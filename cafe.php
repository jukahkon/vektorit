<!DOCTYPE html>
<?php require("head.php") ?>
<?php require("session_handler.php") ?>

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDulVn9smDJoBkTRXBQ7D7Cy2wrfnz8rHY&sensor=false"></script>

<script type="text/javascript">

    $(document).ready( function () {

    });
    
</script>

<style>
    .media-body {
        margin-bottom: 20px;
    }
    
    #content {
        width: 60%;
        margin-left: auto;
        margin-right: auto;
    }
    
    #messageBox {
        width: 95%;
    }
    
    h4 {
        color: #555555;
    }

</style>

</head>

<body>
    <div id="container">
        
        <?php require("header.php"); createHeader("cafe"); ?>

        <div id="content">
            <form id="tripInputForm" class="well">
                <fieldset>
                    <label>Kirjoita viesti:</label>
                    <div class="controls">
                        <textarea id="messageBox" maxlength="140" rows="2"></textarea>
                    </div>							
                </fieldset>                            
                <button type="submit" class="btn btn-warning">Lähetä</button>
            </form>
           
            <div>
                <div class="media-body">
                    <h4 class="media-heading">Bart 24.1.2013 15:04</h4>
                        Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
                </div>
                <div class="media-body">
                    <h4 class="media-heading">JuhaK 23.1.2013 10:20</h4>
                        Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
                </div>
                <div class="media-body">
                    <h4 class="media-heading">Homer 22.1.2013 01:15</h4>
                        Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
                </div>
                    <div class="media-body">
                    <h4 class="media-heading">Bart 22.1.2013 21:01</h4>
                        Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
                </div>
                <button class="btn">Lisää viestejä</button>
            </div>

        </div>
        
        <?php require("footer.php") ?>

    </div>    
</body>
</html>
