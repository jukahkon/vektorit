<!DOCTYPE html>
<?php 
session_start();
require("head.php") 
?>

</head>

<body>
    <div id="container">
        
        <?php require("header.php"); createHeader("login"); ?>
        
        <?php
            $login_status = "";
            if (isset($_SESSION["login_status"])) {
                $login_status = $_SESSION["login_status"];
            }
        ?>

        <div id="content">
            <div id="login_container">
                <form class="well" action="admin.php" method="POST">
                    <input name="op" type="hidden" value="login"></input>
                    <legend>Kirjaudu sisään</legend>
                    <fieldset>
                        <div class="control-group <?php if ($login_status == "account_not_found") { echo 'error'; } ?>">
                            <div class="controls">
                            <?php 
                                if ($login_status == "account_not_found") { echo '<span id="pass_error" class="help-inline">Tarkista sähköpostiosoite</span>'; }
                            ?>
                            <input name="user" class="input-xlarge" type="email" placeholder="Sähköpostiosoite"
                                   tabindex="1" autofocus required <?php if ($login_status) { echo "value='$_SESSION[login_email]'"; } ?> ></input>                            
                            </div>
                        </div>
                        <div class="control-group <?php if ($login_status == "incorrect_password") { echo 'error'; } ?>">
                            <div class="controls">
                            <?php 
                                if ($login_status == "incorrect_password") { echo '<span id="pass_error" class="help-inline">Tarkista salasana</span>'; }
                                unset($_SESSION["login_status"]);
                                unset($_SESSION["login_email"]);
                            ?>
                            <input name="pass" class="input-xlarge" type="password" placeholder="Salasana" tabindex="2" required></input>
                            </div>
                        </div>
                        <div class="control-group">
                            <button type="submit" class="btn btn-primary">Kirjaudu sisään</button>
                        </div>    
                    </fieldset>							                    
                </form>
            </div>
        </div>
        
        <?php require("footer.php") ?>

    </div>    
</body>

