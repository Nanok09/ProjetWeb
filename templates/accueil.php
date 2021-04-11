<?php



?>
<style>
    #imageLoupe{
        max-width: 5%;
    }
    #imageLoupe2{
        max-width: 5%;
        transform: translateY(-10px);
    }
    .sportLogos{
        max-height: 120px;
    }
    .sportLogos:hover{
        transform: translateY(-10px);
        cursor:pointer;
    }
    .sportLogos2{
        max-height: 200px;
        max-width: 200px;
        margin: 10px;
    }
    .sportLogos2:hover{
        transform: translateY(-10px);
        cursor:pointer;
        z-index: 2000;
    }

    #searchbar:hover{
        cursor: pointer;

    }

    .bg-custom-grey{
        background-color: #dcdcdc;
    }



    .carouselControls{
        width: 5%;
    }
    .carouselControls >
    .carousel-control-prev-icon,
    .carousel-control-next-icon {
        height: 100px;
        width: 100px;
        outline: black;
        background-size: 100%, 100%;
        border-radius: 50%;
        background-image: none;
    }

    .carouselControls > .carousel-control-next-icon:after
    {
        content: '>';
        font-size: 55px;
        color: #b39769;
    }

    .carouselControls > .carousel-control-prev-icon:after {
        content: '<';
        font-size: 55px;
        color: #b39769;
    }




    #svg{
        transform: translateY(-10px);
        width: 100px;
        height: 80px;
    }

    .hoveredCircle{
        r:35;
        transform: translateY(5px);
        cursor:pointer;
    }


    @media (max-width: 576px) {
        #svg{
            transform: translateY(-20px);
        }
        #svg > circle{
            r:20;
        }
        .hoveredCircle{
            r:25;
            cursor:pointer;
        }
        #svg > image{
            height: 25px;
            width: 25px;
        }

    }

    .custom-rounded-corners{
        border-radius: 50px;
    }
    #containerCroix{
        right: 0;
    }
    #imageCroix{
        width: 30px;
        height: auto;
    }
    #imageCroix:hover{
        width: 40px;
        cursor: pointer;
    }



</style>

<script>
    $(window).ready(function(){

        $("#searchbar").hover(
            function() {
                let jSearchbar = $(this)
                jSearchbar.addClass('shadow')
                jSearchbar.css("background-color", '#fafafa')
                jSearchbar.removeClass('bg-light')
            },
            function(){
                let jSearchbar = $(this)
                jSearchbar.removeClass('shadow')
                jSearchbar.css("background-color", "")
                jSearchbar.addClass('bg-light')}
        )

        $("#searchbar").click(
            function (){
                $("#recherche").removeClass("d-none");
                $("#blockRecherche").addClass("d-none");
            }
        )

        $("#svg").hover(function (){
            $("#svg>circle").addClass("hoveredCircle")
        }, function(){
            $("#svg>circle").removeClass('hoveredCircle');
        });

        $("#svg").click(function(){
            console.log("click svg")
            $("#rechercheForm").trigger("submit");
            return false;
        });

        $("#rechercheForm").submit(function (event){

        });

        $("#containerCroix").click(function(){
            $("#recherche").addClass("d-none");
            $("#blockRecherche").removeClass("d-none");
        })
    });

</script>
<div class="container">
    <div class="my-5"></div>
    <div id="recherche" class="row justify-content-center d-none">
        <div class="col-8 bg-custom-grey text-center custom-rounded-corners">
            <div id="containerCroix" class="position-absolute"> <img id="imageCroix" src="../images/croix.png" class="d-block"> </div>
            <svg id="svg">
                <circle r="30" cx="50%" cy="30" fill="#35516E">

                </circle>
                <image href="../images/loupe.png" x="35%" y="15" height="35px" width="35px" />
            </svg>
            <form id="rechercheForm" action="../controleur.php" name="recherche" method="get">
                <div class="form-row justify-content-center">
                    <div class="col-8">
                        <div class="form-group">
                            <label for="selectSport">Choisissez votre sport</label>
                            <select id="selectSport" class="form-control custom-rounded-corners">
                                <option>Basket</option>
                                <option>Foot</option>
                                <option>Musculation</option>
                            </select>
                        </div>
                    </div>
                    <div class="w-100"></div>

                    <div class="col-8 mb-2">
                        <input class="form-control custom-rounded-corners" type="text" name="adresse" placeholder="Adresse">
                    </div>
                    <div class="w-100"></div>
                    <div class="col-8 mb-2">
                        <input class="form-control custom-rounded-corners" type="text" name="horaire" placeholder="Horaire">
                    </div>
                    <div class="w-100"></div>
                    <div class="col-8 mb-2">
                        <input class="form-control custom-rounded-corners" type="text" name="prix" placeholder="Prix">
                    </div>
                    <input type="text" name="action" value="Recherche" class="d-none">
                </div>
            </form>
        </div>
    </div>
    <div id="blockRecherche" class="row justify-content-center">
        <div class="col col-xl-10 rounded-pill bg-custom-grey my-2 py-3">
            <h1 class="text-center">Rechercher des terrains proches de vous !</h1>
            <div class="bg-light rounded-lg p-3 w-75 mx-auto" id="searchbar">
                <img src="./images/loupe.png" class="img-fluid" id="imageLoupe">
            </div>
        </div>
    </div>
</div>

<div class="my-5"></div>

<!-- Sports -->
<div class="container-fluid bg-custom-grey">

    <h1> Choisissez votre sport! </h1>
    <div id="sports" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <div class="row justify-content-around pt-3">
                    <img src="./images/sports/basketball-ball.png" class="d-block col-12 col-md-3 col-lg-2 col-xl-1 sportLogos2">
                    <img src="./images/sports/football.png" class="d-block col-12 col-md-3 col-lg-2 col-xl-1 sportLogos2">
                    <img src="./images/sports/rugby-ball.png" class="d-block col-12 col-md-3 col-lg-2 col-xl-1 sportLogos2">
                </div>
            </div>
            <div class="carousel-item">
                <div class="row justify-content-around pt-3">
                    <img src="./images/sports/tennis-racket.png" class="d-block col-12 col-md-3 col-lg-2 col-xl-1 sportLogos2">
                    <img src="./images/sports/climbing.png" class="d-block col-12 col-md-3 col-lg-2 col-xl-1 sportLogos2">
                    <img src="./images/sports/dumbbell.png" class="d-block col-12 col-md-3 col-lg-2 col-xl-1 sportLogos2">
                </div>
            </div>
        </div>
        <!--Controles-->
        <a class="carousel-control-prev primary carouselControls" href="#sports" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Précédent</span>
        </a>
        <a class="carousel-control-next carouselControls" href="#sports" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Suivant</span>
        </a>
    </div>
</div>

<div class="my-5"></div>

<!-- Terrains bien notés -->
<div class="container-fluid bg-custom-grey">

    <h1> Ce que vous avez aimé: </h1>
    <div id="terrains" class="carousel slide" data-interval="false">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <div class="row justify-content-around pt-3">
                    <div class="col-8 col-md-4 mb-2 text-center">
                        <img src="./images/terrains/terrain1.jpg" class="d-block m-auto sportLogos2">
                        <h5>Hoops factory Lille</h5>
                    </div>
                    <div class="col-8 col-md-4 mb-2 text-center">
                        <img src="./images/terrains/terrain2.jpg" class="d-block m-auto sportLogos2">
                        <h5>Playground de la Porte Dorée</h5>
                    </div>
                    <div class="col-8 col-md-4 mb-2 text-center">
                        <img src="./images/terrains/terrain3.jpg" class="d-block m-auto sportLogos2">
                        <h5>Terrain de tennis du Triolo</h5>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <div class="row justify-content-around pt-3">
                    <div class="col-8 col-md-3 col-lg-2 col-xl-1 mb-2 text-center">
                        <img src="./images/terrains/terrain4.jpg" class="d-block m-auto sportLogos2">
                        <h5>Stade Hunebelle - Clamart</h5>
                    </div>
                    <div class="col-8 col-md-3 col-lg-2 col-xl-1 mb-2 text-center">
                        <img src="./images/terrains/terrain5.png" class="d-block m-auto sportLogos2">
                        <h5>Parc Street Workout - Fontenay-Aux-Roses</h5>
                    </div>
                    <div class="col-8 col-md-3 col-lg-2 col-xl-1 mb-2 text-center">
                        <img src="./images/terrains/terrain6.jpg" class="d-block m-auto sportLogos2">
                        <h5>Salle de Musculation - Villeneuve d'Ascq</h5>
                    </div>
                </div>
            </div>
        </div>
        <!--Controles-->
        <a class="carousel-control-prev primary carouselControls" href="#terrains" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Précédent</span>
        </a>
        <a class="carousel-control-next carouselControls" href="#terrains" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Suivant</span>
        </a>
    </div>

</div>


<div>


</div>

<div class="my-5"></div>