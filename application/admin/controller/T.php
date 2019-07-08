<?php
// +----------------------------------------------------------------------
// | 海豚PHP框架 [ DolphinPHP ]
// +----------------------------------------------------------------------
// | 版权所有 2016~2019 广东卓锐软件有限公司 [ http://www.zrthink.com ]
// +----------------------------------------------------------------------
// | 官方网站: http://dolphinphp.com
// +----------------------------------------------------------------------

namespace app\admin\controller;

use think\facade\Cache;
use think\facade\Env;
use think\helper\Hash;
use think\Db;
use app\common\builder\ZBuilder;
use app\user\model\User as UserModel;

/**
 * 后台默认控制器
 * @package app\admin\controller
 */
class T extends Admin
{
   public function index()
   {

      $array = [1,2];
      $array1 = [3,4];
      $data = array_merge($array,$array1);
      t($data);
   }
}