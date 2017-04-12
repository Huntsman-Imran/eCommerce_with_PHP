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
 $(this).next('.full-view').fadeToggle(200);                                    //example of next for traversing
 });

//toggling option by clicking in ordering
$('.option span').click(function(){
 $(this).addClass('active').siblings('span').removeClass('active');   

 //changing view by clicking classic and full in category
 if($(this).data('view')==='full')                                                //data-view=full part
 {
     $('.cat .full-view').fadeIn(200);
 }
 else
 {
      $('.cat .full-view').fadeOut(200);
 }
});

/*******************************************************front end start*****************************************************************/

//fadeing in signup or login part of login page
$('.login-page h4 span').click(function(){
	$(this).addClass('selected').siblings().removeClass('selected');
	$('.login-page form').hide();
	$('.'+$(this).data('class')).fadeIn(100);                          //data-class=login or signup
});


//liv preview of add new itrm

/*class e live-name or live-des or live-price likhe prottek tar jonno alada vhabe live preview dakhano jae *****************turorial-98**********************

$('.live-name').keyup(function(){
	$('.live-preview .caption h3').text($(this).val());
});
$('.live-des').keyup(function(){
	$('.live-preview .caption p').text($(this).val());
});

$('.live-price').keyup(function(){
	$('.live-preview .price-tag').text($(this).val());
});

*/
//we can do this easily by the following code

$('.live').keyup(function(){
	//for testing with console we can write the following code    (  /*console.log($(this).data('class'))*/   )
	$($(this).data('class')).text($(this).val());
});



$('select').selectBoxIt({
	autoWideth:false
});


});