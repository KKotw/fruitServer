<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<script language="javascript" type="text/javascript" src="./static/energy/js/00001-jquery-1.7.2.js"></script>
<script type="text/javascript">
    $(function(){
        var msg;
        $.ajax({
            type:'GET',
            url:"./index.php/utils/weixin/unifiedorder?orderid=" + <?php echo($_GET['orderid'])?>,
            dataType:'json',
            success:function(result){
                if (result.errcode == 0) {
                    msg =
                    {
                        'appId' :  result.data.appId,     //公众号名称，由商户传入
                        'timeStamp': result.data.timeStamp,         //戳，自1970年以来的秒数
                        'nonceStr' :  result.data.nonceStr, //随机串
                        'package' :  result.data.package,
                        'signType' :  result.data.signType,         //微信签名方式：
                        'paySign' : result.data.paySign //微信签名
                    };

                    if (typeof WeixinJSBridge == "undefined"){
                        if( document.addEventListener ){
                            document.addEventListener('WeixinJSBridgeReady', onBridgeReady, false);
                        }else if (document.attachEvent){
                            document.attachEvent('WeixinJSBridgeReady', onBridgeReady);
                            document.attachEvent('onWeixinJSBridgeReady', onBridgeReady);
                        }
                    }else{
                        onBridgeReady();
                    }
                } else {
                    alert(result.errmsg);
                }
            }
        });

        function onBridgeReady(){
            WeixinJSBridge.invoke(
                'getBrandWCPayRequest',msg,
                function(res){
                    if(res.err_msg == "get_brand_wcpay_request:ok" ) {
                        $.ajax({
                            type:'GET',
                            url:"./index.php/utils/weixin/queryorder?orderid=" + <?php echo($_GET['orderid'])?>,
                            dataType:'json',
                            success:function(result){
                                if (result.errcode == 0) {
                                    window.location.href = "./index.php/index/activity/paySuccess?activityid=" + result.activityid;
                                } else {
                                    alert(result.errmsg);
                                }
                            }
                        });
                    }
                    if(res.err_msg == "get_brand_wcpay_request:fail" ) {alert(res.err_code+res.err_desc+res.err_msg);}     // 使用以上方式判断前端返回,微信团队郑重提示：res.err_msg将在用户支付成功后返回    ok，但并不保证它绝对可靠。
                    if(res.err_msg == "get_brand_wcpay_request:cancel" ) {alert('cancel')}     // 使用以上方式判断前端返回,微信团队郑重提示：res.err_msg将在用户支付成功后返回    ok，但并不保证它绝对可靠。
                }
            );
        }
    })
</script>