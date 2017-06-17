<?php
namespace app\utils\controller;
use think\Controller;
use think\Db;
use WxPay\data\WxPayUnifiedOrder;
use WxPay\WxPayApi;
use WxPay\data\WxPayResults;
use WxPay\data\WxPayNotifyReply;
use WxPay\data\WxPayJsApiPay;
use WxPay\data\WxPayOrderQuery;

class Weixin extends Controller
{
    /**
     * 微信统一下单
     * @return string
     */
    public function unifiedorder() {
        $orderid = $_GET['orderid'];
        $order = M('fruit_order')->where(array('id'=>$orderid))->find();

        $user = M('fruit_user')->where(array('id'=>$order['user_id']))->find();
        $input = new WxPayUnifiedOrder();
        // 避免body过长
        if (mb_strlen($order['products'], 'utf-8') > 20) {
            $input->SetBody(mb_substr($order['products'], 0, 20, 'utf-8').'...');
        } else {
            $input->SetBody($order['products']);
        }
        $input->SetOut_trade_no($order['order_number']);
        $input->SetTotal_fee($order['total_price']*100);
        $input->SetTime_start(date("YmdHis"));
        $input->SetTime_expire(date("YmdHis", time() + 600));
        $input->SetNotify_url(substr(C('__SiteUrl__'), 0, strlen(C('__SiteUrl__')) - 1).U('utils/weixin/notify'));
        $input->SetTrade_type("JSAPI");
        $input->SetOpenid($user['openid']);
        $result = WxPayApi::unifiedOrder($input);

        // 如果下单出错
        if ($result['return_code'] != 'SUCCESS') {
            $msg['errcode'] = 1;
            $msg['errmsg'] = $result['return_msg'];
            return json_encode($msg, JSON_UNESCAPED_UNICODE);
        }

        if ($result['result_code'] != 'SUCCESS') {
            $msg['errcode'] = 3;
            $msg['errmsg'] = $result['err_code_des'];
            return json_encode($msg, JSON_UNESCAPED_UNICODE);
        }

        $jsapi = new WxPayJsApiPay();
        $jsapi->SetAppid($result["appid"]);
        $timeStamp = time();
        $jsapi->SetTimeStamp("$timeStamp");
        $jsapi->SetNonceStr(WxPayApi::getNonceStr());
        $jsapi->SetPackage("prepay_id=" . $result['prepay_id']);
        $jsapi->SetSignType("MD5");
        $jsapi->SetPaySign($jsapi->MakeSign());
        $data = $jsapi->GetValues();

        $msg['errcode'] = 0;
        $msg['data'] = $data;
        return json_encode($msg, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 生成出货数据
     * @param $orderid 订单ID
     * @param $machineid 机器ID
     */
    public function assignShipment($orderid, $machineid){
        $data = M('fruit_order_detail')->where(array('order_id'=>$orderid))->select();
        $len = count($data);
        $lxy =array();
        $a['machine_id'] = $machineid;
        $a['storage'] = array('gt',0);
        for ($i=0;$i<$len;$i++){
            $a['product_id'] = $data[$i]['product_id'];
            $b = M('fruit_location')->where($a)->select();
            $c = count($b);
            $s1 = $data[$i]['product_count'];
            for($j=0;$j<$c;$j++){
                    if($s1 > $b[$j]['storage']){
                        $lxy[$i][$j]['x'] = $b[$j]['location_x'];
                        $lxy[$i][$j]['y'] = $b[$j]['location_y'];
                        $lxy[$i][$j]['count'] = $b[$j]['storage'];
                        $s1 = $s1 - $b[$j]['storage'];
                        M('fruit_location')->where(array('id'=>$b[$j]['id']))->setField(array('storage'=>0));
                        M('fruit_order_shipment')->add(array('order_id'=>$orderid, 'machine_id'=>$machineid, 'location_x'=>$lxy[$i][$j]['x'], 'location_y'=>$lxy[$i][$j]['y'], 'shipment_count'=>$lxy[$i][$j]['count']));
                    }else{
                        $lxy[$i][$j]['x'] = $b[$j]['location_x'];
                        $lxy[$i][$j]['y'] = $b[$j]['location_y'];
                        $lxy[$i][$j]['count'] = $s1;
                        $b[$j]['storage'] = $b[$j]['storage'] - $s1;
                        M('fruit_location')->where(array('id'=>$b[$j]['id']))->setField(array('storage'=>$b[$j]['storage']));
                        M('fruit_order_shipment')->add(array('order_id'=>$orderid, 'machine_id'=>$machineid, 'location_x'=>$lxy[$i][$j]['x'], 'location_y'=>$lxy[$i][$j]['y'], 'shipment_count'=>$lxy[$i][$j]['count']));
                        break;
                    }
            }
        }
    }
    /**
     * 微信支付结果主动查询
     * @return string
     */
    public function queryorder(){
        $order = M('fruit_order')->lock(true)->where(array('id'=>$_GET['orderid']))->find();
        if($order['status'] != 0){
            $data['errcode'] = 0;
            $data['id'] = $order['id'];
            return json_encode($data, JSON_UNESCAPED_UNICODE);
        }

        $queryInput = new WxPayOrderQuery();
        $queryInput->SetOut_trade_no($order['order_number']);

        $result = WxPayApi::orderQuery($queryInput, 30);
        if ($result['return_code'] != 'SUCCESS') {
            $data['errcode'] = 1;
            $data['errmsg'] = $result['return_msg'];
            return json_encode($data, JSON_UNESCAPED_UNICODE);
        }

        if ($result['result_code'] != 'SUCCESS') {
            $data['errcode'] = 1;
            $data['errmsg'] = $result['err_code_des'];
            return json_encode($data, JSON_UNESCAPED_UNICODE);
        }

        if ($result['trade_state'] != 'SUCCESS') {
            $data['errcode'] = 1;
            $data['errmsg'] = $result['trade_state_desc'];
            return json_encode($data, JSON_UNESCAPED_UNICODE);
        }

        Db::startTrans();
        try{
            //更新数据
            M('fruit_order')->where(array('id'=>$_GET['orderid']))->setField(array('status'=>1));
            $this->assignShipment($order['id'], $order['machine_id']);
            Db::commit();
            $data['errcode'] = 0;
            $data['id'] = $order['id'];
            return json_encode($data, JSON_UNESCAPED_UNICODE);
        }catch(\Exception $e){
            Db::rollback();
            $data['errcode'] = 1;
            $data['errmsg'] = $e->getMessage();
            return json_encode($data, JSON_UNESCAPED_UNICODE);
        }
    }

    /**
     * 异步回调
     * @return string
     */
    public function notify() {
        try {
            $xml = $GLOBALS['HTTP_RAW_POST_DATA'];

            // 记录日志
            file_put_contents('notify.log', $xml, FILE_APPEND);

            $wxPayNotifyReply = new WxPayNotifyReply();
            // 如果post数据为空
            if (empty($xml)) {
                $wxPayNotifyReply->SetReturn_code("FAIL");
                echo $wxPayNotifyReply->ToXml();
                die;
            }

            $payResult = WxPayResults::Init($xml);
            // 如果post数据的状态非正确
            if ($payResult['return_code'] != 'SUCCESS' || $payResult['result_code'] != 'SUCCESS') {
                $wxPayNotifyReply->SetReturn_code("FAIL");
                echo $wxPayNotifyReply->ToXml();
                die;
            }

            Db::startTrans();
            $orderSn = $payResult['out_trade_no'];
            $order = M('fruit_order')->lock(true)->where(array('order_number'=>$orderSn))->find();
            if($order['status'] != 0){
                Db::commit();
                $wxPayNotifyReply->SetReturn_code("SUCCESS");
                $wxPayNotifyReply->SetReturn_msg("OK");
                echo $wxPayNotifyReply->ToXml();
                die;
            } else {
                //更新数据
                M('fruit_order')->where(array('order_number'=>$orderSn))->setField(array('status'=>1));
                $this->assignShipment($order['id'], $order['machine_id']);
                Db::commit();
                $wxPayNotifyReply->SetReturn_code("SUCCESS");
                $wxPayNotifyReply->SetReturn_msg("OK");
                echo $wxPayNotifyReply->ToXml();
                die;
            }
        } catch(\Exception $e) {
            $wxPayNotifyReply = new WxPayNotifyReply();
            $wxPayNotifyReply->SetReturn_code("FAIL");
            echo $wxPayNotifyReply->ToXml();
            die;
        }
    }


}
