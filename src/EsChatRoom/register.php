<?php
// Avvio sessione
session_start();

// Include la connessione al DB
require_once "db.php";

// Verifica se la richiesta è POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Controlla se i campi sono stati riempiti
    if (!empty($_POST['username']) && !empty($_POST['email']) && !empty($_POST['password'])) {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Controlla se l'username è già in uso
        $query = "SELECT * FROM Utenti WHERE username = ?";
        $stmt = $connection->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Se l'username è già preso, mostra un messaggio di errore
            echo "Username già esistente!";
        } else {
            // Hash della password prima di salvarla nel DB
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Query per inserire l'utente nel database
            $insert_query = "INSERT INTO Utenti (username, email, password) VALUES (?, ?, ?)";
            $stmt = $connection->prepare($insert_query);
            $stmt->bind_param("sss", $username, $email, $hashed_password);
            $stmt->execute();

            // Se l'inserimento va a buon fine
            if ($stmt->affected_rows > 0) {
                echo "Registrazione avvenuta con successo! <a href='login.html'>Login</a>";
            } else {
                echo "Errore durante la registrazione. Riprova.";
            }

            $stmt->close();
        }
    } else {
        echo "Tutti i campi sono obbligatori!";
    }
} else {
    //echo "Richiesta non valida!";
}

$connection->close();
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrazione</title>
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
    <h1>Registrazione</h1>
    <form action="register.php" method="POST">
        <input type="text" name="username" placeholder="Username" required><br><br>
        <input type="email" name="email" placeholder="Email" required><br><br>
        <input type="password" name="password" placeholder="Password" required><br><br>
        <button type="submit">Registrati</button>
    </form>
    <p>Hai già un account? <a href="login.html">Login</a></p>
</body>
</html>