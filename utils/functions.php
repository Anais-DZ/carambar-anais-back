<?php
//fonction pour se connecter à la BDD 
function connect($host, $dbname, $login, $password)
{
    return new
        PDO('mysql:host=' . $host . ';dbname=' . $dbname . '', $login, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
?>