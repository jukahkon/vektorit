<!DOCTYPE html>
<?php require("head.php") ?>
<?php require("session_handler.php") ?>

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDulVn9smDJoBkTRXBQ7D7Cy2wrfnz8rHY&sensor=false"></script>

</head>

<script type="text/javascript">

    $(document).ready( function () {

        resizeContent();
        initializeMap();
        
    });
    
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
        
        <?php require("header.php"); createHeader("messages"); ?>

        <div id="content">            
        </div>
        
        <?php require("footer.php") ?>

    </div>    
</body>
</html>
