


<!-- **** F O O T E R **** -->
<?php
// Si l'utilisateur est connecte, on affiche un lien de deconnexion
if (valider("connecte","SESSION"))
{
    echo "Utilisateur <b>$_SESSION[pseudo]</b> connecté depuis <b>$_SESSION[heureConnexion]</b> &nbsp; ";
    echo "<a href=\"controleur.php?action=Logout\">Se Déconnecter</a>";
}
?>


<div class="container-fluid pb-0 mb-0 justify-content-center text-light " style="background-color: #153455">
    <footer>
        <div class="row my-5 justify-content-center py-5">
            <div class="col-11">
                <div class="row ">
                    <div class="col-xl-8 col-md-4 col-sm-4 col-12 my-auto mx-auto a">
                        <h1 class="mb-md-0 mb-5 bold-text" style="color: #fdedcf">Sport'bnb</h1>
                    </div>
                    <div class="col-xl-2 col-md-4 col-sm-4 col-12">
                        <h6 class="mb-3 mb-lg-4" style="color: #fdedcf"><b>MENU</b></h6>
                        <ul class="list-unstyled">
                            <li><a href="#" style="color: white">Accueil</a></li>
                            <li><a href="#" style="color: white">Rechercher</a></li>
                            <li><a href="#" style="color: white">Louer</a></li>
                            <li><a href="#" style="color: white">Mon Compte</a></li>
                        </ul>
                    </div>
                    <div class="col-xl-2 col-md-4 col-sm-4 col-12">
                        <h6 class="mb-3 mb-lg-4 mt-sm-0 mt-5" style="color: #fdedcf"><b>ADDRESSE</b></h6>
                        <p class="mb-1">AVENUE PAUL LANGEVIN</p>
                        <p>RESIDENCE LEONARD DE VINCI</p>
                    </div>
                </div>
                <div class="row ">
                    <div class="col-xl-8 col-md-4 col-sm-4 col-auto my-md-0 mt-5 order-sm-1 order-3 align-self-end">
                        <p class="social text-muted mb-0 pb-0 bold-text"> <span class="mx-2"><i class="fa fa-facebook" aria-hidden="true"></i></span> <span class="mx-2"><i class="fa fa-linkedin-square" aria-hidden="true"></i></span> <span class="mx-2"><i class="fa fa-twitter" aria-hidden="true"></i></span> <span class="mx-2"><i class="fa fa-instagram" aria-hidden="true"></i></span> </p><small class="rights"><span>&#174;</span> Sport'bnb All Rights Reserved.</small>
                    </div>
                    <div class="col-xl-2 col-md-4 col-sm-4 col-auto order-1 align-self-end ">
                        <h6 class="mt-55 mt-2 bold-text" style="color: #fdedcf"><b>NOUS CONTACTER</b></h6><small> <span><i class="fa fa-envelope" aria-hidden="true"></i></span> contact@sportbnb.com</small>
                    </div>
                    <div class="col-xl-2 col-md-4 col-sm-4 col-auto order-2 align-self-end mt-3 ">
                        <h6 class="bold-text" style="color: #fdedcf"><b>FAIRE UN DON</b></h6><small><span><i class="fa fa-envelope" aria-hidden="true"></i></span><a href="#" style="color: white">www.faireundon.fr</a></small>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</div>


</body>
</html>
