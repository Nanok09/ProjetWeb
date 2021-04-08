<?php
include_once("libs/modele.php");
include_once("libs/maLibUtils.php");
include_once("libs/maLibForms.php");
?>


<?php

$container='

<div id="container">
    <!-- Connexion -->
    <h1>Connexion</h1>
    <form id="connexion" action="controleur.php">
        <input type="text" name="pseudo" placeholder="pseudo"/>
        <input type="password" name="password" placeholder="mot de passe"/>
        <input type="checkbox" name="ResterCo" />
        <label for="ResterCo">Rester connecté</label>
        <input type="submit" name="action" value="Se connecter"/>
    </form>
    
    <!-- Inscription -->
    <h1>Inscription</h1>
    <form id="inscription" action="controleur.php">
        <input type="email" name="email" placeholder="example@gfin.fr"/>
        <input type="text" name="pseudo" placeholder="pseudo"/>
        <input type="text" name="nom" placeholder="nom"/>
        <input type="text" name="prenom" placeholder="prénom"/>
        <input type="password" name="password" placeholder="mot de passe"/>
        <input type="submit" name="action" value="S\'inscrire"/>
    </form>
</div>
';

if ($msg=valider('msg')){
    $container .= "<span style='color:red'>$msg</span>";
}

?>

<?php
    if (valider("connecte","SESSION")){
        header('index.php');
    }else{
        echo $container;
    }
?>


