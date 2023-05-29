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
    
    $breadcrumb = '<li aria-current="page" lang="en">Login</li>';

    $page  = Utils::template_replace("%TITLE%", "Login | A.C. Torre Archimede", "../html/head.html");
    $page  = str_replace("%DESCRIPTION%", "Effettua il login al sito per acquistare i biglietti per le prossime partite o visualizzare quelli già acquistati", $page);
    $page .= Utils::template_replace("%PAGENAME%", $breadcrumb, "../html/navbar.html");

    require_once("../php/navbar.php");

    $page = str_replace('><a href="login.php" lang="en">Login</a>', ' id="current_page" lang="en">Login',  $page);

    $page .= file_get_contents("../html/login.html");
    $page .= file_get_contents("../html/footer.html");

    $page  = str_replace('%ID%', "form-login", $page);

    $page = Errors::handleErrorsAndMessages($page);
    $page = Utils::fillBackForm($page);
    $page = Utils::removePlaceholders($page);

    echo $page;

?>
