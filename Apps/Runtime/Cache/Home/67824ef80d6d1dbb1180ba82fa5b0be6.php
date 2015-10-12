<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
	<head>
  		<meta charset="utf-8">
      	<meta http-equiv="X-UA-Compatible" content="IE=edge">
      	<meta name="viewport" content="width=device-width, initial-scale=1">
      	<title><?php echo ($goodsDetails["goodsName"]); ?> - <?php echo ($CONF['mallTitle']); ?></title>
      	<meta name="keywords" content="<?php echo ($goodsDetails['goodsName']); ?>" />
      	<meta name="description" content="<?php echo ($CONF['mallDesc']); ?>,<?php echo ($goodsDetails['goodsName']); ?>" />
      	<link rel="stylesheet" href="/mineop/1/wstmall/Apps/Home/View/default/css/common.css" />
     	<link rel="stylesheet" href="/mineop/1/wstmall/Apps/Home/View/default/css/goodsdetails.css" />
     	<link rel="stylesheet" href="/mineop/1/wstmall/Apps/Home/View/default/css/base.css" />
		<link rel="stylesheet" href="/mineop/1/wstmall/Apps/Home/View/default/css/head.css" />
		<link rel="stylesheet" href="/mineop/1/wstmall/Apps/Home/View/default/css/pslocation.css" />
		<link rel="stylesheet" href="/mineop/1/wstmall/Apps/Home/View/default/css/magnifier.css" />
     	<script src="/mineop/1/wstmall/Public/js/jquery.min.js"></script>
     	<script src="/mineop/1/wstmall/Public/js/common.js"></script>
     	<script src="/mineop/1/wstmall/Public/plugins/layer/layer.min.js"></script>
   	</head>
   	<body>
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
	
		<input id="goodsId" type="hidden" value="<?php echo ($goodsDetails['goodsId']); ?>"/>
		<!----加载商品楼层start----->
		<div class="wst-container">
			<div class="wst-nvg-title">
				<a href="<?php echo U('Home/Goods/getGoodsList/',array('c1Id'=>$goodsNav[0]['catId']));?>"><?php echo ($goodsNav[0]["catName"]); ?></a>&nbsp;>&nbsp;
				<a href="<?php echo U('Home/Goods/getGoodsList/',array('c1Id'=>$goodsNav[0]['catId'],'c2Id'=>$goodsNav[1]['catId']));?>"><?php echo ($goodsNav[1]["catName"]); ?></a>&nbsp;>&nbsp;
				<a href="<?php echo U('Home/Goods/getGoodsList/',array('c1Id'=>$goodsNav[0]['catId'],'c2Id'=>$goodsNav[1]['catId'],'c3Id'=>$goodsNav[2]['catId']));?>"><?php echo ($goodsNav[2]["catName"]); ?></a>
			</div>
			<div class="wst-goods-details">
				<div class="details-left">
					<div class="goods-img-box">
						 <!--产品参数开始-->
						  <div>
						    <div id="preview" class="spec-preview"> 
							    <span class="jqzoom">
							    	<img jqimg="/mineop/1/wstmall/<?php echo ($goodsDetails['goodsImg']); ?>" src="/mineop/1/wstmall/<?php echo ($goodsDetails['goodsImg']); ?>" height="350" width="350"/>
							    </span> 
						    </div>
						    <!--缩图开始-->
						    <div class="spec-scroll"> <a class="prev">&lt;</a> <a class="next">&gt;</a>
						      <div class="items">
						        <ul>
						        	<li><img alt="" bimg="/mineop/1/wstmall/<?php echo ($goodsDetails['goodsImg']); ?>" src="/mineop/1/wstmall/<?php echo ($goodsDetails['goodsImg']); ?>" onmousemove="preview(this);"></li>
						        	<?php if(is_array($goodsImgs)): $k = 0; $__LIST__ = $goodsImgs;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?><li><img alt="" bimg="/mineop/1/wstmall/<?php echo ($vo['goodsImg']); ?>" src="/mineop/1/wstmall/<?php echo ($vo['goodsImg']); ?>" onmousemove="preview(this);"></li><?php endforeach; endif; else: echo "" ;endif; ?>
						        </ul>
						      </div>
						    </div>
						    <!--缩图结束-->
						  </div>
						  <!--产品参数结束-->
					</div>
					<div class="goods-des-box">
						<table class="goods-des-tab">
							<tbody>
								<tr>
									<td colspan="2">
										<div class="des-title">
											<a href="">
											<?php echo ($goodsDetails["goodsName"]); ?>
											</a>
										</div>
									</td>
								</tr>
								<tr>
									<td colspan="2">
										<div class="des-chux">
											价格：<span id='shopGoodsPrice_<?php echo ($goodsDetails["goodsId"]); ?>' dataId='<?php echo ($goodsDetails["goodsAttrId"]); ?>'>￥<?php echo ($goodsDetails["shopPrice"]); ?></span>
											首付：<input type="text" value='10' id='f_pay'>
											分期：<input type="text" value='7' id='fenqi'>
										</div>
									</td>
								</tr>
								<tr>
									<td width="70"><span class="des-title-span">商品编号：</span></td>
									<td><?php echo ($goodsDetails["goodsSn"]); ?></td>
								</tr>
								<tr>
									<td width="70"><span class="des-title-span">配送至：</span></td>
									<td>
										<li id="summary-stock">
											<div class="dd">
												<div id="store-selector">
													<div class="text">
														<div></div>
														<b></b>
													</div>
												</div><!--store-selector end-->
												<div id="store-prompt">
													<strong></strong>
												</div><!--store-prompt end--->
											</div>
										</li>
										<div class="wst-clear"></div>
									</td>
								</tr>
								<tr>
									<td width="70"><span class="des-title-span">运费：</span></td>
									<td><?php echo ($goodsDetails["deliveryStartMoney"]); ?>元起，配送费<?php echo ($goodsDetails["deliveryMoney"]); ?>元，<?php echo ($goodsDetails["deliveryFreeMoney"]); ?>元起免配送费</td>
								</tr>
								<tr>
									<td width="70"><span class="des-title-span">服务：</span></td>
									<td>由<?php if($goodsDetails['deliveryType'] == 0): ?>WST商城<?php else: ?><a href="<?php echo U('Home/Shops/toShopHome/',array('shopId'=>$goodsDetails['shopId']));?>"><?php echo ($goodsDetails['shopName']); ?></a><?php endif; ?>配送，并提供售后服务</td>
								</tr>
								<?php if( count($goodsAttrs['priceAttrs']) > 0): ?><tr style='height:15px;border-top:1px dashed #ddd;'>
								   <td colspan='2'></td>
								</tr>
								<tr>
									<td width="70"><span class="des-title-span"><?php echo ($goodsAttrs["priceAttrName"]); ?>：</span></td>
									<td>
									 <?php if(is_array($goodsAttrs['priceAttrs'])): $i = 0; $__LIST__ = $goodsAttrs['priceAttrs'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$avo): $mod = ($i % 2 );++$i;?><span class='wst-goods-attrs <?php if( $goodsDetails['goodsAttrId'] == $avo['id']): ?>wst-goods-attrs-on<?php endif; ?>' dataId='<?php echo ($avo["id"]); ?>' onclick='javascript:checkStock(this)'><?php echo ($avo['attrVal']); ?></span><?php endforeach; endif; else: echo "" ;endif; ?>
									</td>
								</tr><?php endif; ?>
								<tr>
								    <td></td>
								    <td></td>
								</tr>
								<!-- 
								<?php if($goodsDetails['shopServiceStatus'] == 1): ?><tr>
									<td width="70"><span style="display:inline-block;width:70px;">购买数量：</span></td>
									<td>
										<div id="haveGoodsToBuy" <?php if($goodsDetails['goodsStock'] <= 0): ?>style="display:none;"<?php endif; ?>>
											<div class="goods-buy-cnt">
												<div class="buy-cnt-plus" onclick="changebuynum(1)"></div>
												<input id="buy-num" type="text" class="buy-cnt-txt" value="1" maxVal="<?php echo ($goodsDetails['goodsStock']); ?>" maxlength="3" onkeypress="return WST.isNumberKey(event);" onkeyup="changebuynum(0);"/>
												<div class="buy-cnt-add" onclick="changebuynum(2)"></div>
											</div>
										</div>
										<div id="noGoodsToBuy" <?php if($goodsDetails['goodsStock'] > 0): ?>style="display:none;"<?php endif; ?>>
											<div style="font-weight: bold;">所选地区该商品暂时无货，非常抱歉！</div>
											<div style="clear: both;"></div>
											<br />
											<div>
												<a id="InitCartUrl" class="btn-append " href="javascript:void(0);" title="">
													<span>
														<img src="/mineop/1/wstmall/Apps/Home/View/default/images/hcat.jpg" />
													</span>
												</a>
											</div>
										</div>
									</td>
								</tr>
								<?php else: ?>
								<tr>
									<td colspan="2">
										<div class="wst-gdetail-wait">休息中,暂停营业</div>
									</td>
								</tr><?php endif; ?> 
								-->
								<tr>
									<td ></td>
									<td></td>
								</tr>
								<?php if($goodsDetails['goodsStock'] > 0): ?><tr>
									<td width="70"></td>
									<td>
										<?php if($comefrom == 1): ?><img src="/mineop/1/wstmall/Apps/Home/View/default/images/hcat.jpg" />
										<?php elseif($goodsDetails['shopServiceStatus'] == 1): ?>
											<!--  
												<a href="javascript:addCart(<?php echo ($goodsDetails['goodsId']); ?>,0,'<?php echo ($goodsDetails['goodsThums']); ?>')" class="btnCart"><img src="/mineop/1/wstmall/Apps/Home/View/default/images/btn_buy_01_hover.png" width="112" height="38"/></a>
												&nbsp;&nbsp;
											-->
												<a href="javascript:addCart(<?php echo ($goodsDetails['goodsId']); ?>,1)" class="btn2Cart">
													<img src="/mineop/1/wstmall/Apps/Home/View/default/images/btn_buy_02.png" width="112" height="38"/>
												</a><?php endif; ?>
											<?php if($goodsDetails['shopServiceStatus'] == 0): ?><img src="/mineop/1/wstmall/Apps/Home/View/default/images/hcat.jpg" /><?php endif; endif; ?>
									</td>
								</tr>
								</if>
							</tbody>
						</table>
					</div>
				</div>
				<div class="details-right">
					<table class="details-tab">
						<tbody>
							<tr>
								<td class="title">店铺名称：</td>
								<td><?php echo ($goodsDetails["shopName"]); ?></td>
							</tr>
							<tr>
								<td class="title">营业时间：</td>
								<td><?php echo ($goodsDetails['serviceStartTime']); ?>-<?php echo ($goodsDetails['serviceEndTime']); ?></td>
							</tr>
							<tr>
								<td class="title">配送说明：</td>
								<td><?php echo ($goodsDetails["deliveryStartMoney"]); ?>元起，配送费<?php echo ($goodsDetails["deliveryMoney"]); ?>元<br/><?php echo ($goodsDetails["deliveryFreeMoney"]); ?>元起免配送费<br/><br/></td>
							</tr>
							<tr>
								<td class="title">店铺地址：</td>
								<td><?php echo ($goodsDetails['shopAddress']); ?></td>
							</tr>
							<tr>
								<td class="title">店铺电话：</td>
								<td><?php echo ($goodsDetails['shopTel']); ?></td>
							</tr>
							<tr>
								<td ></td>
								<td></td>
							</tr>
							<tr>
								<td colspan="2" class="wst-shop-eval">
									<div class="shop-eval-box" style="width:220px;margin:0 auto;">
										    <li>商品<br/><?php echo ($shopScores["goodsScore"]); ?></li>
											<li class="li-center">时效<br/><?php echo ($shopScores["timeScore"]); ?></li>
											<li>服务<br/><?php echo ($shopScores["serviceScore"]); ?></li>
										<div class="wst-clear"></div>
									</div>
								</td>
							</tr>
							<tr>
								<td ></td>
								<td></td>
							</tr>
							<tr>
								<td colspan="2" class="wst-shop-eval">
									<div class="shop-eval-box" style="width:214px;margin:0 auto;">
										<a href="<?php echo U('Home/Shops/toShopHome/',array('shopId'=>$goodsDetails['shopId']));?>"><img src="/mineop/1/wstmall/Apps/Home/View/default/images/btn_into.png" width="112" height="38"/></a>
									</div>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="wst-clear"></div>
			</div>
			
			<div class="wst-goods-pdetails">
				<div class="wst-goods-pdetails-left">
					<div class="wst-goods-hotsale-box">
						<div class="hotsale-title">热销商品</div>
						<?php if(is_array($hotgoods)): $k = 0; $__LIST__ = $hotgoods;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?><div class="hotsale-goods-box">
							<div class="hotsale-goods-img">
								<img data-original="/mineop/1/wstmall/<?php echo ($vo['goodsThums']); ?>" width="65" height="65" />
							</div>
							<div class="hotsale-goods-title">
								<a href="<?php echo U('Home/Goods/getGoodsDetails/',array('goodsId'=>$vo['goodsId']));?>"><?php echo ($vo['goodsName']); ?></a>
								<div><span class="span1">￥<?php echo ($vo['shopPrice']); ?></span>&nbsp;&nbsp;&nbsp;&nbsp;<span class="span2">￥<?php echo ($vo['marketPrice']); ?></span></div>
							</div>
							<div class="wst-clear"></div>
						</div><?php endforeach; endif; else: echo "" ;endif; ?>
						
					</div>
				</div>
				<div id="wst-goods-pdetails-right" class="wst-goods-pdetails-right">
					<div class="goods-nvg">
						<ul class="tab">
							<li onclick="tabs('#wst-goods-pdetails-right',0)" class="curr">商品介绍</li>
							<?php if( count($goodsAttrs['attrs']) > 0): ?><li onclick="tabs('#wst-goods-pdetails-right',1)">商品属性</li>
							<li onclick="tabs('#wst-goods-pdetails-right',2)">商品评价</li>
							<?php else: ?>
							<li onclick="tabs('#wst-goods-pdetails-right',1)">商品评价</li><?php endif; ?>
						</ul>
						<div class="wst-clear"></div>
					</div>
					<div class="tabcon">
						<div style="font-weight:bolder;height:auto;line-height:30px;padding-left:8px;">
						<?php echo ($goodsDetails["goodsDesc"]); ?>
						</div>
					</div>
					<?php if( count($goodsAttrs['attrs']) > 0): ?><div class="tabcon" style="display:none;">
						<table class='wst-attrs-list'>
						  <?php if(is_array($goodsAttrs['attrs'])): $i = 0; $__LIST__ = $goodsAttrs['attrs'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if($vo['attrContent'] !='' ): ?><tr>
						    <th nowrap><?php echo ($vo['attrName']); ?>：</th>
						    <td><?php echo ($vo['attrContent']); ?></td>
						  </tr><?php endif; endforeach; endif; else: echo "" ;endif; ?>
						</table>
					</div><?php endif; ?>
					<div class="tabcon"  style="display:none;">						
						<table id="appraiseTab" width="100%">
							<tr>
								<td>
		                      	 	<div style="margin-top: 10px;" id="allgoodsppraises">
		                           		 请稍等...
		                        	</div>
		                        </td>
		                	</tr>
	                   	</table>  
	                   	<div id="wst-page-items" style="text-align:right;"></div>                  
					</div>
					<div class="wst-clear"></div>
				</div>
				<div class="wst-clear"></div>
			</div>
			<div class="wst-clear"></div>
		</div>
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

		<link rel="stylesheet" type="text/css" href="/mineop/1/wstmall/Apps/Home/View/default/css/cart.css" />
<script src="/mineop/1/wstmall/Apps/Home/View/default/js/login.js"></script>
<script type="text/javascript" src="/mineop/1/wstmall/Apps/Home/View/default/js/cart/common.js?v=725"></script>
<script type="text/javascript" src="/mineop/1/wstmall/Apps/Home/View/default/js/cart/quick_links.js"></script>
<!--[if lte IE 8]>
<script src="/mineop/1/wstmall/Apps/Home/View/default/js/cart/ieBetter.js"></script>
<![endif]-->
<script src="/mineop/1/wstmall/Apps/Home/View/default/js/cart/parabola.js"></script>
<!--右侧贴边导航quick_links.js控制-->
	<div id="flyItem" class="fly_item" style="display:none;">
		<p class="fly_imgbox">
		<img src="/mineop/1/wstmall/Apps/Home/View/default/images/item-pic.jpg"
			width="30" height="30">
		</p>
	</div>
	<div class="mui-mbar-tabs">
		<div class="quick_link_mian">
			<div class="quick_links_panel">
				<div id="quick_links" class="quick_links">
					<li><a href="#" class="my_qlinks"><i class="setting"></i></a>
						<div class="ibar_login_box status_login">
							<?php if($WST_USER['userId'] > 0): ?><div class="avatar_box">
								<p class="avatar_imgbox">
									<img
										src="/mineop/1/wstmall/Apps/Home/View/default/images/no-img_mid_.jpg" />
								</p>
								<?php if($WST_USER['userId'] > 0): ?><ul class="user_info">
									<li>用户名：<?php echo ($WST_USER['loginName']); ?></li>
									<li>级&nbsp;别：普通会员</li>
								</ul><?php endif; ?>
							</div>
							
							<div class="ibar_recharge-btn">
								<input type="button" value="我的订单" onclick="getMyOrders();"/>
							</div>
							<i class="icon_arrow_white"></i>
						</div> <?php else: ?>
							<div style="margin: 0 auto;padding: 15px 0; width: 220px;">
							<div class="ibar_recharge-field">
								<label>帐号</label>
								<div class="ibar_recharge-fl">
									<div class="ibar_recharge-iwrapper">
										<input id="loginName" name="loginName" value="<?php echo ($loginName); ?>" type="text" name="19" placeholder="用户名/手机号/邮箱" />
									</div>
									<i class="ibar_username-contact"></i>
								</div>
							</div>
							<div class="ibar_recharge-field">
								<label>密码</label>
								<div class="ibar_recharge-fl">
									<div class="ibar_recharge-iwrapper">
										<input id="loginPwd" name="loginPwd" type="password" name="19" placeholder="密码" />
									</div>
									<i class="ibar_password-contact"></i>
								</div>
							</div>
							<div class="ibar_recharge-field">
								<label>验证码</label>
								<div class="ibar_recharge-fl" style="width:80px;">
									<div class="ibar_recharge-iwrapper">
										<input id="verify" style="ime-mode:disabled;width:80px;" name="verify" class="text text-1" tabindex="6" autocomplete="off" maxlength="6" type="text" placeholder="验证码"/>
									</div>
								</div>
								<label class="img" onclick="javascript:getVerify()">
				                	<img style='vertical-align:middle;cursor:pointer;height:30px;width:93px;' class='verifyImg' src='/mineop/1/wstmall/Apps/Home/View/default/images/clickForVerify.png' title='刷新验证码' onclick='javascript:getVerify()'/> 
								</label>
							</div>
							<div class="ibar_recharge-btn">
								<input type="button" value="登录" onclick="checkLoginInfo();"/>
							</div>
							</div><?php endif; ?></li>
					<li id="shopCart"><a href="#" class="message_list"><i class="message"></i>
					<div class="span">购物车</div> <span class="cart_num">0</span></a></li>
				</div>
				<div class="quick_toggle">
					<li><a href="#none"><i class="mpbtn_qrcode"></i></a>
						<div class="mp_qrcode" style="display: none;">
							<img
								src="/mineop/1/wstmall/Apps/Home/View/default/images/wstmall_weixin.png"
								width="148"  /><i class="icon_arrow_white"></i>
						</div></li>
					<li><a href="#top" class="return_top"><i class="top"></i></a></li>
				</div>
			</div>
			<div id="quick_links_pop" class="quick_links_pop hide"></div>
		</div>
	</div>
	<script type="text/javascript">
	var numberItem = <?php echo WSTCartNum();?>;
	$('.cart_num').html(numberItem);
	$(".quick_links_panel li").mouseenter(function() {
		$(this).children(".mp_tooltip").animate({
			left : -92,
			queue : true
		});
		$(this).children(".mp_tooltip").css("visibility", "visible");
		$(this).children(".ibar_login_box").css("display", "block");
	});
	$(".quick_links_panel li").mouseleave(function() {
		$(this).children(".mp_tooltip").css("visibility", "hidden");
		$(this).children(".mp_tooltip").animate({
			left : -121,
			queue : true
		});
		$(this).children(".ibar_login_box").css("display", "none");
	});
	$(".quick_toggle li").mouseover(function() {
		$(this).children(".mp_qrcode").show();
	});
	$(".quick_toggle li").mouseleave(function() {
		$(this).children(".mp_qrcode").hide();
	});

	// 元素以及其他一些变量
	var eleFlyElement = document.querySelector("#flyItem"), eleShopCart = document
			.querySelector("#shopCart");
	eleFlyElement.style.visibility = "hidden";
	
	var numberItem = 0;
	// 抛物线运动
	var myParabola = funParabola(eleFlyElement, eleShopCart, {
		speed : 100, //抛物线速度
		curvature : 0.0012, //控制抛物线弧度
		complete : function() {
			eleFlyElement.style.visibility = "hidden";
			jQuery.post(domainURL +"/index.php/Home/Cart/getCartGoodCnt/" ,{"axm":1},function(data) {
				var cart = WST.toJson(data);
				eleShopCart.querySelector("span").innerHTML = cart.goodscnt;
			});
			
		}
	});
	// 绑定点击事件
	if (eleFlyElement && eleShopCart) {
		[].slice
				.call(document.getElementsByClassName("btnCart"))
				.forEach(
						function(button) {
							button
									.addEventListener(
											"click",
											function(event) {
												// 滚动大小
												var scrollLeft = document.documentElement.scrollLeft
														|| document.body.scrollLeft
														|| 0, scrollTop = document.documentElement.scrollTop
														|| document.body.scrollTop
														|| 0;
												eleFlyElement.style.left = event.clientX
														+ scrollLeft + "px";
												eleFlyElement.style.top = event.clientY
														+ scrollTop + "px";
												eleFlyElement.style.visibility = "visible";
												$(eleFlyElement).show();
												// 需要重定位
												myParabola.position().move();
											});
						});
	}

	function getMyOrders(){
		document.location.href = "<?php echo U('Home/Orders/queryByPage/');?>";
	}
</script>
   	</body>
   	
   	<script src="/mineop/1/wstmall/Apps/Home/View/default/js/goods.js"></script>
<script src="/mineop/1/wstmall/Public/js/common.js"></script>
<script src="/mineop/1/wstmall/Apps/Home/View/default/js/head.js" type="text/javascript"></script>
<script src="/mineop/1/wstmall/Apps/Home/View/default/js/common.js" type="text/javascript"></script>
<script src="/mineop/1/wstmall/Apps/Home/View/default/js/pslocation.js" type="text/javascript"></script>
<script src="/mineop/1/wstmall/Apps/Home/View/default/js/jquery.jqzoom.js" type="text/javascript"></script>
<script src="/mineop/1/wstmall/Apps/Home/View/default/js/magnifier.js" type="text/javascript"></script>
<script src="/mineop/1/wstmall/Apps/Home/View/default/js/jquery.page.js" type="text/javascript"></script>
<script> 
$("#store-selector").hover(function() {
}, function() {
	$("#store-selector").removeClass("hover");
});


$(function(){
	var params = {}; 
	var goodsId = $.trim($("#goodsId").val());
	params.goodsId = goodsId;	
	
	//加载商品评价
	jQuery.post("<?php echo U('Home/Goods/getGoodsappraises/');?>" ,params,function(data) {
		var json = WST.toJson(data);
			
		var html = new Array();		    	
		for(var j=0;j<json.root.length;j++){
		    var appraises = json.root[j];
		    	
		    html.push('<tr height="75" style="border:1px dotted #eeeeee;">');
			    html.push('<td width="150" style="padding-left:6px;"><div>'+(appraises.userName?appraises.userName:"匿名")+'</div></td>');
			    html.push('<td width="*"><div>'+appraises.content+'</div></td>');
			    html.push('<td width="180">');
			    html.push('<div>商品评分：');
				for(var i=0;i<appraises.goodsScore;i++){
					html.push('<img src="'+domainURL +'/Apps/Home/View/default/images/icon_score_yes.png"/>');
				}
				html.push('</div>');
				html.push('<div>时效评分：');
				for(var i=0;i<appraises.timeScore;i++){
					html.push('<img src="'+domainURL +'/Apps/Home/View/default/images/icon_score_yes.png"/>');
				}
				html.push('</div>');
				html.push('<div>服务评分：');
				for(var i=0;i<appraises.serviceScore;i++){
					html.push('<img src="'+domainURL +'/Apps/Home/View/default/images/icon_score_yes.png"/>');
				}
				html.push('</div>');
				html.push('</td>');
				
		    html.push('</tr>');
		    	
		}
		 
		if(json.root.length>0){
		    $("#appraiseTab").html(html.join(""));
		}else{
		 	$("#appraiseTab").html("<tr><td><div style='font-size:15px;text-align:center;'>没有评价信息</div></td></tr>");
		}
		
		$(".wst-page-items").createPage({
	        pageCount:json.totalPage,
	        current:json.currPage,
	        backFn:function(p){
	        	getAppraisesPage(p);
	        }
	    });
		
	});
	
});
</script>
   	
</html>