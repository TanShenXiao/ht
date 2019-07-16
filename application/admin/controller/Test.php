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
use app\common\controller\Common;
use app\common\model\Api;
use app\common\model\Backend;
use think\App;
use think\Controller;
use think\Db;

/**
 * 后台公共控制器
 * @package app\admin\controller
 */
class Test extends Common
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
           ]/*,
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
               'form_data' => ['type' => 'Select','tips' => '时间','options' => 'test2->name->id'],
               'is_validate' => 1,
               'validate_data' => ['require'],
           ]*/
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
                   'form_data' => ['type' => 'text','tips' => '提示信息'],
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
       $Generate = new Backend($data);
       t($Generate->create());

       //t($this->fetch());
       $data = ['a' => 'face_api'];
       echo $this->$data['a']();
   }


    public function test2()
    {
        $config = [
            'module'     => 'test',
            'class_name' => 'Tests',
            'name'       => 'index',
            'temp_type'  => 'select',
            'comment'    => '好东西
            zknbzkl
            nzblkcxz
            nzlbkxc',
            'table' => ['test' => 'test','test2' => ['test2',['test.id = test2.pid','inner']],'test3' => ['test3',['test.id = test3.tid','inner']]],
            'field' =>[
                [
                    'field' => 'name',
                    'table' => 'test',
                    'alias' => 'test',
                    'name' => '表1',
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
                    'is_list' => 1,
                    'list_data' => ['text',''],
                    'is_add' => 1,
                    'is_edit' => 1,
                    'form_data' => ['type' => 'Select','tips' => '时间','options' => 'test2->name->id'],
                    'is_validate' => 1,
                    'validate_data' => ['require'],
                ]
                ,[
                    'field' => 'name',
                    'table' => 'test2',
                    'alias' => 'test2',
                    'name' => '表2',
                    'list_data' => ['text',''],
                    'form_data' => ['type' => 'text','tips' => '提示信息'],
                    'is_validate' => 1,
                    'validate_data' => ['require'],
                ],[
                    'field' => 'city',
                    'table' => 'test2',
                    'alias' => 'test2',
                    'name' => '表2地区',
                    'is_list' => 1,
                    'list_data' => ['text',''],
                    'form_data' => ['type' => 'Linkages','tips' => '提示信息','table' => 'origin','level' => 3],
                    'is_validate' => 1,
                    'validate_data' => ['require'],
                ],
                [
                    'field' => 'name',
                    'table' => 'test3',
                    'alias' => 'test3',
                    'name' => '表3',
                    'is_list' => 1,
                    'list_data' => ['text',''],
                    'form_data' => ['type' => 'text','tips' => '提示信息',],
                    'is_validate' => 1,
                    'validate_data' => ['require'],
                ]
            ],
        ];

        $data['config'] = $config;
        $Generate = new Api($data);
        t($Generate->create());


    }

}   
        