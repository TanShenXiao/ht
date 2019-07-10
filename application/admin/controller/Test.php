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
           'table' => ['test' => 'test','test2' => ['test2',['test.id = test2.pid','inner']],'test3' => ['test3',['test.id = test3.tid','inner']]],
           'is_add' => 1,   //是否添加 添加按钮
           'is_edit' => 1,  //是否添加 编辑按钮
           'is_delete' => 1,//是否添加 删除按钮
           'field' =>[
               [
                   'field' => 'name',
                   'table' => 'test',
                   'alias' => 'test',
                   'name' => '表1',
                   'is_search' => 0,
                   'search_data' => ['select','','','test2->name->id'],
                   'is_list' => 1,
                   'list_data' => ['text',''],
                   'is_add' => 1,
                   'is_edit' => 1,
                   'form_data' => ['type' => 'text','tips' => '提示信息',],
                   'is_validate' => 1,
                   'validate_data' => ['require'],
               ]
               ,
               [
               'field' => 'created_time',
               'table' => 'test',
               'alias' => 'test',
               'name' => '表1',
               'is_search' => 1,
               'search_data' => ['daterange','','',''],
               'is_list' => 1,
               'list_data' => ['text',''],
               'is_add' => 1,
               'is_edit' => 1,
               'form_data' => ['type' => 'Datetime','tips' => '时间',],
               'is_validate' => 1,
               'validate_data' => ['require'],
           ],
               [
               'field' => 'status',
               'table' => 'test',
               'alias' => 'test',
               'name' => '表1',
               'is_search' => 0,
               'search_data' => ['daterange','','',''],
               'is_list' => 1,
               'list_data' => ['text',''],
               'is_add' => 1,
               'is_edit' => 1,
               'form_data' => ['type' => 'Select','tips' => '时间','options' => ['1' => 2,'3' => '4','5' => 'kkkkk']],
               'is_validate' => 1,
               'validate_data' => ['require'],
           ]
               ,[
                   'field' => 'name',
                   'table' => 'test2',
                   'alias' => 'test2',
                   'name' => '表2',
                   'is_search' => 0,
                   'search_data' => ['text','like','',[]],
                   'is_list' => 1,
                   'list_data' => ['text',''],
                   'is_add' => 1,
                   'is_edit' => 1,
                   'form_data' => ['type' => 'text','tips' => '提示信息',],
                   'is_validate' => 1,
                   'validate_data' => ['require'],
               ],
               [
                   'field' => 'name',
                   'table' => 'test3',
                   'alias' => 'test3',
                   'name' => '表3',
                   'is_search' => 1,
                   'search_data' => ['text','like','',[]],
                   'is_list' => 1,
                   'list_data' => ['text',''],
                   'is_add' => 1,
                   'is_edit' => 1,
                   'form_data' => ['type' => 'text','tips' => '提示信息',],
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
   public function test3($app_path = APP_PATH)
   {
        $dir = scandir($app_path);
        $dirs = [];
        foreach ($dir as $name){
            $value = $app_path.'/'.$name;
            if($name == '.' or $name == '..' or (is_file($value) and pathinfo($value)['extension'] != 'php')) continue;
            if(is_dir($value)){
                $dirs = array_merge($dirs,$this->test3($value));
            }else{
                $dirs[] = $value;
            }
        }

        return $dirs;
   }

    public function test2()
    {
        t($this->test3());
    }

    /**
     * 获取路径对应的命名空间
     * @param $path
     * @return mixed|string
     */
    public function created_namespace($path)
    {
        $namespace = str_replace(dirname(APP_PATH),'',$path);
        $namespace = str_replace('application','app',$namespace);
        $namespace = trim(str_replace('/','\\',$namespace),'\\');

        return $namespace;
    }
}
