<?php
session_start();
require_once "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['username']) && !empty($_POST['email']) && !empty($_POST['password'])) {
        $username = trim($_POST['username']);
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $password = $_POST['password']; // Password salvata in chiaro (insicuro!)

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = "Formato email non valido!";
        } else {
            // Controllo se username o email esistono già
            $query = "SELECT id FROM Utenti WHERE username = ? OR email = ?";
            if ($stmt = $connection->prepare($query)) {
                $stmt->bind_param("ss", $username, $email);
                $stmt->execute();
                $stmt->store_result();

                if ($stmt->num_rows > 0) {
                    $error = "Username o email già esistente!";
                } else {
                    // Query per inserire la password in chiaro (NON SICURO!)
                    $insert_query = "INSERT INTO Utenti (username, email, password) VALUES (?, ?, ?)";
                    
                    if ($stmt = $connection->prepare($insert_query)) {
                        $stmt->bind_param("sss", $username, $email, $password);
                        if ($stmt->execute()) {
                            echo "Registrazione avvenuta con successo! <a href='login.php'>Login</a>";
                            exit();
                        } else {
                            $error = "Errore durante la registrazione.";
                        }
                        $stmt->close();
                    }
                }
                $stmt->close();
            }
        }
    } else {
        $error = "Tutti i campi sono obbligatori!";
    }
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrazione</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; margin-top: 50px; background-color: #e8f5e9; }
        input, button { padding: 10px; font-size: 16px; margin-top: 10px; }
        button { background-color: #4caf50; color: white; border: none; border-radius: 5px; }
        button:hover { background-color: #388e3c; }
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
    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <p>Hai già un account? <a href="login.php">Login</a></p>
</body>
</html>