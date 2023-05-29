<?php
    
    require_once('../helpers/DBAccess.php');
    require_once('../helpers/Utils.php');
    require_once('../helpers/Errors.php');

    #validazione nome
    if(isset($_POST['nome']) && $_POST['nome'] != '') {

        $name = $_POST['nome'];
        
        if(!preg_match("/^[a-z][a-z' àèìòù]*$/i", $name))
            Errors::addValidationError('%NAME_ERROR%', 'Il nome può contenere solo lettere maiuscole, minuscole, accentare e il carattere \'');

        unset($name);
        
    } else
        Errors::addValidationError('%NAME_ERROR%', 'Il campo è obbligatorio.');

    
    # validazione congome
    if(isset($_POST['cognome']) && $_POST['cognome'] != '') {

        $surname = $_POST['cognome'];
        
        if(!preg_match("/^[a-z][a-z' àèìòù]*$/i", $surname))
            Errors::addValidationError('%SURNAME_ERROR%', 'Il cognome può contenere solo lettere maiuscole, minuscole, accentare e il carattere \'');

        unset($surname);
        
    } else
        Errors::addValidationError('%SURNAME_ERROR%', 'Il campo è obbligatorio.');


    #validazione data di nascita
    if(isset($_POST['compleanno']) && $_POST['compleanno'] != '') {

        $date = $_POST['compleanno'];
    
        if(preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/', $date)) {
            
            $year  = substr($date, 0, 4);
            $month = substr($date, 5, 2);
            $day   = substr($date, 8, 2);

            if(checkdate($month, $day, $year)) {

                if(strtotime($date) > time())
                    Errors::addValidationError('%BIRTHDAY_ERROR%', 'La data di nascita deve essere antecedente a quella odierna');
    
            } else
                Errors::addValidationError('%BIRTHDAY_ERROR%', 'Inserire una data esistente nel formato (YYYY-MM-DD)');

    
        } else
            Errors::addValidationError('%BIRTHDAY_ERROR%', 'Il formato è errato (YYYY-MM-DD).');

            unset($date);

    } else
        Errors::addValidationError('%BIRTHDAY_ERROR%', 'Il campo è obbligatorio.');

    
    #validazione nazionalità
    if(isset($_POST['nazione']) && $_POST['nazione'] != '') {

        $nazione = $_POST['nazione'];
        
        if(!preg_match("/^[a-z][A-Za-z' àèìòù]*$/i", $nazione))
            Errors::addValidationError('%NATION_ERROR%', 'La nazione può contenere solo lettere maiuscole, minuscole, accentare, numeri e i caratteri \' - ,');

        unset($nazione);
        
    } else
        Errors::addValidationError('%NATION_ERROR%', 'Il campo è obbligatorio.');


    #validazione indirizzo
    if(isset($_POST['indirizzo']) && $_POST['indirizzo'] != '') {

        $address = $_POST['indirizzo'];
    
        if(!preg_match("/^[a-z][a-z0-9'-, àèìòù]*$/i", $address))
            Errors::addValidationError('%ADDRESS_ERROR%', 'L\'indirizzo può contenere solo lettere maiuscole, minuscole, accentare, numeri e i caratteri \' - ,');

        unset($address);

    } else
        Errors::addValidationError('%ADDRESS_ERROR%', 'Il campo è obbligatorio.');


    #validazione cittò
    if(isset($_POST['citta']) && $_POST['citta'] != '') {

        $city = $_POST['citta'];
    
        if(!preg_match("/^[a-z][a-z' àèìòù]*$/i", $city))
            Errors::addValidationError('%CITY_ERROR%', 'La città può contenere solo lettere maiuscole, minuscole, accentare e il carattere \'');

        unset($city);

    } else
        Errors::addValidationError('%CITY_ERROR%', 'Il campo è obbligatorio.');


    #validazione cap
    if(isset($_POST['cap']) && $_POST['cap'] != '') {

        $cap = $_POST['cap'];
    
        if(!preg_match("/^[0-9]{5}$/", $cap))
            Errors::addValidationError('%CAP_ERROR%', 'Il CAP dev\'essere composto da 5 caratteri numerici');

        unset($cap);

    } else
        Errors::addValidationError('%CAP_ERROR%', 'Il campo è obbligatorio.');


    #validazione numero di telefono
    if(isset($_POST['telefono']) && $_POST['telefono'] != '') {

        $phone = $_POST['telefono'];
    
        if(!preg_match("/^([ ]*[0-9][ ]*){10}$/", $phone))
            Errors::addValidationError('%PHONE_ERROR%', 'Il numero di telefono dev\'essere composto da 10 caratteri numerici');

        unset($phone);

    } else
        Errors::addValidationError('%PHONE_ERROR%', 'Il campo è obbligatorio.');


    #validaizone indirizo email / username
    if(isset($_POST['email']) && $_POST['email'] != '') {

        $email = $_POST['email'];
    
        if(!preg_match("/^(([^<>()[\]\\.,;:\s@']+(\.[^<>()[\]\\.,;:\s@']+)*)|('.+'))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/", $email))
            Errors::addValidationError('%EMAIL_ERROR%', 'L\'indirizzo <span lang="en">email</span> dovrebbe essere nel formato corretto, esempio: utente@esempio.com ');

        unset($email);

    } else
        Errors::addValidationError('%EMAIL_ERROR%', 'Il campo è obbligatorio.');


    #validazione password
    if(isset($_POST['password']) && $_POST['password'] != '') {

        $password = $_POST['password'];
    
        if(!preg_match("/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&* -]).{8,25}$/", $password))
            Errors::addValidationError('%PSW_ERROR%', 'La <span lang="en">password</span> deve contenere almeno un carattere maiuscolo, uno minuscolo, un numero, un carattare speciale tra #?!@$%^&*- ed essere compresa tra 8 e 25 caratteri');

        
        unset($password);

    } else
        Errors::addValidationError('%PSW_ERROR%','Il campo è obbligatorio.');

    

    #validazione conferma password
    if(isset($_POST['conferma_password']) && $_POST['conferma_password'] != '') {

        $password = $_POST['conferma_password'];
    
        if(isset($_POST['password']) && $_POST['password'] != $password)
            Errors::addValidationError('%COMPARE_PSW%', 'Le due <span lang="en">password</span> devono coincidere');

        unset($password);

    } else
        Errors::addValidationError('%COMPARE_PSW%', 'Il campo è obbligatorio.');

?>
