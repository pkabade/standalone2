$(document).ready(function(){
	/*$('.suiteDetailColumn').click(function(){
		$('.ui-datepicker').css('z-index','10000');
		$('.suiteDetailCo
		lumn').expose({api: true}).load(); 
	});*/
	if($('#vacancy_flag').val() == '1'){
		$('#shw_1 input').attr('value','Close').css('color','green');$('#show_hide').slideToggle();//to show calender box open when vacancy msg shown.
	}

        $('.update_btn').submit(function(){
            var no_of_rooms = parseInt($('#rooms_count_ppp').html());
            for(var i = no_of_rooms; i < 5; i++){
                $(".adults_ppp")[i].name='';
            }
            for(var i = no_of_rooms; i < 5; i++){
                $(".children_ppp")[i].name='';
            }

            var age = new Array();
            $.each($('select[name=child[]]'), function(key, value) {
              if(value.value != '?'){age.push(value.value);}
            });
            var child_ages = age.join(',');

           // var param = 'check_in='+$('#room_check_in').val()+'&check_out='+$('#room_check_out').val()+'&no_of_rooms='+$('#rooms_count_ppp').html()+'&no_of_adults='+$('#adult_count_ppp').html()+'&no_of_childs='+$('#children_count_ppp').html()+'&child_ages='+child_ages;
            var controller = location.pathname.split("/")[2];
//            $.ajax({
//                    type:'POST',
//                    url: location.protocol+'//'+location.hostname+'/restclient/'+controller+'/get_available_room_types',
//                    data:$("#get_avaibility").serialize()+'&child_ages='+child_ages,
//                    success: function(){
//                   
//                    }
//		});
        })


        $('.search_btn').submit(function(){
            var no_of_rooms = parseInt($('#rooms_count').html());
            for(var i = no_of_rooms; i < 5; i++){
                $(".adults_ppp_header")[i].name='';
            }
            for(var i = no_of_rooms; i < 5; i++){
                $(".children_ppp_header")[i].name='';
            }

            var age = new Array();
            $.each($('select[name=child[]]'), function(key, value) {
              if(value.value != '?'){age.push(value.value);}
            });
            var child_ages = age.join(',');

           // var param = 'check_in='+$('#room_check_in').val()+'&check_out='+$('#room_check_out').val()+'&no_of_rooms='+$('#rooms_count_ppp').html()+'&no_of_adults='+$('#adult_count_ppp').html()+'&no_of_childs='+$('#children_count_ppp').html()+'&child_ages='+child_ages;
            var controller = location.pathname.split("/")[2];
//            $.ajax({
//                    type:'POST',
//                    url: location.protocol+'//'+location.hostname+'/restclient/'+controller+'/get_available_room_types',
//                    data:$("#get_avaibility").serialize()+'&child_ages='+child_ages,
//                    success: function(){
//
//                    }
//		});
        });

        $(".AVGRate").tooltip({
    bodyHandler: function() {
        return $('#avg_rate_html').html();
    }
        
        /*$('.AVGRate').hover(function(){ console.log('inside');
        	$('#avg_rate_popup').show();
        },
        function(){ console.log('outside');
        	$('#avg_rate_popup').hide();
        });*/

});

        $('.attraction_cat, .sort_name, .sort_distance').click(function(){
            var cats = new Array();
            var orderBy = '';
            $('input:checkbox[checked]').each(function(){
                cats.push(this.value)
            })
            if($(this).attr('class') == 'sort_name'){orderBy='name'}
            if($(this).attr('class') == 'sort_distance'){orderBy='distance'}
            var param = 'attraction_cats='+cats.join(',')+'&order_by='+orderBy;  console.log(param);
            var controller = location.pathname.split("/")[2];
            $.ajax({
                    type:'POST',
                    url: __SITE__+'/get_filtered_attraction_cats',
                    data:param,
                    success: function(response){
                        $('#filtered_categories').html(response);
                    }
		});
        })

	
	$('#top_mns').remove();
	$('#sharethis_0').remove();
	
	$('.arrow').click(function(){
		$(this).parent().nextAll().slideToggle();
		$(this).toggleClass('DetailsArrow_up');
	});
	
	$('#arrival_date').click(function(){
	$('.ui-widget-header').css('background','#292E80 url(../images/125c9ccc_500x100_textures_12_gloss_wave_55.png) repeat-x scroll 50% 50%');
	});
	
	$('#departure_date').click(function(){
		$('.ui-widget-header').css('background','#292E80 url(../images/125c9ccc_500x100_textures_12_gloss_wave_55.png) repeat-x scroll 50% 50%');
	});
	
	$('.ui-datepicker-trigger').click(function(){
		$('.ui-widget-header').css('background','#292E80 url(../images/125c9ccc_500x100_textures_12_gloss_wave_55.png) repeat-x scroll 50% 50%');
		});
	
	$('#no_rooms').mouseover(function(){
		$('html, body').animate({
			scrollTop: $('#updte').offset().top
			}, 2000);
		$('.UpdateOuterBox').slideDown('1000');
		$('.change').addClass('closing');
		$('.close').removeClass('change');
		});
	
	$('#shw_1').click(function(){
		var display = $('#show_hide').css('display');
		if(display == "block"){
			$('#shw_1 input').attr('value','Change').css('color','green');
		}else{
			$('#shw_1 input').attr('value','Close').css('color','#CF3F3F');			
		}
		$('#show_hide').slideToggle();
		});
	/*$('#room_sel').click(function(){
		//$('.UpdateOuterBox').css('height','auto');
	});*/
	
	
	/* js for update expand/collapse design */

	$('#room_preferences_new').click(function(){
		$('roomDetailsExpand').hide();
		$('.YWLDetailsExpand_Bottom').toggle();
		$(this).toggleClass('closed');
                $('.ICONPng').toggleClass('right_ICONPng');
	});
	
	$('.ClossIconPPP').click(function(){
		$('.YWLDetailsExpand_Bottom').hide();
                $('#room_preferences_new').toggleClass('closed');
                $('.ICONPng').toggleClass('right_ICONPng');
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
	
	$('.children_ppp').change(function(){
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
		    $('#age_headline_ppp').show();
		    $('#child_age_limit_message_ppp').show();
		    $('#div_child_age_limit_ppp').css("height", "35px");
		}
		else{
			$('#age_headline_ppp').hide();	
			$('#child_age_limit_message_ppp').hide();
			$('#div_child_age_limit_ppp').css("height", "20px");
		}
		$('.roomAdults').children('.children_ppp:visible').each(function(i){
			total = parseInt(total) + parseInt($(this).val());
		});
		$('#children_count_ppp').html(total);
	});
	
	$('.adults_ppp').change(function(){ 
		count_change_update();
	});
	
	$('form[name="content_top"]').submit(function (){
		 var no_of_rooms = $('#search_rooms').val();
		 for(var i = no_of_rooms; i < 5; i++){
		     $(".adults_ppp")[i].name='';
		 }
		 for(var i = no_of_rooms; i < 5; i++){
			 $(".children_ppp")[i].name='';
		 }
	});
	
	$('#make_favourite').click(function(){
		
		$.ajax({
			  url: site_url+'inn_front/make_my_favourite',
			  dataType: "json",
			  success: function(data) {
			  if(data == "success"){
			    alert('Sucessfully Added To Your Favourites');
			   }
			  if(data == "login"){
				  alert('Please Login First');  
			  }
			  }
			});
		
	});
			
});

function count_change_update(){
	   var total_adult=0;
	   var total_children=0;
	   var number = $('#no_of_rooms').val();//alert(number);
	   if(number==1)//as by jquery the number of room is set 1 after six plus pop up
	   {
			total_adult=2;
	   }
	   else
	   {
		   $('.roomAdults').children('.adults_ppp:visible').each(function(i){
				total_adult = parseInt(total_adult) + parseInt($(this).val());
			});
	   }
	   //alert(total_adult)
		
		
		
		$('#adult_count_ppp').html(total_adult);
                if(parseInt(total_adult) > 1)
                {
                    $('#adult_label_ppp').html('adults');
                }
                else
                {
                    $('#adult_label_ppp').html('adult');
                }
		$('.roomAdults').children('.children_ppp:visible').each(function(i){
			total_children = parseInt(total_children) + parseInt($(this).val());
		});
		$('#children_count_ppp').html(total_children);
	  
}

function update_ad_ch(rooms, status)
{   
	//Need to write this comment
	var no_of_rooms = rooms.options[rooms.selectedIndex].value;	
	//for (i = 1 ; i <= no_of_rooms ; i++)
	for (i = 1 ; i <= 5 ; i++){	
		
		if(typeof(status) === "undefined"){
		var ad = "no_of_adults_"+i;
		var ch = "no_of_childs_"+i;
		var rm = "room_no_"+i;
	    }
	
		if(typeof(status) === "number"){
			var ad = "no_of_adult_"+i;
			var ch = "no_of_child_"+i;
			var rm = "room_nos_"+i;
		}
		document.getElementById(rm).style.padding = "4px 0px";
		if (i <= no_of_rooms){   
			//Need to write this comment
			document.getElementById(ad).style.display = "block";			
			document.getElementById(ad).disabled = false;			
			document.getElementById(ch).disabled = false;			
			document.getElementById(ch).style.display = "block";			
			document.getElementById(rm).style.display = "block";		
			//$('#rm').css('display','block');
		}
		else{
			//Need to write this comment
			document.getElementById(ad).style.display = "none";
			document.getElementById(ad).disabled = true;
			document.getElementById(ch).style.display = "none";
			document.getElementById(ch).disabled = true;
			document.getElementById(rm).style.display = "none";			
			//$('#rm').css('display','none');
		}
	}
}

function bookmark(title){
	var url = window.location;
	if(window.sidebar) 
          window.sidebar.addPanel(title,url,"");
	else if(window.opera && window.print)
	{
          var elem = document.createElement('a');
          elem.setAttribute('href',url);
          elem.setAttribute('title',title);
          elem.setAttribute('rel','sidebar');
          elem.click();
	}
	else if(os == "ie")
          window.external.AddFavorite(url,title);
}

$(window).load(function(){
	   $('#search_rooms').change(function(){
			var number = $(this).val();
			if(number==6)		
			{
				$(this).parent('.roomsNumberOfRooms').next().find('.rows_ppp').each(function(i){
					if(i<1){
					     $(this).show();
					   }
					   else{
					     $(this).hide();   
					 }	
				});
				$('.YWLDetailsExpand_Bottom').hide();
				$('.room_preferences').toggleClass('closed');
		        $('.ICONPng').toggleClass('right_ICONPng');
		        $("#search_rooms").val("1");
		        $('#rooms_count_ppp').html('1');
				location.href =  "javascript: jQuery.facebox({ajax:'"+__SITE__+"/six_plus_booking'})";
			}
			else
			{
				$(this).parent('.roomsNumberOfRooms').next().find('.rows_ppp').each(function(i){
					if(i<number){
					     $(this).show();
					   }
					   else{
					     $(this).hide();   
					 }	
				});
				$('#rooms_count_ppp').html(number);
			}
			
			if(parseInt(number) > 1)
            {
                  $('#rooms_label_ppp').html('rooms');
            }
            else
            {
                  $('#rooms_label_ppp').html('room');
            }
			count_change_update();
	    });  
});

