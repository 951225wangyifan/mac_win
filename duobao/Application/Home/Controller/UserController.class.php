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
class UserController extends Controller {
    //查看幸运码
    public function lucky(){
        $login_info = session('user_info');
        if(!isset($login_info) || empty($login_info)){
            auto_login();
        }
        $goods_id=$_REQUEST['id'];
        $user_id=$_SESSION['user_info']['id'];
        $Userinfo = M("User"); // 实例化User对象
        
        $Userinfo_name = $Userinfo->where("id='$user_id'")->getField('name');
        $Userinfo_image = $Userinfo->where("id='$user_id'")->getField('image');
        $this->assign('Userinfo_name',$Userinfo_name);
        $this->assign('Userinfo_image',$Userinfo_image);
        $lucky = M("order"); // 实例化User对象
        // 获取ID为3的用户的昵称
        $order_info = $lucky->where("goods_id=$goods_id AND user_id=$user_id AND is_paid=1")->select();
        foreach ($order_info as $key=>$val){
            //var_dump($order_info["$key"]['lucky_number']);
            $order_info["$key"]['lucky_number'] = unserialize($order_info["$key"]['lucky_number']);
            $order_info["$key"]['lucky_number'] = implode(";",$order_info["$key"]['lucky_number']);
            $order_info["$key"]['lucky_number'] = emptyreplace($order_info["$key"]['lucky_number']);
            $lucky_number["$key"] = $order_info["$key"]['lucky_number'];
            //var_dump($order_info["$key"]['lucky_number']);
            
        }
        //exit;
        $this->assign('order_info',$lucky_number);
        //var_dump($lucky_number);
        //exit;
        //$this->assign('goods',$goods_details);
        $this->display ();
    }
    
    
    
}

?>