<?php
//获取GMTime
function get_gmtime()
{
    //return (time() - date('Z'));
    return time();
}

function valid_tag($str)
{

    return preg_replace("/<(?!div|ol|ul|li|sup|sub|span|br|img|p|h1|h2|h3|h4|h5|h6|\/div|\/ol|\/ul|\/li|\/sup|\/sub|\/span|\/br|\/img|\/p|\/h1|\/h2|\/h3|\/h4|\/h5|\/h6|blockquote|\/blockquote|strike|\/strike|b|\/b|i|\/i|u|\/u)[^>]*>/i","",$str);
}

//记录日志
function  log_result($file,$word)
{
    $fp = fopen($file,"a");
    flock($fp, LOCK_EX) ;
    fwrite($fp,"执行日期：".strftime("%Y-%m-%d-%H：%M：%S",time())."\n".$word."\n\n");
    flock($fp, LOCK_UN);
    fclose($fp);
}


//生成订单号
function to_date($utc_time, $format = 'Y-m-d H:i:s') {
    if (empty ( $utc_time )) {
        return '';
    }
    $timezone = intval('8');
    $time = $utc_time + $timezone * 3600;
    return date ($format, $time );
}

/*
 * 字符串中的分号替换为空格
 */
function emptyreplace($str) {
    $noe = false; //是否遇到不是空格的字符
    for ($i=0 ; $i<strlen($str); $i++) { //遍历整个字符串
        if($noe && $str[$i]==';') $str[$i] = '    ';
        elseif($str[$i]!=';') $noe=true;
    }
    return $str;
}


/*
 * 检测微信端
 */
function isWeixin(){
    $agent = strtolower($_SERVER['HTTP_USER_AGENT']);
    $is_weixin = strpos($agent, 'micromessenger') ? true : false ;
    if($is_weixin){
        return true;
    }else{
        return false;
    }
}

//检查该用户是否存在
function get_user_has($key,$value){
    $User = M("User"); // 实例化User对象
    $row = $User->where("$key='$value'")->find();
    if($row){
        return $row;
    }else{
        return false;
    }
}


/**
 * 处理会员登录
 *
 */
function do_login_user($user_id,$user_name)
{
    $User = M("User"); // 实例化User对象
    $user_data = $User->where("id=$user_id AND name='$user_name'")->find();
    session('user_info',$user_data);  //设置session
    //重定向
    //redirect('Index/index');
    header('Location: http://www.1qjx.com/index.php');
}

/**
 * 处理会员保存
 *
 */
function do_save_user($user_name,$user_image,$user_openid){
    $data['name'] = $user_name;
    $data['image'] = $user_image;
    $data['wx_openid'] = $user_openid;
    $User = M("User"); // 实例化User对象
    $User->data($data)->add();
    session('user_info',$data);  //设置session
    //重定向到系统首页
    //$this->redirect('Index/index');
    header('Location: http://www.1qjx.com/index.php');
}


/*
 * 微信自动登录
 */
function auto_login(){
    /* if(!isWeixin()){
        header("Content-Type: text/html; charset=utf-8");
        echo "抱歉,该网站只能在微信端打开，请用微信打开该网页！";
        exit;
    } */
    $user_info = session('user_info');
    if($_REQUEST['code']&&$_REQUEST['state']==1&&!$user_info){
        require 'weixin.php';
        $weixin=new weixin('wxa7e0d8fb62b7d5df','cab576f236da15a72eed02bc0fb7820a','http://www.1qjx.com/');
        $wx_info=$weixin->scope_get_userinfo($_REQUEST['code']);
      	 if($wx_info['openid']){
      	     $wx_user_info=get_user_has('wx_openid',$wx_info['openid']);
      	     if($wx_user_info){
      	         //如果会员存在，直接登录
      	         do_login_user($wx_user_info['id'],$wx_user_info['name']);
      	     }else{
      	         //会员不存在,保存会员呢账号
      	         do_save_user($wx_info['nickname'],$wx_info['headimgurl'],$wx_info['openid']);
      	     }
      	 }
    }else{
        if(!$user_info){
            require 'weixin.php';
            $weixin_2=new weixin('wxa7e0d8fb62b7d5df','cab576f236da15a72eed02bc0fb7820a','http://www.1qjx.com/');
            $wx_url=$weixin_2->scope_get_code();
            redirect($wx_url);
        }
    }
}



















