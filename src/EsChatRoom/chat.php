<?php
session_start();

// Controlla se l'utente è loggato
if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}

// Connessione al database
require_once "db.php";

// Recupera il nome della chat dalla richiesta GET
$chat_name = isset($_GET['chat']) ? $_GET['chat'] : 'Generale';

// ID della stanza (per esempio, in base al nome della chat)
$stanza_id = null;
switch ($chat_name) {
    case 'tecnologia':
        $stanza_id = 1;
        break;
    case 'sport':
        $stanza_id = 2;
        break;
    case 'musica':
        $stanza_id = 3;
        break;
    default:
        $stanza_id = 1; // Valore di default
        break;
}

// Recupera i messaggi dalla tabella Messaggi
$query = "SELECT m.testo, u.username FROM Messaggi m
          JOIN Utenti u ON m.utente_id = u.id
          WHERE m.stanza_id = ? ORDER BY m.id ASC";
$stmt = $connection->prepare($query);
$stmt->bind_param("i", $stanza_id);
$stmt->execute();
$result = $stmt->get_result();

$messages = [];
while ($row = $result->fetch_assoc()) {
    $messages[] = $row;
}

// Se l'utente invia un nuovo messaggio
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['message'])) {
    $message = $_POST['message'];
    
    // Inserisce il nuovo messaggio nella tabella
    $query = "INSERT INTO Messaggi (utente_id, stanza_id, testo) VALUES (?, ?, ?)";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("iis", $_SESSION['id'], $stanza_id, $message);
    $stmt->execute();
    
    // Ricarica la pagina per visualizzare il nuovo messaggio
    header("Location: chat.php?chat=" . $chat_name);
    exit();
}

$connection->close();
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
            <?php
            // Visualizza i messaggi della chat
            foreach ($messages as $msg) {
                echo "<p><strong>" . htmlspecialchars($msg['username']) . ":</strong> " . htmlspecialchars($msg['testo']) . "</p>";
            }
            ?>
        </div>
        <form action="chat.php?chat=<?php echo htmlspecialchars($chat_name); ?>" method="POST">
            <input type="text" name="message" id="message" placeholder="Scrivi un messaggio..." required>
            <button type="submit">Invia</button>
        </form>
    </div>
    <br>
    <a href="chat_selection.php">Torna alla selezione chat</a> |
    <a href="logout.php">Logout</a>
</body>
</html>