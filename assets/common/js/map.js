

var directionDisplay;
var directionsService = new google.maps.DirectionsService();

function initialize() {
	
	
  directionsDisplay = new google.maps.DirectionsRenderer();
  var myOptions = {
    zoom: 7,
    mapTypeId: google.maps.MapTypeId.ROADMAP,
    center: new google.maps.LatLng(lat,lng),
    mapTypeControl:true,
	mapTypeControlOptions: { style: google.maps.MapTypeControlStyle.DROPDOWN_MENU },
  };
  var map = new google.maps.Map(document.getElementById('map'),myOptions);

//Adding marker to the map
	var marker = new google.maps.Marker({
		position: new google.maps.LatLng(lat,lng),
		map: map,
		title:'click me',
		icon:'http://gmaps-samples.googlecode.com/svn/trunk/markers/blue/blank.png'
	  });  

	 var displayString = [                                   
	                      "Property Name: " + $("#prop_name").val(),
	                      "Location: " + $("#location").val(),
	                      "City: " + $("#pcity_name").val(),
	                      "State: " + $("#pstate_name").val()
	                      
	                    ].join("<br/>");
	 // creating infowindow
	 var infowindow = new google.maps.InfoWindow({content:displayString});

	 //adding click event to the marker
    google.maps.event.addListener(marker,'click',function(){infowindow.open(map,marker);}); 
	  
    directionsDisplay.setMap(map);
    directionsDisplay.setPanel(document.getElementById('bor_left'));

	  var control = document.getElementById('control');
	  control.style.display = 'block';
	  map.controls[google.maps.ControlPosition.TOP].push(control);
}

function calcRoute() {
  var end = document.getElementById('location').value +','+ document.getElementById('pcity_name').value +','+ document.getElementById('pstate_name').value;
  var start = document.getElementById('fromAddress').value;
  var request = {
    origin: start,
    destination: end,
    travelMode: google.maps.DirectionsTravelMode.DRIVING
  };
  directionsService.route(request, function(response, status) {
	  
    if (status == google.maps.DirectionsStatus.OK) {
      directionsDisplay.setDirections(response);
      $('.link').show();
      $('#error').hide();

      var fromAddress;
      fromAddress = start;
      var val = $('#map_addr').val();
      var faddr  = fromAddress.replace(",","+");
	  var faddrs = "&saddr="+faddr;
	  var addr = val+faddrs;
	  $('#insert').attr('href',addr);
    }
    else
    {
    	handleErrors(status);
    }
  });
}

google.maps.event.addDomListener(window, 'load', initialize);

function handleErrors(status){
	$('.link').hide();
	$('#bor_left').html('');
	$('#bor_left').css('border',"none");

	switch(status)
	{
		case 'ZERO_RESULTS':
			var error =  "A geocoding or directions request could not be successfully processed, yet the exact reason for the failure is not known. ";
			break;
		case 'NOT_FOUND':	
			var error ="A directions request could not be successfully parsed." ;
			break;
		default	: var error ="An unknown error occurred." ;
		break;
	}
   
    
    $('#error').html(error);
    $('#error').show();
    
 }