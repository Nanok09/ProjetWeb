<?php

include_once("modele.php");

//hotel de ville lat, long = 48.856614,2.3522219

$description = "j'ai modifié juste le lieu 5";
$adresse = '5 rue du moulin bleu!';


$result = get_info(4);
var_dump($result);
