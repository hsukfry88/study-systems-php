(function($){
	
			$.extend(jQuery.easing,{
			easeOutQuint: function (x, t, b, c, d) {
			return c*((t=t/d-1)*t*t*t*t + 1) + b;
		}
	});
	
	$.fn.vScrollPane=function(settings){
		
		settings=$.extend(true,{},$.fn.vScrollPane.defaults,settings);
		
		this.each(function(){
			
			var container=$(this),
				//容器下的移动对象
				mover=container.find(settings.mover),
				//指定显示区域的高度
				h="200",
				//获取移动对象的高度
				c=settings.moverH||mover.height(),
				//bar条  handle块
				
				dragbar=(container.find(".hScrollPane_dragbar").length==0 && c>h)?
				container.append('<div class="hScrollPane_dragbar"><div class="hScrollPane_draghandle"></div></div> ').find(".hScrollPane_dragbar"):container.find(".hScrollPane_dragbar"),
				handle=container.find(".hScrollPane_draghandle");
				
 				dragbar.css("height",container.height());

				mover.stop().css("top","0px"); 
				container.unbind();
				handle.unbind();
				dragbar.unbind();
				
				//限定最大移动距离
				var maxlen=parseInt(dragbar.height())-parseInt(handle.outerWidth());
				//滑动块绑定移动事件
				handle.bind("mousedown",function(e){
					//获取相对于页面顶部的位置
					var y=e.pageY,
						//获取滑块起点位置
						stratY=parseInt(handle.css("top"));
					//判断鼠标拖拽滚动条的样式
					if(settings.handleCssAlter){$(this).addClass(settings.handleCssAlter);}
					$(document).bind("mousemove",function(e){
						var top=stratY+e.pageY-y<0?0:(stratY+e.pageY-y>=maxlen?maxlen:stratY+e.pageY-y);
						//更改滑动条到相应位置
						handle.stop().css({"top":top});
						if(settings.easing){
							mover.stop().animate({
							top:-top/maxlen*(c-h)			
						},{duration:1500,easing:'easeOutQuint',queue:false})
						}else{
							mover.css({top:-top/maxlen*(c-h)});
						}
						//阻止事件冒泡
						return false;
					});
					
					
					$(document).bind("mouseup",function(e){
					//如果设定了特效，删除特效
					if(settings.handleCssAlter)
					{handle.removeClass(settings.handleCssAlter);}
					//删除移动绑定
					$(this).unbind("mousemove");
					});
				
				}).click(function(){	
					//false阻止时间冒泡,
					return false;
				})
				
				if(settings.dragable){
				mover.bind("mousedown",function(e){
					var x=e.pageY;
					$(this).bind("mousemove",function(e){
						$.fn.hScrollPane.move(settings,mover,handle,w,c,maxlen,x,e.pageY);
						return false;
					})
					$(document).bind("mouseup",function(){
						mover.unbind("mousemove");
					})
				})
			}
		
		});
	}
	$.fn.vScrollPane.defaults={
		showArrow:false,
		handleMinWidth:0,
		dragable:true,
		easing:true,
		mousewheel:{bind:true,moveLength:172}	
	};
	$.fn.vScrollPane.move=function(settings,mover,handle,h,c,maxlen,y,ny){
	
		if(arguments.length==7){
			var top=parseInt(mover.css("top"))+x*settings.mousewheel.moveLength;
		}else{
			var top=parseInt(mover.css("top"))+((ny-y)/h)*(c-h);
		}
		top=top.toFixed(0);
		top=top>0?0:top<h-c?h-c:top;
		var handle_top=(top/(h-c))*maxlen;
		//动画效果
		if(settings.easing){
			mover.stop().animate({
				top:top			
			},{duration:1500,easing:'easeOutQuint',queue:false});
			
			handle.stop().animate({
				top:handle_top			
			},{duration:1500,easing:'easeOutQuint',queue:false});
		}else{
			mover.stop().animate({
				top:top			
			},{duration:5,queue:false});
			
			handle.css({top:handle_top});
		}
	
	};

})((jQuery));