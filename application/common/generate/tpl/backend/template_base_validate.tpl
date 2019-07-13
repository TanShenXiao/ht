// +----------------------------------------------------------------------
// | 代码生成器 php  生成的摸版文件这个摸版文件可以进行修改 如果此文件存在自动生成器将
// | 不会生成该文件。
// +----------------------------------------------------------------------
// | 最新更新时间: {$change_date}

// +-----------------------------------------------------------------------
// | Author: tanshenxiao
// +-----------------------------------------------------------------------

namespace {$namespace};

{foreach $use as $item }
use {$item};
{/foreach}

/**
* [Final] 基类不可以修改
*/
class {$class_name} extends {$extends_class}
{
    //定义验证规则
    protected $rule = [
        {foreach $rule as $key => $item }

           '{$key}' => '{$item}',
        {/foreach}

    ];

    //定义场景消息
    protected $message  =   [
         {foreach $message as $key => $item }

            '{$key}' => '{$item}',
         {/foreach}

    ];

    //验证场景
    protected $scene = [
        {foreach $scene as $key => $item }

            '{$key}' => '{$item}',
        {/foreach}

    ];
}