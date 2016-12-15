<?php if (!defined('THINK_PATH')) exit();?>﻿
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>欢迎页</title>
    <link href="__PUBLIC__/css/bootstrap.css" rel="stylesheet">
    <link href="__PUBLIC__/css/bootstrap-theme.css" rel="stylesheet">

    <script src="__PUBLIC__/js/jquery-1.8.2.js"></script>
</head>
<body>

<nav class="navbar navbar-default">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand text-center" href="#">数字艺术展厅</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                <li ><a href="#">首页<span class="sr-only">(current)</span></a></li>
                <li ><a href="#">展厅<span class="sr-only">(current)</span></a></li>
                <li class="active" ><a href="index.html">个人中心</a></li>
                <li ><a href="<?php echo U(GROUP_NAME . '/Index/logout');?>">退出<span class="sr-only">(current)</span></a></li>
            </ul>


        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>

<div class="container-fluid" >
	
	
	
    <form class="form-horizontal center-block" action="creatclass.php">

		
        <div class="form-group">
            <label  class="col-sm-7 control-label">尊敬的<?php echo (session('uname')); ?>老师，您可以进行以下操作:</label>

        </div>
        <div class="form-group">
            <div class="col-sm-offset-4 col-sm-4 ">
	
               <a href="<?php echo U(GROUP_NAME . '/Teacher/addClass');?>" class="btn btn-primary form-control">开设新的课程</a>
            	
			</div>
       </div>
	</form>	
	
	
	
	
	<form class="form-horizontal center-block">
        <div class="form-group">
            <div class="col-sm-offset-4 col-sm-4 ">
                <a href="<?php echo U(GROUP_NAME . '/Teacher/individual');?>" class="btn btn-default form-control">审核学生作业</a>
            </div>
        </div>
	</form>
	
	
	<form class="form-horizontal center-block">
        <div class="form-group">
            <div class="col-sm-offset-4 col-sm-4 ">
                <a href="changeclass.html" class="btn btn-default  form-control">修改课程</a>
            </div>
        </div>

    </form>
	
		<form class="form-horizontal center-block">
        <div class="form-group">
            <div class="col-sm-offset-4 col-sm-4 ">
                <a href="information.html" class="btn btn-default  form-control">修改用户信息</a>
            </div>
        </div>

    </form>
	
</div>

</body>
</html>