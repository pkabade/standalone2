 	var map;
    var myPano;   
    var panoClient;
    var nextPanoId;
    var center;
    var marker;
    var fromAddress;
    
    $(document).ready( function () {
    	
	var val = $('#map_addr').val();
	$('#print').click(function(){
		//alert(fromAddress+'\n'+val);
		//$('.link').show(); 
		var faddr  = fromAddress.replace(",","+");
		var faddrs = "&saddr="+faddr;
		var addr = val+faddrs;
		$('#insert').attr('href',addr);
		$('#bor_left').css('border',"1px solid #94BCE4");
		$('#bor_left').css('border-top',"none");
	});
        
      var center = new GLatLng(lat, lng);
   
//      alert(center);
      var fenwayPOV = {yaw:370.64659986187695,pitch:-20};
      
      panoClient = new GStreetviewClient();      
      
      map = new GMap2(document.getElementById("map"));
      map.setCenter(center, 13);
      map.addControl(new GSmallMapControl());
      map.addControl(new GMapTypeControl());
      marker = new GMarker(center);
      map.addOverlay(marker);
      /*GEvent.addListener(map, "click", function(overlay,latlng) {
        panoClient.getNearestPanorama(latlng, showPanoData);
      });*/     
      myPano = new GStreetviewPanorama(document.getElementById("pano"));
      myPano.setLocationAndPOV(center, fenwayPOV);
      GEvent.addListener(myPano, "error", handleNoFlash);  
      panoClient.getNearestPanorama(center, showPanoData);
      
	   gdir = new GDirections(map, document.getElementById("directions"));
	   GEvent.addListener(gdir, "error", handleErrors); 
    });
    
    function showPanoData(panoData) {
      if (panoData.code != 200) {
//        GLog.write('showPanoData: Server rejected with code: ' + panoData.code);
        return;
      }
      nextPanoId = panoData.links[0].panoId;
      var prop_description = $("#short_desc").val();
      var displayString = [                                   
        "Property Name: " + $("#prop_name").val(),
        "Location: " + $("#location").val(),
        "City: " + $("#pcity_name").val(),
        "State: " + $("#pstate_name").val()
        // "Description: " + prop_description,
      //  "Copyright: " + panoData.copyright,
      ].join("<br/>");
      
      GEvent.addListener(marker, "click", function() {
          marker.openInfoWindowHtml(displayString);
        });
      
      map.openInfoWindowHtml(panoData.location.latlng, displayString);
      
//      GLog.write('Viewer moved to' + panoData.location.latlng);
      myPano.setLocationAndPOV(panoData.location.latlng);
    }
    
    
    function next() {
      // Get the next panoId
      // Note that this is not sophisticated. At the end of the block, it will get stuck
      panoClient.getPanoramaById(nextPanoId, showPanoData);
    }
    
    function handleNoFlash(errorCode) {
      if (errorCode == 603) {
        alert("Error: Flash doesn't appear to be supported by your browser");
        return;
      }
    }  
    
    function handleErrors(){
    	$('.link').hide();
    	$('#bor_left').css('border',"none");
    	
        if (gdir.getStatus().code == G_GEO_UNKNOWN_ADDRESS){
        	var error = "No corresponding geographic location could be found for one of the specified addresses. This may be due to the fact that the address is relatively new, or it may be incorrect. ";
        
        	
        }
        else if (gdir.getStatus().code == G_GEO_SERVER_ERROR){
        	
        	var error =  "A geocoding or directions request could not be successfully processed, yet the exact reason for the failure is not known. ";
        }
        else if (gdir.getStatus().code == G_GEO_MISSING_QUERY){
        	
        	var error = "The HTTP q parameter was either missing or had no value. For geocoder requests, this means that an empty address was specified as input. For directions requests, this means that no query was specified in the input. ";
        }
        else if (gdir.getStatus().code == G_GEO_BAD_KEY){
        	
        	var error ="The given key is either invalid or does not match the domain for which it was given.  " ;
        }
        else if (gdir.getStatus().code == G_GEO_BAD_REQUEST){
        	
        	var error ="A directions request could not be successfully parsed." ;
        }
        else var error ="An unknown error occurred.";
        
        $('#error').html(error);
        $('#error').show();
     }
    
    function setDirections() {
    	$('#error').hide();
    	fromAddress = $('#fromAddress').val();
    	address =  lat+', '+lng;
    	//console.log('Address'+address);
    	//map.removeOverlay(marker)
    	gdir.load("from: " + fromAddress + " to: " + address, { "locale": "en_US" });
    	$('.link').show();	
    

    }
