$(function(){

'use strict';


//hide placeholder
$('[placeholder]').focus(function(){

	$(this).attr('data-text',$(this).attr('placeholder'));
	$(this).attr('placeholder','');
}).blur(function(){
	$(this).attr('placeholder',$(this).attr('data-text'));
});

//Add astrisk with required field
$('input').each(function(){
	if($(this).attr('required')==='required') 
	{
           $(this).after('<span class="astrisk">*</span>');
	}
});

//show passsword field 
var passwordField=$('.password');
$('.show-pass').hover(function(){passwordField.attr('type','text');},function(){passwordField.attr('type','password');});

// delete command prompt
$('.confirm').click(function(){
return confirm('Are You Sure?');
});

//show hidden button on hover event with cat class for transition effect by toggleClass //aita lagenai css er madhome kora hoise
//$('.cat').hover(function(){$('.hidden-buttons').addClass('show-hidden-buttons',2000,'easeInQuart');},function(){$('.hidden-buttons').removeClass('show-hidden-buttons',2000);});
/*$('.hidden-buttons').toggleClass('show-hidden-buttons',2000,'easeInQuart');*/

//category view option
$('.cat h3').click(function(){
 $(this).next('.full-view').fadeToggle(200);
 });

//toggling option by clicking in ordering
$('.option span').click(function(){
 $(this).addClass('active').siblings('span').removeClass('active');

 //changing view by clicking classic and full
 if($(this).data('view')==='full')
 {
     $('.cat .full-view').fadeIn(200);
 }
 else
 {
      $('.cat .full-view').fadeOut(200);
 }
});


	$('.fa-plus').click(function(){
		$('.panel-body').fadeToggle(200);
	});


});