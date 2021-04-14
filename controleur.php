<?php
session_start();

include_once "libs/libUtils.php";
include_once "libs/libSQL.pdo.php";
include_once "libs/libSecurisation.php";
include_once "libs/modele.php";
include_once "libs/upload_photo.php";

tprint($_POST);

$qs = "";

if ($action = valider("action")) {
    ob_start();

    echo "Action = '$action' <br />";

    switch ($action) {

        // Connexion //////////////////////////////////////////////////

        case 'Se connecter':
            echo "j'ai compris que tu veux te connecter";
            if (($pseudo = valider('pseudo')) &&
                ($password = valider('password'))
            ) {
                if (!verif_user($pseudo, $password)) {
                    $qs = "?view=login-signIn&msg=Mauvais identifiants de connexion, si vous n'avez pas de compte inscrivez vous!";
                } else {
                    $qs = "?view=accueil";
                }
                if (valider('ResterCo')) {
                    setcookie("password", $password);
                    setcookie("pseudo", $pseudo);
                }
            } else {
                $qs = "?view=login-signIn&msg=Pour vous connecter, renseignez votre pseudo et mot de passe";
            }
            break;

        // Inscription //////////////////////////////////////////////////

        case 'Inscription':
            if (($pseudo = valider('pseudo')) &&
                ($password = valider('password')) &&
                ($nom = valider('nom')) &&
                ($prenom = valider('prenom')) &&
                ($email = valider('email'))
            ) {
                create_user($pseudo, $password, $email, $nom, $prenom);
                verif_user($pseudo, $password);
                $qs = "?view=accueil";
            } else {
                $msg = "Veuillez remplir toutes les informations nécessaires à l%E2%80%99inscription";
                $qs = "?view=login-signIn&msg=" . $msg;
            }
            break;

        // Déconnexion //////////////////////////////////////////////////

        case 'Logout':
            session_destroy();
            setcookie('pseudo');
            setcookie('password');
            unset($_COOKIE['pseudo']);
            unset($_COOKIE['password']);
            $qs = "?view=login-signIn";
            break;

        // Création terrain //////////////////////////////////////////////////

        case 'Créer terrain':
            if (($nom = valider('nom')) &&
                ($sport = valider('sport')) &&
                ($coord = valider('coord'))
            ) {
                $createur_id = valider('id_user', 'SESSION');
                $coord = str_replace("\\", '', $coord);
                $coord = json_decode($coord, true);



                $adresse = $coord['address'];
                $lat = $coord['coordinates']['lat'];
                $long = $coord['coordinates']['long'];
                if (!($prive = valider('prive'))) {
                    $prive = 0;
                }
                if (!($capacite = valider('capacite'))) {
                    $capacite = 10;
                }
                if (!($prix = valider('prix'))) {
                    $prix = 0;
                }
                if (!($description = valider('description'))) {
                    $description = '';
                }
                $id_place=create_place($nom, $lat, $long, $sport, $prive, $createur_id, $prix, $capacite, $description, $adresse);
                $upload_done = upload($_FILES["fileToUpload"]);
                echo $id_place;
                if ($upload_done){
                    add_photo_place(intval($id_place), $_FILES["fileToUpload"]["name"]);
                }
                $qs = "?view=mesTerrains";
            } else {
                $qs = "?view=mesTerrains&msg=Veuillez au moins remplir le nom, l'adresse et le sport";
            }
            break;

        // Ajout créneau //////////////////////////////////////////////////

        case 'ajouter créneau':
            if (($debut=valider('debut')) &&
                ($fin=valider('fin')) &&
                ($id_place=valider('id_place')) &&
                ($capacite = valider('capacite')) &&
                ($date = valider('date'))
            ){
                if($debut<$fin){
                    add_creneau_dispo($id_place, $date, $debut, $fin, $capacite);
                    $qs="?view=mesTerrains";
                }else{
                    $qs="?view=mesTerrains&msg2=Erreur : heure de debut > heure de fin";
                }
            }else{
                $qs="?view=mesTerrains&msg2=Pour ajouter un créneau, veuillez remplir tous les champs.";
            }
            echo $debut;
            echo $fin;
            echo $date;
            echo $capacite;
            echo $id_place;
            break;

        // Ajout photo //////////////////////////////////////////////////

        case 'ajouter photo':
            if ($id_place = valider('id_place')){
                $upload_done = upload($_FILES["fileToUpload"]);
                echo $upload_done."</br>";
                echo $id_place;
                if ($upload_done){
                    add_photo_place(intval($id_place), $_FILES["fileToUpload"]["name"]);
                    $qs="?view=mesTerrains";
                }else{
                    $qs="?view=mesTerrains&msg3=Erreur lors de l upload.";
                }
            }
            break;

        // Modifier infos terrains //////////////////////////////////////////////////

        case 'modif_place':
            if ($id_place = valider('id_place')){
                $user_id=valider('id_user', 'SESSION');
                $modification=[];
                if ($nom = valider('nom')){
                    $modification['nom'] = $nom;
                }
                if ($description = valider('description')){
                    $modification['description'] = $description;
                }
                if ($capacite = valider('capacite')){
                    $modification['capacite'] = $capacite;
                }
                if ($prix = valider('prix')){
                    $modification['prix'] = $prix;
                }
                if ($sport = valider('sport')){
                    $modification['sport'] = $sport;
                }
                tprint($modification);
                modify_place($id_place, $user_id, $modification);
                $qs = "?view=mesTerrains";
            }
            break;

    }

}

// On redirige toujours vers la page index, mais on ne connait pas le répertoire de base
// On l'extrait donc du chemin du script courant : $_SERVER["PHP_SELF"]
// Par exemple, si $_SERVER["PHP_SELF"] vaut /chat/data.php, dirname($_SERVER["PHP_SELF"]) contient /chat

//$urlBase = dirname($_SERVER["PHP_SELF"]) . "/index.php";
// On redirige vers la page index avec les bons arguments


header("Location:" . "index.php" . $qs);


//qs doit contenir le symbole '?'

// On écrit seulement après cette entête
ob_end_flush();



?>