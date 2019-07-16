<?php
// +----------------------------------------------------------------------
// | 代码生成器 php  生成的摸版文件这个摸版文件可以进行修改 如果此文件存在自动生成器将
// | 不会生成该文件。
// +----------------------------------------------------------------------
// | 最新更新时间: 2019-07-16 18:18:06
// +-----------------------------------------------------------------------
// | Author: tanshenxiao
// +-----------------------------------------------------------------------

namespace app\admin\validate\backend_validate;

use think\Validate;

/**
* [Final] 基类不可以修改
*/
class BaseValidateTests extends Validate{
    //定义验证规则
    protected $rule = [
        
           'test_name|表1' => 'require',
        
           'test_created_time|表1' => 'require',
        
           'test2_name|表2' => 'require',
        
           'test3_name|表3' => 'require',
        
    ];

    //定义场景消息
    protected $message  =   [
         
    ];

    //验证场景
    protected $scene = [
        
    ];
}