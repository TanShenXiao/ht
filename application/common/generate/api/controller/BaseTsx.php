<?php
// +----------------------------------------------------------------------
// | 代码生成器 php 基础摸版文件 注意该文件不可以修改他随时都在发生变化
// +----------------------------------------------------------------------
// | 最新更新时间: 2019-07-05 17:41:40
// +-----------------------------------------------------------------------
// | Author: tanshenxiao
// +-----------------------------------------------------------------------

namespace app\common\generate\api\controller;

use think\Db;
use app\common\builder\ZBuilder;
use app\admin\model\Attachment as AttachmentModel;
use think\Image;
use think\File;
use think\App;
use think\Controller;

class BaseTsx extends Controller
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
        echo 'name';
    }

     /**
     * 通用的add方法
     * @access public
     */
    public function add()
    {
        echo 'name';
    }

     /**
     * 通用的edit方法
     * @access public
     */
    public function edit()
    {
        echo 'name';
    }

     /**
     * 通用的delete方法
     * @access public
     */
    public function delete()
    {
        echo 'name';
    }
}
