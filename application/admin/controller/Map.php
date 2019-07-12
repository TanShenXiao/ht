<?php
// +----------------------------------------------------------------------
// | 海豚PHP框架 [ DolphinPHP ]
// +----------------------------------------------------------------------
// | 版权所有 2016~2019 广东卓锐软件有限公司 [ http://www.zrthink.com ]
// +----------------------------------------------------------------------
// | 官方网站: http://dolphinphp.com
// +----------------------------------------------------------------------

namespace app\admin\controller;

use app\common\builder\ZBuilder;
use app\admin\model\Module as ModuleModel;
use app\admin\model\Menu as MenuModel;
use app\user\model\Role as RoleModel;
use think\App;
use think\Db;
use think\facade\Cache;
use app\common\model\ProgramMap;

/**
 * 节点管理
 * @package app\admin\controller
 */
class Map extends Admin
{
    public $module;

    public function __construct(App $app = null)
    {
        parent::__construct($app);

        $this->module = new ProgramMap();
    }

    /**
     * 模块搜索首页
     * @param string $group 分组
     * @author 蔡伟明 <314013107@qq.com>
     * @return mixed
     * @throws \Exception
     */
    public function index()
    {

        $tab = input('tab');
        //模块信息
        $tab_list = Db::name('admin_module')->where(['status' => 1])->order('sort desc')->select();

        if(!$tab and !empty($tab_list)){
            $tab = $tab_list[0]['name'];
        }
        //获取当前模块信息
        $file_list = $this->module->get_file(APP_PATH.'/'.$tab);


        $max_level = $this->request->get('max', 0);

        $this->assign('menus', $this->getNestMenu($file_list, $max_level));

        $this->assign('tab_nav', ['tab_list' => $tab_list, 'curr_tab' => $tab]);
        $this->assign('page_title', '模块搜索管理');
        return $this->fetch();
    }

    /**
     * 添加代码
     * @param string $module 所属模块
     * @param string $pid 所属节点id
     * @author 蔡伟明 <314013107@qq.com>
     * @return mixed
     * @throws \Exception
     */
    public function add($module = 'admin', $pid = '')
    {
        $path = base64_decode(input('function_path',''));
        $function_name = input('function_name');
        $function_content = input('function_content');
        $function_comment = input('function_comment');
        $function_param = input('function_param','');

        if(!is_file($path)) $this->error('请选择文件路径。');
        if(!$function_name) $this->error('请输入函数名称。');
        if(!$function_comment) $this->error('请输入函数备注。');

        $result = $this->module->add_code($path,$function_name,$function_param,$function_content,$function_comment);
        if($result === true){
            $this->success('成功');
        }
        $this->error('失败'.$result);
    }

    /**
     * 编辑节点
     * @param int $id 节点ID
     * @author 蔡伟明 <314013107@qq.com>
     * @return mixed
     * @throws \Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function edit($id = 0)
    {

    }

    /**
     * 设置角色权限
     * @param string $role_id 角色id
     * @param array $roles 角色id
     * @author 蔡伟明 <314013107@qq.com>
     * @throws \Exception
     */
    private function setRoleMenu($role_id = '', $roles = [])
    {

    }

    /**
     * 删除节点
     * @param array $record 行为日志内容
     * @author 蔡伟明 <314013107@qq.com>
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function delete($record = [])
    {

    }

    /**
     * 保存节点排序
     * @author 蔡伟明 <314013107@qq.com>
     */
    public function save()
    {

    }

    /**
     * 获取嵌套式节点
     * @param array $lists 原始节点数组
     * @param int $pid 父级id
     * @param int $max_level 最多返回多少层，0为不限制
     * @param int $curr_level 当前层数
     * @author 蔡伟明 <314013107@qq.com>
     * @return string
     */
    private function getNestMenu($lists = [], $max_level = 0, $pid = 0, $curr_level = 1)
    {
        $result = '';
        foreach ($lists as $key => $value) {
            if ($value['pid'] == $pid) {
                $disable  = 0 ? 'dd-disable' : '';
                if($value['type'] == 'dir'){
                    $value['icon'] = 'fa fa-fw fa-folder';
                }elseif ($value['type'] == 'file'){
                    $value['icon'] = 'fa fa-fw fa-paste';
                }else{
                    $value['icon'] = 'fa fa-fw fa-pencil';
                }

                // 组合节点
                if($value['type'] == 'file'){
                    $result .= '<li class="dd-item dd3-item class_name'.$disable.'" data-id="'.$value['id'].'">';
                }elseif ($value['type'] == 'function'){
                    $result .= '<li class="dd-item dd3-item class_name'.$disable.'" data-id="'.$value['id'].'">';
                }else{
                    $result .= '<li class="dd-item dd3-item'.$disable.'" data-id="'.$value['id'].'">';
                }


                $result .= '<div class="dd-handle dd3-handle">拖拽</div><div class="dd3-content" style="height:auto;"><i class="'.$value['icon'].'"></i> '.$value['title'];
                if ($value['value'] != '') {
                    $result .= '<span class="link"><i class="fa fa-link"></i> '.$value['value'].'</span>';
                }

                if($value['type'] == 'file'){
                    if(!isset($value['is_base_class']) or $value['is_base_class'] <= 0){
                        $path = base64_encode($value['value']);
                        $result .= '<div class="action">';
                        $result .= "<a href=\"javascript:alert_form('{$path}');\" data-toggle=\"tooltip\" data-original-title=\"添加方法\"><i class=\"list-icon fa fa-pencil fa-fw\"></i></a>";
                        $result .= '</div>';
                    }
                    $result .= '<div class="comment" style="display:block"><pre style="border:0px;background-color:unset;">'.$value['comment'].'</pre></div>';
                }elseif($value['type'] == 'function'){

                    $result .= '<div class="comment" style="display:block"><pre style="border:0px;background-color:unset;">'.$value['comment'];
                    foreach ($value['param'] as $key => $item){
                        $result .="参数名：{$key} 默认值：{$item[0]} 类型：{$item[1]}<br>";
                    }
                    $result .=  '</pre></div>';
                }
                $result .= '</div>';

                if ($max_level == 0 || $curr_level != $max_level) {
                    unset($lists[$key]);
                    // 下级节点
                    $children = $this->getNestMenu($lists, $max_level, $value['id'], $curr_level + 1);

                    if ($children != '') {
                        $result .= '<ol class="dd-list">'.$children.'</ol>';
                    }
                }

                $result .= '</li>';
            }
        }
        return $result;
    }

}
