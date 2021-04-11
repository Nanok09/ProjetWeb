<link rel="stylesheet" type="text/css" href="../css/footer.css">

<!-- **** F O O T E R **** -->
<?php
// Si l'utilisateur est connecte, on affiche un lien de deconnexion
if (valider("is_connected", "SESSION")) {
    echo "Utilisateur <b>$_SESSION[pseudo]</b> connecté depuis <b>$_SESSION[heure_connexion]</b> &nbsp; ";
    echo "<a href=\"controleur.php?action=Logout\">Se Déconnecter</a>";
}
?>
<div class="footer-dark">
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-md-3 item">
                    <h3><img src="images/logo.png"> École Centrale de Lille © 2020-2021</h3>
                    <ul>
                        <li><a href="#">Mentions légales</a></li>
                        <li><a href="#">Nous écrire</a></li>
                        <li><a href="#">Statistiques</a></li>
                        <li><a href="#">Données et cookies</a></li>
                        <div>Icons made by <a href="https://www.flaticon.com/authors/mavadee" title="mavadee">mavadee</a> from <a href="https://www.flaticon.com/" title="Flaticon">www.flaticon.com</a></div>

                    </ul>
                </div>
                <div class="col-sm-6 col-md-3 item">
                    <h3>Mieux nous connaître</h3>
                    <ul>
                        <li><a href="#">Notre équipe</a></li>
                        <li><a href="https://centralelille.fr/">Centrale Lille</a></li>
                    </ul>
                </div>
                <div class="col-sm-6 col-md-3 item">
                    <h3>Vous avez besoin d'aide</h3>
                    <ul>
                        <li><a href="#">Assistance</a></li>
                        <li><a href="#">Application</a></li>
                        <li><a href="#">Service Client</a></li>
                    </ul>
                </div>
                <div class="col item social mt-5"><a href="#"><i class="fab fa-facebook-f"></i></a><a href="#"><i class="fab fa-twitter"></i></a><a href="#"><i class="fab fa-linkedin-in"></i></a></div>
            </div>
        </div>
    </footer>
</div>


</body>
</html>
