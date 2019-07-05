<?php
// +----------------------------------------------------------------------
// | 海豚PHP框架 [ DolphinPHP ]
// +----------------------------------------------------------------------
// | 版权所有 2016~2019 广东卓锐软件有限公司 [ http://www.zrthink.com ]
// +----------------------------------------------------------------------
// | 官方网站: http://dolphinphp.com
// +----------------------------------------------------------------------

namespace app\admin\controller;
use app\common\builder\ZBuilder;
use think\App;
use think\Controller;
use app\common\model\Generate;
use think\Db;

/**
 * 后台公共控制器
 * @package app\admin\controller
 */
class Test extends Controller
{

    public function __construct(App $app = null)
    {
        parent::__construct($app);
    }

    public function index()
   {
       $Generate = new Generate();
       t($Generate->create());

       //t($this->fetch());
       $data = ['a' => 'face_api'];
       echo $this->$data['a']();
   }
   public function face_api()
   {
       echo 'aaaa';
   }
}
