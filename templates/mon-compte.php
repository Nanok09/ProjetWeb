<?php
// Si l'utilisateur est connecte, on affiche un lien de deconnexion
if (valider("connecte","SESSION"))
{
    echo "Utilisateur <b>$_SESSION[pseudo]</b> connecté depuis <b>$_SESSION[heureConnexion]</b> &nbsp; ";
    echo "<a href=\"controleur.php?action=Logout\">Se Déconnecter</a>";
}
?>


