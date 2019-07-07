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

    }

     /**
     * 通用的index方法
     * @access public
     */
    public function index()
    {
        $data_list = {$index_content['data_list']}->where($this->map)->order($order)->paginate();
        // 分页数据
        $page = $data_list->render();

        $table = ZBuilder::make('table');
            {foreach $index_content as $item }
               {$item};
            {/foreach}

            ->setRowList($data_list) // 设置表格数据
            ->setPages($page) // 设置分页数据
        $table->fetch();

        return $table;
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
    public function edit()
    {


    }

     /**
     * 通用的delete方法
     * @access public
     */
    public function delete()
    {


    }
}
