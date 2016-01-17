<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN"><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>本期幸运码 </title>
	<meta name="description" content="1元夺宝">
    <meta name="keywords" content="1元夺宝">
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, width=device-width">
	<meta content="telephone=no" name="format-detection">
    <link href="../../../../../../../../../Public/public1/index/css/user_lucky/common.css" rel="stylesheet">
    <link href="../../../../../../../../../Public/public1/index/css/user_lucky/user.css" rel="stylesheet">

</head>
<body class="">
<div class="m-user" id="dvWrapper">
	<div class="m-simpleHeader" id="dvHeader">
		<a href="#" onClick="javascript :history.back(-1);" data-pro="back" data-back="true" class="m-simpleHeader-back"><i class="ico ico-back"></i></a>
		<a href="#" data-pro="ok" class="m-simpleHeader-ok" id="aHome"><i class="ico ico-home"></i></a>
		<h1>本期幸运码</h1>
	</div>
    <div class="m-user-index">
    	<div class="m-user-summary m-user-summary-simple">
        	<div class="info">
            	<div class="m-user-avatar">
            		<img  src="<?php echo ($Userinfo_image); ?>" height="50" width="50">
				</div>
	            <div class="txt">
	                <div class="name"><?php echo ($Userinfo_name); ?></div>
	               <!--  <div class="id">ID：62427183</div> -->
	            </div>
        	</div>
    	</div>
    </div>
</div>
<div class="m-user-duobaoRecord" id="duobaoRcd_dvWrapper" style="">
<div id="pro-view-11"><div data-pro="loading"></div>
<ul class="w-goodsList w-goodsList-l m-user-goodsList" data-pro="list">
	<?php if(is_array($order_info)): foreach($order_info as $key=>$order_info): if($order_info != ''): ?><li id="pro-view-13" class="w-goodsList-item">
        <div class="w-goods w-goods-l w-goods-ing m-user-goods">
           <!--  <div class="w-goods-info"> -->
                <p >幸运号：<?php echo ($order_info); ?></p>
           <!--  </div> -->
        </div>
    </li><?php endif; endforeach; endif; ?>
</ul>
</div>
</div>
</body>
</html>