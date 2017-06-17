<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:69:"/var/www/html/fruit_machine/application/cms/view/cms_module/edit.html";i:1481021465;s:81:"/var/www/html/fruit_machine/public/../application/cms/view/layout/new_header.html";i:1481021471;s:81:"/var/www/html/fruit_machine/public/../application/cms/view/layout/new_footer.html";i:1481021471;}*/ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title><?php echo $titleName; ?></title>
		<script type="text/javascript" src="<?php echo __STATIC__; ?>/js/00001-jquery-1.7.2.js" ></script>
        <link href="<?php echo __STATIC__; ?>/cms/css/cms.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo __STATIC__; ?>/cms/css/common.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo __STATIC__; ?>/cms/css/style.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo __STATIC__; ?>/cms/css/style-responsive.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo __STATIC__; ?>/cms/css/table-responsive.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo __STATIC__; ?>/cms/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo __STATIC__; ?>/cms/css/bootstrap-reset.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo __STATIC__; ?>/cms/iCheck/skins/square/blue.css" rel="stylesheet">

		<script src="<?php echo __STATIC__; ?>/cms/js/jquery-1.10.2.min.js"></script>
		<script src="<?php echo __STATIC__; ?>/cms/js/jquery-ui-1.9.2.custom.min.js"></script>
		<script src="<?php echo __STATIC__; ?>/cms/js/jquery-migrate-1.2.1.min.js"></script>
		<script src="<?php echo __STATIC__; ?>/cms/js/bootstrap.min.js"></script>
		<script src="<?php echo __STATIC__; ?>/cms/js/modernizr.min.js"></script>

        <style>
            .table-bordered>tbody>tr>td{
                background-color: #f9f9f9
            }
        </style>

        <!-- 图片上传js -->
		<script src="<?php echo __STATIC__; ?>/jquery-fileupload/js/vendor/jquery.ui.widget.js"></script>
		<script src="<?php echo __STATIC__; ?>/jquery-fileupload/js/vendor/load-image.all.min.js"></script>
		<script src="<?php echo __STATIC__; ?>/jquery-fileupload/js/jquery.iframe-transport.js"></script>
		<script src="<?php echo __STATIC__; ?>/jquery-fileupload/js/jquery.fileupload.js"></script>
		<script src="<?php echo __STATIC__; ?>/jquery-fileupload/js/jquery.fileupload-process.js"></script>
		<script src="<?php echo __STATIC__; ?>/jquery-fileupload/js/jquery.fileupload-image.js"></script>
		<script src="<?php echo __STATIC__; ?>/jquery-fileupload/js/jquery.fileupload-ui.js"></script>
		<script src="<?php echo __STATIC__; ?>/jquery-fileupload/js/jquery.fileupload-validate.js"></script>
		<!-- 图片上传js -->
	    <!--kindeditor CSS JS-->
	    <link rel="stylesheet" href="<?php echo __STATIC__; ?>/kindeditor/themes/default/default.css" />
	    <link rel="stylesheet" href="<?php echo __STATIC__; ?>/kindeditor/plugins/code/prettify.css" />
	    <script src="<?php echo __STATIC__; ?>/kindeditor/kindeditor.js" type="text/javascript"></script>
	    <script src="<?php echo __STATIC__; ?>/kindeditor/lang/zh_CN.js" type="text/javascript"></script>
	    <script src="<?php echo __STATIC__; ?>/kindeditor/plugins/code/prettify.js" type="text/javascript"></script>
	    <!--kindeditor-->

	    <!--datetimepickers CSS JS-->
	    <link rel="stylesheet" type="text/css" href="<?php echo __STATIC__; ?>/js/bootstrap-datepicker/css/datepicker-custom.css" />
	    <link rel="stylesheet" type="text/css" href="<?php echo __STATIC__; ?>/js/bootstrap-datetimepicker/css/datetimepicker-custom.css" />
	    <script type="text/javascript" src="<?php echo __STATIC__; ?>/js/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
	    <script type="text/javascript" src="<?php echo __STATIC__; ?>/js/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>
	    <!--datetimepickers-->

		<!-- caven -->
        <link href="<?php echo __STATIC__; ?>/cms/css/wuzhenhuai.css" rel="stylesheet" type="text/css" />
			
		<!-- 表单验证 -->
        <script type="text/javascript" src="<?php echo __STATIC__; ?>/js/jquery.validate.min.js"></script>

    </head>

	<body <?php if(ACTION_NAME != 'index'): ?> class='background' <?php endif; ?>>
		<div class="cms_left">
			<div class="cms_left_title">
				<b><img src="<?php echo __STATIC__; ?>/cms/images/cms_left_logo.png" /></b>
				<!-- <a href="#"><img src="<?php echo __STATIC__; ?>/cms/images/cms_left_logo2.png" /></a> -->
			</div>

			<div class="cms_left_list  ">
				<?php foreach($moduleArr as $v): $display = 'display:none;' ;$background='';foreach($v['models'] as $vv): if(CONTROLLER_NAME == $vv['modelname']): $display = 'display:block;' ; $background='background:#759ed8;';endif; endforeach; ?>
				<div class="cms_left_list_inner " >
					<div class="cms_left_list_inner1 isShowUL" style="<?php echo $background; ?>">
						<span>
							<img src="<?php echo __STATIC__; ?>/cms/images/cms_menu1.png" /><?php echo $v['name']; ?>
						</span>
						<a href="#">
							<img src="<?php echo __STATIC__; ?>/cms/images/minus.png" />
						</a>
					</div>
					<div class="cms_left_list_inner2 sub-menu-list showUL" style='<?php echo $display; ?>'>
						<ul class="sub-menu-list">
							<?php foreach($v['models'] as $vv): ?>
							<li <?php if(CONTROLLER_NAME == $vv['modelname']): ?> class="active"<?php endif; ?>>
								<?php echo $vv['url']; ?>
							</li>
							<?php endforeach; ?>
						</ul>
					</div>
				</div>
				<?php endforeach; ?>
			</div>
		</div>
		<div class="cms_right">
			<div class="cms_right_top">
			<div class="cms_right_title">
				<div class="cms_right_title_left"><img src="<?php echo __STATIC__; ?>/cms/images/cms_right_img1.png" /><?php echo $titleName; ?></div>
				<div class="cms_right_title_right">
					<div class="cms_right_title_right1">
						<b><img src="<?php echo __STATIC__; ?>/cms/images/logo_name1.png" /></b>
						<a href="javascrpt:;" class='showLoginout'>eric<img src="<?php echo __STATIC__; ?>/cms/images/cms_right_img2.png" /></a>
					</div>
					<div class="cms_right_title_right2 loginout" style="display:none" >
						<b><img src="<?php echo __STATIC__; ?>/cms/images/cms_right_img4.png" /></b>
						<a href="<?php echo U('cms/login/loginout'); ?>">登出</a>
						<span><img src="<?php echo __STATIC__; ?>/cms/images/cms_right_img3.png" /></span>
					</div>
				</div>
			</div>
<script>
	$('.isShowUL').click(function(){

		if($(this).next().css('display')=='block'){
			// $(this).next().css('display','none');
			$('.showUL').css('display','none');
			$('.isShowUL').find('a').find('img').attr('src','<?php echo __STATIC__; ?>/cms/images/plus.png')
		}else{
			$('.showUL').css('display','none');
			$('.isShowUL').css('background-color','');
			$('.isShowUL').find('a').find('img').attr('src','<?php echo __STATIC__; ?>/cms/images/plus.png')
			$(this).find('a').find('img').attr('src','<?php echo __STATIC__; ?>/cms/images/minus.png')
			$(this).next().css('display','block');
			$(this).css('background-color','#759ed8');
		}
	})

	$('.showLoginout').click(function(){
		if($('.loginout').css('display')=='block'){
			$('.loginout').css('display','none');
		}else{
			$('.loginout').css('display','block');
		}
	})
</script>
            <div class="cms_right_box1">
                <label>编辑大模块</label>
            </div>
            <div class="cms_right_box2">
                <div class="cms_right_box2_write">
                    <form id="editFrom" action="<?php echo U('edit',array('id'=>$_GET['id'])); ?>" method="post">
                    <div class="cms_right_box2_write_inner">
                        <div class="cms_right_box2_write_group1">
                            <label>名称</label>
                            <div class="cms_right_box2_write_group1_inner1"><input  id="name" name="name" type="text" value="<?php echo (isset($info['name']) && ($info['name'] !== '')?$info['name']:''); ?>" /></div>
                        </div>

                        <div class="cms_right_box2_write_group1">
                            <label>状态</label>
                            <div class="cms_right_box2_write_group1_inner1">
                                <select id='status' name = 'status'>
                                        <option value="0" <?php echo ($info['status']==0)?'selected' : ''; ?>>正常</option>
                                        <option value="4" <?php echo ($info['status']==4)?'selected' : ''; ?>>删除</option>
                                </select>
                            </div>
                        </div>

                        <div class="cms_right_box2_write_group1 write_group_btn">
                            <a href="javascript:;" id="saveBtn">保存</a>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        
		
		
		<script src="<?php echo __STATIC__; ?>/cms/js/jquery.nicescroll.js"></script>
		<script src="<?php echo __STATIC__; ?>/cms/js/scripts.js"></script>
		<script src="<?php echo __STATIC__; ?>/cms/iCheck/jquery.icheck.js"></script>
		<script src="<?php echo __STATIC__; ?>/cms/js/icheck-init.js"></script>

		<script>
			$(document).ready(function(){
				var screenHeight = $(window).height();//获取屏幕可视区域的高度。
				var divHeight = $(".cms_right_box2_bottom").height() + 1;//bottomDiv的高度再加上它一像素的边框。
				var divHeight2 = $(".cms_right_top").height();
				if(document.documentElement.clientHeight < document.documentElement.offsetHeight){
					$(".cms_right_box2_bottom").css("margin-top",0);
				}else{
					$(".cms_right_box2_bottom").css("margin-top",screenHeight - divHeight-divHeight2-30);
				}
				
			})
		</script>
	</body>

</html>

<!-- 一些js -->
    <script type="text/javascript">
        $(function(){

            // 保存事件绑定
            initSaveBtn();

        });
        /**
         * 保存按钮绑定
         */
        function initSaveBtn() {
            $("#saveBtn").bind("click", function(){
                if ($("#editFrom").valid()) {
 
                    $("#editFrom").submit();
                }
            });
        }
    </script>