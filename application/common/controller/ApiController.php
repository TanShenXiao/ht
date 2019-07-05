<?php
// +----------------------------------------------------------------------
// | 海豚PHP框架 [ DolphinPHP ]
// +----------------------------------------------------------------------
// | 版权所有 2016~2019 广东卓锐软件有限公司 [ http://www.zrthink.com ]
// +----------------------------------------------------------------------
// | 官方网站: http://dolphinphp.com
// +----------------------------------------------------------------------

namespace app\common\controller;

use app\yeartest\model\Member;
use app\yeartest\model\ModelWxPay;
use think\App;
use think\Controller;
use app\yeartest\model\Auth;
use app\common\model\Auth as AuthP;
use think\Db;

/**
 * api 公共控制器
 * @package app\common\controller
 */
class ApiController extends Controller
{
    /**
     * @package think\model
     * @var
     */
    protected $model;

    /**
     * 用户信息
     * @var
     */
    protected $member;
    /**
     * 店铺信息
     * @var
     */
    protected $store;
    /**
     * 店员信息
     * @var
     */
    protected $staff;

    protected $user;

    /**
     * 每页显示的条数
     * @var int
     */

    public function __construct(App $app = null)
    {
        parent::__construct($app);
        //用户数据验证
        /**
         * 用户 token验证s
         */
        if(input('member_token','') and  input('member_id','') and input('orgId','')){
            $token = Auth::token_validate('member_token',input('member_id',''),input('member_token',''));
            if($token['0'] == 1){

                $this->member = Db::name('v_member')->where(['id' => input('member_id','')])->find();
                if($this->member){
                    $this->member['orginfo']=Db::name('org')->where(['id'=>input('orgId','')])->find();
                }
                $this->user = $this->member;
            }else{
                errors($token[1],4,$token);
            }
        }
        /**
         * 商户 token验证
         */
        if(input('store_token','') and input('store_id','')){
            $token = Auth::token_validate('store_token',input('store_id',''),input('store_token',''));
            if($token['0'] == 1){
                $this->store = Db::name('check_shop_info')->where(['id' => $token[1]['id']])->find();
                $this->store = Db::name('check_shop_info')->where(['id' =>input('store_id','')])->find();
            }else{
                errors($token[1],4);
            }
        }

        /**
         * 商户 token验证
         */
        if(input('staff_token','') and  input('staff_id','')){
            $token = Auth::token_validate('staff_token',input('staff_id',''),input('staff_token',''));
            if($token['0'] == 1){
                $this->staff = Db::name('staff')->where(['id' => input('staff_id','')])->fetchSql(0)->find();
                $this->staff = Db::name('staff')->where(['id' => $token[1]['id']])->fetchSql(0)->find();
            }else{
                errors($token[1],4,$token);
            }
        }

        /**
         * 会员通 用验证
         * uid  ext表的id
         */
        if(input('token','') &&  input('uid','') && input('orgId','')){
            $token = AuthP::token_validate('token',input('uid'),input('token',''));

            if($token['0'] == 1){
                $field="m.id wid,e.org_id,m.openid,e.pay_openid,m.nickname,m.city,m.province,m.country,
                case when e.name then e.name else m.name end  name,
                case when e.sex then e.sex else m.sex end  sex,
                case when e.headimgurl then e.headimgurl else m.headimgurl end  headimgurl,
                m.remark,m.groupid,
                e.id uid,e.mobile,e.idcard,e.isvip,e.vip_begin_date,e.vip_end_date,e.info,e.del_flag,e.ctime,e.utime
                ";

                $this->user = Db::name('member')
                    ->field($field)
                    ->where(["e.id"=>input('uid','')])
                    ->alias('m')
                    ->join("member_ext e","e.uid=m.id and e.org_id=m.org_id","inner")
                    ->fetchSql(0)
                    ->find();
                !$this->user && error("用户信息未找到",$this->user,4);
                $this->user['orginfo']=Db::name('org')->where(['id'=>input('orgId','')])->find();
            }else{
                errors($token[1],4,$token);
            }
        }
    }

    /**
     * 验证用户是否登录
     */
    public function is_member()
    {
        if(!$this->member){
            errors('用户未登录。',4);
        }
    }
}