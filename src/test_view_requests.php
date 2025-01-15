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

    echo "Visualizzazione della variabile \$_REQUEST con var_dump():<br>";
    var_dump($_REQUEST);
    echo"<br><br>";

    echo "Contenuto della richiesta:<br>";
    if($_SERVER['REQUEST_METHOD'] == 'GET')
    {
        echo "GET:<br>";
        print_r($_GET);

        //visualizza i dati ricevuti dalla post/get
        //iterando gli elementi dell'array associativo
        foreach($GET as $key=>$value)
        {
            echo "$key=$value";
            echo"<br>";
        }
    }
    elseif ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        echo "POST:<br>";
        print_r($POST);

        //visualizza i dati ricevuti dalla post/get
        //iterando gli elementi dell'array associativo
        foreach($POST as $key=>$value)
        {
            echo "$key=$value";
            echo"<br>";
        }
    }