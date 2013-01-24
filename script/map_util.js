var map = null;
var routeRenderer = null;
var directionsService = null;

function initializeMap() {

    // create map
    var mapOptions = {
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        disableDefaultUI: true
    };

    map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
}

function showRouteOnMap() {
    if (!directionsService) {
        directionsService= new google.maps.DirectionsService();
    }

    if (!routeRenderer) {
        options = {
            suppressMarkers: true
        };

        routeRenderer = new google.maps.DirectionsRenderer(options);
        routeRenderer.setMap(map);
    }


    $.get("route_get.php", "", function(data) {
        var waypoints = JSON.parse(data);
        var orig = waypoints[0];
        var dest = waypoints[waypoints.length-1];

        console.log("Waypoints: " + JSON.stringify(waypoints));
        var request = {
            origin: new google.maps.LatLng(orig.lat,orig.lng),
            destination: new google.maps.LatLng(dest.lat,dest.lng),
            travelMode: google.maps.TravelMode.DRIVING
        };

        console.log("Route req: " + JSON.stringify(request));

        directionsService.route(request, function(result,status){
            if (status === google.maps.DirectionsStatus.OK) {
                routeRenderer.setDirections(result);
            } else {
                console.log("showRouteOnMap failed: " +status);
            }
        });

        // create start and finish markers
        new google.maps.Marker({
            position: new google.maps.LatLng(orig.lat, orig.lng),
            map: map,
            title:"LÄHTÖ",
            icon: { url: "images/start_marker.png", anchor: {x:3,y:60} }
        });

        new google.maps.Marker({
            position: new google.maps.LatLng(dest.lat, dest.lng),
            map: map,
            title:"MAALI",
            icon: { url: "images/finish_marker.png", anchor: {x:0,y:60} }
        });
    });
}
