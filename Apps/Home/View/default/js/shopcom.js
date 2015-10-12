
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
$.fn.TabPanel = function(options){
	var defaults = {    
		tab: 0      
	}; 
	var opts = $.extend(defaults, options);
	var t = this;
	$(t).find('.wst-tab-nav li').click(function(){
		$(this).addClass("on").siblings().removeClass();
		var index = $(this).index();
		$(t).find('.wst-tab-content .wst-tab-item').eq(index).show().siblings().hide();
		if(opts.callback)opts.callback(index);
	});
	$(t).find('.wst-tab-nav li').eq(opts.tab).click();
}
/****************************商品操作**************************/
function queryUnSaleByPage(){
	var shopCatId1 = $('#shopCatId1').val();
	var shopCatId2 = $('#shopCatId2').val();
	var goodsName = $('#goodsName').val();
	location.href= Think.U('Home/Goods/queryUnSaleByPage','goodsName='+goodsName+"&shopCatId1="+shopCatId1+"&shopCatId2="+shopCatId2); 
}
function queryOnSale(){
	var shopCatId1 = $('#shopCatId1').val();
	var shopCatId2 = $('#shopCatId2').val();
	var goodsName = $('#goodsName').val();
	location.href= Think.U('Home/Goods/queryOnSaleByPage','goodsName='+goodsName+"&shopCatId1="+shopCatId1+"&shopCatId2="+shopCatId2); 
}
function queryPendding(){
	var shopCatId1 = $('#shopCatId1').val();
	var shopCatId2 = $('#shopCatId2').val();
	var goodsName = $('#goodsName').val();
	location.href= Think.U('Home/Goods/queryPenddingByPage','goodsName='+goodsName+"&shopCatId1="+shopCatId1+"&shopCatId2="+shopCatId2); 
}
function toEditGoods(id,menuId){
	location.href= Think.U('Home/Goods/toEdit','umark='+menuId+"&id="+id); 
}
function toViewGoods(id){
	$.post(Think.U('Home/Goods/getGoodsVerify'),{id:id},function(data,textStatus){
		var json = WST.toJson(data);
		if(json.status=='1'){
			var verifyCode = json.verifyCode;
			window.open(Think.U('Home/Goods/getGoodsDetails','goodsId='+id+"&kcode="+verifyCode));
		}
	});
	
}
function delGoods(id){
	layer.confirm("您确定要删改该商品？",{icon: 3, title:'系统提示'},function(tips){
		$.post(Think.U('Home/Goods/del'),{id:id},function(data,textStatus){
			layer.close(tips);
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
function batchDel(){
	layer.confirm("您确定要删改这些商品？",{icon: 3, title:'系统提示'},function(){
	      var ids = getChks();
	      var loading = layer.load('正在处理，请稍后...', 3);
	      var params = {};
	      params.ids = ids;
	      $.post(Think.U('Home/Goods/batchDel'),params,function(data,textStatus){
	    		var json = WST.toJson(data);
	    		if(json.status=='1'){
	    			WST.msg('操作成功！', {icon: 1},function(){
	    				location.reload();
	    			});
	    		}else{
	    			layer.close(loading);
	    			WST.msg('操作失败', {icon: 5});
	    		}
	     });
	});
}
function sale(v){
	var ids = getChks();
	if(ids==''){
		WST.msg('请先选择商品!', {icon: 5});
		return;
	}
	layer.confirm((v==1)?"您确定要上架这些商品？":"您确定要下架这些商品？",{icon: 3, title:'系统提示'},function(tips){
	    var loading = layer.load('正在处理，请稍后...', 3);
	    layer.close(tips);
	    var params = {};
	    params.ids = ids;
	    params.isSale= v;
	    $.post(Think.U('Home/Goods/sale'),params,function(data,textStatus){
	    	layer.close(loading);
	    	var json = WST.toJson(data);
	    	if(json.status=='1'){
	    		WST.msg('操作成功！', {icon: 1},function(){
	    			location.reload();
	    		});
	    	}else if(json.status=='-2'){
	    		WST.msg('上架失败，请核对商品信息是否完整!', {icon: 5});
	    	}else if(json.status=='2'){
	    		WST.msg('已成功上架商品'+json.num+" 件，请核对未能上架的商品信息是否完整。", {icon: 5},function(){
	    			location.reload();
	    		});
	    	}else if(json.status=='-3'){
	    		WST.msg('上架商品失败!您的店铺权限不能出售商品，如有疑问请与商城管理员联系。', {icon: 5,time:3000});
	    	}else{
	    		WST.msg('操作失败!', {icon: 5});
	    	}
	    });
	});
}
function goodsSet(type,umark){
	var ids = getChks();
	if(ids==''){
		WST.msg('请先选择商品!', {icon: 5});
		return;
	}

	layer.load('正在处理，请稍后...', 3);
	var params = {};
	params.ids = ids;
	params.code= type;
	$.post(Think.U('Home/Goods/goodsSet'),params,function(data,textStatus){
	    var json = WST.toJson(data);
	    if(json.status=='1'){
	    	WST.msg('操作成功！', {icon: 1},function(){
	    		location.reload();
	    	});
	    }else{
	    	WST.msg('操作失败!', {icon: 5});
	    }
	});
}

function getShopCatListForGoods(v,id){
	   var params = {};
	   params.id = v;
	   $('#shopCatId2').empty();
	   var html = [];
	   $.post(Think.U('Home/ShopsCats/queryByList'),params,function(data,textStatus){
		    html.push('<option value="">请选择</option>');
			var json = WST.toJson(data);
			if(json.status=='1' && json.list){
				var opts = null;
				for(var i=0;i<json.list.length;i++){
					opts = json.list[i];
					html.push('<option value="'+opts.catId+'" '+((id==opts.catId)?'selected':'')+'>'+opts.catName+'</option>');
				}
			}
			$('#shopCatId2').html(html.join(''));
	   });
}
$.fn.imagePreview = function(options){
	var defaults = {}; 
	var opts = $.extend(defaults, options);
	var t = this;
	xOffset = 5;
	yOffset = 20;
	if(!$('#preview')[0])$("body").append("<div id='preview'><img width='200' src=''/></div>");
	$(this).hover(function(e){
		   $('#preview img').attr('src',domainURL+ "/" +$(this).attr('img'));      
		   $("#preview").css("top",(e.pageY - xOffset) + "px").css("left",(e.pageX + yOffset) + "px").show();      
	  },
	  function(){
		$("#preview").hide();
	}); 
	$(this).mousemove(function(e){
		   $("#preview").css("top",(e.pageY - xOffset) + "px").css("left",(e.pageX + yOffset) + "px");
	});
}
function getShopCatListForEdit(v,id){
	   var params = {};
	   params.id = v;
	   $('#shopCatId2').empty();
	   var html = [];
	   $.post(Think.U('Home/ShopsCats/queryByList'),params,function(data,textStatus){
		    html.push('<option value="">请选择</option>');
			var json = WST.toJson(data);
			if(json.status=='1' && json.list){
				var opts = null;
				for(var i=0;i<json.list.length;i++){
					opts = json.list[i];
					html.push('<option value="'+opts.catId+'" '+((id==opts.catId)?'selected':'')+'>'+opts.catName+'</option>');
				}
			}
			$('#shopCatId2').html(html.join(''));
	   });
}
function getBrands(catId){
	var v = $('#brandId').attr('dataVal');
	var params = {};
	params.catId = catId;
	$('#brandId').empty();
	var html = [];
	$('#brandId').append('<option value="0">请选择</option>');
	$.post(Think.U('Home/Brands/queryBrandsByCat'),params,function(data,textStatus){
		var json = WST.toJson(data);
		if(json.status=='1' && json.list){
			for(var i=0;i<json.list.length;i++){
				opts = json.list[i];
				$('#brandId').append('<option value="'+opts.brandId+'" '+((v==opts.brandId)?'selected':'')+'>'+opts.brandName+'</option>');
			}
		}
	})
}
function getCatListForEdit(objId,parentId,t,id){
	   var params = {};
	   params.id = parentId;
	   $('#'+objId).empty();
	   if(t<1){
		   $('#goodsCatId3').empty();
		   $('#goodsCatId3').html('<option value="">请选择</option>');
		   getBrands(parentId);
	   }
	   var html = [];
	   $.post(Think.U('Home/GoodsCats/queryByList'),params,function(data,textStatus){
		    html.push('<option value="">请选择</option>');
			var json = WST.toJson(data);
			if(json.status=='1' && json.list){
				var opts = null;
				for(var i=0;i<json.list.length;i++){
					opts = json.list[i];
					html.push('<option value="'+opts.catId+'" '+((id==opts.catId)?'selected':'')+'>'+opts.catName+'</option>');
				}
			}
			$('#'+objId).html(html.join(''));
	   });
}
function editGoods(menuId){
	   
	   var params = {};
	   params.id = $('#id').val();
	   params.goodsSn = $('#goodsSn').val();
	   params.goodsName = $('#goodsName').val();
	   params.goodsImg = $('#goodsImg').val();
	   params.goodsThumbs = $('#goodsThumbs').val();
	   params.marketPrice = $('#marketPrice').val();
	   params.shopPrice = $('#shopPrice').val();
	   params.goodsStock = $('#goodsStock').val();
	   params.brandId = $('#brandId').val();
	   params.goodsUnit = $('#goodsUnit').val();
	   params.goodsSpec = $('#goodsSpec').val();
	   params.goodsCatId1 = $('#goodsCatId1').val();
	   params.goodsCatId2 = $('#goodsCatId2').val();
	   params.goodsCatId3 = $('#goodsCatId3').val();
	   params.shopCatId1 = $('#shopCatId1').val();
	   params.shopCatId2 = $('#shopCatId2').val();
	   params.isSale = $('input[name="isSale"]:checked').val();
	   params.isNew = $('input[name="isNew"]:checked').val();;
	   params.isBest = $('input[name="isBest"]:checked').val();;
	   params.isHot = $('input[name="isHot"]:checked').val();;
	   params.isRecomm = $('input[name="isRecomm"]:checked').val();;
	   params.goodsDesc = $('#goodsDesc').val();
	   params.attrCatId = $('#attrCatId').val();
	   if(params.attrCatId>0){
		   params.priceAttrId = $('.hiddenPriceAttr').attr('dataId');
		   params.goodsPriceNo = $('.hiddenPriceAttr').attr('dataNo');
		   if(params.priceAttrId>0){
			   var isPriceRecomm = false;
			   for(var i=0;i<=params.goodsPriceNo;i++){
				   if(document.getElementById('price_name_'+params.priceAttrId+'_'+i)){
					   params['price_name_'+params.priceAttrId+'_'+i] = $.trim($('#price_name_'+params.priceAttrId+'_'+i).val());
					   params['price_price_'+params.priceAttrId+'_'+i] = $.trim($('#price_price_'+params.priceAttrId+'_'+i).val());
					   params['price_isRecomm_'+params.priceAttrId+'_'+i] = $('#price_isRecomm_'+params.priceAttrId+'_'+i).prop('checked')?1:0;
					   if(params['price_isRecomm_'+params.priceAttrId+'_'+i]==1)isPriceRecomm = true;
					   params['price_stock_'+params.priceAttrId+'_'+i] = $.trim($('#price_stock_'+params.priceAttrId+'_'+i).val());
					   if(params['price_name_'+params.priceAttrId+'_'+i]==''){
						   WST.msg('请输入商品规格！',{icon: 5});
						   $('#price_name_'+params.priceAttrId+'_'+i).focus();
						   return;
					   }
					   if(params['price_stock_'+params.priceAttrId+'_'+i]==''){
						   WST.msg('请输入商品库存！',{icon: 5});
						   $('#price_stock_'+params.priceAttrId+'_'+i).focus();
						   return;
					   }
				   }
			   }
			   if(!isPriceRecomm){
				   WST.msg('请选择一个推荐的价格，以便在商城展示！',{icon: 5,time:3000});
				   return;
			   }
		   }
		   $('.attrList').each(function(){
			   //多选项处理
			   if($(this).attr('dataType')==1){
				   var chk = [];
				   $('input[name="attrTxtChk_'+$(this).attr('dataId')+'"]:checked').each(function(){
					   chk.push($(this).val())
				   })
			       params['attr_name_'+$(this).attr('dataId')] = chk.join(',');
			   }else{
				   //普通下拉，文本
				   params['attr_name_'+$(this).attr('dataId')] = $.trim($(this).val());
			   }
		   });
	   }
	   
	   var gallery = [];
	   $('.gallery-img').each(function(){
		   gallery.push($(this).attr('v')+'@'+$(this).attr('iv'));
	   });
	   if(params.goodsDesc==''){
		   WST.msg('请输入商品描述!', {icon: 5});
		   return;
	   }
	   if(params.goodsImg==''){
		   WST.msg('请上传商品图片!', {icon: 5});
		   return;
	   }
	   params.gallery = gallery.join(',');
	   var loading = layer.load('正在提交商品信息，请稍后...', 3);
	   $.post(Think.U('Home/Goods/edit'),params,function(data,textStatus){
		   layer.close(loading);
			var json = WST.toJson(data);
			if(json.status=='1'){
				WST.msg('操作成功!', {icon: 1}, function(){
					if((menuId=='toEditGoods')){
						location.href= Think.U('Home/Goods/toEdit','umark=toEditGoods');
					}else{
						location.href=Think.U('Home/Goods/'+menuId);
					}
				});
			}else if(json.status=='-2'){
				if(params.isSale==1){
				    WST.msg('您的店铺已被封，如有疑问请与商城管理员联系!', {icon: 5,time:4000},function(){
				    	if((menuId=='toEditGoods')){
							location.href= Think.U('Home/Goods/toEdit','umark=toEditGoods');
						}else{
							location.href=Think.U('Home/Goods/'+menuId);
						}
				    });
				}else{
					WST.msg('操作成功!', {icon: 1}, function(){
						if((menuId=='toEditGoods')){
							location.href= Think.U('Home/Goods/toEdit','umark=toEditGoods');
						}else{
							location.href=Think.U('Home/Goods/'+menuId);
						}
					});
				}
			}else if(json.status=='-3'){
				if(params.isSale==1){
					WST.msg('您的店铺权限不能上架商品，所编辑商品已被存放在仓库中，如有疑问请与商城管理员联系!', {icon: 5,time:4000},function(){
						if((menuId=='toEditGoods')){
							location.href= Think.U('Home/Goods/toEdit','umark=toEditGoods');
						}else{
							location.href=Think.U('Home/Goods/'+menuId);
						}
					});
				}else{
					WST.msg('操作成功!', {icon: 1}, function(){
						if((menuId=='toEditGoods')){
							location.href= Think.U('Home/Goods/toEdit','umark=toEditGoods');
						}else{
							location.href=Think.U('Home/Goods/'+menuId);
						}
					});
				}
			}else{
				WST.msg('操作失败!', {icon: 5});
			}
	   });
}
function getAttrList(catId){
	$('#priceContainer').hide();
	$('#attrContainer').hide();
	$('#priceConent').empty();
	$('#attrConent').empty();
	if(catId==0){
		$('.hiddenPriceAttr').attr('dataId',0);
		$('.hiddenPriceAttr').attr('dataNo',0);
		$('.hiddenPriceAttr').val('');
		$('#goodsStock').attr('disabled',false);
	}
	$.post(Think.U('Home/Attributes/getAttributes'),{catId:catId},function(data,textStatus){
		 var json = WST.toJson(data);
		 var priceAttr = null;
		 if(json.status=='1' && json.list){
			var opts = null;
			for(var i=0;i<json.list.length;i++){
				opts = json.list[i];
				if(opts.isPriceAttr==1){
					priceAttr = opts;
				}else{
					addAttr(opts);
					$('#attrContainer').show();
				}
			}
		 }
		 if(priceAttr){
			 $('.hiddenPriceAttr').attr('dataId',priceAttr.attrId);
			 $('.hiddenPriceAttr').attr('dataNo',0);
			 $('.hiddenPriceAttr').val(priceAttr.attrName);
			 addPriceAttr();
			 $('#priceContainer').show();
			 $('#goodsStock').attr('disabled',true);
		 }
	});
}
function addPriceAttr(){
	var goodsPriceNo = $('.hiddenPriceAttr').attr('dataNo');
	goodsPriceNo++;
	var obj = {attrId:$('.hiddenPriceAttr').attr('dataId'),attrName:$('.hiddenPriceAttr').val()};
	var html = [];
	html.push('<tr id="attr_'+goodsPriceNo+'"><td style="text-align:right">'+obj.attrName+'：</td>');
	html.push('<td><input type="text" id="price_name_'+obj.attrId+'_'+goodsPriceNo+'" /></td>');
	html.push('<td><input type="text" id="price_price_'+obj.attrId+'_'+goodsPriceNo+'" value="0" onkeypress="return WST.isNumberdoteKey(event)" onkeyup="javascript:WST.isChinese(this,1)" maxLength="10"/></td>');
	html.push('<td><input type="radio" id="price_isRecomm_'+obj.attrId+'_'+goodsPriceNo+'" name="price_isRecomm"/></td>');
	html.push('<td><input type="text" id="price_stock_'+obj.attrId+'_'+goodsPriceNo+'" value="100" onkeypress="return WST.isNumberKey(event)" onblur="javascript:statGoodsStaock()" onkeyup="javascript:WST.isChinese(this,1)" maxLength="25"/></td>');
	if(goodsPriceNo==1){
		html.push('<td><a title="新增" class="add btn" href="javascript:addPriceAttr()"></a></td>');
	}else{
	    html.push('<td><a title="删除" class="del btn" href="javascript:delPriceAttr('+goodsPriceNo+')"></a></td></tr>');
	}
	$('.hiddenPriceAttr').attr('dataNo',goodsPriceNo);
	$('#priceConent').append(html.join(''));
	statGoodsStaock();
}
function delPriceAttr(v){
	$('#attr_'+v).remove();
	statGoodsStaock();
}
function statGoodsStaock(){
	var goodsPriceNo = $('.hiddenPriceAttr').attr('dataNo');
	var attrId = $('.hiddenPriceAttr').attr('dataId');
	var totalStock = 0;
	for(var i=0;i<=goodsPriceNo;i++){
		if(document.getElementById('price_stock_'+attrId+"_"+i)){
			totalStock = totalStock +parseInt($.trim($('#price_stock_'+attrId+'_'+i).val()),10);
		}
	}
	$('#goodsStock').val(totalStock);
}
function addAttr(obj){
	var html = [];
	html.push("<tr id='attr_"+obj.attrId+"'>");
	html.push("<th style='width:80px;text-align:right' nowrap>"+obj.attrName+"：</th><td>");
	if(obj.attrType==0){
		html.push("<input type='text' style='width:70%;' dataId='"+obj.attrId+"' class='attrList'/>");
	}else if(obj.attrType==1){
		if(obj.opts && obj.opts.txt){
			html.push("<input type='hidden' dataType='"+obj.attrType+"' dataId='"+obj.attrId+"' class='attrList'>");
	        for(var i=0;i<obj.opts.txt.length;i++){
	        	html.push("<label><input type='checkbox' name='attrTxtChk_"+obj.attrId+"' value='"+obj.opts.txt[i]+"'/>"+obj.opts.txt[i]+"</label>&nbsp;&nbsp;");
	        }
		}
        html.push("</select>");
	}else if(obj.attrType==2){
		html.push("<select class='attrList' id='attr_name_"+obj.attrId+"' dataId='"+obj.attrId+"'>");
        if(obj.opts && obj.opts.txt){
			for(var i=0;i<obj.opts.txt.length;i++){
	        	html.push("<option value='"+obj.opts.txt[i]+"'>"+obj.opts.txt[i]+"</option>");
	        }
        }
        html.push("</select>");
	}
	html.push("</td></tr>");
	$('#attrConent').append(html.join(''));
}

/*****************************商品分类***********************************/
function editGoodsCat(){
	   var params = {};
	   params.id = $('#id').val();
	   params.parentId = $('#parentId').val();
	   params.catName = $('#catName').val();
	   params.isShow = $('input[name="isShow"]:checked').val();;
	   params.catSort = $('#catSort').val();
	   var loading = layer.load('正在提交商品分类信息，请稍后...', 3);
	   $.post(Think.U('Home/ShopsCats/edit'),params,function(data,textStatus){
		   layer.close(loading);
			var json = WST.toJson(data);
			if(json.status=='1'){
				WST.msg('操作成功!', {icon: 1}, function(){
				   location.href= Think.U('Home/ShopsCats/index');
				});
			}else{
				layer.msg('操作失败!', {icon: 5});
			}
	   });
}
function delGoodsCat(id){
	layer.confirm("您确定要删除该商品分类吗？",{icon: 3, title:'系统提示'},function(tips){
		layer.load('正在处理，请稍后...', 3);
		layer.close(tips);
		$.post(Think.U('Home/ShopsCats/del'),{id:id},function(data,textStatus){
			var json = WST.toJson(data);
			if(json.status=='1'){
				WST.msg('操作成功!', {icon: 1}, function(){
					location.reload();
				});
			}else{
				WST.msg('操作失败!', {icon: 5});
			}
		});
	})
}
function editGoodsCatName(obj){
	var name = $('#');
	$.post(Think.U('Home/ShopsCats/editName'),{id:$(obj).attr('dataId'),catName:obj.value},function(data,textStatus){
		var json = WST.toJson(data);
		if(json.status=='1'){
			WST.msg('操作成功!',{icon: 1});
		}else{
			WST.msg('操作失败!', {icon: 5});
		}
	});
}
function loadGoodsCatChildTree(obj,pid,objId){
	    var showhtml = "<span class='wst-state_yes'></span>";
	    var hidehtml = "<span class='wst-state_no'></span>";
		var str = objId.split("_");
		level = (str.length-2);
		if($(obj).hasClass('wst-tree-open')){
			$(obj).removeClass('wst-tree-open').addClass('wst-tree-close');
			$('tr[class^="'+objId+'"]').hide();
		}else{
			$(obj).removeClass('wst-tree-close').addClass('wst-tree-open');
			$('tr[class^="'+objId+'"]').show();
		}
}
/*****************商品评价**************************/
function queryAppraises(){
	var shopCatId1 = $('#shopCatId1').val();
	var shopCatId2 = $('#shopCatId2').val();
	var goodsName = $('#goodsName').val();
	location.href= Think.U('Home/GoodsAppraises/index','umark=GoodsAppraises&goodsName='+goodsName+"&shopCatId1="+shopCatId1+"&shopCatId2="+shopCatId2);
}
function getShopCatListForAppraises(v,id){
	   var params = {};
	   params.id = v;
	   $('#shopCatId2').empty();
	   var html = [];
	   $.post(Think.U('Home/ShopsCats/queryByList'),params,function(data,textStatus){
		    html.push('<option value="">请选择</option>');
			var json = WST.toJson(data);
			if(json.status=='1' && json.list){
				var opts = null;
				for(var i=0;i<json.list.length;i++){
					opts = json.list[i];
					html.push('<option value="'+opts.catId+'" '+((id==opts.catId)?'selected':'')+'>'+opts.catName+'</option>');
				}
			}
			$('#shopCatId2').html(html.join(''));
	   });
}
/******************订单列表**********************/
//查看订单
function showOrder(id){
	layer.open({
	    type: 2,
	    title:"订单详情",
	    shade: [0.6, '#000'],
	    border: [0],
	    content: [Think.U('Home/Orders/getOrderDetails','orderId='+id)],
	    area: ['1020px', ($(window).height() - 50) +'px']
	});
}
//受理
function shopOrderAccept(id){
	layer.confirm('您确定受理该订单吗？', {icon: 3, title:'系统提示'}, function(tips){
	    var ll = layer.load('数据处理中，请稍候...');
	    $.post(Think.U('Home/Orders/shopOrderAccept'),{orderId:id},function(data){
	    	layer.close(ll);
	    	layer.close(tips);
	    	var json = WST.toJson(data);
			if(json.status>0){
				$(".wst-tab-nav").find("li").eq(statusMark).click();
			}else if(json.status==-1){
				WST.msg('操作失，订单状态已发生改变，请刷新后再重试 !', {icon: 5});
			}else{
				WST.msg('操作失，请与商城管理员联系 !', {icon: 5});
			}
	   });
	});
	
}
//包装
function shopOrderProduce(id){
	layer.confirm('确定打包中吗？',{icon: 3, title:'系统提示'}, function(tips){
	    var ll = layer.load('数据处理中，请稍候...');
	    $.post(Think.U('Home/Orders/shopOrderProduce'),{orderId:id},function(data){
	    	layer.close(ll);
	    	layer.close(tips);
	    	var json = WST.toJson(data);
			if(json.status>0){
				$(".wst-tab-nav").find("li").eq(statusMark).click();
			}else if(json.status==-1){
				WST.msg('操作失，订单状态已发生改变，请刷新后再重试 !', {icon: 5});
			}else{
				WST.msg('操作失，请与商城管理员联系 !', {icon: 5});
			}
	   });
	});
	
}
//发货配送
function shopOrderDelivery(id){
	layer.confirm('确定正在发货吗？',{icon: 3, title:'系统提示'}, function(tips){
	    var ll = layer.load('数据处理中，请稍候...');
	    $.post(Think.U('Home/Orders/shopOrderDelivery'),{orderId:id},function(data){
	    	layer.close(ll);
	    	layer.close(tips);
	    	var json = WST.toJson(data);
			if(json.status>0){
				$(".wst-tab-nav").find("li").eq(statusMark).click();
			}else if(json.status==-1){
				WST.msg('操作失，订单状态已发生改变，请刷新后再重试 !', {icon: 5});
			}else{
				WST.msg('操作失，请与商城管理员联系 !', {icon: 5});
			}
	   });
	});
	
}
//确认收货
function shopOrderReceipt(id){
	layer.confirm('确定已收货吗？',{icon: 3, title:'系统提示'}, function(tips){
	    var ll = layer.load('数据处理中，请稍候...');
	    $.post(Think.U('Home/Orders/shopOrderReceipt'),{orderId:id},function(data){
	    	layer.close(ll);
	    	layer.close(tips);
	    	var json = WST.toJson(data);
			if(json.status>0){
				$(".wst-tab-nav").find("li").eq(statusMark).click();
			}else if(json.status==-1){
				WST.msg('操作失，订单状态已发生改变，请刷新后再重试 !', {icon: 5});
			}else{
				WST.msg('操作失，请与商城管理员联系 !', {icon: 5});
			}
	   });
	});
	
}
//同意拒收
function shopOrderRefund(id){
	layer.confirm('确定拒收吗？',{icon: 3, title:'系统提示'}, function(tips){
	    var ll = layer.load('数据处理中，请稍候...');
	    $.post(Think.U('Home/Orders/shopOrderRefund'),{orderId:id},function(data){
	    	layer.close(ll);
	    	layer.close(tips);
	    	var json = WST.toJson(data);
			if(json.status>0){
				$(".wst-tab-nav").find("li").eq(statusMark).click();
			}else if(json.status==-1){
				WST.msg('操作失，订单状态已发生改变，请刷新后再重试 !', {icon: 5});
			}else{
				WST.msg('操作失，请与商城管理员联系 !', {icon: 5});
			}
	   });
	});
}

//同意取消
function shopOrderCancel(id){
	layer.confirm('确定取消吗？',{icon: 3, title:'系统提示'}, function(tips){
	    var ll = layer.load('数据处理中，请稍候...');
	    $.post(Think.U('Home/Orders/shopOrderCancel'),{orderId:id},function(data){
	    	layer.close(ll);
	    	layer.close(tips);
	    	var json = WST.toJson(data);
			if(json.status>0){
				$(".wst-tab-nav").find("li").eq(statusMark).click();
			}else if(json.status==-1){
				WST.msg('操作失，订单状态已发生改变，请刷新后再重试 !', {icon: 5});
			}else{
				WST.msg('操作失，请与商城管理员联系 !', {icon: 5});
			}
	   });
	});
}

function orderPager(statusMark,pcurr){
	var orderNo = $.trim($("#orderNo_"+statusMark).val());
	var userName = $.trim($("#userName_"+statusMark).val());
	var userAddress = $.trim($("#userAddress_"+statusMark).val());
	$.post(Think.U('Home/Orders/queryShopOrders'),{orderNo:orderNo,userName:userName,userAddress:userAddress,statusMark:statusMark,pcurr:pcurr},function(data,textStatus){
		var json = WST.toJson(data);
		var html = new Array();
		if(json.root.length>0){
			for(var i=0;i<json.root.length;i++){
				var order = json.root[i];
				html.push("<tr>");
					html.push("<td width='100'><a href='javascript:;' style='color:blue;font-weight:bold;' onclick=showOrder('"+order.orderId+"')>"+order.orderNo+"</a></td>");
					html.push("<td width='100'>"+order.userName+"</td>");
					html.push("<td width='*'>"+order.userAddress+"</td>");
					html.push("<td width='100'>"+order.totalMoney+"</td>");
					html.push("<td width='100'><div style='line-height:20px;'>"+order.createTime+"</div></td>");

					html.push("<td width='100'>");
						html.push("<a href='javascript:;' onclick=showOrder('"+order.orderId+"')>查看</a> | ");
					if(statusMark==0){
						html.push(" | <a href='javascript:;' onclick=shopOrderAccept('"+order.orderId+"')>受理</a>");
					}else if(statusMark==1){
						html.push(" | <a href='javascript:;' onclick=shopOrderProduce('"+order.orderId+"')>打包</a>");
					}else if(statusMark==2){
						html.push(" | <a href='javascript:;' onclick=shopOrderDelivery('"+order.orderId+"')>发货配送</a>");
					}else if(statusMark==3){
							
					}else if(statusMark==4){
						html.push(" | <a href='javascript:;' onclick=shopOrderReceipt('"+order.orderId+"')>确认收货</a>");
					}else if(statusMark==6){
						if(order.orderStatus==-3){
						     html.push(" | <a href='javascript:;' onclick=shopOrderRefund('"+order.orderId+"')>同意拒收</a>");
						}
					}
					
					html.push("</td>");
				html.push("</tr>");
			}
			$("#otbody"+statusMark).html(html.join(""));
			$('.pager_'+statusMark).show();
		}else{
			$('#pager_'+statusMark).hide();
			$(".otbody"+statusMark).empty();
			
		}
	});	
	
}

function queryOrderPager(statusMark,pcurr){
	var orderNo = $.trim($("#orderNo_"+statusMark).val());
	var userName = $.trim($("#userName_"+statusMark).val());
	var userAddress = $.trim($("#userAddress_"+statusMark).val());
	var ll = layer.load('数据加载中，请稍候...');
		$.post(Think.U('Home/Orders/queryShopOrders'),{orderNo:orderNo,userName:userName,userAddress:userAddress,statusMark:statusMark,pcurr:pcurr},function(data,textStatus){
			var json = WST.toJson(data);
			var html = new Array();
			if(json.root.length>0){
				for(var i=0;i<json.root.length;i++){
					var order = json.root[i];
					html.push("<tr>");
						html.push("<td width='100'><a href='javascript:;' style='color:blue;font-weight:bold;' onclick=showOrder('"+order.orderId+"')>"+order.orderNo+"</a></td>");
						html.push("<td width='100'>"+order.userName+"</td>");
						html.push("<td width='*'>"+order.userAddress+"</td>");
						html.push("<td width='100'>"+order.totalMoney+"</td>");
						html.push("<td width='100'><div style='line-height:20px;'>"+order.createTime+"</div></td>");
				
						html.push("<td width='100'>");
							html.push("<a href='javascript:;' onclick=showOrder('"+order.orderId+"')>查看</a>");
						if(statusMark==0){
							html.push(" | <a href='javascript:;' onclick=shopOrderAccept('"+order.orderId+"')>受理</a>");
						}else if(statusMark==1){
							html.push(" | <a href='javascript:;' onclick=shopOrderProduce('"+order.orderId+"')>打包</a>");
						}else if(statusMark==2){
							html.push(" | <a href='javascript:;' onclick=shopOrderDelivery('"+order.orderId+"')>发货配送</a>");
						}else if(statusMark==3){
							
						}else if(statusMark==4){
							html.push(" | <a href='javascript:;' onclick=shopOrderReceipt('"+order.orderId+"')>确认收货</a>");
						}else if(statusMark==6){
							if(order.orderStatus==-3){
							     html.push(" | <a href='javascript:;' onclick=shopOrderRefund('"+order.orderId+"')>同意拒收</a>");
							}
							if(order.orderStatus==-1){
							     html.push(" | <a href='javascript:;' onclick=shopOrderCancel('"+order.orderId+"')>同意取消</a>");
							}
						}
						html.push("</td>");
					html.push("</tr>");
				}
				$("#otbody"+statusMark).html(html.join(""));
				$('.pager_'+statusMark).show();
			}else{
				$('.pager_'+statusMark).hide();
				$("#otbody"+statusMark).empty();
				
			}
			var tt = null;
			tt = $("#opage_"+statusMark+" .wst-page-items").createPage({
				pageCount:json.totalPage,
				current:json.currPage,
				backFn:function(pcurr){
					orderPager(statusMark,pcurr);
				}
			});
			layer.close(ll);
		});
}
/*******修改密码 ********************/
function editPass(){
	   var params = {};
	   params.oldPass = $('#oldPass').val();
	   params.newPass = $('#newPass').val();
	   params.reNewPass = $('#reNewPass').val();
	   $.post(Think.U('Home/Users/editPass'),params,function(data,textStatus){
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
/***************编辑店铺资料******************/
function getCommunitysForShopEdit(){
	  
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
	  var count = 0;
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
function initTime(objId,val){
	for(var i=0;i<24;i++){
		$('<option value="'+i+'" '+((val==i)?"selected":'')+'>'+i+':00</option>').appendTo($('#'+objId));
		$('<option value="'+(i+".5")+'" '+((val==(i+".5"))?"selected":'')+'>'+i+':30</option>').appendTo($('#'+objId));
	}
}
function editShop(){
	   var params = {};
	   params.userName = $('#userName').val();
	   params.shopSn = $('#shopSn').val();
	   params.shopName = $('#shopName').val();
	   params.shopCompany = $('#shopCompany').val();
	   params.shopKeywords = $('#shopKeywords').val();
	   params.shopImg = $('#shopImg').val();
	   params.shopTel = $('#shopTel').val();
	   params.shopAddress = $('#shopAddress').val();
	   params.deliveryCostTime = $('#deliveryCostTime').val();
	   params.deliveryStartMoney = $('#deliveryStartMoney').val();
	   params.deliveryMoney = $('#deliveryMoney').val();
	   params.deliveryFreeMoney = $('#deliveryFreeMoney').val();
	   params.avgeCostMoney = $('#avgeCostMoney').val();
	   params.isInvoice = $("input[name='isInvoice']:checked").val();
	   params.invoiceRemarks = $('#invoiceRemarks').val();
	   params.serviceStartTime = $('#serviceStartTime').val();
	   params.serviceEndTime = $('#serviceEndTime').val();
	   
	   params.shopAtive = $("input[name='shopAtive']:checked").val();
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
	   var shopAds = new Array();
	   var shopAdsUrl = new Array();
	   $('.gallery-img').each(function(){
		   shopAds.push($(this).attr("v"));
	   });
	   $('.gallery-img-url').each(function(){
		   shopAdsUrl.push($(this).val());
	   });
	   params.shopAds=shopAds.join('#@#');
	   params.shopAdsUrl=shopAdsUrl.join('#@#');
	   params.relateAreaId=relateArea.join(',');
	   params.relateCommunityId=relateCommunity.join(',');
	   layer.load('正在处理，请稍后...', 3);
	   $.post(Think.U('Home/Shops/edit'),params,function(data,textStatus){
			var json = WST.toJson(data);
			if(json.status=='1'){
				WST.msg('操作成功!', {icon: 1}, function(){
					location.reload();
				});
			}else{
				WST.msg('操作失败!', {icon: 5});
			}
		});
}
/******************店铺设置************************/
function setShop(){
	   var params = {};
	   params.shopTitle = $('#shopTitle').val();
	   params.shopKeywords = $('#shopKeywords').val();
	   params.shopBanner = $('#shopBanner').val();
	   var shopAds = new Array();
	   var shopAdsUrl = new Array();
	   $('.gallery-img').each(function(){
		   shopAds.push($(this).attr("v"));
	   });
	   $('.gallery-img-url').each(function(){
		   shopAdsUrl.push($(this).val());
	   });
	   params.shopAds=shopAds.join('#@#');
	   params.shopAdsUrl=shopAdsUrl.join('#@#');
	   params.shopDesc = $('#shopDesc').val();
	   layer.load('正在处理，请稍后...', 3);
	   
	   $.post(Think.U('Home/Shops/editShopCfg'),params,function(data,textStatus){
			var json = WST.toJson(data);
			if(json.status=='1'){
				WST.msg('操作成功!', {icon: 1}, function(){
					location.reload();
				});
			}else{
				WST.msg('操作失败!', {icon: 5});
			}
		});
}
function logout(){
	jQuery.post(Think.U('Home/Shops/logout'),{},function(rsp) {
		location.reload();
	});
}
function checkLogin(){
	jQuery.post(Think.U('Home/Shops/checkLoginStatus'),{},function(rsp) {
		var json = WST.toJson(rsp);
		if(json.status && json.status==-999)location.reload();
	});
}
/***************商品类型****************/
function editAttrCats(type,src){
	var catName = $.trim($('#catName').val());
	if(catName==''){
		WST.msg('请输入商品类型名称!', {icon: 5});
		return;
	}
	var loading = layer.load('正在处理，请稍后...', 3);
	$.post(Think.U('Home/AttributeCats/edit'),{umark:src,catName:catName,id:$('#id').val()},function(data,textStatus){
		layer.close(loading);
		var json = WST.toJson(data);
		if(json.status=='1'){
			WST.msg('操作成功!', {icon: 1}, function(){
				if(type==1){
					$('#myform')[0].reset();
				}else{
				    location.href=Think.U('Home/AttributeCats/index');
				}
			});
		}else{
			WST.msg('操作失败!', {icon: 5});
		}
	});
}
function delAttrCat(id){
	layer.confirm("您确定要删除该商品类型及其下的属性吗？",{icon: 3, title:'系统提示'},function(tips){
	    var loading = layer.load('正在处理，请稍后...', 3);
	    layer.close(tips);
	    var params = {};
	    $.post(Think.U('Home/AttributeCats/del'),{id:id},function(data,textStatus){
	    	layer.close(loading);
	    	var json = WST.toJson(data);
	    	if(json.status=='1'){
	    		WST.msg('操作成功！', {icon: 1},function(){
	    			location.reload();
	    		});
	    	}else{
	    		WST.msg('操作失败!', {icon: 5});
	    	}
	    });
	});
}
/***********商品属性************/
function getAttrsForAttr(){
	location.href=Think.U("Home/Attributes/index",'catId='+$('#catId').val());
}
function toAddAttr(){
	var attrNoForAttr = $('#catId').attr('dataNo');
	attrNoForAttr++
	var html = [];
	html.push("<tr id='tr_"+attrNoForAttr+"' dataId='0'><td>&nbsp;</td>");
	html.push("<td><input type='text' id='attrName_"+attrNoForAttr+"'/></td>");
	html.push("<td><input type='radio' name='isPriceAttr' id='isPriceAttr_"+attrNoForAttr+"' onclick='javascript:chkPriceAttrForAttr()' id='isPriceAttr_"+attrNoForAttr+"'></td>");
	html.push("<td><select id='attrType_"+attrNoForAttr+"' onchange='javascript:changeAttrTypeForAttr("+attrNoForAttr+")'><option value='0'>输入框</option/><option value='1'>多选项</option/><option value='2'>下拉项</option/></select>");
    html.push("</td>");
    html.push("<td><input type='text' id='attrContent_"+attrNoForAttr+"' style='width:300px;display:none'/></td>");
    html.push("<td><input type='text' id='attrSort_"+attrNoForAttr+"'/></td>");
    html.push("<td>");
    html.push("<a href='javascript:delAttrs("+attrNoForAttr+",0)' class='btn del' title='删除'></a>");
    html.push("</td>");
    html.push("</tr>");
    $('#tbody').append(html.join(''));
    $('#catId').attr('dataNo',attrNoForAttr);
    $('.wst-btn-query').show();
}
function changeAttrTypeForAttr(v){
	if($('#attrType_'+v).val()==0){
		$('#attrContent_'+v).hide();
	}else{
		$('#attrContent_'+v).show();
	}
}
function chkPriceAttrForAttr(){
	var attrNoForAttr = $('#catId').attr('dataNo');
	for(var i=0;i<attrNoForAttr;i++){
		if(!document.getElementById('tr_'+i))continue;
		if($('#isPriceAttr_'+i)[0].checked){
			$('#attrType_'+i).hide();
			$('#attrContent_'+i).hide();
		}else{
			$('#attrType_'+i).show();
			if($('#attrType_'+i).val()==1 || $('#attrType_'+i).val()==2){
				$('#attrContent_'+i).show();
			}
		}
	}
}
function editAttrs(){
	var attrNoForAttr = $('#catId').attr('dataNo');
	var params = {}
	params.catId = $('#catId').val();
	params.no = attrNoForAttr;
	for(var i=0;i<=attrNoForAttr;i++){
		if(!document.getElementById('tr_'+i))continue;
		params['id_'+i] = $('#tr_'+i).attr('dataId');
		params['isPriceAttr_'+i] = $('#isPriceAttr_'+i)[0].checked?1:0;
		params['attrName_'+i] = $.trim($('#attrName_'+i).val());
		if(params['attrName_'+i]==''){
			WST.msg('请输入属性名称!', {icon: 5});
			$('#attrName_'+i).focus();
			return;
		}
		params['attrType_'+i] = $('#attrType_'+i).val();
		params['attrContent_'+i] = $.trim($('#attrContent_'+i).val());
		if((params['attrType_'+i]==1 || params['attrType_'+i]==2) && params['attrContent_'+i]==''){
			WST.msg('请输入属性选项值!', {icon: 5});
			$('#attrContent_'+i).focus();
			return;
		}
		params['attrSort_'+i] = $.trim($('#attrSort_'+i).val());
	}
	var loading = layer.load('正在处理，请稍后...', 3);
	$.post(Think.U('Home/attributes/edit'),params,function(data,textStatus){
		layer.close(loading);
		var json = WST.toJson(data);
		if(json.status=='1'){
			WST.msg('操作成功!', {icon: 1}, function(){
				location.href=Think.U('Home/Attributes/index','catId='+$('#catId').val());
			});
		}else{
			WST.msg('操作失败!', {icon: 5});
		}
	});
}
function delAttrs(no,id){
	if(id>0){
		layer.confirm("您确定要删除该商品属性吗？",{icon: 3, title:'系统提示'},function(tips){
		    var loading = layer.load('正在处理，请稍后...', 3);
		    layer.close(tips);
		    var params = {};
		    $.post(Think.U('Home/Attributes/del'),{id:id},function(data,textStatus){
		    	layer.close(loading);
		    	var json = WST.toJson(data);
		    	if(json.status=='1'){
		    		WST.msg('操作成功！', {icon: 1},function(){
		    			location.reload();
		    		});
		    	}else{
		    		WST.msg('操作失败!', {icon: 5});
		    	}
		    });
		});
	}else{
		$('#tr_'+no).remove();
	}
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