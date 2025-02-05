<?php
session_start();

// Controlla se l'utente è loggato
if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}

// Recupera il nome della chat dalla richiesta GET
$chat_name = isset($_GET['chat']) ? $_GET['chat'] : 'Generale';

?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat <?php echo ucfirst(htmlspecialchars($chat_name)); ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin-top: 50px;
        }
        .chat-container {
            width: 50%;
            margin: auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            background: #f9f9f9;
        }
        .message-box {
            width: 100%;
            height: 300px;
            border: 1px solid #ccc;
            overflow-y: scroll;
            margin-bottom: 10px;
            padding: 10px;
            background: white;
        }
        input, button {
            padding: 10px;
            font-size: 16px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <h1>Chat <?php echo ucfirst(htmlspecialchars($chat_name)); ?></h1>
    <div class="chat-container">
        <div class="message-box" id="messages">
            <p>Benvenuto nella chat di <?php echo ucfirst(htmlspecialchars($chat_name)); ?>!</p>
        </div>
        <input type="text" id="message" placeholder="Scrivi un messaggio...">
        <button onclick="sendMessage()">Invia</button>
    </div>
    <br>
    <a href="chat_selection.php">Torna alla selezione chat</a> |
    <a href="logout.php">Logout</a>

    <script>
        function sendMessage() {
            let messageBox = document.getElementById("messages");
            let messageInput = document.getElementById("message");
            let message = messageInput.value.trim();

            if (message !== "") {
                let newMessage = document.createElement("p");
                newMessage.textContent = "<?php echo htmlspecialchars($_SESSION['username']); ?>: " + message;
                messageBox.appendChild(newMessage);
                messageInput.value = "";
            }
        }
    </script>
</body>
</html>