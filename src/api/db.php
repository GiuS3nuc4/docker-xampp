<?php

    //parametri connessione db
    $host = 'db';
    $dbname = 'root_db';
    $user = 'user';
    $password = 'user';
    $port = 3306;

    $connection = new mysqli($host, $user, $password, $dbname, $port);

    if($connection->connect_error){
        die("Errore di connessione: ".$connection->connect_error);
    }