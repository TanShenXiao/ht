<?php
// +----------------------------------------------------------------------
// | 海豚PHP框架 [ DolphinPHP ]
// +----------------------------------------------------------------------
// | 版权所有 2016~2019 广东卓锐软件有限公司 [ http://www.zrthink.com ]
// +----------------------------------------------------------------------
// | 官方网站: http://dolphinphp.com
// +----------------------------------------------------------------------

namespace app\admin\controller;

use app\common\model\Api;
use think\Db;
use think\Validate;

/**
 * 后台公共控制器
 * @package app\admin\controller
 */
class GenerateApi extends Admin
{
    function initialize()
    {
        parent::initialize(); // TODO: Change the autogenerated stub
        $this->assign('_js_files',['select2_js']);
        $this->assign('_css_files',['select2_css']);
        $this->assign('_js_init',"['select2']");
    }

    /**
     * 首页列表
     * @return mixed
     */
    function index()
    {
        $db_name = config('database.database');
        $tables = Db::query("SELECT TABLE_NAME,TABLE_COMMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = '{$db_name}'");
        $this->assign('tables',$tables);

        return $this->fetch();
    }

    /**
     * 代码生成
     */
    function generate()
    {
        if(!$this->request->isAjax()) $this->error('错误的请求方式');
        $data = input();
        $prefix = config('database.prefix');
       //数据校验
       $validate = new Validate([
           'module' => 'require',
           'temp_type' => 'require',
           'tables' => 'require',
           'class_name' => 'require',
           'name' => 'require',
           'is_method' => 'require',
           'comment' => 'require',
       ]);
       if(!$validate->check($data)){
            $this->error($validate->getError());
       }
       $data['tables'] =  preg_replace("/^{$prefix}/i","", $data['tables']);
       //过滤有效数据
       $config = [
         'table'  => [$data['tables'] => $data['tables']],
         'module'  => $data['module'],
         'temp_type'  => $data['temp_type'],
         'tables'  => $data['tables'],
         'class_name'  => $data['class_name'],
         'name'  => $data['name'],
         'is_method'  => $data['is_method'],
         'comment'  => $data['comment'],
       ];
       $i = 0;
       foreach ($data['field_checkbox'] as $key => $item){
           if($item == 'on'){
            //分解数据 table 字段名
            list($table,$field) = explode('|',$key);
            $table = preg_replace("/^{$prefix}/i","",$table);
            $config['field'][$i]['field'] = $field;
            $config['field'][$i]['table'] = $table;
            $config['field'][$i]['alias'] = $table;
            $config['field'][$i]['name'] = $data['field_name'][$key];
            $config['field'][$i]['is_validate'] = $data['field_validate'][$key] ? 1:0;
            $config['field'][$i]['validate_data'] = [$data['field_validate'][$key]];
            $i++;
           }else{
               unset($data['field_checkbox'][$key]);
           }
       }
        $data['config'] = $config;
        $Generate = new Api($data);
        $content = $Generate->get_content();

        $this->success('成功','',$content);
    }

    /**
     * 获取table的字段列表
     */
    function get_table_filed()
    {
        if (!$this->request->isAjax()) $this->error('错误的请求方式');
        $tables =  input('tables','');
        $tables = json_decode($tables,true);
        if(!$tables){
            $this->error('请选择需要查询的表');
        }
        $prefix = config('database.prefix');
        $db_name = config('database.database');
        $tables = preg_replace('/,/i',"','",implode(',',$tables));
        $tables = "'".$tables."'";
        $tables = Db::query("SELECT concat(replace(TABLE_NAME,'{$prefix}',''),'|',COLUMN_NAME) as FIELD,replace(TABLE_NAME,'{$prefix}','') as TABLE_NAME,COLUMN_NAME,COLUMN_COMMENT,IS_NULLABLE FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = '{$db_name}' and TABLE_NAME in({$tables})");

        $this->success('成功','',$tables);
    }
}   
        