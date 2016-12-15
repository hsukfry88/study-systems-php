$(function (){
	$(".sub-menu").prev().click(function (){
		var state = $(this).next().css('display');
		if(state == 'block')	$(this).next().css('display','none');
		else	$(this).next().css('display','block');
		autoHeight();
	})
})