<?php
session_start();

// Controlla se l'utente è loggato
if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}

// Connessione al database
require_once "db.php";

// ID dell'utente corrente
$utente_id = $_SESSION['username'];  // Puoi modificare in base al campo 'id' nella tabella Utenti

// ID della chat, passato via GET
$stanza_id = null;
$messaggi_predefiniti = [];

// Verifica quale chat è stata scelta
if (isset($_GET['chat'])) {
    $chat = $_GET['chat'];
    
    // Determina l'ID della stanza in base alla chat scelta
    switch ($chat) {
        case 'tecnologia':
            $stanza_id = 1;
            $messaggi_predefiniti = [
                ['utente_id' => 1, 'testo' => 'Benvenuto nella chat di Tecnologia!'],
                ['utente_id' => 2, 'testo' => 'Ciao! Qual è l\'argomento di oggi?'],
                ['utente_id' => 1, 'testo' => 'Parliamo delle nuove innovazioni nel campo dell\'IA!']
            ];
            break;
        case 'sport':
            $stanza_id = 2;
            $messaggi_predefiniti = [
                ['utente_id' => 1, 'testo' => 'Benvenuto nella chat di Sport!'],
                ['utente_id' => 2, 'testo' => 'Ciao! Che sport ti piace di più?'],
                ['utente_id' => 1, 'testo' => 'Io sono un grande fan del calcio!']
            ];
            break;
        case 'musica':
            $stanza_id = 3;
            $messaggi_predefiniti = [
                ['utente_id' => 1, 'testo' => 'Benvenuto nella chat di Musica!'],
                ['utente_id' => 2, 'testo' => 'Ciao! Qual è il tuo genere musicale preferito?'],
                ['utente_id' => 1, 'testo' => 'Mi piace molto il rock e l\'indie!']
            ];
            break;
    }
    
    // Aggiungi i messaggi predefiniti nella tabella Messaggi
    if ($stanza_id && !empty($messaggi_predefiniti)) {
        foreach ($messaggi_predefiniti as $msg) {
            $query = "INSERT INTO Messaggi (utente_id, stanza_id, testo) VALUES (?, ?, ?)";
            $stmt = $connection->prepare($query);
            $stmt->bind_param("iis", $msg['utente_id'], $stanza_id, $msg['testo']);
            $stmt->execute();
        }
    }
}

$connection->close();
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seleziona una chat</title>
    <style>
        body {
            font-family: 'Arial',sans-serif;
            text-align: center;
            margin-top: 50px;
        }
        .chat-button {
            display: block;
            width: 200px;
            margin: 20px auto;
            padding: 10px;
            font-size: 18px;
            background-color: #218838;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .chat-button:hover {
            background-color: #1A6B2F;
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