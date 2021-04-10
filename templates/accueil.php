<?php



?>
<style>
    #imageLoupe{
        max-width: 5%;
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

    });

</script>
<div class="container">
    <div class="row justify-content-center">
        <div class="col rounded-pill bg-custom-grey my-2 py-3">
            <h1 class="text-center">Rechercher des terrains proches de vous !</h1>
            <div class="bg-light rounded-lg p-3 w-75 mx-auto" id="searchbar">
                <img src="../images/loupe.png" class="img-fluid" id="imageLoupe">
            </div>
        </div>
    </div>
</div>

<!--
<div class="container-fluid bg-custom-grey">

    <div class="row justify-content-around">
        <div class="col-6 col-md-4 col-lg-2 text-center">
            <img src="../images/sports/football.png" class="img-fluid sportLogos">
            <h3>Foot</h3>
        </div>
        <div class="col-6 col-md-4 col-lg-2 text-center">
            <img src="../images/sports/basketball-ball.png" class="img-fluid sportLogos">
            <h3>Basket</h3>
        </div>
        <div class="col-6 col-md-4 col-lg-2 text-center">
            <img src="../images/sports/dumbbell.png" class="img-fluid sportLogos">
            <h3>Musculation</h3>
        </div>
        <div class="col-6 col-md-4 col-lg-2 text-center">
            <img src="../images/sports/rugby-ball.png" class="img-fluid sportLogos">
            <h3>Rugby</h3>
        </div>
        <div class="col-6 col-md-4 col-lg-2 text-center">
            <img src="../images/sports/tennis-racket.png" class="img-fluid sportLogos">
            <h3>Tennis</h3>
        </div>
    </div>
</div>
-->
<!-- Sports -->
<div class="container-fluid bg-custom-grey">

    <h1> Choisissez votre sport! </h1>
    <div id="sports" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <div class="row justify-content-around pt-3">
                    <img src="../images/sports/basketball-ball.png" class="d-block col-12 col-md-3 col-lg-2 col-xl-1 sportLogos2">
                    <img src="../images/sports/football.png" class="d-block col-12 col-md-3 col-lg-2 col-xl-1 sportLogos2">
                    <img src="../images/sports/rugby-ball.png" class="d-block col-12 col-md-3 col-lg-2 col-xl-1 sportLogos2">
                </div>
            </div>
            <div class="carousel-item">
                <div class="row justify-content-around pt-3">
                    <img src="../images/sports/tennis-racket.png" class="d-block col-12 col-md-3 col-lg-2 col-xl-1 sportLogos2">
                    <img src="../images/sports/climbing.png" class="d-block col-12 col-md-3 col-lg-2 col-xl-1 sportLogos2">
                    <img src="../images/sports/dumbbell.png" class="d-block col-12 col-md-3 col-lg-2 col-xl-1 sportLogos2">
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
                        <img src="../images/terrains/terrain1.jpg" class="d-block m-auto sportLogos2">
                        <h5>Hoops factory Lille</h5>
                    </div>
                    <div class="col-8 col-md-4 mb-2 text-center">
                        <img src="../images/terrains/terrain2.jpg" class="d-block m-auto sportLogos2">
                        <h5>Playground de la Porte Dorée</h5>
                    </div>
                    <div class="col-8 col-md-4 mb-2 text-center">
                        <img src="../images/terrains/terrain3.jpg" class="d-block m-auto sportLogos2">
                        <h5>Terrain de tennis du Triolo</h5>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <div class="row justify-content-around pt-3">
                    <div class="col-8 col-md-3 col-lg-2 col-xl-1 mb-2 text-center">
                        <img src="../images/terrains/terrain4.jpg" class="d-block m-auto sportLogos2">
                        <h5>Stade Hunebelle - Clamart</h5>
                    </div>
                    <div class="col-8 col-md-3 col-lg-2 col-xl-1 mb-2 text-center">
                        <img src="../images/terrains/terrain5.png" class="d-block m-auto sportLogos2">
                        <h5>Parc Street Workout - Fontenay-Aux-Roses</h5>
                    </div>
                    <div class="col-8 col-md-3 col-lg-2 col-xl-1 mb-2 text-center">
                        <img src="../images/terrains/terrain6.jpg" class="d-block m-auto sportLogos2">
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