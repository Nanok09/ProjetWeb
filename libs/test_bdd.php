<?php
//======================== CE FICHIER SERA A SUPPRIMMER DANS LA VERSION FINALE=========================
include_once("modele.php");

//hotel de ville lat, long = 48.856614,2.3522219

$raw= 'Avenue paul langevin';

//$result = get_note_place($id_place);

//var_dump($result);

$coded = urlencode($raw);
echo '<h2> Version codée : </h2>';
var_dump($coded);
echo 'echo <h2> Version décodée : </h2>';
var_dump(urldecode($coded));

