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
class PayController extends Controller {
    
    //参加夺宝
    public function join()
    {
        $login_info = session('user_info');
        if(!isset($login_info) || empty($login_info)){
            auto_login();
        }
        $id=$_REQUEST['id'];
        $Goods = M("Goods"); // 实例化User对象
        // 获取ID为  $_REQUEST['id'] 的用户的昵称
        $goods_info = $Goods->where("id=$id")->find();
        $goods_info['remainder']=$goods_info['number']-$goods_info['pay_number'];
        $this->assign('goods',$goods_info);
        $this->display();
    }
    
    //支付
    public function pay()
    {
        $login_info = session('user_info');
         if(!isset($login_info) || empty($login_info)){
            auto_login();
        } 
        //var_dump($login_info);
        $id=$_REQUEST['id'];
        $number=$_REQUEST['number'];
        $Goods = M("Goods"); // 实例化User对象
        // 获取ID为  $_REQUEST['id'] 的用户的昵称
        $goods_info = $Goods->where("id=$id")->find();
        $goods_info['buy_number'] = $number;
        $goods_info['total_money']=$goods_info['unit_price']*$goods_info['buy_number'];
        $goods_info['remainder']=$goods_info['number']-$goods_info['pay_number'];
        if($goods_info['remainder']==0){
            $this->error('您选择的商品已经达到指定购买人次，您已无法购买！');
        }
        if($number>$goods_info['remainder']){
            $this->error('您选择的商品购买人次超过商品剩余人次，请重新选择！');
        }
        $order = M("order");
        if(!defined('NOW_TIME'))
            define("NOW_TIME",get_gmtime());
        $data['notice_sn']=to_date(NOW_TIME,"Ymdhis").rand(100,999);
        $data['create_time']=get_gmtime();
        $data['pay_time']=0;
        $data['is_paid']=0;
        $data['user_id']=$login_info['id'];
        $data['goods_id']=$id;
        $data['number']=$number;
        $data['money']=$goods_info['total_money'];
        $order_id=$order->add($data);
        $goods_info['order_id']=$order_id;
        //var_dump($order_id);
        $this->assign('goods',$goods_info);
        $this->display();
    }
    
    public function go_pay()
    {
        $login_info = session('user_info');
        if(!isset($login_info) || empty($login_info)){
            auto_login();
        }
        $order_id=$_REQUEST['order_id'];
        session('order_id',$order_id);  //设置session
        
        $order = M("order");
        $order_info = $order->where("id = $order_id")->find();
        /* var_dump($order_info);
        exit; */
        $goods_id = $order_info['goods_id'];
        $number =  $order_info['number'];
        $Goods = M("Goods"); // 实例化User对象
        // 获取ID为  $_REQUEST['id'] 的用户的昵称
        /* var_dump($goods_id);
        exit; */
        $goods_info = $Goods->where("id=$goods_id")->find();
        $goods_info['buy_number'] = $number;
        $goods_info['total_money']=$goods_info['unit_price']*$goods_info['buy_number'];
        $goods_info['remainder']=$goods_info['number']-$goods_info['pay_number'];
        if($goods_info['remainder']<=0){
            $this->error('您选择的商品已经达到指定购买人次，您已无法购买！');
        }elseif ($number>$goods_info['remainder']){
            $this->error('您选择的商品购买人次超过商品剩余人次，请重新选择！');
        }else{
            $this->redirect("Jsapi/pay");
        }
        

    }
    
    
}