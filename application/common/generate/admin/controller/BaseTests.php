<?php
// +----------------------------------------------------------------------
// | 代码生成器 php 基础摸版文件 注意该文件不可以修改他随时都在发生变化
// +----------------------------------------------------------------------
// | 最新更新时间: 2019-07-08 18:29:16// +-----------------------------------------------------------------------
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
        
        $this->test_name = Db::name('test2')->column('name','id');
        
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

        $data_list = Db::name('test test')->join('test2 test2','test.id = test2.pid','inner')->field('test.id as id,test.id as test_id,test.name as test_name,test2.name as test2_name')->where($map)->order($order)->paginate();
        // 分页数据
        $page = $data_list->render();

        $table = ZBuilder::make('table')
        //搜索字段
        ->setSearchArea([
        
            ['text','test.id','id','like','',''],        
            ['select','test.name','用户姓名1','','',$this->test_name],        
            ['text','test2.name','用户姓名2','like','',''],        
        ])

        //搜索字段结束

        //显示字段
        
            ->addColumn('test_id','id','text','')        
            ->addColumn('test_name','用户姓名1','text','')        
            ->addColumn('test2_name','用户姓名2','text','')        
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


    }

     /**
     * 通用的edit方法
     * @access public
     */
    public function edit($id = '')
    {


    }

     /**
     * 通用的delete方法
     * @access public
     */
    public function delete($record = [])
    {


    }
}
