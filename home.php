<!DOCTYPE html>
<?php require("head.php") ?>
<?php /*require("session_handler.php")*/ ?>

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDulVn9smDJoBkTRXBQ7D7Cy2wrfnz8rHY&sensor=false"></script>

</head>

<script type="text/javascript">

    $(document).ready( function () {
        $('#dateinput').datepicker( { showWeek : true, dateFormat: "d.m.yy" } );
        $('#dateinput').datepicker( 'setDate', new Date() );        
        
        resizeContent();
        initializeMap();
    });
    
    function initializeMap() {
        // return;
        
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
        var mapHeight = contentHeight - $('#map_controls').height() - $('#map_controls_bottom').height();
        $('#map_canvas').height(mapHeight);
    }    
    
</script>

</head>

<body onresize="resizeContent()">
    <div id="container">
        
        <?php require("header.php"); createHeader("home"); ?>

        <div id="content">
            <div id="dataPanel">
                <div id="dataInput">
                    <form class="well">
                        <fieldset>
                            <label>Päivämäärä</label>
                            <div class="controls">
                                <input id="dateinput" type="text"></input>
                            </div>
                            <label>Kilometrit</label>
                                <input type="text" placeholder="0,00"></input>
                            </fieldset>							
                        <button type="submit" class="btn btn-success">Päivitä</button>
                    </form>
                </div>
                
                <div id="dataTable">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th><th>Päivämäärä</th><th>Kilometrit</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr><td>1</td><td>5.1.2013</td><td>62,50</td></tr>
                            <tr><td>2</td><td>5.1.2013</td><td>62,50</td></tr>
                            <tr><td>3</td><td>5.1.2013</td><td>62,50</td></tr>
                            <tr><td>4</td><td>5.1.2013</td><td>62,50</td></tr>
                            <tr><td>5</td><td>5.1.2013</td><td>62,50</td></tr>
                            <tr><td>6</td><td>5.1.2013</td><td>62,50</td></tr>
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
                <div id="map_controls">
                    <div id="total_km">Total: 652,15 km</div>
                    <div id="coordinates">25.123456, 63.123456</div>
                    
                    <button id="cameraButton" class="btn btn-inverse icon-camera"></button>
                    
                </div>    
                <div id="map_canvas">
                    
                </div>
                <div id="map_controls_bottom">
                </div>
            </div>
        </div>
        
        <?php require("footer.php") ?>

    </div>    
</body>


