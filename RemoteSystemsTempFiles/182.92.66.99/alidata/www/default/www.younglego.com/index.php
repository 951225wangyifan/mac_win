<?php
/**
 * 欢迎使用
 *
 * AwMall微信商城系统!
 * 
 *
 * @版权  Copyright (c) 2014-2015 AwMall Inc. 
 * @官网  http://www.awcms.net/
 * @演示  http://awmall.awcms.net/
 * @作者  阿旺 QQ:532917920
 * @版本  Ver2.0  
 * @版号  201503024
**/

define('ROOT_PATH', dirname(__FILE__));

/**
 * 安装判断
 */
if (!file_exists(ROOT_PATH . "/data/install.lock") && is_dir(ROOT_PATH . "/install")){
	@header("location: install");
	exit;
}

include(ROOT_PATH . '/eccore/AwMall.php');

/* 定义配置信息 */
awmall_define(ROOT_PATH . '/data/config.inc.php');

$ua = strtolower($_SERVER['HTTP_USER_AGENT']);
$uachar = "/(nokia|sony|ericsson|mot|samsung|sgh|lg|philips|panasonic|alcatel|lenovo|cldc|midp|mobile|android)/i";

if((preg_match($uachar, $ua)))
{
    define('AwMall_WAP', 1);
}
if ($_GET['Debug'] == 'Wap') {
    define('AwMall_WAP', 1);
}
//define('AwMall_WAP', 1);
/* 启动AwMall */
AwMall::startup(array(
    'default_app'   =>  'default',
    'default_act'   =>  'index',
    'app_root'      =>  ROOT_PATH . '/app',
    'external_libs' =>  array(
        ROOT_PATH . '/includes/global.lib.php',
        ROOT_PATH . '/includes/libraries/time.lib.php',
        ROOT_PATH . '/includes/ecapp.base.php',
        ROOT_PATH . '/includes/plugin.base.php',
        ROOT_PATH . '/app/frontend.base.php',
        ROOT_PATH . '/includes/subdomain.inc.php',
    ),
));
?>
