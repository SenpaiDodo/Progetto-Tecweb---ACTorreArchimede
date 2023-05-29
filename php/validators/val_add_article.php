<?php

require_once('../helpers/DBAccess.php');
require_once('../helpers/Utils.php');
require_once('../helpers/Errors.php');



// controllo titolo
if(isset($_POST['news_title']) && $_POST['news_title'] != '') {

    $title = $_POST['news_title'];
    
    if(strlen($title) > 50)
        Errors::addValidationError('%NEWS_TITLE_ERROR%', 'Lunghezza massima titolo 50 caratteri.');
        
} else
    Errors::addValidationError('%NEWS_TITLE_ERROR%', 'Il campo è obbligatorio.');
    // ? accessibilità: necessario dichiarare il nome del campo

    
// controllo corpo
if(isset($_POST['news_body']) && $_POST['news_body'] != '') {
  
} else
    Errors::addValidationError('%NEWS_BODY_ERROR%', 'Il campo è obbligatorio.');
    // ? accessibilità: necessario dichiarare il nome del campo

    
// controllo immagine
if(isset($_FILES['news_backgroundImg']) && $_FILES['news_backgroundImg']['error'] != UPLOAD_ERR_NO_FILE) {

    $pic = $_FILES['news_backgroundImg'];

    if(!in_array(pathinfo($pic['name'], PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif']))
        Errors::addValidationError('%NEWS_BGIMG_ERROR%', 'Estensione non supportata, prova con <span lang="en">file</span> .jpg, .jpeg, .png o .gif');

    if($pic['size'] > 2000000 || in_array($pic['error'], [UPLOAD_ERR_INI_SIZE, UPLOAD_ERR_FORM_SIZE]))
        Errors::addValidationError('%NEWS_BGIMG_ERROR%', 'Il <span lang="en">file</span> è troppo grande, scegli un <span lang="en">file</span> di dimensione minore di <abbr title="due Megabyte">2MB</abbr>.');

    if(!in_array($pic['error'], [UPLOAD_ERR_INI_SIZE, UPLOAD_ERR_FORM_SIZE, UPLOAD_ERR_OK]))
        Errors::addValidationError('%NEWS_BGIMG_ERROR%', 'Non è stato posibile caricare l\' immagine, contattare l\'amministratore');
}
