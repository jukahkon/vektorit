<!DOCTYPE html>
<?php require("head.php") ?>
<?php require("session_handler.php") ?>

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDulVn9smDJoBkTRXBQ7D7Cy2wrfnz8rHY&sensor=false"></script>

</head>

<script type="text/javascript">

    $(document).ready( function () {

        initializeMap();
        
    });
    
</script>

</head>

<body onresize="resizeContent()">
    <div id="container">
        
        <?php require("header.php"); createHeader("cafe"); ?>

        <div id="content">
           
            <div id="dataPanel">
                <div id="dataInput">
                    <form id="tripInputForm" class="well">
                        <fieldset>
                            <label>Kirjoita viesti:</label>
                            <div class="controls">
                                <textarea id="textarea" maxlength="140" rows="5"></textarea>
                            </div>							
                        </fieldset>                            
                        <button type="submit" class="btn btn-warning">Lähetä</button>
                    </form>
                </div>                
            </div>            

            <div id="messagePanel">
                <div class="media-body">
                    <h4 class="media-heading">24.1.2013 Bart:</h4>
                        Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
                </div>
                <div class="media-body">
                    <h4 class="media-heading">23.1.2013 Juha:</h4>
                        Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
                </div>
                <div class="media-body">
                    <h4 class="media-heading">22.1.2013 Homer:</h4>
                        Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
                </div>
                    <div class="media-body">
                    <h4 class="media-heading">22.1.2013 Bart:</h4>
                        Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
                </div>
            </div>
                

            <div style="clear: both"></div>
        </div>
        
        <?php require("footer.php") ?>

    </div>    
</body>
</html>
