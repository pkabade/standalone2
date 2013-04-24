$(document).ready(function() {

	// att_home_map();

	});

function att_home_map() {
	if (GBrowserIsCompatible()) {
		var zip_prop = $('#attr_home_map').attr('zip_map');
		var zip_attr = $('#contents').attr('zip');

		var zip = new Array();
		zip[0] = zip_prop;
		zip[1] = zip_attr;

		var map = new GMap2(document.getElementById("attr_home_map"));
		map.addControl(new GSmallMapControl());
		map.addControl(new GMapTypeControl());

		$(zip)
				.each(function(i, val) {
					// console.log(i);
						// alert(val);
						// Create our "tiny" marker icon

						if (i == 0) {
							var icon = new GIcon(G_DEFAULT_ICON);
							icon.image = site_url + 'assets/css/ywl/images/mapblpointer.png';
							icon.shadow = site_url + 'assets/css/ywl/images/mapyl_shadow.png';
							icon.iconSize = new GSize(40, 48);
							markerOptions = {
								icon : icon
							};
							create_icon(val, map, markerOptions);

						} else {
							// console.log("i!=0")
							var icons = new GIcon(G_DEFAULT_ICON);
							icons.image = site_url + 'assets/css/ywl/images/mapylpointer.png';
							icons.shadow = site_url + 'assets/css/ywl/images/mapyl_shadow.png';
							icons.iconSize = new GSize(40, 48);
							markerOptionss = {
								icon : icons
							};
							create_icon(val, map, markerOptionss);
						}

					});

	}
}

function create_icon(zip, map, markeroption) {

	var geocoder = new GClientGeocoder();
	geocoder.getLatLng(zip, function(point) {
		map.setCenter(point, 6);
		if (!point) {
			alert(val + " not found");
		} else {
			map.addOverlay(new GMarker(point, markeroption));
		}
	});
}

function make_favourite(val) {
	arr = val.split('-');
	$.post(site_url + 'Attraction/make_favourite', {
		source_id : arr[0],
		source_type_id : arr[1]
	}, function(msg) {
		alert('This Attraction has been added to your favourites successfully')
	});
}