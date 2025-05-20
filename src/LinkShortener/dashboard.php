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

// Query per recuperare tutti i link originali, shortati, login_count e il nome dell'utente
$query = "SELECT Link.link_org, Link.link_short, Link.login_count, Utenti.username 
          FROM Link 
          JOIN Utenti ON Link.utente_id = Utenti.id
          Where Utenti.id = ?";
$stmt = $connection->prepare($query);
$stmt->bind_param("s", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Shortare un link
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['link_org'])) {
    $link_org = $_POST['link_org'];
    $link_short = substr(md5($link_org . time()), 0, 6); // Crea un short link casuale

    // Inserisci il link nel database
    $insert_query = "INSERT INTO Link (utente_id, link_org, link_short, login_count) VALUES (?, ?, ?, ?)";
    $insert_stmt = $connection->prepare($insert_query);
    $login_count = 0; // inizializza a 0
    $insert_stmt->bind_param("isss", $user_id, $link_org, $link_short, $login_count);
    $insert_stmt->execute();
    $insert_stmt->close();
    header("Location: dashboard.php");
}

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
        .form-container {
            margin-top: 20px;
        }
        input[type="text"] {
            padding: 10px;
            font-size: 16px;
            width: 60%;
        }
        input[type="submit"] {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #4caf50;
            color: white;
            border: none;
            border-radius: 5px;
        }
        input[type="submit"]:hover {
            background-color: #388e3c;
        }
    </style>
</head>
<body>

<h1>Benvenuto nella tua Dashboard!</h1>

<h2>Shorta un nuovo link</h2>
<div class="form-container">
    <form method="post">
        <input type="text" name="link_org" placeholder="Inserisci il link da shortare" required>
        <input type="submit" value="Shorta Link">
    </form>
</div>

<h2>Link Shortati da tutti gli utenti</h2>
<table>
    <tr>
        <th>Nome Utente</th>
        <th>Link Originale</th>
        <th>Link Shortato</th>
        <th>Login Count</th>
    </tr>

    <?php
    // Mostra tutti i link shortati
    if ($result->num_rows > 0) {
        // Cicla e mostra i link
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . htmlspecialchars($row['username']) . "</td>
                    <td>" . htmlspecialchars($row['link_org']) . "</td>
                    <td><a href='r.php?l_s=" . urlencode($row['link_short']) . "' target='_blank'>" . htmlspecialchars($row['link_short']) . "</a></td>
                    <td>" . htmlspecialchars($row['login_count']) . "</td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='4'>Nessun link trovato.</td></tr>";
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