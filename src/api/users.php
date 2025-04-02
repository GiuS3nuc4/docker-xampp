<?php
require '../Includes/db.php';

header ('Content-Type: application/json');

$sql = "SELECT nome, cognome, email FROM utenti";
$result = $conn->query($sql);

$data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        //array_push($data, $row);
        $data[] = $row;
    }
}

echo json_encode($data);

$conn->close();