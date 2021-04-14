<?php
include_once "libs/modele.php";
include_once "libs/libUtils.php";
include_once "libs/libForms.php";

// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
if (basename($_SERVER["PHP_SELF"]) != "index.php") {
    header("Location:../index.php?view=login-signIn");
    die("");
}

//TODO: redirect vers accueil si on est connecté
?>
<script src="js/login-signIn.js" type="text/javascript"></script>
<div id="containerLogin" class="bg-custom-grey container mt-5 custom-rounded-corners col-xl-6">
    <div class="row justify-content-center">
        <div class="col-6 border-right border-dark text-center my-2" role="button" id="connexion">
            <h1 class="bold">Connexion</h1>
        </div>
        <div class="col-6 text-center my-2" role="button" id="inscription">
            <h1>Inscription</h1>
        </div>
        <div class="col-12">
            <div id="barre" class="mb-2 display-block d-block position-relative">
            </div>
        </div>

        <?php
        if ($msg = valider('msg')) { ?>
        <div class="alert alert-danger col-6" role="alert">
            <?php echo $msg; ?>
        </div>
        <?php
        }
        ?>
    </div>
    <div id="formContainer">
        <form id="connexionForm" action="controleur.php" method="GET" class="form-row justify-content-center">
            <input type="text" value="" name="pseudo" placeholder="pseudo" class="form-control col-8" />
            <div class="w-100"></div>
            <input type="password" name="password" placeholder="mot de passe" class="form-control col-8" />
            <div class="w-100"></div>
            <div class="form-group col-8">
                <input type="checkbox" name="ResterCo" />
                <label for="ResterCo">Rester connecté</label>
                <input type="submit" name="action" value="Se connecter" />

            </div>
            <div class="w-100"></div>
        </form>

        <form id="inscriptionForm" action="controleur.php" method="GET" class="form-row justify-content-center">
            <input type="email" name="email" placeholder="example@gfin.fr" class="form-control col-8" />
            <div class="w-100"></div>
            <input type="text" name="pseudo" placeholder="pseudo" class="form-control col-8" />
            <div class="w-100"></div>
            <input type="text" name="nom" placeholder="nom" class="form-control col-8" />
            <div class="w-100"></div>
            <input type="text" name="prenom" placeholder="prénom" class="form-control col-8" />
            <div class="w-100"></div>
            <input type="password" name="password" placeholder="mot de passe" class="form-control col-8" />
            <div class="w-100"></div>
            <input type="submit" name="action" value="Inscription" />
        </form>
    </div>
</div>