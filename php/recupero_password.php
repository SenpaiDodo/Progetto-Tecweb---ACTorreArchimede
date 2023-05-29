<?php

	require_once("helpers/Session.php");
	require_once("helpers/Utils.php");
	require_once("helpers/Errors.php");

	Session::session_start();

	if(Session::userLoggedIn()) {
		header('location: dashboard.php');
		die();
	}
	
	Utils::sanitizeInput();


    #######################
    ###  Render pagina  ###
    #######################

    $breadcrumb = '<li><a href="login.php" lang="en">Login</a></li><li aria-current="page">Recupero password</li>';

	$page  = Utils::template_replace("%TITLE%", "Recupero password | A.C. Torre Archimede", "../html/head.html");
	$page .= Utils::template_replace("%PAGENAME%", $breadcrumb, "../html/navbar.html");

    require_once("../php/navbar.php");

	$page .= file_get_contents("../html/recupero_password.html");
	$page .= file_get_contents("../html/footer.html");

    $page  = str_replace('%ID%', "recupero_password", $page);

    $page = Errors::handleErrorsAndMessages($page);
    $page = Utils::fillBackForm($page);
    $page = Utils::removePlaceholders($page);

	echo $page;

?>
