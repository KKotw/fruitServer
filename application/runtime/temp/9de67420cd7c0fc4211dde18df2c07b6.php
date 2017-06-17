<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:67:"/var/www/html/fruit_machine/application/index/view/index/index.html";i:1486694533;}*/ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="initial-scale=1.0,user-scalable=no,maximum-scale=1,width=device-width"/>
    <meta content="telephone=no" name="format-detection"/>
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <meta name="apple-mobile-web-app-status-bar-style" content="black"/>
    <title><?php echo $name; ?></title>
    <link href="<?php echo __STATIC__; ?>/fruit/css/mui.min.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo __STATIC__; ?>/fruit/css/new1.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo __STATIC__; ?>/fruit/css/common.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="<?php echo __STATIC__; ?>/fruit/js/jquery-1.11.0.min.js"></script>
    <script type="text/javascript" src="<?php echo __STATIC__; ?>/fruit/js/jquery.mobile-1.4.5/jquery.mobile-1.4.5.min.js" ></script>
    <script type="text/javascript" src="<?php echo __STATIC__; ?>/fruit/js/mui.min.js"></script>
</head>

<body>
<div class="mobile_outcontainer">
    <div class="mobile_nopadding_container">
        <div class="list_con_popup" id="list_con_popup1" style="display: none;">
            <div class="list_con_popup_inner2">
                <b><img src="<?php echo __STATIC__; ?>/fruit/images/icon7.png"/></b>
                <span>恭喜您，购买成功!</span>
                <a href="javascript:void(0)" class="refresh">确认</a>
            </div>
        </div>
        <div class="list_con_popup" id="list_con_popup" style="display: none;">
            <div class="list_con_popup_inner1">
                <b><img src="<?php echo __STATIC__; ?>/fruit/images/icon8.png"/></b>
                <span id="span"></span>
                <a href="javascript:void(0)" id="sure">确认</a>
            </div>
        </div>
        <div class="list_con_popup" id="list_con_popup2" style="display: none;">
            <div class="list_con_popup_inner1">
                <b><img src="<?php echo __STATIC__; ?>/fruit/images/icon8.png"/></b>
                <a href="javascript:void(0)" style="margin-top: 20px;margin-bottom: 10px;" id="reselect">重新挑选商品</a>
                <a href="javascript:void(0)" class="refresh">放弃支付</a>
            </div>
        </div>
        <div class="list_con">
            <div class="list_con1">
                <div class="list_con1_inner">
                    <em><img src="<?php echo __STATIC__; ?>/fruit/images/icon17.png"/></em>
                    <a href="<?php echo U('Index/help'); ?>" data-ajax="false"><img src="<?php echo __STATIC__; ?>/fruit/images/icon2.png"/></a>
                </div>
            </div>
            <?php if(count($banners) > 0): ?>
            <div id="slider" class="mui-slider">
                <div class="mui-slider-group mui-slider-loop">
                    <!-- 额外增加的一个节点(循环轮播：第一个节点是最后一张轮播) -->
                    <?php if($endBanner != null): ?>
                    <div class="mui-slider-item mui-slider-item-duplicate">
                        <img src="<?php echo $endBanner['img']; ?>"/>
                    </div>
                    <?php endif; ?>
                    <!-- 第一张 -->
                    <?php if(is_array($banners)): $i = 0; $__LIST__ = $banners;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$banner): $mod = ($i % 2 );++$i;?>
                    <div class="mui-slider-item">
                        <img src="<?php echo $banner['img']; ?>"/>
                    </div>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                    <!-- 额外增加的一个节点(循环轮播：第一个节点是最后一张轮播) -->
                    <?php if($firstBanner != null): ?>
                    <div class="mui-slider-item mui-slider-item-duplicate">
                        <img src="<?php echo $firstBanner['img']; ?>"/>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="mui-slider-indicator">
                    <?php if(is_array($banners)): $i = 0; $__LIST__ = $banners;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$banner): $mod = ($i % 2 );++$i;if($i == 1): ?>
                    <div class="mui-indicator mui-active"></div>
                    <?php else: ?>
                    <div class="mui-indicator"></div>
                    <?php endif; endforeach; endif; else: echo "" ;endif; ?>
                </div>
            </div>
            <?php endif; ?>
            <div class="list_con2">
                <ul id="ul">
                    <?php foreach($goods as $g): if(($g['stock'] > 0) and ($g['is_delete'] == 0)): ?>
                    <li>
                        <div class="list_con2_left"><img src="<?php echo $g['img_url']; ?>"/></div>
                        <div class="list_con2_right">
                            <div class="list_con2_right1">
                                <label><?php echo $g['name']; ?></label>
                                <span><?php echo $g['description']; ?></span>
                            </div>
                            <div class="list_con2_right2">
                                <?php if($g['is_sales_promotion']==1): ?><b><img src="<?php echo __STATIC__; ?>/fruit/images/icon11.png"/></b>
                                <em><label class="label_price" style="display: none;"><?php echo $g['promotion_price']; ?></label><span
                                        class="list_con2_color1">￥<?php echo $g['promotion_price']; ?></span><label>￥<?php echo $g['price']; ?></label></em>
                                <?php else: ?><em><label class="label_price"
                                                 style="display: none;"><?php echo $g['price']; ?></label><b></b><span
                                    class="list_con2_color2">￥<?php echo $g['price']; ?></span></em><?php endif; ?>

                            </div>
                        </div>
                        <div class="list_con2_right_num">
                            <a href="javascript:void(0)" style="display: none;" class="minusNum"><img
                                    src="<?php echo __STATIC__; ?>/fruit/images/icon13.png"/></a>
                            <span style="display: none;" class="class_goods_num">0</span>
                            <a href="javascript:void(0)" class="plusNum"><img
                                    src="<?php echo __STATIC__; ?>/fruit/images/icon12.png"/></a>
                            <a href="javascript:void(0)" style="display: none;"><?php echo $g['stock']; ?></a>
                            <a class="goods_id" style="display: none;"><?php echo $g['id']; ?></a>
                        </div>
                    </li>
                    <?php endif; endforeach; ?>

                </ul>
            </div>
        </div>
    </div>
    <div class="footer_fixed_box">
        <div class="footer_fixed_box_inner">
            <div class="footer_fixed_box_inner_content">
                <div class="footer_fixed_box_inner_left">
                    <em><a href="javascript:void(0)"><img src="<?php echo __STATIC__; ?>/fruit/images/icon15.png"/></a><label
                            id="goods_num">0</label></em>
                    <b></b>
                    <span id="price_span">￥0</span>
                    <input type="hidden"  value="<?php echo $m_id; ?>" id="m_id">
                </div>
                <div class="footer_fixed_box_inner_right"><a href="javascript:void(0);">去支付</a></div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    //轮播图
    $(function () {
        var slider = mui("#slider");
        slider.slider({
            interval: 3000
        });
    })

    $('.plusNum').on('tap', function (e) {
        e.preventDefault();
        e.stopPropagation();

        if (parseInt($(this).prev().text()) + 1 > parseInt($(this).next().text())) {
            $("#list_con_popup").show();
            $("#span").html("您选择的商品缺货哦！");
        } else {
            $(this).prev().show();
            var num = $(this).prev();
            num.text(parseInt(num.text()) + 1);
            $(this).parent().find(".minusNum").show();
            setTotal();
        }
    })

    $('.minusNum').on('tap', function (e) {
        e.preventDefault();
        e.stopPropagation();

        var num = $(this).next().text();
        if (num == 1) {
            $(this).next().text(0);
            $(this).next().hide();
            $(this).hide();
        } else {
            num--;
            $(this).next().text(num);
        }
        setTotal();
    })

    function setTotal() {
        var s = 0;
        var n = 0;
        $("#ul li").each(function () {
            s += parseFloat($(this).find('label[class*=label_price]').text()) * parseFloat($(this).find('span[class*=class_goods_num]').text());
            n += parseInt($(this).find('span[class*=goods_num]').text());
        });
        $("#goods_num").text(n);
        $("#price_span").text("￥" + s.toFixed(2));
    }

    //付款
    var submitting = false;
    $('.footer_fixed_box_inner_right').on('tap', function (e) {
        e.preventDefault();
        e.stopPropagation();

        if (!submitting) {
            submitting = true;
            if (parseInt($("#goods_num").html()) == 0) {
                $("#list_con_popup").show();
                $("#span").html("购物车还是空的哟！");
                submitting = false;
            } else {
                $(".footer_fixed_box_inner_right").find("a").text("处理中..");
                $(".footer_fixed_box_inner_right").find("a").css({"background-color":"#808080"});

                var arr = [];
                $(".list_con2_right_num").each(function () {
                    if ($(this).find('span[class*=class_goods_num]').text() > 0) {
                        var obj = {};
                        obj.id = $(this).find('a[class*=goods_id]').text();
                        obj.count = $(this).find('span[class*=class_goods_num]').text();
                        arr.push(obj);
                    }
                })
                var str = JSON.stringify(arr);
                $.ajax({
                    type: 'post',
                    url: "<?php echo U('Index/order'); ?>",
                    data: {data: str,m_id:$("#m_id").val()},
                    dataType: 'JSON',
                    success: function (res) {
                        if (res.low_stock == 0) {
                            $("#list_con_popup").show();
                            $("#span").html("您选择的商品缺货哦！");
                            submitting = false;
                            $(".footer_fixed_box_inner_right").find("a").text("去支付");
                            $(".footer_fixed_box_inner_right").find("a").css({"background-color":"#51baa9"});
                        } else {
                            var msg = '';
                            $.ajax({
                                type: 'GET',
                                url: "<?php echo U('utils/Weixin/unifiedorder'); ?>",
                                data: {orderid: res.id},
                                dataType: 'JSON',
                                success: function (result) {
                                    if (result.errcode == 0) {
                                        msg =
                                        {
                                            'appId': result.data.appId,     //公众号名称，由商户传入
                                            'timeStamp': result.data.timeStamp,         //戳，自1970年以来的秒数
                                            'nonceStr': result.data.nonceStr, //随机串
                                            'package': result.data.package,
                                            'signType': result.data.signType,         //微信签名方式：
                                            'paySign': result.data.paySign //微信签名
                                        };
                                        if (typeof WeixinJSBridge == "undefined") {
                                            if (document.addEventListener) {
                                                document.addEventListener('WeixinJSBridgeReady', onBridgeReady, false);
                                            } else if (document.attachEvent) {
                                                document.attachEvent('WeixinJSBridgeReady', onBridgeReady);
                                                document.attachEvent('onWeixinJSBridgeReady', onBridgeReady);
                                            }
                                        } else {
                                            onBridgeReady();
                                        }
                                    } else {
                                        alert(result.errmsg);
                                    }
                                    submitting = false;
                                    $(".footer_fixed_box_inner_right").find("a").text("去支付");
                                    $(".footer_fixed_box_inner_right").find("a").css({"background-color":"#51baa9"});
                                }

                            });
                            function onBridgeReady() {
                                WeixinJSBridge.invoke(
                                        'getBrandWCPayRequest', msg,
                                        function (ress) {
                                            if (ress.err_msg == "get_brand_wcpay_request:ok") {
                                                $.ajax({
                                                    type: 'GET',
                                                    url: "<?php echo U('utils/Weixin/queryorder'); ?>",
                                                    data: {orderid: res.id},
                                                    dataType: 'JSON',
                                                    success: function (result) {
                                                        if (result.errcode == 0) {
                                                            $("#list_con_popup1").show();
//                                                            $.ajax({
//                                                                type: 'GET',
//                                                                url: "<?php echo U('index/Index/shipment'); ?>",
//                                                                data: {data:JSON.stringify(result.m)},
//                                                                dataType: 'JSON',
//                                                                success:function (resu) {
//                                                                    if(resu.errcode==0){
//                                                                        $("#list_con_popup1").show();
//                                                                    }
//                                                                }
//                                                            })

                                                        } else {
                                                            alert(result.errmsg);
                                                        }
                                                        submitting = false;
                                                        $(".footer_fixed_box_inner_right").find("a").text("去支付");
                                                        $(".footer_fixed_box_inner_right").find("a").css({"background-color":"#51baa9"});
                                                    }
                                                });
                                            }// 使用以上方式判断前端返回,微信团队郑重提示：res.err_msg将在用户支付成功后返回    ok，但并不保证它绝对可靠。
                                            if (ress.err_msg == "get_brand_wcpay_request:fail") {
                                                alert(ress.err_code + ress.err_desc + ress.err_msg);
                                                submitting = false;
                                                $(".footer_fixed_box_inner_right").find("a").text("去支付");
                                                $(".footer_fixed_box_inner_right").find("a").css({"background-color":"#51baa9"});
                                            }     // 使用以上方式判断前端返回,微信团队郑重提示：res.err_msg将在用户支付成功后返回    ok，但并不保证它绝对可靠。
                                            if (ress.err_msg == "get_brand_wcpay_request:cancel") {
                                                $("#list_con_popup2").show();
                                                submitting = false;
                                                $(".footer_fixed_box_inner_right").find("a").text("去支付");
                                                $(".footer_fixed_box_inner_right").find("a").css({"background-color":"#51baa9"});
                                            }
                                        }
                                );
                            }
                        }
                    }
                })
            }
        }
    });

    //提示
    $("#sure").on('tap', function (e) {
        e.preventDefault();
        e.stopPropagation();

        $("#list_con_popup").hide();
    });

    //页面刷新
    $(".refresh").on('tap', function (e) {
        e.preventDefault();
        e.stopPropagation();

        //window.location.reload();
		var t = new Date().getTime();
		window.location.href = "<?php echo C('__SiteUrl__'); ?>index/index/index?t="+t+"&id=" + $("#m_id").val();
    });


    //重新挑选商品
    $("#reselect").on('tap', function (e) {
        e.preventDefault();
        e.stopPropagation();

        $("#list_con_popup2").hide();
    });
</script>
</body>
</html>
