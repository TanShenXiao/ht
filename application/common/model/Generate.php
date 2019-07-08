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

use think\Db;
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

    protected $public_variable = [];

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

         $config = $this->config;
         $this->build_admin($config);  //生成后台
         //$this->build_api([]);

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
        $base_admin = $this->diy_controller($config);
        $base_admin['namespace'] = $this->created_namespace($this->base_controller_path_admin);
        $this->created_file($this->templete_base_controller_file,$this->base_controller_path_admin,$base_admin);
        //生成前台控制器
        $admin = [
            'use' => [
                 $base_admin['namespace'].'\\'.$base_admin['class_name'],
            ],
            'class_name' => $config['class_name'],
            'extends_class' => $base_admin['class_name'],
            'change_date' => $this->date,

        ];
        $this->created_file($this->template_controller_file,$this->controller_path_admin,$admin);

        //自动创建菜单
        $this->created_menu($config['class_name']);
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
        foreach ($config['field'] as $item){
            if(!$item['is_validate']) continue;
            if(!$item['validate_data']){
                $item['validate_data'] = 'require';
            }
            $field = $this->decompose($item['field']);
            $base_validate['rule'][ "{$item['alias']}_{$field}".'|'.$item['name']] = implode('|',$item['validate_data']);
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
                'app\admin\controller\Admin'
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
        $base_admin['index_content']['data_list'] = $this->analysis_table($config['table']);   //列表查询封装
        $field = $this->analysis_field($config['field'],'is_list');                            //字段查询封装
        $base_admin['index_content']['data_list'] .= "->field('{$field}')";
        $base_admin['index_content']['search'] = $this->analysis_search($config['field']);      //搜索字段封装
        $base_admin['index_content']['column'] = $this->analysis_column($config['field']);     //显示列表字段封装

        $base_admin['public_variable'] = $this->public_variable;  //加载共用变量

        return $base_admin;
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
                $str .= $key." {$value}')";
                continue;
            }

            $str .="->join('{$key} {$value[0]}','{$value[1][0]}','{$value[1][1]}')";
        }

        return $str;
    }

    /**
     * 字段封装
     * @param $table
     * @return string
     */
    public function analysis_field($field,$is_show)
    {
        $table_keys = array_keys($this->config['table']);
        $main_alisa =$this->config['table'][$table_keys[0]];
        $str = "{$main_alisa}.id as id,";  //将主表的id添加到字段中

        foreach($field as $key => $value){
            if(!isset($value[$is_show]) or !$value[$is_show]){
                continue;
            }
            $value['field'] = $this->decompose($value['field']);
            $str .= "{$value['alias']}.{$value['field']} as {$value['alias']}_{$value['field']},";
        }

        $str = trim($str,',');

        return $str;
    }

    /**
     * 字段搜索封装
     * @param $table
     * @return string
     */
    public function analysis_search($field,$is_show = 'is_search')
    {
        $search = [];
        foreach($field as $key => $value){
            if(!isset($value[$is_show]) or !$value[$is_show]){
                continue;
            }
            $value['field'] = $this->decompose($value['field']);
            $field = $value['alias'].'_'.$value['field'];

            //数组对象不能直接传参对数据经行转换
            if(is_array($value['search_data'][3]) and !empty($value['search_data'][3])){
                if(!isset($this->public_variable[$field]) or $this->public_variable[$field]){
                    $this->public_variable[$field] = $this->array_to_string($value['search_data'][3]).';';
                }
                $value['search_data'][3] = '$this->'.$field;

            } elseif(empty($value['search_data'][3])){
                $value['search_data'][3] = "''";
            }elseif ($this->Relation_filed($value['search_data'][3])){
                if(!isset($this->public_variable[$field]) or $this->public_variable[$field]){
                    $this->public_variable[$field] = $this->Relation_filed($value['search_data'][3]).';';
                }
                $value['search_data'][3] = '$this->'.$field;
            } else{
                $value['search_data'][3] = "'{$value['search_data'][3]}'";
            }

            $search[] = "['{$value['search_data'][0]}','{$value['table']}.{$value['field']}','{$value['name']}','{$value['search_data'][1]}','{$value['search_data'][2]}',{$value['search_data'][3]}],";
        }

        return $search;
    }

    /**
     * 字段封装
     * @param $table
     * @return string
     */
    public function analysis_column($field,$is_show = 'is_list')
    {
        $column = [];
        foreach($field as $key => $value){
            if(!isset($value[$is_show]) or !$value[$is_show]){
                continue;
            }

            $value['field'] = $this->decompose($value['field']);
            $data = array_merge(["{$value['alias']}_{$value['field']}",$value['name']],$value['list_data']);
            $str = $this->preg_Separate(implode(',',$data));
            $column[] = "->addColumn({$str})";
        }

        if($this->config['is_edit'] or $this->config['is_delete']){

            $column[] = "->addColumn('right_button', '操作', 'btn')";

        }
        //判断是否需要 添加 编辑 删除按钮
        if($this->config['is_add']){
             $column[] = "->addTopButton('add')       //顶部添加按钮";
             $column[] = "->addTopButton('delete')    //顶部删除按钮";
        }
        if($this->config['is_edit']){
            $column[] = "->addRightButton('edit')     //右边编辑按钮";
        }
        if($this->config['is_delete']){
            $column[] = "->addRightButton('delete')   //右边删除按钮";
        }

        return $column;
    }

    /**
     *为分解的参数加单引号
     * @param $str
     * @return mixed
     */
    public function preg_Separate($str)
    {
        $str = preg_replace('/,/i',"','",$str);
        $str = "'".$str."'";
        return $str;
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
     * @param $field
     * @return array
     */
    public function decompose($field)
    {
        $array = explode('.',$field);
        return array_pop($array);
    }

    /**
     * 数据简单校验
     * @param $data
     * @param string $field
     * @return bool
     */
    public function is_existence($data,$field = '')
    {
        return isset($data[$field]) and $data[$field];

    }

    /**
     * 把数组变成数组字符串
     * @param $array
     * @return string
     */
    public function array_to_string($array)
    {
        $str = '';
        $i =0;
        if(!is_array($array)) return '';
        foreach ($array as $key => $value){
            $i++;
            if($i == 1){
                $str .="[";
            }
            if(is_array($value)){
                $val = $this->array_to_string($value);
                if(!preg_match('/^\[.*\]$/i',$val)){
                    $val = "'".$val."'";
                }
            }else{
                if(is_null($value)){
                    $val = "null";
                }elseif (is_bool($value)){
                    if($value){
                        $val = "true";
                    }else{
                        $val = "false";
                    }
                }else{
                    $val = "'".$value."'";
                }
            }
            $str .= "'{$key}' => {$val},";
        }
        if($i > 0){
            $str  = trim($str,',');
            $str .=']';
        }

        return $str;
    }

    /**
     * 获取多选的关联 查询
     * @param $str
     * @return bool|string
     */
    public function Relation_filed($str)
    {
        $data = explode('->',$str);
        if(!isset($data[1]) or !isset($data[2]) or !$data[0] or !$data[1] or !$data[2]){
            return false;
        }

        return "Db::name('{$data[0]}')->column('{$data[1]}','{$data[2]}')";
    }


    /**
     * 创建后台菜单
     */
    protected function created_menu($controller_name = '')
    {
        $module = $this->config['module'];
        $base_url = $this->config['module'].'/'.$controller_name.'/';
        $index_url = $base_url.'index';
        $add_url = $base_url.'add';
        $edit_url = $base_url.'edit';
        $delete_url = $base_url.'delete';

        $index = Db::name('admin_menu')->where(['module' => $module,'url_value' => $index_url])->find();
        $add = Db::name('admin_menu')->where(['module' => $module,'url_value' => $add_url])->find();
        $edit = Db::name('admin_menu')->where(['module' => $module,'url_value' => $edit_url])->find();
        $delete = Db::name('admin_menu')->where(['module' => $module,'url_value' => $delete_url])->find();



        $pid = Db::name('admin_menu')->where(['module' => $module,'pid' => 0])->value('id');
        $pid = $pid ? $pid:1;
        if(!$index and !$add and !$edit and !$delete){   //创建顶级空菜单
            $data = [];
            $data['pid'] = $pid;
            $data['module'] = $module;
            $data['title'] = $this->config['title'];
            $data['icon'] = 'fa fa-fw fa-bars';
            $data['url_type'] = 'module_admin';
            $data['url_value'] = '';

            Db::name('admin_menu')->insert($data);
            $pid = Db::getLastInsID();

        }else{
           $pid_data =  $index ? $index:($add?$add:($edit?$edit:($delete?$delete:'')));  //找出存在上级的那个上级id
           $pid = $pid_data['pid'];
        }

        if(!$index){   //查看
            $data = [];
            $data['pid'] = $pid;
            $data['module'] = $module;
            $data['title'] = '查看';
            $data['icon'] = 'fa fa-fw fa-bars';
            $data['url_type'] = 'module_admin';
            $data['url_value'] = $index_url;

            Db::name('admin_menu')->insert($data);
        }

        if(!$add){   //添加
            $data = [];
            $data['pid'] = $pid;
            $data['module'] = $module;
            $data['title'] = '添加';
            $data['icon'] = 'fa fa-fw fa-bars';
            $data['url_type'] = 'module_admin';
            $data['url_value'] = $add_url;

            Db::name('admin_menu')->insert($data);
        }

        if(!$edit){   //编辑
            $data = [];
            $data['pid'] = $pid;
            $data['module'] = $module;
            $data['title'] = '编辑';
            $data['icon'] = 'fa fa-fw fa-bars';
            $data['url_type'] = 'module_admin';
            $data['url_value'] = $edit_url;

            Db::name('admin_menu')->insert($data);
        }

        if(!$delete){   //删除
            $data = [];
            $data['pid'] = $pid;
            $data['module'] = $module;
            $data['title'] = '删除';
            $data['icon'] = 'fa fa-fw fa-bars';
            $data['url_type'] = 'module_admin';
            $data['url_value'] = $delete_url;

            Db::name('admin_menu')->insert($data);
        }
    }

}
