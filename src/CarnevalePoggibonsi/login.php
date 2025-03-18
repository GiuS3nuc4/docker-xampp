<?php
// Avvio sessione
session_start();

// Include la connessione al DB
require_once "db.php";

// Verifica se la richiesta è POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['codice_fiscale']) && !empty($_POST['data'])) {
        $username = $_POST['codice_fiscale'];
        $password = $_POST['data'];

        // Query per recuperare i dati dell'utente (username e password hashata)
        $query = "SELECT * FROM Utenti WHERE codice_fiscale = ?";
        $stmt = $connection->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Se l'utente esiste, recupera i dati
            $user = $result->fetch_assoc();

            // Verifica se la password inserita corrisponde a quella salvata nel database
            //if (password_verify($password, $user['password'])) {
                // Se la password è corretta, avvia la sessione
                $_SESSION['username'] = $username;


                // Redirect alla selezione della chat
                header("Location: pannello_controllo.php");
                exit();
            
        } else {
            // Se l'utente non esiste
            echo "Credenziali errate!";
        }

        $stmt->close();
    } else {
        // Se manca username o password
        echo "Inserisci codice fiscale e data di nascita!";
    }
} else {
    // Se la richiesta non è di tipo POST
    //echo "Richiesta non valida!";
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin-top: 50px;
            background-color: #e8f5e9;
        }
        input, button {
            padding: 10px;
            font-size: 16px;
            margin-top: 10px;
        }
        button {
            background-color: #4caf50;
            color: white;
            border: none;
            border-radius: 5px;
        }
        button:hover {
            background-color: #388e3c;
        }
    </style>
</head>
<body>
    <h1>Login</h1>
    <form action="login.php" method="POST">
        <input type="text" name="codice_fiscale" placeholder="Codice fiscale" required><br><br>
        <label for="data">Data di nascita:</label><br>
        <input type="date" name="data" required><br><br>
        <button type="submit">Accedi</button>
    </form>
</body>
</html>