<?php

require_once('../helpers/DBAccess.php');
require_once('../helpers/Utils.php');
require_once('../helpers/Errors.php');

// controllo ora
if(isset($_POST['calendar_time']) && $_POST['calendar_time'] != '') {

    $time = $_POST['calendar_time'];

    if(!preg_match('/^([01][0-9]|2[0-4]):[0-5][0-9]$/', $time))
        Errors::addValidationError('%CALENDAR_TIME_ERROR%', 'Il formato è errato (HH:MM).');

} else
    Errors::addValidationError('%CALENDAR_TIME_ERROR%', 'Il campo è obbligatorio.');


//controllo data
if(isset($_POST['calendar_date']) && $_POST['calendar_date'] != '') {

    $date = $_POST['calendar_date'];

    if(preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/', $date)) {
        
        $year  = substr($date, 0, 4);
        $month = substr($date, 5, 2);
        $day   = substr($date, 8, 2);

        if(checkdate($month, $day, $year)) {

            if(strtotime($date) < time())
                Errors::addValidationError('%CALENDAR_DATE_ERROR%', 'La data deve essere successiva a quella odierna');

        } else
            Errors::addValidationError('%CALENDAR_DATE_ERROR%', 'Inserire una data esistente nel formato (YYYY-MM-DD)');

    } else
        Errors::addValidationError('%CALENDAR_DATE_ERROR%', 'Il formato è errato (YYYY-MM-DD).');

} else
    Errors::addValidationError('%CALENDAR_DATE_ERROR%', 'Il campo è obbligatorio.');

    
// controllo squadra di casa
if(isset($_POST['calendar_host_team']) && $_POST['calendar_host_team'] != '') {

    $host = $_POST['calendar_host_team'];
    
    if(ctype_digit($host) && $host > 0) {

        $query =   'SELECT COUNT(*)
                    FROM squadra
                    WHERE id = :id';

        $args = [':id' => $host];

        $result = $db->easyDBSelectQuery($query, $args);

        if(!isset($result) || $result[0]['COUNT(*)'] != 1)
            Errors::addValidationError('%CALENDAR_HOST_TEAM_ERROR%', 'La squadra selezionata non esiste.');
        
    } else
        Errors::addValidationError('%CALENDAR_HOST_TEAM_ERROR%', 'C\' è stato un errore durante l\' elaborazione della richiesta.');

} else
    Errors::addValidationError('%CALENDAR_HOST_TEAM_ERROR%', 'Il campo è obbligatorio.');
    // ? accessibilità: necessario dichiarare il nome del campo


// controllo squadra ospite
if(isset($_POST['calendar_guest_team']) && $_POST['calendar_guest_team'] != '') {

    $guest = $_POST['calendar_guest_team'];
    
    if(ctype_digit($guest) && $guest > 0) {

        $query =   'SELECT COUNT(*)
                    FROM squadra
                    WHERE id = :id';

        $args = [':id' => $guest];

        $result = $db->easyDBSelectQuery($query, $args);

        if(!isset($result) || $result[0]['COUNT(*)'] != 1)
            Errors::addValidationError('%CALENDAR_GUEST_TEAM_ERROR%', 'La squadra selezionata non esiste.');
        
    } else
        Errors::addValidationError('%CALENDAR_GUEST_TEAM_ERROR%', 'C\' è stato un errore durante l\' elaborazione della richiesta.');

} else
    Errors::addValidationError('%CALENDAR_GUEST_TEAM_ERROR%',  'Il campo è obbligatorio.');


//controllo stadio
if(isset($_POST['calendar_stadium']) && $_POST['calendar_stadium'] != '') {

    $stadium = $_POST['calendar_stadium'];

    if(ctype_digit($stadium) && $stadium >= 0) {

        $db->openDBConnection();

        $query =   'SELECT COUNT(*)
                    FROM stadio
                    WHERE id = :id';

        $args = [':id' => $stadium];

        $result = $db->easyDBSelectQuery($query, $args);

        if(!isset($result) || $result[0]['COUNT(*)'] != 1)
            Errors::addValidationError('%CALENDAR_STADIUM_ERROR%', 'Lo stadio selezionato non esiste.');
        
    } else
        Errors::addValidationError('%CALENDAR_STADIUM_ERROR%', 'Lo stadio selezionato non esiste.');

} else
    Errors::addValidationError('%CALENDAR_STADIUM_ERROR%', 'Il campo è obbligatorio.');

