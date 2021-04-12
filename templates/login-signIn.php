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
//    echo $container;
}
?>
<style>
    .active{
        font-weight: bold;
    }

    .hidden{
        display: none;
    }

    .bold{
        font-weight: bold;
    }

</style>

<script>

    $("window").ready(function (){



        $("#inscription").click( function (event){
            afficherInscription();
            animerBarre("525px");
            texteGras(event);
            $("#connexion>h1").removeClass("bold");
        })

        $("#connexion").click( function (event){
            afficherConnexion();
            animerBarre("210px");
            texteGras(event);
            $("#inscription>h1").removeClass("bold");


        })


        function afficherConnexion (){
            $("#inscriptionForm").fadeOut("fast", function (){

            });
            $("#connexionForm").fadeIn("slow", function (){

            });


            // $("#inscriptionForm").addClass("hidden");
            // $("#connexionForm").removeClass('hidden');
        }

        function afficherInscription (){
            $("#connexionForm").fadeOut("fast", function (){

            });
            $("#inscriptionForm").fadeIn("slow", function (){

            });

            // $("#connexionForm").addClass("hidden");
            // $("#inscriptionForm").removeClass('hidden');
        }

        function animerBarre(position){
            // $("#barre").css("left", position);
            $("#barre").animate({left:position});
        }
        function texteGras(truc){
            $(truc.target).addClass("bold");
        }
    })


</script>
<div id="container" class="bg-custom-grey container mt-5 custom-rounded-corners">

    <div class="row justify-content-center">
        <div class="col-4 border-right border-dark text-center my-2" id="connexion">
            <h1 class="bold">Connexion</h1>
        </div>
        <div class="col-4 text-center my-2" id="inscription">
            <h1>Inscription</h1>
        </div>
        <div class="col-12">
            <div id="barre" class="mb-2 display-block d-block position-relative" style="width: 200px; border-top: 5px solid black; left: 210px;"> <!-- 22% et 56%-->

            </div>
        </div>

    </div>
    <form id="connexionForm" action="controleur.php" method="GET" class="form-row justify-content-center">
        <input type="text" value="" name="pseudo" placeholder="pseudo" class="form-control col-8"/>
        <div class="w-100"></div>
        <input type="password" name="password" placeholder="mot de passe" class="form-control col-8"/>
        <div class="w-100"></div>
        <div class="form-group col-8">
            <input type="checkbox" name="ResterCo" />
            <label for="ResterCo">Rester connecté</label>
            <input type="submit" name="action" value="Se connecter"/>

        </div>
        <div class="w-100"></div>
    </form>

    <form id="inscriptionForm" action="controleur.php" method="GET" class="form-row justify-content-center">
        <input type="email" name="email" placeholder="example@gfin.fr" class="form-control col-8"/>
        <div class="w-100"></div>
        <input type="text" name="pseudo" placeholder="pseudo" class="form-control col-8"/>
        <div class="w-100"></div>
        <input type="text" name="nom" placeholder="nom" class="form-control col-8"/>
        <div class="w-100"></div>
        <input type="text" name="prenom" placeholder="prénom" class="form-control col-8"/>
        <div class="w-100"></div>
        <input type="password" name="password" placeholder="mot de passe" class="form-control col-8"/>
        <div class="w-100"></div>
        <input type="submit" name="action" value="Inscription"/>
    </form>
    <!-- Connexion -->
<!--    <h1>Connexion</h1>-->
<!--    <form id="connexion" action="controleur.php" method="GET">-->
<!--        <input type="text" value="" name="pseudo" placeholder="pseudo"/>-->
<!--        <input type="password" name="password" placeholder="mot de passe"/>-->
<!--        <input type="checkbox" name="ResterCo" />-->
<!--        <label for="ResterCo">Rester connecté</label>-->
<!--        <input type="submit" name="action" value="Se connecter"/>-->
<!--    </form>-->
<!---->
    <!-- Inscription -->
<!--    <h1>Inscription</h1>-->
<!--    <form id="inscription" action="controleur.php" method="GET">-->
<!--        <input type="email" name="email" placeholder="example@gfin.fr"/>-->
<!--        <input type="text" name="pseudo" placeholder="pseudo"/>-->
<!--        <input type="text" name="nom" placeholder="nom"/>-->
<!--        <input type="text" name="prenom" placeholder="prénom"/>-->
<!--        <input type="password" name="password" placeholder="mot de passe"/>-->
<!--        <input type="submit" name="action" value="Inscription"/>-->
<!--    </form>-->
</div>
