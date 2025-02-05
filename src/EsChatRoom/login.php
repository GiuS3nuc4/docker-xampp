<?php
//avvio sessione
session_start();
    //include la connessione al db
    require_once "db.php";

    //verifica se la richiesta è POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (!empty($_POST['username']) && !empty($_POST['password'])) {
            $username = $_POST['username'];
            $pw = $_POST['password'];

            //query sicura con prepared stataments(metodo per eseguire query SQL in modo sicuro)
            $query = "SELECT * FROM Utenti WHERE username = ? AND password = ?";
            $stmt = $connection->prepare($query);
            $stmt->bind_param("ss", $username, $pw);
            $stmt->execute();
            $result = $stmt->get_result();

            if($result->num_rows > 0){
                //echo "Login riuscito!";
                $SESSION['username'] = $username;
                header("Location: chat_selection.php");
                exit();
            } 
            else{
                echo "Credenziali errate!";
            }

            $stmt->close();
        } 
        else {
            echo "Inserisci username e password!";
        }
    } 
    else{
        echo "Richiesta non valida!";
    }

$connection->close();