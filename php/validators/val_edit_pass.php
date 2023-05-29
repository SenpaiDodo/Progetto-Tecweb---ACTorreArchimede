<?php

require_once('../helpers/DBAccess.php');
require_once('../helpers/Utils.php');
require_once('../helpers/Errors.php');



if(isset($_POST['email']) && $_POST['email'] != '') {

    $email = $_POST['email'];

    if(!preg_match("/^(([^<>()[\]\\.,;:\s@']+(\.[^<>()[\]\\.,;:\s@']+)*)|('.+'))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/", $email)) {

        Errors::addValidationError('%EMAIL_ERROR%', 'L\'indirizzo <span lang="en">email</span> dovrebbe essere nel formato corretto, esempio: utente@esempio.com');
    }
    else {
        $query =   'SELECT COUNT(*)
                    FROM utente
                    WHERE email = :email';

        $args = [':email' => $_POST['email']];

        $result = $db->easyDBSelectQuery($query, $args);

        if(!isset($result) || $result[0]["COUNT(*)"] != 1)
            Errors::addServerError('%CHANGE_PASSWORD_MESSAGE%', 'Impossibile aggiornare la <span lang="en">password</span>.');
    }
    


} else
    Errors::addValidationError('%EMAIL_ERROR%', 'Il campo è obbligatorio.');




if(isset($_POST['newpassword']) && $_POST['newpassword'] != '') {
    
    if(!preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,50}$/", $_POST['newpassword'])) {
    
        Errors::addValidationError('%PSW_ERROR%', 'La <span lang="en">password</span> deve contenere almeno un carattere maiuscolo, uno minuscolo, un numero, un carattare speciale tra #?!@$%^&*- ed essere compresa tra 8 e 25 caratteri');
    }
} else
    Errors::addValidationError('%PSW_ERROR%', 'Il campo è obbligatorio.');



if(isset($_POST['confirmpassword']) && $_POST['confirmpassword'] != '') {

        $password = $_POST['confirmpassword'];
    
        if(isset($_POST['password']) && $_POST['password'] != $password)
            Errors::addValidationError('%COMPARE_PSW%', 'Le due <span lang="en">passsword</span> devono coincidere');

        unset($password);

    } else
        Errors::addValidationError('%COMPARE_PSW%', 'Il campo è obbligatorio.');

