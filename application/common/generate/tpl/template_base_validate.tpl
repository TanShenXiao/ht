// +----------------------------------------------------------------------
// | 代码生成器 php 基础消校验器摸版文件 注意该文件不可以修改，他随时都在发生变化
// +----------------------------------------------------------------------
// | 最新更新时间: {$change_date}
// +-----------------------------------------------------------------------
// | Author: tanshenxiao
// +-----------------------------------------------------------------------

namespace {$namespace}

use think\Validate;

class {$class_name} extends Validate
{
    //定义验证规则
    protected $rule = [
        {volist name='rule' id='item'}
           {$i} => {$item}
        {/volist}
    ];

protected $message  =   [
'name.require' => '名称必须',
'name.max'     => '名称最多不能超过25个字符',
'age.number'   => '年龄必须是数字',
'age.between'  => '年龄只能在1-120之间',
'email'        => '邮箱格式错误',
];

    //验证场景
    protected $scene = [
    'edit'  =>  ['name','age'],
    ];


}