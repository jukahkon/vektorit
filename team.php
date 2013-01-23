<!DOCTYPE html>
<?php 
require("head.php");
require("session_handler.php");
require('db_util.php');

$teamName = DbUtil::teamname($_SESSION['team_id']);
?>

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDulVn9smDJoBkTRXBQ7D7Cy2wrfnz8rHY&sensor=false"></script>
<script src="script/team_table.js"></script>

</head>

<script type="text/javascript">

    $(document).ready( function () {

        resizeContent();
        initializeMap();
                
        updateTeamTable();        
    });
    
    function initializeMap() {
        return;
        
        // create map
        var mapOptions = {
            center: new google.maps.LatLng(65.017, 25.467),
            zoom: 15,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            disableDefaultUI: true
	};
	
	var map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
    }
    
    function resizeContent() {
        console.log("Container height: " +$('#container').height());
        console.log("Header height: " +$('#header').outerHeight(true));
        console.log("Footer height: " +$('#footer').outerHeight(true));
        var contentHeight = $('#container').height() - $('#header').outerHeight(true) - $('#footer').outerHeight(true);
        $('#content').height(contentHeight);
        console.log("Content height: " +contentHeight);
        $('#mapContainer').height(contentHeight);
    }    
    
</script>

</head>

<body onresize="resizeContent()">
    <div id="container">
        
        <?php require("header.php"); createHeader("team"); ?>

        <div id="content">
            <div id="dataPanel">
                <div id="dataTable">
                    <h3><?php echo $teamName ?></h3>
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th><th>Nimimerkki</th><th>Yhteensä</th>
                            </tr>
                        </thead>
                        <tbody id="teamRows">
                        </tbody>
                    </table>
                    <div id="pageSelector" class="pagination" style="display:none">
                        <ul id="pageList">
                        </ul>
                    </div>
                </div>                
            
            </div>
            
            <div id="mapPanel">
                <div id="mapContainer">
                    <div id="map_canvas"></div>
                </div>                                                 
            </div>
        </div>
        
        <?php require("footer.php") ?>

    </div>    
</body>
</html>
