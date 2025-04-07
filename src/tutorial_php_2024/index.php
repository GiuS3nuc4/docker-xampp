<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tutorial PHP 2024</title>
    <style>
        form{
            display: flex;
            flex-direction: column;
            width: 200px;
            padding: 40px;
        }
        label{
            margin-bottom: 5px;
        }
        input{
            margin: 10px 0;
        }
    </style>
</head>

<?php
$nome = 'Nome';
?>
<body>
    <h1>Form Esempio</h1>
    <form method="POST" action="esempio.php">
        <label for="nome"><?php echo $nome; ?></label>
        <input type="text" id="nome" name="nome" placeholder="Inserisci nome">
        <label for="cognome">Cognome</label>
        <input type="text" id="cognome" name="cognome" placeholder="Inserisci cognome">
        <input type="submit" value="Invia dati">
    </form>
</body>
</html>