<?php

    //if($_GET == null)
        //echo "Richiesta non tramite GET";
    //else if ($_POST == null)
        //echo "Richiesta non tramite POST";

    if($_GET != null){
        $username = $_GET['username'];
        $pw = $_GET['pw'];

        //connessione al db
        //...

        $query = SELECT * FROM utenti WHERE username='$username' AND pw='$pw';
    }
    else if ($_POST == null)
        echo "Richiesta non tramite POST";