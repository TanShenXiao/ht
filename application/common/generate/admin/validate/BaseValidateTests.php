<?php
// +----------------------------------------------------------------------
// | 代码生成器 php  生成的摸版文件这个摸版文件可以进行修改 如果此文件存在自动生成器将
// | 不会生成该文件。
// +----------------------------------------------------------------------
// | 最新更新时间: 2019-07-08 18:29:16
// +-----------------------------------------------------------------------
// | Author: tanshenxiao
// +-----------------------------------------------------------------------

namespace app\common\generate\admin\validate;

use think\Validate;

class BaseValidateTests extends Validate{
    //定义验证规则
    protected $rule = [
        
           'test_id|id' => 'require',
        
           'test_name|用户姓名1' => 'require',
        
           'test2_name|用户姓名2' => 'require',
        
    ];

    //定义场景消息
    protected $message  =   [
         
    ];

    //验证场景
    protected $scene = [
        
    ];
}