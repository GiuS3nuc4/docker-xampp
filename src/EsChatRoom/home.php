<?php
session_start();

// Controlla se l'utente è loggato
if (!isset($_SESSION['username'])) {
    header("Location: login.html"); // Reindirizza se non autenticato
    exit();
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin-top: 50px;
        }
        .logout-btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 15px;
            background-color: red;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .logout-btn:hover {
            background-color: darkred;
        }
    </style>
</head>
<body>
    <h1>Benvenuto, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
    <p>Sei entrato nella tua area riservata.</p>
    
    <a href="logout.php" class="logout-btn">Logout</a>
</body>
</html>