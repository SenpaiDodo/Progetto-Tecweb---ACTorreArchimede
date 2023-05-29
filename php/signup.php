<?php
    
    require_once("helpers/Utils.php");
    require_once("helpers/Session.php");
    require_once("helpers/DBAccess.php");
    require_once("helpers/Errors.php");

    Session::session_start();

	Utils::sanitizeInput();


    ##########################
    ###  Gestione accessi  ###
    ##########################

    if(Session::userLoggedIn()) {
        header('location: dashboard.php');
        die();
    }


    #######################
    ###  Render pagina  ###
    #######################
    
    $breadcrumb = '<li aria-current="page">Registrazione</li>';

    $page  = Utils::template_replace("%TITLE%", "Registrazione | A.C. Torre Archimede", "../html/head.html");
    $page .= Utils::template_replace("%PAGENAME%", $breadcrumb, "../html/navbar.html");

    require_once("../php/navbar.php");

    $page = str_replace('><a href="signup.php">Registrazione</a>', ' id="current_page">Registrazione',  $page);

    $page .= file_get_contents("../html/signup.html");
    $page .= file_get_contents("../html/footer.html");

    $page  = str_replace('%ID%', "signup-form", $page);

    $page = Errors::handleErrorsAndMessages($page);
    $page = Utils::fillBackForm($page);
    $page = Utils::removePlaceholders($page);

    echo $page;
?>