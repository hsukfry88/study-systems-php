<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>无标题文档</title>
	<link href="__PUBLIC__/css/bootstrap.css" rel="stylesheet">
    <link href="__PUBLIC__/css/bootstrap-theme.css" rel="stylesheet">
	 <script src="__PUBLIC__/js/jquery.js"></script>	
	<style>
    
	#state{
		color:#FF3366 ;
	}
	
	.container{
		border: #CCC 1px solid;
	}
	.imgContainer{
		position:relative;
		width:200px;
		height:200px;
		cursor:pointer;
	}

    .checkboxContainer{
		position:absolute;
		bottom:0px;
		right:0px;
		z-index:2;
	}
	
	#checkAll{
		height:30px;
		line-height:12px;
		text-align:center;
	}
	#checkAllNo{
		height:30px;
		line-height:12px;
		text-align:center;
	}
	
		.workTitle{
				cursor:pointer;
				font-size:18px;
				margin-bottom:-10px;
			}
			#workImg{
				float:left;
				margin-bottom:20px;
				padding:10px;
			}
			#contentContainer{
				float:left;
				width:550px;
				margin-left:60px;
			}
			#cotainer{
				display:block;
				width:1000px;
				padding:30px;
				
			}
			#workList{
				margin-left:30px;
				margin-bottom:20px;
				width:380px;
				clear:both;	
				
			}
			#workeType{
				display:none;
			}
			#close{
				float:right;
				margin-right:20px;
				margin-bottom:20px;
				
			}
			#parent{
				width:95%;
				
				
			}
			#imgContainer{
				width:480px;
				float:left;
				
			}
			#FLVPlayer{
				display:none;
			}
			textarea{
				width:650px;
				float:right;
				
			}
			#close_btn{
				cursor:pointer;
				margin:20px;
			}
		#marks{
			position:absolute;
			z-index:5;
			background-color:#ffffff;
			width:100%;
			height:100%;
			display:none;
		}	
			
	.pass{
		color:#99CC00 ;
	}
	.wait{
		color:#FF3366;
	}
	
	#hide_container{
		border:#CCC solid 1px; 
		position:absolute; 
		z-index:10; 
		top:35%; 
		background-color:#FFF; 
		display:none; width:95%;
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
	.joiner{
		display:none;
	}
	
    </style>
</head>

<body>
<div id="marks"></div>
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
    <div class="container-fluid" >
  		<div class="row">
        	
        	<div class="col-md-2  col-sm-2">
				<img src="<?php echo (geturl($teacher["head"])); ?>" width="100" height="100">
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
					<div class="col-md-3 col-xs-6" >目前展厅状态:<span id="state"><?php if($exhibition['status'] == 'PUBLIC'): ?>开放的<?php else: ?>关闭的<?php endif; ?></span></div>
				</div>
                
                <div class="row">
                	
                    <div class="col-md-7 col-sm-7"></div>
                    <div class="col-md-5 col-sm-5">
						
                    	<div class="row">
                        	
                        	<div class="col-md-4 col-sm-5">
								<a href="information.html"class="btn btn-default btn-sm">开放|关闭展厅</a>
							 </div>
                            <div class="col-md-4 col-sm-5">
								<a href="<?php echo U(GROUP_NAME . '/Leader/addExhibition');?>" class="btn btn-primary btn-sm">创建展厅</a>
							</div>
							
							<div class="col-md-4 col-sm-5">
								<a class="btn btn-primary btn-sm">下载所有作品</a>
							</div>
                            
                        </div>
                    </div>
                </div>
            	
            </div>
        </div>
        <hr>
        
        <div class="row" >

        	<div class="col-md-3 col-sm-3">目前您展厅内的作品：</div>
            <div class="col-md-4 col-sm-4">
				<button class="btn btn-default" id="checkAll">全选</button>
				<button class="btn btn-default" style="margin-left:20px;" id="checkAllNo">全不选</button>
            </div>
            
             
            <div class="col-md-5 col-sm-5">
                
                     <div class="row">
                        <div class="col-md-4 "></div>
                        <div class="col-md-3 col-sm-4 ">	
                                <select value="">
										<option <?php if($mode == 'all'): ?>selected='selected'<?php endif; ?> value="all">查看所有作品</option>
										<option <?php if($mode == 'verified'): ?>selected='selected'<?php endif; ?> value="verified">查看审核通过的作品</option>
										<option <?php if($mode == 'wait'): ?>selected='selected'<?php endif; ?> value="wait">查看审核未通过的作品</option>
								</select>
                                	
                         </div>   
                     </div>
            </div>
        </div>
       
		<script>
		$('select').change(function (){
			var n=0;
			var val = $(this).children(':selected').val();
			var href,newHref;
			if(n==0){
				href =window.location.href;
				newHref = href.substring(href.lastIndexOf('.html')-1,href.lastIndexOf('.html'));
				n=1;
			}
			
			
			href=newHref+'/mode/'+val+'.html';
			window.location.href = href;
		});
		</script>
	   
	   

		<div class="container-fluid" >
        						
                        <button class="btn btn-primary col-sm-2" style="float:right">通过审核</button>
                        <button class="btn btn-default col-sm-2" style="float:right;margin-right:20px;">从展厅移除</button>
               
            
    	</div>

	   
       <div class="container-fluid" style="margin-top:20px;" id="mainContainer" >
       		
               <div class="row">
                    	<?php if(is_array($products)): $i = 0; $__LIST__ = $products;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$value): $mod = ($i % 2 );++$i;?><div class="col-md-2" medium = '<?php echo ($value["mediumjson"]); ?>' author='<?php echo ($value["authorjson"]); ?>' joiner='<?php echo ($value["joinerjson"]); ?>'>
                                
									<img class="tk_container" src="<?php echo (geturl($value["thumb"])); ?>" width="200px" height="200px"/><input class="checkboxContainer" type="checkbox" name="work" />
									<div class="text-center workeName"><?php echo ($value["name"]); ?></div>
									
									<div class="text-center workeAuthor">
											<span>作者:</span>
											<span>
											<?php if(is_array($value['author'])): $i = 0; $__LIST__ = $value['author'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$f): $mod = ($i % 2 );++$i; echo ($f['name']); ?>&nbsp<?php endforeach; endif; else: echo "" ;endif; ?>
											</span>
									</div>
									
									<div class="joiner">
									
										<?php if(is_array($value['joiner'])): $i = 0; $__LIST__ = $value['joiner'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$j): $mod = ($i % 2 );++$i; echo ($j['name']); ?>&nbsp<?php endforeach; endif; else: echo "" ;endif; ?>
									</div>
									
										<div class="text-center">作品评分：<?php echo ($value["grade"]); ?></div>
										<input type='hidden' class='exState' value='<?php echo ($value["exState"]); ?>'/>
										<input type='hidden' class='workeId' value='<?php echo ($value["id"]); ?>'/>
										<input type='hidden' class='workeInfo' value='<?php echo ($value["intro"]); ?>'/>
										<input type='hidden' class='teacherComment' value='<?php echo ($value["comment"]); ?>'/>
									
									<?php if($value['exState'] == '1'): ?><div class="text-center">审核状态：<span class="pass">通过审核</span></div>
									<?php else: ?>
									<div class="text-center">审核状态：<span class="wait">未审核</span></div><?php endif; ?>
								

								
                            </div><?php endforeach; endif; else: echo "" ;endif; ?>
                </div>
       
       </div> 

	   
        <!--隐藏弹框区域-->		
<div id="hide_container" class="container-fluid">
      <div class="text-right" id="close_btn">关闭</div>	  
	<div id="parent">
		<div id="container" >
					<div id="imgContainer">
						<img id="workImg"  src="" width="480">  
						<div id="workList"></div>
						
					</div>
					<div id="contentContainer">
							<h4 id='tkName'>作品名称：1.1米的力量</h4>
											  
							<div class="col-md-12">	
									<span id="tk_authotInfo"></span>
									
							</div>
											   
							<div class="col-md-12">
								 <span>参与人:</span>
								 <span id="tk_joinerInfo"></span>
							</div>
							

						
						<div class="col-md-12">
						<h5 id="introTitle">作品简介:</h5>
							<p  id='workContent'></p>
						</div>
						
						<div class="col-md-12" id="grade">
									教师评分：90分
						</div>
						
						<div class="col-md-12">
							<h5 id="introTitle">教师点评:</h5>
							<p  id='teacherSay'></p>
						</div>
						
						

						
						<div class="row" style="margin-bottom:50px; margin-top:50px;">
							<div class="col-md-12">
								<form class="col-md-6 agreeSubmit" action="<?php echo U(GROUP_NAME . '/Leader/agreeSubmit');?>" method="post">
									<input type='hidden' name='EXWorkeId' id='EXWorkeId'>
									<button class="btn btn-primary col-sm-8" style="margin-left:15px;">通过审核</button>
								</form>
								<button class="btn btn-default col-sm-4">移除作品</button>
							</div>
						</div> 	
					</div>
		</div>       	  
    </div>    
</div>
	

    
    
   	
    <script>
    	
		$(function(){
		
			$('#close_btn').click(function(){
				
				$('#hide_container').animate({
						 opacity: 'toggle', 
					},'slow'
				);
				$('#marks').css({'display':'none'});
			});
				
				
			$('.tk_container').click(function(){
				
				
			
				var medium = eval($(this).parent().attr('medium'));
				//alert(medium)
				//初始化作品名称
				var workeNameStr=$(this).siblings('.workeName').html();
				$('#tkName').html(workeNameStr);
				
				//获取作品ID
				var numId=$(this).siblings('.workeId').val();
				$('#indexId').val(numId);
				$('#EXWorkeId').val(numId);
				//获取作品简介
				var workeInfo=$(this).siblings('.workeInfo').val();
				//String(workeInfo);
				//alert(workeInfo);
				$('#workContent').html(workeInfo);
				//获取作品分数
				var grade=$(this).siblings('.workGrade').html();
				$('#grade').html(grade);
				//获取教师点评
				var comment=$(this).siblings('.teacherComment').val();
				$('#teacherSay').html(comment);
				
				//判断作品审核状态，为1通过时取消审核按钮
				var exState=$(this).siblings('.exState').val();
				if(exState==1){
					$('.agreeSubmit').css({display:"none"});
				}else{
					$('.agreeSubmit').css({display:"block"});
				}
				//获取作品参与人
				var joinerName=$(this).siblings('.joiner').text();
				$('#tk_joinerInfo').html(joinerName);
				//获取作品作者
				var authorName=$(this).siblings('.workeAuthor').text();
				$('#tk_authotInfo').html(authorName);
				
				
				
				//初始化遮罩层尺寸
				var marksHeightVal=$(document).height();
				$('#marks').height(marksHeightVal).css({"opacity":0.8,"display":"block"});
				
				init(medium);
				//资源文件点击事件
				$('.workTitle').click(function(){
							var workUrl=$(this).children(".ImgUrl").val();
							var workType=$(this).children('#workeType').html();
							//alert(workType);
							if(workType=="2"){
								$('#FLVPlayer').css({"display":"block"});
								var videoURL = $('#strobeplayer').attr('src');
								videoURL = videoURL + '?' + workUrl;
								$('#strobeplayer').attr('src', videoURL);
								$('#workImg').hide();
							}
							else{
								$('#FLVPlayer').css({"display":"none"});
								$('#workImg').show();
								$('#workImg').attr('src',workUrl);
							}
							//alert(document.getElementById("strobeplayer").document);
							//alert(workUrl.val());
							
				});
							
				//初始化遮罩层尺寸
				var marksHeightVal=$(document).height();
				$('#marks').height(marksHeightVal).css({"opacity":0.8,"display":"block"});
				//隐藏框相对于作品位移
				var topPostion=$(this).offset();
				topPostion=topPostion.top+20;
				//alert(topPostion);
				var X_Potion=($(document).width()-$('#hide_container').width())/2;
				//alert(X_Potion);
				
				$('#hide_container').animate({
						 opacity: 'toggle',
						 diplay:'block',
					},'slow'
				)
				.css({'display':'block','top':topPostion,'left':X_Potion-17});
				
				$('#title').html('titleName');
			});	
				


				function init(worke){
					//JOSN数据
					//test.html页面为播放器地址
					/**
				var worke=[
					{"name":"电影剧照1","url":"Img/电影剧照1.JPG","type":"1"},
					{"name":"电影剧照2","url":"Img/电影剧照2.JPG","type":"1"},
					{"name":"电影剧照3","url":"Img/电影剧照3.JPG","type":"1"},
					{"name":"电影剧照4","url":"Img/电影剧照4.JPG","type":"1"},
					{"name":"1.1米的力量","url":"/playViedo.html?test&","type":"2"},
					{"name":"展厅介绍","url":"http://pj.com/index.php/Index/Common/playVideo.html?/one2&","type":"2"}
				];
					**/
				$('#workImg').attr("src",worke[0].url);
				$('#workList').html("");
				for(var i=0;i<worke.length;i++){
					var workType=worke[i].type;
					//alert(workType);
					var workName=worke[i].name;
					var workUrl=worke[i].url;
					$('#workList').append('<div class="workTitle"><h5>'+workName+'</h5><input class="ImgUrl" type=hidden value="'+workUrl+'" />'+'<p id=workeType>'+workType+'</p></div>');
					
				}
			}
			
			
			$("#checkAll").click(function() {
					
				$("input[name='work']").each(function () {
                    $(this).prop("checked", true);
                }); 
					
            });
			
			$("#checkAllNo").click(function() {
					
				$("input[name='work']").each(function () {
                    $(this).prop("checked", false);
                }); 
					
            });

			
		})
			
    
    </script>       
            
</body>
</html>