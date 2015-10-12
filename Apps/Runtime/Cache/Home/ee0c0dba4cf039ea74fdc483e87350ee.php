<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
         <title>买家中心</title>
         <link rel="stylesheet" href="/mineop/1/wstmall/Apps/Home/View/default/css/common.css" />
         <link rel="stylesheet" href="/mineop/1/wstmall/Apps/Home/View/default/css/user.css">
         <style>
         	.wst-odetal-box{padding:10px;text-align:center;background-color:#ffffff;}
         	.wst-tab{border-collapse: collapse; }
         	.wst-tab-cpt{text-align:left;height:30px;font-weight:bold;}
         	.wst-tab tr{height:30px;}
         	.wst-tab tr td{border:1px solid #eeeeee;}
         	.wst-td-title{width:100px;text-align:right;}
         	.wst-td-content{padding-left:6px;text-align:left;}
         	.wst-align-center{text-align:center;}
         </style>
	     
    </head>
    
    <body style="background-color:#f5f5f5;">
        <div style="text-align:center;">
        	<div class="wst-odetal-box">
        	<table cellspacing="0" cellpadding="0" class="wst-tab" width="920" style="border:1px solid #eeeeee;margin:0 auto;">
        		<caption class="wst-tab-cpt">日志信息
        		<span style="color:blue;float:right;">
        			<?php if(($order["orderStatus"] == -3) OR ($order["orderStatus"] == -4)): ?>拒收(<?php if($order["isRefund"] == 1): ?>已退款<?php else: ?>未退款<?php endif; ?>
			        <?php elseif($orderInfo["order"]["orderStatus"] == -2): ?>未付款
			        <?php elseif($orderInfo["order"]["orderStatus"] == -1): ?>已取消
			        <?php elseif($orderInfo["order"]["orderStatus"] == 0): ?>未受理
			        <?php elseif($orderInfo["order"]["orderStatus"] == 1): ?>已受理
			        <?php elseif($orderInfo["order"]["orderStatus"] == 2): ?>打包中
			        <?php elseif($orderInfo["order"]["orderStatus"] == 3): ?>配送中
			        <?php elseif($orderInfo["order"]["orderStatus"] == 4): ?>已到货
			        <?php elseif($orderInfo["order"]["orderStatus"] == 5): ?>确认已收货<?php endif; ?>
        		</caption>
        		</span>
        		<tbody>
	        		<?php if(is_array($orderInfo['logs'])): $key1 = 0; $__LIST__ = $orderInfo['logs'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$log): $mod = ($key1 % 2 );++$key1;?><tr>
	        			<td width="200"><?php echo ($log["logTime"]); ?></td>
	        			<td class="wst-td-content"><?php echo ($log["logContent"]); ?></td>
	        		</tr><?php endforeach; endif; else: echo "" ;endif; ?>
        		</tbody>
        	</table>
        	</div>
        	<br/><br/>
        	<div class="wst-odetal-box">
        	<table cellspacing="0" cellpadding="0" class="wst-tab" width="920" style="border:1px solid #eeeeee;margin:0 auto;">
        		<caption class="wst-tab-cpt">订单信息</caption>
        		<tbody>
	        		<tr>
	        			<td class="wst-td-title">订单编号：</td>
	        			<td class="wst-td-content"><?php echo ($orderInfo["order"]["orderNo"]); ?></td>
	        		</tr>
	        		<tr>
	        			<td class="wst-td-title">支付方式：</td>
	        			<td class="wst-td-content"><?php if($orderInfo["order"]["payType"]==0): ?>货到付款<?php else: ?>在线支付<?php endif; ?></td>
	        		</tr>
	        		<tr>
	        			<td class="wst-td-title">配送方式：</td>
	        			<td class="wst-td-content"><?php if($orderInfo["order"]["deliverType"]==0): ?>商城配送<?php else: ?>门店配送<?php endif; ?></td>
	        		</tr>
	        		<tr>
	        		    <td class="wst-td-title">买家留言：</td>
	        		    <td class="wst-td-content"><?php echo ($orderInfo["order"]["orderRemarks"]); ?></td>
	        		</tr>
	        		<tr>
	        			<td class="wst-td-title">下单时间：</td>
	        			<td class="wst-td-content"><?php echo ($orderInfo["order"]["createTime"]); ?></td>
	        		</tr>
        		</tbody>
        	</table>
        	</div>
        	<br/><br/>
        	<div class="wst-odetal-box">
        	<table cellspacing="0" cellpadding="0" class="wst-tab" width="920" style="border:1px solid #eeeeee;margin:0 auto;">
        		<caption class="wst-tab-cpt">收货人信息</caption>
        		<tbody>
	        		
	        		<tr>
	        			<td class="wst-td-title">收货人姓名：</td>
	        			<td class="wst-td-content"><?php echo ($orderInfo["order"]["userName"]); ?></td>
	        		</tr>
	        		<tr>
	        			<td class="wst-td-title">地址：</td>
	        			<td class="wst-td-content"><?php echo ($orderInfo["order"]["userAddress"]); ?> </td>
	        		</tr>
	        		<tr>
	        			<td class="wst-td-title">邮编：</td>
	        			<td class="wst-td-content"><?php echo ($orderInfo["order"]["userPostCode"]); ?></td>
	        		</tr>
	        		<tr>
	        			<td class="wst-td-title">联系电话：</td>
	        			<td class="wst-td-content"><?php echo ($orderInfo["order"]["userPhone"]); ?> <?php if($orderInfo["order"]["userTel"] != ""): ?>| <?php echo ($orderInfo["order"]["userTel"]); endif; ?></td>
	        		</tr>
	        		<tr>
	        			<td class="wst-td-title">期望送达时间：</td>
	        			<td class="wst-td-content"><?php echo ($orderInfo["order"]["requireTime"]); ?></td>
	        		</tr>
        		</tbody>
        	</table>
        	</div>
        	<br/><br/>
        	<?php if(!empty($orderInfo["order"]["invoiceClient"])): ?><div class="wst-odetal-box">
        	<table cellspacing="0" cellpadding="0" class="wst-tab" width="920" style="border:1px solid #eeeeee;margin:0 auto;">
        		<caption class="wst-tab-cpt">发票信息</caption>
        		<tbody>
	        		<tr>
	        			<td class="wst-td-title">发票抬头：</td>
	        			<td class="wst-td-content"><?php echo ($orderInfo["order"]["invoiceClient"]); ?></td>
	        		</tr>
        		</tbody>
        	</table>
        	</div><?php endif; ?>       	
        	<div class="wst-odetal-box" style='padding-bottom:5px;'>
        	<table cellspacing="0" cellpadding="0" class="wst-tab" width="920" style="margin:0 auto;">
        		<caption class="wst-tab-cpt">商品信息</caption>
        		<tbody>
	        		<tr>
	        			<td width='*' class="wst-align-center">商品</td>
	        			<td width='150' class="wst-align-center">商品价格</td>
	        			<td width='150' class="wst-align-center">商品数量</td>
	        			<td width='150' class="wst-align-center">商品总金额</td>
	        		</tr>
	        		<?php if(is_array($orderInfo['goodsList'])): $key1 = 0; $__LIST__ = $orderInfo['goodsList'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$goods): $mod = ($key1 % 2 );++$key1;?><tr>
	        			<td class="wst-align-center" style="vertical-align: middle;">
		        			<div style="float:left;width:50px;">
			        			<a href="<?php echo U('Home/Goods/getGoodsDetails/',array('goodsId'=>$goods['goodsId']));?>" target="_blank">
			        			   <img style='margin:2px;' src="/mineop/1/wstmall/<?php echo ($goods['goodsThums']); ?>" width='50' height='50'/>
			        			</a>
		        			</div>
		        			<div style="float:left;width:360px;text-align: left;vertical-align: middle;margin-left: 8px;line-height: 20px;padding-top:15px;">
		        				<a href="<?php echo U('Home/Goods/getGoodsDetails/',array('goodsId'=>$goods['goodsId']));?>/mineop/1/wstmall/index.php/Home/Goods/getGoodsDetails/?goodsId=<?php echo ($goods['goodsId']); ?>" target="_blank">
		        				<?php echo ($goods["goodsName"]); if($goods['goodsAttrName'] != ''): ?>【<?php echo ($goods['goodsAttrName']); ?>】<?php endif; ?>
		        				</a>
		        			</div>
		        			<div class="wst-clear"></div>
	        			</td>
	        			<td class="wst-align-center">￥<?php echo ($goods["shopPrice"]); ?></td>
	        			<td class="wst-align-center"><?php echo ($goods["goodsNums"]); ?></td>
	        			<td class="wst-align-center">￥<?php echo ($goods["shopPrice"]*$goods["goodsNums"]); ?></td>
	        		</tr><?php endforeach; endif; else: echo "" ;endif; ?>
        		</tbody>
        		<tr>
        		   <td colspan='4' style='border-left:0px;border-right:0px;border-bottom:0px;text-align:right;padding-right:5px;'>
        		  商品总金额： ￥<?php echo ($orderInfo["order"]["totalMoney"]); ?>  <br/>
        		   + 运费：￥<?php echo ($orderInfo["order"]["deliverMoney"]); ?><br/> 
        		   <span style='font-weight:bold;font-size:20px;'>订单总金额：</span><span style='font-weight:bold;font-size:20px;color:red;'>￥<?php echo ($orderInfo["order"]["totalMoney"]+$orderInfo["order"]["deliverMoney"]); ?></span></td>
        		</tr>
        	</table>
        	</div>
        </div>
    </body>


</html>