<?php

include_once("modele.php");

//hotel de ville lat, long = 48.856614,2.3522219

$test = get_places(false, false, false, 48.856614,2.3522219);


echo '<h2> Après tri </h2>';
var_dump($test);