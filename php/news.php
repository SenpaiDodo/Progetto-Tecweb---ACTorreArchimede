<?php

require_once("helpers/Utils.php");
require_once("helpers/DBAccess.php");
require_once("helpers/Session.php");

Session::session_start();

//	Utils::sanitizeInput();


#####################################
###  Interazione con il database  ###
#####################################

$db = new DB\DBAccess;

$searchvalue = "";
if(isset($_GET["cerca"])){
	$args = [':cerca' => "%".$_GET["cerca"]."%"];
	$count = $db->easyDBSelectQuery("SELECT DISTINCT COUNT(*) FROM articolo WHERE titolo LIKE :cerca OR corpo LIKE :cerca", $args)[0]["COUNT(*)"];
	$searchvalue = "&cerca=".$_GET["cerca"];
}
else $count = $db->easyDBSelectQuery("SELECT COUNT(*) FROM articolo")[0]["COUNT(*)"];

if(isset($_GET["idpag"])) {
	$idpag = $_GET["idpag"];
}
else {
	$idpag = 1;
}

$news_per_page = 6;
$tot_page = ceil($count/$news_per_page);

$result = null;
if($count > 0) {
	$begin = ($idpag*$news_per_page)-$news_per_page;
	if(isset($_GET["cerca"])){
		$sql = "SELECT DISTINCT * FROM articolo WHERE titolo LIKE :cerca OR corpo LIKE :cerca ORDER BY data_inserimento DESC LIMIT $begin, $news_per_page";
		$args = [':cerca' => "%".$_GET["cerca"]."%"];
		$result = $db->easyDBSelectQuery($sql, $args);
	}
	else {
		$sql = "SELECT * FROM articolo ORDER BY data_inserimento DESC LIMIT $begin, $news_per_page";
		$result = $db->easyDBSelectQuery($sql);
	}
}

unset($db);


#####################################
### Processazione risultati query ###
#####################################

$news_pages = "";
if(isset($result) && $result != []) {
	if($idpag == 1)
	$news_pages = '<nav> <ul> <li>1</li>';
	else $news_pages = '<nav> <ul> <li><a href="?idpag=1'.$searchvalue.'">1</a></li>';
	
	if($tot_page < 9){
		for($i = 2; $i<=$tot_page-1; ++$i){
			$news_pages .= '<li><a href="?idpag=' . $i . $searchvalue . '">' . $i . '</a></li>';
		}
	}
	else if($idpag<=5){
		for($i = 2; $i<=6; ++$i){
			if($idpag == $i) 
			$news_pages .= '<li>'. $i .'</li>';
			else $news_pages .= '<li><a href="?idpag=' . $i . $searchvalue . '">' . $i . '</a></li>';
		}
		$news_pages .= "...";
		
	}
	else if($idpag<$tot_page - 4){
		$news_pages .= "...";
		for($i = $idpag-2; $i<=$idpag+2; ++$i){
			if($idpag == $i) 
			$news_pages .= '<li>'. $i .'</li>';
			else $news_pages .= '<li><a href="?idpag=' . $i . $searchvalue . '">' . $i . '</a></li>';
		}
		$news_pages .= "...";
	}
	else{
		$news_pages .= "...";
		for($i = $tot_page-5; $i<=$tot_page-1; ++$i){
			if($idpag == $i) 
			$news_pages .= '<li>'. $i .'</li>';
			else $news_pages .= '<li><a href="?idpag=' . $i . $searchvalue . '">' . $i . '</a></li>';
		}
	}
	
	if($idpag == $tot_page){
		if($tot_page != 1)	$news_pages .= "<li>$tot_page</li> </ul> </nav>";
		else $news_pages .= "</ul> </nav>";
	}
	else $news_pages .= "<li><a href='?idpag=$tot_page$searchvalue'>$tot_page</a></li> </ul> </nav>";
	
	$newsList = "";
	
	foreach($result as $article) {
		$newsList .= '<article id="news' . $article['id'] . '"><h3>' . $article['titolo'] . '</h3>';
		
		if($article['percorso_img'] != NULL) {
			$newsList .= '<img src="../images/'.$article['percorso_img'] . '" alt="" width="500" height="600">';
		}
		
		$newsList .='<p>' . $article['corpo'] . '</p> <p>'.$article['data_inserimento'].'</p> </article>';
	}
}
else {
	$newsList = '<p class="info">Nessuna notizia pubblicata</p>';
}


#######################
###  Render pagina  ###
#######################

$breadcrumb = '<li aria-current="page" lang="en">News</li>';

$page  = Utils::template_replace("%TITLE%", "News | A.C. Torre Archimede", "../html/head.html");
$page  = str_replace("%DESCRIPTION%", "Non perderti nessuna notizia dell'A.C. Torre Archimede e del suo stadio", $page);
$page .= Utils::template_replace("%PAGENAME%", $breadcrumb, "../html/navbar.html");

require_once("../php/navbar.php");

$page = str_replace('><a href="news.php" lang="en">News</a>', ' id="current_page" lang="en">News',  $page);

$page .= file_get_contents("../html/news.html");

$page  = str_replace('%NEWS_CHANGE_PAGES%', $news_pages, $page);
$page  = str_replace('%NEWS_LIST%', $newsList, $page);

$page .= file_get_contents("../html/footer.html");
$page  = str_replace('%ID%', "content", $page);

$page = Utils::removePlaceholders($page);
echo $page;
?>
