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
{volist name='use' id='item'}
use {$item};
{/volist}

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
        {$index_content}

    }

     /**
     * 通用的add方法
     * @access public
     */
    public function add()
    {
        {$add_content}

    }

     /**
     * 通用的edit方法
     * @access public
     */
    public function edit()
    {
        {$edit_content}

    }

     /**
     * 通用的delete方法
     * @access public
     */
    public function delete()
    {
        {$delete_content}

    }
}
