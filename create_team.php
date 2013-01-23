<!DOCTYPE html>
<?php require("head.php") ?>

</head>

<script type="text/javascript">

    $(document).ready( function () {
        $('#pass_error').hide();        
        $('#team_error').hide();
        
        $('#registration_form').submit(function() {
            console.log("Submit: " + $(this).serialize());
            
            $.post("admin.php", $(this).serialize(), function(data) {
                console.log("response: " + data);
                if (data == "already_registered") {
                    $('.control-group-user').addClass('error');
                    $('#team_error').show();
                    $('input[name="team"]').one("keypress", function() {
                        $('.control-group-user').removeClass('error');
                        $('#user_error').hide();
                    });
                }                
                else if (data == "pass_not_match") {
                    $('input[type="password"]').val('')
                    $('input[name="pass"]').focus();
                    $('.control-group-pass').addClass('error');
                    $('#pass_error').show();                    
                    $('input[name="pass"]').one("keypress", function() {
                        $('.control-group-pass').removeClass('error');
                        $('#pass_error').hide();
                    });
                } else if (data == "ok") {
                    window.location.href = "registration.php";
                }
            });
            
            return false;
        });
                
    });
    
</script>

</head>

<body>
    <div id="container">
        
        <?php require("header.php"); createHeader("registration"); ?>

        <div id="content">
            
            <div id="team_create_container">
                <form id="registration_form" class="well">
                    <input name="op" type="hidden" value="create_team"></input>
                    <legend>Luo uusi joukkue</legend>
                    <fieldset>
                        <div class="control-group control-group-user">
                            <div class="controls">
                                <input name="team" class="input-xlarge" autocomplete="off" type="text" placeholder="Joukkueen nimi" tabindex="1" autofocus required></input>
                                <span id="team_error" class="help-inline">Joukkue on jo olemassa.</span>
                            </div>
                        </div>
                        <div class="control-group control-group-pass">
                            <div class="controls">
                                <input name="pass" class="input-xlarge" autocomplete="off" type="password" placeholder="Luo salasana" tabindex="3" required></input>
                                <span id="pass_error" class="help-inline">Tarkista salasana</span>
                            </div>
                        </div>
                        <div class="control-group control-group-pass">
                            <div class="controls">
                                <input name="pass2" class="input-xlarge" autocomplete="off" type="password" placeholder="Vahvista salasana" tabindex="4" required></input>
                            </div>
                        </div>
                        <div class="control-group">
                            <button type="submit" class="btn btn-primary">Luo uusi joukkue</button>
                        </div>
                    </fieldset>							                    
                </form>
            </div>            
  
        </div>
        
        <?php require("footer.php") ?>

    </div>    
</body>



