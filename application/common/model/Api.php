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
use think\Exception;
use think\View;
use think\Validate;

/**
 * Class Generate
 * @package app\common\model
 */
class Api extends BaseGenerate
{
    /**
     * 基础控制器摸版的路径
     * @var string
     */
    protected $template_function = [
        'select'     => APP_PATH.'/common/generate/tpl/api/template_select.tpl',   //普通查询模板
        'add'        => APP_PATH.'/common/generate/tpl/api/template_add.tpl',      //普通添加模板
        'edit'       => APP_PATH.'/common/generate/tpl/api/template_edit.tpl',     //普通编辑模板
        'delete'     => APP_PATH.'/common/generate/tpl/api/template_delete.tpl',   //普通查询模板
    ];
    /**
     * 基础控制器摸版的路径
     * @var string
     */
    protected $template_base_controller_file = APP_PATH.'/common/generate/tpl/api/template_base_controller.tpl';
    /**
     * 控制器摸版
     * @var string
     */
    protected $template_controller_file =  APP_PATH.'/common/generate/tpl/api/template_controller.tpl';

    /**
     * 基础控制器api存放路径
     * @var
     */
    protected $base_controller_path_api;

    /**
     * 控制器 api  存放路径
     * @var
     */
    protected $controller_path_api;

    /**
     * 摸版共用参数
     * @var array
     */
    protected $public_variable = [];

    /**
     * 基础类前缀
     */
    protected $prefix = 'Base';

    /**
     * 构造方法
     * Generate constructor.
     * @param array $data
     */
    public function __construct($data = [])
    {
        parent::__construct();
        //数据填充
        if($this->is_existence($data,'base_controller_path_api'))       $this->base_controller_path_api      = $data['base_controller_path_api'];         //基础控制器api存放路径
        if($this->is_existence($data,'controller_path_api'))            $this->controller_path_api           = $data['controller_path_api'];              //控制器 api 存放路径
        if($this->is_existence($data,'config'))                         $this->config = $data['config'];

        //获取表信息
        $this->tables = $this->get_table();
        $this->master_tables = $this->get_table(true);

        //路径设置
        if(isset($this->config['module'])){
            $module = $this->config['module'];
            //判断基础控制器
            if(!$this->base_controller_path_api){
                $this->base_controller_path_api =  APP_PATH."/{$module}/api_controller";
            }
            if(!$this->controller_path_api){
                $this->controller_path_api =  APP_PATH."/{$module}/api";
            }
        }
        if(!isset($this->config['create_type'])){
            $this->config['create_type'] = 1;
        }

        //数据校验
        $this->validate();
    }

    /**
     * 校验器
     */
    public function validate()
    {
        $temp_type_in = implode(',',array_keys($this->template_function));
        $validate = new Validate([
            'module|模块'             => 'require',
            'class_name'              => 'require',
            'temp_type|接口类型'      => "require|in:{$temp_type_in}",
            'comment|函数备注'        => "require",
        ]);
        if(!$validate->check($this->config))
        {
            $this->error_msg = $validate->getError();return;
        }

        $this->config['class_name'] = ucfirst($this->config['class_name']);

        if(!is_file($this->template_base_controller_file)){
            $this->error_msg = '找不到基础摸版控制文件';return;
        }
        if(!is_file($this->template_controller_file)){
            $this->error_msg = '找不到控制器摸版文件';return;
        }
    }


    /**
     * 返回生成代码内容 不生成文件
     * @return string
     */
    public function get_content()
    {
        //检测是否通过数据校验
        if($this->error_msg) return $this->error_msg;

        $data = [];
        $data['comment'] = $this->Format_remarks($this->config['comment']);
        $data['name'] = $this->config['name'];
        $data['change_date'] = $this->date;

        if(!method_exists($this,$this->config['temp_type'])){
            return ['code' => 0,'msg' =>'未找到实现的方法'];
        }
        $func = $this->config['temp_type'];
        $content = $this->$func($data);

         return ['code' => 1,'data' => $content];
    }

    /**
     * 接口创建
     * @param $content内容 is_review是否是生成预览 1是 0不是
     * @return string
     */
    public function create($content)
    {
        //检测是否通过数据校验
        $data['change_date'] = $this->date;
        //if($this->error_msg) return ['code' => 1,'msg' => $this->error_msg];

        //当在没有继承基础类的
        $base_class_name = $this->prefix.$this->config['class_name'];
        //临时类名用于测试
        $test_base_class_name = $this->prefix.$this->config['class_name'].'test';

        $base_path = $this->base_controller_path_api.'/'.$base_class_name;
        $base_class = $this->created_namespace($base_path);

        $base_file = $this->get_created_path($this->base_controller_path_api,$base_class_name);
        if(!class_exists($base_class,true)){
                $data['use'] = ['app\common\controller\Api','think\Validate'];
                $data['extends_class'] = 'Api';
                $data['class_name'] = $base_class_name;

            $this->created_file($this->template_base_controller_file,$this->base_controller_path_api,$data);
        }

        //检查其中有没有次方法
        $Original_content = $base_content  = file_get_contents($base_file);

        $reflection = new  \ReflectionClass($base_class);
        if($reflection->hasMethod($this->config['name'])){

            $y_content = $this->get_method_content($base_file,$base_class,$this->config['name']);
            $Original_content  = str_replace($y_content,$content,$Original_content);
        }else{
            $Original_content = file_get_contents($base_file);
            $Original_content =  preg_replace('/\}\s*\?>$|\}\s*$/i',$content."\n}",$Original_content);
        }
        //将类的名字改变来验证他是否错误
        $Original_content = preg_replace("/class\s*{$base_class_name}/i","class ".$test_base_class_name,$Original_content);
        file_put_contents($base_file,$Original_content);

        //类检测
        try{
            //改变类的名字 引用判断错误

            require $base_file;  //引入类文件检测是否报错

        }catch (\Error $e){
            file_put_contents($base_file,$base_content);
            return  ['code' => 0,'msg' => '生成代码失败，代码出现语法错误，错误信息为'.$e->getMessage()];
        }
        //验证成功将类名提花回来
        $Original_content = preg_replace("/class \s*{$test_base_class_name}/i","class ".$base_class_name,$Original_content);
        file_put_contents($base_file,$Original_content);

        //当在没有继承基础类的
        $class_name = $this->config['class_name'];
        $path = $this->controller_path_api.'/'.$class_name;
        $class = $this->created_namespace($path);
        if(!class_exists($class)){
            $data = [];
            $data['use'] = [$base_class];
            $data['extends_class'] = $base_class_name;
            $data['class_name'] = $this->config['class_name'];
            $this->created_file($this->template_controller_file,$this->controller_path_api,$data);
        }

        $api = url($this->config['module'].'/'.$this->config['class_name'].'/'.$this->config['name']);
        $api = str_replace('admin.php','api.php',$api);

        return ['code' => 1,'msg' => 'ok','data' => $api];
    }

    /**
     * 基础查询处理
     * @param $data
     * @return string|string[]|null
     */
    public function select($data)
    {
        $field = $this->analysis_field( $this->config['field'],true,true);                                  //字段查询封装
        $data['data_list']      = $this->analysis_table($this->config['table']);
        $data['data_list']     .= "\r\n\t\t\t->field('{$field}')";
        $data['data_last']      = "->paginate()->toArray()";
        $data['field_remarks']  = $this->get_remarks();

        return $this->parse_content($data);
    }

    /**
     * 基础添加处理
     * @param $data
     * @return string|string[]|null
     */
    public function add($data)
    {
        $data['rule']           = $this->analysis_validate($this->config['field']);
        $data['field_remarks']  = $this->get_remarks();
        $data['relationship']   = $this->Relationship();
        $data['public_variable']['tables']['describe'] = '表信息';  //加载共用变量
        $data['public_variable']['tables']['data'] = $this->array_to_string($this->tables);  //加载共用变量

        return $this->parse_content($data);
    }

    /**
     * 基础編輯处理
     * @param $data
     * @return string|string[]|null
     */
    public function edit($data)
    {
        $field = $this->analysis_field( $this->config['field'],true,true);
        $data['rule']           = $this->analysis_validate($this->config['field']);
        $data['field_remarks']  = $this->get_remarks();
        $data['relationship']   = $this->Relationship();
        $data['data_list']      = $this->analysis_table($this->config['table']);
        $data['data_list']     .= "\r\n\t\t\t->field('{$field}')";
        $data['public_variable']['tables']['describe'] = '表信息';  //加载共用变量
        $data['public_variable']['tables']['data'] = $this->array_to_string($this->tables);  //加载共用变量
        $data['master_table'] = $this->master_tables;

        return $this->parse_content($data);
    }

    /**
     * 基础編輯处理
     * @param $data
     * @return string|string[]|null
     */
    public function delete($data)
    {
        $data['table']['table'] = $this->master_tables[0];
        $data['table']['pk'] = $this->master_tables[1]['pk'];

        return $this->parse_content($data);
    }

    /**
     * 提取函数在文件的内容
     * @param $base_file
     * @param $class
     * @param $method
     * @return string
     * @throws \ReflectionException
     */
    public function get_method_content($base_file,$class,$method)
    {
        $reflection = new \ReflectionClass($class);
        //找出存在的函数
        $str =  $reflection->getMethod($method);
        $arr = explode('Method',$str,2);
        if($arr[0]){
            $str_len = count(explode("\n",trim($arr[0],"\n")));
        }else{
            $str_len = 0;
        }
        preg_match('/\d+ - \d+/i',$arr[1],$param);
        $param = array_map('trim',explode("-",$param[0]));
        $param[0] = $param[0] - $str_len - 1;
        $param[1] = $param[1] -1;

        $files = file($base_file);
        //替换文本中的内容
        $y_content = '';
        for($i=$param[0];$i <= $param[1];$i++ ){
            $y_content .= $files[$i];
        }
        return $y_content = trim($y_content,"\n");
    }

    /**
     * 解析模板内容
     * @param $data
     * @return string|string[]|null
     * @throws \Exception
     */
    public function parse_content($data)
    {
        $content = $this->View->fetch($this->template_function[$this->config['temp_type']],$data);

        if(!preg_match("/^\n/i",$content)){
            $content = "\n".$content;
        }
        return $content = trim(preg_replace("/\n/i","\n\t",$content),"\n");
    }

    /**
     * 解析备注
     * @param $remarks
     * @return string|string[]|null
     */
    public function Format_remarks($remarks){
        $remarks = preg_replace("/ /i","",$remarks);
        $remarks = preg_replace("/\n/i","\n* ",$remarks);

        return $remarks;
    }


    public function get_remarks()
    {
        $data = [];
        foreach ($this->config['field'] as $item){
            $field = $item['alias']."_".$item['field'];
            $data[] = "'{$field}' => '{$item['name']}',";
        }

        return $data;
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
     * 数据简单校验
     * @param $data
     * @param string $field
     * @return bool
     */
    public function is_existence($data,$field = '')
    {
        return isset($data[$field]) and $data[$field];

    }


}
