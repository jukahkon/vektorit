<!DOCTYPE html>
<?php require("head.php") ?>

</head>

<body>
    <div id="container">
        
        <?php require("header.php"); createHeader("login"); ?>

        <div id="content">
            <div id="login_container">
                <form class="well">
                    <legend>Kirjaudu sisään</legend>
                    <fieldset>
                        <div class="control-group">
                            <div class="controls">
                            <input id="user" class="input-xlarge" type="email" placeholder="Sähköpostiosoite" tabindex="1" autofocus></input>
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="controls">
                            <input id="pass" class="input-xlarge" type="password" placeholder="Salasana" tabindex="2"></input>
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

