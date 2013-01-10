<!DOCTYPE html>
<?php require("head.php") ?>
<?php /*require("session_handler.php")*/ ?>

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDulVn9smDJoBkTRXBQ7D7Cy2wrfnz8rHY&sensor=false"></script>

</head>

<script type="text/javascript">

    $(document).ready( function () {

        resizeContent();
        initializeMap();
        
    });
    
    function initializeMap() {
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
        var mapHeight = contentHeight - $('#map_controls_container').height();
        $('#mapContainer').height(mapHeight);
    }    
    
</script>

</head>

<body onresize="resizeContent()">
    <div id="container">
        
        <?php require("header.php"); createHeader("team"); ?>

        <div id="content">
            <div id="dataPanel">
                <div id="dataTable">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th><th>Nimimerkki</th><th>Yhteensä</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr><td>1</td><td>Bart</td><td>3500 km</td></tr>
                            <tr><td>2</td><td>Marge</td><td>2998 km</td></tr>
                            <tr><td>3</td><td>Homer</td><td>1500 km</td></tr>
                            <tr><td>4</td><td>Jasper Beardly</td><td>50 km</td></tr>
                            <tr><td>5</td><td>Nn</td><td>0 km</td></tr>
                            <tr><td>6</td><td>Nn</td><td>0 km</td></tr>
                            <tr><td>7</td><td>Nn</td><td>0 km</td></tr>
                            <tr><td>8</td><td>Nn</td><td>0 km</td></tr>
                            <tr><td>9</td><td>Nn</td><td>0 km</td></tr>
                            <tr><td>10</td><td>Nn</td><td>0 km</td></tr>
                            <tr><td>11</td><td>Nn</td><td>0 km</td></tr>
                            <tr><td>12</td><td>Nn</td><td>0 km</td></tr>
                        </tbody>
                    </table>
                    <div id="pageSelector" class="pagination">
                        <ul>
                            <li><a href="#">Prev</a></li>
                            <li><a href="#">1</a></li>
                            <li><a href="#">2</a></li>
                            <li><a href="#">3</a></li>
                            <li><a href="#">4</a></li>
                            <li><a href="#">Next</a></li>
                        </ul>
                    </div>
                </div>                
            
            </div>
            
            <div id="mapPanel">
                <div id="map_controls_container">
                    <div id="map_controls">
                        <div id="total_km" class="map_control_label">Team Simpsons: 10800 km</div>
                    </div>                    
                </div>
                
                <div id="mapContainer">
                    <div id="map_canvas"></div>
                </div>                                                 
            </div>
        </div>
        
        <?php require("footer.php") ?>

    </div>    
</body>
</html>
