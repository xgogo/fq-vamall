<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>后台管理中心</title>
<link href="/mineop/1/wstmall/Public/plugins/bootstrap/css/bootstrap.min.css"
	rel="stylesheet">

<!--[if lt IE 9]>
      <script src="/mineop/1/wstmall/Public/js/html5shiv.min.js"></script>
      <script src="/mineop/1/wstmall/Public/js/respond.min.js"></script>
      <![endif]-->
<script src="/mineop/1/wstmall/Public/js/jquery.min.js"></script>
<script src="/mineop/1/wstmall/Public/plugins/bootstrap/js/bootstrap.min.js"></script>

</head>
<body class='wst-page'
	style='overflow: scroll; overflow-x: hidden; overflow-y: hidden'>
	<blockquote>
		<p>角色配置</p>
	</blockquote>
	<div style="padding-left: 20px;">

		<!-- Button trigger modal -->
		<button type="button" class="btn btn-default " data-toggle="modal"
			data-target="#myModal">添加配置</button>


		<table class="table table-hover">
			<thead>
				<tr>
					<td>角色名称</td>
					<td>信用额度</td>
					<td>最大分期数</td>
					<td>操作</td>
				</tr>			
			</thead>
			<tbody>
				<?php if(!empty($roles)){ foreach($roles as $a){ echo "<tr>"; echo "<td>".$a['r_name']."</td>"; echo "<td>".$a['r_ed']."</td>"; echo "<td>".$a['r_qishu']."</td>"; echo "<td><a class='del' href='#' data_id='".$a['id']."'>删除</a></td>"; echo "</tr>"; } } ?>
			</tbody>
		</table>
	</div>
	<!-- Modal -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog"
		aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"
						aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title" id="myModalLabel">添加角色配置</h4>
				</div>
				<div class="modal-body">
					<form class="form-horizontal" id=''>
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-3 control-label">角色名称：*</label>
							<div class="col-sm-7">
								<input type="text" class="form-control r_name"  value=""
									placeholder="" id="r_name" />
							</div>
						</div>
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-3 control-label">最大分期数：*</label>
							<div class="col-sm-7">
								<input type="text" class="form-control"  value=""
									placeholder="" id='r_qishu' />
							</div>
						</div>
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-3 control-label">信用额度：*</label>
							<div class="col-sm-7">
								<input type="text" class="form-control"  value=""
									placeholder="" id='r_ed' />
							</div>
						</div>

					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
					<button type="button" class="btn btn-primary" onclick='role_sub();'>确定</button>
				</div>
			</div>
		</div>
	</div>


</body>
<script type="text/javascript">
	function role_sub() {
		var params = {};
		//var a = getElementById('r_name').value;
		
		params.r_name = $('#r_name').val();
		params.r_qishu = $('#r_qishu').val();
		params.r_ed = $('#r_ed').val();
		if ( params.r_name == '' || params.r_qishu == '' || params.r_ed == '') {
			alert("带*号必填！");
			return false;
		}
		$.post("<?php echo U('Admin/yfq/add_uroles');?>", params, function(data) {
			if(data =='success'){
				//alert("添加成功！");
				location.href ='<?php echo U("Admin/yfq/index_user");?>'; 
			}else{
				alert('抱歉，系统错误！请重新操作。');
			}
				
		});
	}
	
	$('.del').click(function(){
		var　id = $(this).attr('data_id');
		$.post("<?php echo U('Admin/yfq/del_uroles');?>", {id:id}, function(data) {
			if(data =='success'){
				//alert("删除成功！");
				location.href ='<?php echo U("Admin/yfq/index_user");?>'; 
			}else{
				alert('抱歉，系统错误！请重新操作。');
			}			
		});
	})
</script>
</html>