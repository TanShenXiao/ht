<?php
// +----------------------------------------------------------------------
// | 代码生成器 php 基础摸版文件 注意该文件不可以修改他随时都在发生变化
// +----------------------------------------------------------------------
// | 最新更新时间: 2019-07-17 16:46:22// +-----------------------------------------------------------------------
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
class BaseTest extends Api
{

	/**
	* 所属
	* @access public
	*/
	public function index()
	{
	    $is_remarks = input('is_remarks');
	    //获取筛选
	    $map = $this->getMap();
	    $order = $this->getOrder();
	
	    $data_list = Db::name('admin_attachment admin_attachment')
				->field('admin_attachment.id as id,admin_attachment.id as admin_attachment_id,admin_attachment.uid as admin_attachment_uid,admin_attachment.name as admin_attachment_name,admin_attachment.module as admin_attachment_module,admin_attachment.thumb as admin_attachment_thumb,admin_attachment.url as admin_attachment_url,admin_attachment.size as admin_attachment_size')
				->where($map)->order($order)->paginate()->toArray();
	
	    if($is_remarks){
	        $data_list['field_remarks'] = [
	            //显示字段
	            
	                'admin_attachment_uid' => '用户id',            
	                'admin_attachment_name' => '文件名',            
	                'admin_attachment_module' => '模块名，由哪个模块上传的',            
	                'admin_attachment_thumb' => '缩略图路径',            
	                'admin_attachment_url' => '文件链接',            
	                'admin_attachment_size' => '文件大小',            
	        ];
	    }
	
	    return $this->result($data_list,1,'获取成功','json');
	}
	/**
	* 所诉* @access public
	*/
	public function add()
	{
	
	    
	    //表信息//
	    $tables = ['admin_action' => ['table' => 'admin_action','pk' => 'id']];
	
	    
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
	        if(key_exists($arr[0],$tables)){
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
	
	    return $this->result($add_id,1,'获取成功','json');
	}
}