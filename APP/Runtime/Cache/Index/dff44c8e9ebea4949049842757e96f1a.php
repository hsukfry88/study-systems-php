<?php if (!defined('THINK_PATH')) exit();?>﻿
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>登陆页</title>
    <link href="__PUBLIC__/css/bootstrap.css" rel="stylesheet">
    <link href="__PUBLIC__/css/bootstrap-theme.css" rel="stylesheet">
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
    <form class="form-horizontal center-block" method="post" name="login" action="<?php echo U(GROUP_NAME . '/Index/login');?>">
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-4 control-label">Number</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" id="inputEmail3" placeholder="输入您的邮箱或手机或工号登陆" name="number">
            </div>
        </div>
        <div class="form-group">
            <label for="inputPassword3" class="col-sm-4 control-label">Password</label>
            <div class="col-sm-4">
                <input type="password" class="form-control" id="inputPassword3" placeholder="输入密码" name="password">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-4 col-sm-10">
                <div class="radio">
                    <label>
                        <input type="radio" name="auther" value="0" checked="checked""> 学生
                    </label>

                    <label>
                        <input type="radio" name="auther" value="1"> 教师
                    </label>

                    <label>
                        <input type="radio" name="auther" value="2">领导
                    </label>

                    <label>
                        <input type="radio" name="auther" value="3"> 管理员
                    </label>

                </div>


            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-4 col-sm-4 ">
                <button class="btn btn-default form-control">登陆</button>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-4 col-sm-4 ">
                <button type="reset" class="btn btn-primary form-control">注册</button>
            </div>
        </div>
    </form>
</div>

</body>
</html>