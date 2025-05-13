<?php
session_start();
require_once "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['username']) && !empty($_POST['password'])) {
        $username = trim($_POST['username']);
        $password = $_POST['password'];

        // Query per la password criptata dal database
        $query = "SELECT id, password FROM Utenti WHERE username = ?";
        $stmt = $connection->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $stmt->bind_result($user_id, $db_password);
                $stmt->fetch();
                
                // Verifica della password con password_verify
                if (password_verify($password, $db_password)) {
                    // Password corretta, avvia la sessione
                    $_SESSION['username'] = $username;
                    $_SESSION['id'] = $user_id;
                    header("Location: dashboard.php");
                    exit();
                } else {
                    $error = "Credenziali errate!";
                }
            } else {
                $error = "Credenziali errate!";
            }
            $stmt->close();
        }
    } else {
        $error = "Inserisci username e password!";
    }
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; margin-top: 50px; background-color: #e8f5e9; }
        input, button { padding: 10px; font-size: 16px; margin-top: 10px; }
        button { background-color: #4caf50; color: white; border: none; border-radius: 5px; }
        button:hover { background-color: #388e3c; }
    </style>
</head>
<body>
    <h1>Login</h1>
    <form action="login.php" method="POST">
        <input type="text" name="username" placeholder="Username" required><br><br>
        <input type="password" name="password" placeholder="Password" required><br><br>
        <button type="submit">Accedi</button>
    </form>
    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <p>Non hai un account? <a href="register.php">Registrati</a></p>
</body>
</html>