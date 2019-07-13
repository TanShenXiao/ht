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

        //数据校验
        $this->validate();
    }

    /**
     * 校验器
     */
    public function validate()
    {
        $temp_type_in = implode(',',$this->template_function);
        $validate = new Validate([
            'module|模块'             => 'require',
            'temp_type|接口类型'      => "require|in:{$temp_type_in}",
            'comment|函数备注'      => "require",
        ]);

        if(!$validate->check($this->config))
        {
            $this->error_msg = $validate->getError();return;
        }

        if(!is_file($this->template_base_controller_file)){
            $this->error_msg = '找不到基础摸版控制文件';return;
        }
        if(!is_file($this->template_controller_file)){
            $this->error_msg = '找不到控制器摸版文件';return;
        }
    }

    /**
     * 创建后台管理
     * @return string
     */
    public function create()
    {
        $data = [];
        $data['comment'] = $this->Format_remarks($this->config['comment']);
        $data['name'] = $this->config['name'];
        $data['change_date'] = $this->date;
        $base_name = 'Base';

        if(!method_exists($this,$this->config['temp_type'])){
            return '未找到实现的方法';
        }
        $func = $this->config['temp_type'];
        $content = $this->$func($data);
        //当在没有继承基础类的
        $base_class_name = $base_name.$this->config['class_name'];
        $base_path = $this->base_controller_path_api.'/'.$base_class_name;
        $base_class = $this->created_namespace($base_path);
        if(!class_exists($base_class)){

                $data['use'] = ['app\admin\controller\Admin'];
                $data['extends_class'] = 'Admin';
                $data['class_name'] = $base_class_name;

            $this->created_file($this->template_base_controller_file,$this->base_controller_path_api,$data);
        }
        $base_file = $this->get_created_path($this->base_controller_path_api,$base_class_name);

        //检查其中有没有次方法
        $Original_content = file_get_contents($base_file);
        $reflection = new \ReflectionClass($base_class);

        if($reflection->hasMethod($data['name'])){

            //找出存在的函数
            $str =  $reflection->getMethod('zzz');
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
            $y_content = trim($y_content,"\n");
            $Original_content  = str_replace($y_content,$content,$Original_content);
            file_put_contents($base_file,$Original_content);
        }else{
            $Original_content = file_get_contents($base_file);
            $Original_content =  preg_replace('/\}\s*\?>$|\}\s*$/i',$content."\n}",$Original_content);

            file_put_contents($base_file,$Original_content);
        }
       echo 'ok';


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
        return $content = preg_replace("/\n/i","\n\t",$content);
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
