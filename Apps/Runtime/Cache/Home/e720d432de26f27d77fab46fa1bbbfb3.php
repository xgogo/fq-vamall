<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE>
<html lang="zh-cn">
<head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title><?php echo ($CONF['mallTitle']); ?> - <?php if(count($orderInfos) > 0): ?>订单提交成功<?php else: ?>不能重复提交订单<?php endif; ?></title>
      	<meta name="keywords" content="<?php echo ($CONF['mallKeywords']); ?>,订单提交" />
      	<meta name="description" content="<?php echo ($CONF['mallDesc']); ?>,订单提交" />
	    <link rel="stylesheet" href="/mineop/1/wstmall/Apps/Home/View/default/css/common.css" />
     	<link rel="stylesheet" href="/mineop/1/wstmall/Apps/Home/View/default/css/ordersuccess.css" />
     	<link rel="stylesheet" href="/mineop/1/wstmall/Apps/Home/View/default/css/base.css" />
		<link rel="stylesheet" href="/mineop/1/wstmall/Apps/Home/View/default/css/head.css" />
		<link rel="stylesheet" href="/mineop/1/wstmall/Apps/Home/View/default/css/pslocation.css" />
		<link rel="stylesheet" href="/mineop/1/wstmall/Apps/Home/View/default/css/magnifier.css" />
</head>

<body class="root61">
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
			<li class="fore1" id="loginbar"><a href="<?php echo U('Home/Orders/queryByPage');?>"><span style='color:blue'><?php echo ($WST_USER['userName'] ? $WST_USER['userName'] : $WST_USER['loginName']); ?></span></a> 欢迎您来到 <a href='<?php echo WSTDomain();?>'><?php echo ($CONF['mallName']); ?></a>！<s></s>&nbsp;
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

<div style="height:132px;">
<div id="mainsearchbox" style="text-align:center;">
	<div id="wst-search-pbox">
		<div style="float:left;width:240px;" class="wst-header-car">
		  <a href='<?php echo WSTDomain();?>'>
			<img id="wst-logo" width='240' height='132' src="<?php echo WSTDomain();?>/<?php echo ($CONF['mallLogo']); ?>"/>
		  </a>	
		</div>
		<div id="wst-search-container">
			<div id="wst-search-type-box">
				<input id="wst-search-type" type="hidden" value="<?php echo ($searchType); ?>"/>
				<div id="wst-panel-goods" class="<?php if($searchType == 1): ?>wst-panel-curr<?php else: ?>wst-panel-notcurr<?php endif; ?>">商品</div>
				<div id="wst-panel-shop" class="<?php if($searchType == 2): ?>wst-panel-curr<?php else: ?>wst-panel-notcurr<?php endif; ?>">店铺</div>
				<div class="wst-clear"></div>
			</div>
			<div id="wst-searchbox">
				<input id="keyword" placeholder="<?php if($searchType == 2): ?>搜索 店铺<?php else: ?>搜索 商品<?php endif; ?>" autocomplete="off"  value="<?php echo ($keyWords); ?>">
				<div id="btnsch" class="wst-search-button">搜&nbsp;索</div>
			</div>
		</div>
		<div id="wst-search-des-container">
			<div class="des-box">
				<div class='wst-reach'>
					<img src="/mineop/1/wstmall/Apps/Home/View/default/images/sadn.jpg"  height="38" width="40"/>
					<div style="float:left;position:absolute;top:0px;left:38px;"><span style="font-weight:bolder;">闪电配送</span><br/><span style="color:#e23c3d;">最快1小时送达</span></div>
				</div>
				<div class='wst-since'>
					<img src="/mineop/1/wstmall/Apps/Home/View/default/images/sqzt.jpg"  height="38" width="40"/>
					<div style="float:left;position:absolute;top:0px;left:38px;"><span style="font-weight:bolder;">社区自提</span><br/><span style="color:#e23c3d;">330家自提点</span></div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
<div class="headNav">
		  <div class="navCon w1020">
		  	<div class="wst-slide-controls">
		  		<?php if(is_array($indexAds)): $k = 0; $__LIST__ = $indexAds;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k; if($k == 1): ?><span class="curr"><?php echo ($k); ?></span>
		  		  	<?php else: ?>
		  		    	<span class=""><?php echo ($k); ?></span><?php endif; endforeach; endif; else: echo "" ;endif; ?>
			</div>
		    <div class="navCon-cate fl navCon_on" >
		      <div class="navCon-cate-title"> <a href="<?php echo U('Home/goods/getGoodsList');?>">全部商品分类</a></div>
		      
		      	<?php if($ishome == 1): ?><div class="cateMenu1" >
		      	<?php else: ?>
		      		<div class="cateMenu2" style="display:none;" ><?php endif; ?>
		        <div style="position:relative;">
		        	<div class="wst-nvgbk" style="diplay:none;"></div>
		        	<?php $_result=WSTGoodsCats();if(is_array($_result)): $k1 = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo1): $mod = ($k1 % 2 );++$k1;?><li style="border-top: none;">
				    	<div>
				            <div class="cate-tag"> 
				            <div class="listModel">
				             <p > 
				            	<strong><s<?php echo ($k1); ?>></s<?php echo ($k1); ?>>&nbsp;<a style="font-weight:bold;" href="<?php echo U('Home/goods/getGoodsList',array('c1Id'=>$vo1['catId']));?>"><?php echo ($vo1["catName"]); ?></a></strong>
				             </p> 
				             </div>
				              <div class="listModel">
				                <p> 
				                <?php if(is_array($vo1['catChildren'])): $k2 = 0; $__LIST__ = $vo1['catChildren'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo2): $mod = ($k2 % 2 );++$k2;?><a href="<?php echo U('Home/goods/getGoodsList',array('c1Id'=>$vo1['catId'],'c2Id'=>$vo2['catId']));?>"><?php echo ($vo2["catName"]); ?></a><?php endforeach; endif; else: echo "" ;endif; ?>
				                </p>
				              </div>
				            </div>
				            <div class="list-item hide">
				              <ul class="itemleft">
				              	<?php if(is_array($vo1['catChildren'])): $k2 = 0; $__LIST__ = $vo1['catChildren'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo2): $mod = ($k2 % 2 );++$k2;?><dl>
				                  <dt><a href="<?php echo U('Home/goods/getGoodsList',array('c1Id'=>$vo1['catId'],'c2Id'=>$vo2['catId']));?>"><?php echo ($vo2["catName"]); ?></a></dt>
				                  <dd> 
				                  <?php if(is_array($vo2['catChildren'])): $k3 = 0; $__LIST__ = $vo2['catChildren'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo3): $mod = ($k3 % 2 );++$k3;?><a href="<?php echo U('Home/goods/getGoodsList',array('c1Id'=>$vo1['catId'],'c2Id'=>$vo2['catId'],'c3Id'=>$vo3['catId']));?>"><?php echo ($vo3["catName"]); ?></a><?php endforeach; endif; else: echo "" ;endif; ?>
				                  </dd>
				                </dl>
				                <div class="fn-clear"></div><?php endforeach; endif; else: echo "" ;endif; ?>
				              </ul>
				            </div>
				            </div>
				  		</li><?php endforeach; endif; else: echo "" ;endif; ?>
		          	<li style="display:none;"></li>
		        </div>
		      </div>
		    </div>
		    
		    <div class="navCon-menu fl">
		      <ul class="fl">
		        <?php $_result=WSTNavigation(0);if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li ><a href="<?php echo ($vo['navUrl']); ?>" <?php if($vo['isOpen'] == 1): ?>target="_blank"<?php endif; ?> <?php if($vo['active'] == 1): ?>class="curMenu"<?php endif; ?>>&nbsp;&nbsp;<?php echo ($vo['navTitle']); ?>&nbsp;&nbsp;</a></li><?php endforeach; endif; else: echo "" ;endif; ?>
		      </ul>
		    </div>
		    <li id="wst-nvg-cart">
		    	<div class='wst-nvg-cart-cost'>
		       		&nbsp;<span class="wst-nvg-cart-cnt">0</span>件&nbsp;|&nbsp;<span class="wst-nvg-cart-price">0.00</span>元
		       	</div>
			</li>
			<div class="wst-cart-box"><div class="wst-nvg-cart-goods">购物车中暂无商品</div></div>
		  </div>
		</div>
	<div class="w">
		<div>
			<div>
                <div id="succeed" class="wst-ods-success">
                    <div class="success2" style="margin: 0 auto;">
                        <div class="wst-ods-success-blank"></div>
                        <div class="wst-ods-success-step">
                            <img src="/mineop/1/wstmall/Apps/Home/View/default/images/step3.png" alt="" /><br />
                            <span class="wst-ods-success-step1">1.我的购物车</span>
                            <span class="wst-ods-success-step2">2.填写核对订单信息</span>
                            <span class="wst-ods-success-step3">3.成功提交订单</span>
                        </div>
                        <div class="wst-clear"></div>
                    </div>
                </div>
            </div>

			<div class="wst-ods-success-tb">
					<div class="wst-ods-success-tc">
						<div class="wst-ods-success-td">
							<?php if(count($orderInfos) > 0): ?><img src="/mineop/1/wstmall/Apps/Home/View/default/images/icon-succ.png" alt="" /><?php endif; ?>
						</div>
						<div class="wst-ods-success-tf">
							<div class="wst-ods-success-l25">
								<?php if(count($orderInfos) > 0): ?><span class="wst-ods-success-tg">订单提交成功！</span>					
								订单号：
								<?php if(is_array($orderInfos)): $key = 0; $__LIST__ = $orderInfos;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$order): $mod = ($key % 2 );++$key; if(($key > 1) AND ($isMoreOrder == 1)): ?>、<?php endif; ?>
									<a href="javascript:;" onclick="getOrderInfo(<?php echo ($order['orderId']); ?>);"><span class="wst-ods-success-th"><?php echo ($order['orderNo']); ?></span></a>&nbsp;<?php endforeach; endif; else: echo "" ;endif; ?>
								 应付金额：<span class="wst-ods-success-ti"><?php echo ($totalMoney); ?></span> 元
	   							<?php else: ?>
	   								<div class="wst-ods-success-tj">不能重复提交订单</div><?php endif; ?>
	   						</div>							
						</div>
						<div class="wst-clear"></div>
					</div>					
					
					<div class="wst-clear"></div>
					<div class="wst-ods-success-tk">			
						<div id="checkout" class="wst-checkout" >							
							<a class="btn-submit" href="/mineop/1/wstmall/index.php">
								<span id="saveConsigneeTitleDiv" class="wst_btn-continue"></span>
							</a>
							<div class="wst-clear"></div>
						</div>
					</div>				
				</div>							
			</div>			
		</div>
	
	<div class="wst-clear"></div>
    <div style="height: 20px;"></div>
    
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

	
	<script src="/mineop/1/wstmall/Public/js/common.js"></script>
  	<script src="/mineop/1/wstmall/Apps/Home/View/default/js/index.js"></script>      	
 	<script src="/mineop/1/wstmall/Apps/Home/View/default/js/common.js"></script>
	<script src="/mineop/1/wstmall/Apps/Home/View/default/js/orders.js"></script>
</body>
</html>