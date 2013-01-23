<!DOCTYPE html>
<?php require("head.php") ?>

</head>

<script type="text/javascript">

    $(document).ready( function () {
        $('#pass_error').hide();        
        $('#nick_error').hide();
        $('#user_error').hide();
        $('#team_error').hide();
        $('#team_pass_error').hide();
        
        $('#registration_form').submit(function() {
            console.log("Submit: " + $(this).serialize());
            
            $.post("admin.php", $(this).serialize(), function(data) {
                console.log("response: " + data);
                if (data == "already_registered") {
                    $('.control-group-user').addClass('error');
                    $('#user_error').show();
                    $('input[name="user"]').one("keypress", function() {
                        $('.control-group-user').removeClass('error');
                        $('#user_error').hide();
                    });
                } else if (data == "nick_in_use") {
                    $('.control-group-nick').addClass('error');
                    $('#nick_error').show();
                    $('input[name="nick"]').one("keypress", function() {
                        $('.control-group-nick').removeClass('error');
                        $('#nick_error').hide();
                    })
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
                } else if (data == "team_not_found") {
                    $('.control-group-team').addClass('error');
                    $('#team_error').show();
                    $('input[name="team"]').one("keypress", function() {
                        $('.control-group-team').removeClass('error');
                        $('#team_error').hide();
                    })
                } else if (data == "incorrect_team_password") {
                    $('input[name="team-pass"]').val('')
                    $('.control-group-team-pass').addClass('error');
                    $('#team_pass_error').show();
                    $('input[name="team"]').one("keypress", function() {
                        $('.control-group-team-pass').removeClass('error');
                        $('#team_pass_error').hide();
                    })
                } else if (data == "ok") {
                    window.location.href = "home.php";
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
            
            <div style="float: right; margin-right: 10px">
                <a href="create_team.php">Luo uusi joukkue täällä!</a>
            </div>
            <div style="clear: both"></div>

            <div id="registration_container">
                <form id="registration_form" class="well">
                    <input name="op" type="hidden" value="register"></input>
                    <legend>Luo uusi tili</legend>
                    <fieldset>
                        <div class="control-group control-group-user">
                            <div class="controls">
                                <input name="user" class="input-xlarge" autocomplete="off" type="email" placeholder="Sähköpostiosoite" tabindex="1" autofocus required></input>
                                <span id="user_error" class="help-inline">Tili on jo olemassa.</span>
                            </div>
                        </div>
                        <div class="control-group control-group-nick">
                            <div class="controls">
                                <input name="nick" class="input-xlarge" autocomplete="off" type="text" placeholder="Nimimerkki" tabindex="2" required></input>
                                <span id="nick_error" class="help-inline">Varattu. Vaihda.</span>
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
                        <div class="control-group control-group-team">
                            <div class="controls">
                                <input name="team" class="input-xlarge" autocomplete="off" type="text" placeholder="Joukkueen nimi" tabindex="5" required></input>
                                <span id="team_error" class="help-inline">Tarkista joukkue</span>
                            </div>
                        </div>
                        <div class="control-group control-group-team-pass">
                            <div class="controls">
                                <input name="team-pass" class="input-xlarge" autocomplete="off" type="password" placeholder="Joukkueen salasana" tabindex="6" required></input>
                                <span id="team_pass_error" class="help-inline">Tarkista salasana</span>
                            </div>
                        </div>
                        <div class="control-group">
                            <button type="submit" class="btn btn-primary">Luo uusi tili</button>
                        </div>
                    </fieldset>							                    
                </form>
            </div>            
  
        </div>
        
        <?php require("footer.php") ?>

    </div>    
</body>


