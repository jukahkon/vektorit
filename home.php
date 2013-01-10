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
                <div id="map_controls_container">
                    <div id="map_controls">
                        <div id="total_km" class="map_control_label">Yhteensä: 652,15 km</div>
                        <div id="coordinates" class="map_control_label">Nizza: 2300,34 km</div>
                        <div id="arrival" class="map_control_label">Saapuminen: 25.8.2013</div>
                    </div>
                    
                    <div id="street_view_controls" style="display:none">
                        <button id="streetPlayButton" class="btn btn-info map-button">Play</button>
                        <div id="leg" class="map_control_label">Osuus: #1</div>
                        <div id="leg" class="map_control_label">Pvm: 5.1.2013</div>
                        <div id="leg" class="map_control_label">Osamatka: 62,50 km</div>                        
                    </div>
                    
                    <button id="mapModeButton" class="btn btn-warning map-button">Katutaso</button>                    
                </div>
                
                <div id="mapContainer">
                    <div id="map_canvas"></div>
                    <div id="street_view" style="display:none">
                        <img id="street_view_image" src="http://maps.googleapis.com/maps/api/streetview?size=640x480&location=65.012642,25.471491&heading=123&sensor=false"/>
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


