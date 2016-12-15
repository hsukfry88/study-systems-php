<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>创建展厅</title>
	
	
	<link type="text/css" rel="stylesheet" href="__PUBLIC__/css/calendar.css" >
	<script type="text/javascript" src="__PUBLIC__/js/calendar.js" ></script>
    <script type="text/javascript" src="__PUBLIC__/js/calendar-zh.js" ></script>
    <script type="text/javascript" src="__PUBLIC__/js/calendar-setup.js"></script>
	<script src="__PUBLIC__/js/jquery.js" type="text/javascript"></script>
    <script src="__PUBLIC__/js/uploadPreview.js" type="text/javascript"></script>
	<script src="__PUBLIC__/js/jquery.Jcrop.js" type="text/javascript"></script>


	
	
    <script type="text/javascript">
       	window.onload=function(){
			 new uploadPreview({ UpBtn: "up_img", DivShow: "imgdiv", ImgShow: "target" });
			
	 }
		
		$('document').ready(function (){
			$('#photo').click(function(){
			
				//初始化遮罩层尺寸
				var marksHeightVal=$(document).height();
				$('#marks').height(marksHeightVal).css({"opacity":0.8,"display":"block"});
				//隐藏框相对于作品位移
				var topPostion=$(this).offset();
				topPostion=topPostion.top-300;
				var X_Potion=($(document).width()-$('#hide_container').width())/2;
				
				$('#hide_container').animate({
						 opacity: 'toggle',
						 diplay:'block',
					},'slow'
				)
				.css({'display':'block','top':topPostion,'left':X_Potion-17});

				
			});
			
			$('#close_btn').click(function(){
				
				$('#hide_container').animate({
						 opacity: 'toggle',
						 
						 
					},'slow'
				);
				$('#marks').css({'display':'none'});
				
			});
			
			
		});
		
		$(function($) {
			
				//截图上传代码
			 $('#target').bind("mouseenter",function(){
			var api = $.Jcrop('#target',{
					//限定剪裁尺寸
					onSelect:updateCoords
			});
			
			//剪裁上传区域
			function updateCoords(c){
			  $('#x').val(c.x);
			  $('#y').val(c.y);
			  $('#w').val(c.w);
			  $('#h').val(c.h);
			};
			
			function checkCoords(){
			  if (parseInt($('#w').val())) {
				return true;
			  };
			  alert('请先选择要裁剪的区域后，再提交。');
			  return false;
			};
			
			//alert(api);
			$('#up_img').bind("click",function(){
					api.destroy();
					new uploadPreview({ UpBtn: "up_img", DivShow: "imgdiv", ImgShow: "target" });
					
			})
			
			//剪裁上传区域
			function updateCoords(c){
			  $('#x').val(c.x);
			  $('#y').val(c.y);
			  $('#w').val(c.w);
			  $('#h').val(c.h);
			};
			
			function checkCoords(){
			  if (parseInt($('#w').val())) {
				return true;
			  };
			  alert('请先选择要裁剪的区域后，再提交。');
			  return false;
			};
			
			//alert(api);
			$('#up_img').bind("click",function(){
					api.destroy();
					new uploadPreview({ UpBtn: "up_img", DivShow: "imgdiv", ImgShow: "target" });
					
				});
		});
	});
 
    </script>

    <link rel="stylesheet" type="text/css" href="__PUBLIC__/Css/ImgCropper.css"/>
    <link href="__PUBLIC__/css/bootstrap.css" rel="stylesheet">
    <link href="__PUBLIC__/css/bootstrap-theme.css" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="__PUBLIC__/calendar.css" >
	
	<style>
	
			#hide_container{
		border:#CCC solid 1px;
		position:absolute; 
		z-index:10; 
		top:35%; 
		background-color:#FFF;  
		padding:30px;
		padding-top:0px; 
		width:1000px;
		display:none;
		box-shadow: 2px 2px 5px #CCCCCC; 
		border-radius:5px;

		
		}
	#marks{
			position:absolute;
			z-index:5;
			background-color:#ffffff;
			width:100%;
			height:100%;
			display:none;
	}
	
	
	#close_btn{
		cursor:pointer;
		margin:20px;
	}
	
	</style>

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


<form class="form-horizontal center-block" action="<?php echo U(GROUP_NAME . '/Leader/addExhibitionService');?>" enctype="multipart/form-data" method="post" name="course" onsubmit="return checkCoords();">

<div class="container-fluid" >
     <h3 class="text-center">创建展厅</h3>
    
        <div class="form-group">
            <label  class="col-sm-4 control-label ">展厅名称:</label>
            <div class="col-sm-4">
                <input type="text" class="form-control "  placeholder="15字以内" name="name">
            </div>
        </div>



        <div class="form-group">
            <label  class="col-sm-4 control-label">创建人:</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" value="<?php echo (session('uname')); ?>" disabled>
            </div>
        </div>


        <div class="form-group">
            <label  class="col-sm-4 control-label">展厅截止时间:</label>

            <div class="col-sm-4">
                <input type="text" class="form-control"  id="EntTime" name="EntTime" onclick="return showCalendar('EntTime', 'y-mm-dd');">
            </div>
        </div>


        <div class="form-group">
            <label  class="col-sm-4 control-label">展厅介绍:</label>

            <div class="col-sm-4">
                <textarea class="col-sm-4" style="width: 420px; height: 100px; " name="intro"></textarea>
            </div>
        </div>

        <div class="form-group">
            <label  class="col-sm-4 control-label">展厅海报：</label>
            <div class="col-sm-4">
				
				 <button type="button" class="btn btn-default"  id="photo">上传海报</button>

            </div>
        </div>
		
		<div class="form-group">
            <label  class="col-sm-4 control-label">展厅解说音频上传:</label>

            <div class="col-sm-4">
                 <input type="file" name="soundFlie">
            </div>
        </div>
		
		
        <div class="form-group" style="margin-top: 50px;">
			 <label  class="col-sm-4 control-label"></label>
            <div class="col-sm-4 ">
                <button type="submit" class="btn btn-primary form-control" >确认上传</button>
            </div>
        </div>
	
		<div id="hide_container" class="container-fluid">
      <div class="text-right" id="close_btn">关闭</div>
        <div class="row">
             
             	<input type="file" id="up_img" name="imgfile" class="col-sm-6 control-label" />
				<div  style="margin-left:35%;" >
				<img id="target" class="control-label"/>
				</div>
		
		
			  <input type="hidden" id="x" name="x">
			  <input type="hidden" id="y" name="y">
			  <input type="hidden" id="w" name="w">
			  <input type="hidden" id="h" name="h">
           <div class="col-sm-offset-4 col-sm-4" style="left:25px;">
				<input class="btn btn-primary form-control" type="button" style="margin-top:20px;" value="裁剪图像">		
          </div>
        </div>
	</div>
	

</div>
</form>

</body>
</html>