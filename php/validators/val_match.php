<?php

require_once('../helpers/DBAccess.php');
require_once('../helpers/Utils.php');
require_once('../helpers/Errors.php');



include("val_edit_match.php");


  
// controllo giorno
if(isset($_POST['calendar_day']) && $_POST['calendar_day'] != '') {

    $giornata = $_POST['calendar_day'];

    if(!is_numeric($giornata) || $giornata <= 0)
        Errors::addValidationError('%CALENDAR_DAY_ERROR%', 'La giornata deve essere un numero intero maggiore di 0.');

} else
    Errors::addValidationError('%CALENDAR_DAY_ERROR%', 'Il campo è obbligatorio.');


// controllo prezzo fascia 1
if(isset($_POST['calendar_price_platea']) && $_POST['calendar_price_platea'] != '') {

    $prezzo = $_POST['calendar_price_platea'];

    if(!is_numeric($prezzo) || $prezzo < 0)
        Errors::addValidationError('%CALENDAR_PRICE_PLATEA_ERROR%', 'Il prezzo deve essere un numero maggiore di 0');

} else
    Errors::addValidationError('%CALENDAR_PRICE_PLATEA_ERROR%', 'Il campo è obbligatorio.');


// controllo prezzo fascia 2
if(isset($_POST['calendar_price_tribuna']) && $_POST['calendar_price_tribuna'] != '') {

    $prezzo = $_POST['calendar_price_tribuna'];

    if(!is_numeric($prezzo) || $prezzo < 0)
        Errors::addValidationError('%CALENDAR_PRICE_TRIBUNA_ERROR%', 'Il prezzo deve essere un numero maggiore o uguale a 0');

} else
    Errors::addValidationError('%CALENDAR_PRICE_TRIBUNA_ERROR%', 'Il campo è obbligatorio.');

    
// controllo prezzo fascia 3
if(isset($_POST['calendar_price_spalti']) && $_POST['calendar_price_spalti'] != '') {

    $prezzo = $_POST['calendar_price_spalti'];

    if(!is_numeric($prezzo) || $prezzo < 0)
        Errors::addValidationError('%CALENDAR_PRICE_SPALTI_ERROR%', 'Il prezzo deve essere un numero maggiore o uguale a 0');

} else
    Errors::addValidationError('%CALENDAR_PRICE_SPALTI_ERROR%', 'Il campo è obbligatorio.');

    
// controllo prezzo fascia 4
if(isset($_POST['calendar_price_curva']) && $_POST['calendar_price_curva'] != '') {

    $prezzo = $_POST['calendar_price_curva'];

    if(!is_numeric($prezzo) || $prezzo < 0)
        Errors::addValidationError('%CALENDAR_PRICE_CURVA_ERROR%', 'Il prezzo deve essere un numero maggiore o uguale a 0');

} else
    Errors::addValidationError('%CALENDAR_PRICE_CURVA_ERROR%', 'Il campo è obbligatorio.');
