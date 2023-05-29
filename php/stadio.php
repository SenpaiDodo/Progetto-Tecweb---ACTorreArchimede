<?php
    
    require_once("helpers/Session.php");
    require_once("helpers/Utils.php");

    Session::session_start();

	Utils::sanitizeInput();

    
    #######################
    ###  Render pagina  ###
    #######################
    
    $breadcrumb = '<li aria-current="page">Stadio</li>';

    $page  = Utils::template_replace("%TITLE%", "Stadio | A.C. Torre Archimede", "../html/head.html");
    $page  = str_replace("%DESCRIPTION%", "Leggi la storia completa dello stadio Torre Archimede, dai suoi albori alla sua attuale forma", $page);
    $page .= Utils::template_replace("%PAGENAME%", $breadcrumb, "../html/navbar.html");

    require_once("../php/navbar.php");

    $page = str_replace('><a href="stadio.php">Stadio</a>', ' id="current_page">Stadio', $page);

    $page .= file_get_contents("../html/stadio.html");
    $page .= file_get_contents("../html/footer.html");

    $page  = str_replace('%ID%', "stadio-content", $page);
    $page = Utils::removePlaceholders($page);
    echo $page;

?>
