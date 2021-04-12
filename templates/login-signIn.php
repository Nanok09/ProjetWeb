<?php
include_once "libs/modele.php";
include_once "libs/libUtils.php";
include_once "libs/libForms.php";

// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
if (basename($_SERVER["PHP_SELF"]) != "index.php") {
    header("Location:../index.php?view=login-signIn");
    die("");
}

$container = '
<div id="container">
    <!-- Connexion -->
    <h1>Connexion</h1>
    <form id="connexion" action="controleur.php" method="GET">
        <input type="text" value="" name="pseudo" placeholder="pseudo"/>
        <input type="password" name="password" placeholder="mot de passe"/>
        <input type="checkbox" name="ResterCo" />
        <label for="ResterCo">Rester connecté</label>
        <input type="submit" name="action" value="Se connecter"/>
    </form>

    <!-- Inscription -->
    <h1>Inscription</h1>
    <form id="inscription" action="controleur.php" method="GET">
        <input type="email" name="email" placeholder="example@gfin.fr"/>
        <input type="text" name="pseudo" placeholder="pseudo"/>
        <input type="text" name="nom" placeholder="nom"/>
        <input type="text" name="prenom" placeholder="prénom"/>
        <input type="password" name="password" placeholder="mot de passe"/>
        <input type="submit" name="action" value="Inscription"/>
    </form>
</div>
';

if ($msg = valider('msg')) {
    $container .= "<span style='color:red'>$msg</span>";
}

?>

<?php
if (valider("is_connected", "SESSION")) {
    if ($pseudo = valider("pseudo", "SESSION")) {
        echo "Vous êtes connecté en tant que " . $pseudo . ".";
    }
} else {
    echo $container;
}
?>