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
use app\admin\model\Attachment as AttachmentModel;
use think\Image;
use think\File;
use think\App;
{foreach $use as $item }
use {$item};
{/foreach}


class {$class_name} extends {$extends_class}

{

     /**
     * 构造方法
     * @access public
     */
    public function __construct(App $app = null)
    {
         parent::__construct($app);

        //共用变量
        {foreach $public_variable as $key => $item }

        $this->{php}echo $key.' = '.$item;{/php}

        {/foreach}

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

        $data_list = {php}echo $index_content['data_list'];{/php}->where($map)->order($order)->paginate();
        // 分页数据
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
        {foreach $index_content['column'] as $item }

            {php}echo $item;{/php}
        {/foreach}

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
        $from = ZBuilder::make('form')->setPageTitle('{$add_content['title']}');



        if($this->request->isPost()){

        }

        return $from->fetch();
    }

     /**
     * 通用的edit方法
     * @access public
     */
    public function edit($id = '')
    {
        $data = {php}echo $add_content['data_list'];{/php}->where(['{$master_table[1]}.id' => $id])->find();

    }

     /**
     * 通用的delete方法
     * @access public
     */
    public function delete($record = [])
    {


    }
}
