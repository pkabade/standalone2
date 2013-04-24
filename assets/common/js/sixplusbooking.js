 $(document).ready(function(){
	 	$('#request').click(function(e){
			 if(!$('#is_agree').is(':checked'))
			 {
				 alert('Please agree to the terms and conditions ');
				 return false;
			 }
		 }); 
		$('#form_sixplusbooking').validate({
			errorElement: "label",
			errorClass: "errors",
			success: function(label) {
			     label.addClass("sucess").text("OK");
			},

			rules: {
				firstname: 	{ required: true,	minlength: 2, maxlength: 35 },
				lastname:  	{ required: true,	minlength: 2, maxlength: 35 },
				phone:  	{ required: true},
				email:      { required: true, my_email: true, maxlength: 100 }
				
			},
		    messages: {
				firstname: {
					required: " Please enter your first name",
					maxlength: " Firstname must be up to 35 characters",
					minlength: " Firstname must be of min 2 characters"
				},
				lastname: {
					required: " Please enter your last name",
					maxlength: " Lastname must be up to 35 characters",
					minlength: " Lastname must be of min 2 characters"
				},
				phone: {
					required: " Please enter your phone number"				
				},
				email:  {
					required: " Please enter your email address",
					maxlength: "Email must be up to 100 characters",
					my_email: " Please enter a valid email address"
				}
			},
			submitHandler:function(form){
				var contact_preference="";				
							
				$('input:radio:checked').each(function(i) {
					contact_preference=this.value;
	            });
				var firstname=$('#firstname').val();
				var lastname=$('#lastname').val();
				var phone=$('#phone').val();
				var email=$('#email').val();
				var checkin=$('#room_check_in1').val();
				var checkout=$('#room_check_out1').val();
				var trip_type=$('#trip_type').val();
				var no_rooms=$('#dd_no_rooms').val();			
				
				
				$.ajax({    
			        type	:'POST',
			        url		: __SITE__+'/six_plus_booking',
			        data	: {firstname:firstname,lastname:lastname,contact_preference:contact_preference,phone:phone,email:email,checkin:checkin,checkout:checkout,trip_type:trip_type,no_rooms:no_rooms},
			        success	: function(response)
			        {
			        	if(response=='success')
			        	{
				        	$('#six_content').slideUp("slow");	        	
							$('#success_msg').html('Thank you for filling in the details. We will get back to you soon . ');
							$('#success_msg').show();
							$('html,body').animate({scrollTop: 0}, 2000);
			        	}
			        	else
			        	{
			        		alert('We are sorry, Due to some Technical error. Please try it again after some time.');
			        	}
			        }
			    });
				return false;
			}
	  });
		
	$("#firstname").live('focusout', function() {
			$("#firstname").valid();
			$("#firstname").css({'border-radius':'4px 0 0 4px','-moz-border-radius':'4px 0 0 4px','-webkit-border-radius':'4px 0 0 4px','-khtml-border-radius':'4px 0 0 4px'});
	});
	$("#lastname").live('focusout', function() {
		$("#lastname").valid();
		$("#lastname").css({'border-radius':'4px 0 0 4px','-moz-border-radius':'4px 0 0 4px','-webkit-border-radius':'4px 0 0 4px','-khtml-border-radius':'4px 0 0 4px'});

	});
	$("#phone").live('focusout', function() {
		$("#phone").valid();
		$("#phone").css({'border-radius':'4px 0 0 4px','-moz-border-radius':'4px 0 0 4px','-webkit-border-radius':'4px 0 0 4px','-khtml-border-radius':'4px 0 0 4px'});

	});
	$("#email").live('focusout', function() {
		$("#email").valid();
		$("#email").css({'border-radius':'4px 0 0 4px','-moz-border-radius':'4px 0 0 4px','-webkit-border-radius':'4px 0 0 4px','-khtml-border-radius':'4px 0 0 4px'});

	});	
	
		
 });
 
