<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>无标题文档</title>
    
	<script src="__PUBLIC__/js/jquery.js" type="text/javascript"></script>
    <script src="__PUBLIC__/js/uploadPreview.js" type="text/javascript"></script>
	<script src="__PUBLIC__/js/jquery.Jcrop.js" type="text/javascript"></script>
	<script src="__PUBLIC__/js/vScrollPane.js"></script>
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
					aspectRatio:1,
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
					
			});		
		});
});
		
		
        
    </script>

    <link rel="stylesheet" type="text/css" href="__PUBLIC__/Css/ImgCropper.css"/>
    <link href="__PUBLIC__/css/bootstrap.css" rel="stylesheet">
    <link href="__PUBLIC__/css/bootstrap-theme.css" rel="stylesheet">
    <link href="__PUBLIC__/css/jquery.Jcrop.css" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="__PUBLIC__/calendar.css" >
    <style>
	
	.upload_image{max-height:250px; padding:5px;}
	.upload_drag_area{display:inline-block; width:50%; padding:4em 0; margin-left:.5em; border:1px dashed #ddd;  color:#999; text-align:center; vertical-align:middle;}
	
	
	.xcConfirm{visibility:hidden;}
	.xcConfirm .xc_layer{position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: #666666; opacity: 0.5; z-index:10;}
	
	.xcConfirm .popBox{position: absolute; left: 40%; top: 5%; background-color: #ffffff; z-index: 11; width:284px; height: 85%; border-radius: 5px; font-weight: bold; color: #535e66;}
	
	.xcConfirm .popBox .ttBox{height: 40px; line-height: 30px; padding: 10px 30px; border-bottom: solid 1px #eef0f1;}
	
	.xcConfirm .popBox .ttBox .tt{font-size: 16px; display: block; float: left; height: 20px; position: relative;}
	
	.xcConfirm .popBox .txtBox{ overflow:hidden; padding: 0px 30px; height:78%; width:80%;position:relative; float:left; }
	.xcConfirm .popBox .txtBox .list{
		width:80%;
		top:0px;
		height:2000px;
		display:block;
		position: absolute;
	}
	
	.xcConfirm .popBox .txtBox	.hScrollPane_dragbar{height:80%; border-left:#ccc 1px solid;   width: 6px; position:absolute; top:15px; right:2%;}
	.hScrollPane_draghandle{position:absolute; background:url(Images/gunbar.png) no-repeat; height:180px; width:10px; left:-2px; top:0px;}
		
	.xcConfirm .popBox .btnArea{border-top: solid 1px #eef0f1; position:absolute; bottom:0px; background-color:#FFF; display:block;}
	.xcConfirm .popBox .sgBtn{display: block; cursor: pointer; float: left; width: 95px; height: 35px; line-height: 35px; text-align: center; color: #FFFFFF; border-radius: 5px; margin:7px 0px 10px 30px;}

	dd{
		position:relative;
		padding:4px;
		font-size:14px;
		cursor:default;
		color:#999999;
		}
	dt{
		background:#6699FF;
		cursor:pointer;
		color:#ffffff;
		opacity:0.7;
		padding:10px;
		
		
		}
		
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

<form class="form-horizontal center-block" action="<?php echo U(GROUP_NAME . '/Student/updateInfo');?>" enctype="multipart/form-data" method="post" name="course">

<div class="container-fluid" id="mainContainer">
  <h3 class="text-center">修改用户信息</h3>
    


        <div class="form-group">
            <label  class="col-sm-4 control-label ">学生姓名:</label>
            <div class="col-sm-4">
                <input type="text" class="form-control text-center " value="<?php echo ($student["name"]); ?>" disabled>
            </div>
        </div>

        <div class="form-group">
            <label  class="col-sm-4 control-label ">所属院校:</label>
            <div class="col-sm-4">
                <input type="text" id="workType" name="workType" class="form-control text-center " value="成都东软学院" disabled>
            </div>
        </div>

        <div class="form-group">
            <label  class="col-sm-4 control-label ">所属专业:</label>
            <div class="col-sm-4">
                <input id="workAuthor" type="text" class="form-control text-center"  value="数字媒体技术"  disabled >                             
            </div>
        </div>
		
		
		<div class="form-group">
            <label  class="col-sm-4 control-label ">旧密码:</label>
            <div class="col-sm-4">
                <input type="text" class="form-control text-center " name="opwd">
            </div>
        </div>
		
		<div class="form-group">
            <label  class="col-sm-4 control-label ">新的密码:</label>
            <div class="col-sm-4">
                <input type="text" class="form-control text-center " name="npwd">
            </div>
        </div>
		
		<div class="form-group">
            <label  class="col-sm-4 control-label ">确认密码:</label>
            <div class="col-sm-4">
                <input type="text" class="form-control text-center " name="cpwd">
            </div>
        </div>
		
		


        <div class="form-group">
            <label  class="col-sm-4 control-label ">联系电话:</label>
            <div class="col-sm-4">
                <input type="text" class="form-control text-center " value="<?php echo ($student["phone"]); ?>" name="phone">
            </div>
        </div>
        
        <div class="form-group">
            <label  class="col-sm-4 control-label ">邮箱:</label>
            <div class="col-sm-4">
                <input type="text" class="form-control text-center " value="<?php echo ($student["mail"]); ?>" name="mail">
            </div>
        </div>


      	 <div class="form-group">
            <label  class="col-sm-4 control-label ">QQ:</label>
            <div class="col-sm-4">
                <input id="cy_people" type="text" value="<?php echo ($student["qq"]); ?>" class="form-control text-center " name="qq">
            </div>
        </div>
           
         <div class="xcConfirm">
        
        	<div class="xc_layer"></div>
            <div class="popBox">
            		<div class="ttBox">
                    	<div class="tt">选择作者</div>                    
                    </div>
                    
                    <div class="txtBox" id="lisContainer">
			<div class="list"></div>	
                    </div>
                 
                    
                    <div class="btnArea">
                    	<div id="add_Btn" class="sgBtn ok btn-primary">加入</div> 
                        <div class="sgBtn cancel btn-info">取消</div>
                    </div>

            </div>
        </div>
     
           
           


        <div class="form-group" style="margin-top: 20px;">
            <label  class="col-sm-4 control-label ">个人说明:</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" style="height: 200px;" value="<?php echo ($student["brief"]); ?>" name="brief">
            </div>
        </div>
		
        

        <div class="form-group">
            <label  class="col-sm-6 control-label" style="margin-left: 10px;"><h5><b>上传头像:（缩略图默认截取尺寸:150*150px）</b></h5>
			</label>
			
            <button type="button" class="btn btn-default"  id="photo">修改头像</button>
            
        </div>
		
  
		  

        <div style="margin-top: 50px; margin-left:35%;">
            <div class=" col-sm-6 ">
                <button  class="btn btn-primary form-control" type="submit">确认修改
				</button>
            </div>
        </div>


</div>

  <div id="hide_container" class="container-fluid">
      <div class="text-right" id="close_btn">关闭</div>
        <div class="row">
             
             	<input type="file" id="up_img" name="imgfile" class="col-sm-6 control-label" />
				<div  style="margin-left:35%;" >
				<img id="target" class="control-label" width="85%" height="85%"/>
				</div>
		
		
			  <input type="text" id="x" name="x">
			  <input type="text" id="y" name="y">
			  <input type="text" id="w" name="w">
			  <input type="text" id="h" name="h">
           <div class="col-sm-offset-4 col-sm-4" style="left:25px;">
				<input id="screenbutton" class="btn btn-primary form-control" type="button" style="margin-top:20px;" value="裁剪图像">		
          </div>
        </div>
	</div>	
</form>
<script type="text/javascript">
$("#screenbutton").click(function () {
	$("#hide_container").hide();
})
</script>
</body>
</html>