<?php
    echo "Tipo di richiesta: " . $_SERVER['REQUEST_METHOD'] . "<br>";

    echo "<br>";

    echo "Visualizzazione della variabile \$_REQUEST con echo:<br>";
    //non sempre la echo è la scelta giusta!
    //si aspetta una stringa!
    echo "$_REQUEST<br>";
    echo "<br>";

    echo "Visualizzazione della variabile \$_REQUEST con print_r():<br>";
    //visualizza le informazioni in maniera human readable
    print_r($_REQUEST);
    echo "<br><br>";