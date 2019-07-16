<?php
// +----------------------------------------------------------------------
// | 代码生成器 php 基础摸版文件 注意该文件不可以修改他随时都在发生变化
// +----------------------------------------------------------------------
// | 最新更新时间: 2019-07-14 18:13:59// +-----------------------------------------------------------------------
// | Author: tanshenxiao
// +-----------------------------------------------------------------------

namespace app\test\api_controller;

use think\Db;
use think\App;
use app\common\controller\Api;
use think\Validate;
//---flag_use---- 添加used标记

/**
* [Final] 基类不可以修改
*/
class BaseTests extends Api
{

	/**
	* 好东西
	* zknbzkl
	* nzblkcxz
	* nzlbkxc* @access public
	*/
	public function zzz($id = '')
	{
	
	     $data = Db::name('test test')
				->join('test2 test2','test.id = test2.pid','inner')
				->join('test3 test3','test.id = test3.tid','inner')
				->field('test.id as id,test.id as test_id,test2.id as test2_id,test3.id as test3_id,test.name as test_name,test.created_time as test_created_time,test.status as test_status,test2.name as test2_name,test2.city as test2_city,test3.name as test3_name')
				->where(['test.id' => $id])->find();
	
	    
	    //表信息//
	    $tables = ['test' => ['table' => 'test','pk' => 'id'],'test2' => ['table' => 'test2','pk' => 'id'],'test3' => ['table' => 'test3','pk' => 'id']];
	
	    
	    if($this->request->isPost()){
	        $change_data = input();
	        $validate = new Validate();
	        $validate->rule([
	
	                    'test_name|表1' => 'require',
	                    'test_created_time|表1' => 'require',
	                    'test_status|表1' => 'require',
	                    'test2_name|表2' => 'require',
	                    'test2_city|表2地区' => 'require',
	                    'test3_name|表3' => 'require',
	        
	        ]);
	        if(!$validate->check($change_data)){
	
	            $this->error($validate->getError());
	
	        }
	
	        //数据分解
	        $update_data = [];
	            foreach ($change_data as $key => $item){
	            $arr = explode('_',$key,2);
	            if(!isset($arr[1])) continue;
	            if(key_exists($arr[0],$tables)){
	
	            $table = $tables[$arr[0]];
	            if($table['pk'] == $arr[1]){
	            $update_data[$table['table']]['where'] = [$table['pk'] => $item];
	            }else{
	            $update_data[$table['table']]['data'][$arr[1]] = $item;
	            }
	            $update_data[$table['table']]['alias']= $arr[0] ;
	
	            }
	        }
	        //开启事务插入数据
	        Db::startTrans();
	        foreach ($update_data as $key => $item){
	            if(empty($item) or empty($item['where'])) continue;
	
	            if(!Db::name($key)->where($item['where'])->update($item['data'])){ //有的表可能没有更改会导致失败这个先注释掉
	                //$this->error("表".$key."修改数据失败。");
	            }
	        }
	        Db::commit();
	
	        return $this->result([],200,'获取成功','json');
	    }
	
	    return $this->result($data,200,'修改成功','json');
	}
	
	
	
	/**
	* 好东西
	* zknbzkl
	* nzblkcxz
	* nzlbkxc* @access public
	*/
	public function edit($id = '')
	{
	
	     $data = Db::name('test test')
				->join('test2 test2','test.id = test2.pid','inner')
				->join('test3 test3','test.id = test3.tid','inner')
				->field('test.id as id,test.id as test_id,test2.id as test2_id,test3.id as test3_id,test.name as test_name,test.created_time as test_created_time,test.status as test_status,test2.name as test2_name,test2.city as test2_city,test3.name as test3_name')
				->where(['test.id' => $id])->find();
	
	    
	    //表信息//
	    $tables = ['test' => ['table' => 'test','pk' => 'id'],'test2' => ['table' => 'test2','pk' => 'id'],'test3' => ['table' => 'test3','pk' => 'id']];
	
	    
	    if($this->request->isPost()){
	        $change_data = input();
	        $validate = new Validate();
	        $validate->rule([
	
	                    'test_name|表1' => 'require',
	                    'test_created_time|表1' => 'require',
	                    'test_status|表1' => 'require',
	                    'test2_name|表2' => 'require',
	                    'test2_city|表2地区' => 'require',
	                    'test3_name|表3' => 'require',
	        
	        ]);
	        if(!$validate->check($change_data)){
	
	            $this->error($validate->getError());
	
	        }
	
	        //数据分解
	        $update_data = [];
	            foreach ($change_data as $key => $item){
	            $arr = explode('_',$key,2);
	            if(!isset($arr[1])) continue;
	            if(key_exists($arr[0],$tables)){
	
	            $table = $tables[$arr[0]];
	            if($table['pk'] == $arr[1]){
	            $update_data[$table['table']]['where'] = [$table['pk'] => $item];
	            }else{
	            $update_data[$table['table']]['data'][$arr[1]] = $item;
	            }
	            $update_data[$table['table']]['alias']= $arr[0] ;
	
	            }
	        }
	        //开启事务插入数据
	        Db::startTrans();
	        foreach ($update_data as $key => $item){
	            if(empty($item) or empty($item['where'])) continue;
	
	            if(!Db::name($key)->where($item['where'])->update($item['data'])){ //有的表可能没有更改会导致失败这个先注释掉
	                //$this->error("表".$key."修改数据失败。");
	            }
	        }
	        Db::commit();
	
	        return $this->result([],200,'获取成功','json');
	    }
	
	    return $this->result($data,200,'修改成功','json');
	}
	/**
	* 好东西
	* zknbzkl
	* nzblkcxz
	* nzlbkxc* @access public
	*/
	public function add()
	{
	
	    
	    //表信息//
	    $tables = ['test' => ['table' => 'test','pk' => 'id'],'test2' => ['table' => 'test2','pk' => 'id'],'test3' => ['table' => 'test3','pk' => 'id']];
	
	    
	    $change_data = input();
	    $validate = new Validate();
	    $validate->rule([
	
	            'test_name|表1' => 'require',
	            'test_created_time|表1' => 'require',
	            'test_status|表1' => 'require',
	            'test2_name|表2' => 'require',
	            'test2_city|表2地区' => 'require',
	            'test3_name|表3' => 'require',
	    
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
	    
	    if(isset($test2_last_id) and isset($test_last_id) and !Db::name('test2')->where(['id' => $test2_last_id])->update(['pid' => $test_last_id])){
	    $this->error("数据关系更新失败");
	    }
	    
	    if(isset($test3_last_id) and isset($test_last_id) and !Db::name('test3')->where(['id' => $test3_last_id])->update(['tid' => $test_last_id])){
	    $this->error("数据关系更新失败");
	    }
	    
	    //字段关系结束
	    Db::commit();
	
	    return $this->result($add_id,200,'获取成功','json');
	}
	/**
	* 好东西
	* zknbzkl
	* nzblkcxz
	* nzlbkxc
	* @access public
	*/
	public function index()
	{
	    $is_remarks = input('is_remarks');
	    //获取筛选
	    $map = $this->getMap();
	    $order = $this->getOrder();
	
	    $data_list = Db::name('test test')
				->join('test2 test2','test.id = test2.pid','inner')
				->join('test3 test3','test.id = test3.tid','inner')
				->field('test.id as id,test.id as test_id,test2.id as test2_id,test3.id as test3_id,test.name as test_name,test.created_time as test_created_time,test.status as test_status,test2.name as test2_name,test2.city as test2_city,test3.name as test3_name')
				->where($map)->order($order)->paginate()->toArray();
	
	    if($is_remarks){
	        $data_list['field_remarks'] = [
	            //显示字段
	            
	                'test_name' => '表1',            
	                'test_created_time' => '表1',            
	                'test_status' => '表1',            
	                'test2_name' => '表2',            
	                'test2_city' => '表2地区',            
	                'test3_name' => '表3',            
	        ];
	    }
	
	    return $this->result($data_list,200,'获取成功','json');
	}
}