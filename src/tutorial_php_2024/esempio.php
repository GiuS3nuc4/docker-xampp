<?php

$operatore1 = 3; //intero
$operatore2 = 5.10; //double
$operatore3 = '10'; //numero in stringa


// 1) interi is_int()
var_dump(is_int($operatore1)); //restituisce un boolean

// 2) float is_float()
var_dump(is_float($operatore2)); //restituisce un boolean

// 3) numeri vs numeri stringhe is_numeric()
echo $operatore1 + $operatore2; //risultato=8.1
echo $operatore1 + $operatore3; //risultato= 13
$risultato = $operatore1 + $operatore3;
var_dump($risultato);// intero

// 5) cast da stringhe a numeri (int)$stringa
$operatore3 = (int)'10'; //castare
var_dump($operatore3);

?>