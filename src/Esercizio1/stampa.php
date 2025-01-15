<?php

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST["fname"];
    $cognome = $_POST["lname"];
    $username = $_POST["uname"];
    $email = $_POST["email"];
    $citta = $_POST["citta"];
    $genere = $_POST["genere"];
    $dataNascita = $_POST["dataNascita"]; 

    echo $nome . "<br>";
    echo $cognome . "<br>";
    echo $username . "<br>";
    echo $email . "<br>";
    echo $citta . "<br>";
    echo $genere . "<br>";
    echo $dataNascita . "<br>";

}

?>