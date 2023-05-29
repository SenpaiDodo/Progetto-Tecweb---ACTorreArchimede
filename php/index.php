<?php

use DB\DBAccess;

    require_once("helpers/Utils.php");
    require_once("helpers/DBAccess.php");
    require_once("helpers/Tables.php");
    require_once("helpers/Session.php");
    require_once("helpers/Errors.php");

    Session::session_start();

	Utils::sanitizeInput();


    #####################################
    ###  Interazione con il database  ###
    #####################################

    $db = new DBAccess;
    $db->openDBConnection();

    $tableResult = $db->DBSelectQuery(
       'SELECT Sq.nome AS NomeSquadra,
            St.nome AS NomeStadio,
            Sq2.nome AS NomeSquadraAvversaria,
            P.data as Data,
            P.giornata as Giornata,
            Sq2.id,
            St.id,
            P.id
        FROM partita AS P, stadio AS St, squadra AS Sq, squadra AS Sq2
        WHERE P.data >= CURDATE()
            AND Sq.id = P.id_host
            AND Sq2.id = P.id_guest
            AND St.id = P.id_stadio
        ORDER BY data ASC
        LIMIT 3');

    $newsResult = $db->DBSelectQuery(
       'SELECT *
        FROM articolo
        ORDER BY data_inserimento DESC
        LIMIT 6');

    $db->closeDBConnection();
    unset($db);


    #####################################
    ### Processazione risultati query ###
    #####################################

    $table = Tables::buildHomeTable($tableResult);

    if(isset($newsResult) && $newsResult != []) {
        $news = '';
        foreach($newsResult as $article) {
            $news .=   '<article class="home-news">' . "\n";

            $news .= '<h3>' . $article['titolo'] .  "</h3>\n";
            $body  = substr(strip_tags($article['corpo']), 0, 100) . "...";
            $news .= '<p>'  . $body . '<a href="news.php#news' . $article['id'] . '">vai all\'articolo completo</a></p>' . "\n";
            $news .=    '</article>' . "\n";
        }
    } else
        $news = '<p class="info">Nessuna notizia pubblicata.</p>';


    #######################
    ###  Render pagina  ###
    #######################

    $breadcrumb = '<li aria-current="page" lang="en">Home</li>';

    $page = Utils::template_replace("%TITLE%", "Home | A.C. Torre Archimede", "../html/head.html");
    $page  = str_replace("%DESCRIPTION%", "Il sito ufficiale dell'A.C. Torre Archimede e dello stadio Torre Archimede", $page);
    $page .= Utils::template_replace("%PAGENAME%", $breadcrumb, "../html/navbar.html");

    require_once("../php/navbar.php");

    $page = str_replace('><a href="index.php" lang="en">Home</a>', ' id="current_page">Home',  $page);

    $page .= file_get_contents("../html/index.html");

    $page = str_replace('%NEXT_EVENTS%', $table, $page);
    $page = str_replace('%LATEST_NEWS%', $news, $page);

    $page .= file_get_contents("../html/footer.html");
    
    $page  = str_replace('%ID%', "home-content", $page);
    $page = Errors::handleErrorsAndMessages($page);
    $page = Utils::removePlaceholders($page);
    echo $page;

    ?>
   
