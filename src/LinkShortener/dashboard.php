<?php
// Avvio sessione
session_start();

// Include la connessione al DB
require_once "db.php";

// Verifica se l'utente è loggato
if (!isset($_SESSION['id'])) {
    // Se l'utente non è loggato, reindirizza al login
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['id']; // ID dell'utente loggato

// Query per recuperare i link originali, shortati e login_count dell'utente
$query = "SELECT link_org, link_short, login_count FROM Link WHERE user_id = ?";
$stmt = $connection->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #e8f5e9;
        }
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #4caf50;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #4caf50;
            color: white;
        }
        .btn {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #4caf50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
        .btn:hover {
            background-color: #388e3c;
        }
    </style>
</head>
<body>

<h1>Benvenuto nella tua Dashboard!</h1>

<table>
    <tr>
        <th>Link Originale</th>
        <th>Link Shortato</th>
        <th>Login Count</th>
    </tr>

    <?php
    // Verifica se l'utente ha dei link
    if ($result->num_rows > 0) {
        // Cicla e mostra i link
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row['link_org'] . "</td><td>" . $row['link_short'] . "</td><td>" . $row['login_count'] . "</td></tr>";
        }
    } else {
        echo "<tr><td colspan='3'>Non hai ancora creato nessun link shortato.</td></tr>";
    }
    ?>

</table>

<a href="logout.php" class="btn">Logout</a>

</body>
</html>

<?php
// Chiudi la connessione
$stmt->close();
$connection->close();
?>