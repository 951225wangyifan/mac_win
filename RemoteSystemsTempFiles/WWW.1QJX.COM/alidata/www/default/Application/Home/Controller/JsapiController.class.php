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
class JsapiController extends Controller {

    /**
     * 初始化
     */
    public function _initialize()
    {
        //引入WxPayPubHelper
        vendor('WxPayPubHelper.WxPayPubHelper');
    }


    //jsapi 支付接口
    public function pay(){

        //使用jsapi接口
        $jsApi = new \JsApi_pub();

        //=========步骤1：网页授权获取用户openid============
        //通过code获得openid
        if (!isset($_GET['code']))
        {
            //触发微信返回code码
            $url = $jsApi->createOauthUrlForCode(C('WxPayConf_pub.JS_API_CALL_URL'));
            Header("Location: $url");
        }else
        {
            //获取code码，以获取openid
            $code = $_GET['code'];
            $jsApi->setCode($code);
            $openid = $jsApi->getOpenId();
        }
        if(!session('user_info')){
            header("Location: http://www.1qjx.com/");
        }
        ini_set('date.timezone','Asia/Shanghai');


        $order_id = session('order_id');
       //$order_id=$_SESSION['order_id'];
        //var_dump($order_id);
        //exit;

        header("Content-Type:text/html;Charset=utf-8");

        $order = M("order"); // 实例化User对象
        $order_info = $order->where("id = $order_id")->select();
        if($order_info[0]['is_paid']==1){
            echo "<script>alert('该订单已支付，请勿重复支付！');window.location.href='http://www.1qjx.com/';</script>";
            exit;
        }
        $order_info = $order->where("id = $order_id")->find();
        /*  var_dump($order_info);
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
        }
        $money = round($order_info['money'],2);
        $db_money=$money;
        $money = $money*100;
        $notice_sn = $order_info['notice_sn'];
        //var_dump($notice_sn);
        //exit;

        //var_dump($order_info);
        //exit;
        $Goods = M("Goods"); // 实例化User对象
        // 查找status值为1的用户数据 以创建时间排序 返回10条数据
        $goods_info = $Goods->where("id = $goods_id")->select();
        $goods_name = $goods_info['name'];
        //$notify_url = "http://www.1qjx.com/index.php/Home/Pay/pay_result/order_id/$order_id";


        //=========步骤2：使用统一支付接口，获取prepay_id============
        //使用统一支付接口
        $unifiedOrder = new \UnifiedOrder_pub();

        //设置统一支付接口参数
        //设置必填参数
        //appid已填,商户无需重复填写
        //mch_id已填,商户无需重复填写
        //noncestr已填,商户无需重复填写
        //spbill_create_ip已填,商户无需重复填写
        //sign已填,商户无需重复填写
        $unifiedOrder->setParameter("openid",$openid);//商品描述
        $unifiedOrder->setParameter("body","夺宝$goods_name");//商品描述
        $unifiedOrder->setParameter("out_trade_no",$notice_sn);//商户订单号
        $unifiedOrder->setParameter("total_fee","$money");//总金额
        $unifiedOrder->setParameter("notify_url",C('WxPayConf_pub.NOTIFY_URL'));//通知地址
        $unifiedOrder->setParameter("trade_type","JSAPI");//交易类型
        //非必填参数，商户可根据实际情况选填
        //$unifiedOrder->setParameter("sub_mch_id","XXXX");//子商户号
        //$unifiedOrder->setParameter("device_info","XXXX");//设备号
        //$unifiedOrder->setParameter("attach","XXXX");//附加数据
        //$unifiedOrder->setParameter("time_start","date("YmdHis")");//交易起始时间
        //$unifiedOrder->setParameter("time_expire","XXXX");//交易结束时间
        $unifiedOrder->setParameter("goods_tag","夺宝系列商品");//商品标记
        //$unifiedOrder->setParameter("openid","XXXX");//用户标识
        //$unifiedOrder->setParameter("product_id","XXXX");//商品ID

        $prepay_id = $unifiedOrder->getPrepayId();
        //=========步骤3：使用jsapi调起支付============
        $jsApi->setPrepayId($prepay_id);

        $jsApiParameters = $jsApi->getParameters();
        $this->assign('jsApiParameters',$jsApiParameters);
        $this->assign('db_money',$db_money);
        $this->display();
        //echo $jsApiParameters;

    }


    public function notify(){

        //使用通用通知接口
        $notify = new \Notify_pub();

        //存储微信的回调
        $xml = $GLOBALS['HTTP_RAW_POST_DATA'];
        $notify->saveData($xml);

        //验证签名，并回应微信。
        //对后台通知交互时，如果微信收到商户的应答不是成功或超时，微信认为通知失败，
        //微信会通过一定的策略（如30分钟共8次）定期重新发起通知，
        //尽可能提高通知的成功率，但微信不保证通知最终能成功。
        if($notify->checkSign() == FALSE){
            $notify->setReturnParameter("return_code","FAIL");//返回状态码
            $notify->setReturnParameter("return_msg","签名失败");//返回信息
        }else{
            $notify->setReturnParameter("return_code","SUCCESS");//设置返回码
        }
        $returnXml = $notify->returnXml();
        echo $returnXml;

        //==商户根据实际情况设置相应的处理流程，此处仅作举例=======

        //以log文件形式记录回调信息
        //$log_ = new Log_();
        $log_name= "notify_url.log";//log文件路径

        log_result($log_name,"【接收到的notify通知】:\n".$xml."\n");
        if($notify->checkSign() == TRUE)
        {
            if ($notify->data["return_code"] == "FAIL") {
                //此处应该更新一下订单状态，商户自行增删操作
                log_result($log_name,"【通信出错】:\n".$xml."\n");
            }
            elseif($notify->data["result_code"] == "FAIL"){
                //此处应该更新一下订单状态，商户自行增删操作
                log_result($log_name,"【业务出错】:\n".$xml."\n");
            }
            else{
                //此处应该更新一下订单状态，商户自行增删操作
                log_result($log_name,"【支付成功】:\n".$xml."\n");
                $info = $notify->xmlToarray($xml);
                $notice_sn = $info['out_trade_no'];
                $order_info['out_notice_sn'] = $info['transaction_id'];;
                $order_info['is_paid'] = 1;
                $order_info['pay_time'] = get_gmtime();
                $order = M("order");
                $order_info1 = $order->where("notice_sn=$notice_sn")->select();
                if($order_info1['is_paid']==1){
                    exit;
                }else{
                    $pay_time1=$order->where("notice_sn=$notice_sn")->getField('pay_time');
                    if($pay_time1==0){
                         $result = $order->where("notice_sn=$notice_sn")->save($order_info); // 根据条件更新记录

                    }
                    if ( false !== $result && isset($result)){
                        $number = $order->where("notice_sn=$notice_sn AND is_paid =1")->getField('number');
                        $goods_id =  $order->where("notice_sn=$notice_sn AND is_paid =1")->getField('goods_id');
                        M("goods")->where("id=$goods_id")->setInc('pay_number',$number);
                        $pay_number = M("goods")->where("id=$goods_id")->getField('pay_number');
                        $total_number = M("goods")->where("id=$goods_id")->getField('number');
                        if($pay_number >= $total_number){
                            $goods['type'] = 2;
                            $goods['end_time'] = get_gmtime();
                            M("goods")->where("id=$goods_id")->save($goods); // 根据条件更新记录
                        }
                        $unique = M("unique");
                        $total_lucky_number = $unique->where("goods_id=$goods_id")->getField('lucky_number');
                        $total_lucky_number = unserialize($total_lucky_number);
                        $lucky_number = array_slice($total_lucky_number, 0,$number);
                        $rem_lucky_number = array_slice($total_lucky_number,$number);
                        $lucky_number1['lucky_number'] = serialize($lucky_number);
                        $rem_lucky_number1['lucky_number'] = serialize($rem_lucky_number);
                        M("unique")->where("goods_id=$goods_id")->save($rem_lucky_number1);
                        $order->where("notice_sn=$notice_sn")->save($lucky_number1);
                    }
                }

            }

        }

    }

}