<?php

function createHeader($page) {
    echo '<div id="header">';
        echo '<div class="navbar">';
            echo '<div class="navbar-inner">';
                echo '<a class="brand" href="home.php">Vektorit</a>';

                if ($page == "test") {
                    
                }
                else if ($page == "login") {
                    echo '<ul class="nav pull-right">';
                        echo '<li><p class="navbar-text">Oletko palvelun uusi käyttäjä?</p></li>';
                        echo '<li><button type="button" onclick="window.location.href=\'registration.php\'" class="btn btn-primary">Luo tili</button></li>';
                    echo '</ul>';
                }
                else if ($page != "registration") {
                    echo '<ul class="nav">';
                        if ($page == "home") {
                            echo '<li class="active">';
                        } else {
                            echo '<li>';
                        }
                        echo '<a href="home.php">Omat kilometrit</a></li>';
                        
                        if ($page == "team") {
                            echo '<li class="active">';
                        } else {
                            echo '<li>';
                        }
                        echo '<a href="team.php">Joukkueen tiedot</a></li>';
                                                
                        if ($page == "cafe") {
                            echo '<li class="active">';
                        } else {
                            echo '<li>';
                        }                        
                        echo '<a href="cafe.php">Vektorit Caf&#233;</a></li>';
                                                
                    echo '</ul>';
                                        
                    echo '<ul class="nav pull-right">';
                        echo '<li><p class="navbar-text">Tervetuloa ' . $_SESSION['nick'] . '!</p></li>';
                        echo '<li><button type="button" onclick="logout()" class="btn btn-primary">Kirjaudu ulos</button></li>';
                    echo '</ul>';
                }


            echo '</div>';
        echo '</div>';
    echo '</div>';
}

?>