<!DOCTYPE html>
<?php require("head.php") ?>
<?php require("session_handler.php") ?>

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDulVn9smDJoBkTRXBQ7D7Cy2wrfnz8rHY&sensor=false"></script>
<script src="assets/imagesloaded/jquery.imagesloaded.min.js"></script>
<script src="script/trip_table.js"></script>
<script src="script/street_view.js"></script>
<script src="script/map_util.js"></script>

</head>

<script type="text/javascript">
    var map = null;
    var routeRenderer = null;
    var locationMarker = null;
    var directionsService = null;
    var tripPath = null;
    
    $(document).ready( function () {
        $('#dateinput').datepicker( { showWeek : true, dateFormat: "d.m.yy",
                                      altFormat: "yy-mm-dd", altField: "#alt_date" } );
        $('#dateinput').datepicker( 'setDate', new Date() );
             
        $("#tripInputForm").submit(handleTripSubmit);
        
        $('#distanceInput').keypress(function(event) {
            if (event.which != 44 && (event.which < 48 || event.which > 57))
            {
                event.preventDefault();
            }            
        });        

        $('#menuItemMapMode').click(event, function() {
            console.log("Change map mode");
            if ($('#street_view').is(':visible')) {
                $('#street_view').fadeOut(500);
                $('#street_view_controls').hide();
                $('#map_canvas').fadeIn(500);
                $('#map_controls').show();
                $("#menuItemMapMode").text('Katutaso');
            } else {
                $('#map_canvas').fadeOut(500);
                $('#map_controls').hide();
                $('#street_view').fadeIn(500);
                $('#street_view_controls').show();
                $("#menuItemMapMode").text('Kartta');
                prepareStreetView();
            }

            event.preventDefault();            
        });

        $('#menuItemShowRoute').click(event, function() {
            console.log("Show route!");
            showRouteOnMap();
            event.preventDefault();            
        });
        
        $('#menuItemOwnLocation').click(event, function() {
            alert("Not implemented yet!");            
            event.preventDefault();            
        });
        
        initializeMap();
        
        showRouteOnMap();        
        
        updateTripTable();
        
        updateStatusDisplay();
        
        window.setTimeout(showCurrentLocation, 3000);
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

            if ($('#street_view').is(':visible')) {
                prepareStreetView();
            } else {
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
                        strokeColor: "red" // "#269DFF"
                    });

                    tripPath.setMap(map);
                });                
            }
        }
    });

    function showCurrentLocation() {
        if (!map)
            return;
        
//        map.setCenter(new google.maps.LatLng(loc.lat, loc.lng));
//        map.setZoom(8);

        $.get("location_get.php", "", function(location) {
            var loc = JSON.parse(location);
            
            if (!locationMarker) {
                console.log("create marker!");
                locationMarker = new google.maps.Marker({
                    position: new google.maps.LatLng(loc.lat, loc.lng),
                    map: map,
                    title:"Your current location!",
                    icon: "images/cyclist_marker_red.png"
                });
            } else {
                locationMarker.setPosition(new google.maps.LatLng(loc.lat, loc.lng));
            }        
        });        
    }
    
    function updateStatusDisplay() {
        $.get("trip_get.php", "op=getTotalDistance", function(data) {
            var distanceData = JSON.parse(data);
            if (!distanceData.totalDistance) {
                distanceData.totalDistance = "0.00";
            }
            $("#total_sum").text(distanceData.totalDistance.replace(".",","));
            var distanceLeft = distanceData.routeLength - distanceData.totalDistance;
            distanceLeft = distanceLeft.toFixed(2);
            if (!distanceLeft) {                
                distanceLeft = "0.00";
            }
            
            $("#distance_left").text(distanceLeft.replace(".",","));
        });        
    }
        
    function prepareStreetView() {
        // find selected trip
        var tripDate = $("#tripRows td.selected").parent().attr("date");
        if (!tripDate) {
            $("#tripRows > tr:first-child > td").addClass("selected");
            tripDate = $("#tripRows > tr:first-child").attr("date");
        }

        console.log("prepareStreetView: " +tripDate);
        
        if (tripDate) {
            showSreetViewImages(tripDate);
        }        
    }
    
</script>

</head>

<body>
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
                        <tbody id="tripRows">
                        </tbody>
                    </table>
                    <div id="pageSelector" style="display:none">
                        <ul class="pager">
                            <li id="prevTripPage"><a href="#" onclick="previousTripPage(); return false;">Edellinen</a></li>
                            <li id="nextTripPage"><a href="#" onclick="nextTripPage(); return false;">Seuraava</a></li>
                        </ul>
                    </div>
                </div>                
            
            </div>            

            <div id="mapPanel">
                <div id="map_controls_container">
                    
                    <div id="map_controls">
                        <div class="map_control_label">Yhteensä: <strong id="total_sum"></strong> km</div>
                        <div class="map_control_label">Nizza: <strong id="distance_left"></strong> km</div>
                    </div>
                    
                    <div id="street_view_controls" style="display:none">
                        <div class="map_control_label">Pvm: <span id="sv_date"></span></div>
                        <div class="map_control_label">Kuva: <span id="sv_images"></span></div>
                    </div>
                    
                    <div id="mapOptions" class="dropdown">
                        <a id="foo" class="map_control_label" data-toggle="dropdown" href="#">Valinnat<b class="caret"></b></a>
                        <ul id="menu1" class="dropdown-menu" role="menu" aria-labelledby="drop4">
                            <li><a id="menuItemMapMode" href="#">Katunäkymä</a></li>
                            <li><a id="menuItemOwnLocation" href="#">Sijaintitiedot</a></li>
                        </ul>
                    </div>
                    
                </div>

                <div id="mapContainer">

                    <div id="map_canvas"></div>

                    <div id="street_view" style="display:none">
                        <div id="imageContainer"></div>
                        <div id="streetSign">
                            <div class="streetSignText">Oulu <span id="toStart"></span> km</div>
                            <div class="streetSignText">Nizza <span id="toFinish"></span> km</div>
                            <img class="streetSignIcon" src="images/arrow_down.png"></img>
                        </div>
                        <div id="playbackButton" onclick="svPlay()">
                            <img class="playbackIcon" src="images/playback.png"></img>
                        </div>                        
                    </div>
                </div>                                                 

            </div>

            <div style="clear: both"></div>
        </div>
        
        <?php require("footer.php") ?>
        
    </div>    
</body>
</html>

