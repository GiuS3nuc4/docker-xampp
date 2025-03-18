<?php
// Avvio sessione
session_start();

// Include la connessione al DB
require_once "db.php";

// Recupera i messaggi dalla tabella Messaggi
$username = $_SESSION['username'];
$query = "SELECT * FROM `Utenti` WHERE codice_fiscale = ? AND m_scelta!= NULL;";
$stmt = $connection->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0)  {
    echo 'maschera scelta';
} else{
    echo 'maschera non inserita';
}