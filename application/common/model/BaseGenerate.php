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
class BaseGenerate
{
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

    /**
     * 表信息
     * @var array
     */
    protected $tables = [];

    /**
     * 主表信息
     * @var array
     */
    protected $master_tables = [];

    public function __construct()
    {
        $this->View = (new View())->engine();

        $this->date = date('Y-m-d H:i:s');

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
            $str .="\r\n\t\t\t->join('{$key} {$value[0]}','{$value[1][0]}','{$value[1][1]}')";
        }

        return $str;
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
        $namespace = str_replace(dirname(APP_PATH),'',$path);
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
        if(!is_dir($target)){  //如果文件不存在新建
            mkdir($target,0777,true);
        }
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
     * 获取表信息 第一个是别名 第二个是表名
     * is_master 是否获取主表 true是 false不是
     * @return array
     */
    protected function get_table($is_master = false)
    {
        $table = [];
        foreach ($this->config['table'] as $key => $item){
            if(is_array($item)){
                $alias = $item[0];
            }elseif(!$item){
                $alias = $key;
            }else{
                $alias = $item;
            }

            $pk = Db::name("{$key}")->getPk();  //获取表的主键
            if(!$pk){
                $pk = 'id'; //当主键不存在的时候用id作为主键
            }elseif (is_array($pk)){
                $pk = $pk[0];
            }

            if($is_master){
                return [$alias,['table' => $key,'pk' => $pk]];
            }

            $table[$alias] = ['table' => $key,'pk' => $pk];
        }

        return $table;
    }

    /**
     * 验证封装
     * @param $field
     * @return array
     */
    public function analysis_validate($field)
    {
        $data = [];
        foreach ($field as $item){
            if(!$item['is_validate']) continue;
            if(!$item['validate_data']){
                $item['validate_data'] = 'require';
            }
            $field = $this->decompose($item['field']);
            $data[ "{$item['alias']}_{$field}".'|'.$item['name']] = implode('|',$item['validate_data']);
        }

        return $data;
    }
    /**
     * @param $field
     * @param $is_show
     * @param bool $is_show_primary_key  是否查询每张表的主键
     * @return string
     */
    public function analysis_field($field,$is_show,$is_show_primary_key = false)
    {
        $main_alisa = $this->master_tables[0];
        $str = "{$main_alisa}.id as id,";  //将主表的id添加到字段中

        //添加除主表以外的其他主键
        if($is_show_primary_key){
            $tables = $this->tables;
            if(!empty($tables)){
                foreach ($tables as $key => $item){
                    $str .=$key.'.'.$item['pk'].' as '.$key.'_'.$item['pk'].',';
                }
            }
        }

        foreach($field as $key => $value){
            if($is_show !== true and (!isset($value[$is_show]) or !$value[$is_show])){
                continue;
            }
            $value['field'] = $this->decompose($value['field']);
            $str .= "{$value['alias']}.{$value['field']} as {$value['alias']}_{$value['field']},";
        }

        $str = trim($str,',');

        return $str;
    }

    /**
     * 把数组变成数组字符串
     * @param $array
     * @return string
     */
    public function array_to_string($array)
    {
        $str = '[';
        if(!is_array($array)) return '';
        foreach ($array as $key => $value){
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

        $str  = trim($str,',');
        $str .=']';

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
     * 构建关系表之间的字段关系
     * @return array
     */
    public function Relationship()
    {
        $add_Relationship = [];
        //条件分析
        $tables = $this->config['table'];
        array_shift($tables);
        foreach ($tables as $keys => $item)
        {
            if(!isset($item[1][0])) continue;
            //关系分析
            $on = preg_replace('/(or|and){1}.*$/i','',$item[1][0]);
            $on = explode('=',$on);
            if(!isset($on['0']) or !isset($on[1])){
                continue;
            }
            $on[0] = explode('.',trim($on[0]));
            $on[1] = explode('.',trim($on[1]));
            //查看他们之间的关系那个是主键 在条件里面必须要一个主键 一个非主键
            foreach ($on as $key => $item){
                $pkey = $key == 1? 0:1;
                if($this->tables[$item[0]]['pk'] == $item[1] or $this->tables[$on[$pkey][0]]['pk'] != $on[$pkey][1]) continue;
                $add_Relationship[$keys]['Db'] = "Db::name('{$this->tables[$item[0]]['table']}')->where(['{$this->tables[$item[0]]['pk']}' => \${$item[0]}_last_id])->update(['{$item[1]}' => \${$on[$pkey][0]}_last_id])";
                $add_Relationship[$keys]['variable'] = ["\${$item[0]}_last_id","\${$on[$pkey][0]}_last_id"];
                break;
            }
        }

        return $add_Relationship;
    }
}
