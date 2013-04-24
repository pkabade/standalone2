//Jquery is mandatory for this javscript file. Pleas mention your dependent javascript files 

/* Dependant files :
 * 	1. common/js/jquery-1.7.2.min.js
 * 
 * 
 * 
 */
$(document).ready(function(){
	
	//Home page image slider
	$("#slide-runner").easySlider({ 
		numeric: true,
		auto: true,
		continuous: true,
		numericId: 	'slide-controls',
		controlsBefore:''
	});
	
	//Common for all pages. To open chack availibility box
	$('.availability a.arrow').click(function(){
		 $('.availability_box').slideToggle('slow');
	});
	$('.availability_box a.close').click(function(){
		$('.availability_box').slideUp('slow');
	});
	 
	//Set Main navigation Bar on scroll.
	$(document).scroll(function(e){
		//navbar-fixed-top
		var scroll_count = $(window).scrollTop();
		if(scroll_count >119){
			$('#main_navigation').addClass('navbar-fixed-top');
		}else{
			$('#main_navigation').removeClass('navbar-fixed-top');
		}
	});
	
	//Signin/ register show hide
	$(".signin_link").click(function(){
		$('#register_box').hide();
		$('#signin_box').slideToggle('slow');
	});
	$(".register_link").click(function(){
		$('#signin_box').hide();
		$('#register_box').slideToggle('slow');
	});
	$(".closes").click(function(){
		$('#register_box,#signin_box').hide();
	});
	if(jQuery().easyAccordion){
		$('#ti_accordion').easyAccordion({ 
			autoStart: true,
			slideInterval: 3000,
			slideNum:false
		}); 
	}
});//document ready