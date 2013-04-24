$('document').ready(function(){
	
	$('#deals_desc[title]').cluetip({splitTitle: '|'});
	
	//control code of a slider
	$("#slider").easySlider({
		
		auto: false,
        continuous: false,
        prevId:'prevBtn',
        nextId:'nextBtn',
        count:count
	});	
	//show and hide the slider arrow used for navigation
	if($('#deal_slider_arrow').val()==0)
	{
		$('#nextBtn').hide();
	}	
	
	$('#cluetip').show();	
	$('#deal_no_of_rooms').live('change',function(){	
		var number = $(this).val();//alert(number);
		if(number==6)
		{
			//used to show a six plus booking form
			location.href = "javascript: jQuery.facebox({ajax:'"+__SITE__+"/six_plus_booking'})";
		}
		else
		{
			//used to show/hide drop down box of adult and children
			$('.column').each(function(i){
					if(i<number)
					{
					     $(this).show();
					}
					else
					{
					     $(this).hide();   
					}	
			});
		}
		
    });
	
	//used to show/hide drop down box of ages of children
	$('.deal_children').live('change',function(){
		var total = 0;
		var number = $(this).val();
		var id = $(this).parent('td').attr('id');
	    $('#'+id).next('td').children('select').each(function(i){
			if(i<number)
			{
			     $(this).show();
			}
			else
			{
			     $(this).hide();   
			}
		});
	    
	    //used to show/hide head line of the age
	    if($('select[name="child[]"]').is(':visible')==true)
		{
		    $('#deal_age_headline').show();
		    $('#deals_child_age_limit_msg').show();
		}
		else
		{
			$('#deal_age_headline').hide();	
			$('#deals_child_age_limit_msg').hide();	
		}
		
	});
	
	$('#form_deal_step1').live('submit',function(){
		
		//used to force the user to select the ages of each child as per the selection of the number of child
		
		var age_selected=1;
		$('.column .column_child select').not(':hidden').each(function(){
			 if($(this).val()=='?')
			 {			     
				 age_selected=0; 
			 }
	    });
		if(age_selected==0)
		{
			$('#errorPopup').html('Please select the ages of each child.');
			$('#errorPopup').show();
			setTimeout(function() { $('#errorPopup').slideUp(); }, 8000);
			return false;
		}
		
		//used to show an alert box when user select person more than the total occupancy of a particular room type		
		var totol_rooms=$('#deal_no_of_rooms').val();
		var max_no_of_person=$('#max_person').val();
		for(var i=1;i<=totol_rooms;i++)
		{
			var totol_member=0;
			totol_member=parseInt($('#adults_'+i).val()) + parseInt($('#children_'+i).val());
			if(totol_member > max_no_of_person)
			{
				//$('#errorPopup').html('Only '+max_no_of_person+' persons can accomodate in one room.');
				$('#errorPopup').html('Sorry, this room type can only accommodate '+max_no_of_person+' persons per room.');
				$('#errorPopup').show();
				setTimeout(function() { $('#errorPopup').slideUp(); }, 10000);
				return false;
			}
		}
		
		var deal_id=$('#deal_id').val();
		if(location.hostname == 'localhost')
        {
           var controller = location.pathname.split("/")[3];
           deal_url = location.protocol+'//'+location.hostname+'/'+local_user+'/restclient/'+controller+'/deals/'+deal_id;

        }
        else
        {
           var controller = location.pathname.split("/")[1];
           deal_url = __SITE__+'/deals/'+deal_id;
        }
        $.ajax({
               type:'POST',
               url: deal_url,
               data:{'details':$('#form_deal_step1').serialize()},
               //dataType: "text",
               success: function(response)
               {
            	   //alert(response);
            	   if(response=='false'||response=='not_available'||response=='no_vacancy')
            	   {
            		   $('#errorPopup').html('No vacancy for your selected date.Please try another set of dates to check availability.');
					   $('#errorPopup').show();
					   setTimeout(function() { $('#errorPopup').slideUp(); }, 8000);
            	   }
            	   else
            	   {
            		   /*$('#div_deal_step_1').slideUp("slow");	
            		   $('#div_deal_step_1').replaceWith(response);
            		   $('#div_deal_step_2').slideDown(1000);*/
            		   $('#div_deal_step_1').slideUp('slow',function(){
            			   $('#div_for_step2').replaceWith(response);
                		   $('#div_deal_step_2').slideDown('slow');
            		   });	
            		   
            	   }
              }
       });
	   return false;
	});
	
	$('#back_step1').live('click',function(){
		//alert('hello');
		$('#div_deal_step_2').slideUp('slow',function(){
		   $('#div_deal_step_2').replaceWith('<div class="Rsleft1 W515" id="div_for_step2" style="display:none;"></div>');
 		   $('#div_deal_step_1').slideDown('slow');
		});	
	});
	
	$('.SliderPDRight').addClass('deal_rightbtn');
	$('.SliderPD').addClass('deal_leftbtn');

});

