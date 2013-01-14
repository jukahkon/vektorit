<!DOCTYPE html>
<?php require("head.php") ?>

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDulVn9smDJoBkTRXBQ7D7Cy2wrfnz8rHY&sensor=false"></script>
<script src="script/trip_table.js"></script>

</head>

<script type="text/javascript">

    $(document).ready( function () {
        $('#dateinput').datepicker( { showWeek : true, dateFormat: "yy-mm-dd" });
        $('#dateinput').datepicker( 'setDate', new Date() );
        
        $(".generateForm").submit( function() {
            console.log("generateUsersFrom submit");
            
            $.post("test_data_post.php", $(this).serialize(), function(status) {
                if (status!="ok") {
                    alert("Operation failed:" +status); 
                }
            });
            
            return false;
        });
        
        $("#resetUserTable").click( function(event) {
            console.log("resetUserTable");
            $.post("test_data_post.php", "op=removeAllUsers", function(status) {
                if (status!="ok") {
                    alert("Operation failed:" +status); 
                }
            });
            
            event.preventDefault();
        });
        
        $("#resetTripTable").click( function(event) {
            console.log("resetUserTable");
            $.post("test_data_post.php", "op=removeAllTrips", function(status) {
                if (status!="ok") {
                    alert("Operation failed:" +status); 
                }
            });
            
            event.preventDefault();
        });
    });
    
</script>

</head>

<body>
    <div id="container">
        
        <?php require("header.php"); createHeader("test"); ?>

        <div id="content">
            <div>
                <form class="generateForm" class="well form-horizontal">
                    <fieldset>
                        <legend>Generate Users</legend>
                    </fieldset>
                    <div class="control-group">
                        <label class="control-label">Select user count</label>
                        <div class="controls">
                            <input name="op" type="hidden" value="generateUsers"></input>
                            <input name="userCount" type="number" value="1" min="1" max="10"></input>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Generate</button>
                        <button id="resetUserTable" class="btn btn-danger">Reset Users Table</button>
                    </div>
                </form>
            </div>
            <div>
                <form class="generateForm" class="well form-horizontal">
                    <fieldset>
                        <legend>Generate Trips</legend>
                    </fieldset>
                    <input name="op" type="hidden" value="generateTrips"></input>
                    <div class="control-group">
                        <label class="control-label">Select user</label>
                        <div class="controls">
                            <select name="user" type="text">
                                <option>All</option>
                            </select>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Due date</label>
                        <div class="controls">
                            <input id="dateinput" name="dueDate" type="text"></input>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Select trip count</label>
                        <div class="controls">
                            <input name="tripCount" type="number" value="1" min="1" max="100"></input>
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Generate</button>
                        <button id="resetUserTable" class="btn btn-danger">Reset Trips Table</button>
                    </div>
                </form>
            </div>
        </div>
        
        <?php require("footer.php") ?>

    </div>    
</body>
</html>






