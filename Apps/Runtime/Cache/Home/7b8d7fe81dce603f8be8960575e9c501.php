<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
         <title>买家中心 - <?php echo ($CONF['mallTitle']); ?></title>
         <meta name="keywords" content="<?php echo ($CONF['mallKeywords']); ?>" />
      	<meta name="description" content="<?php echo ($CONF['mallDesc']); ?>,买家中心" />
         <meta http-equiv="Expires" content="0">
		 <meta http-equiv="Pragma" content="no-cache">
		 <meta http-equiv="Cache-control" content="no-cache">
		 <meta http-equiv="Cache" content="no-cache">
         <link rel="stylesheet" href="/mineop/1/wstmall/Apps/Home/View/default/css/common.css" />
         <link rel="stylesheet" href="/mineop/1/wstmall/Apps/Home/View/default/css/user.css">
    </head>
	<?php echo WSTLoginTarget(0);?>
    <body>
        <div class="wst-wrap">
          <div class='wst-header'>
          <script src="/mineop/1/wstmall/Public/js/jquery.min.js"></script>
<script src="/mineop/1/wstmall/Public/plugins/lazyload/jquery.lazyload.min.js?v=1.9.1"></script>
<script type="text/javascript">
var ThinkPHP = window.Think = {
        "ROOT"   : "/mineop/1/wstmall",
        "APP"    : "/mineop/1/wstmall/index.php",
        "PUBLIC" : "/mineop/1/wstmall/Public",
        "DEEP"   : "<?php echo C('URL_PATHINFO_DEPR');?>",
        "MODEL"  : ["<?php echo C('URL_MODEL');?>", "<?php echo C('URL_CASE_INSENSITIVE');?>", "<?php echo C('URL_HTML_SUFFIX');?>"],
        "VAR"    : ["<?php echo C('VAR_MODULE');?>", "<?php echo C('VAR_CONTROLLER');?>", "<?php echo C('VAR_ACTION');?>"]
}
    var domainURL = "<?php echo WSTDomain();?>";
    var publicurl = "/mineop/1/wstmall/Public";
    var currCityId = "<?php echo ($currArea['areaId']); ?>";
    var currCityName = "<?php echo ($currArea['areaName']); ?>";
    var currDefaultImg = "<?php echo WSTDomain();?>/<?php echo ($CONF['goodsImg']); ?>";
    $(function() {
      $("img").lazyload({ effect: "fadeIn",failurelimit : 10,threshold: 200,placeholder:currDefaultImg});
    });
</script>
<script src="/mineop/1/wstmall/Public/js/think.js"></script>
<div id="wst-shortcut">
	<div class="w">
		<ul class="fl lh">
			<li class="fore1 ld"><b></b><a href="javascript:addToFavorite()"
				rel="nofollow">收藏<?php echo ($CONF['mallName']); ?></a></li><s></s>
			<li class="fore3 ld menu" id="app-jd" data-widget="dropdown">
				<span class="outline"></span> <span class="blank"></span> 
				<a href="#" target="_blank"><img src="/mineop/1/wstmall/Apps/Home/View/default/images/icon_top_02.png"/>&nbsp;<?php echo ($CONF['mallName']); ?> 手机版</a>
			</li>
			<li class="fore4" id="biz-service" data-widget="dropdown" style='padding:0;'>&nbsp;<s></s>&nbsp;&nbsp;&nbsp;
				所在城市
				【<span class='wst-city'>&nbsp;<?php echo ($currArea["areaName"]); ?>&nbsp;</span>】
				<img src="/mineop/1/wstmall/Apps/Home/View/default/images/icon_top_03.png"/>	
				&nbsp;&nbsp;<a href="javascript:;" onclick="changeCity();">切换城市</a><i class="triangle"></i>
			</li>
		</ul>
	
		<ul class="fr lh" style='float:right;'>
			<li class="fore1" id="loginbar"><a href="<?php echo U('Home/Orders/queryByPage');?>"><span style='color:blue'><?php echo ($WST_USER['loginName']); ?></span></a> 欢迎您来到 <a href='<?php echo WSTDomain();?>'><?php echo ($CONF['mallName']); ?></a>！<s></s>&nbsp;
			<span>
				<?php if(!$WST_USER['userId']): ?><a href="<?php echo U('Home/Users/login');?>">[登录]</a>
				<a href="<?php echo U('Home/Users/regist');?>"	class="link-regist">[免费注册]</a><?php endif; ?>
				<?php if($WST_USER['userId'] > 0): ?><a href="javascript:logout();">[退出]</a><?php endif; ?>
			</span>
			</li>
			<li class="fore2 ld"><s></s>
			<?php if(session('WST_USER.userId')>0){ ?>
				<?php if(session('WST_USER.userType')==0){ ?>
				    <a href="<?php echo U('Home/Shops/toOpenShopByUser');?>" rel="nofollow">我要开店</a>
				<?php }else{ ?>
				    <?php if(session('WST_USER.loginTarget')==0){ ?>
				        <a href="<?php echo U('Home/Shops/index');?>" rel="nofollow">卖家中心</a>
				    <?php }else{ ?>
				        <a href="<?php echo U('Home/Users/index');?>" rel="nofollow">买家中心</a>
				    <?php } ?>
				<?php } ?>
			<?php }else{ ?>
			    <a href="<?php echo U('Home/Shops/toOpenShop');?>" rel="nofollow">我要开店</a>
			<?php } ?>
			</li>
		</ul>
		<span class="clr"></span>
	</div>
</div>

          <div class='wst-user-top'>
			<div class="wst-user-top-main">
					<div class='wst-user-top-logo'>
						<a href="<?php echo WSTDomain();?>"  title='商城首页'>
						<img src="<?php echo WSTDomain();?>/<?php echo ($CONF['mallLogo']); ?>" height="132" width='240'/>	
						</a>
					</div>
					<div class='wst-user-top-search'>
						<div class="search-box">
							<input id="wst-search-type" type="hidden" value="1"/>
							<input id="keyword" class="wst-search-ipt" me="q" tabindex="9" placeholder="搜索 商品" autocomplete="off" >
							<div id="btnsch" class="wst-search-btn">搜&nbsp;索</div>
						</div>
					</div>
					
				</div>
			</div>
			<div class="wst-shop-nav">
				<div class="wst-nav-box">
					<li class="liselect"><a href="<?php echo U('Home/Orders/queryByPage');?>">买家首页</a></li>
					<div class="wst-clear"></div>
				</div>
			</div>
          </div>
          <div class='wst-nav'></div>
          <div class='wst-main'>
            <div class='wst-menu'>
            <span class='wst-menu-title' style='border-top:0px;'><span></span>交易信息</span>
            
               <a href="<?php echo U('Home/Orders/queryPayByPage/');?>"><li <?php if($umark == "queryPayByPage"): ?>class='selected'<?php endif; ?>>待付款订单</li></a>
               <a href="<?php echo U('Home/Orders/queryDeliveryByPage/');?>"><li <?php if($umark == "queryDeliveryByPage"): ?>class='selected'<?php endif; ?>>待发货订单</li></a>
               <a href="<?php echo U('Home/Orders/queryReceiveByPage/');?>"><li <?php if($umark == "queryReceiveByPage"): ?>class='selected'<?php endif; ?>>待确认收货</li></a>
               <a href="<?php echo U('Home/Orders/queryAppraiseByPage/');?>"><li <?php if($umark == "queryAppraiseByPage"): ?>class='selected'<?php endif; ?>>待评价交易</li></a>
               <a href="<?php echo U('Home/Orders/queryCancelOrders/');?>"><li <?php if($umark == "queryCancelOrders"): ?>class='selected'<?php endif; ?>>已取消订单</li></a>
               <span class='wst-menu-title'><span></span>交易操作</span>
           
               <!-- a href="<?php echo U('Home/Orders/queryByPage/');?>"><li <?php if($umark == "queryByPage"): ?>class='selected'<?php endif; ?>>我的订单</li></a-->
               <a href="<?php echo U('Home/Orders/queryRefundByPage/');?>"><li <?php if($umark == "queryRefundByPage"): ?>class='selected'<?php endif; ?>>拒收/退款</li></a>
               <a href="<?php echo U('Home/UserAddress/queryByPage/');?>"><li <?php if($umark == "addressQueryByPage"): ?>class='selected'<?php endif; ?>>收货地址</li></a>
               <a  href="<?php echo U('Home/GoodsAppraises/getAppraisesList/');?>"><li <?php if($umark == "getAppraisesList"): ?>class='selected'<?php endif; ?>>评价管理</li></a>
               <a href="<?php echo U('Home/Messages/queryByPage/');?>"><li <?php if($umark == "queryMessageByPage"): ?>class='liselect'<?php endif; ?>>商城消息</li></a>
               <a href="<?php echo U('Home/Users/toEdit/');?>"><li <?php if($umark == "toEditUser"): ?>class='selected'<?php endif; ?>>个人资料</li></a>
               <a href="<?php echo U('Home/Users/toEditPass/');?>"><li <?php if($umark == "toEditPass"): ?>class='selected'<?php endif; ?>>修改密码</li></a>
               <a href="<?php echo U('Home/Users/user_verify/');?>"><li <?php if($umark == "user_verify"): ?>class='selected'<?php endif; ?>>申请认证</li></a>
             <?php if($WST_USER["userType"] == 0): ?><div class="wst-appsaler">
				<div>您目前不是卖家，您可以</div>
				<div><a href="<?php echo U('Home/Shops/toOpenShopByUser/');?>"><img src="/mineop/1/wstmall/Apps/Home/View/default/images/btn_setshop.png" height="38" width="134" /></a></div>
			 </div><?php endif; ?>
            </div>
            <div class='wst-content'>
            
<script>
$(function () {
	   $.formValidator.initConfig({
		   theme:'Default',mode:'AutoTip',formID:"myform",debug:true,submitOnce:true,onSuccess:function(){
				   editUser();
			       return false;
			},onError:function(msg){
		}});
	   $("#userName").formValidator({onShow:"",onFocus:"",onCorrect:"输入正确"}).inputValidator({min:6,max:20,onError:"用户昵称长度为6到20位"});
	   $("#userPhone").inputValidator({min:0,max:25,onError:"你输入的手机号码非法,请确认"}).regexValidator({
			regExp:"mobile",dataType:"enum",onError:"手机号码格式错误"
		}).ajaxValidator({
			dataType : "json",
			async : true,
			url : Think.U('Home/Users/checkLoginKey'),
			success : function(data){
				var json = WST.toJson(data);
	            if( json.status == "1" ) {
	                return true;
				} else {
	                return false;
				}
				return "该手机号码已被使用";
			},
			buttons: $("#dosubmit"),
			onError : "该手机号码已存在。",
			onWait : "请稍候..."
		}).defaultPassed().unFormValidator(true);
		$("#userEmail").inputValidator({min:0,max:25,onError:"你输入的邮箱长度非法,请确认"}).regexValidator({
		       regExp:"email",dataType:"enum",onError:"邮箱格式错误"
			}).ajaxValidator({
				dataType : "json",
				async : true,
				url : Think.U('Home/Users/checkLoginKey'),
				success : function(data){
					var json = WST.toJson(data);
		            if( json.status == "1" ) {
		                return true;
					} else {
		                return false;
					}
					return "该电子邮箱已被使用";
				},
				buttons: $("#dosubmit"),
				onError : "该邮箱已存在。",
				onWait : "请稍候..."
			}).defaultPassed().unFormValidator(true);
		$("#userPhone").blur(function(){
			  if($("#userPhone").val()==''){
				  $("#userPhone").unFormValidator(true);
			  }else{
				  $("#userPhone").unFormValidator(false);
			  }
		});
		$("#userEmail").blur(function(){
			  if($("#userEmail").val()==''){
				  $("#userEmail").unFormValidator(true);
			  }else{
				  $("#userEmail").unFormValidator(false);
			  }
		});
	   $("#userImgUpload").uploadify({
		    formData      : {'dir':'users','width':150,'height':150},
		    buttonText    : '选择图标',
		    fileTypeDesc  : 'Image Files',
	        fileTypeExts  : '*.gif; *.jpg; *.png',
	        swf           : publicurl+'/plugins/uploadify/uploadify.swf',
	        uploader      : Think.U('Home/Users/uploadPic'),
	        onUploadSuccess : function(file, data, response) {
	        	var json = WST.toJson(data);
	        	$('#preview').attr('src',domainURL +'/'+json.Filedata.savepath+json.Filedata.savethumbname).show();
	        	$('#userPhoto').val(json.Filedata.savepath+json.Filedata.savename);
       }
	    });
});
</script>
	<link rel="stylesheet" href="/mineop/1/wstmall/Public/plugins/uploadify/uploadify.css">
	<script src="/mineop/1/wstmall/Public/plugins/uploadify/jquery.uploadify.min.js"></script>
   	<div class="wst-body"> 
       <div class='wst-page-header'>买家中心 > 个人资料</div>
       <div class='wst-page-content'>
       <form name="myform" method="post" id="myform">
        <table class="table table-hover table-striped table-bordered wst-form">
           <tr>
             <th align='right' width="80">昵称 <font color='red'>*</font>：</th>
             <td>
             <input type='text' id='userName' name='userName' value="<?php echo ($user['userName']); ?>"/>
             </td>
             <td width='120' align='right' rowspan='5'>
             <img id='preview' src='<?php if($user['userPhoto'] =='' ): ?>/mineop/1/wstmall/Apps/Home/View/default/images/logo.png<?php else: ?>/mineop/1/wstmall/<?php echo ($user["userPhoto"]); endif; ?>' width='150' height='150' />
             <input type='text' id='userImgUpload' class="form-control wst-ipt"/>
             <input type='hidden' id='userPhoto' name='userPhoto'/>
             </td>
           </tr>
           <tr>
             <th align='right'>性别 <font color='red'>*</font>：</th>
             <td>
             	<label><input type='radio' name='userSex' value="1" <?php if($user['userSex'] == 1): ?>checked<?php endif; ?>/>男</label>
             	<label><input type='radio' name='userSex' value="2" <?php if($user['userSex'] == 2): ?>checked<?php endif; ?>/>女</label>
             	<label><input type='radio' name='userSex' value="3" <?php if($user['userSex'] == 3): ?>checked<?php endif; ?>/>保密</label>
             </td>
           </tr>
            <tr>
             <th align='right'>用户QQ ：</th>
             <td>
             <input type='text' id='userQQ' name='userQQ' value="<?php echo ($user['userQQ']); ?>"/>
             </td>
           </tr>
           <tr>
             <th align='right'>手机 <font color='red'>*</font>：</th>
             <td>
             <input type='text' id='userPhone' name='userPhone' value="<?php echo ($user['userPhone']); ?>" maxlength="11"/>
             </td>
           </tr>
           <tr>
             <th align='right'>邮箱<font color='red'>*</font>：</th>
             <td>
             <input type='text' id='userEmail' name='userEmail' value="<?php echo ($user['userEmail']); ?>" maxlength="25" style='width:200px'/>
             </td>
           </tr>
           
           <tr>
             <td colspan='2' style='padding-left:250px;'>
                 <button class='wst-btn-query' type="submit">保&nbsp;存</button>
                 <button class='wst-btn-query' type="reset">重&nbsp;置</button>
             </td>
           </tr>
        </table>
       </form>
       </div>
   </div>

            </div>
          </div>
          <div style='clear:both;'></div>
          <br/>
           <div class='wst-footer'>
          	<div class="wst-footer-fl-box">
	<div class="wst-footer" >
		<div class="wst-footer-cld-box">
			<div class="wst-footer-fl">友情链接：</div>
			<div style="padding-left:30px;">
				<?php if(is_array($friendLikds)): $k = 0; $__LIST__ = $friendLikds;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?><div style="float:left;"><a href="<?php echo ($vo["friendlinkUrl"]); ?>" target="_blank"><?php echo ($vo["friendlinkName"]); ?></a>&nbsp;&nbsp;</div><?php endforeach; endif; else: echo "" ;endif; ?>
				<div class="wst-clear"></div>
			</div>
		</div>
	</div>
</div>

<div class="wst-footer-hp-box">
	<div class="wst-footer">
		<div class="wst-footer-hp-ck1">
			<?php if(is_array($helps)): $k1 = 0; $__LIST__ = $helps;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo1): $mod = ($k1 % 2 );++$k1;?><div class="wst-footer-wz-ca">
				<div class="wst-footer-wz-pt">
				    <img src="/mineop/1/wstmall/Apps/Home/View/default/images/a<?php echo ($k1); ?>.jpg" height="18" width="18"/>
					<span class="wst-footer-wz-pn"><?php echo ($vo1["catName"]); ?></span>
					<div style='margin-left:30px;'>
						<?php if(is_array($vo1['articlecats'])): $k2 = 0; $__LIST__ = $vo1['articlecats'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo2): $mod = ($k2 % 2 );++$k2;?><a href="<?php echo U('Home/Articles/index/',array('articleId'=>$vo2['articleId']));?>"><?php echo ($vo2['articleTitle']); ?></a><br/><?php endforeach; endif; else: echo "" ;endif; ?>
					</div>
				</div>
			</div><?php endforeach; endif; else: echo "" ;endif; ?>
			
			<div class="wst-footer-wz-clt">
				<div style="padding-top:5px;line-height:25px;">
				    <img src="/mineop/1/wstmall/Apps/Home/View/default/images/a6.jpg" height="18" width="18"/>
					<span class="wst-footer-wz-kf">联系客服</span>
					<div style='margin-left:30px;'>
						<a href="#">联系电话</a><br/>
						<span class="wst-footer-pno">020-29806661</span><br/>
						<a href="#">在线客服</a><br/>
						<a href="#" class="wst-footer-wz-ent">点击这里进入</a><br/>
					</div>
				</div>
			</div>
			<div class="wst-clear"></div>
		</div>
	    
		<div class="wst-footer-hp-ck2">
			<img src="/mineop/1/wstmall/Apps/Home/View/default/images/alipay.jpg" height="40" width="120"/>支付宝签约商家&nbsp;|&nbsp;
			<span class="wst-footer-frd">正品保障</span><span >100%原产地</span>&nbsp;|&nbsp;
			<span class="wst-footer-frd">7天退货保障</span>购物无忧&nbsp;|&nbsp;
			<span class="wst-footer-frd">免费配送</span>满98包邮&nbsp;|&nbsp;
			<span class="wst-footer-frd">货到付款</span>400城市送货上门
		</div>
	    <div class="wst-footer-hp-ck3">
	        <div class="links"> 
	            <?php $_result=WSTNavigation(1);if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><a rel="nofollow" <?php if($vo['isOpen'] == 1): ?>target="_blank"<?php endif; ?> href="<?php echo ($vo['navUrl']); ?>"><?php echo ($vo['navTitle']); ?></a>&nbsp;<?php if($vo['end'] == 0): ?>|&nbsp;<?php endif; endforeach; endif; else: echo "" ;endif; ?>
	        </div>
	        
	        <div class="copyright">
	         
	         <?php if($CONF['mallFooter']!=''){ echo htmlspecialchars_decode($CONF['mallFooter']); } ?>
	      	<?php if($CONF['visitStatistics']!=''){ echo htmlspecialchars_decode($CONF['visitStatistics'])."<br/>"; } ?>
	        <?php if($CONF['mallLicense'] ==''): ?><div>
				Copyright©2015 Powered By <a target="_blank" href="http://www.wstmall.com">WSTMall</a>
			</div>
			<?php else: ?>
				<div id="wst-mallLicense" data='1' style="display:none;">Copyright©2015 Powered By <a target="_blank" href="http://www.wstmall.com">WSTMall</a></div><?php endif; ?>
	        </div>
	    	
	        	 
	     
	    </div>
	</div>
</div>

          </div>
        </div>
    </body>
    <script src="/mineop/1/wstmall/Public/plugins/formValidator/formValidator-4.1.3.js"></script>
   	<script src="/mineop/1/wstmall/Public/js/common.js"></script>
   	<script src="/mineop/1/wstmall/Apps/Home/View/default/js/usercom.js"></script>
   	<script src="/mineop/1/wstmall/Apps/Home/View/default/js/head.js"></script>
   	<script src="/mineop/1/wstmall/Public/plugins/layer/layer.min.js"></script>
  	<script src="/mineop/1/wstmall/Apps/Home/View/default/js/common.js"></script>
   	<script src="/mineop/1/wstmall/Public/plugins/laypage/laypage.js"></script>

     <script type="text/javascript">
		var publicurl = '/mineop/1/wstmall/Public/';
		var shopId = '<?php echo ($orderInfo["order"]["shopId"]); ?>';
		checkLogin();
	</script>
</html>