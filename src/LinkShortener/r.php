<?php
// Include la connessione al DB
require_once "db.php";

// Verifica se è stato passato il parametro 'link_short'
if (isset($_GET['link_short'])) {
    $link_short = $_GET['link_short'];

    // Query per recuperare il link originale corrispondente al link shortato
    $query = "SELECT link_org FROM Link WHERE link_short = ?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("s", $link_short);
    $stmt->execute();
    $result = $stmt->get_result();

    // Se il link shortato esiste nel database
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Reindirizza l'utente al link originale
        header("Location: " . $row['link_org']);
        exit();
    } else {
        echo "Link non trovato.";
    }

    $stmt->close();
} else {
    echo "Link shortato non specificato.";
}

// Chiudi la connessione
$connection->close();
?>