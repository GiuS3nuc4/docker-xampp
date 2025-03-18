<?php
require_once 'includes/db.php';

$table = "users";
$query = "SELECT * FROM $table";
$result = $conn->query($query);

if ($result->num_rows > 0 )
{
    echo "<table>";

    while($column = $result->fetch_field())
    {
        //var_dump($column);
        echo "<th>";
        echo $column->name;
        echo "</th>";
    }
    // Stampo il contenuto della tabella
    while ($row = $result->fetch_assoc())
    {
        // Inserimento delle tuple della tabella
        
        echo "<tr>";
        foreach ($row as $key => $value)
        {
            echo "<td>$value</td>";
        }
        echo "</tr>";
    }
    echo "</table>";    
}
