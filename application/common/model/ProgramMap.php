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

/**
 * Class Generate
 * @package app\common\model
 */
class ProgramMap
{
    /**
     * 获取文件列表
     * @param bool|string $app_path
     * @return array
     */
    public function get_file($app_path = APP_PATH,$pid = 0)
    {   static $i;
        $dir = scandir($app_path);
        $dirs = [];
        foreach ($dir as $name){
            $value = $app_path.'/'.$name;
            if($name == '.' or $name == '..' or (is_file($value) and pathinfo($value)['extension'] != 'php')) continue;
            ++$i;
            $key = 'k_'.$i;
            $dirs[$key]['id']    = $i;
            $dirs[$key]['pid']   = $pid;
            $dirs[$key]['title'] = $name;
            $dirs[$key]['value'] = $value;

            if(is_dir($value)){
                $dirs[$key]['type'] = 'dir';
            }else{
                $dirs[$key]['type'] = 'file';
                $result = $this->analysis_class($value,$i,$i);
                if($result === false){
                    unset($dirs[$key]);
                    --$i;
                }
                $dirs[$key]['comment'] = $result['comment'];
                $dirs[$key]['is_base_class'] = $result['is_base_class'];

                $dirs = array_merge($dirs,$result['function']);
            }
            if(is_dir($value)){
                $dirs = array_merge($dirs,$this->get_file($value,$i));
            }
        }

        return $dirs;
    }

    /**
     * 获取类的的信息
     * @param $file
     * @param $i
     * @param $pid
     * @return bool
     * @throws \ReflectionException
     */
    public function analysis_class($file,&$i,$pid)
    {
        $namespace = $this->created_namespace(dirname($file));
        $class = $namespace.'\\'.pathinfo($file,PATHINFO_FILENAME);

        if(!class_exists($class)){
              return false;
        }
        $reflectionClass = new \ReflectionClass($class);
        $data = [];

        $class_data['comment'] =  preg_replace('/(^\/\*{1,})|(\*\/)| /i','',trim($reflectionClass->getDocComment()));
        $methods = $reflectionClass->getMethods();
        //判断它是不是基类
        $class_data['is_base_class'] = preg_match('/\[Final\]/i', $class_data['comment']);

        foreach ($methods as $values){
            if($values->class != $class) continue;
            ++$i;
            $key = 'k_'.$i;
            $data[$key]['id']       = $i;
            $data[$key]['pid']      = $pid;
            $data[$key]['value']    = $file;
            $data[$key]['type']     = 'function';
            $data[$key]['comment']  = preg_replace('/^\/\*{1,}|\*\/| /i','',trim($values->getDocComment(),"\r\n"));
            $data[$key]['title']     = $values->getName();
            $data[$key]['param'] = [];
            $parameters = (array)$values->getParameters();
            foreach ($parameters as $keys => $param){
                $name = $param->getName();
                if($param->isDefaultValueAvailable()){
                   $default = $param->getDefaultValue();
                   if(is_array($default)){
                       $data[$key]['param'][$name][] = $this->array_to_string($default);
                   }elseif (is_object($default)){
                       $data[$key]['param'][$name][] = get_class($default);
                   }else{
                       $data[$key]['param'][$name][] = $default;
                   }
                }else{
                    $data[$key]['param'][$name][] = '无';
                }

                if($param->HasType()){
                    $data[$key]['param'][$name][] = $param->getType()->getName();
                }else{
                    $data[$key]['param'][$name][] = '无';
                }
            }
        }
        $class_data['function'] = $data;


        return $class_data;
    }

    public function add_code($path,$function_name,$param = '',$function_content= '',$function_comment = '')
    {
        //在备注的换行符前面加*
        $function_comment = preg_replace("/\n/i","\n\t *",$function_comment);

        $content = "
    /**
     * {$function_comment}
     */    
    function $function_name({$param})
    {
        {$function_content}
    }
}   
        ";
        //函数名称判断
        if(preg_match('/[^A-za-z_]+/i',$function_name)){
            return '请输入正确的函数名称';
        }

        //函数参数判断
        $array = explode(',',$param);
        foreach ($array as $item){
            if(preg_match('/^[^\$]/i',$param) and preg_match('/^[^&\$]/i',$param)){
                return '请输入正确的参数';
            }
        }

        $namespace = $this->created_namespace(dirname($path));
        $class = $namespace.'\\'.pathinfo($path,PATHINFO_FILENAME);

        if(!class_exists($class)){
            return '获取不到类';
        }
        $reflectionClass = new \ReflectionClass($class);
        if($reflectionClass->hasMethod($function_name)){
            return '方法已存在不能添加';
        }
        $Original_content = file_get_contents($path);
        $Original_content =  preg_replace('/\}\s*\?>$|\}\s*$/i','',$Original_content).$content;

        if(file_put_contents($path,$Original_content)){
            return true;
        }
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
}
