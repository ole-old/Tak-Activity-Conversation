$(document).ready(function() {

	$('.tak_iniciarsesion').click(function() {
	    $(".tak_lightbox").lightbox_me({
		   centered: true}
		);
	 });
	 $('input[placeholder]').each(function(){ 
		var input = $(this);       
		$(input).val(input.attr('placeholder'));
		$(input).focus(function(){
			 if (input.val() == input.attr('placeholder')) {
				 input.val('');
			 }
		});
		$(input).blur(function(){
			if (input.val() == '' || input.val() == input.attr('placeholder')) {
				input.val(input.attr('placeholder'));
			}
		});
	});
	
	
	$('#slider').nivoSlider({ pauseTime: 6000, });
	
	/* Form validation */
	$("form.validate").submit(function(){
		var error = false;
		
		$(".required").removeClass('error');
		
		$("input.required, select.required, textarea.required, input.required_checkbox, input.required_checkboxred").each(function(){
			if($.trim($(this).val())==""){
				$(this).focus().addClass("error");
				error = true;
				return false;
			}
			if($(this).hasClass("email") && $.trim($(this).val())!="" && !$(this).val().isEmail()){
				$('#change_red_4').addClass('red');
				$('.change_red_4').removeClass('hide');
				$(this).focus().addClass("error");
				error = true;
				return false;				
			}			
		});
		
		if(error) {
			$("p.warning-text").fadeIn();
		}
		
		return !error;		
		
	});
	$('a.pp_close').click( function () {
 		e.preventDeafult();
		alert("si llega");    		
	});
});

function logo_load(){
	$('.tak_logo').prepend('<a href="inicio"><img src="assets/images/frontend/logo_animacion.gif" /></a>')
	$("#logo_snd")[0].play();
}

String.prototype.isEmail = function(){
	return (this.valueOf().search(/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/) != -1);
}





