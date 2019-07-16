<?php
// +----------------------------------------------------------------------
// | 代码生成器 php 基础摸版文件 注意该文件不可以修改他随时都在发生变化
// +----------------------------------------------------------------------
// | 最新更新时间: 2019-07-16 22:12:02// +-----------------------------------------------------------------------
// | Author: tanshenxiao
// +-----------------------------------------------------------------------

namespace app\admin\api_controller;

use think\Db;
use think\App;
use app\common\controller\Api;
use think\Validate;
//---flag_use---- 添加used标记

/**
* [Final] 基类不可以修改
*/
class Basekkk extends Api
{

	/**
	* 添加数据* @access public
	*/
	public function add()
	{
	
	    
	    //表信息//
	    $tables = ['admin_access' => ['table' => 'admin_access','pk' => 'id']];
	
	    
	    $change_data = input();
	    $validate = new Validate();
	    $validate->rule([
	
	    
	    ]);
	    if(!$validate->check($change_data)){
	
	        $this->error($validate->getError());
	
	    }
	
	    //数据分解
	    $insert_data = [];
	    foreach ($change_data as $key => $item){
	        $arr = explode('_',$key,2);
	        if(!isset($arr[1])) continue;
	        if(key_exists($arr[0],$this->tables)){
	            $table = $tables[$arr[0]];
	            $insert_data[$table['table']]['data'][$arr[1]] = $item;
	            $insert_data[$table['table']]['alias']= $arr[0];
	        }
	    }
	    //开启事务插入数据
	    Db::startTrans();
	    $add_id = [];
	    foreach ($insert_data as $key => $item){
	        if(empty($item['data'])) continue;
	        if(!Db::name($key)->insert($item['data'])){
	            $this->error("表".$key."添加数失败。");
	        }
	
	        $last_id_name = $item['alias'].'_last_id';  //存储插入id
	        $add_id[$last_id_name] = $$last_id_name =  Db::getLastInsID();
	    }
	
	    //更新字段之间的关系
	    
	    //字段关系结束
	    Db::commit();
	
	    return $this->result($add_id,200,'获取成功','json');
	}
}