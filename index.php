<?php
session_start();


if (basename($_SERVER["PHP_SELF"]) != "index.php") {
    header("Location:../index.php");
    die("");
}

include_once("libs/maLibUtils.php");

include("templates/header.php");

$view = valider("view");


if(!$view) $view = "accueil";

switch($view) {



    case "accueil":
        include("templates/accueil.php");
        break;

    default : // si le template correspondant à l'argument existe, on l'affiche
        if (file_exists("templates/".$view.".php")) {
            include("templates/".$view.".php");
        }
}
include("templates/footer.php");


?>