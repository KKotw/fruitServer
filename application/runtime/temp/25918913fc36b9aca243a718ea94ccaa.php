<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:65:"/var/www/html/fruit_machine/application/cms/view/login/login.html";i:1481021472;}*/ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>CMS登录</title>
		<link href="<?php echo __STATIC__; ?>/cms/css/cms.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo __STATIC__; ?>/cms/css/common.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="<?php echo __STATIC__; ?>/cms/js/00001-jquery-1.7.2.js" ></script>
	</head>

	<body class="background2">
		<div class="cms_login_con">
			<div class="cms_login_con_box">
				<div class="cms_login_con_box_inner">
					<div class="cms_login_con_box_inner_img"><img src="<?php echo __STATIC__; ?>/cms/images/cms_login1.png" /></div>
					<div class="cms_login_con_box_inner_input">
					<form id='dologin' action="<?php echo U('dologin'); ?>" method="POST">
						<div class="cms_login_con_box_inner_input_inner"><input placeholder="User ID" type="text" name="username"></div>
						<div class="cms_login_con_box_inner_input_inner"><input placeholder="Password" type="password" name="password"></div>
					</form>
					</div>
					<div class="cms_login_con_box_inner_btn"><a href="javascript:;" class='submit'><img src="<?php echo __STATIC__; ?>/cms/images/cms_login2.png" /></a></div>
				</div>
			</div>
		</div>
	</body>

</html>
<script>
	$('.submit').click(function(){
		$('#dologin').submit();
	})
</script>