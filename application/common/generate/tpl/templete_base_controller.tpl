// +----------------------------------------------------------------------
// | 代码生成器 php 基础摸版文件 注意该文件不可以修改他随时都在发生变化
// +----------------------------------------------------------------------
// | 最新更新时间: {$change_date}
// +-----------------------------------------------------------------------
// | Author: tanshenxiao
// +-----------------------------------------------------------------------

namespace {$namespace};

use think\Db;
use app\common\builder\ZBuilder;
use think\App;
{foreach $use as $item }
use {$item};
{/foreach}

/**
* [Final] 基类不可以修改
*/
class {$class_name} extends {$extends_class}

{

    {foreach $public_variable as $key => $item }

     //{$item['describe']}

     protected ${php}echo $key;{/php};
    {/foreach}

     /**
     * 构造方法
     * @access public
     */
    public function __construct(App $app = null)
    {
         parent::__construct($app);

        {foreach $public_variable as $key => $item }

        $this->{php}echo $key.' = '.$item['data'];{/php};
        {/foreach}

    }

     /**
     * 通用的index方法
     * @access public
     */
    public function index()
    {
        //获取筛选
        $map = $this->getMap();
        $order = $this->getOrder();

        $data_list = {php}echo $index_content['data_list']."\r\n\t\t\t->where(\$map)->order(\$order)->paginate()";{/php};

        //分页数据
        $page = $data_list->render();

        $table = ZBuilder::make('table')->setPageTitle('{$index_content['title']}')
            //搜索字段
            ->setSearchArea([
            {foreach $index_content['search'] as $item }

                {php}echo $item;{/php}
            {/foreach}

            ])
            //搜索字段结束

            //显示字段
            {foreach $index_content['column'] as $key => $item }

            {php}echo $item;{/php}
            {/foreach}

            //显示字段结束

            ->setRowList($data_list)
            ->setPages($page);

        return $table->fetch();
    }

     /**
     * 通用的add方法
     * @access public
     */
    public function add()
    {
        $from = ZBuilder::make('form')->setPageTitle('{$add_content['title']}')

            //显示字段
            {foreach $add_content['column'] as $key => $item }
            {php}
               if($add_content['column_num'] <= $key){

                echo $item.";\r\n";

                }else{

                echo $item."\r\n";

                }
            {/php}
            {/foreach}

        if($this->request->isPost()){
            $change_data = input();
            $validate = new {$add_content['validate_class']}();
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

            //更新字段之间的关系
            {foreach $add_content['relationship'] as $key => $item }

            if(isset({$item['variable'][0]}) and isset({$item['variable'][1]}) and !{php}echo $item['Db'];{/php}){
                $this->error("数据关系更新失败");
            }
            {/foreach}

            //字段关系结束


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
        $data = {php}echo $edit_content['data_list']."\r\n\t\t\t->where(['".$master_table[0].".id' => \$id])->find()";{/php};

        if(!$data){
            $this->error('数据不存在，请重新打开此页面');
        }

        $from = ZBuilder::make('form')->setPageTitle('{$add_content['title']}')
            //显示字段
            {foreach $edit_content['column'] as $key => $item }
                {php}
                    if($edit_content['column_num'] <= $key){

                    echo $item.";\r\n";

                    }else{

                    echo $item."\r\n";

                    }
                {/php}
            {/foreach}

        $from->setFormData($data);

        if($this->request->isPost()){
            $change_data = input();
            $validate = new {$edit_content['validate_class']}();
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
