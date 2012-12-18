<!DOCTYPE html>
<head>
    <meta charset="UTF-8" />
    <link href="assets/bootstrap/themes/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="css/vektorit.css" rel="stylesheet" media="screen">
    
    <script src="assets/jquery/jquery-1.8.3.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    
</head>

<body>
    <div id="container">
        
        <div id="header">
            <div class="navbar">
                <div class="navbar-inner">
                    <a class="brand" href="#">Vektor IT</a>
                    
                    <ul class="nav pull-right">
                        <li><p class="navbar-text">Oletko palvelun uusi käyttäjä?</p></li>
                        <li><button type="submit" onclick="window.location.href='registration.php'" class="btn btn-primary">Luo tili</button></li>
                    </ul>
		</div>
            </div>
        </div>

        <div id="content">
            <div id="login_container">
                <form class="well">
                    <legend>Kirjaudu sisään</legend>
                    <fieldset>
                        <div class="control-group">
                            <div class="controls">
                            <input id="user" class="input-xlarge" type="email" placeholder="Sähköposti" tabindex="1" autofocus></input>
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
        <hr>
        <footer style="text-align: center">
            <a target="_blank">support@vektorit.fi</a>        
        </footer>

    </div>    
</body>










