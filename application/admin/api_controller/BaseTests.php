<?php
// +----------------------------------------------------------------------
// | 代码生成器 php 基础摸版文件 注意该文件不可以修改他随时都在发生变化
// +----------------------------------------------------------------------
// | 最新更新时间: 2019-07-13 23:46:21// +-----------------------------------------------------------------------
// | Author: tanshenxiao
// +-----------------------------------------------------------------------

namespace app\admin\api_controller;

use think\Db;
use think\App;
use app\admin\controller\Admin;
//---flag_use---- 添加used标记

/**
* [Final] 基类不可以修改
*/
class BaseTests extends Admin
{




	/**
	* 好东西
	* zknbzkl
	* nzblkcxz
	* nzlbkxc
	* @access public
	*/
	public function zzz()
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
	
	    $this->success('获取成功','',$data_list);
	}
}