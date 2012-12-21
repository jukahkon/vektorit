<!DOCTYPE html>
<?php require("head.php") ?>

</head>

<script type="text/javascript">

    $(document).ready( function () {
        $('#pass_error').hide();        
        $('#nick_error').hide();
        $('#user_error').hide();
        
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
            <div id="registration_container">
                <form id="registration_form" class="well">
                    <input name="op" type="hidden" value="register"></input>
                    <legend>Luo uusi tili</legend>
                    <fieldset>
                        <div class="control-group control-group-user">
                            <div class="controls">
                            <input name="user" class="input-xlarge" type="email" placeholder="Sähköpostiosoite" tabindex="1" autofocus required></input>
                            <span id="user_error" class="help-inline">Tili on jo olemassa.</span>
                            </div>
                        </div>
                        <div class="control-group control-group-nick">
                            <div class="controls">
                            <input name="nick" class="input-xlarge" type="text" placeholder="Nimimerkki" tabindex="2" required></input>
                            <span id="nick_error" class="help-inline">Varattu. Vaihda.</span>
                            </div>
                        </div>
                        <div class="control-group control-group-pass">
                            <div class="controls">
                            <input name="pass" class="input-xlarge" type="password" placeholder="Luo salasana" tabindex="2" required></input>
                            <span id="pass_error" class="help-inline">Tarkista salasana</span>
                            </div>
                        </div>
                        <div class="control-group control-group-pass">
                            <div class="controls">
                            <input name="pass2" class="input-xlarge" type="password" placeholder="Vahvista salasana" tabindex="2" required></input>
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


