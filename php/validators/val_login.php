<?php
    
    require_once('../helpers/DBAccess.php');
    require_once('../helpers/Utils.php');
    require_once('../helpers/Errors.php');

    if(isset($_POST['username']) && $_POST['username'] != '') {

        if(!in_array($_POST['username'], ['admin', 'utente']) && !preg_match("/^(([^<>()[\]\\.,;:\s@']+(\.[^<>()[\]\\.,;:\s@']+)*)|('.+'))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/", $_POST['username']))
            Errors::addValidationError('%EMAIL_ERROR%', '<span lang="en">Email</span> in formato non valido.');
       
    } else
        Errors::addValidationError('%EMAIL_ERROR%', 'Il campo è obbligatorio.');



    if(!isset($_POST['password']) || $_POST['password'] == '')
        Errors::addValidationError('%PSW_ERROR%', 'Il campo è obbligatorio.');

?>
