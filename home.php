<!DOCTYPE html>
<?php require("head.php") ?>
<?php require("session_handler.php") ?>

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDulVn9smDJoBkTRXBQ7D7Cy2wrfnz8rHY&sensor=false"></script>
<script src="script/trip_table.js"></script>

</head>

<script type="text/javascript">
    var map = null;
    var routeRenderer = null;
    var locationMarker = null;
    var directionsService = null;
    var tripPath = null;
    
    $(document).ready( function () {
        $('#dateinput').datepicker( { showWeek : true, dateFormat: "d.m.yy", altFormat: "yy-mm-dd", altField: "#alt_date" } );
        $('#dateinput').datepicker( 'setDate', new Date() );
        
        resizeContent();
        initializeMap();
        
        $("#mapModeButton").click( function() {
            console.log("Change map mode");
            if ($('#street_view').is(':visible')) {
                $('#street_view').hide();
                $('#street_view_controls').hide();
                $('#map_canvas').show();
                $('#map_controls').show();
                $("#mapModeButton").text('Katutaso');
            } else {
                $('#map_canvas').hide();
                $('#map_controls').hide();
                $('#street_view').show();
                $('#street_view_controls').show();
                $("#mapModeButton").text('Kartta');
            }
        });
        
        $("#tripInputForm").submit( function() {
            var value = $('#distanceInput').val().replace(",",".");
            if (!value) {
                value = "0";
            }
            var distance = parseFloat(value);
            if (isNaN(distance)) {
                return false;
            }
            
            var distance = distance.toFixed(2);            
            var params = "date=" + $('#alt_date').val();
            params += "&distance=" + distance.toString();            
            console.log("Handle trip submit: " + params);
            
            $.post("trip_post.php", params, function(status) {
                if (status=="ok") {
                    updateTripTable();
                    updateStatusDisplay();
                }
            });
            
            return false;
        });
        
        $('#distanceInput').keypress(function(event) {
            if (event.which != 44 && (event.which < 48 || event.which > 57))
            {
                event.preventDefault();
            }            
        });        
        
        updateTripTable();
        
        updateStatusDisplay();

    });
    
    $(document).on("click","#tripRows tr",{}, function() {
        if (tripPath) {
            tripPath.setMap(null);
            tripPath = null;
        }            
        
        var highlight = $(this).find("td");
        
        if (highlight.hasClass("selected")) {
            highlight.removeClass("selected");
        } else {
            $("#tripRows").find("td").removeClass("selected");
            highlight.addClass("selected");
            
            var param = "op=getTripSteps&";
            param += "date=" + $(this).attr("date");
            
            $.get("trip_get.php", param, function(data) {
                var steps = JSON.parse(data);

                var coords = [];
                for (var i=0; i < steps.length; i++) {
                    var step = steps[i];
                    console.log("Step: " + JSON.stringify(step));
                    coords.push(new google.maps.LatLng(step.lat, step.lng));
                }

                tripPath = new google.maps.Polyline({
                    path: new google.maps.MVCArray(coords),
                    strokeWeight: 4.0,
                    strokeColor: "red"                
                });

                tripPath.setMap(map);
            });
        }
    });

    function initializeMap() {
        // return;        
        
        // create map
        var mapOptions = {
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            disableDefaultUI: true
	};
	
	map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
        
        directionsService = new google.maps.DirectionsService();
        
        showRouteOnMap();
    }
    
    function resizeContent() {
        console.log("Container height: " +$('#container').height());
        console.log("Header height: " +$('#header').outerHeight(true));
        console.log("Footer height: " +$('#footer').outerHeight(true));
        var contentHeight = $('#container').height() - $('#header').outerHeight(true) - $('#footer').outerHeight(true);
        $('#content').height(contentHeight);
        var mapHeight = contentHeight - $('#map_controls_container').height();
        $('#mapContainer').height(mapHeight);
    }
    
    function showCurrentLocation(loc) {
        if (!map)
            return;
        
        // map.setCenter(new google.maps.LatLng(loc.lat, loc.lng));        
        
        if (!locationMarker) {
            console.log("create marker!");
            locationMarker = new google.maps.Marker({
                position: new google.maps.LatLng(loc.lat, loc.lng),
                map: map,
                title:"Your current location!",
                icon: "images/cyclist_marker.png"
            });
        } else {
            locationMarker.setPosition(new google.maps.LatLng(loc.lat, loc.lng));
        }
        
    }
    
    function updateStatusDisplay() {
        $.get("trip_get.php", "op=getTotalDistance", function(distance) {
            $("#total_sum").text(distance.replace(".",","));
        });
        
        $.get("location_get.php", "", function(location) {
            console.log("Location: " +JSON.stringify(location));
            var l = JSON.parse(location);
            $("#latitude").text(l.lat);
            $("#longitude").text(l.lng);
            $("#heading").text(l.heading);
            
            showCurrentLocation(l);
        });
    }
    
    function showRouteOnMap() {
        if (!routeRenderer) {
            options = {
                polylineOptions: { strokeColor : "black", strokeOpacity: 0.5 },
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
                origin: new google.maps.LatLng(65.012642,25.471491),
                destination: new google.maps.LatLng(65.736313,24.56432),
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
                icon: "images/start_marker.png"
            });
            
            new google.maps.Marker({
                position: new google.maps.LatLng(dest.lat, dest.lng),
                map: map,
                title:"MAALI",
                icon: { url: "images/finish_marker.png", anchor: {x:0,y:60} }
            });
        });
    }
    
</script>

</head>

<body onresize="resizeContent()">
    <div id="container">
        
        <?php require("header.php"); createHeader("home"); ?>

        <div id="content">
            <div id="dataPanel">
                <div id="dataInput">
                    <form id="tripInputForm" class="well">
                        <fieldset>
                            <label>Päivämäärä</label>
                            <div class="controls">
                                <input id="dateinput" type="text"></input>
                                <input id="alt_date" type="hidden"></input>
                            </div>
                            <label>Kilometrit</label>
                                <input id="distanceInput" type="text" placeholder="0,00"></input>
                            </fieldset>							
                        <button type="submit" class="btn btn-success">Päivitä</button>
                    </form>
                </div>
                
                <div id="dataTable" style="display:none">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th><th>Päivämäärä</th><th>Kilometrit</th>
                            </tr>
                        </thead>
                        <tbody id= "tripRows">
                        </tbody>
                    </table>
                    <div id="pageSelector" class="pagination" style="display:none">
                        <ul id="pageList">
                        </ul>
                    </div>
                </div>                
            
            </div>
            
            <div id="mapPanel">
                <div id="map_controls_container">
                    <div id="map_controls">
                        <div class="map_control_label">Yhteensä: <strong id="total_sum"></strong> km</div>
                        <div class="map_control_label">Lat: <strong id="latitude"></strong></div>
                        <div class="map_control_label">Lng: <strong id="longitude"></strong></div>
                        <div class="map_control_label">Heading: <strong id="heading"></strong></div>                        
                    </div>
                    
                    <div id="street_view_controls" style="display:none">
                        <div id="leg" class="map_control_label">Osuus: #1</div>
                        <div id="leg1" class="map_control_label">Pvm: 5.1.2013</div>
                        <div id="leg2" class="map_control_label">Osamatka: 62,50 km</div>
                        <button id="streetPlayButton" class="btn btn-info map-button">Play</button>
                    </div>
                    
                    <button id="mapModeButton" class="btn btn-warning map-button">Katutaso</button>                    
                </div>
                
                <div id="mapContainer">
                    <div id="map_canvas"></div>
                    <div id="street_view" style="display:none">
                        <!-- src="http://maps.googleapis.com/maps/api/streetview?size=640x480&location=65.012642,25.471491&heading=123&sensor=false"-->
                        <img id="street_view_image" />
                        <div id="streetSign">
                            <div class="streetSignText">Tukholma 350 km</div>
                            <div class="streetSignText">Nizza 2560 km</div>
                            <img class="streetSignIcon" src="images/arrow_down.png"></img>
                        </div>                        
                    </div>
                </div>                                                 
            </div>
        </div>
        
        <?php require("footer.php") ?>

    </div>    
</body>
</html>

