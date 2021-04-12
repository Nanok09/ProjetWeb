<?php
session_start();

include_once "libs/maLibUtils.php";
include_once "libs/maLibSQL.pdo.php";
include_once "libs/maLibSecurisation.php";
include_once "libs/modele.php";

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

        case 'Créer terrain':
            if (($nom = valider('nom')) &&
                ($adresse = valider('adresse')) &&
                ($sport = valider('sport')) &&
                ($prix = valider('prix')) &&
                ($capacite = valider('capacite')) &&
                ($prive = valider('type')) &&
                ($description = valider('description'))
            ){
                $createur_id = valider('id_user','SESSION');
                //create_place($nom,$description,$adresse,$lat,$long,$sport,$prive,$createur_id,$prix,$capacite);
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
