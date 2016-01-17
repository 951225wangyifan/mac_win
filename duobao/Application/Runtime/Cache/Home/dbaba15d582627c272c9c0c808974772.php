<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
 <html>
 <head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
    <title>微信安全支付</title>
    <script type="text/javascript">
        //调用微信JS api 支付
        function jsApiCall()
        {
            WeixinJSBridge.invoke(
                'getBrandWCPayRequest',
                <?php echo ($jsApiParameters); ?>,
                		function(res){
    				WeixinJSBridge.log(res.err_msg);
    				if(res.err_msg == 'get_brand_wcpay_request:ok'){

    					alert('支付成功');
    					window.location.href="http://www.1qjx.com/";
    						//?m=Home&c=Pay&a=pay_result&order_id=<?php echo $order_id; ?>";

    				}
    				else if(res.err_msg == 'get_brand_wcpay_request:cancel'){
    					alert('支付取消');
    				}
    				else{
    					alert('支付失败');
    				}
    			}
            );
        }
        function callpay()
        {
            if (typeof WeixinJSBridge == "undefined"){
                if( document.addEventListener ){
                    document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
                }else if (document.attachEvent){
                    document.attachEvent('WeixinJSBridgeReady', jsApiCall);
                    document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
                }
            }else{
                jsApiCall();
            }
        }
    </script>
 </head>
 <body>
    <br/>
    <font color="#9ACD32"><b style="font-size:60px">该笔订单支付金额为<span style="color:#f00;font-size:80px">
    <?php echo ($db_money); ?>元</span></b></font><br/><br/><br/><br/><br/><br/>
	<div align="center">
		<button style="width:300px; height:120px; border-radius: 15px;background-color:#FE6714; border:0px #FE6714 solid; cursor: pointer;  color:white;  font-size:60px;" type="button" onclick="callpay()" >立即支付</button>
	</div>
</body>
 </html>