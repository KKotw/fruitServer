<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:73:"/var/www/html/fruit_machine/application/cms/view/fruit_location/edit.html";i:1481021468;s:81:"/var/www/html/fruit_machine/public/../application/cms/view/layout/new_header.html";i:1481021471;s:81:"/var/www/html/fruit_machine/public/../application/cms/view/layout/new_footer.html";i:1481021471;}*/ ?>
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
<script type="text/javascript" src="http://api.map.baidu.com/api?v=1.4"></script>

            <div class="cms_right_box1">
                <label>编辑货架商品位置</label>
            </div>
            <div class="cms_right_box2">
                <div class="cms_right_box2_write">
                    <div class="cms_right_box2_write_inner">
                        <form class="cmxform form-horizontal adminex-form" id="editForm" action="<?php echo U('edit',array('id'=>$_GET['id'])); ?>" method="post">
<!-- 外键默认下拉展示 -->
                        <div class="cms_right_box2_write_group1">
                            <label><span style="color:red">*</span>所属货架名称</label>
                            <div class="cms_right_box2_write_group1_inner1">   
                                <select id='machine_id' name = 'machine_id'>
                                    <?php echo getfkarr('id,name,is_delete','fruit_machine','',$arr); if(isset($arr)): foreach($arr as $k=>$list): if($list['is_delete']==0): ?>
                                        <option value="<?php echo $list['id']; ?>" <?php echo ($list['id']==$info['machine_id'])?'selected' : ''; ?> ><?php echo $list['name']; ?></option>
                                        <?php endif; endforeach; endif; ?>
                                </select>
                            </div>
                        </div> 
<!-- 外键默认下拉展示 -->
                        <div class="cms_right_box2_write_group1">
                            <label><span style="color:red">*</span>商品名称</label>
                            <div class="cms_right_box2_write_group1_inner1">   
                                <select id='product_id' name = 'product_id'>
                                    <?php echo getfkarr('id,name,is_delete','fruit_product','',$arr); if(isset($arr)): foreach($arr as $k=>$list): if($list['is_delete']==0): ?>
                                        <option value="<?php echo $list['id']; ?>" <?php echo ($list['id']==$info['product_id'])?'selected' : ''; ?> ><?php echo $list['name']; ?></option>
                                        <?php endif; endforeach; endif; ?>
                                </select>
                            </div>
                        </div> 
                        <div class="cms_right_box2_write_group1">
                            <label><span style="color:red">*</span>位置横坐标</label>
                            <div class="cms_right_box2_write_group1_inner1">        
                                <input id="location_x" name="location_x" type="number" value="<?php echo (isset($info['location_x']) && ($info['location_x'] !== '')?$info['location_x']:''); ?>" />
                            </div>
                        </div>
                        <div class="cms_right_box2_write_group1">
                            <label><span style="color:red">*</span>位置纵坐标</label>
                            <div class="cms_right_box2_write_group1_inner1">        
                                <input id="location_y" name="location_y" type="number" value="<?php echo (isset($info['location_y']) && ($info['location_y'] !== '')?$info['location_y']:''); ?>" />
                            </div>
                        </div>
                        <div class="cms_right_box2_write_group1">
                            <label><span style="color:red">*</span>库存数量</label>
                            <div class="cms_right_box2_write_group1_inner1">        
                                <input id="storage" name="storage" type="number" value="<?php echo (isset($info['storage']) && ($info['storage'] !== '')?$info['storage']:''); ?>" />
                            </div>
                        </div>

                        <div class="cms_right_box2_write_group1 write_group_btn">
                            <a href="javascript:;" id="saveBtn">保存</a>
                        </div>

                        </form>
                    </div>
                </section>
            </div>
        </div>
    </div>


    <script type="text/javascript">
        var editor;
        $(function(){
            // 时间控件初始化
            initDateTimePickers();

            // 保存事件绑定
            initSaveBtn();

            // form验证初始化
            initValidate();


        });

        /**
         * 初始化时间控件
         */
        function initDateTimePickers(field) {
            $("#"+field).datetimepicker({
                format: "yyyy-mm-dd hh:ii",
                autoclose: true,
                todayBtn: true,
                startDate: "2016-01-01 10:00"
            });
            $("#"+field+"Reset").click(function(){
                $("#"+field).val("");
            });
            $("#"+field+"Set").click(function(){
                $("#"+field).datetimepicker('show');
            });
        }

        /**
         * 文件上传框初始化
         */
        function initFileUpload(fieldClick,fieldUp,fieldValue,fieldView){
            $(fieldClick).bind("click", function(){
                return $(fieldUp).click();
            });

            $(fieldUp).fileupload({
                autoUpload:true,
                url:'<?php echo U("upload/fileupload"); ?>?photodir=fruit_location',
                dataType:'json',
                acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
                maxFileSize: 5000000,
                added:function(e,data){
                  if (data.files.error) {
                      alert(data.files[0].error);
                      return false;
                  }
                },
                done:function(e,data){
                  $(fieldView).attr('src', data.result.url);
                  $(fieldValue).attr('value',data.result.url);
                }
            });        
        }
        
        /**
         * 富文本框初始化
         */
        function initKindEditor(field) {
            KindEditor.ready(function(K) {
                editor = K.create('#'+field, {
                    resizeType : 1,
                    allowPreviewEmoticons : false,
                    allowImageUpload : true,
                    uploadJson : '<?php echo U("upload/kindEditorUpload"); ?>?photodir=fruit_location_text',
                    height:350,
                    width:'100%',
                    items : [
                        'source','undo','clearhtml','hr',
                        'removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist',
                        'insertunorderedlist', '|', 'emoticons', 'image','link', 'unlink','baidumap','lineheight','table','anchor','preview','print','template','code','cut']
                });
            });
        }

        /**
         * 表单验证初始化
         */
        function initValidate() {
              // 手机号码验证
              jQuery.validator.addMethod("isPhone", function(value, element) {
                var length = value.length;
                return this.optional(element) || (length == 11 && /^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1}))+\d{8})$/.test(value));
              }, "请正确填写您的手机号码。");
              
            $("#editForm").validate({
                rules: {

                },
                messages: {
                }
            });
        }
        /**
         * 保存按钮绑定
         */
        function initSaveBtn() {
            $("#saveBtn").bind("click", function(){
                if ($("#editForm").valid()) {
                    if($('#machine_id').val()==''){
                        alert('请输入货架ID');
                        return false;
                    }
                    if($('#product_id').val()==''){
                        alert('请输入商品ID');
                        return false;
                    }
                    if($('#location_x').val()==''){
                        alert('请输入位置横坐标');
                        return false;
                    }
                    if($('#location_y').val()==''){
                        alert('请输入位置纵坐标');
                        return false;
                    }
                    if($('#storage').val()==''){
                        alert('请输入库存数量');
                        return false;
                    }
                    $("#editForm").submit();
                }
            });
        }
        function initAddLineBtn(field) {
            $(".addLineBtn"+field).click(function(){
                $("#editForm ."+field+"selectionLine").last().after($(addNewLine(field)));
                var num = Math.floor(Math.random()*10000+1);
                var up = field + 'Up' + num;
                var click = field + 'Click' + num;
                var view = field + 'View' + num;
                var value = field + 'Value' + num;
                $('#editForm .'+field+'selectionLine').last().children().first().attr('id',up);
                $('#editForm .'+field+'selectionLine').last().children('.cms_right_box2_write_group1_inner5').find('span').find('input').attr('id',value);
                $('#editForm .'+field+'selectionLine').last().children('.cms_right_box2_write_group1_inner5').find('span').find('a').attr('id',click);
                $('#editForm .'+field+'selectionLine').last().children('.cms_right_box2_write_group1_inner5').find('b').find('img').attr('id',view);
                initFileUpload('#'+click,'#'+up,'#'+value,'#'+view);
            });
        }
        function addNewLine(field) {
            var selectionLine = $("#"+field+"selectionTemplate").children().clone(true);
            $(selectionLine).show();
            $(selectionLine).removeAttr("id");
            $(selectionLine).addClass(field+'selectionLine');
            return selectionLine;
        }
        function initDeleteLineBtn(field) {
            $(".deleteLineBtn"+field).click(function(){
                var selectionLine = $("#editForm").find("div."+field+"selectionLine");
                if (selectionLine.length > 1) {
                    $(this).parents("div."+field+"selectionLine").remove();
                } else { 
                    $(this).parents("div."+field+"selectionLine").children('.cms_right_box2_write_group1_inner5').find('b').find('img').attr("src",'');
                    $(this).parents("div."+field+"selectionLine").find("input").val("");
                }
            });
        }

    </script>
   		
		
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