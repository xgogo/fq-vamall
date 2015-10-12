function checkLogin(){
	jQuery.post(Think.U('Home/Shops/checkLoginStatus'),{},function(rsp) {
		var json = WST.toJson(rsp);
		if(json.status && json.status==-999)location.reload();
	});
}
function checkAll(obj){
	$('.chk').each(function(){
		$(this)[0].checked = obj.checked;
	})
}
function getChks(){
	var ids = [];
	$('.chk').each(function(){
		if($(this)[0].checked)ids.push($(this).val());
	});
	return ids.join(',');
}
function editAddress(){
	   var params = {};
	   params.id = $('#id').val();
	   params.areaId1 = $('#areaId1').val();
	   params.areaId2 = $('#areaId2').val();
	   params.areaId3 = $('#areaId3').val();
	   params.communityId = $('#communityId').val();
	   params.address = $('#address').val();
	   params.userName = $('#userName').val();
	   params.userPhone = $('#userPhone').val();
	   params.userTel = $('#userTel').val();
	   params.isDefault = $("input[name='isDefault']:checked").val();
	   
	   
	   if(!WST.checkMinLength(params.userName,2)){
		   WST.msg("收货人姓名长度必须大于1个汉字", {icon: 5});
			return ;	
		}
	   	if(params.areaId1<1){
	   		WST.msg("请选择省", {icon: 5});
			return ;		
		}
		if(params.areaId2<1){
			WST.msg("请选择市", {icon: 5});
			return ;		
		}
		if(params.areaId3<1){
			WST.msg("请选择区县", {icon: 5,shade: [0.3, '#000'],time: 2000});
			return ;		
		}
		if(params.communityId<1){
			WST.msg("请选择社区", {icon: 5});
			return ;		
		}
		if(params.address==""){
			WST.msg("请输入详细地址", {icon: 5});
			return ;		
		}
		if(params.userPhone=="" && params.userTel==""){
			WST.msg("请输入手机号码或固定电话", {icon: 5});
			return ;		
		}
		if(params.userPhone!="" && !WST.isPhone(params.userPhone)){
			WST.msg("手机号码格式错误", {icon: 5});
			return ;		
		}
		if(params.userTel!="" && !WST.isTel(params.userTel)){
			WST.msg("固定电话格式错误", {icon: 5});
			return ;		
		}	
	   
	   $.post(Think.U('Home/UserAddress/edit'),params,function(data,textStatus){
			var json = WST.toJson(data);
			if(json.status>0){
				WST.msg('操作成功!', {icon: 1}, function(){
					location.href = Think.U('Home/UserAddress/queryByPage');
				});
			}else{
				WST.msg(' 操作失败!',{icon: 5});
			}
	   });
}
function getAreaList(objId,parentId,t,id){
	   var params = {};
	   params.parentId = parentId;
	   params.type = t;
	   $('#'+objId).empty();
	   if(t<1){
		   $('#areaId3').empty();
		   $('#areaId3').html('<option value="">请选择</option>');
	   }
	   var html = [];
	   $.post(Think.U('Home/Areas/queryByList'),params,function(data,textStatus){
		    html.push('<option value="">请选择</option>');
			var json = WST.toJson(data);
			if(json.status=='1' && json.list.length>0){
				var opts = null;
				for(var i=0;i<json.list.length;i++){
					opts = json.list[i];
					html.push('<option value="'+opts.areaId+'" '+((id==opts.areaId)?'selected':'')+'>'+opts.areaName+'</option>');
				}
			}
			$('#'+objId).html(html.join(''));
	   });
}
function getCommunitys(v,id){
	   var params = {};
	   params.areaId3 = v;
	   $('#communityId').empty();
	   var html = [];
	   $.post(Think.U('Home/Communitys/getByDistrict'),params,function(data,textStatus){
		    html.push('<option value="">请选择</option>');
			var json = WST.toJson(data);
			if(json.status=='1' && json.list && json.list.length>0){
				var opts = null;
				for(var i=0;i<json.list.length;i++){
					opts = json.list[i];
					html.push('<option value="'+opts.communityId+'" '+((id==opts.communityId)?'selected':'')+'>'+opts.communityName+'</option>');
				}
			}
			$('#communityId').html(html.join(''));
	   });
}

function toEditAddress(id){
	    location.href = Think.U('Home/UserAddress/toEdit','id='+id); 
	}
	function delAddress(id){
		layer.confirm("您确定要删除该地址吗？",{icon: 3, title:'系统提示'},function(tips){
			var ll = layer.load('数据处理中，请稍候...');
			$.post(Think.U('Home/UserAddress/del'),{id:id},function(data,textStatus){
				layer.close(ll);
		    	layer.close(tips);
				var json = WST.toJson(data);
				if(json.status=='1'){
					WST.msg('操作成功!', {icon: 1}, function(){
					   location.reload();
					});
				}else{
					WST.msg('操作失败!', {icon: 5});
				}
			});
		});
	}
function batchMessageDel(){
	  layer.confirm("您确定要删除这些消息？",function(){
	        var ids = getChks();
	        layer.load('正在处理，请稍后...', 3);
	        var params = {};
	        params.ids = ids;
	        $.post(Think.U('Home/Messages/batchDel'),params,function(data,textStatus){
	          var json = WST.toJson(data);
	          if(json.status=='1'){
	        	  WST.msg('操作成功！', {icon: 1},function(){
	              location.reload();
	            });
	          }else{
	        	  WST.msg('操作失败', {icon: 5});
	          }
	       });
	  });
}
function editPass(){
	   var params = {};
	   params.oldPass = $('#oldPass').val();
	   params.newPass = $('#newPass').val();
	   params.reNewPass = $('#reNewPass').val();
	   var ll = layer.load('数据处理中，请稍候...');
	   $.post(Think.U("Home/Users/editPass"),params,function(data,textStatus){
		   layer.close(ll);
			var json = WST.toJson(data);
			if(json.status=='1'){
				WST.msg('密码修改成功!', {icon: 1}, function(){
					location.reload();
				});
			}else{
				WST.msg('密码修改失败!', {icon: 5});
			}
	   });
}
function editUser(){
	   var params = {};
	   params.userName = $.trim($('#userName').val());
	   params.userQQ = $.trim($('#userQQ').val());
	   params.userPhone = $.trim($('#userPhone').val());
	   params.userEmail = $.trim($('#userEmail').val());
	   params.userSex = $('input:radio[name="userSex"]:checked').val();
	   params.userPhoto =  $.trim($('#userPhoto').val());		
	   var ll = layer.load('数据处理中，请稍候...');
	   $.post(Think.U('Home/Users/editUser'),params,function(data,textStatus){
		   layer.close(ll);
			var json = WST.toJson(data);
			if(json.status=='1'){
				WST.msg('修改用户资料成功!', {icon: 1});
				location.reload();
			}else if(json.status=='-2'){
				WST.msg('用户手机已存在!', {icon: 5});
			}else if(json.status=='-3'){
				WST.msg('用户邮箱已存在!', {icon: 5});
			}else{
				WST.msg('修改用户资料失败!', {icon: 5});
			}
	   });
}

function toPay(id){
	
	var params = {};
	params.orderIds = id;
	jQuery.post(Think.U('Home/Orders/checkOrderPay') ,params,function(data) {
		var json = WST.toJson(data);
		if(json.status==1){
			location.href=Think.U('Home/Payments/toPay','orderIds='+params.orderIds);
		}else if(json.status==-2){
			var rlist = json.rlist;
			var garr = new Array();
			for(var i=0;i<rlist.length;i++){
				garr.push(rlist[i].goodsName);
			}
			WST.msg('订单中商品【'+garr.join("，")+'】库存不足，不能进行支付。', {icon: 5});
		}else{
			WST.msg('您的订单已支付!', {icon: 5});
			setTimeout(function(){
				window.location = Think.U('Home/orders/queryDeliveryByPage');
			},1500);
		}
	});
	
}
function showOrder(id){
	layer.open({
	    type: 2,
	    title:"订单详情",
	    shade: [0.6, '#000'],
	    border: [0],
	    offset: ['20px',''],
	    content: [Think.U('Home/Orders/getOrderDetails','orderId='+id)],
	    area: ['1020px', ($(window).height() - 50) +'px']
	});
}
function orderCancel(id){
	layer.confirm('您确定要取消该订单吗？',{icon: 3, title:'系统提示'}, function(tips){
	    var ll = layer.load('数据处理中，请稍候...');
	    $.post(Think.U('Home/Orders/orderCancel'),{orderId:id},function(data){
	    	layer.close(ll);
	    	layer.close(tips);
	    	var json = WST.toJson(data);
			if(json.status>0){
				window.location.reload();
			}else if(json.status==-1){
				WST.msg('操作失，订单状态已发生改变，请刷新后再重试 !', {icon: 5});
			}else{
				WST.msg('操作失，请与商城管理员联系 !', {icon: 5});
			}
	   });
	});
	
}

function appraiseOrder(id){
	layer.open({
	    type: 2,
	    title:"订单详情",
	    shade: [0.6, '#000'],
	    border: [0],
	    content: [Think.U('Home/GoodsAppraises/toAppraise','orderId='+id)],
	    area: ['1020px', ($(window).height() - 50) +'px'],
	    end:function(){
	    	window.location.reload();
	    }
	});
}

function addGoodsAppraises(shopId,goodsId,orderId){
	var goodsScore = $('.'+goodsId+'_goodsScore > input[name="score"]').val();
	if(goodsScore==0){
		WST.msg('请选择商品评分 !', {icon: 5});
		return;
	}
	
	var timeScore = $('.'+goodsId+'_timeScore > input[name="score"]').val();
	if(timeScore==0){
		WST.msg('请选择时效得分 !', {icon: 5});
		return;
	}
	
	var serviceScore = $('.'+goodsId+'_serviceScore > input[name="score"]').val();
	if(serviceScore==0){
		WST.msg('请选择服务得分 !', {icon: 5});
		return;
	}
	
	var content = $.trim($('#'+goodsId+'_content').val());
	if(content.length<3 || content.length>50){
		WST.msg('评价内容为3-50个字 !', {icon: 5});
		return;
	}
	
	//layer.confirm('您确定要提交该评价吗？',{icon: 3, title:'系统提示'}, function(tips){
	    var ll = layer.load('数据处理中，请稍候...');
		$.post(Think.U('Home/GoodsAppraises/addGoodsAppraises'),{shopId:shopId, goodsId:goodsId, orderId:orderId, goodsScore:goodsScore, timeScore:timeScore, serviceScore:serviceScore, content:content },function(data,textStatus){
			//layer.close(tips);
			layer.close(ll);
			var json = WST.toJson(data);
			if(json.status==1){
				$('#'+goodsId+'_appraise').slideUp();
				$('#'+goodsId+'_appraise').empty();
				$('#'+goodsId+'_status').html('评价成功');
			}else{
				WST.msg('评价失败，请刷新后再重试 !', {icon: 5});
			}
		});
	//});
}

function orderConfirm(id,type){
	var msg = (type==1)?'您确定已收货吗？':'您确认拒收货吗?';
	layer.confirm(msg,{icon: 3, title:'系统提示'}, function(tips){
	    var ll = layer.load('数据处理中，请稍候...');
	    $.post(Think.U('Home/Orders/orderConfirm'),{orderId:id,type:type},function(data){
	    	layer.close(tips);
	    	layer.close(ll);
	    	var json = WST.toJson(data);
			if(json.status>0){
				location.reload();
			}else if(json.status==-1){
				WST.msg('操作失败，订单状态已发生改变，请刷新后再重试 !', {icon: 5});
			}else{
				WST.msg('操作失败，请与商城管理员联系 !', {icon: 5});
			}
	   });
	});
}
function getAreaListForOpen(objId,parentId,t,id){
	   var params = {};
	   params.parentId = parentId;
	   params.type = t;
	   $('#'+objId).empty();
	   if(t<1){
		   $('#areaId3').empty();
		   $('#areaId3').html('<option value="">请选择</option>');
	   }
	   var html = [];
	   $.post(Think.U('Home/Areas/queryByList'),params,function(data,textStatus){
		    html.push('<option value="">请选择</option>');
			var json = WST.toJson(data);
			if(json.status=='1' && json.list){
				var opts = null;
				for(var i=0;i<json.list.length;i++){
					opts = json.list[i];
					html.push('<option value="'+opts.areaId+'" '+((id==opts.areaId)?'selected':'')+'>'+opts.areaName+'</option>');
				}
			}
			$('#'+objId).html(html.join(''));
			if(t==0)getCommunitysForOpen();
	   });
}

// 修改开始2015-4-25
function getCommunitysForOpen(){
	  $('#areaTree').empty();
	  var areaId = $('#areaId2').val();
	  $.post(Think.U('Home/Areas/getAreaAndCommunitysByList'),{areaId:areaId},function(data,textStatus){
			var json = data;
			if(json.list){
					var html = [];
					json = json.list;
					for(var i=0;i<json.length;i++){
						var isAreaSelected = ($.inArray(json[i]['areaId'],relateArea)>-1)?" checked ":"";
						communitysCount = 0
						if (json[i].communitys) {
							for (var j =json[i].communitys.length - 1; j >= 0; j--) {
								if ($.inArray(json[i].communitys[j]['communityId'],relateCommunity) > -1 ) {communitysCount++;};
							};
						};
						html.push("<dl class='areaSelect' id='"+json[i]['areaId']+"'>");
						html.push("<dt class='ATRoot' id='node_"+json[i]['areaId']+"' isshow='0'>"+json[i]['areaName']+"：<span> <input type='checkbox' all='1' class='AreaNode' onclick='javascript:selectArea(this)' id='ck_"+json[i]['areaId']+"' "+isAreaSelected+" value='"+json[i]['areaId']+"'><label for='ck_"+json[i]['areaId']+"' "+isAreaSelected+" value='"+json[i]['areaId']+"'>全区配送</label></span> <small>(已选<span class='count'>"+communitysCount+"</span>个社区)</small></dt>");
						if(json[i].communitys && json[i].communitys.length){
							for(var j=0;j<json[i].communitys.length;j++){
								var isCommunitySelected = ($.inArray(json[i].communitys[j]['communityId'],relateCommunity)>-1)?" checked ":"";
								isCommunitySelected += (isAreaSelected!='')?" disabled ":"";
							    html.push("<dd id='node_"+json[i]['areaId']+"_"+json[i].communitys[j]['communityId']+"'><input type='checkbox' id='ck_"+json[i]['areaId']+"_"+json[i].communitys[j]['communityId']+"' all='0' class='AreaNode' "+isCommunitySelected+" onclick='javascript:selectArea(this)' value='"+json[i].communitys[j]['communityId']+"'><label for='ck_"+json[i]['areaId']+"_"+json[i].communitys[j]['communityId']+"'>"+json[i].communitys[j]['communityName']+"</label></dd>");
							}
						}
						html.push("</dl>");
					}
					$('#areaTree').html(html.join(''));
					$('#expendAll').parent().removeClass('Hide');
					$('#expendAll').attr('checked','checked');
				}
		});
	}
function selectArea(v){
		count = 0;
		if($(v).attr('all')=='1'){
			$('input[id^="'+$(v).attr('id')+'_"]').each(function(){
				$(this)[0].checked = $(v)[0].checked;
				$(this)[0].disabled = $(v)[0].checked;
				if ($(v)[0].checked) {count++};
			});
		}else{
			$(v).closest('dl').find('input[type="checkbox"]').each(function(){
				if ($(this).prop('checked') == true) { count++};
			});
		}
		$(v).closest('dl').find('.count:first').html(count);
	}
function openShop(){
	   var params = {};
	   params.userName = $('#userName').val();
	   params.shopName = $('#shopName').val();
	   params.shopCompany = $('#shopCompany').val();
	   params.shopImg = $('#shopImg').val();
	   params.shopTel = $('#shopTel').val();
	   params.areaId1 = $('#areaId1').val();
	   params.areaId2 = $('#areaId2').val();
	   params.areaId3 = $('#areaId3').val();
	   params.goodsCatId1 = $('#goodsCatId1').val();
	   params.shopAddress = $('#shopAddress').val();
	   params.deliveryMoney = $('#deliveryMoney').val();
	   params.deliveryFreeMoney = $('#deliveryFreeMoney').val();
	   params.avgeCostMoney = $('#avgeCostMoney').val();
	   params.bankId = $('#bankId').val();
	   params.bankNo = $('#bankNo').val();
	   params.isInvoice = $("input[name='isInvoice']:checked").val();
	   params.invoiceRemarks = $.trim($('#invoiceRemarks').val());
	   params.serviceStartTime = $('#serviceStartTime').val();
	   params.serviceEndTime = $('#serviceEndTime').val();
	   params.shopAtive = $("input[name='shopAtive']:checked").val();
	   params.verify = $('#authcode').val();
	   if(params.shopImg==''){
		   WST.msg('请上传店铺图片!', {icon: 5});
		   return;
	   }
	   var relateArea = [0];
	   var relateCommunity = [0];
	   $('.AreaNode').each(function(){
			if($(this)[0].checked){
				if($(this).attr('all')==1){
					relateArea.push($(this).val());
				}else{
					relateCommunity.push($(this).val());
				}
			}
	   });
	   params.relateAreaId=relateArea.join(',');
	   params.relateCommunityId=relateCommunity.join(',');
	   if(params.relateAreaId=='0' && params.relateCommunityId=='0'){
		   WST.msg('请选择配送区域!', {icon: 5});
		   return;
	   }
	   if(params.isInvoice==1 && params.invoiceRemarks==''){
		   WST.msg('请输入发票说明!', {icon: 5});
		   return;
	   }
	   if(parseInt(params.serviceStartTime,10)>parseInt(params.serviceEndTime,10)){
		   WST.msg('开始营业时间不能大于结束营业时间!', {icon: 5});
		   return;
	   }
	   if(!document.getElementById('protocol').checked){
		   WST.msg('必须同意使用协议才允许注册!',{icon: 5});
		   return;
	   }
	   if(params.verify==''){
		   WST.msg('请输入验证码!',{icon: 5});
		   return;
	   }
	   layer.load('正在处理，请稍后...', 3);
	   $.post(Think.U('Home/Shops/openShopByUser'),params,function(data,textStatus){
			var json = WST.toJson(data);
			if(json.status=='1'){
				WST.msg('您的开店申请已提交，请等候商城管理员审核!', {icon: 1}, function(){
					location.href=Think.U('Home/Orders/queryByPage');
				});
			}else if(json.status==-4){
				WST.msg('验证码错误!', {icon: 5});
				getVerify();
			}else if(json.status==-5){
				WST.msg('验证码已超过有效期!', {icon: 5});
				getVerify();
			}else{
				WST.msg('操作您的开店申请失败，请联系商城管理员!', {icon: 5});
				getVerify();
			}
			layer.close(ll);
		});
}

function initTime(objId,val){
   for(var i=0;i<24;i++){
	  $('<option value="'+i+'" '+((val==i)?"selected":'')+'>'+i+':00</option>').appendTo($('#'+objId));
	  $('<option value="'+(i+0.5)+'" '+((val==(i+0.5))?"selected":'')+'>'+i+':30</option>').appendTo($('#'+objId));
   }
}
function isInvoce(v){
   if(v){
	  $('#invoiceRemarkstr').show();
   }else{
	  $('#invoiceRemarkstr').hide();
   }
}
function showXiey(id){
		layer.open({
		    type: 2,
		    title: '店铺用户注册协议',
		    shadeClose: true,
		    shade: 0.8,
		    area: ['1000px', ($(window).height() - 50) +'px'],
		    content: [Think.U('Home/Index/toUserProtocol')],
		    btn: ['同意并注册'],
		    yes: function(index, layero){
		    	layer.close(index);
		    }
		});
	}	





function getOrdersList(type){
	var params = {};
	var orderNo = $.trim($('#orderNo').val());
	var userName = $.trim($('#userName').val());
	var shopName = $.trim($('#shopName').val());
	var sdate = $.trim($('#sdate').val());
	var edate = $.trim($('#edate').val());
	var orderStatus = $.trim($('#orderStatus').val());
	if(orderNo!=""){
		params.orderNo = $.trim($('#orderNo').val());
	}
	if(userName!=""){
		params.userName = $.trim($('#userName').val());
	}
	if(shopName!=""){
		params.shopName = $.trim($('#shopName').val());
	}
	if(sdate!=""){
		params.sdate = $.trim($('#sdate').val());
	}
	if(edate!=""){
		params.edate = $.trim($('#edate').val());
	}
	if(orderStatus!=""){
		params.orderStatus = $.trim($('#orderStatus').val());
	}
	
	//type->1:待付款订单;2:待发货订单;3:待确认收货;4:待评价交易;5:已取消订单;6:拒收/退款
	if(type==1){
		location.href=Think.U('Home/Orders/queryPayByPage',params);
	}else if(type==2){
		location.href=Think.U('Home/Orders/queryDeliveryByPage',params);
	}else if(type==3){
		location.href=Think.U('Home/Orders/queryReceiveByPage',params);
	}else if(type==4){
		location.href=Think.U('Home/Orders/queryAppraiseByPage',params);
	}else if(type==5){
		location.href=Think.U('Home/Orders/queryCancelOrders',params);
	}else if(type==6){
		location.href=Think.U('Home/Orders/queryRefundByPage',params);
	}
	
}






