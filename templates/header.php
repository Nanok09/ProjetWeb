<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"
        integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link rel="stylesheet" href="css/common.css" type="text/css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar-scheduler@5.6.0/main.min.css"
        type="text/css">
    <link rel="stylesheet" type="text/css" href="../css/header.css">
    <title>Sport'BnB</title>

    <!-- Font Awesome JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js"
        integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous">
    </script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js"
        integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous">
    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar-scheduler@5.6.0/main.min.js"></script>


    <style>
    body {
        font-family: "Avenir Next";
    }

    ul.navbar-nav a:hover {
        background-color: #153455;
        border-radius: 20px !important;
    }

    #deconnexion:hover {
        color: red !important;
    }

    ul.navbar-nav a:hover {
        color: white !important;
    }
    </style>



</head>

<body>



    <nav class="navbar navbar-expand-lg navbar-light shadow">
        <a class="navbar-brand" href="index.php?view=accueil">
            <img src="images/Logo.svg" width="200" height="50" alt="">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample08"
            aria-controls="navbarsExample08" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-md-center" id="navbarsExample08">
            <ul class="navbar-nav">
                <li class="nav-item active border-right border-dark">
                    <a class="nav-link" href="index.php?view=accueil">Accueil<span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item border-right border-dark">
                    <a class="nav-link" href="index.php?view=recherche">Rechercher</a>
                </li>
                <li class="nav-item border-right border-dark">
                    <a class="nav-link" href="index.php?view=louer" tabindex="-1" aria-disabled="true">Louer</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?view=mesTerrains">Mes Terrains</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="dropdown08" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">Compte</a>
                    <div class="dropdown-menu" aria-labelledby="dropdown08">
                        <a class="dropdown-item" href="index.php?view=mon-compte">Mon Compte</a>
                        <a class="dropdown-item" href="index.php?view=chat">Mes discussions</a>
                        <?php
if (valider("is_connected", "SESSION")) {
    echo "<a id=\"deconnexion\" class=\"dropdown-item text-danger\" href=\"controleur.php?action=Logout\">Se Déconnecter</a>";
} else {
    echo " <a class=\"dropdown-item\" href=\"index.php?view=login-signIn\">Inscription/Connexion</a>";
}
?>
                    </div>
                </li>
            </ul>
        </div>
    </nav>