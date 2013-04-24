/*if(!location.hostname == 'localhost')
{
    //image_url = 'http://localhost/restclient/images/ywl/';
}
else
{
   image_url = __HOST__+'/images/'+stand_alone_name+'/';
}*/
if(!location.hostname == 'localhost'){
	 image_url = __HOST__+'/images/'+asset_name+'/';
}

$(document).ready(function(){
	//used to display account verification message when user is verified through the link
	if($('#verification_success').is(':visible')==true)
	{
		setTimeout(function() { $('#verification_success').slideUp(); }, 8000);
	}
	
	//used to block the facebox until user click on a close button
	$(document).bind('loading.facebox', function() {
        $(document).unbind('keydown.facebox');   
        $('#facebox_overlay').unbind('click');
	});
	
	$('#far').click(function(){
		$('#cent').css('text-decoration','none');
		$(this).css('text-decoration','underline');
		$('.far').removeClass('hide');
		$('.cent').addClass('hide');
	});
	
	$('#cent').click(function(){
		$('#far').css('text-decoration','none');
		$(this).css('text-decoration','underline');
		$('.cent').removeClass('hide');
		$('.far').addClass('hide');
	});
	
	$('#register_user').click(function(){
		window.setTimeout(registration_validation,'2000');
		
	});

	if($('#search_city').length > 0)
	{
		onload_fill();
	}

	$(".crossicon, .help_icon").click(function() {
          $("#hpCOM_ContactB").animate({width: 'toggle'}, 'fast');
    });

	$('form[name="get_header_avaibility"]').submit(function (ev){
		 $('.occupants .roomsPeople select').not(':hidden').each(function(){
			 if($(this).val()=='?')
			 {
			     alert('Please select the ages of each child.');
			     ev.preventDefault();
			     return false;
			 }
	      });
	});


if($('.for_share').length > 0){
               var domain = $('.for_share').val();
                var name = $('.for_share').attr('title');
                title = "Innsight - Browse Inn ";
                //var data = Array("google","google");
                //alert(typeof (SHARETHIS)); return;
                if(typeof (SHARETHIS) != 'undefined'){
                object = SHARETHIS.addEntry({
                        title:title,
                        URL:window.location,
                        icon:image_url+"logo1.png"},
                        {button:false});
                        var element = document.getElementById("share_link_0");
                        object.attachButton(element);
                }
    }

        $('.forgot_password').live('click',function(){
            $('#forgot_pass').css('display', 'block');
            $('#email_request').focus();
            $('#username').val('');
            $('#password').val('');
        });

    	$('#email_request').live('keypress', function(event){
            if(event.keyCode == 13)
            {
            	 var mail_id ='';
	   			 mail_id = $('#email_request').val();
	   			 if(mail_id=='')
	   			 {
	   				 $('#email_error').text('Please enter your Email Id.');
	   				 return false;
	   			 }
	   			 else
	   			 {
	   					var regEx = /^.{1,}@.{2,}\..{2,}/;
	   				    if(!regEx.test(mail_id))
	   				    {		    	
	   				    	$('#email_error').text('Invalid Email Id.');
	   				    	return false;
	   				    }		    	
	   			}
                event.preventDefault();
                if(location.hostname == 'localhost')
                {
                    var controller = location.pathname.split("/")[3];
                    reset_url = location.protocol+'//'+location.hostname+'/'+local_user+'/restclient/'+controller+'/reset_pass';
                }
                else
                {
                    var controller = location.pathname.split("/")[1];
                    reset_url = __SITE__+'/reset_pass';
                }
                
                $.ajax({
                    type:'POST',
                    url: reset_url,
                    data:'email='+mail_id,
                    success: function(response)
                    {
                		if(response == 1)
				    	{
				    		//alert("Mail sent successfully. Please check your mail for password reset");
				    		$('#email_error').html('Mail sent successfully. Please check your mail for password reset');
				    	}
				    	else
				    	{
				    		$('#email_error').html(response);
				    	}
                	}
                });
           }
     });

     $('.amenities').click(function(){
            if($('.amenities_block')[0].style.display == "none")
            {
                $('.amenities_block').fadeIn();
                $('#amenities_arrow').toggleClass('OpenArrow')
            }
            else
            {
                $('.amenities_block').fadeOut();
                $('#amenities_arrow').toggleClass('OpenArrow')
            }
        })

        $('.policies').click(function(){
            if($('.policies_block')[0].style.display == "none")
            {
                $('.policies_block').fadeIn();
                $('#policies_arrow').toggleClass('OpenArrow')
            }
            else
            {
                $('.policies_block').fadeOut();
                $('#policies_arrow').toggleClass('OpenArrow')
            }
        })

        /* Modified By:Sunny Patwa
     	 * used to authenticate the username and password at the time of login 
     	 * 
     	 */
        var verify_code='';//make it global bcoz we r using in next function to this one
        $('.sign_in').live('click' ,function(){
            $('#login_error').html('');
            var param = 'username='+$('#username').val()+'&password='+$('#password').val();
            if(location.hostname == 'localhost')
            {
                login_url = __SITE__+'/authenticate_login' ;
            }
            else
            {
                var controller = location.pathname.split("/")[1];
                login_url = __SITE__+'/authenticate_login';
            }
            ///// alert(login_url);
            $.ajax({
                    type:'POST',
                    url: login_url,
                    data:param,
                    dataType: "json",
                    success: function(response)
                    {	//alert(response);
	                    $.each(response,function(i,item){ 
	                        if(i == 'success')
	                        {
	                        	$(document).trigger('close.facebox')
	                            location.reload();
	                        }
	                        else
	                        {
	                        	//alert(i+"="+item);
	                        	if(i == 'email'|| i == 'code' || i == 'firstname' || i == 'lastname')
	                        	{
	                        		if(i == 'code')
	                        		{
	                        			verify_code=item;
	                        			$('#login_inactive_error').show();
	                        		}
	                        		else
	                        		{
	                        			$('#'+i).val(item);//used to set the value in the hidden field for email, firstname and lastname.
	                        		}
	                        	}
	                        	else
	                        	{
	                        		$('#login_error').html('Invalid Login ');
	                        	}
	                        }
	                    });
                    }
            });
        });
     	
     	/*Author:Sunny Patwa
     	 * If user is already registered with INNsight but not veified .
     	 * So this code is used to display the verification box and mail the code to USER when he/she clicks on resend verification code.
     	 * 
     	 */
     	$('#send_verification_code').live('click',function(){
     		//alert(verify_code);
     		var user_email		=	$('#email').val();
     		var user_firstname	=	$('#firstname').val();
     		var user_lastname	=	$('#lastname').val();
     		
     		if(verify_code !='' && user_email != '')
     		{
     			$.ajax({    
			        type	:'POST',
			        url		: __SITE__+'/resend_verification_code',
			        data	: {email:user_email,code:verify_code,firstname:user_firstname,lastname:user_lastname},
			        success	: function(response)
			        {	
			        	if(response=='success')
			        	{
			        		$("#sign_in_div").slideUp('slow',function(){
			        			if(!$.browser.mozilla)
			        			{
			        				$(".wa0").css('width', '882px' );//used to solve google chrome issue
			        			}			        			
			        			$('#facebox_close').hide();	//hide the close button of facebox.
			        			$('#verify_form').slideDown('slow');	
			        		});
			        	}
			        	else
			        	{
			        		alert('Some error occured during sending Email.Please try again later.');
			        	}
			        }
			    });
     		}
     		else
     		{
     			alert('Some error occured from our side.Please try again later.');
     		}
     	})
        
        $('.register_passport').live('click' ,function(){
             //$('#login_error').html('');
            var param = 'username='+$('#username').val()+'&password='+$('#password').val();
            
        	 if($('#traveller_register').valid())
        	 {
        	
		             if(location.hostname == 'localhost')
		             {
		                var controller = location.pathname.split("/")[3];
		                registration_url = location.protocol+'//'+location.hostname+'/'+local_user+'/restclient/'+controller+'/register_user';

		             }
		             else
		             {
		                var controller = location.pathname.split("/")[1];
		                registration_url = __SITE__+'/register_user';
		             }
		            
		             $.ajax({
		                    type:'POST',
		                    url: registration_url,
		                    data:{'details':$('#traveller_register').serialize()},
		                    dataType: "json",
		                    success: function(response)
		                    {
		                    	$.each(response,function(i,item){ 
			                        if(i == 'success')
			                        {
			                            $('#register_form').hide();
			                            $('#verify_form').show();
			                            $('#facebox_close').hide();//hide close button
			                            $('html,body').animate({scrollTop: 0}, 2000);
			                        }
			                        else
			                        {
			                        	$('#error_main').show();
			                            $('#form_errors').html(item);
			                            $('html,body').animate({scrollTop: 0}, 2000);
			                        }
		                        });
		                    }
		             });
        	   }      
        });
        
        $('#verify').live('click' ,function(){
            		 var user_reg_email	=	$('#email').val();
		             if(location.hostname == 'localhost')
		             {
		                var controller = location.pathname.split("/")[3];
		                verification_url = location.protocol+'//'+location.hostname+'/'+local_user+'/restclient/'+controller+'/verify_user';
		             }
		             else
		             {
		                var controller = location.pathname.split("/")[1];
		                verification_url = __SITE__+'/verify_user';
		             }
		             //this is email id of the registertrating user
		         
		             if($('#verification_code').val()!=''){
			             $.ajax({
			                    type:'POST',
			                    url: verification_url,
			                    data:{'verification_code':$('#verification_code').val(),'user_email':user_reg_email},
			                    dataType: "json",
			                    success: function(response){
			                    	$.each(response,function(i,item){
			                        if(i == 'success')
			                        {
			                            location.reload();
			                        }
			                        else
			                        {
			                        	if($('#verification_code').next().html() != null)
			                        	{
			    		            		$('#verification_code').next().replaceWith('<label class="errors">Verification Code Does Not Match'+i+'</label>');
			    		            	}
			                        	else
			                        	{
			    		            		$('#verification_code').after('<label class="errors">Verification Code Does Not Match'+i+'</label>');
			    		            	}
			                        }
			                    });
			                 }
			            }); 
		            }else{
		            	if($('#verification_code').next().html() != null){
		            		$('#verification_code').next().replaceWith('<label class="errors">Enter verification Code</label>');
		            	}else{
		            		$('#verification_code').after('<label class="errors">Enter verification Code</label>');
		            	}
		            }
       });
        
        $('#signin_register').live('click',function(){ 
        	//$('#register_user').trigger('click');
        });
	
	$("a.custom_tooltip").hover(function(e){
        this.t = this.title;
        this.title = "";
        //$("body").append("<p id='tooltip'>"+ $('#new_title').show() +"</p>");
        $('#new_title').show()
		},
		function(){
		        this.title = this.t;
		        $('#new_title').hide()
		       // $("#tooltip").remove();
		});
		$('a.custom_tooltip').mousemove(function(e){ 
			var percent_x_position = (parseInt(e.pageX) / parseInt($(window).width()))*parseInt('100');
			$('#new_title')
		                .css("top",(e.pageY) + "px")
		                .css("left",(percent_x_position) + "%");
		});
	

	//DatePicker
 /*$('#check_in_date').datepicker({
		minDate: 0           
    });
	
	$('#check_out_date').datepicker({
		minDate: 1,
		beforeShow: customRange_header         
    	}); 
	*/
	$.datepicker.setDefaults({
		showAnim:'fadeIn',
		showOn: 'both',
		buttonImageOnly: true ,
		buttonImage: image_url+"/cal_icon.png",
		buttonText: '',
		changeMonth: true ,
		changeYear: true ,
		dateFormat: 'm/dd/yy' 
	});
	
	$("#check_in_date").change(function(){
	 	var d1= $('#check_in_date').val();
	 	var d2= $('#check_out_date').val();
	 	var date1 = new Date(d1);
	 	var datecmp1 = date1.getTime();
	 	var date2 = new Date(d2);
	 	var datecmp2 = date2.getTime();
		if(datecmp1>=datecmp2){
			var date = new Date(d1);
			var d = date.getDate();
			var m = date.getMonth();
			var y = date.getFullYear();
			var NextDate= new Date(y, m, d+1);
                        var p = NextDate.getDate();
                        p = (p > 9)?p:('0'+p);
			var Ndate = NextDate.getMonth()+1+"/"+p+"/"+NextDate.getFullYear();
			$('#check_out_date').val(Ndate);
	 	}
 	});	
	
	$('#close_box').click(function(){
		//$('.roomDetailsExpand').hide();
                $('.Stay_roomDetailsExpand').hide();
		$('.roomDetailsExpand').toggle();
		$('#room_preferences').toggleClass('closed');
                $('.right_ARROW').toggleClass('down_arrow');
	});
	
	$('#room_preferences').click(function(){
		$('.Stay_roomDetailsExpand').hide();
		$('.roomDetailsExpand').toggle();
		$(this).toggleClass('closed');
                $('.right_ARROW').toggleClass('down_arrow');

	});
	
	$('#main_slide').click(function(){
		if($('.searchResult_box').is(':hidden')){
		 $('.searchResult_box').toggle();
		 $(this).addClass('TopMinuse');
		 $(this).removeClass('TopPlus');
		}else{
	     $('.searchResult_box').toggle();
	     $(this).removeClass('TopMinuse');
		 $(this).addClass('TopPlus');  
		}
	});
	/*$('#no_of_rooms').change(function(){
		var number = $(this).val();
		$(this).parent('.roomsNumberOfRooms').next().find('.rows').each(function(i){
			if(i<number){
			     $(this).show();
			   }
			   else{
			     $(this).hide();   
			 }	
		});
		$('#rooms_count').html(number);
		count_change();
    });*/
	
	$('.children').change(function(){
		var total = 0;
		var number = $(this).val();
		var id = $(this).parent('td').attr('id');
	   $('#'+id).next('td').children('select').each(function(i){
		if(i<number){
		     $(this).show();
		   }
		   else{
		     $(this).hide();   
		 }
		
	   });
		if($('select[name="child[]"]').is(':visible')==true){
			//alert('hi');
		    $('#age_headline').show();
		    $('#child_age_limit_message').show();
		    $('#div_child_age_limit').css("height", "35px");
		    
		}
		else{
			$('#age_headline').hide();
			$('#child_age_limit_message').hide();
			$('#div_child_age_limit').css("height", "20px");
		}
		$('.roomAdults').children('.children:visible').each(function(i){
			total = parseInt(total) + parseInt($(this).val());
		});
		$('#children_count').html(total);
	});
	
	$('.adults').change(function(){ 
		count_change();
	});
	
	$('form[name="property_search"]').submit(function (ev){
		var field_val = $("#search_city").val();
		if(field_val == 'Enter a city, landmark, or airport' || field_val == ''){
			//$('#search_city').after('<div class="error">Please enter city, landmark or airport</div>');
			alert('Please enter city, landmark or airport');
			ev.preventDefault();
	    }
		
		 var no_of_rooms = document.property_search.no_of_rooms.value;
		 for(var i = no_of_rooms; i < 5; i++){
		 $(".adults")[i].name='';
		 }
		 for(var i = no_of_rooms; i < 5; i++){
			 $(".children")[i].name='';
		 }
		 
	});
	
	$('img.ui-datepicker-trigger').removeClass('ui-datepicker-trigger');

        $('#show_hide_header').click(function()
        {
            if($('#get_header_avaibility').is(':hidden'))
            {
                $('#get_header_avaibility').toggle();
                $(this).addClass('TopMinuse');
                $(this).removeClass('TopPlus');
            }else{
                $('#get_header_avaibility').toggle();
                $(this).removeClass('TopMinuse');
                $(this).addClass('TopPlus');
            }
        });


          /*var name = $('.for_share').attr('title');
        title = "Innsight - Attraction -"+name;
        object = SHARETHIS.addEntry({
                title:title,
                URL:window.location,
                icon:image_url+"logo.gif"},
                {button:false}
        );
        var element = document.getElementById("share_link_0");
        object.attachButton(element);*/
});

  function count_change()
  {
	   var total_adult=0;
	   var total_children=0;
	   var number = $('#no_of_rooms').val();//alert(number);
	   if(number==1)//as by jquery the number of room is set 1 after six plus pop up
	   {
			total_adult=2;
	   }
	   else
	   {
		   $('.roomAdults').children('.adults:visible').each(function(i){		
				total_adult = parseInt(total_adult) + parseInt($(this).val());						
		   });
	   }
	   $('#adult_count').html(total_adult);
       if(parseInt(total_adult) > 1)
       {
            $('#adult_lable').html('ADULTS');
       }
       else
       {
            $('#adult_lable').html('ADULT');
       }

		$('.roomAdults').children('.children:visible').each(function(i){
			total_children = parseInt(total_children) + parseInt($(this).val());
		});
		$('#children_count').html(total_children);	  
  }

  function customRange_header(input)
  {
		var one_day = 1000*60*60*24;
		return {minDate: ((input.id == "check_out_date" && $("#check_in_date").datepicker("getDate") == null)? 0 : Math.ceil(($("#check_in_date").datepicker("getDate") - new Date())/(one_day))+1)} ;
		/*return { minDate: ((input.id == "departure_date" && $("#arrival_date").datepicker("getDate") == null)? 0 : $("#arrival_date").datepicker("getDate"))};*/
  }
   
   function onload_fill()
   {
   	//Input autocomplete
	   var search_value = $('#search_city').val();
      		$('#search_city').focus(function () 
      		{   			
      			if ($('#search_city').val() != ''){
      				$('#search_city').val(''); 
      			}else return;
      		});
      		
      		$('#search_city').blur(function (){ 
      	      		if ($('#search_city').val() == ''){
      	      				$('#search_city').val(search_value); 
      	      	    }else return;
      	    });
      		
      		
      		
      		options = {serviceUrl	: site_url+"Search/autocomplete/",
		   	   		 params		: {country:'Yes'},
		   	   		 minChars	: 3,
		   	   		 noCache	: false,
		   	   		 onSelect	: function(value, type, type_value){
		   	   			 $('#search_type').val(type);
		   	   		     $('#search_value').val(type_value);
		   	   		 }


      	   	         };
  	    ac = $('#search_city').autocomplete(options);

   }
   
   $(window).load(function(){
	   $('#no_of_rooms').change(function(){
			var number = $(this).val();
			if(number==6)
			{	
				$(this).parent('.roomsNumberOfRooms').next().find('.rows').each(function(i){
					if(i<1){
					     $(this).show();
					   }
					   else{
					     $(this).hide();   
					 }	
				});
				$('.roomDetailsExpand').toggle();
				$('#room_preferences').toggleClass('closed');
		        $('.right_ARROW').toggleClass('down_arrow');
		        $("#no_of_rooms").val("1");
		        $('#rooms_count').html('1');
		       
				//location.href = __SITE__+'/six_plus_booking';
				location.href = "javascript: jQuery.facebox({ajax:'"+__SITE__+"/six_plus_booking'})";
				
			}
			else
			{
				$(this).parent('.roomsNumberOfRooms').next().find('.rows').each(function(i){
					if(i<number){
					     $(this).show();
					   }
					   else{
					     $(this).hide();   
					 }	
				});
				$('#rooms_count').html(number);
			}			
						
            if(parseInt(number) > 1)
            {
                $('#room_lable').html('ROOMS');
            }
            else
            {
                $('#room_lable').html('ROOM');
            }
			count_change();
	    });  
   });
   
   function registration_validation(){
	   
	   $('#traveller_register').validate({
			errorElement: "label",
			errorClass: "errors",
			success: function(label) {
			     label.addClass("sucess").text("OK");
			},

		rules: {
			firstname: 	{ required: true,	minlength: 2, maxlength: 35,	chars: true },
			lastname:  	{ required: true,	minlength: 2, maxlength: 35,	lastname: true },
			city:       { required: true },
			state:      { required: true },
			zip_code:   { required: true, 	minlength: 3	},//digits: true 
			country: "required",
			username: {	required: true,username: true, minlength: 4, maxlength: 15
			},		
			email: { required: true, my_email: true, maxlength: 100 },
			re_email: {	required: true,	my_email: true,	maxlength: 100, equalTo: "#email" },
			secret_question_id : { required: true },
			secret_answer: {required: true,maxlength: 100},							
			password: {	required: true,	minlength: 6,	maxlength: 20	},
			confirm_password: {	required: true,	minlength: 6,	equalTo: "#password"}
//			recaptcha_response_field: "required",
		},
	messages: {
		firstname: {
			required: " Please enter your first name",
			maxlength: " Firstname must be up to 35 characters",
			chars: " Only characters are allowed in firstname",
			minlength: " Firstname must be of min 2 characters"
		},
	    lastname: {
			required: " Please enter your last name",
			maxlength: " Lastname must be up to 35 characters",
			lastname: " Only characters and ' allowed in lastname",
			minlength: " Lastname must be of min 2 characters"
				
		},
	    city: {
			required: " Please Select/Enter your City"
			},
		state:  {
			required: " Please Select/Enter your State"
			},
		country: " Please select your Country",
		username: {
			required: " Please enter a username",
			username: " Please enter a valid username",
			remote: " Username already taken",
			minlength: " Username must be at least 4 characters",
			maxlength: " Username must be up to 15 characters"
		},
		email:  {
			required: " Please enter your email address",
			remote: " Email already taken",
			maxlength: "Email must be up to 100 characters",
			my_email: " Please enter a valid email address"
		},
		re_email: {
			required: " Please Re-enter your email address",
			my_email: " Please enter valid email address",
			maxlength: "Re-enter email must be up to 100 characters",
			equalTo: " Sorry, your mail id's do not match"
		},
		password: {
			required: " Please provide a password",
			minlength: " Password must be at least 6 characters",
			maxlength: " Password must be up to 20 characters"
		},
		confirm_password: {
			required: " Please provide a password",
			minlength: " Password must be at least 6 characters",
			equalTo: " Sorry, your passwords do not match"
		},
		zip_code: {
			required: " Please enter your Zip Code",
			digits: " Please enter only digits",
			minlength: " Zipcode must be of min 3 digits"
		},secret_answer: {
			required: " Please enter your secret answer",
			maxlength: " Answer must up to 100 characters"
		},
		secret_question_id: {
			required: " Please select security question"
		}
//		recaptcha_response_field:  " Please enter a code",
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
	$("#city").live('focusout', function()  {
		$("#city").valid();
		$("#city").css({'border-radius':'4px 0 0 4px','-moz-border-radius':'4px 0 0 4px','-webkit-border-radius':'4px 0 0 4px','-khtml-border-radius':'4px 0 0 4px'});

	});
	$("#state").live('focusout', function() {
		$("#state").valid();
		$("#state").css({'border-radius':'4px 0 0 4px','-moz-border-radius':'4px 0 0 4px','-webkit-border-radius':'4px 0 0 4px','-khtml-border-radius':'4px 0 0 4px'});

	});
	$("#country").live('focusout', function() {
		$("#country").valid();
		$("#country").css({'border-radius':'4px 0 0 4px','-moz-border-radius':'4px 0 0 4px','-webkit-border-radius':'4px 0 0 4px','-khtml-border-radius':'4px 0 0 4px'});

	});
	$("#username").live('focusout', function() {
		$("#username").valid();
		$("#username").css({'border-radius':'4px 0 0 4px','-moz-border-radius':'4px 0 0 4px','-webkit-border-radius':'4px 0 0 4px','-khtml-border-radius':'4px 0 0 4px'});

	});
	$("#email").live('focusout', function() {
		$("#email").valid();
		$("#email").css({'border-radius':'4px 0 0 4px','-moz-border-radius':'4px 0 0 4px','-webkit-border-radius':'4px 0 0 4px','-khtml-border-radius':'4px 0 0 4px'});

	});
	$("#re_email").live('focusout', function() {
		$("#re_email").valid();
		$("#re_email").css({'border-radius':'4px 0 0 4px','-moz-border-radius':'4px 0 0 4px','-webkit-border-radius':'4px 0 0 4px','-khtml-border-radius':'4px 0 0 4px'});

	});
	$("#password").live('focusout', function() {
		$("#password").valid();
		$("#password").css({'border-radius':'4px 0 0 4px','-moz-border-radius':'4px 0 0 4px','-webkit-border-radius':'4px 0 0 4px','-khtml-border-radius':'4px 0 0 4px'});

	});
	$("#confirm_password").live('focusout', function() {
		$("#confirm_password").valid();
		$("#confirm_password").css({'border-radius':'4px 0 0 4px','-moz-border-radius':'4px 0 0 4px','-webkit-border-radius':'4px 0 0 4px','-khtml-border-radius':'4px 0 0 4px'});

	});
	$("#secret_answer").live('focusout', function() {
		$("#secret_answer").valid();
		$("#secret_answer").css({'border-radius':'4px 0 0 4px','-moz-border-radius':'4px 0 0 4px','-webkit-border-radius':'4px 0 0 4px','-khtml-border-radius':'4px 0 0 4px'});

	});
	$("#zip_code").live('focusout', function() {
		$("#zip_code").valid();
		$("#zip_code").css({'border-radius':'4px 0 0 4px','-moz-border-radius':'4px 0 0 4px','-webkit-border-radius':'4px 0 0 4px','-khtml-border-radius':'4px 0 0 4px'});

	});
	   
   }
   
   function bookmark(title){
		var url = window.location;
		if(window.sidebar) 
	          window.sidebar.addPanel(title,url,"");
		else if(window.opera && window.print){
	          var elem = document.createElement('a');
	          elem.setAttribute('href',url);
	          elem.setAttribute('title',title);
	          elem.setAttribute('rel','sidebar');
	          elem.click();
		}
		else if(window.external)
	          window.external.AddFavorite(url,title);
	}
   
   
 // Ajax calls for State and city drop down 
   $("#country").live('change',function(){
			//Get states
	   $('#state_loader').show();
	   $('#city').replaceWith('<input type="text" name="city" id="city" class="Account_Name" style="">');
		$.post(__HOST__+"common/get_states/", {
	        'country': $('#country').val()
	    },function(j){ 
	        if(j==false){
	        	$('#state').replaceWith('<input type="text" name="state" id="state" class="Account_Name" style="">');
	        	$('#state_loader').hide();
	        }else{
	        	var options = '<option value="">Select State</option>';
	        	for (var i = 0; i < j.length; i++) {            	
	                options += '<option value="' + j[i].state + '"';                
	                if($('#state').val()== j[i].state){                
	                    options += 'selected=selected';
	                }
	                options += '>' + j[i].state + '</option>';
	            }
	        	html = '<select class="Account_Name" style="width: 251px; height:30px !important;" id="state" name="state">'+
	        			options+'</select>';
	        	$('#state').replaceWith(html);
	        	$('#state_loader').hide();
	        }
	    },"json");
		
   });
   
   $("#state").live('change',function(){
			//Get states
	   $('#city_loader').show();
		$.post(__HOST__+"common/get_cities/", {
	        'state': $('#state').val()
	    },function(j){ 
	        if(j==false){
	        	$('#city').replaceWith('<input type="text" name="city" id="city" class="Account_Name" style="">');
	        	$('#city_loader').hide();
	        }else{
	        	var options = '<option value="">Select City</option>';
	        	for (var i = 0; i < j.length; i++) {            	
	                options += '<option value="' + j[i] + '"';                
	                if($('#city').val()== j[i].state){                
	                    options += 'selected=selected';
	                }
	                options += '>' + j[i] + '</option>';
	            }
	        	html = '<select class="Account_Name" style="width: 251px; height:30px !important;" id="city" name="city">'+
	        			options+'</select>';
	        	$('#city').replaceWith(html);
	        	$('#city_loader').hide();
	        }
	    },"json");
		
   });
   
