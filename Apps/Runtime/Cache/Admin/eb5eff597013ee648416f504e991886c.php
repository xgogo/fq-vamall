<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title><?php echo ($CONF['mallTitle']); ?>后台管理中心</title>
      <link href="/mineop/1/wstmall/Public/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
      <link href="/mineop/1/wstmall/Apps/Admin/View/css/AdminLTE.css" rel="stylesheet" type="text/css" />
      <!--[if lt IE 9]>
      <script src="/mineop/1/wstmall/Public/js/html5shiv.min.js"></script>
      <script src="/mineop/1/wstmall/Public/js/respond.min.js"></script>
      <![endif]-->
      <script src="/mineop/1/wstmall/Public/js/jquery.min.js"></script>
      <script src="/mineop/1/wstmall/Public/plugins/bootstrap/js/bootstrap.min.js"></script>
      <script src="/mineop/1/wstmall/Public/js/common.js"></script>
      <script src="/mineop/1/wstmall/Public/plugins/plugins/plugins.js"></script>
   </head>
   <script>
   function del(id){
	   Plugins.confirm({title:'信息提示',content:'您确定要删除该会员信息吗?',okText:'确定',cancelText:'取消',okFun:function(){
		   Plugins.closeWindow();
		   Plugins.waitTips({title:'信息提示',content:'正在操作，请稍后...'});
		   $.post("<?php echo U('Admin/Users/del');?>",{id:id},function(data,textStatus){
					var json = WST.toJson(data);
					if(json.status=='1'){
						Plugins.setWaitTipsMsg({content:'操作成功',timeout:1000,callback:function(){
						   location.reload();
						}});
					}else{
						Plugins.closeWindow();
						Plugins.Tips({title:'信息提示',icon:'error',content:'操作失败!',timeout:1000});
					}
				});
	   }});
   }
   </script>
   <body class='wst-page'>
    <form method='post' action='<?php echo U("Admin/Users/index");?>'>
       <div class='wst-tbar'>
       会员账号：<input type='text' id='loginName' name='loginName' class='form-control wst-ipt-10' value='<?php echo ($loginName); ?>'/>
       手机号码：<input type='text' id='userPhone' name='userPhone' class='form-control wst-ipt-10' value='<?php echo ($userPhone); ?>'/>  
       电子邮箱：<input type='text' id='userEmail' name='userEmail' class='form-control wst-ipt-10' value='<?php echo ($userEmail); ?>'/>  
       会员类型：<select id='userType' name='userType' class="form-control wst-ipt-10">
           <option value='-1' <?php if( $userType == -1 ): ?>selected<?php endif; ?>>全部</option>
           <option value='0' <?php if( $userType == 0 ): ?>selected<?php endif; ?>>普通会员</option>
           <option value='1' <?php if( $userType == 1 ): ?>selected<?php endif; ?>>店铺会员</option>
       </select>  
  <button type="submit" class="btn btn-primary glyphicon glyphicon-search">查询</button> 
  <?php if(in_array('hylb_01',$WST_STAFF['grant'])){ ?>
       <a class="btn btn-success glyphicon glyphicon-plus" href='<?php echo U("Admin/Users/toEdit");?>' style='float:right'>新增</a>
  <?php } ?>     
       </div>
       </form>
       <div class="wst-body">
        <table class="table table-hover table-striped table-bordered wst-list">
           <thead>
             <tr>
               <th width='30'>&nbsp;</th>
               <th width='80'>账号</th>
               <th width='80'>用户名</th>
               <th width='60'>手机号码</th>
               <th width='80'>电子邮箱</th> 
               <th width='40'>积分</th>
               <th width='60'>等级</th>
               <th width='130'>注册时间</th>
               <th width='40'>状态</th>
               <th width='130'>操作</th>
             </tr>
           </thead>
           <tbody>
            <?php if(is_array($Page['root'])): $i = 0; $__LIST__ = $Page['root'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
               <td><?php echo ($i); ?></td>
               <td><?php echo ($vo['loginName']); ?></td>
               <td><?php echo ($vo['userName']); ?>&nbsp;</td>
               <td><?php echo ($vo['userPhone']); ?>&nbsp;</td>
               <td><?php echo ($vo['userEmail']); ?>&nbsp;</td>
               <td><?php echo ($vo['userScore']); ?>&nbsp;</td>
               <td>
               <?php if($vo['userType']==0 ): echo ($vo['userRank']); ?>
               <?php else: ?>
               &nbsp;-&nbsp;<?php endif; ?>
               &nbsp;</td>
               <td><?php echo ($vo['createTime']); ?>&nbsp;</td>
               <td>
               <?php if($vo['userStatus']==0 ): ?><span class='label label-danger wst-label'>
			               停用
			     </span>          
			     <?php else: ?>
			     <span class='label label-success wst-label'>
			               启用
			     </span><?php endif; ?>
               </td>
               <td>
               <?php if(in_array('hylb_02',$WST_STAFF['grant'])){ ?>
               <a class="btn btn-default glyphicon glyphicon-pencil" href="<?php echo U('Admin/Users/toEdit',array('id'=>$vo['userId']));?>">修改</a>&nbsp;
               <?php } ?>
               <?php if(in_array('hylb_03',$WST_STAFF['grant'])){ ?>
               <button type="button" class="btn btn-default glyphicon glyphicon-trash" onclick="javascript:del(<?php echo ($vo['userId']); ?>)">刪除</buttona>
               <?php } ?>
               </td>
             </tr><?php endforeach; endif; else: echo "" ;endif; ?>
             <tr>
                <td colspan='11' align='center'><?php echo ($Page['pager']); ?></td>
             </tr>
           </tbody>
        </table>
       </div>
   </body>
</html>