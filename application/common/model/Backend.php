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
class Backend extends BaseGenerate
{
    /**
     * 基础控制器摸版的路径
     * @var string
     */
    protected $template_base_controller_file = APP_PATH.'/common/generate/tpl/backend/template_base_controller.tpl';

    /**
     * 控制器摸版
     * @var string
     */
    protected $template_controller_file =  APP_PATH.'/common/generate/tpl/backend/template_controller.tpl';

    /**
     * 基礎验证器配置路径
     * @var string
     */
    protected $template_base_validate_file =  APP_PATH.'/common/generate/tpl/backend/template_base_validate.tpl';

    /**
     * 验证器配置路径
     * @var string
     */
    protected $template_validate_file =  APP_PATH.'/common/generate/tpl/backend/template_validate.tpl';

    /**
     * 基础控制器后台存放路径
     * @var
     */
    protected $base_controller_path_admin;

    /**
     * 基础控制器api存放路径
     * @var
     */
    protected $base_controller_path_api;

    /**
     * 基础校验器admin存放路径
     * @var mixed|string
     */
    protected $base_validate_path_admin;

    /**
     *  基础校验器api存放路径
     * @var mixed|string
     */
    protected $base_validate_path_api;

    /**
     * 控制器 后台 存放路径
     * @var
     */
    protected $controller_path_admin;

    /**
     * 控制器 api  存放路径
     * @var
     */
    protected $controller_path_api;

    /**
     * 校验器 后台 存放路径
     * @var
     */
    protected $validate_path_admin;

    /**
     * 校验器 api 存放路径
     * @var
     */
    protected $validate_path_api;

    /**
     * 获取字段属性和字段应有的值
     * @var array
     */
    protected $filed_data = [
        'addCheckbox'   =>   [['name','name值',1],['title','标题',1],['tips','提示',1],['options','数据项',2],['default','默认值',1],['attr','属性',1],['extra_attr','额外属性',1],['extra_class','额外css类',1]],  //复选
        'addRadio'      =>   [['name','name值',1],['title','标题',1],['tips','提示',1],['options','数据项',2],['default','默认值',1],['attr','属性',1],['extra_attr','额外属性',1],['extra_class','额外css类',1]],  //单选
        'addDate'       =>   [['name','name值',1],['title','标题',1],['tips','提示',1],['default','默认值',1],['format','日期格式',1],['extra_attr','额外属性',1],['extra_class','额外css类',1]],  //日期
        'addTime'       =>   [['name','name值',1],['title','标题',1],['tips','提示',1],['default','默认值',1],['format','日期格式',1],['extra_attr','额外属性',1],['extra_class','额外css类',1]],  //时间
        'addSwitch'     =>   [['name','name值',1],['title','标题',1],['tips','提示',1],['default','默认值',1],['attr','属性',2],['extra_attr','额外属性',1],['extra_class','额外css类',1]],  //开关
        'addTags'       =>   [['name','name值',1],['title','标题',1],['tips','提示',1],['default','默认值',1],['extra_class','额外css类',1]],  //开关
        'addArray'      =>   [['name','name值',1],['title','标题',1],['tips','提示',1],['default','默认值',1],['extra_attr','额外属性',1],['extra_class','额外css类',1]],  //数组
        'addGroup'      =>   [['groups','分组数据',2]],  //分组
        'addRange'      =>   [['name','name值',1],['title','标题',1],['tips','提示',1],['default','默认值',1],['options','数据项',1],['extra_attr','额外属性',1],['extra_class','额外css类',1]],  //开关
        'addButton'     =>   [['name','name值',1],['attr','属性',2],['ele_type','按钮类型',1]],  //按钮
        'addNumber'     =>   [['name','name值',1],['title','标题',1],['tips','提示',1],['default','默认值',1],['min','最小值',1],['min','最大值',1],['step','步进值',1],['extra_attr','额外属性',2],['extra_class','额外css类',1]],  //数组框
        'addPassword'   =>   [['name','name值',1],['title','标题',1],['tips','提示',1],['default','默认值',1],['extra_attr','额外属性',2],['extra_class','额外css类',1]],  //密码框
        'addColorpicker'=>   [['name','name值',1],['title','标题',1],['tips','提示',1],['default','默认值',1],['mode','模式',1],['extra_attr','额外属性',1],['extra_class','额外css类',1]],  //取色器
        'addSelect'     =>   [['name','name值',1],['title','标题',1],['tips','提示',1],['options','数据项',2],['default','默认值',1],['extra_attr','额外属性',1],['extra_class','额外css类',1]],  //下拉菜单
        'addLinkage'    =>   [['name','name值',1],['title','标题',1],['tips','提示',1],['options','数据项',2],['default','默认值',1],['ajax_url','异步请求地址',1],['next_items','后代name值',1],['param','请求参数名',1],['extra_param','extra_param',1]],  //普通联动
        'addLinkages'   =>   [['name','name值',1],['title','标题',1],['tips','提示',1],['table','表名',1],['level','级别数量',1],['default','默认值',1],['fields','字段名',1]],  //快速联动
        'addSort'       =>   [['name','name值',1],['title','标题',1],['tips','提示',1],['value','数据值',2],['extra_class','额外css类',1]],  //拖拽排序
        'addStatic'     =>   [['name','name值',1],['title','标题',1],['tips','提示',1],['default','默认值',1],['hidden','属性',1],['extra_class','额外css类',1]],  //静态文本
        'addMasked'     =>   [['name','name值',1],['title','标题',1],['tips','提示',1],['format','格式',1],['default','默认值',1],['extra_attr','额外属性',1],['extra_class','额外css类',1]],  //格式文本
        'addDatetime'   =>   [['name','name值',1],['title','标题',1],['tips','提示',1],['format','格式',1],['extra_attr','额外属性',1],['extra_class','额外css类',1]],  //日期时间
        'addDaterange'  =>   [['name','name值',1],['title','标题',1],['tips','提示',1],['format','格式',1],['extra_attr','额外属性',1],['extra_class','额外css类',1]],  //日期范围
        'addJcrop'      =>   [['name','name值',1],['title','标题',1],['tips','提示',1],['default','默认值',1],['options','参数',2],['extra_class','额外css类',1]],  //图片剪辑
        'addBmap'       =>   [['name','name值',1],['title','标题',1],['ak','秘钥',1],['tips','提示',1],['default','默认坐标',1],['level','显示级别',1],['extra_class','额外css类',1]],  //百度地图
        'addFile'       =>   [['name','name值',1],['title','标题',1],['tips','提示',1],['default','默认值',1],['size','限制大小',1],['ext','文件后缀',1],['extra_class','额外css类',1]],  //单文件上传
        'addFiles'      =>   [['name','name值',1],['title','标题',1],['tips','提示',1],['default','默认值',1],['size','限制大小',1],['ext','文件后缀',1],['extra_class','额外css类',1]],  //多文件上传
        'addImage'      =>   [['name','name值',1],['title','标题',1],['tips','提示',1],['default','默认值',1],['size','限制大小',1],['ext','文件后缀',1],['extra_class','额外css类',1],['thumb','缩略参数',1],['watermark','水印参数',1]],  //单图片上传
        'addImages'     =>   [['name','name值',1],['title','标题',1],['tips','提示',1],['default','默认值',1],['size','限制大小',1],['ext','文件后缀',1],['extra_class','额外css类',1],['thumb','缩略参数',1],['watermark','水印参数',1]],  //多图片上传
        'addHidden'     =>   [['name','name值',1],['default','默认值',1],['extra_class','额外css类',1]],  //隐藏表单
        'addIcon'       =>   [['name','name值',1],['title','标题',1],['tips','提示',1],['default','默认值',1],['extra_attr','额外属性',2],['extra_class','额外css类',1]],  //图标选择器
        'addText'       =>   [['name','name值',1],['title','标题',1],['tips','提示',1],['default','默认值',1],['group','标签分组',1],['extra_attr','额外属性',1],['extra_class','额外css类',1]],  //单行文本框
        'addTextarea'   =>   [['name','name值',1],['title','标题',1],['tips','提示',1],['default','默认值',1],['extra_attr','额外属性',1],['extra_class','额外css类',1]],  //多行文本框
        'addUeditor'    =>   [['name','name值',1],['title','标题',1],['tips','提示',1],['default','默认值',1],['extra_class','额外css类',1]],  //百度编辑器
        'addCkeditor'   =>   [['name','name值',1],['title','标题',1],['tips','提示',1],['default','默认值',1],['width','宽度',1],['height','高度',1],['extra_class','额外css类',1]],  //CKEditor编辑器
        'addWangeditor' =>   [['name','name值',1],['title','标题',1],['tips','提示',1],['default','默认值',1],['extra_class','额外css类',1]],  //wang编辑器
        'addEditormd'   =>   [['name','name值',1],['title','标题',1],['tips','提示',1],['default','默认值',1],['watch','实时预览',3],['extra_class','额外css类',1]],  //markdown编辑器
        'addSummernote' =>   [['name','name值',1],['title','标题',1],['tips','提示',1],['default','默认值',1],['width','宽度',1],['height','高度',1],['extra_class','额外css类',1]],  //summernote编辑器
        'addGallery'    =>   [['name','name值',1],['title','标题',1],['tips','提示',1],['default','默认值',1],['extra_class','额外css类',1]],  //图片展示
        'addArchive'    =>   [['name','name值',1],['title','标题',1],['tips','提示',1],['default','默认值',1],['extra_class','额外css类',1]],  //单文件展示
        'addArchives'   =>   [['name','name值',1],['title','标题',1],['tips','提示',1],['default','默认值',1],['extra_class','额外css类',1]],  //多文件展示
        'addSelectAjax' =>   [['name','name值',1],['title','标题',1],['tips','提示',1],['params','参数',2],['default','默认值',1],['extra_attr','额外属性',1],['extra_class','额外css类',1]],  //下拉菜单Ajax
    ];

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
        if($this->is_existence($data,'template_base_controller_file'))  $this->template_base_controller_file = $data['template_base_controller_file'];    //基础控制器摸版的路径
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


        //获取表信息
        $this->tables = $this->get_table();
        $this->master_tables = $this->get_table(true);

        //路径设置
        if(isset($this->config['module'])){
            $module = $this->config['module'];
            //判断基础控制器
            if(!$this->base_controller_path_admin){
                $this->base_controller_path_admin =  APP_PATH."/{$module}/backend_controller";
            }
            if(!$this->base_controller_path_api){
                $this->base_controller_path_api =  APP_PATH."/{$module}/api_controller";
            }
            if(!$this->base_validate_path_admin){
                $this->base_validate_path_admin =  APP_PATH."/{$module}/validate/backend_validate";
            }
            if(!$this->base_validate_path_api){
                $this->base_validate_path_api =  APP_PATH."/{$module}/validate/api_validate";
            }
            if(!$this->controller_path_admin){
                $this->controller_path_admin =  APP_PATH."/{$module}/controller";
            }
            if(!$this->controller_path_api){
                $this->controller_path_api =  APP_PATH."/{$module}/api";
            }
            if(!$this->validate_path_admin){
                $this->validate_path_admin =  APP_PATH."/{$module}/validate/backend";
            }
            if(!$this->validate_path_api){
                $this->validate_path_api =  APP_PATH."/{$module}/validate/api";
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
        $validate = new Validate([
            'module' => 'require'
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
        if(!is_file($this->template_base_validate_file)){
            $this->error_msg = '找不到基础校验器摸控制文件';return;
        }
        if(!is_file($this->template_validate_file)){
            $this->error_msg = '找不到校验器摸控制文件';return;
        }
    }

    /**
     * 创建后台管理
     * @return string
     */
    public function create()
    {
        //检测是否通过数据校验
        if($this->error_msg) return $this->error_msg;
        $config = $this->config;
        //生成基础验证器
        $base_validate = $this->diy_validate($config);
        $this->created_file($this->template_base_validate_file,$this->base_validate_path_admin,$base_validate);

        //生成验证器
        $validate = [
            'use' => [
                $base_validate['namespace'].'\\'.$base_validate['class_name'],
            ],
            'extends_class' => $base_validate['class_name'],
            'change_date' => $this->date,
        ];

        $this->config['validate_name'] = $validate['class_name']  = 'Validate'.$config['class_name'];                                        //在配置文件中保存验证类名
        $this->config['validate_namespace'] = $this->created_namespace($this->validate_path_admin).'\\'.$this->config['validate_name'];     //在配置文件中保存验证类的命名空间

        $this->created_file($this->template_validate_file,$this->validate_path_admin,$validate);

        //生成基础后台控制器
        $base_admin = $this->diy_controller($config);
        $base_admin['namespace'] = $this->created_namespace($this->base_controller_path_admin);
        $this->created_file($this->template_base_controller_file,$this->base_controller_path_admin,$base_admin);

        //生成后台控制器
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
        //生成基础后台控制器
        $validate_namespace = $this->config['validate_namespace'];
        $base_admin = [
            'use' => [
                'app\admin\controller\Admin',
                $validate_namespace,
            ],
            'extends_class' => 'Admin',
            'index_content' => [
                'data_list' => '',
            ],
            'edit_content' => [],
            'delete_content' => [],
            'change_date' => $this->date,
        ];
        $base_admin['class_name'] = $base_name.$config['class_name'];
        $this->public_variable['tables']['data'] = $this->array_to_string($this->tables);//获取主表信息用于条件查询
        $this->public_variable['tables']['describe'] = '数据表信息';
        $base_admin['master_table'] = $this->master_tables;                  //获取主表信息

        //index 所需数据封装
        $field = $this->analysis_field($config['field'],'is_list');                                  //字段查询封装
        $base_admin['index_content']['title']         = $config['title'].'_查看';
        $base_admin['index_content']['data_list']     = $this->analysis_table($config['table']);     //列表查询封装
        $base_admin['index_content']['data_list']    .= "\r\n\t\t\t->field('{$field}')";
        $base_admin['index_content']['search']        = $this->analysis_search($config['field']);    //搜索字段封装
        $base_admin['index_content']['column']        = $this->analysis_column($config['field']);    //显示列表字段封装

        //add 所需数据封装
        $base_admin['add_content']['title']           = $config['title'].'_添加';
        $base_admin['add_content']['column']          = $this->analysis_form_column($config['field'],'is_add'); //编辑字段
        $base_admin['add_content']['column_num']      = count($base_admin['add_content']['column'])-1;
        $base_admin['add_content']['validate_class']  = $this->config['validate_name'];
        $base_admin['add_content']['relationship']    = $this->Relationship();

        //edit 所需数据封装
        $field = $this->analysis_field($config['field'],'is_edit',true);                             //字段查询封装
        $base_admin['edit_content']['title']          = $config['title'].'_编辑';
        $base_admin['edit_content']['data_list']      = $this->analysis_table($config['table']);    //列表查询封装
        $base_admin['edit_content']['data_list']     .= "\r\n\t\t\t->field('{$field}')";
        $base_admin['edit_content']['column']         = $this->analysis_form_column($config['field'],'is_edit',true); //编辑字段
        $base_admin['edit_content']['column_num']     = count($base_admin['edit_content']['column'])-1;
        $base_admin['edit_content']['validate_class'] = $this->config['validate_name'];

        $this->Relationship();


        $base_admin['public_variable'] = $this->public_variable;  //加载共用变量

        return $base_admin;
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
                    $this->public_variable[$field]['data'] = $this->array_to_string($value['search_data'][3]);
                    $this->public_variable[$field]['describe'] = $value['name'].'关联数据';
                }
                $value['search_data'][3] = '$this->'.$field;

            } elseif(empty($value['search_data'][3])){

                $value['search_data'][3] = "''";

            }elseif ($this->Relation_filed($value['search_data'][3])){

                if(!isset($this->public_variable[$field]) or !$this->public_variable[$field]){
                    $this->public_variable[$field]['data'] = $this->Relation_filed($value['search_data'][3]);
                    $this->public_variable[$field]['describe'] = $value['name'].'关联数据';
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
     * 显示字段封装 字段封装
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
             $column[] = "->addTopButton('add')";
             $column[] = "->addTopButton('delete')";
        }
        if($this->config['is_edit']){
            $column[] = "->addRightButton('edit')";
        }
        if($this->config['is_delete']){
            $column[] = "->addRightButton('delete')";
        }

        return $column;
    }

    /**
     * 组装表单数据
     * @param $field
     * @param string $is_show
     * @param bool $is_primary_key 是否将其他表主键隐藏在表单中
     * @return array
     */
    public function analysis_form_column($field,$is_show = 'is_add',$is_primary_key = false)
    {
        $column = [];

        //添加除主表以外的其他主键 隐藏表单用于数据修改
        if($is_primary_key){
            $tables = $this->tables;
            if(!empty($tables)){
                foreach ($tables as $key => $item){
                    $column[] = "->addHidden('{$key}_{$item['pk']}','')";
                }
            }
        }

        foreach($field as $key => $value){
            if(!isset($value[$is_show]) or !$value[$is_show]){
                continue;
            }
            $field = $value['alias'].'_'.$value['field'];
            $value['field'] = $this->decompose($value['field']);
            $data = $value['form_data'];
            if(!key_exists('add'.$data['type'],$this->filed_data)){  //如果获取不到默认取单行文本框
                $data['type'] = 'Text';
            }
            if(!isset($data['title'])){
                $data['title'] = $value['name'];
            }
            if(!isset($data['name'])){
                $data['name'] = $field;
            }

            $filed_data = $this->filed_data['add'.$data['type']];
            $i = 0;
            $str = '->';
            foreach ($filed_data as $key => $item){
                $i++;
                if($i == 1){
                    $str .='add'.$data['type']."(";
                }
                if(!isset($data[$item[0]])){
                    if($item[2] == 1){
                        $data[$item[0]] = '';
                    }elseif ($item[2] == 2){
                        $data[$item[0]] = [];
                    }else{
                        $data[$item[0]] = '';
                    }
                }
                //判断 是否有表关联
                if($item[0] == 'options' and !is_array($data[$item[0]]) and $this->Relation_filed($data[$item[0]])){
                    if(!isset($this->public_variable[$field]) or !$this->public_variable[$field]){
                        $this->public_variable[$field]['data'] = $this->Relation_filed($data[$item[0]]);
                        $this->public_variable[$field]['describe'] = $value['name'].'关联数据';
                    }
                    $data[$item[0]] = '$this->'.$field;
                }

                if(is_array($data[$item[0]])){
                    $str .= $this->array_to_string($data[$item[0]]).",";
                }elseif(preg_match('/^\$.+/i',$data[$item[0]])){
                    $str .= $data[$item[0]].",";
                }else{
                    $str .="'".$data[$item[0]]."',";
                }
            }

            $column[] = trim($str,',').')';
        }
        return $column;
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
