<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>创建课程</title>

    <script type="text/javascript" src="__PUBLIC__/js/calendar.js" ></script>
    <script type="text/javascript" src="__PUBLIC__/js/calendar-zh.js" ></script>
    <script type="text/javascript" src="__PUBLIC__/js/calendar-setup.js"></script>


    <link rel="stylesheet" type="text/css" href="__PUBLIC__/Css/ImgCropper.css"/>
    <link href="__PUBLIC__/css/bootstrap.css" rel="stylesheet">
    <link href="__PUBLIC__/css/bootstrap-theme.css" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="__PUBLIC__/css/calendar.css" >

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
     <h3 class="text-center">开设课程</h3>
    <form class="form-horizontal center-block" method="post" action="<?php echo U(GROUP_NAME . '/Teacher/addClassService');?>" enctype="multipart/form-data" 
          name="course">
        <div class="form-group">
            <label  class="col-sm-4 control-label ">所属学校:</label>
            <div class="col-sm-4">
                <input type="text" class="form-control text-center " value="成都东软学院" disabled>
            </div>
        </div>

        <div class="form-group">
            <label  class="col-sm-4 control-label ">所属系别:</label>
            <div class="col-sm-4">
                <input type="text" class="form-control text-center " value="数字艺术" disabled>
            </div>
        </div>

        <div class="form-group">
            <label  class="col-sm-4 control-label ">任课老师:</label>
            <div class="col-sm-4">
                <input type="text" class="form-control text-center " value="<?php echo (session('uname')); ?>" disabled>
            </div>
        </div>

        <div class="form-group">
            <label  class="col-sm-4 control-label ">课程名称:</label>
            <div class="col-sm-4">
                <input type="text" class="form-control text-center "  name="course" >
            </div>
        </div>




        <div class="form-group">
            <label  class="col-sm-4 control-label">作业截止提交时间:</label>

            <div class="col-sm-4">
                <input type="text" class="form-control"  id="EntTime" name="EntTime" onclick="return showCalendar('EntTime', 'y-mm-dd');">
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-4 control-label">作品类型:</label>
            <div class="col-sm-4">

        				<select  name="option1" class="form-control  text-center">
								<option value="-1">请选择类型</option>
								<?php if(is_array($type)): foreach($type as $key=>$value): ?><option value="<?php echo ($value["id"]); ?>"><?php echo ($value["name"]); ?></option><?php endforeach; endif; ?>
						</select>
            </div>
        </div>


        <div class="form-group">
            <label  class="col-sm-4 control-label ">课程简介:</label>
            <div class="col-sm-4">
                <textarea  class="form-control " style="height: 200px;"  name="intro" ></textarea>
            </div>
        </div>



        <div class="form-group" style="margin-top: 50px;">
		<label  class="col-sm-4 control-label "></label>
            <div class="col-sm-4 ">
                <button type="submit" class="btn btn-primary form-control" >开始课程</button>
            </div>
        </div>
    </form>

</div>
</body>

</html>