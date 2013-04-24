$('document').ready(function(){ 
	
	$('#lowest_price[title]').cluetip({splitTitle: '|'});
	//$('#my_account_check').cluetip({ cursor: 'pointer',sticky:'true',splitTitle:'|',closePosition:'title'});
	$('a.person_cluetip').cluetip({ cursor: 'pointer',sticky:'true',closePosition:'title',titleAttribute:'title'});	
		
	
/*	//set the onclick form submit on the anchor of the cancel reservatation 
	$('#cancel_reservation_link').Click(function(){
		$("form:[name='cancel_reservation']").submit();
	});*/
		

	
	//set image caption 
	//document.getElementById('photo_caption').innerHTML	= $('#p_0').attr('title');
	//START:30sep2011:Author-Sunny:used to implement ASK A QUESTION.
	
	var from="";
	var subject="";
	var message="";     

	$('#frm_msg_box').live('submit',function(){	
		
		from=$('#from_name').val();
		subject=$('#subject').val();
		message=$('#message').val();		
		if(from=='')
		{
			$('#error_1').html('Enter your email');			
			return false;
		}
		else
		{
			var regEx = /^.{1,}@.{2,}\..{2,}/;
		    if(!regEx.test(from))
		    {		    	
		    	$('#error_1').html('Invalid email');
		    	return false;
		    }		    	
		}
		if(subject=='')
		{
			$('#error_1').hide();
			$('#error_2').html('Enter subject');			
			return false;
		}
		if(message=='')
		{
			$('#error_1').hide();
			$('#error_2').hide();
			$('#error_3').html('Enter message');			
			return false;
		}	
		
		$.ajax({    
	        type	:'POST',
	        url		: __SITE__+'/askquestion',
	        data	: {message_from:from,message_subject:subject,msg:message},
	        success	: function(response)
	        {
	        	if(response=='success')
	        	{
	        		$('#mail_box').slideUp("slow");
					$('#mail_success').show();
					$('#mail_success').html('Your message has been sent successfully! We will contact you shortly. ');
	        	}
	        	else
	        	{
	        		alert('We are sorry, Due to some Technical error. Please try it again after some time.');
	        	}
	        }
	    });		
		return false;		
	});
	//END:30sep2011:Author-Sunny:used to implement ASK A QUESTION.
	$('.availability a.arrow').click(function(){
		 $('.availability_box').slideToggle('slow');
	});
	$('.availability_box a.close').click(function(){
		$('.availability_box').slideUp('slow');
	});
	
	
});

function handle_pagination(offset, action)
{
    var len = $('.review_class').length;

    if($.trim(action) != 'prev' && $.trim(action) != 'next')
    {
        alert('Unknown Action');
        return false;
    }

    if(offset > len)
    {
        alert('Unknown Offset');
        return false;
    }

    for(var i=0; i<len; i++)
    {
        if(i == offset)
        {
            $('.review_class')[i].style.display ='block';
        }
        else
        {
            $('.review_class')[i].style.display ='none';
        }
    }
}

function handle_image_slider(offset)
{
	
	//This sinnept is added to show caption on below image in the accomodation page By Mohan On Date Oct 1 2011
	offset=offset+1;
	var title	=	$('#p_'+offset).attr('title').length!= 0 ? $('#p_'+offset).attr('title') : '';
	document.getElementById('photo_caption').innerHTML	=	title; 
	delete(title);//end
	
    var len = $('.slider_medium_class').length;

    for(var i=0; i<len; i++)
    {
        if(i == offset-1)
        {
            $('.slider_medium_class')[i].style.display ='block';
        }
        else
        {
            $('.slider_medium_class')[i].style.display ='none';
        }
    }
}