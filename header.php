<?php

function createHeader($page) {
    echo '<div id="header">';
    echo '<div class="navbar">';
        echo '<div class="navbar-inner">';
            echo '<a class="brand" href="index.php">Sports Logger</a>';
            
            if ($page == "login") {
                echo '<ul class="nav pull-right">';
                    echo '<li><p class="navbar-text">Oletko palvelun uusi käyttäjä?</p></li>';
                    echo '<li><button type="submit" onclick="window.location.href=\'registration.php\'" class="btn btn-primary">Luo tili</button></li>';
                echo '</ul>';
            }
        echo '</div>';
    echo '</div>';
    echo '</div>';
}

?>