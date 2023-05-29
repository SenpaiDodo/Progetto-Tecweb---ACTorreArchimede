<?php

require_once('../helpers/DBAccess.php');
require_once('../helpers/Utils.php');
require_once('../helpers/Errors.php');


// controllo risultato sq. casa
if(isset($_POST['result_host']) && $_POST['result_host'] != '') {

    $result = $_POST['result_host'];

    if(!preg_match('/^[0-9]+$/', $result))
        Errors::addValidationError('%RESULT_HOST_ERROR%', 'Il risultato deve essere un numero non negativo (>= 0)');

} else
    Errors::addValidationError('%RESULT_HOST_ERROR%', 'Il campo è obbligatorio.');


// controllo risultato sq. casa
if(isset($_POST['result_guest']) && $_POST['result_guest'] != '') {

    $result = $_POST['result_guest'];

    if(!preg_match('/^[0-9]+$/', $result))
        Errors::addValidationError('%RESULT_GUEST_ERROR%', 'Il risultato deve essere un numero non negativo (>= 0)');

} else
    Errors::addValidationError('%RESULT_GUEST_ERROR%', 'Il campo è obbligatorio.');

    
