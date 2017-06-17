<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:70:"/var/www/html/fruit_machine/application/cms/view/fruit_user/index.html";i:1481021471;s:81:"/var/www/html/fruit_machine/public/../application/cms/view/layout/new_header.html";i:1481021471;s:80:"/var/www/html/fruit_machine/public/../application/cms/view/layout/new_pager.html";i:1481021471;s:81:"/var/www/html/fruit_machine/public/../application/cms/view/layout/new_footer.html";i:1481021471;}*/ ?>
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
                <form id="searchFrom" action='<?php echo U("index"); ?>' method='get'>

                    
                    <input type="hidden" name='pageSize' id='setPageSize'>
                    <label>用户列表：</label>
                    <div class="cms_right_box1_inner">
                        <em><span>ID</span><input name="id" value='<?php echo (isset($searchCnd['id']) && ($searchCnd['id'] !== '')?$searchCnd['id']:""); ?>'></em>
                </div>
                    
                </form>
                    
                <b>
                    <a href="javascript:;" class='submit' style="background: #70c4e8;">查找</a>
                    <a href="javascript:;" id="resetval">清空</a>
                </b>
            </div>

        <div class="cms_right_box2">

            <div class="cms_right_box2_title">
  
                <div class="cms_right_box2_title_right"><a href="javascript:;" class='toexcel'><img src="<?php echo __STATIC__; ?>/cms/images/down.png" />导出Excel</a></div>
                
            </div>


            <div class="cms_right_box2_table">
                <section class="panel">
                    <div class="panel-body">
                        <section id="no-more-tables">
                            <table class="table table-bordered table-striped table-condensed cf table-hover">
                                <thead class="cf">
                                <tr>
                                    <th style="border-bottom: 1px solid #ddd;border-right: 1px solid #ddd;">ID</th>
                                    <th style="border-bottom: 1px solid #ddd;border-right: 1px solid #ddd;">微信用户openid</th>
                                    <th style="border-bottom: 1px solid #ddd;border-right: 1px solid #ddd;">微信用户昵称</th>
                                    <th style="border-bottom: 1px solid #ddd;border-right: 1px solid #ddd;">微信用户性别</th>
                                    <th style="border-bottom: 1px solid #ddd;border-right: 1px solid #ddd;">微信用户头像地址</th>
                                    <th style="border-bottom: 1px solid #ddd;border-right: 1px solid #ddd;">微信用户填写的省份</th>
                                    <th style="border-bottom: 1px solid #ddd;border-right: 1px solid #ddd;">微信用户填写的城市</th>
                                    <th style="border-bottom: 1px solid #ddd;border-right: 1px solid #ddd;">微信用户填写的国家</th>
                                    <th style="border-bottom: 1px solid #ddd;border-right: 1px solid #ddd;">创建时间</th>
                                    <th class="width_limit" style="border-bottom: 1px solid #ddd;border-right: 1px solid #ddd;width:160px">操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach($arr as $k=>$list): ?>
                                <tr>
                                    <td data-title="ID" title="<?php echo $list['id']; ?>"><?php echo $list['id']; ?>&nbsp;</td>
                                    <td data-title="微信用户openid" title="<?php echo $list['openid']; ?>"><?php echo $list['openid']; ?>&nbsp;</td>
                                    <td data-title="微信用户昵称" title="<?php echo $list['nickname']; ?>"><?php echo $list['nickname']; ?>&nbsp;</td>
                                    <?php if($list['sex']==1): ?>
                                    <td data-title="微信用户性别，1:男，2:女，0:未知" title="<?php echo $list['sex']; ?>">男&nbsp;</td>
                                    <?php else: ?>
                                    <td data-title="微信用户性别，1:男，2:女，0:未知" title="<?php echo $list['sex']; ?>">女&nbsp;</td>
                                    <?php endif; ?>
                                    <td data-title="微信用户头像地址" title="<?php echo $list['headimgurl']; ?>"><?php echo $list['headimgurl']; ?>&nbsp;</td>
                                    <td data-title="微信用户填写的省份" title="<?php echo $list['province']; ?>"><?php echo $list['province']; ?>&nbsp;</td>
                                    <td data-title="微信用户填写的城市" title="<?php echo $list['city']; ?>"><?php echo $list['city']; ?>&nbsp;</td>
                                    <td data-title="微信用户填写的国家" title="<?php echo $list['country']; ?>"><?php echo $list['country']; ?>&nbsp;</td>
                                    <td data-title="创建时间" title="<?php echo $list['createtime']; ?>"><?php echo $list['createtime']; ?>&nbsp;</td>
                                    <td class="width_limit" data-title="操作" style="height: 40px;">
                                        <a  href="<?php echo U('info',array('id'=>$list['id'])); ?>" class="cms_list_detail" title='详情'></a>
                                       <!-- <a href="<?php echo U('edit',array('id'=>$list['id'])); ?>" class="cms_list_edit" title='编辑'></a>-->
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </section>
                    </div>
                </section>

                </div>
            </div>
        </div>        
        
            <div class="cms_right_box2_bottom">
            <div class="cms_right_box2_bottom_left">
            <select  id="pageSize" name='pageSize'>
                <option value="25" <?php if($pageSize == '25'): ?>selected<?php endif; ?>>25</option>
                <option value="50" <?php if($pageSize == '50'): ?>selected<?php endif; ?>>50</option>
                <option value="100" <?php if($pageSize == '100'): ?>selected<?php endif; ?>>100</option>
            </select>
                <span>当前页面显示</span>
            </div>
            <?php if($pager['totalPage'] > 0): ?>
            <div class="cms_right_box2_bottom_right">
                <ul>
                    <?php if($pager['currentPage'] <= 1): ?>
                    <li><a href="javascript:void(0);" class="cms_page_prev"><img src="<?php echo __STATIC__; ?>/cms/images/cms_page_prev.png" /></a></li>
                    <?php else: ?>
                    <li><a href="<?php echo $pager['url']; ?>&page=<?php echo $pager['prevPage']; ?>" class="cms_page_prev"><img src="<?php echo __STATIC__; ?>/cms/images/cms_page_prev.png" /></a></li>
                    <?php endif; if(is_array($pager['lists'])): $i = 0; $__LIST__ = $pager['lists'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?>
                    <li ><a href="<?php echo $pager['url']; ?>&page=<?php echo $list['index']; ?>" class="cms_page_num <?php if($list['index'] == $pager['currentPage']): ?>active<?php endif; ?>"><?php echo $list['index']; ?></a></li>
                    <?php endforeach; endif; else: echo "" ;endif; if($pager['currentPage'] >= $pager['totalPage']): ?>
                    <li><a href="javascript:void(0);" class="cms_page_next"><img src="<?php echo __STATIC__; ?>/cms/images/cms_page_next.png" /></a></li>
                    <?php else: ?>
                    <li><a href="<?php echo $pager['url']; ?>&page=<?php echo $pager['nextPage']; ?>" class="cms_page_next"><img src="<?php echo __STATIC__; ?>/cms/images/cms_page_next.png" /></a></li>
                    <?php endif; ?>
                    
                </ul>
            </div>
            <?php endif; ?>
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


<script>
    $(function(){
        $('.submit').click(function(){
            
            pageSize = $('#pageSize[name="pageSize"]').val();
            $('#setPageSize').val(pageSize);
            return $('#searchFrom').submit();
        })
        $('#resetval').click(function(){
            $('#searchFrom').find('input').val('');
            $('#searchFrom').find('select').val('');
            $('#pageSize[name="pageSize"]').val('25');
            
        })

        inittoexcel();
    })
    function initDateTimePickers(field) {
            $("#"+field).datetimepicker({
                format: "yyyy-mm-dd hh:ii",
                autoclose: true,
                todayBtn: true,
                startDate: "2016-01-01 10:00"
            });
            $("#starttimeReset").click(function(){
                $("#"+field).val("");
            });
            $("#starttimeSet").click(function(){
                $("#"+field).datetimepicker('show');
            });
            $("#"+field+"1").datetimepicker({
                format: "yyyy-mm-dd hh:ii",
                autoclose: true,
                todayBtn: true,
                startDate: "2016-01-01 10:00"
            });
            $("#starttimeReset").click(function(){
                $("#"+field+"1").val("");
            });
            $("#starttimeSet").click(function(){
                $("#"+field+"1").datetimepicker('show');
            });
    }
    function inittoexcel(){
        $('.toexcel').click(function(){
            $("#searchFrom").prepend("<input id='gotoexcel' name='toexcel' value='1' type='hidden' >");
            $('#searchFrom').attr('action','<?php echo U('excel'); ?>');
            $('#searchFrom').submit();
            $('#searchFrom').attr('action','<?php echo U('index'); ?>')
            $('#gotoexcel').remove();
        })
    }

</script>
