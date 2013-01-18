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
                        echo '<a href="team.php">Oma joukkue</a></li>';
                                                
                        if ($page == "messages") {
                            echo '<li class="active">';
                        } else {
                            echo '<li>';
                        }                        
                        echo '<a href="messages.php">Vektorit Caf&#233;</a></li>';
                        
                        echo '<li class="dropdown">';
                            echo '<a class="dropdown-toggle" id="drop4" role="button" data-toggle="dropdown" href="#">Dropdown <b class="caret"></b></a>';
                            echo '<ul id="menu1" class="dropdown-menu" role="menu" aria-labelledby="drop4">';
                              echo '<li><a tabindex="-1" href="#">Action</a></li>';
                              echo '<li><a tabindex="-1" href="#">Another action</a></li>';
                              echo '<li><a tabindex="-1" href="#">Something else here</a></li>';
                              echo '<li class="divider"></li>';
                              echo '<li><a tabindex="-1" href="#">Separated link</a></li>';
                            echo '</ul>';
                        echo '</li>';
                        
                    echo '</ul>';
                                        
                    echo '<ul class="nav pull-right">';
                        echo '<li><p class="navbar-text">Hei Nimimerkki!</p></li>';
                        echo '<li><button type="button" onclick="logout()" class="btn btn-primary">Kirjaudu ulos</button></li>';
                    echo '</ul>';
                }


            echo '</div>';
        echo '</div>';
    echo '</div>';
}

?>