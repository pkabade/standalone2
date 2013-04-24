$('document').ready(function(){

	$('#att_filter input').live('click',function(){
		$.ajax({
			url: site_url+'inn_front/filter_attractions/',
			data:'filter=yes&'+$('#att_filter').serialize(),
			type: "POST",
			dataType: "html",
			success: function(data){
			$('#filter').replaceWith(data);
			load_back();
		   }			
		});	
	});	
	//LabeledMarker.prototype = new GMarker(new GLatLng(0, 0));
	$.ajax({
		  url: site_url+'assets/js/map_marker.js',
		  dataType: 'script',
		  success: load_back
		});	
	
});


function load_back(){
	if (GBrowserIsCompatible()) {
	   var map = new GMap2(document.getElementById("attr_map"));	   
	   $('#filtered_categories > .Dest_PerHotelB').each(function(i){
		   
		   function createMarker(point) 
		    {
	       	var icon = new GIcon();
                
	       	icon.image = site_url + 'assets/css/ywl/images/mapylpointer.png';
	       	mlbltxt = i+1;
	       	icon.iconSize = new GSize(40, 48);
	       	icon.iconAnchor = new GPoint(32, 28);
	       	icon.infoWindowAnchor = new GPoint(25, 7);

	       	opts = {
	       		"icon": icon,
	       		"clickable": true,
	       		"labelText": mlbltxt,
	       		"labelOffset": new GSize(-16, -16)
	       	};
	       	var marker = new LabeledMarker(point, opts);
	       	 return marker;
	       }
		var seperated = $(this).attr('cordinates').split('|');
		map.addControl(new GSmallMapControl());
	    map.addControl(new GMapTypeControl());
//		console.log(seperated+"inside 1");
		if(seperated.length > 1)
		{
		    var latlng = new GLatLng(seperated[0], seperated[1]);
		    map.setCenter(new GLatLng(seperated[0], seperated[1]), 6);	    
			
		    var icon = createMarker(latlng);
		    //console.log(typeof(icon)+"inside 2");
	        map.addOverlay(icon);
		}
		else{ 
			var geocoder = new GClientGeocoder();
			   geocoder.getLatLng(seperated[0],function(point) {
				   map.setCenter(point, 6);
			       if (!point) {
			         alert(seperated[0] + " not found");
			       } else {
			    	   var icon = createMarker(point);
			    	   //console.log(typeof(icon)+"inside 3");
				        map.addOverlay(icon); 			                 
			       }
			     });
		}
	   });
	} else {
	      alert("Sorry, the Google Maps API is not compatible with this browser");
	  }
}