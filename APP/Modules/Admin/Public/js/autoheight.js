function autoHeight(){
	var siderbarLength = $('.sidebar-wrap').height();
	$('.main-wrap').find('iframe').height(siderbarLength);
}

autoHeight();