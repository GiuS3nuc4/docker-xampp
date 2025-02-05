<?php
    //include la connessione al db
    require_once "db.php";

    //verifica se la richiesta è POST
    if ($SERVER["REQUEST_METHOD"] == "POST") {
        if (!empty($_POST['username']) && !empty($_POST['password'])) {
            $username = $_POST['username'];
            $pw = $_POST['password'];

            //query sicura con prepared stataments(metodo per eseguire query SQL in modo sicuro)
            $query = "SELECT * FROM utenti WHERE username = ? AND pw = ?";
            $stmt = $connection->prepare($query);
            $stmt->bind_param("ss", $username, $pw);
            $stmt->execute();
            $result = $stmt->get_result();

            if($result->num_rows > 0){
                echo "Login riuscito!";
                //avvio sessione
                session_start();
                $SESSION['username'] = $username;
                header("Location: home.php")
            } else{
                echo "Credenziali errate!"
            }

            $stmt->close();
        } else {
            echo "Inserisci username e password!";
        }
    } else{
        scho "Richiesta non valida!";
    }