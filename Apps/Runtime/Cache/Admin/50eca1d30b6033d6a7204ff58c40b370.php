<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>后台管理中心</title>
      <link href="/mineop/1/wstmall/Public/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
   
      <!--[if lt IE 9]>
      <script src="/mineop/1/wstmall/Public/js/html5shiv.min.js"></script>
      <script src="/mineop/1/wstmall/Public/js/respond.min.js"></script>
      <![endif]-->
      <script src="/mineop/1/wstmall/Public/js/jquery.min.js"></script>
      <script src="/mineop/1/wstmall/Public/plugins/bootstrap/js/bootstrap.min.js"></script>
      <script src="/mineop/1/wstmall/Public/js/common.js"></script>
      <script src="/mineop/1/wstmall/Public/plugins/plugins/plugins.js"></script>
   </head>
<body class='wst-page' style='overflow:scroll;overflow-x:hidden;overflow-y:hidden'>
<blockquote>
  <p>分期配置  (Ps:请使用半角英文字符！！！)</p>
</blockquote>
<form class="form-horizontal" action="" method="" id="form_fenqi">
  <div class="form-group">
    <label for="inputEmail3" class="col-sm-2 control-label">期数：</label>
    <div class="col-sm-8">
      <input type="text" class="form-control" id="inputEmail3" placeholder="输入期数，按逗号号隔开，如1，2，3" name='qishu' value='<?php echo ($fenqi["qishu"]); ?>'>
    </div>
  </div>
  <div class="form-group">
    <label for="inputPassword3" class="col-sm-2 control-label">利息：</label>
    <div class="col-sm-8">
      <input type="text" class="form-control" id="inputPassword3" placeholder="输入利息，按逗号号隔开，如0.01，0.02，0.03" name='lixi' value='<?php echo ($fenqi["lixi"]); ?>'>
    </div>
  </div>

  <div class="form-group">
    <label for="inputPassword3" class="col-sm-2 control-label">逾期利息：</label>
    <div class="col-sm-8">
      <input type="text" class="form-control" id="inputPassword3" placeholder="输入逾期利息" name='yuqi' value="<?php echo ($fenqi["yuqi"]); ?>">
    </div>
  </div>
  
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="button" class="btn btn-default" id="fq_info">保存</button>
    </div>
  </div>
</form>

</body>
<script type="text/javascript">
$('#fq_info').click(function(){
	var url='<?php echo U("admin/yfq/add_fqinfo");?>';
	$.ajax({
		   type:"POST",
		   url:url,
		   //dataType:json,			
		   data:$('#form_fenqi').serialize(),
		   success:function(data){
		     if(data == "success"){
		    	 //alert("保存成功！");
		    	 location.href = "<?php echo U('admin/yfq/index');?>";
		     }else{
		    	 alert("保存失败，请检查数据后重新提交！");
		     }
		   }
		});
	
})

</script>
</html>