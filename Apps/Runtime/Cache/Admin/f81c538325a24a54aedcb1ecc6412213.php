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
      <style type="text/css">
      	img{
      		width: 400px;
      		height: 300px;
      	}
      	.t{
      		width: 200px;
      		
      	}
      	.text{
      		font-weight: bold;
      	}
      </style>
   </head>
<body class='wst-page' style='overflow:scroll;overflow-x:hidden;overflow-y:' >
<blockquote>
  <p><font color='bule'><?php echo ($info["loginName"]); ?></font>的认证信息</p>
</blockquote>
<div class="" style='margin: 10px;'>
<table class="table table-bordered" style='width: 70%'>
	<tbody>
		<tr>
			<td class="t">真实姓名：</td>
			<td class="text"><?php echo ($info["u_name"]); ?></td>
			<td class="t">身份证号码：</td>
			<td class="text"><?php echo ($info["sfzhm"]); ?></td>
		</tr>
		<tr>
			<td class="t">学校名称：</td>
			<td class="text"><?php echo ($info["sch_name"]); ?></td>
			<td class="t">学校地址：</td>
			<td class="text"><?php echo ($info["sch_address"]); ?></td>
		</tr>
		<tr>
			<td class="t"> 专业：</td>
			<td class="text"><?php echo ($info["profession"]); ?></td>
			<td class="t">班级：</td>
			<td class="text"><?php echo ($info["class"]); ?></td>
		</tr>
		<tr>
			<td class="t">入学时间：</td>
			<td class="text"><?php echo ($info["start_time"]); ?></td>
			<td class="t">学制：</td>
			<td class="text"><?php echo ($info["xuezhi"]); ?></td>
		</tr>
		<tr>
			<td class="t">寝室地址：</td>
			<td class="text"><?php echo ($info["dorm_address"]); ?></td>
			<td class="t">寝室号：</td>
			<td class="text"><?php echo ($info["dorm_number"]); ?></td>
		</tr>
		<tr>
			<td class="t">手持身份证照正面：</td>
			<td colspan="3" style="text-align: center;">
				<img alt="" src="/mineop/1/wstmall/<?php echo ($info["sfz_img01"]); ?>" class="img-rounded">
			</td>
			
		</tr>
		<tr>
			<td class="t" >手持身份证照背面：</td>
			<td colspan="3" style="text-align: center;">
				<img alt="" src="/mineop/1/wstmall/<?php echo ($info["sfz_img02"]); ?>" class="img-rounded">
			</td>
			
		</tr>
		<tr>
			<td class="t">手持学生证证照：</td>
			<td colspan="3" style="text-align: center;">
				<img alt="" src="/mineop/1/wstmall/<?php echo ($info["student_img"]); ?>" class="img-rounded">
			</td>
			
		</tr>
		<tr>
			
			<td colspan="4" style="text-align: center;">
			<input type="hidden" value='<?php echo ($info["u_id"]); ?>' id='uid'>
			
				<input type="button" value="打回重填" class='btn btn-warning' data-toggle="modal" data-target="#myModal">
				&nbsp;&nbsp;&nbsp;&nbsp;
				<?php if($info["status"] != 1): ?><input type="button" value="通过审核" class='yes btn btn-success'><?php endif; ?>
			</td>
			
		</tr>
	</tbody>
</table>
</div>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">打回描述</h4>
      </div>
      <div class="modal-body">
       <textarea class="form-control" rows="3" id='textarea'></textarea>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
        <button type="button" class="btn btn-primary no ">确定</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">

var id= $('#uid').val();



$('.no').click(function(){
	var str = $('#textarea').val();
	$.post('<?php echo U("admin/yfq/back_info");?>', {back_str:str,uid:id}, function(data) {
		if(data =='success'){
			alert("打回成功！");
			location.href ='<?php echo U("Admin/yfq/index_users_verify");?>'; 
		}else{
			alert('抱歉，系统错误！请重新操作。');
		}			
	});
	
});

$('.yes').click(function(){
	$.post('<?php echo U("admin/yfq/yes_info");?>', {uid:id}, function(data) {
		if(data =='success'){
			alert("操作成功！");
			location.href ='<?php echo U("Admin/Users/toEdit");?>?id='+id;
			//location.href ='<?php echo U("Admin/yfq/index_users_verify");?>'; 
		}else{
			alert('抱歉，系统错误！请重新操作。');
		}			
	});
	
});
</script>
</body>
</html>