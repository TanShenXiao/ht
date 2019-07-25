<?php
// +----------------------------------------------------------------------
// | 代码生成器 php 基础摸版文件 注意该文件不可以修改他随时都在发生变化
// +----------------------------------------------------------------------
// | 最新更新时间: 2019-07-17 23:27:24// +-----------------------------------------------------------------------
// | Author: tanshenxiao
// +-----------------------------------------------------------------------

namespace app\temp_test\api_controller;

use think\Db;
use think\App;
use app\common\controller\Api;
use think\Validate;
//---flag_use---- 添加used标记

/**
* [Final] 基类不可以修改
*/
class BaseTest098f6bcd4621d373cade4e832627b4f6 extends Api
{

	/**
	* 试试
	* @access public
	*/
	public function add()
	{
	    $is_remarks = input('is_remarks');
	    //获取筛选
	    $map = $this->getMap();
	    $order = $this->getOrder();
	
	    $data_list = Db::name('test test')
				->field('test.id as id,test.id as test_id,test.name as test_name,test.status as test_status')
				->where($map)->order($order)->paginate()->toArray();
	
	    if($is_remarks){
	        $data_list['field_remarks'] = [
	            //显示字段
	            
	                'test_name' => '试试',            
	                'test_status' => '试试',            
	        ];
	    }
	
	    return $this->result($data_list,1,'获取成功','json');
	}
/**
	* 试试
	* @access public
	*/
	public function addss()
	{
	    $is_remarks = input('is_remarks');
	    //获取筛选s
	    $map = $this->getMap();
	    $order = $this->getOrder();
	
	    $data_list = Db::name('test test')
				->field('test.id as id,test.id as test_id,test.name as test_name,test.status as test_status')
				->where($map)->order($order)->paginate()->toArray();
	
	    if($is_remarks){
	        $data_list['field_remarks'] = [
	            //显示字段
	            
	                'test_name' => '',            
	                'test_status' => '',            
	        ];
	    }
	
	    return $this->result($data_list,1,'获取成功','json');
	}
	/**
	* 是
	* @access public
	*/
	public function adds()
	{
	    $is_remarks = input('is_remarks');
	    //获取筛选
	    $map = $this->getMap();
	    $order = $this->getOrder();
	
	    $data_list = Db::name('test test')
				->field('test.id as id,test.id as test_id,test.name as test_name')
				->where($map)->order($order)->paginate()->toArray();
	
	    if($is_remarks){
	        $data_list['field_remarks'] = [
	            //显示字段
	            
	                'test_name' => '',            
	        ];
	    }
	
	    return $this->result($data_list,1,'获取成功','json');
	}
}