<?php
// +----------------------------------------------------------------------
// | 仿网易一元夺宝购物系统
// +----------------------------------------------------------------------
// | Author: 王茂林 (1290800466@qq.com)
// +----------------------------------------------------------------------
// | Tel: 18612446985
// +----------------------------------------------------------------------
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
        $login_info = session('user_info');
        if(!isset($login_info) || empty($login_info)){
            auto_login();
        }
        //var_dump($login_info);
        $goods_one = M("Goods")->where('type=1')->order('creat_time asc')->find();
        if($goods_one==''){
            $goods_one = M("Goods")->where('type=0')->order('creat_time asc')->find();
            if($goods_one==''){
                echo '本期夺宝已结束，敬请期待下期夺宝！';
                exit;
            }
            $id=$goods_one['id'];
            $number=$goods_one['number'];
            $arr = array();
            $count=0;
            $i=0;
            while($count<$number){
                $a=rand(0,($number-1));
                if(!in_array ($a,$arr))
                {
                    $arr[$i] = $a;
                    $i++;
                }
                $count  =  count($arr);
            }
            $arr=serialize($arr);
            $lucky['goods_id'] = $id;
            $lucky['lucky_number'] = $arr;
            $lucky_one = M("unique")->where("goods_id=$id")->find();
            if($lucky_one==''){
                M("unique")->add($lucky); //
            }
            $date['type']=1;
            $date['begin_time'] = get_gmtime();
            $date['issue'] = date("Ym",get_gmtime()).$id;
            // 要修改的数据对象属性赋值
            M("Goods")->where("id=$id")->save($date); // 根据条件更新记录
            $goods_one = M("Goods")->where('type=1')->order('creat_time asc')->find();
        }
        $percent=round(($goods_one['pay_number']/$goods_one['number'])*100).'%';
        $remainder=$goods_one['number']-$goods_one['pay_number'];
        if(($goods_one['begin_time']!=0)&&($goods_one['begin_time']!='')){
            $goods_one['begin_time']=date("Y-m-d H:i:s",$goods_one['begin_time']);
        }
        $this->assign('goods',$goods_one);
        $this->assign('percent',$percent);
        $this->assign('remainder',$remainder);
        $now_time=date('Y-m-d',time());
        $this->assign('now_time',$now_time);


        $id=$goods_one['id'];
        $pay_list = M("order")->where("is_paid=1 AND goods_id=$id")->order('pay_time desc')->select();
        foreach ($pay_list as $key=>$val){
            if(($pay_list["$key"]['pay_time']!=0)&&($pay_list["$key"]['pay_time']!='')){
                $pay_list["$key"]['pay_time']= date("Y-m-d H:i:s", $pay_list["$key"]['pay_time']);
            }
            $Userinfo = M("User"); // 实例化User对象
            $user_id=$pay_list["$key"]['user_id'];

            $Userinfo_name = $Userinfo->where("id='$user_id'")->getField('name');
            $Userinfo_image = $Userinfo->where("id='$user_id'")->getField('image');
            $pay_list["$key"]['user'] = $Userinfo_name;
            $pay_list["$key"]['head'] = $Userinfo_image;
            $notice_sn = $pay_list["$key"]['notice_sn'];
            $lucky_number=M("order")->where("notice_sn=$notice_sn")->getField('lucky_number');
            $lucky_number = unserialize($lucky_number);
            $lucky_number = implode(";",$lucky_number);
            $lucky_number = emptyreplace($lucky_number);

            $pay_list["$key"]['lucky_number'] = $lucky_number;
        }
        $this->assign('pay_list',$pay_list);
        //user_id  此处要填写session值
        $user = M("order")->where("is_paid=1 AND goods_id=$id AND user_id=1")->select();
        $this->assign('user',$user);

        $this->display ();
    }
}