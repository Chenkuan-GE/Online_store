<div class="r-inputs">
	<div>
		lat: <input type="" name="" id="address_lng" value="经度" /> 
		lng:<input type="" name="" id="address_lat" value="纬度" />
	</div>
	address: <input type="" name="" id="address" value="address" class="r-address" />
</div>
<input id="pac-input" class="controls" type="text" placeholder="Search Box">
<div id="map" style="width:800px; height:750px"></div>


<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBS-NGoGe1KrzyghFvzs-syhYiNdERGi34&callback=initAutocomplete" async defer></script>
<script type="text/javascript">
	var lngtxt = "153.0236759";
var lattxt = "-27.4693948";
var addresstxt = "Brisbane";

var map;
var marker;
var infowindow;
var geocoder;
var markersArray = [];

function initAutocomplete() {
	var latlng = new google.maps.LatLng(lattxt, lngtxt);
	var myOptions = {
		zoom: 13,
		center: latlng,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	};
	map = new google.maps.Map(document.getElementById('map'), myOptions);
	
	geocoder = new google.maps.Geocoder(); //实例化地址解析
	//监听点击地图事件
	google.maps.event.addListener(map, 'click', function(event) {
		placeMarker(event.latLng);
	});
	// Create the search box and link it to the UI element.
	var input = document.getElementById('pac-input');
	var searchBox = new google.maps.places.SearchBox(input);
	map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

	// Bias the SearchBox results towards current map's viewport.
	map.addListener('bounds_changed', function() {
		searchBox.setBounds(map.getBounds());
	});

	var markers = [];
	// Listen for the event fired when the user selects a prediction and retrieve
	// more details for that place.
	searchBox.addListener('places_changed', function() {
		var places = searchBox.getPlaces();

		if(places.length == 0) {
			return;
		}

		// Clear out the old markers.
		markers.forEach(function(marker) {
			marker.setMap(null);
		});
		markers = [];

		// For each place, get the icon, name and location.
		var bounds = new google.maps.LatLngBounds();
		places.forEach(function(place) {
			if(!place.geometry) {
				console.log("Returned place contains no geometry");
				return;
			}
			var icon = {
				url: place.icon,
				size: new google.maps.Size(71, 71),
				origin: new google.maps.Point(0, 0),
				anchor: new google.maps.Point(17, 34),
				scaledSize: new google.maps.Size(25, 25)
			};
			//console.log(place.geometry.location.lat());
			mapClick(place.geometry.location.lng(), place.geometry.location.lat(), place.name);
			// Create a marker for each place.
			markers.push(new google.maps.Marker({
				map: map,
				icon: icon,
				title: place.name,
				position: place.geometry.location
			}));

			if(place.geometry.viewport) {
				// Only geocodes have viewport.
				bounds.union(place.geometry.viewport);
			} else {
				bounds.extend(place.geometry.location);
			}
		});
		map.fitBounds(bounds);
	});
}

function placeMarker(location) {
	clearOverlays(infowindow); //清除地图中的标记
	marker = new google.maps.Marker({
		position: location,
		map: map
	});
	markersArray.push(marker);
	//根据经纬度获取地址
	if(geocoder) {
		geocoder.geocode({
			'location': location
		}, function(results, status) {
			if(status == google.maps.GeocoderStatus.OK) {
				if(results[0]) {
					attachSecretMessage(marker, results[0].geometry.location, results[0].formatted_address);
				}
			} else {
				alert("Geocoder failed due to: " + status);
			}
		});
	}
}
//在地图上显示经纬度地址
function attachSecretMessage(marker, piont, address) {
	var message = "<b>坐标:</b>" + piont.lat() + " , " + piont.lng() + "<br />" + "<b>地址:</b>" + address;
	var infowindow = new google.maps.InfoWindow({
		content: message,
		size: new google.maps.Size(50, 50)
	});
	infowindow.open(map, marker);
	if(typeof(mapClick) == "function") mapClick(piont.lng(), piont.lat(), address);
}
//删除所有标记阵列中消除对它们的引用
function clearOverlays(infowindow) {
	if(markersArray && markersArray.length > 0) {
		for(var i = 0; i < markersArray.length; i++) {
			markersArray[i].setMap(null);
		}
		markersArray.length = 0;
	}
	if(infowindow) {
		infowindow.close();
	}
}

function setiInit() {
	// 页面加载显示默认lng lat address---begin
	if(lattxt != '' && lngtxt != '' && addresstxt != '') {
		var latlng = new google.maps.LatLng(lattxt, lngtxt);
		marker = new google.maps.Marker({
			position: latlng,
			map: map
		});
		markersArray.push(marker);
		attachSecretMessage(marker, latlng, addresstxt);
	}
}

function mapClick(lng, lat, address) {
	window.parent.document.getElementById("address_lng").value = lng;
	window.parent.document.getElementById("address_lat").value = lat;
	window.parent.document.getElementById("address").value = address;
}
window.onload = function() {
	setiInit();
}
</script>