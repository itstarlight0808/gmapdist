var g_map = null;
var g_loc_start = null;
var g_loc_dest = null;
var g_mk1 = null;
var g_mk2 = null;
var g_directionsService = null;
var g_directionsRenderer = null;
var unit_mile = 1609;
var rt_distance = 0;
var rt_duration = 0;

var autocomplete_start=null, autocomplete_dest=null;

const g_names = ["Alex", "Mike", "Marc", "Jason"];
const g_addrs = ["9 Brentwood Dr McKees Rocks, PA 15136", "1 Alverston Ct, Irmo, SC 29063", "34 Park Road, Crownsville, MD 21032", "145 Hampden Park, Tiffin, OH 44883", ""];
// Initialize and add the map

function haversine_distance(mk1, mk2) {
    var R = 3958.8; // Radius of the Earth in miles
    var rlat1 = mk1.position.lat() * (Math.PI/180); // Convert degrees to radians
    var rlat2 = mk2.position.lat() * (Math.PI/180); // Convert degrees to radians
    var difflat = rlat2-rlat1; // Radian difference (latitudes)
    var difflon = (mk2.position.lng()-mk1.position.lng()) * (Math.PI/180); // Radian difference (longitudes)

    var d = 2 * R * Math.asin(Math.sqrt(Math.sin(difflat/2)*Math.sin(difflat/2)+Math.cos(rlat1)*Math.cos(rlat2)*Math.sin(difflon/2)*Math.sin(difflon/2)));
    return d;
}

function initMap() {
    // The map, centered on Central Park
    const center = {lat: 40.774102, lng: -73.971734};
    const map = new google.maps.Map(
        document.getElementById('map'), {zoom: 15, scaleControl: true, center: center});
    g_map = map;

    const geocoder_start = new google.maps.Geocoder();
    const geocoder_dest = new google.maps.Geocoder();

    // Locations of landmarks
    g_loc_start = {lat: 40.7767644, lng: -73.9761399}; //The Dakota
    g_loc_dest = {lat: 40.771209, lng: -73.9673991}; //The Frick

    // The markers for The Dakota and The Frick Collection
    var mk1 = new google.maps.Marker({position: g_loc_start, map: map});
    var mk2 = new google.maps.Marker({position: g_loc_dest, map: map});

    g_mk1 = mk1;
    g_mk2 = mk2;

    const biasInputElement = document.getElementById("use-location-bias");
    const strictBoundsInputElement = document.getElementById("use-strict-bounds");
    const options = {
        componentRestrictions: { country: "us" },
        fields: ["formatted_address", "geometry", "name"],
        origin: map.getCenter(),
        strictBounds: false,
        types: [],
    };

    const addr_start = document.getElementById("pac-addr-start");
    const addr_dest = document.getElementById("pac-addr-dest");

    autocomplete_start = new google.maps.places.Autocomplete(addr_start, options);
    autocomplete_dest = new google.maps.places.Autocomplete(addr_dest, options);

    // Bind the map's bounds (viewport) property to the autocomplete object,
    // so that the autocomplete requests use the current map bounds for the
    // bounds option in the request.
    autocomplete_start.bindTo("bounds", map);
    autocomplete_dest.bindTo("bounds", map);

    const infowindow_start = new google.maps.InfoWindow();
    const infowindowContent_start = document.getElementById("infowindow-content-start");
    infowindow_start.setContent(infowindowContent_start);

    const infowindow_dest = new google.maps.InfoWindow();
    const infowindowContent_dest = document.getElementById("infowindow-content-dest");
    infowindow_dest.setContent(infowindowContent_dest);
    
    autocomplete_start.addListener("place_changed", () => {
        geocoder_start.geocode({'address': addr_start.value}, function(results, status){
            if (status == google.maps.GeocoderStatus.OK){
                var latitude = results[0].geometry.location.lat();
                var longitude = results[0].geometry.location.lng();
                g_loc_start.lat = latitude;
                g_loc_start.lng = longitude;

                infowindow_start.close();
                mk1.setVisible(false);
                const place_start = results[0];

                if (!place_start.geometry || !place_start.geometry.location) {
                // User entered the name of a Place that was not suggested and
                // pressed the Enter key, or the Place Details request failed.
                window.alert("No details available for input: '" + place_start.name + "'");
                return;
                }

                // If the place has a geometry, then present it on a map.
                if (place_start.geometry.viewport) {
                //map.fitBounds(place_start.geometry.viewport);
                } else {
                //map.setCenter(place_start.geometry.location);
                //map.setZoom(17);
                }
                mk1.setPosition(place_start.geometry.location);
                mk1.setVisible(true);
                infowindowContent_start.children["place-name-start"].textContent = place_start.name;
                infowindowContent_start.children["place-address-start"].textContent = place_start.formatted_address;
                infowindow_start.open(map, mk1);
                g_mk1 = mk1;
            }
        });
    });
    setTimeout(()=>google.maps.event.trigger(autocomplete_start, 'place_changed'), 500);
    autocomplete_dest.addListener("place_changed", () => {
        infowindow_dest.close();
        mk2.setVisible(false);
        const place_dest = autocomplete_dest.getPlace();

        if (!place_dest.geometry || !place_dest.geometry.location) {
        // User entered the name of a Place that was not suggested and
        // pressed the Enter key, or the Place Details request failed.
        window.alert("No details available for input: '" + place_dest.name + "'");
        return;
        }

        // If the place has a geometry, then present it on a map.
        if (place_dest.geometry.viewport) {
        //map.fitBounds(place_dest.geometry.viewport);
        } else {
        //map.setCenter(place_dest.geometry.location);
        //map.setZoom(17);
        }
        mk2.setPosition(place_dest.geometry.location);
        mk2.setVisible(true);
        infowindowContent_dest.children["place-name-dest"].textContent = place_dest.name;
        infowindowContent_dest.children["place-address-dest"].textContent = place_dest.formatted_address;
        infowindow_dest.open(map, mk2);
        g_mk2 = mk2;
        geocoder_dest.geocode({'address': addr_dest.value}, function(results, status){
            if (status == google.maps.GeocoderStatus.OK){
                var latitude = results[0].geometry.location.lat();
                var longitude = results[0].geometry.location.lng();
                g_loc_dest.lat = latitude;
                g_loc_dest.lng = longitude;
            }
        });
    });

    let directionsService = new google.maps.DirectionsService();
    let directionsRenderer = new google.maps.DirectionsRenderer();
    g_directionsService = directionsService;
    g_directionsRenderer = directionsRenderer;

    // Sets a listener on a radio button to change the filter type on Places
    // Autocomplete.
    function setupClickListener(id, types) {
        const radioButton = document.getElementById(id);
        radioButton.addEventListener("click", () => {
            autocomplete_start.setTypes(types);
            autocomplete_dest.setTypes(types);
            addr_start.value = "";
            addr_dest.value = "";
        });
    }
    setupClickListener("changetype-all", []);
    setupClickListener("changetype-address", ["address"]);
    setupClickListener("changetype-establishment", ["establishment"]);
    setupClickListener("changetype-geocode", ["geocode"]);

    biasInputElement.addEventListener("change", () => {
        if (biasInputElement.checked) {
            autocomplete_start.bindTo("bounds", map);
            autocomplete_dest.bindTo("bounds", map);
        } else {
            // User wants to turn off location bias, so three things need to happen:
            // 1. Unbind from map
            // 2. Reset the bounds to whole world
            // 3. Uncheck the strict bounds checkbox UI (which also disables strict bounds)
            autocomplete_start.unbind("bounds");
            autocomplete_start.setBounds({ east: 180, west: -180, north: 90, south: -90 });
            autocomplete_dest.unbind("bounds");
            autocomplete_dest.setBounds({ east: 180, west: -180, north: 90, south: -90 });
            strictBoundsInputElement.checked = biasInputElement.checked;
        }
        addr_start.value = "";
        addr_dest.value = "";
    });
    strictBoundsInputElement.addEventListener("change", () => {
        autocomplete_start.setOptions({
            strictBounds: strictBoundsInputElement.checked,
        });
        autocomplete_dest.setOptions({
            strictBounds: strictBoundsInputElement.checked,
        });

        if (strictBoundsInputElement.checked) {
            biasInputElement.checked = strictBoundsInputElement.checked;
            autocomplete_start.bindTo("bounds", map);
            autocomplete_dest.bindTo("bounds", map);
        }
        addr_start.value = "";
        addr_dest.value = "";
    });
    
}

function calc_distance_expense()
{
    // Draw a line showing the straight distance between the markers
    //var line = new google.maps.Polyline({path: [g_loc_start, g_loc_dest], map: g_map});

    // Calculate and display the distance between markers
    //var distance = haversine_distance(g_mk1, g_mk2);
    //document.getElementById('msg').innerHTML = "Distance between markers: " + distance.toFixed(2) + " mi.";

    
    g_directionsRenderer.setMap(g_map); // Existing map object displays directions
    // Create route from existing points used for markers
    const route = {
        origin: g_loc_start,
        destination: g_loc_dest,
        travelMode: 'DRIVING'
    }

    g_directionsService.route(route, function(response, status) { // anonymous function to capture directions
        if (status !== 'OK') {
            window.alert('Directions request failed due to ' + status);
            return;
        } else {
            g_directionsRenderer.setDirections(response); // Add route to the map
            var directionsData = response.routes[0].legs[0]; // Get data about the mapped route
            console.log(directionsData);
            if (!directionsData) {
                window.alert('Directions request failed');
                return;
            }
            else {
                document.getElementById('msg').innerHTML = " Driving distance is " + directionsData.distance.text + " (" + directionsData.duration.text + ").";
                rt_distance = directionsData.distance.value * 2 / unit_mile;
                rt_duration = directionsData.duration.value * 2;
                var str_msg = "";
                if (rt_distance < 500)
                {
                    rt_distance *= 1.04;
                    rt_duration *= 1.04;
                }
                else if (rt_distance >= 500 && rt_distance < 1000)
                {
                    rt_distance *= 1.03;
                    rt_duration *= 1.04;
                }
                else
                {
                    rt_distance *= 1.02;
                    rt_duration *= 1.02;
                }
                var rt_duration_min = parseFloat(rt_duration) / 60;
                if (rt_distance < 1)
                    str_msg = "You will have a round trip of " + rt_distance.toFixed(2) + " mile ";
                else
                    str_msg = "You will have a round trip of " + rt_distance.toFixed(2) + " miles ";
                if (rt_duration_min < 1)
                {
                    str_msg += "(" + Math.ceil(rt_duration) + " seconds).";
                }
                else
                {
                    str_msg += "(" + parseInt(rt_duration_min) + " minutes).";
                }
                document.getElementById('msg').innerHTML = str_msg;
            }
        }
    });
}