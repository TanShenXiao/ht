<?php
// +----------------------------------------------------------------------
// | 代码生成器
// +----------------------------------------------------------------------
// | Copyright (c) 2019
// +----------------------------------------------------------------------
// | Licensed
// +----------------------------------------------------------------------
// | Author: tanshenxiao
// +-----------------------------------------------------------------------------------------------------------------------------------------

namespace app\common\model;

use think\View;

/**
 * Class Generate
 * @package app\common\model
 */
class Generate
{
    /**
     * 基础控制器摸版的路径
     * @var string
     */
    protected $templete_base_controller_file = ROOT_PATH.'/application/common/generate/tpl/templete_base_controller.tpl';

    /**
     * 控制器摸版
     * @var string
     */
    protected $template_controller_file =  ROOT_PATH.'/application/common/generate/tpl/template_controller.tpl';

    /**
     * 基礎验证器配置路径
     * @var string
     */
    protected $template_base_validate_file =  ROOT_PATH.'/application/common/generate/tpl/template_base_validate.tpl';

    /**
     * 验证器配置路径
     * @var string
     */
    protected $template_validate_file =  ROOT_PATH.'/application/common/generate/tpl/template_validate.tpl';

    /**
     * 基础控制器后台存放路径
     * @var
     */
    protected $base_controller_path_admin = ROOT_PATH.'/application/common/generate/admin/controller';

    /**
     * 基础控制器api存放路径
     * @var
     */
    protected $base_controller_path_api = ROOT_PATH.'/application/common/generate/api/controller';

    /**
     * 基础校验器admin存放路径
     * @var mixed|string
     */
    protected $base_validate_path_admin = ROOT_PATH.'/application/common/generate/admin/validate';

    /**
     *  基础校验器api存放路径
     * @var mixed|string
     */
    protected $base_validate_path_api = ROOT_PATH.'/application/common/generate/api/validate';

    /**
     * 控制器 后台 存放路径
     * @var
     */
    protected $controller_path_admin = ROOT_PATH.'/application/admin/controller';

    /**
     * 控制器 api  存放路径
     * @var
     */
    protected $controller_path_api = ROOT_PATH.'/application/admin/api';

    /**
     * 校验器 后台 存放路径
     * @var
     */
    protected $validate_path_admin =  ROOT_PATH.'/application/admin/validate/admin';

    /**
     * 校验器 api 存放路径
     * @var
     */
    protected $validate_path_api =  ROOT_PATH.'/application/admin/validate/api';

    /**
     * 生成器通用配置
     * @var array
     */
    protected $config = [];

    /**
     * 错误提示
     * @var string
     */
    public $error_msg = '';

    /**
     * 视图类
     * @var View
     */
    protected $View;

    /**
     * 当前时间
     * Generate constructor.
     * @param array $data
     */
    protected $date = '';



    public function __construct($data = [])
    {
        //数据填充
        if($this->is_existence($data,'templete_base_controller_file'))  $this->templete_base_controller_file = $data['templete_base_controller_file'];    //基础控制器摸版的路径
        if($this->is_existence($data,'template_controller_file'))       $this->template_controller_file      = $data['template_controller_file'];         //控制器摸版
        if($this->is_existence($data,'template_base_validate_file'))    $this->template_base_validate_file   = $data['template_base_validate_file'];      //基礎验证器配置路径
        if($this->is_existence($data,'template_validate_file'))         $this->template_validate_file        = $data['template_validate_file'];           //验证器配置路径
        if($this->is_existence($data,'base_controller_path_admin'))     $this->base_controller_path_admin    = $data['base_controller_path_admin'];       //基础控制器后台存放路径
        if($this->is_existence($data,'base_controller_path_api'))       $this->base_controller_path_api      = $data['base_controller_path_api'];         //基础控制器api存放路径
        if($this->is_existence($data,'controller_path_admin'))          $this->controller_path_admin         = $data['controller_path_admin'];            //控制器 后台 存放路径
        if($this->is_existence($data,'controller_path_api'))            $this->controller_path_api           = $data['controller_path_api'];              //控制器 api 存放路径
        if($this->is_existence($data,'validate_path_admin'))            $this->validate_path_admin           = $data['validate_path_admin'];              //校验器 后台 存放路径
        if($this->is_existence($data,'validate_path_api'))              $this->validate_path_api             = $data['validate_path_api'];                //校验器 api 存放路径
        if($this->is_existence($data,'config'))                         $this->config = $data['config'];

        $this->View = (new View())->engine();

        $this->date = date('Y-m-d H:i:s');

        //数据校验
        $this->validate();
    }

    /**
     * 校验器
     */
    public function validate()
    {
        if(!is_file($this->templete_base_controller_file)){
            $this->error_msg = '找不到基础摸版控制文件';return;
        }
        if(!is_file($this->template_controller_file)){
            $this->error_msg = '找不到控制器摸版文件';return;
        }
        if(!is_file($this->template_base_validate_file)){
            $this->error_msg = '找不到基础校验器摸控制文件';return;
        }
        if(!is_file($this->template_validate_file)){
            $this->error_msg = '找不到校验器摸控制文件';return;
        }
        if(!is_dir($this->base_controller_path_admin)){
            $this->error_msg = '找不到存放基础后台类的目录';return;
        }
        if(!is_dir($this->base_controller_path_api)){
            $this->error_msg = '找不到存放基础api类的目录';return;
        }
        if(!is_dir($this->base_validate_path_admin)){
            $this->error_msg = '找不到存放基础后台校验器的目录';return;
        }
        if(!is_dir($this->base_validate_path_api)){
            $this->error_msg = '找不到存放基础api消焰器校验器类的目录';return;
        }
        if(!is_dir($this->controller_path_admin)){
            $this->error_msg = '找不到存放后台类的目录';return;
        }
        if(!is_dir($this->controller_path_api)){
            $this->error_msg = '找不到存放api类的目录';return;
        }
        if(!is_dir($this->validate_path_admin)){
            $this->error_msg = '找不到存放后台校验器的目录';return;
        }
        if(!is_dir($this->validate_path_api)){
            $this->error_msg = '找不到存api校验器类目';return;
        }
    }

    public function create()
    {
        //检测是否通过数据校验
        if($this->error_msg) return $this->error_msg;
        //定义模拟config文件
        $config = [
            'class_name' => 'Test',
            'table' => ['test' => ['test'],'test2' => ['test2',['test.id = test2','inner']]],
            'filed' =>[
                [
                    'filed' => 'id',
                    'alias' => 'test',
                    'name' => 'id',
                    'is_search' => 1,
                    'search_data' => ['text','','',[]],
                    'is_list' => 1,
                    'list_data' => ['text',''],
                    'is_from' => 1,
                    'form_data' => ['','','','','','',''],
                    'is_validate' => 1,
                    'validate_data' => ['require'],
                ],
            ],
        ];
         $this->build_admin($config);  //生成后台
         $this->build_api([]);

        echo 'ok';
    }

    protected function build_admin($config)
    {
        //生成基础验证器
        $base_validate = $this->diy_validate($config);
        $this->created_file($this->template_base_validate_file,$this->base_validate_path_admin,$base_validate);

        //生成验证器
        $validate = [
            'use' => [
                $base_validate['namespace'].'\\'.$base_validate['class_name'],
            ],
            'class_name' => 'ValidateTsx',
            'extends_class' => $base_validate['class_name'],
            'change_date' => $this->date,
        ];
        $this->created_file($this->template_validate_file,$this->validate_path_admin,$validate);

        //生成基础后台控制器
        $base_admin = [
            'use' => [
                'think\Controller'
            ],
            'class_name' => 'BaseTsx',
            'extends_class' => 'Controller',
            'index_content' => "echo 'name';",
            'add_content' => "echo 'name';",
            'edit_content' => "echo 'name';",
            'delete_content' => "echo 'name';",
            'change_date' => $this->date,
        ];
        $this->diy_controller($config);
        $base_admin['namespace'] = $this->created_namespace($this->base_controller_path_admin);
        $this->created_file($this->templete_base_controller_file,$this->base_controller_path_admin,$base_admin);

        //生成前台控制器
        $admin = [
            'use' => [
                 $base_admin['namespace'].'\\'.$base_admin['class_name'],
            ],
            'class_name' => 'Tsx',
            'extends_class' => $base_admin['class_name'],
            'change_date' => $this->date,

        ];
        $this->created_file($this->template_controller_file,$this->controller_path_admin,$admin);
    }

    protected function build_api($config)
    {
        //生成基础后台控制器
        $base_admin = [
            'use' => [
                'think\Controller'
            ],
            'class_name' => 'BaseTsx',
            'extends_class' => 'Controller',
            'index_content' => "echo 'name';",
            'add_content' => "echo 'name';",
            'edit_content' => "echo 'name';",
            'delete_content' => "echo 'name';",
            'change_date' => $this->date,
        ];
        $this->created_file($this->templete_base_controller_file,$this->base_controller_path_api,$base_admin);

        //生成前台控制器
        $admin = [
            'use' => [
                $base_admin['namespace'].'\\'.$base_admin['class_name'],
            ],
            'class_name' => 'Tsx',
            'extends_class' => $base_admin['class_name'],
            'change_date' => $this->date,

        ];
        $this->created_file($this->template_controller_file,$this->controller_path_api,$admin);
    }

    /**
     * 验证数据组装
     * @param $config
     * @return array
     */
    protected function diy_validate($config)
    {
        $base_name = 'BaseValidate';
        $base_validate = [      //基础数据
            'use' => [
                'think\Validate'
            ],
            'extends_class' => 'Validate',
            'rule' => [],
            'message' => [],
            'scene' => [],
            'change_date' => $this->date,
        ];
        $base_validate['class_name'] = $base_name.$config['class_name'];
        foreach ($config['filed'] as $item){
            if(!$item['is_validate']) continue;
            if(!$item['validate_data']){
                $item['validate_data'] = 'require';
            }
            $filed = $this->decompose($item['filed']);
            $base_validate['rule'][$filed.'|'.$item['name']] = implode('|',$item['validate_data']);
        }

        return $base_validate;
    }

    /**
     * 验证数据组装
     * @param $config
     * @return array
     */
    protected function diy_controller($config)
    {
        $base_name = 'Base';
        $base_validate = [      //基础数据
            'use' => [
                'think\Validate'
            ],
            'extends_class' => 'Validate',
            'rule' => [],
            'message' => [],
            'scene' => [],
            'change_date' => $this->date,
        ];
        //生成基础后台控制器
        $base_admin = [
            'use' => [
                'think\Controller'
            ],
            'extends_class' => 'Admin',
            'index_content' => [
                'data_list' => '',
            ],
            'add_content' => [],
            'edit_content' => [],
            'delete_content' => [],
            'change_date' => $this->date,
        ];
        $base_admin['class_name'] = $base_name.$config['class_name'];
        //查询头封装
        $base_admin['index_content']['data_list'] = $this->analysis_table($config['table']);
        $filed = $this->analysis_field($config['filed'],'is_list');
        $base_admin['index_content']['data_list'] .= "->filed('{$filed}')";
        //构造器封装

        foreach ($config['filed'] as $item){
            if(!$item['is_list']) continue;

            $filed = $this->decompose($item['filed']);
            $base_validate['rule'][$filed.'|'.$item['name']] = implode('|',$item['validate_data']);
        }

        return $base_validate;
    }

    /**
     * table头部封装
     * @param $table
     * @return string
     */
    public function analysis_table($table)
    {
        $str = "Db::name('";
        $i = 0;
        foreach($table as $key => $value){
            $i++;
            if($i == 1){
                if(empty($value)){
                    $value = $key;
                }
                if(is_array($value)){
                    $value = $value[0];
                }
                $str .= $key." {$value}')";
                continue;
            }

            $str .="->join({$key} {$value[0]},'{$value[1][0]}','{$value[1][1]}')";
        }

        return $str;
    }

    /**
     * 字段封装
     * @param $table
     * @return string
     */
    public function analysis_field($filed,$is_show)
    {
        $str = "";
        foreach($filed as $key => $value){
            if(!isset($value[$is_show]) or !$value[$is_show]){
                continue;
            }
            $str = "{$value['alias']}.{$value['filed']} as {$value['alias']}_{$value['filed']},";
        }

        $str = trim($str,',');

        return $str;
    }

    /**
     * 字段封装
     * @param $table
     * @return string
     */
    public function analysis_column($filed,$is_show = 'is_list')
    {
        $column = [];
        foreach($filed as $key => $value){
            if(!isset($value[$is_show]) or !$value[$is_show]){
                continue;
            }
            switch($value['']):
            //$column = ["{$value['alias']}_{$value['filed']}",$value['name']];


            endswitch;
        }



        return $column;
    }

    /**
     * 获取路径对应的命名空间
     * @param $path
     * @return mixed|string
     */
    public function created_namespace($path)
    {
        $namespace = str_replace(ROOT_PATH,'',$path);
        $namespace = str_replace('application','app',$namespace);
        $namespace = trim(str_replace('/','\\',$namespace),'\\');

        return $namespace;
    }

    /**
     * 根据路经生成php位置
     * @param $path
     * @param $class_name
     * @param string $prefix
     * @return string
     */
    public function get_created_path($path,$class_name,$prefix = '')
    {
       return preg_replace('/(\/|\\\)$/i','',$path).'/'.$prefix.$class_name.'.php';
    }

    /**
     * 生成目标文件
     * @param $file
     * @param $target
     * @param array $var
     * @return bool|int
     * @throws \Exception
     */
    protected function created_file($file,$target,&$var = [])
    {
        if(!isset($var['namespace'])){
            $var['namespace'] = $this->created_namespace($target);
        }
        $content = $this->View->fetch($file,$var);
        $content = "<?php\n".$content;
        return file_put_contents($this->get_created_path($target,$var['class_name']),$content);
    }

    /**
     * 分解数组取
     * @param $filed
     * @return array
     */
    public function decompose($filed)
    {
        $array = explode('.',$filed);
        return array_pop($array);
    }

    /**
     * 数据简单校验
     * @param $data
     * @param string $filed
     * @return bool
     */
    public function is_existence($data,$filed = '')
    {
        return isset($data[$filed]) and $data[$filed];
    }

}
