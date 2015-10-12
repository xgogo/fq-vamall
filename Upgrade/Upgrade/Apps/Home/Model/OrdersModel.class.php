<?php
namespace Home\Model;
/**
 * ============================================================================
 * WSTMall开源商城
 * 官网地址:http://www.wstmall.com 
 * 联系QQ:707563272
 * ============================================================================
 * 订单服务类
 */
class OrdersModel extends BaseModel {
	/**
	 * 获以订单列表
	 */
	public function getOrdersList($obj){
		$userId = $obj["userId"];
		$m = M('orders');
		$sql = "SELECT * FROM __PREFIX__orders WHERE userId = $userId AND orderStatus <>-1 order by createTime desc";		
		return $m->pageQuery($sql);
	}
	
	/**
	 * 取消订单记录 
	 */
	public function getcancelOrderList($obj){		
		$userId = $obj["userId"];
		$m = M('orders');
		$sql = "SELECT * FROM __PREFIX__orders WHERE userId = $userId AND orderStatus =-1 order by createTime desc";		
		return $m->pageQuery($sql);
		
	}

	/**
	 * 获取订单详情
	 */
	public function getOrdersDetails($obj){		
		$orderId = $obj["orderId"];
		$sql = "SELECT od.*,sp.shopName 
				FROM __PREFIX__orders od, __PREFIX__shops sp 
				WHERE od.shopId = sp.shopId And orderId = $orderId ";		
		$rs = $this->query($sql);;	
		return $rs;
		
	}
	
	/**
	 * 获取订单商品信息
	 */
	public function getOrdersGoods($obj){	
			
		$orderId = $obj["orderId"];
		$sql = "SELECT g.*,og.goodsNums as ogoodsNums,og.goodsPrice as ogoodsPrice 
				FROM __PREFIX__order_goods og, __PREFIX__goods g 
				WHERE og.orderId = $orderId AND og.goodsId = g.goodsId ";		
		$rs = $this->query($sql);	
		return $rs;
		
	}
	
	/**
	 * 
	 * 获取订单商品详情
	 */
	public function getOrdersGoodsDetails($obj){	
			
		$orderId = $obj["orderId"];
		$sql = "SELECT g.*,og.goodsNums as ogoodsNums,og.goodsPrice as ogoodsPrice ,ga.id as gaId
				FROM __PREFIX__order_goods og, __PREFIX__goods g 
				LEFT JOIN __PREFIX__goods_appraises ga ON g.goodsId = ga.goodsId AND ga.orderId = $orderId
				WHERE og.orderId = $orderId AND og.goodsId = g.goodsId";		
		$rs = $this->query($sql);	
		return $rs;
		
	}
	
	/**
	 *
	 * 获取订单商品详情
	 */
	public function getPayOrders($obj){
			
		$orderIds = $obj["orderIds"];
		$sql = "SELECT o.orderId, o.orderNo, g.goodsId, g.goodsName, og.goodsNums ,og.goodsPrice 
				FROM __PREFIX__order_goods og, __PREFIX__goods g, __PREFIX__orders o
				WHERE o.orderId = og.orderId AND og.goodsId = g.goodsId AND o.payType=1 AND orderFlag =1 AND o.isPay=0 AND o.needPay>0 AND o.orderStatus = -2 AND og.orderId in ($orderIds)";
		$rslist = $this->query($sql);
		$orders = array();
		foreach ($rslist as $key => $order) {
			$orders[$order["orderNo"]][] = $order;
		}
		$sql = "SELECT SUM(needPay) needPay FROM __PREFIX__orders WHERE orderId IN ($orderIds) AND isPay=0 AND payType=1 AND needPay>0 AND orderStatus = -2 AND orderFlag =1";
		$payInfo = self::queryRow($sql);
		$data["orders"] = $orders;
		$data["needPay"] = $payInfo["needPay"];
		return $data;
	
	}
	
	
	/**
	 * 提交订单
	 */
	public function addOrders($userId,$consigneeId,$payway,$needreceipt,$catgoods,$orderunique,$isself){	
		
		$orderInfos = array();
		$orderIds = array();
		$orderNos = array();
		$remarks = I("remarks");
		
		$addressInfo = UserAddressModel::getAddressDetails($consigneeId);
        $m = M('orderids');
        $m->startTrans();
		foreach ($catgoods as $key=> $shopgoods){
			//生成订单ID
			$orderSrcNo = $m->add(array('rnd'=>microtime(true)));
			$orderNo = $orderSrcNo."".(fmod($orderSrcNo,7));
			//创建订单信息
			$data = array();
			$pshopgoods = $shopgoods["shopgoods"];
			$shopId = $pshopgoods[0]["shopId"];
			$data["orderNo"] = $orderNo;
			$data["shopId"] = $shopId;	
			$deliverType = intval($pshopgoods[0]["deliveryType"]);
			$data["userId"] = $userId;	
				
			$data["orderFlag"] = 1;
			$data["totalMoney"] = $shopgoods["totalMoney"];
			if($isself==1){//自提
				$deliverMoney = 0;
			}else{
				$deliverMoney = ($shopgoods["totalMoney"]<$shopgoods["deliveryFreeMoney"])?$shopgoods["deliveryMoney"]:0;
			}
			$data["deliverMoney"] = $deliverMoney;
			$data["payType"] = $payway;
			$data["deliverType"] = $deliverType;
			$data["userName"] = $addressInfo["userName"];
			$data["areaId1"] = $addressInfo["areaId1"];
			$data["areaId2"] = $addressInfo["areaId2"];
			$data["areaId3"] = $addressInfo["areaId3"];
			$data["communityId"] = $addressInfo["communityId"];
			$data["userAddress"] = $addressInfo["paddress"]." ".$addressInfo["address"];
			$data["userTel"] = $addressInfo["userTel"];
			$data["userPhone"] = $addressInfo["userPhone"];
			
			$data['orderScore'] = round($data["totalMoney"]+$data["deliverMoney"],0);
			$data["isInvoice"] = $needreceipt;		
			$data["orderRemarks"] = $remarks;
			$data["requireTime"] = I("requireTime");
			$data["invoiceClient"] = I("invoiceClient");
			$data["isAppraises"] = 0;
			$data["isSelf"] = $isself;
			$data["needPay"] = $shopgoods["totalMoney"]+$deliverMoney;

			$data["createTime"] = date("Y-m-d H:i:s");
			$payMoney = $shopgoods["totalMoney"]+$deliverMoney;
			
			
			if($payway==1){
				$data["orderStatus"] = -2;
			}else{
				$data["orderStatus"] = 0;
			}
			
			$data["orderunique"] = $orderunique;
			$data["isPay"] = 0;
			$morders = M('orders');
			$orderId = $morders->add($data);	
			
			
			$orderNos[] = $data["orderNo"];
			$orderInfos[] = array("orderId"=>$orderId,"orderNo"=>$data["orderNo"]) ;
			//订单创建成功则建立相关记录
			if($orderId>0){
				$orderIds[] = $orderId;
				//建立订单商品记录表
				$mog = M('order_goods');
				foreach ($pshopgoods as $key=> $sgoods){
					$data = array();
					$data["orderId"] = $orderId;
					$data["goodsId"] = $sgoods["goodsId"];
					$data["goodsAttrId"] = (int)$sgoods["goodsAttrId"];
					if($sgoods["attrVal"]!='')$data["goodsAttrName"] = $sgoods["attrName"].":".$sgoods["attrVal"];
					$data["goodsNums"] = $sgoods["cnt"];
					$data["goodsPrice"] = $sgoods["shopPrice"];
					
					$data["goodsName"] = $sgoods["goodsName"];
					$data["goodsThums"] = $sgoods["goodsThums"];
					
					$mog->add($data);
					
				}
			
				if($payway==0){
					//建立订单记录
					$data = array();
					$data["orderId"] = $orderId;
					$data["logContent"] = ($pshopgoods[0]["deliverType"]==0)? "下单成功":"下单成功等待审核";
					$data["logUserId"] = $userId;
					$data["logType"] = 0;
					$data["logTime"] = date('Y-m-d H:i:s');
					$mlogo = M('log_orders');
					$mlogo->add($data);
					
					
					//建立订单提醒
					$sql ="SELECT userId,shopId,shopName FROM __PREFIX__shops WHERE shopId=$shopId AND shopFlag=1  ";
					$users = $this->query($sql);
					$morm = M('order_reminds');
					for($i=0;$i<count($users);$i++){
						$data = array();
						$data["orderId"] = $orderId;
						$data["shopId"] = $shopId;
						$data["userId"] = $users[$i]["userId"];
						$data["userType"] = 0;
						$data["remindType"] = 0;
						$data["createTime"] = date("Y-m-d H:i:s");
						$morm->add($data);
					}
					
					//修改库存
					foreach ($pshopgoods as $key=> $sgoods){
						$sql="update __PREFIX__goods set goodsStock=goodsStock-".$sgoods['cnt']." where goodsId=".$sgoods["goodsId"];
						$this->query($sql);
						if((int)$sgoods["goodsAttrId"]>0){
							$sql="update __PREFIX__goods_attributes set attrStock=attrStock-".$sgoods['cnt']." where id=".$sgoods["goodsAttrId"];
							$this->execute($sql);
						}
					}
				}else{
					$data = array();
					$data["orderId"] = $orderId;
					$data["logContent"] = "订单已提交，等待支付";
					$data["logUserId"] = $userId;
					$data["logType"] = 0;
					$data["logTime"] = date('Y-m-d H:i:s');
					$mlogo = M('log_orders');
					$mlogo->add($data);
				}
			}
			
			
		}
		if(count($orderIds)>0){
			$m->commit();
		}else{
			$m->rollback();
		}
		return array("orderIds"=>$orderIds,"orderInfos"=>$orderInfos,"orderNos"=>$orderNos);
		
	}
	
	/**
	 * 获取待付款订单
	 */
	public function queryByPage($obj){
		$userId = $obj["userId"];
		$pcurr = I("pcurr",0);
		$pageSize = 5;
		$sql = "SELECT o.* FROM __PREFIX__orders o
				WHERE userId = $userId AND orderFlag=1 order by orderId desc";
		$pages = $this->pageQuery($sql,$pcurr,$pageSize);	
		$orderList = $pages["root"];
		if(count($orderList)>0){
			$orderIds = array();
			for($i=0;$i<count($orderList);$i++){
				$order = $orderList[$i];
				$orderIds[] = $order["orderId"];
			}
			//获取涉及的商品
	        $sql = "SELECT og.goodsId,og.goodsName,og.goodsThums,og.orderId FROM __PREFIX__order_goods og
					WHERE og.orderId in (".implode(',',$orderIds).")";	
	        $glist = $this->query($sql);
			$goodslist = array();
			for($i=0;$i<count($glist);$i++){
				$goods = $glist[$i];
				$goodslist[$goods["orderId"]][] = $goods;
			}
			//放回分页数据里
			for($i=0;$i<count($orderList);$i++){
				$order = $orderList[$i];
				$order["goodslist"] = $goodslist[$order['orderId']];
				$pages["root"][$i] = $order;
			}
		}
		return $pages;
	}

	/**
	 * 获取待付款订单
	 */
	public function queryPayByPage($obj){
		$userId = $obj["userId"];
		$orderNo = I("orderNo");
		$orderStatus = I("orderStatus",0);
		$goodsName = I("goodsName");
		$shopName = I("shopName");
		$userName = I("userName");
		$sdate = I("sdate");
		$edate = I("edate");
		$pcurr = I("pcurr",0);
		$pageSize = 20;
		
		$sql = "SELECT o.*,sp.shopId,sp.shopName FROM __PREFIX__orders o,__PREFIX__shops sp WHERE o.userId = $userId AND o.orderStatus =-2 AND o.payType = 1 AND o.shopId=sp.shopId ";
		if($orderNo!=""){
			$sql .= " AND o.orderNo like '%$orderNo%'";
		}
		if($userName!=""){
			$sql .= " AND o.userName like '%$userName%'";
		}
		if($shopName!=""){
			$sql .= " AND sp.shopName like '%$shopName%'";
		}
		if($sdate!=""){
			$sql .= " AND o.createTime >= $sdate";
		}
		if($edate!=""){
			$sql .= " AND o.createTime <= $edate";
		}
		$sql .= " order by o.orderId desc";
		$pages = $this->pageQuery($sql,$pcurr,$pageSize);	
		$orderList = $pages["root"];
		if(count($orderList)>0){
			$orderIds = array();
			for($i=0;$i<count($orderList);$i++){
				$order = $orderList[$i];
				$orderIds[] = $order["orderId"];
			}
			//获取涉及的商品
	        $sql = "SELECT og.goodsId,og.goodsName,og.goodsThums,og.orderId FROM __PREFIX__order_goods og
					WHERE og.orderId in (".implode(',',$orderIds).")";	
			$glist = $this->query($sql);
			$goodslist = array();
			for($i=0;$i<count($glist);$i++){
				$goods = $glist[$i];
				$goodslist[$goods["orderId"]][] = $goods;
			}
			//放回分页数据里
			for($i=0;$i<count($orderList);$i++){
				$order = $orderList[$i];
				$order["goodslist"] = $goodslist[$order['orderId']];
				$pages["root"][$i] = $order;
			}
		}
		return $pages;
	}
	
	
	
	/**
	 * 获取待确认收货
	 */
	public function queryReceiveByPage($obj){
		$userId = $obj["userId"];
		$orderNo = I("orderNo");
		$orderStatus = I("orderStatus",0);
		$goodsName = I("goodsName");
		$shopName = I("shopName");
		$userName = I("userName");
		$sdate = I("sdate");
		$edate = I("edate");
		$pcurr = I("pcurr",0);
		$pageSize = 20;

		$sql = "SELECT o.*,sp.shopId,sp.shopName FROM __PREFIX__orders o,__PREFIX__shops sp WHERE o.userId = $userId AND o.orderStatus =3 AND o.shopId=sp.shopId ";
		if($orderNo!=""){
			$sql .= " AND o.orderNo like '%$orderNo%'";
		}
		if($userName!=""){
			$sql .= " AND o.userName like '%$userName%'";
		}
		if($shopName!=""){
			$sql .= " AND sp.shopName like '%$shopName%'";
		}
		if($sdate!=""){
			$sql .= " AND o.createTime >= $sdate";
		}
		if($edate!=""){
			$sql .= " AND o.createTime <= $edate";
		}
		$sql .= " order by o.orderId desc";
		$pages = $this->pageQuery($sql,$pcurr,$pageSize);	
		$orderList = $pages["root"];
		if(count($orderList)>0){
			$orderIds = array();
			for($i=0;$i<count($orderList);$i++){
				$order = $orderList[$i];
				$orderIds[] = $order["orderId"];
			}
			//获取涉及的商品
	        $sql = "SELECT og.goodsId,og.goodsName,og.goodsThums,og.orderId FROM __PREFIX__order_goods og
					WHERE og.orderId in (".implode(',',$orderIds).")";	
			$glist = $this->query($sql);
			$goodslist = array();
			for($i=0;$i<count($glist);$i++){
				$goods = $glist[$i];
				$goodslist[$goods["orderId"]][] = $goods;
			}
			//放回分页数据里
			for($i=0;$i<count($orderList);$i++){
				$order = $orderList[$i];
				$order["goodslist"] = $goodslist[$order['orderId']];
				$pages["root"][$i] = $order;
			}
		}
		return $pages;
	}
    /**
	 * 获取待发货订单
	 */
	public function queryDeliveryByPage($obj){
		$userId = $obj["userId"];
		$orderNo = I("orderNo");
		$orderStatus = I("orderStatus",0);
		$goodsName = I("goodsName");
		$shopName = I("shopName");
		$userName = I("userName");
		$sdate = I("sdate");
		$edate = I("edate");
		$pcurr = I("pcurr",0);
		$pageSize = 20;

		$sql = "SELECT o.*,sp.shopId,sp.shopName FROM __PREFIX__orders o,__PREFIX__shops sp WHERE o.userId = $userId AND o.orderStatus in ( 0,1,2 ) AND o.shopId=sp.shopId ";
		if($orderNo!=""){
			$sql .= " AND o.orderNo like '%$orderNo%'";
		}
		if($userName!=""){
			$sql .= " AND o.userName like '%$userName%'";
		}
		if($shopName!=""){
			$sql .= " AND sp.shopName like '%$shopName%'";
		}
		if($sdate!=""){
			$sql .= " AND o.createTime >= $sdate";
		}
		if($edate!=""){
			$sql .= " AND o.createTime <= $edate";
		}
		$sql .= " order by o.orderId desc";
		$pages = $this->pageQuery($sql,$pcurr,$pageSize);	
		$orderList = $pages["root"];
		if(count($orderList)>0){
			$orderIds = array();
			for($i=0;$i<count($orderList);$i++){
				$order = $orderList[$i];
				$orderIds[] = $order["orderId"];
			}
			//获取涉及的商品
	        $sql = "SELECT og.goodsId,og.goodsName,og.goodsThums,og.orderId FROM __PREFIX__order_goods og
					WHERE og.orderId in (".implode(',',$orderIds).")";	
			$glist = $this->query($sql);
			$goodslist = array();
			for($i=0;$i<count($glist);$i++){
				$goods = $glist[$i];
				$goodslist[$goods["orderId"]][] = $goods;
			}
			//放回分页数据里
			for($i=0;$i<count($orderList);$i++){
				$order = $orderList[$i];
				$order["goodslist"] = $goodslist[$order['orderId']];
				$pages["root"][$i] = $order;
			}
		}
		return $pages;
	}
    /**
	 * 获取退款
	 */
	public function queryRefundByPage($obj){
		$userId = $obj["userId"];
		$orderNo = I("orderNo");
		$orderStatus = I("orderStatus",0);
		$goodsName = I("goodsName");
		$shopName = I("shopName");
		$userName = I("userName");
		$sdate = I("sdate");
		$edate = I("edate");
		$pcurr = I("pcurr",0);
		$pageSize = 20;
		//必须是在线支付的才允许退款

		$sql = "SELECT o.*,sp.shopId,sp.shopName FROM __PREFIX__orders o,__PREFIX__shops sp WHERE o.userId = $userId AND (o.orderStatus in (-3,-4) or (o.orderStatus =-1 and payType =1 AND o.isPay =1)) AND o.shopId=sp.shopId ";
		if($orderNo!=""){
			$sql .= " AND o.orderNo like '%$orderNo%'";
		}
		if($userName!=""){
			$sql .= " AND o.userName like '%$userName%'";
		}
		if($shopName!=""){
			$sql .= " AND sp.shopName like '%$shopName%'";
		}
		if($sdate!=""){
			$sql .= " AND o.createTime >= $sdate";
		}
		if($edate!=""){
			$sql .= " AND o.createTime <= $edate";
		}
		$sql .= " order by o.orderId desc";
		
		$pages = $this->pageQuery($sql,$pcurr,$pageSize);	
		$orderList = $pages["root"];
		if(count($orderList)>0){
			$orderIds = array();
			for($i=0;$i<count($orderList);$i++){
				$order = $orderList[$i];
				$orderIds[] = $order["orderId"];
			}
			//获取涉及的商品
	        $sql = "SELECT og.goodsId,og.goodsName,og.goodsThums,og.orderId FROM __PREFIX__order_goods og
					WHERE og.orderId in (".implode(',',$orderIds).")";	
			$glist = $this->query($sql);
			$goodslist = array();
			for($i=0;$i<count($glist);$i++){
				$goods = $glist[$i];
				$goodslist[$goods["orderId"]][] = $goods;
			}
			//放回分页数据里
			for($i=0;$i<count($orderList);$i++){
				$order = $orderList[$i];
				$order["goodslist"] = $goodslist[$order['orderId']];
				$pages["root"][$i] = $order;
			}
		}
		return $pages;
	}
	
	/**
	 * 获取取消的订单
	 */
	public function queryCancelOrders($obj){
		$userId = $obj["userId"];
		$orderNo = I("orderNo");
		$orderStatus = I("orderStatus",0);
		$goodsName = I("goodsName");
		$shopName = I("shopName");
		$userName = I("userName");
		$sdate = I("sdate");
		$edate = I("edate");
		$pcurr = I("pcurr",0);
		$pageSize = 20;

		$sql = "SELECT o.*,sp.shopId,sp.shopName FROM __PREFIX__orders o,__PREFIX__shops sp WHERE o.userId = $userId AND o.orderStatus in (-1,-5) AND o.shopId=sp.shopId ";
		if($orderNo!=""){
			$sql .= " AND o.orderNo like '%$orderNo%'";
		}
		if($userName!=""){
			$sql .= " AND o.userName like '%$userName%'";
		}
		if($shopName!=""){
			$sql .= " AND sp.shopName like '%$shopName%'";
		}
		if($sdate!=""){
			$sql .= " AND o.createTime >= $sdate";
		}
		if($edate!=""){
			$sql .= " AND o.createTime <= $edate";
		}
		$sql .= " order by o.orderId desc";
		$pages = $this->pageQuery($sql,$pcurr,$pageSize);	
		$orderList = $pages["root"];
		if(count($orderList)>0){
			$orderIds = array();
			for($i=0;$i<count($orderList);$i++){
				$order = $orderList[$i];
				$orderIds[] = $order["orderId"];
			}
			//获取涉及的商品
	        $sql = "SELECT og.goodsId,og.goodsName,og.goodsThums,og.orderId FROM __PREFIX__order_goods og
					WHERE og.orderId in (".implode(',',$orderIds).")";	
			$glist = $this->query($sql);
			$goodslist = array();
			for($i=0;$i<count($glist);$i++){
				$goods = $glist[$i];
				$goodslist[$goods["orderId"]][] = $goods;
			}
			//放回分页数据里
			for($i=0;$i<count($orderList);$i++){
				$order = $orderList[$i];
				$order["goodslist"] = $goodslist[$order['orderId']];
				$pages["root"][$i] = $order;
			}
		}
		return $pages;
	}
	
	/**
	 * 获取待评价交易
	 */
	public function queryAppraiseByPage($obj){
		$userId = $obj["userId"];
		$orderNo = I("orderNo");
		$orderStatus = I("orderStatus",0);
		$goodsName = I("goodsName");
		$shopName = I("shopName");
		$userName = I("userName");
		$sdate = I("sdate");
		$edate = I("edate");
		$pcurr = I("pcurr",0);
		$pageSize = 20;
		$sql = "SELECT o.*,sp.shopId,sp.shopName FROM __PREFIX__orders o,__PREFIX__shops sp WHERE o.userId = $userId AND o.shopId=sp.shopId ";	
		if($orderNo!=""){
			$sql .= " AND o.orderNo like '%$orderNo%'";
		}
		if($userName!=""){
			$sql .= " AND o.userName like '%$userName%'";
		}
		if($shopName!=""){
			$sql .= " AND sp.shopName like '%$shopName%'";
		}
		if($sdate!=""){
			$sql .= " AND o.createTime >= $sdate";
		}
		if($edate!=""){
			$sql .= " AND o.createTime <= $edate";
		}
		if($orderStatus==0){
			$sql .= " AND o.orderStatus in (4,5)";
		}else{
			$sql .= " AND o.orderStatus =$orderStatus";
		}
		$sql .= " order by o.orderId desc";
		$pages = $this->pageQuery($sql,$pcurr,$pageSize);	
		$orderList = $pages["root"];
		if(count($orderList)>0){
			$orderIds = array();
			for($i=0;$i<count($orderList);$i++){
				$order = $orderList[$i];
				$orderIds[] = $order["orderId"];
			}
			//获取涉及的商品
	        $sql = "SELECT og.goodsId,og.goodsName,og.goodsThums,og.orderId FROM __PREFIX__order_goods og
					WHERE og.orderId in (".implode(',',$orderIds).")";	
			$glist = $this->query($sql);
			$goodslist = array();
			for($i=0;$i<count($glist);$i++){
				$goods = $glist[$i];
				$goodslist[$goods["orderId"]][] = $goods;
			}
			//放回分页数据里
			for($i=0;$i<count($orderList);$i++){
				$order = $orderList[$i];
				$order["goodslist"] = $goodslist[$order['orderId']];
				$pages["root"][$i] = $order;
			}
		}
		return $pages;
	}
	/**
	 * 取消订单
	 */
	public function orderCancel($obj){		
		$userId = $obj["userId"];
		$orderId = $obj["orderId"];
		$rsdata = array();
		$sql = "SELECT orderId,orderNo,orderStatus FROM __PREFIX__orders WHERE orderId = $orderId and orderFlag = 1 and userId=".$userId;		
		$rsv = $this->queryRow($sql);
		$cancelStatus = array(0,1,2,3,-2);
		if(!in_array_case($rsv["orderStatus"], $cancelStatus)){
			$rsdata["status"] = -1;
			return $rsdata;
		}
		
		$sql = "UPDATE __PREFIX__orders set orderStatus = -1 WHERE orderId = $orderId and userId=".$userId;	
		$rs = $this->query($sql);		
		
		$sql = "select ord.deliverType, ord.orderId, og.goodsId ,og.goodsId, og.goodsNums 
				from __PREFIX__orders ord , __PREFIX__order_goods og 
				WHERE ord.orderId = og.orderId AND ord.orderId = $orderId";
		$ogoodsList = $this->query($sql);
		
		for($i=0;$i<count($ogoodsList);$i++){
			$sgoods = $ogoodsList[$i];
			$sql="update __PREFIX__goods set goodsStock=goodsStock+".$sgoods['goodsNums']." where goodsId=".$sgoods["goodsId"];
			$this->query($sql);
			
		}
		$sql="Delete From __PREFIX__order_reminds where orderId=".$orderId." AND remindType=0";
		$this->query($sql);
		
		$data = array();
		$m = M('log_orders');
		$data["orderId"] = $orderId;
		$data["logContent"] = "用户已取消订单";
		$data["logUserId"] = $userId;
		$data["logType"] = 0;
		$data["logTime"] = date('Y-m-d H:i:s');
		$ra = $m->add($data);
		$rsdata["status"] = $ra;
		return $rsdata;
		
	}
	/**
	 * 用户确认收货
	 */
	public function orderConfirm ($obj){		
		$userId = $obj["userId"];
		$orderId = $obj["orderId"];
		$type = $obj["type"];
		$rsdata = array();
		$sql = "SELECT orderId,orderNo,orderScore,orderStatus FROM __PREFIX__orders WHERE orderId = $orderId and userId=".$userId;		
		$rsv = $this->queryRow($sql);
		if($rsv["orderStatus"]!=3){
			$rsdata["status"] = -1;
			return $rsdata;
		}		
        //收货则给用户增加积分
        if($type==1){
        	$sql = "UPDATE __PREFIX__orders set orderStatus = 4 WHERE orderId = $orderId and userId=".$userId;			
        	$rs = $this->query($sql);
        	
        	//修改商品销量
        	$sql = "UPDATE __PREFIX__goods g, __PREFIX__order_goods og, __PREFIX__orders o SET g.saleCount=g.saleCount+og.goodsNums WHERE g.goodsId= og.goodsId AND og.orderId = o.orderId AND o.orderId=$orderId AND o.userId=".$userId;
        	$rs = $this->query($sql);
        	
        	$sql = "UPDATE __PREFIX__users set userScore=userScore+".$rsv["orderScore"]." WHERE userId=".$userId;
        	$rs = $this->query($sql);
        }else{
        	$sql = "UPDATE __PREFIX__orders set orderStatus = -3 WHERE orderId = $orderId and userId=".$userId;		
        	$rs = $this->query($sql);
        }
        //增加记录
		$data = array();
		$m = M('log_orders');
		$data["orderId"] = $orderId;
		$data["logContent"] = ($type==1)?"用户已收货":"用户拒收";
		$data["logUserId"] = $userId;
		$data["logType"] = 0;
		$data["logTime"] = date('Y-m-d H:i:s');
		$ra = $m->add($data);
		$rsdata["status"] = $ra;;
		return $rsdata;
	}
	
    /**
     * 获取订单详情
     */
	public function getOrderDetails($obj){
		$userId = (int)$obj["userId"];
		$shopId = (int)$obj["shopId"];
		$orderId = $obj["orderId"];
		$data = array();
		$sql = "SELECT * FROM __PREFIX__orders WHERE orderId = $orderId and (userId=".$userId." or shopId=".$shopId.")";	
		$order = $this->queryRow($sql);
		if(empty($order))return $data;
		$data["order"] = $order;

		$sql = "select og.orderId, og.goodsId ,g.goodsSn, og.goodsNums, og.goodsName , og.goodsPrice shopPrice,og.goodsThums,og.goodsAttrName,og.goodsAttrName 
				from __PREFIX__goods g , __PREFIX__order_goods og 
				WHERE g.goodsId = og.goodsId AND og.orderId = $orderId";
		$goods = $this->query($sql);
		$data["goodsList"] = $goods;
		
		for($i=0;$i<count($ogoodsList);$i++){
			$sgoods = $ogoodsList[$i];
			$sql="update __PREFIX__goods set goodsStock=goodsStock+".$sgoods['goodsNums']." where goodsId=".$sgoods["goodsId"];
			$this->query($sql);
		}
		
		$sql = "SELECT * FROM __PREFIX__log_orders WHERE orderId = $orderId ";	
		$logs = $this->query($sql);
		$data["logs"] = $logs;
		
		return $data;
		
	}
	/**
	 * 获取指定状态的订单数目
	 */
	public function getOrderStatusCount($obj){
		$userId = $obj["userId"];
		$data = array();
		$sql = "select orderStatus,COUNT(*) cnt from __PREFIX__orders WHERE orderStatus in (1,2,3) and orderFlag=1 and userId = $userId GROUP BY orderStatus";
		$olist = $this->query($sql);
		$data = array('-3'=>0,'-2'=>0,'2'=>0,'3'=>0,'4'=>0);
		for($i=0;$i<count($olist);$i++){
			$row = $olist[$i];
			if($row["orderStatus"]==1 || $row["orderStatus"]==2){
				$row["orderStatus"] = 2;
			}
			$data[$row["orderStatus"]] = $data[$row["orderStatus"]]+$row["cnt"];
		}
		//获取未支付订单
		$sql = "select COUNT(*) cnt from __PREFIX__orders WHERE orderStatus = -2 and isRefund=0 and payType=1 and orderFlag=1 and isPay = 0 and needPay >0 and userId = $userId";
		$olist = $this->query($sql);
		$data[-2] = $olist[0]['cnt'];
		
		//获取退款订单
		$sql = "select COUNT(*) cnt from __PREFIX__orders WHERE orderStatus in (-3,-4) and isRefund=0 and payType=1 and orderFlag=1 and userId = $userId";
		$olist = $this->query($sql);
		$data[-3] = $olist[0]['cnt'];
		//获取待评价订单
		$sql = "select COUNT(*) cnt from __PREFIX__orders WHERE orderStatus = 4 and isAppraises=0 and orderFlag=1 and userId = $userId";
		$olist = $this->query($sql);
		$data[4] = $olist[0]['cnt'];
		return $data;
		
	}
	
	/**
	 * 获取商家订单列表
	 */
	public function queryShopOrders($obj){		
		$userId = $obj["userId"];
		$shopId = $obj["shopId"];
		$pcurr = I("pcurr",0);
		$pageSize = 10;
		$orderStatus = I("statusMark");
		
		$orderNo = I("orderNo");
		$userName = I("userName");
		$userAddress = I("userAddress");
		$rsdata = array();
		if($orderStatus==6){
			$sql = "SELECT * FROM __PREFIX__orders WHERE shopId = $shopId AND (orderStatus in (-3,-4,-5) OR (orderStatus =-1 AND ((payType=1 AND isPay=1) OR payType=0)))";
		}else{
			$sql = "SELECT * FROM __PREFIX__orders WHERE shopId = $shopId AND orderStatus = $orderStatus ";	
		}
		if($orderNo!=""){
			$sql .= " AND orderNo like '%$orderNo%'";
		}
		if($userName!=""){
			$sql .= " AND userName like '%$userName%'";
		}
		if($userAddress!=""){
			$sql .= " AND userAddress like '%$userAddress%'";
		}
		$sql.=" order by orderId desc ";
		$data = $this->pageQuery($sql,$pcurr,$pageSize);	
		
		return $data;
		
	}
	
	/**
	 * 商家受理订单-只能受理【未受理】的订单
	 */
	public function shopOrderAccept ($obj){		
		$userId = $obj["userId"];
		$orderId = $obj["orderId"];
		$shopId = $obj["shopId"];
		$rsdata = array();
		$sql = "SELECT orderId,orderNo,orderStatus FROM __PREFIX__orders WHERE orderId = $orderId AND orderFlag=1 and shopId=".$shopId;		
		$rsv = $this->queryRow($sql);
		if($rsv["orderStatus"]!=0){
			$rsdata["status"] = -1;
			return $rsdata;
		}

		$sql = "UPDATE __PREFIX__orders set orderStatus = 1 WHERE orderId = $orderId and shopId=".$shopId;		
		$rs = $this->query($sql);		

		$data = array();
		$m = M('log_orders');
		$data["orderId"] = $orderId;
		$data["logContent"] = "商家已受理订单";
		$data["logUserId"] = $userId;
		$data["logType"] = 0;
		$data["logTime"] = date('Y-m-d H:i:s');
		$ra = $m->add($data);
		$rsdata["status"] = $ra;
		return $rsdata;
		
	}
	
	/**
	 * 商家打包订单-只能处理[受理]的订单
	 */
	public function shopOrderProduce ($obj){		
		$userId = $obj["userId"];
		$shopId = $obj["shopId"];
		$orderId = $obj["orderId"];
		$rsdata = array();
		$sql = "SELECT orderId,orderNo,orderStatus FROM __PREFIX__orders WHERE orderId = $orderId AND orderFlag =1 and shopId=".$shopId;		
		$rsv = $this->queryRow($sql);
		if($rsv["orderStatus"]!=1){
			$rsdata["status"] = -1;
			return $rsdata;
		}

		$sql = "UPDATE __PREFIX__orders set orderStatus = 2 WHERE orderId = $orderId and shopId=".$shopId;		
		$rs = $this->query($sql);		
		$data = array();
		$m = M('log_orders');
		$data["orderId"] = $orderId;
		$data["logContent"] = "订单打包中";
		$data["logUserId"] = $userId;
		$data["logType"] = 0;
		$data["logTime"] = date('Y-m-d H:i:s');
		$ra = $m->add($data);
		$rsdata["status"] = $ra;;
		return $rsdata;
	}
	
	/**
	 * 商家发货配送订单
	 */
	public function shopOrderDelivery ($obj){		
		$userId = $obj["userId"];
		$orderId = $obj["orderId"];
		$shopId = $obj["shopId"];
		$rsdata = array();
		$sql = "SELECT orderId,orderNo,orderStatus FROM __PREFIX__orders WHERE orderId = $orderId AND orderFlag =1 and shopId=".$shopId;		
		$rsv = $this->queryRow($sql);
		if($rsv["orderStatus"]!=2){
			$rsdata["status"] = -1;
			return $rsdata;
		}

		$sql = "UPDATE __PREFIX__orders set orderStatus = 3 WHERE orderId = $orderId and shopId=".$shopId;		
		$rs = $this->query($sql);		

		$data = array();
		$m = M('log_orders');
		$data["orderId"] = $orderId;
		$data["logContent"] = "商家已发货";
		$data["logUserId"] = $userId;
		$data["logType"] = 0;
		$data["logTime"] = date('Y-m-d H:i:s');
		$ra = $m->add($data);
		$rsdata["status"] = $ra;;
		return $rsdata;
	}
	
	/**
	 * 商家确认收货
	 */
	public function shopOrderReceipt ($obj){		
		$userId = $obj["userId"];
		$shopId = $obj["shopId"];
		$orderId = $obj["orderId"];
		$rsdata = array();
		$sql = "SELECT orderId,orderNo,orderStatus FROM __PREFIX__orders WHERE orderId = $orderId AND orderFlag =1 and shopId=".$shopId;		
		$rsv = $this->queryRow($sql);
		if($rsv["orderStatus"]!=4){
			$rsdata["status"] = -1;
			return $rsdata;
		}

		$sql = "UPDATE __PREFIX__orders set orderStatus = 5 WHERE orderId = $orderId and shopId=".$shopId;		
		$rs = $this->query($sql);		

		$data = array();
		$m = M('log_orders');
		$data["orderId"] = $orderId;
		$data["logContent"] = "商家确认已收货，订单完成";
		$data["logUserId"] = $userId;
		$data["logType"] = 0;
		$data["logTime"] = date('Y-m-d H:i:s');
		$ra = $m->add($data);
		$rsdata["status"] = $ra;;
		return $rsdata;
	}
	/**
	 * 商家确认拒收
	 */
	public function shopOrderRefund ($obj){		
		$userId = $obj["userId"];
		$orderId = $obj["orderId"];
		$shopId = $obj["shopId"];
		$rsdata = array();
		$sql = "SELECT orderId,orderNo,orderStatus FROM __PREFIX__orders WHERE orderId = $orderId AND orderFlag = 1 and shopId=".$shopId;		
		$rsv = $this->queryRow($sql);
		if($rsv["orderStatus"]!= -3){
			$rsdata["status"] = -1;
			return $rsdata;
		}

		$sql = "UPDATE __PREFIX__orders set orderStatus = -4 WHERE orderId = $orderId and shopId=".$shopId;		
		$rs = $this->execute($sql);
		//加回库存
		if($rs>0){
			$sql = "SELECT goodsId,goodsNums,goodsAttrId from __PREFIX__order_goods WHERE orderId = $orderId";
			$oglist = $this->query($sql);
			foreach ($oglist as $key => $ogoods) {
				$goodsId = $ogoods["goodsId"];
				$goodsNums = $ogoods["goodsNums"];
				$goodsAttrId = $ogoods["goodsAttrId"];
				$sql = "UPDATE __PREFIX__goods set goodsStock = goodsStock+$goodsNums WHERE goodsId = $goodsId";
				$this->execute($sql);
				if($goodsAttrId>0){
					$sql = "UPDATE __PREFIX__goods_attributes set attrStock = attrStock+$goodsNums WHERE id = $goodsAttrId";
					$this->execute($sql);
				}
			}
		}	

		$data = array();
		$m = M('log_orders');
		$data["orderId"] = $orderId;
		$data["logContent"] = "商家确认拒收";
		$data["logUserId"] = $userId;
		$data["logType"] = 0;
		$data["logTime"] = date('Y-m-d H:i:s');
		$ra = $m->add($data);
		$rsdata["status"] = $ra;;
		return $rsdata;
	}
	
	/**
	 * 商家确认取消
	 */
	public function shopOrderCancel ($obj){
		$userId = $obj["userId"];
		$orderId = $obj["orderId"];
		$shopId = $obj["shopId"];
		$rsdata = array();
		$sql = "SELECT orderId,orderNo,orderStatus FROM __PREFIX__orders WHERE orderId = $orderId AND orderFlag = 1 and shopId=".$shopId;
		$rsv = $this->queryRow($sql);
		if($rsv["orderStatus"]!= -1){
			$rsdata["status"] = -1;
			return $rsdata;
		}
	
		$sql = "UPDATE __PREFIX__orders set orderStatus = -5 WHERE orderId = $orderId and shopId=".$shopId;
		$rs = $this->query($sql);
	
		$data = array();
		$m = M('log_orders');
		$data["orderId"] = $orderId;
		$data["logContent"] = "商家确认取消订单";
		$data["logUserId"] = $userId;
		$data["logType"] = 0;
		$data["logTime"] = date('Y-m-d H:i:s');
		$ra = $m->add($data);
		$rsdata["status"] = $ra;;
		return $rsdata;
	}
	
	/**
	 * 检查订单是否已支付
	 */
	public function checkOrderPay ($obj){
		$userId = $obj["userId"];
		$orderIds = $obj["orderIds"];
		$sql = "SELECT count(orderId) counts FROM __PREFIX__orders WHERE userId = $userId AND orderId in ($orderIds) AND orderFlag = 1 AND orderStatus = -2 AND isPay = 0 AND payType = 1";
		$rsv = $this->query($sql);
		$ocnt = count(explode(",",$orderIds));
		$data = array();
		
		if($ocnt==$rsv[0]['counts']){
			
			$sql = "SELECT og.goodsId,og.goodsName,g.goodsStock,og.goodsNums, og.goodsAttrId, ga.attrStock FROM  __PREFIX__goods g ,__PREFIX__order_goods og
					left join __PREFIX__goods_attributes ga on ga.goodsId=og.goodsId and og.goodsAttrId=ga.id
					WHERE og.goodsId = g.goodsId and og.orderId in($orderIds)";
			$glist = $this->query($sql);
			if(count($glist)>0){
				$rlist = array();
				foreach ($glist as $goods) {
					if($goods["goodsAttrId"]>0){
						if($goods["attrStock"]<$goods["goodsNums"]){
							$rlist[] = $goods;
						}
					}else{
						if($goods["goodsStock"]<$goods["goodsNums"]){
							$rlist[] = $goods;
						}
					}
				}
				if(count($rlist)>0){
					$data["status"] = -2;
					$data["rlist"] = $rlist;
				}else{
					$data["status"] = 1;
				}
			}else{
				$data["status"] = 1;
			}
			
			
		}else{
			$data["status"] = -1;
		}
		
		
		return $data;
	}
	
	
	
	
}