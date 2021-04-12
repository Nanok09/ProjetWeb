<?php
// Si l'utilisateur est connecte, on affiche un lien de deconnexion
if (valider("connecte","SESSION"))
{
    echo "Utilisateur <b>$_SESSION[pseudo]</b> connecté depuis <b>$_SESSION[heureConnexion]</b> &nbsp; ";
    echo "<a href=\"controleur.php?action=Logout\">Se Déconnecter</a>";
}
?>

    <style>
        body {
            background-color: #fdedcf;
            font-family: "Avenir Next";
        }

        .padding {
            padding: 3rem !important
        }

        .user-card-full {
            overflow: hidden
        }

        .card {
            border-radius: 15px;
            border: none;
            margin-bottom: 30px
        }

        .card-block{
            color:#fdedcf;
        }

        .m-r-0 {
            margin-top:6px;
            margin-right: 0px
        }

        .m-l-0 {
            margin-top:6px;
            margin-left: 0%
        }

        .m-b-20{
            margin-top: 30px;
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
<h1 style="color: #123455; text-align: center; margin-top: 40px;">Mon Compte</h1>
<div class="page-content page-container" id="page-content" >
    <div class="padding">
        <div class="row container d-flex justify-content-center" >
            <div class="col-xl-6 col-md-12" >
                <div class="card user-card-full" style="background-color:#123455">
                    <div class="row m-l-0 m-r-0 " >
                        <div class="col-sm-12" >
                            <div class="card-block">
                                <h3 class="mt-5 ml-3 b-b-default f-w-600">Information</h3>
                                <div class="row justify-content-center">
                                    <div class="col-sm-4 text-center">
                                        <p class="m-b-10 f-w-600"><u>Prénom</u></p>
                                        <h6 class=" f-w-400">Capitain</h6>
                                    </div>
                                    <div class="col-sm-4 text-center">
                                        <p class="m-b-10 f-w-600"><u>Nom</u></p>
                                        <h6 class=" f-w-400">Haddock</h6>
                                    </div>
                                    <div class="col-sm-4 text-center">
                                        <p class="m-b-10 f-w-600"><u>Email</u></p>
                                        <h6 class=" f-w-400">capitain.haddock@gmail.com</h6>
                                    </div>
                                </div>
                                <h3 class="mt-2 ml-3 b-b-default f-w-600">Locations</h3>
                                <div class="row">
                                    <div class="col-sm-5 text-center">
                                        <p class="m-b-10 f-w-600"><u>Location 1</u></p>
                                        <h6 class=" f-w-400">Nom de la location</h6>
                                    </div>
                                    <div class="col-sm-6 text-center">
                                        <p class="m-b-10 f-w-600">Photo Location</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>