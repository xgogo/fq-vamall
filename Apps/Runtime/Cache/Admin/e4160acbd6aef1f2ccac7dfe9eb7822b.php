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
<body class='wst-page' style='overflow:scroll;overflow-x:hidden;overflow-y:'>
<blockquote>
  <p>审核认证</p>
</blockquote>
<div class="" style='margin: 10px;'>
<table class="table table-hover">
      <thead>
        <tr>
          <th>用户名</th>
          <th>昵称</th>
          <th>姓名</th>
          <th>身份证号码</th>
          <th>申请时间</th>
          <th>认证状态</th>
          <th>操作</th>
        </tr>
      </thead>
      <tbody>
     <?php if(is_array($info)): $i = 0; $__LIST__ = $info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
     	<td><?php echo ($vo["loginName"]); ?></td>
     	<td><?php echo ($vo["userName"]); ?></td>
     	<td><?php echo ($vo["u_name"]); ?></td>
     	<td><?php echo ($vo["sfzhm"]); ?></td>
     	<td><?php echo ($vo["add_time"]); ?></td>
     	<td>    	
     		<?php if($vo["status"] == 1): ?><font color='blue'>已审核</font>
     			<?php elseif($vo["status"] == 2): ?><font color='red'>被打回</font>
     			<?php else: ?><font color='red'>未审核<?php echo ($vo["['status']"]); ?></font><?php endif; ?>
     	</td>
     	<td><a href="<?php echo U('admin/yfq/get_verifyinfo',array('id'=>$vo['u_id']),'');?>" id="check_info" data_id='<?php echo ($vo["u_id"]); ?>'>查看</a></td>
     	</tr><?php endforeach; endif; else: echo "" ;endif; ?>
      </tbody>
    </table>
</div>
<script type="text/javascript">

	
</script>
</body>
</html>