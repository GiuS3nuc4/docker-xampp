<?php
session_start();

// Controlla se l'utente è loggato
if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seleziona una chat</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin-top: 50px;
        }
        .chat-button {
            display: block;
            width: 200px;
            margin: 20px auto;
            padding: 10px;
            font-size: 18px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .chat-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h1>Benvenuto, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
    <p>Scegli una chat:</p>

    <form action="chat.php" method="GET">
        <button type="submit" name="chat" value="tecnologia" class="chat-button">Chat Tecnologia</button>
        <button type="submit" name="chat" value="sport" class="chat-button">Chat Sport</button>
        <button type="submit" name="chat" value="musica" class="chat-button">Chat Musica</button>
    </form>

    <br>
    <a href="logout.php">Logout</a>
</body>
</html>