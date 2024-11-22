<?php
    $db_host = '127.0.0.1';
    $db_name = 'gaulois';
    $db_user = "root";
    $db_psw = "";

    try{
        $db = new PDO("mysql:host=".$db_host.";dbname=".$db_name, $db_user, $db_psw);
    } catch(Exception $e){
        die("Une erreur est survenue : $e");
    }


?>