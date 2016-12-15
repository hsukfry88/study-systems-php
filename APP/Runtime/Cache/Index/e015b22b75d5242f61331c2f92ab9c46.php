<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>无标题文档</title>
	<link href="__PUBLIC__/css/bootstrap.css" rel="stylesheet">
    <link href="__PUBLIC__/css/bootstrap-theme.css" rel="stylesheet">
	<style>
    
	.container{
		border: #CCC 1px solid;
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
	
    
    <!--主体内容区-->
    <div class="container-fluid">
  		<div class="row">
        	
        	<div class="col-md-2  col-sm-2"><img src="<?php echo (geturl($teacher["head"])); ?>" width="100" height="100">
            </div>
			<div class="col-md-10 col-sm-10">
            
            	<div class="row">
                	<div class="col-md-3 col-xs-6">姓名：<?php echo ($teacher["name"]); ?></div>
                </div>
                
                <div class="row">
                	<div class="col-md-3 col-xs-3">学校:成都东软学院</div>
                    <div class="col-md-3 col-xs-3">院系:数字艺术系</div>
                    <div class="col-md-3 col-xs-3">管理专业:数字媒体技术</div>
                    <div class="col-md-3 col-xs-3">通知：0条</div>
                </div>
                
                <div class="row">     
                    <div class="col-md-3 col-xs-3">QQ:<?php echo ($teacher["qq"]); ?></div>
                    <div class="col-md-3 col-xs-5">邮箱:<?php echo ($teacher["mail"]); ?></div>
                </div>
                
                <div class="row">
                	
                    <div class="col-md-7 col-sm-7"></div>
                    <div class="col-md-3 col-sm-3">
                    	<div class="row">
                        	
                        	<div class="col-md-4 col-sm-4">
                            <a href="<?php echo U(GROUP_NAME . '/Leader/information');?>" class="btn btn-default btn-sm">修改用户信息</a>
							</div>
							<div class="col-sm-1"></div>
                            <div class="col-md-4 col-sm-4">
                            <a href="<?php echo U(GROUP_NAME . '/Leader/addExhibition');?>" class="btn btn-primary btn-sm">创建展厅</a></div>
                            
                        </div>
                    </div>
                </div>
            	
            </div>
        </div>
        <hr>
        
        <div class="row">
        
        	<div class="col-md-3 col-sm-3">以下是您所创建的展厅：</div>
            <div class="col-md-9 col-sm-9">
                
                            <div class="row">
                            	<div class="col-md-4 "></div>
                                <div class="col-md-3 col-sm-4 ">
                                	
                                    <select>
                                    	<option>筛选展厅</option>
										<?php if(is_array($exhibitions)): foreach($exhibitions as $key=>$exName): ?><option><?php echo ($exName["name"]); ?></option><?php endforeach; endif; ?>
                                    </select>
                                	
                                </div>
                                

                                
                                
                            </div>
            </div>
        </div>
        
        
        <div class="row" style="margin-top:50px;">
        	<?php if(is_array($exhibitions)): foreach($exhibitions as $key=>$value): ?><div class="col-md-3">
                        <a href="<?php echo U(GROUP_NAME . '/Leader/showRoom?id='.$value[id]);?>"><img class="tk_container" src="<?php echo (geturl($value["thumb"])); ?>" width="100%" height="100%"/></a>
                        <div class="text-center workeName">展厅名称：<?php echo ($value["name"]); ?></div>
                        <div class="text-center">审核状态：<?php if($value['status'] == 'PUBLIC'): ?>开放<?php else: ?>关闭<?php endif; ?></div>
                        <div class="text-center">展厅截止时间：<?php echo (date("Y/m/d",$value["EndTime"])); ?></div>
                    </div><?php endforeach; endif; ?>
                    
                
        
        </div>	
       
                        </div> 

	
    
            
</body>
</html>