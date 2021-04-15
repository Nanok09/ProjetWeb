<?php
//======================== CE FICHIER SERA A SUPPRIMMER DANS LA VERSION FINALE=========================
include_once("modele.php");

//hotel de ville lat, long = 48.856614,2.3522219
/*
$raw= 'Avenue paul langevin';

//$result = get_note_place($id_place);

//var_dump($result);
$id_auteur = 1;
$id_destinataire = 4;

$result = add_message_to_conv(1,4,5,'ça faisait longtemps! :) ');



$coded = urlencode($raw);
echo '<h2> Version codée : </h2>';
var_dump($coded);
echo 'echo <h2> Version décodée : </h2>';
var_dump(urldecode($coded));
date('d-m-Y h:i:s')
*/
$test = (int) date('h');
$date = date('H:i:s');
echo $date;


var_dump(strval($test + 1));
