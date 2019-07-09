<?php
// +----------------------------------------------------------------------
// | 代码生成器 php 基础摸版文件 注意该文件不可以修改他随时都在发生变化
// +----------------------------------------------------------------------
// | 最新更新时间: 2019-07-09 20:20:20// +-----------------------------------------------------------------------
// | Author: tanshenxiao
// +-----------------------------------------------------------------------

namespace app\common\generate\admin\controller;

use think\Db;
use app\common\builder\ZBuilder;
use app\admin\model\Attachment as AttachmentModel;
use think\Image;
use think\File;
use think\App;
use app\admin\controller\Admin;
use app\admin\validate\admin\ValidateTests;


class BaseTests extends Admin
{

     /**
     * 构造方法
     * @access public
     */
    public function __construct(App $app = null)
    {
         parent::__construct($app);

        //共用变量

        $this->tables = ['test' => ['table' => 'test','pk' => 'id'],'test2' => ['table' => 'test2','pk' => 'id'],'test3' => ['table' => 'test3','pk' => 'id']]; //数据表信息

        $this->test_name = Db::name('test2')->column('name','id');

        $this->test_created_time = Db::name('test2')->column('name','id');

        //共用变量结束

    }

     /**
     * 通用的index方法
     * @access public
     */
    public function index()
    {
        // 获取筛选
        $map = $this->getMap();
        $order = $this->getOrder();

        $data_list = Db::name('test test')->join('test2 test2','test.id = test2.pid','inner')->join('test3 test3','test.id = test3.tid','inner')->field('test.id as id,test.name as test_name,test.created_time as test_created_time,test2.name as test2_name,test3.name as test3_name')->where($map)->order($order)->paginate();
        // 分页数据
        $page = $data_list->render();

        $table = ZBuilder::make('table')->setPageTitle('测试中_查看')
        //搜索字段
        ->setSearchArea([

            ['select','test.name','表1','','',$this->test_name],
            ['select','test.created_time','表1','','',$this->test_created_time],
            ['text','test2.name','表2','like','',''],
            ['text','test3.name','表3','like','',''],
        ])

        //搜索字段结束

        //显示字段

            ->addColumn('test_name','表1','text','')
            ->addColumn('test_created_time','表1','text','')
            ->addColumn('test2_name','表2','text','')
            ->addColumn('test3_name','表3','text','')
            ->addColumn('right_button', '操作', 'btn')
            ->addTopButton('add')       //顶部添加按钮
            ->addTopButton('delete')    //顶部删除按钮
            ->addRightButton('edit')     //右边编辑按钮
            ->addRightButton('delete')   //右边删除按钮
        //显示字段结束

        ->setRowList($data_list) // 设置表格数据
        ->setPages($page); // 设置分页数据

        return $table->fetch();
    }

     /**
     * 通用的add方法
     * @access public
     */
    public function add()
    {
        $from = ZBuilder::make('form')->setPageTitle('测试中_添加')

        //显示字段
        ->addText('test_name','表1','提示信息','','','','')
        ->addDatetime('test_created_time','表1','时间','','','')
        ->addText('test2_name','表2','提示信息','','','','')
        ->addText('test3_name','表3','提示信息','','','','');

        if($this->request->isPost()){
            $change_data = input();
            $validate = new ValidateTests();
            if(!$validate->check($change_data)){
                $this->error($validate->getError());
            }

            //数据分解
            $insert_data = [];
            foreach ($change_data as $key => $item){
                $arr = explode('_',$key,2);
                if(!isset($arr[1])) continue;
                if(key_exists($arr[0],$this->tables)){
                    $table = $this->tables[$arr[0]];
                    $insert_data[$table['table']]['data'][$arr[1]] = $item;
                    $insert_data[$table['table']]['alias']= $arr[0];
                }
            }
            //开启事务插入数据
            Db::startTrans();
            foreach ($insert_data as $key => $item){
                if(empty($item['data'])) continue;
                if(!Db::name($key)->insert($item['data'])){
                    $this->error("表".$key."添加数失败。");
                }

                $last_id_name = $item['alias'].'_last_id';  //存储插入id
                $$last_id_name = Db::getLastInsID();
            }

            //循环更新字段之间的关系

            if(!Db::name('test2')->where(['id' => $test2_last_id])->update(['pid' => $test_last_id])){
                $this->error("数据关系更新失败");
            }

            if(!Db::name('test3')->where(['id' => $test3_last_id])->update(['tid' => $test_last_id])){
                $this->error("数据关系更新失败");
            }

            //更新字段关系结束


            Db::commit();

            $this->success('成功');
        }

        return $from->fetch();
    }

     /**
     * 通用的edit方法
     * @access public
     */
    public function edit($id = '')
    {
        $data = Db::name('test test')->join('test2 test2','test.id = test2.pid','inner')->join('test3 test3','test.id = test3.tid','inner')->field('test.id as id,test.id as test_id,test2.id as test2_id,test3.id as test3_id,test.name as test_name,test.created_time as test_created_time,test2.name as test2_name,test3.name as test3_name')->where(['test.id' => $id])->find();

        $from = ZBuilder::make('form')->setPageTitle('测试中_添加')
        //显示字段
        ->addHidden('test_id','')
        ->addHidden('test2_id','')
        ->addHidden('test3_id','')
        ->addText('test_name','表1','提示信息','','','','')
        ->addDatetime('test_created_time','表1','时间','','','')
        ->addText('test2_name','表2','提示信息','','','','')
        ->addText('test3_name','表3','提示信息','','','','');

        $from->setFormData($data);

        if($this->request->isPost()){
            $change_data = input();
            $validate = new ValidateTests();
            if(!$validate->check($change_data)){
                $this->error($validate->getError());
            }

            //数据分解
            $update_data = [];
            foreach ($change_data as $key => $item){
                $arr = explode('_',$key,2);
                if(!isset($arr[1])) continue;
                if(key_exists($arr[0],$this->tables)){

                    $table = $this->tables[$arr[0]];
                    if($table['pk'] == $arr[1]){
                        $update_data[$table['table']]['where'] = [$table['pk'] => $item];
                    }else{
                        $update_data[$table['table']]['data'][$arr[1]] = $item;
                    }
                    $update_data[$table['table']]['alias']= $arr[0] ;

                }
            }
            //开启事务插入数据
            Db::startTrans();
            foreach ($update_data as $key => $item){
                if(empty($item) or empty($item['where'])) continue;

                if(!Db::name($key)->where($item['where'])->update($item['data'])){ //有的表可能没有更改会导致失败这个先注释掉
                    //$this->error("表".$key."修改数据失败。");
                }
            }
            Db::commit();

            $this->success('成功');
        }

        return $from->fetch();

    }

     /**
     * 通用的delete方法
     * @access public
     */
    public function delete($record = [])
    {
        $ids   = $this->request->isPost() ? input('post.ids/a') : input('param.ids');
        $ids   = (array)$ids;
        if(!$ids) $this->error('失败');

        $table = $this->tables;
        $table = array_shift($table);

        if(Db::name($table['table'])->where([$table['pk'] => $ids])->delete()){
            $this->success('删除成功。');
        }

        $this->error('删除失败。');

    }
}
