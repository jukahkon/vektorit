<!DOCTYPE html>
<?php 
require("head.php");
require("session_handler.php");
require('db_util.php');

$teamName = DbUtil::teamname($_SESSION['team_id']);
?>

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDulVn9smDJoBkTRXBQ7D7Cy2wrfnz8rHY&sensor=false"></script>
<script src="script/team_table.js"></script>
<script src="script/map_util.js"></script>

</head>

<script type="text/javascript">
    var userId = <?php echo $_SESSION["user_id"] . ";" ?>
    
    var markers = [];

    $(document).ready( function () {
        updateTeamTable();
        
        initializeMap();
        
        setTimeStamp();
        
        showRouteOnMap();
        
        $('#menuItemUpdate').click(event, function() {
            updateTeamTable();
            showTeamLocationsOnMap();            
            event.preventDefault();            
        });

        window.setTimeout(showTeamLocationsOnMap, 1000);
    });
    
    function showTeamLocationsOnMap() {
        console.log("showTeamLocationsOnMap():");
        $.get("team_get.php", "op=getTeamLocations", function(data) {
            console.log(data);
            var locations = JSON.parse(data);

            for (var j=0; j<markers.length; j++) {
                markers[j].setMap(null);
            }
            
            markers.length = 0;
            
            for (var i=0; i < locations.length; i++) {
                var loc = locations[i];
                var marker = new google.maps.Marker({
                    position: new google.maps.LatLng(loc.lat, loc.lng),
                    map: map,
                    title: loc.nickname,
                    icon: loc.id == userId ? "images/cyclist_marker_red.png" : "images/cyclist_marker_blue.png"
                });
                
                markers.push(marker);
            }                       
        });        
    }
    
    function setTimeStamp() {
        var dateTime = new Date();
        var date = dateTime.toLocaleDateString();
        var time = dateTime.toLocaleTimeString();
        
        $("#mapTimeStamp").text(date + " " + time);
    }
    
</script>

</head>

<body>
    <div id="container">
        
        <?php require("header.php"); createHeader("team"); ?>

        <div id="content">
            <div id="dataPanel">
                <div id="dataTable">
                    <h3><?php echo $teamName ?></h3>
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th><th>Nimimerkki</th><th>Kilometrit</th>
                            </tr>
                        </thead>
                        <tbody id="teamRows">
                        </tbody>
                    </table>
                    <div id="pageSelector" style="display:none">
                        <ul class="pager">
                            <li id="prevMemberPage"><a href="#" onclick="previousMemberPage(); return false;">Edellinen</a></li>
                            <li id="nextMemberPage"><a href="#" onclick="nextMemberPage(); return false;">Seuraava</a></li>
                        </ul>
                    </div>
                </div>                
            
            </div>
            
            <div id="mapPanel">
                <div id="map_controls_container">
                    
                    <div id="map_controls">
                        <div class="map_control_label">Tilanne <span id="mapTimeStamp"></span></div>
                    </div>
                    
                    <div id="mapOptions" class="dropdown">
                        <a id="foo" class="map_control_label" data-toggle="dropdown" href="#">Valinnat<b class="caret"></b></a>
                        <ul id="menu1" class="dropdown-menu" role="menu" aria-labelledby="drop4">
                            <li><a id="menuItemUpdate" href="#">Päivitä</a></li>
                        </ul>
                    </div>
                    
                </div>
                
                <div id="mapContainer">
                    <div id="map_canvas"></div>
                </div>                                                 
            </div>
            
            <div style="clear: both"></div>
        </div>
        
        <?php require("footer.php") ?>

    </div>    
</body>
</html>
