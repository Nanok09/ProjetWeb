<?php
//======================== CE FICHIER SERA A SUPPRIMMER DANS LA VERSION FINALE=========================
include_once("modele.php");

//hotel de ville lat, long = 48.856614,2.3522219

$id_place= 1;

$result = get_note_place($id_place);

var_dump($result);
