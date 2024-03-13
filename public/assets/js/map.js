let map;
let currentMarker;

function initMap(element) {
    map = new google.maps.Map(document.getElementById(element), {
        center: { lat: 14.621543, lng: 121.050349 }, // Country: PH, Location: Cubao
        zoom: 14, // You can adjust the zoom level as needed
        fullscreenControl: false, // Remove the full-screen control button
        streetViewControl: false, // Remove the street view control (pegman)
        mapTypeControl: false, // Remove the map type control button
    });
}

function branchGoogleMaps(element, address, location = null) {
    var geocoder = new google.maps.Geocoder();

    geocoder.geocode({ address: address }, function(results, status) {
        if (status === "OK" && results[0]) {
            var locations = (location ? location : results[0].geometry.location);

            map = new google.maps.Map(document.getElementById(element), {
                center: locations,
                zoom: 15, // You can adjust the zoom level as needed
                fullscreenControl: false, // Remove the full-screen control button
                streetViewControl: false, // Remove the street view control (pegman)
                mapTypeControl: false, // Remove the map type control button
            });
            map.setCenter(locations);

            google.maps.event.addListener(map, 'click', function (event) {
                addMarker({
                    coordinates: event.latLng
                })
            })

            if(location){
                addMarker({ coordinates: location });
            }
        }
    });
}

function addMarker(prop) {
    var coordinates = prop.coordinates;

    if (currentMarker) {
        currentMarker.setMap(null);
    }

    let marker = new google.maps.Marker({
        position: prop.coordinates,
        map: map
    });

    currentMarker = marker;

    var latitude = typeof coordinates.lat === 'number' ? coordinates.lat : coordinates.lat();
    var longitude = typeof coordinates.lat === 'number' ? coordinates.lng : coordinates.lng();

    document.getElementById('branch-latitude').value = latitude;
    document.getElementById('branch-longitude').value = longitude;

    if (prop.iconImage) {
        marker.setIcon(prop.iconImage);
    }

    if (prop.content) {
        let information = new google.maps.InfoWindow({
            content: prop.content
        });

        marker.addListener("click", function () {
            information.open(map, marker);
        });
    }
}

