<?php

    ########################################################
    ###  Modifica navbar a seconda dello stato di login  ###
    ########################################################

    $user = '';
    if(Session::userLoggedIn()) {                                                   // se un utente è loggato, stampa
        $user  = '<li id="welcome-text">Bentornato ' . $_SESSION["user"] . '</li>';     // messaggio di bentornato
        $user .= '<li><a href="actions/logout.php" lang="en">Logout</a></li>';          // pulsante di logout
        $user .= '<li><a href="dashboard.php">Area personale</a></li>';                 // pulsante area personale

    } else {                                                                        // altrimenti stampa
        $user  = '<li><a href="login.php" lang="en">Login</a></li>';                    // pulsante di login
        $user .= '<li><a href="signup.php">Registrazione</a></li>';                     // pulsante di registrazione
    }

    $page  = str_replace('%LOGIN%', $user, $page);
    unset($user);


