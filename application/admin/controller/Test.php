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

       $config = [
           'module' => 'admin',
           'title' => '测试中',
           'class_name' => 'Tests',
           'table' => ['test' => 'test','test2' => ['test2',['test.id = test2.pid','inner']]],
           'is_add' => 1,   //是否添加 添加按钮
           'is_edit' => 1,  //是否添加 编辑按钮
           'is_delete' => 1,//是否添加 删除按钮
           'field' =>[
               [
                   'field' => 'id',
                   'table' => 'test',
                   'alias' => 'test',
                   'name' => 'id',
                   'is_search' => 1,
                   'search_data' => ['text','like','',[]],  //类型 匹配模式 默认值 附加 参数
                   'is_list' => 1,
                   'list_data' => ['text',''],
                   'is_from' => 1,
                   'form_data' => ['','','','','','',''],
                   'is_validate' => 1,
                   'validate_data' => ['require'],
               ],
               [
                   'field' => 'name',
                   'table' => 'test',
                   'alias' => 'test',
                   'name' => '用户姓名1',
                   'is_search' => 1,
                   'search_data' => ['select','','','test2->name->id'],
                   'is_list' => 1,
                   'list_data' => ['text',''],
                   'is_from' => 1,
                   'form_data' => ['','','','','','',''],
                   'is_validate' => 1,
                   'validate_data' => ['require'],
               ],[
                   'field' => 'name',
                   'table' => 'test2',
                   'alias' => 'test2',
                   'name' => '用户姓名2',
                   'is_search' => 1,
                   'search_data' => ['text','like','',[]],
                   'is_list' => 1,
                   'list_data' => ['text',''],
                   'is_from' => 1,
                   'form_data' => ['','','','','','',''],
                   'is_validate' => 1,
                   'validate_data' => ['require'],
               ]
           ],
       ];

       $data['config'] = $config;

       $Generate = new Generate($data);
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
