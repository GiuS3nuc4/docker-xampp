<?php
// Avvio sessione
session_start();

// Include la connessione al DB
require_once "db.php";

// Verifica se la richiesta è POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['username']) && !empty($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Query per recuperare i dati dell'utente (username e password hashata)
        $query = "SELECT * FROM Utenti WHERE username = ?";
        $stmt = $connection->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Se l'utente esiste, recupera i dati
            $user = $result->fetch_assoc();

            // Verifica se la password inserita corrisponde a quella salvata nel database
            if (password_verify($password, $user['password'])) {
                // Se la password è corretta, avvia la sessione
                $_SESSION['username'] = $username;
                $_SESSION['id'] = $user['id']; 


                // Redirect alla selezione della chat
                header("Location: chat_selection.php");
                exit();
            } else {
                // Se la password non corrisponde
                echo "Credenziali errate!";
            }
        } else {
            // Se l'utente non esiste
            echo "Credenziali errate!";
        }

        $stmt->close();
    } else {
        // Se manca username o password
        echo "Inserisci username e password!";
    }
} else {
    // Se la richiesta non è di tipo POST
    echo "Richiesta non valida!";
}
