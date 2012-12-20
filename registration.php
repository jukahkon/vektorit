<!DOCTYPE html>
<?php require("head.php") ?>
<?php require("db_connect.php") ?>

</head>

<body>
    <div id="container">
        
        <?php require("header.php"); createHeader("registration"); ?>

        <div id="content">
            <div id="registration_container">
                <form class="well">
                    <legend>Luo uusi tili</legend>
                    <fieldset>
                        <div class="control-group">
                            <div class="controls">
                            <input id="user" class="input-xlarge" type="email" placeholder="Sähköpostiosoite" tabindex="1" autofocus required></input>
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="controls">
                            <input id="pass" class="input-xlarge" type="text" placeholder="Nimimerkki" tabindex="2" required></input>
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="controls">
                            <input id="pass" class="input-xlarge" type="password" placeholder="Luo salasana" tabindex="2" required></input>
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="controls">
                            <input id="pass" class="input-xlarge" type="password" placeholder="Vahvista salasana" tabindex="2" required></input>
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


