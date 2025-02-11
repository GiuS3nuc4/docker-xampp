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
        <input type="text" name="username" placeholder="Username" required><br><br>
        <input type="password" name="password" placeholder="Password" required><br><br>
        <button type="submit">Accedi</button>
    </form>
    <p>Non hai un account? <a href="register.php">Registrati</a></p>
</body>
</html>