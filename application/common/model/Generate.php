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
         $this->build_admin([]);  //生成后台
         $this->build_api([]);

        //$config['']



        //t($data);


        echo 'aa';
    }

    protected function build_admin($config)
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
        $base_admin['namespace'] = $this->created_namespace($this->base_controller_path_admin);

        $content = $this->View->fetch($this->templete_base_controller_file,$base_admin);
        $content = "<?php\n".$content;
        file_put_contents($this->get_created_path($this->base_controller_path_admin,$base_admin['class_name']),$content);
        //生成前台控制器
        $admin = [
            'use' => [
                 $base_admin['namespace'].'\\'.$base_admin['class_name'],
            ],
            'class_name' => 'Tsx',
            'extends_class' => $base_admin['class_name'],
            'change_date' => $this->date,

        ];
        $admin_path = $this->get_created_path($this->controller_path_admin,$admin['class_name']);
        //if(!is_file($admin_path)){   //如果存在就不生成 如果不存在就生成
            $admin['namespace'] = $this->created_namespace($this->controller_path_admin,$base_admin['class_name']);
            $content = $this->View->fetch($this->template_controller_file,$admin);
            $content = "<?php\n".$content;
            file_put_contents($this->get_created_path($this->controller_path_admin,$admin['class_name']),$content);
        //}
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
        $base_admin['namespace'] = $this->created_namespace($this->base_controller_path_api);

        $content = $this->View->fetch($this->templete_base_controller_file,$base_admin);
        $content = "<?php\n".$content;
        file_put_contents($this->get_created_path($this->base_controller_path_api,$base_admin['class_name']),$content);
        //生成前台控制器
        $admin = [
            'use' => [
                $base_admin['namespace'].'\\'.$base_admin['class_name'],
            ],
            'class_name' => 'Tsx',
            'extends_class' => $base_admin['class_name'],
            'change_date' => $this->date,

        ];
        $admin_path = $this->get_created_path($this->controller_path_api,$admin['class_name']);
        //if(!is_file($admin_path)){   //如果存在就不生成 如果不存在就生成
        $admin['namespace'] = $this->created_namespace($this->controller_path_api,$base_admin['class_name']);
        $content = $this->View->fetch($this->template_controller_file,$admin);
        $content = "<?php\n".$content;
        file_put_contents($this->get_created_path($this->controller_path_api,$admin['class_name']),$content);
        //}
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
