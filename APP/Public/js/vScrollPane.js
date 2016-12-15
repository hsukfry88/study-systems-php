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
				//�����µ��ƶ�����
				mover=container.find(settings.mover),
				//ָ����ʾ����ĸ߶�
				h="200",
				//��ȡ�ƶ�����ĸ߶�
				c=settings.moverH||mover.height(),
				//bar��  handle��
				
				dragbar=(container.find(".hScrollPane_dragbar").length==0 && c>h)?
				container.append('<div class="hScrollPane_dragbar"><div class="hScrollPane_draghandle"></div></div> ').find(".hScrollPane_dragbar"):container.find(".hScrollPane_dragbar"),
				handle=container.find(".hScrollPane_draghandle");
				
 				dragbar.css("height",container.height());

				mover.stop().css("top","0px"); 
				container.unbind();
				handle.unbind();
				dragbar.unbind();
				
				//�޶�����ƶ�����
				var maxlen=parseInt(dragbar.height())-parseInt(handle.outerWidth());
				//��������ƶ��¼�
				handle.bind("mousedown",function(e){
					//��ȡ�����ҳ�涥����λ��
					var y=e.pageY,
						//��ȡ�������λ��
						stratY=parseInt(handle.css("top"));
					//�ж������ק����������ʽ
					if(settings.handleCssAlter){$(this).addClass(settings.handleCssAlter);}
					$(document).bind("mousemove",function(e){
						var top=stratY+e.pageY-y<0?0:(stratY+e.pageY-y>=maxlen?maxlen:stratY+e.pageY-y);
						//���Ļ���������Ӧλ��
						handle.stop().css({"top":top});
						if(settings.easing){
							mover.stop().animate({
							top:-top/maxlen*(c-h)			
						},{duration:1500,easing:'easeOutQuint',queue:false})
						}else{
							mover.css({top:-top/maxlen*(c-h)});
						}
						//��ֹ�¼�ð��
						return false;
					});
					
					
					$(document).bind("mouseup",function(e){
					//����趨����Ч��ɾ����Ч
					if(settings.handleCssAlter)
					{handle.removeClass(settings.handleCssAlter);}
					//ɾ���ƶ���
					$(this).unbind("mousemove");
					});
				
				}).click(function(){	
					//false��ֹʱ��ð��,
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
		//����Ч��
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