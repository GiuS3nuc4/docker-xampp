<?php
// Imposta il nome del cookie e la durata (7 giorni)
$cookie_name = "visite";
$cookie_value = isset($_COOKIE[$cookie_name]) ? $_COOKIE[$cookie_name] + 1 : 1;

// Imposta il cookie
setcookie($cookie_name, $cookie_value, time() + (86400 * 7), "/"); // scade tra 7 giorni

// Verifica se il cookie esiste
if (isset($_COOKIE[$cookie_name])) {
    echo "Hai visitato questa pagina " . $_COOKIE[$cookie_name] . " volte.";
} else {
    echo "Benvenuto! Questa è la tua prima visita.";
}
?>