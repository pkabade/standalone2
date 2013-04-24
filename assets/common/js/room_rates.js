var room1;
var counter = "first";
$(document).ready(function(){
	
	/*
	 * Modified By: Sunny Patwa
	 * used to show a alert message for the child above 12	 
	 */
	var children_count = $('#children_count').html();//unused variable, previously the if condition was using this variable
	//alert('#child_popup_msg').val());
	if($('#child_popup_msg').val()==1)
	{	//alert('sunny');
		$('#alert_timeout').animate({'width':'toggle'});
		window.setTimeout("close_child_alert();", 5000);
	}
	/*if(typeof(child_popup)!='undefined'){
		$('#alert_timeout').animate({'width':'toggle'});
		window.setTimeout("close_child_alert();", 5000);
	}*/
    tooltip();//active les tooltip simple
    imagePreview();//active les tooltip image preview
    screenshotPreview();//active les tooltip lien avec preview

    $('form[name="get_avaibility"]').submit(function (ev){
            $('.Stay_occupants .roomsPeople select').not(':hidden').each(function(){
	            if($(this).val()=='?')
	            {
	                alert('Please select the ages of each child.');
	                ev.preventDefault();
	                return false;
	            }
             });
    });


    var room_inner = $('#total_rooms_inner').val();
    //console.log(room_inner)
    var room = $('#total_rooms').val();
    //console.log(room)
    count = room_inner - 1;
    room1 = room-1;
    room2 = room_inner-1;
    for(var i=1; i<room;i++){
        $('#slider128_'+i).easySlider({
            auto: false,
            continuous: false,
            prevId:'prevBtn'+i,
            nextId:'nextBtn'+i,
            count:count
        });
    }
	
    for(var i=1; i<room;i++){
        for(var j=1; j<=room_inner;j++){        	
            $('#inner_slider_'+i+'_'+j).loopedSlider();
        }
    }
    
    for(var m=0; m < $('#room_types_total').val(); m++){
    	 $('#inner_slider_'+m).loopedSlider();
    }
    
    $('#alert_close').click(function(){
		$('#alert_timeout').animate({'width':'toggle'});	
	});
    
 
   $('.room_Rate_BoxLTInner').change(function(){
	  // alert('slide is palyed');
   }); 
});

$(window).load( function (){
	
    $('.Room').hover(function(){
        if(counter == "first"){
            $('#booking_popup').animate({
                'width':'toggle'
            });
            counter = counter + "not";
            window.setTimeout("closeDiv();", 5000);
        }
		
    });
	
    $('#cse').click(function(){
		
        $('#booking_popup').animate({
            'width':'toggle'
        });
	
    });
	

	
    $('.Max2Box').mouseover(function(){
        /*$(this).tooltip({

		// use div.tooltip as our tooltip
		tip: '.tooltip',

		// use the fade effect instead of the default
		effect: 'fade',

		// make fadeOutSpeed similar to the browser's default
		fadeOutSpeed: 100,

		// the time before the tooltip is shown
		predelay: 400,

		// tweak the position
		position: "center right",
		offset: [-30, -80]
	});*/
        });
	
//$('#avg_rate[title]').cluetip({splitTitle: '|'});
	
});


function closeDiv()
{
    $('#booking_popup').animate({
        'width':'hide'
    });
}

function show_hide_toggle(id,nid,obj){
    //console.log(id+'==>'+nid+'==>'+obj)

    if ($('#show_hide128_'+id).is(':visible')){
        //console.log('inside if');
        $('#show_hide128_'+id).hide();
        $(obj).find('input').parent('div').removeClass('BoxMinuse').addClass('BoxPlus');
    }
    else{
        //console.log('inside else');
        //$('#slider128_'+nid).css('height','100%');
        $('#show_hide128_'+id).show();
        $(obj).find('input').parent('div').removeClass('BoxPlus').addClass('BoxMinuse');
    }

}

function radio_click(id,arrowbtnid,btnid,nextid,room_tax){ 
    //alert(id)
    if ($('#'+id).attr('checked')==true){
			
        $('#'+btnid).parent('div').addClass('green');
        $('#'+btnid).val('Select Room');
        $('#'+btnid).parent('div').removeClass('boxRed');
        $('#tick_'+arrowbtnid).hide();
        $('#prevBtn'+arrowbtnid).css('visibility','visible');
        $('#nextBtn'+arrowbtnid).css('visibility','visible');
        $('#room_'+arrowbtnid+'_name').html('');
        $('#room_'+arrowbtnid+'_base').html('0.00');
        $('#extra_charges_'+arrowbtnid).html('0.00');
        $('#extra_child_'+arrowbtnid).html('0.00');
        var single_total = $('#total_'+arrowbtnid).html();
        var sub_total = $('#subtotal').html();
        var new_sub_total = sub_total - single_total;
        var tax = room_tax/100 * new_sub_total;
        var gross_total = new_sub_total + tax;
        $('#total_'+arrowbtnid).html('0.00');
        $('#subtotal').html(roundNumber(new_sub_total,2));
        $('#total_tax').html(roundNumber(tax,2));
        $('#gross_total').html(roundNumber(gross_total,2));
        $('#'+id).attr('checked',false);
    }

    else{
        compid = parseInt(arrowbtnid);
        var j = compid-1;
        if(compid > 1){
            var radioSelected = false;
            for (var i=0; i < document.getElementsByName('room_'+j).length; i++)
            {
                if (document.getElementsByName('room_'+j)[i].checked == true)
                {
		     
                    radioSelected = true;
		  	 
                }
            }
            if (!radioSelected)
            {
                alert('Please select one room type in Room '+j);
                newid = arrowbtnid -1;
                scrollWin(newid);
                window.load.load();
            }
        }
        //$('#slider128_'+arrowbtnid).css('height','100%');
        $('.shw_hide').hide();
        $('.shw_hide').removeClass('BoxMinuse').addClass('BoxPlus');
        $('#'+btnid).parent('div').addClass('boxRed');
        $('#'+btnid).val('Cancel Room');
        $('#'+btnid).parent('div').removeClass('green');
        $('#prevBtn'+arrowbtnid).css('visibility','hidden');
        $('#nextBtn'+arrowbtnid).css('visibility','hidden');
        $('#tick_'+arrowbtnid).show();
        $('#'+id).attr('checked','checked');
        $('#'+id).trigger('click');
        scrollWin(nextid);
    }

}

function scrollWin(num){
    $('html,body').animate({
        scrollTop: $("#auto_"+num).offset().top
    }, 2000);
}
   
function roundNumber(number,decimals) {
    var newString;// The new rounded number
    decimals = Number(decimals);
    if (decimals < 1) {
        newString = (Math.round(number)).toString();
    } else {
        var numString = number.toString();
        if (numString.lastIndexOf(".") == -1) {// If there is no decimal point
            numString += ".";// give it one at the end
        }
        var cutoff = numString.lastIndexOf(".") + decimals;// The point at which to truncate the number
        var d1 = Number(numString.substring(cutoff,cutoff+1));// The value of the last decimal place that we'll end up with
        var d2 = Number(numString.substring(cutoff+1,cutoff+2));// The next decimal, after the last one we want
        if (d2 >= 5) {// Do we need to round up at all? If not, the string will just be truncated
            if (d1 == 9 && cutoff > 0) {// If the last digit is 9, find a new cutoff point
                while (cutoff > 0 && (d1 == 9 || isNaN(d1))) {
                    if (d1 != ".") {
                        cutoff -= 1;
                        d1 = Number(numString.substring(cutoff,cutoff+1));
                    } else {
                        cutoff -= 1;
                    }
                }
            }
            d1 += 1;
        }
        if (d1 == 10) {
            numString = numString.substring(0, numString.lastIndexOf("."));
            var roundedNum = Number(numString) + 1;
            newString = roundedNum.toString() + '.';
        } else {
            newString = numString.substring(0,cutoff) + d1.toString();
        }
    }
    if (newString.lastIndexOf(".") == -1) {// Do this again, to the new string
        newString += ".";
    }
    var decs = (newString.substring(newString.lastIndexOf(".")+1)).length;
    for(var i=0;i<decimals-decs;i++) newString += "0";
    //var newNumber = Number(newString);// make it a number if you like
    return newString; // Output the result to the form field (change for your purposes)
}



function update_total_price(nights, avg_price, tax_percentile, room_number, total_rooms, room_name_value, ext_charges_value, child_add_value, deal_id)
{
        avg_price = avg_price.replace(/,/g,'');
    	ext_charges_value = ext_charges_value.replace(/,/g,'');
    	child_add_value = child_add_value.replace(/,/g,'');

        var room = 'room_'+room_number+'_base';
        var deal = 'deal_'+room_number+'_base';
        var tax = 'tax_'+room_number;
        var total = 'total_'+room_number;
        var room_name = 'room_'+room_number+'_name';
        var extra_charges_div = 'extra_charges_'+room_number;
        var child_charges_div = 'extra_child_'+room_number;

        var b = document.getElementById(room);
        b.innerHTML = roundNumber(avg_price*nights, 2);

        document.room_details.elements[room].value = roundNumber(avg_price ,2);
        document.room_details.elements[deal].value = deal_id;
        tax_amount = 0;

        var e = document.getElementById(extra_charges_div);
        e.innerHTML = roundNumber(ext_charges_value*nights, 2);
        document.room_details.elements[extra_charges_div].value = roundNumber(ext_charges_value*nights, 2);

        var x = document.getElementById(child_charges_div);
        x.innerHTML = roundNumber(child_add_value*nights, 2);
        //alert(roundNumber(child_add_value*nights, 2));alert(child_charges_div);
        //$('input[name="'+child_charges_div+'"').val(child_add_value);
        document.getElementById(child_charges_div).value = roundNumber(child_add_value*nights, 2);

        extra_charge = parseFloat(ext_charges_value) + parseFloat(child_add_value);

       	total_amount = roundNumber(nights*(parseFloat(avg_price)+parseFloat(extra_charge)), 2);
//        total_amount = roundNumber(nights*(parseFloat(avg_price)), 2);
        var room_total = document.getElementById(total).innerHTML;

        var d = document.getElementById(total);
        d.innerHTML = roundNumber(total_amount, 2);
        document.room_details.elements[total].value = roundNumber(total_amount, 2);

        var f = document.getElementById(room_name);
        f.innerHTML = room_name_value;
        document.room_details.elements[room_name].value = room_name_value;

        var gross_total = 0;
        var room_total_amount;
        var total_n;
        var subtotal = 0;
        var total_tax;

        for (var j=1;j<=total_rooms;j++)
        {
                total_n = "total_"+j;
                tmp = document.getElementById(total_n).innerHTML;
                room_total_amount = parseFloat(tmp);
                subtotal = subtotal + room_total_amount;
                gross_total = gross_total + room_total_amount;
        }

        total_tax = subtotal*tax_percentile/100;
        gross_total = gross_total + total_tax;

        var e = document.getElementById("gross_total");
        e.innerHTML = roundNumber(gross_total, 2);
        //document.room_details.gross_total.value = roundNumber(gross_total, 2);

        var f = document.getElementById("total_tax");
        f.innerHTML = roundNumber(total_tax, 2);
       // document.room_details.gross_total.value = roundNumber(total_tax, 2);

        var g = document.getElementById("subtotal");
        g.innerHTML = roundNumber(subtotal, 2);
       // document.room_details.gross_total.value = roundNumber(subtotal, 2);
}

function book_it_now(total_room)
{
    for (var j=1; j <= total_room; j++)
    {

        var radioSelected = false;
        for (var i=0; i < document.getElementsByName('room_'+j).length; i++)
        {

            if (document.getElementsByName('room_'+j)[i].checked == true)
            {
                radioSelected = true;
            }

        }
        if (!radioSelected)
        {
            alert('Please select one room type in Room '+j);
            window.load();
        }
    }
    //alert('The handshake is under construction');
    //window.load();
    //document.room_details.action = "https://www.inn_front/book_it_now/book_standalone";

    document.room_details.action = bin_url+"/inn_front/book_it_now/book_standalone";
    document.room_details.submit();
}

function close_child_alert(){
	$('#alert_timeout').animate({'width':'toggle'});
}
