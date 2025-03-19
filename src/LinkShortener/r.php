<?php
// Connessione al database
require_once "db.php";

// Controlla se il parametro "l_s" è presente
if (!isset($_GET['l_s']) || empty($_GET['l_s'])) {
    die("Errore: Link shortato non specificato.");
}

$short_link = $_GET['l_s'];

// Cerca il link originale nel database
$query = "SELECT link_org FROM Link WHERE link_short = ?";
$stmt = $connection->prepare($query);
$stmt->bind_param("s", $short_link);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $original_link = $row['link_org'];

    // Reindirizza al link originale
    header("Location: $original_link");
    exit();
} else {
    die("Errore: Link non trovato nel database.");
}
?>