<?php
    
    require_once("helpers/Session.php");
    require_once("helpers/Utils.php");

    Session::session_start();

	Utils::sanitizeInput();


    #######################
    ###  Render pagina  ###
    #######################
    
    $breadcrumb = '<li aria-current="page">Squadra</li>';

    $page = Utils::template_replace("%TITLE%", "Squadra | A.C. Torre Archimede", "../html/head.html");
    $page  = str_replace("%DESCRIPTION%", "Vedi e conosci chi sono i giocatori della squadra A.C. Torre Archimede, l'allenatore e i tecnici", $page);
    $page .= Utils::template_replace("%PAGENAME%", $breadcrumb, "../html/navbar.html");

    require_once("../php/navbar.php");

    $page = str_replace('><a href="squadra.php">La squadra</a>', ' id="current_page">La squadra',  $page);

    $page .= file_get_contents("../html/squadra.html");
    $page .= file_get_contents("../html/footer.html");
    $page  = str_replace('%ID%', "squadra-content", $page);

    $page = Utils::removePlaceholders($page);

    echo $page;

?>
