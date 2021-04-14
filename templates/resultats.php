<?php
include_once ("./libs/libUtils.php");


$sports = valider("sports");
$localisation= valider("localisation");
$lat=valider("lat");
$long=valider("long");


$adresse=valider("adresse");
$horaireA=valider("horaireA");
$horaireD=valider("horaireD");
$prixMi=valider("prixMi");
$prixMa=valider("prixMa");
$dateReservation=valider("dateRes");
$distanceMax=valider("dMax");
$acceptPublic=valider("acceptPublic");
$acceptPrive=valider("acceptPrive");
$nBMax=valider("nBMax");

?>
<script>
    var localisation = "<?php echo $localisation ?>";
    var sport = "<?php echo $sports ?>";
    var lat = "<?php echo $lat ?>";
    var long = "<?php echo $long ?>";

    var horaireFin = "<?php echo $horaireA ?>";
    var horaireDebut = "<?php echo $horaireD ?>";
    var prixMi = "<?php echo $prixMi ?>";
    var prixMa = "<?php echo $prixMa ?>";
    var dateReservation = "<?php echo $dateReservation ?>";
    var distanceMax = "<?php echo $distanceMax ?>";
    var acceptPrive = "<?php echo $acceptPrive ?>";
    var acceptPublic = "<?php echo $acceptPublic ?>";
    var nBMax = "<?php echo $nBMax ?>";

    var all_info = [sport, lat, long, distanceMax, acceptPublic, acceptPrive, prixMi, prixMa, nBMax, horaireDebut, horaireFin, dateReservation];

    console.log(all_info);


    $("window").ready(function (){

        if(localisation === ""){
            getListPlacesByAddress(sport);
        }
        if(localisation === "on"){
            console.log("HI");
            var geolocation = null;

            if (window.navigator && window.navigator.geolocation) {
                geolocation = window.navigator.geolocation;
            }

            if (geolocation) {
                geolocation.getCurrentPosition(function(position) {

                    window.position = position;
                    console.log(position);
                    getListPlacesByCurrentPosition(position, sport);
                });
            }


        }
    })

    function getListPlacesByCurrentPosition(position, sport){
        let data={
            "action": "get_list_places",
            "sport":sport,
            "user_location_lat":position["coords"]["latitude"],
            "user_location_long":position["coords"]["longitude"],
            "distance_max":distanceMax,
            "accept_public":acceptPublic,
            "accept_private":acceptPrive,
            "prix_min":prixMi,
            "prix_max":prixMa,
            "max_results":nBMax,
            "start_time":horaireDebut,
            "end_time":horaireFin,
            "date":dateReservation
        };

        if(acceptPrive === "on"){
            console.log("Hi: 1");

            delete data["accept_private"];
        }
        if(acceptPublic === "on"){
            console.log("Hi: 2");

            delete data["accept_public"];
        }


        if(acceptPrive === ""){
            console.log("Hi: 3");

            data["accept_private"]='no';
        }
        if(acceptPublic === ""){
            console.log("Hi: 4");

            data["accept_public"]='no';
        }



        for(key in data){
            if(data[key] == ""){

                delete data[key];
            }
        }


        console.log(data);



        $.ajax({
            type: "POST",
            url: "libs/api.php",
            headers: {
                "debug-data": true
            },
            data: data,
            success: function(oRep) {
                console.log(oRep);
                printPlaces(oRep);

            },
            dataType: "json"
        });
    }

    function getListPlacesByAddress(sport){
        $.ajax({
            type: "POST",
            url: "libs/api.php",
            headers: {
                "debug-data": true
            },
            data: {
                "action": "get_list_places",
                "user_location_lat": lat,
                "user_location_long": long,
                "sport": sport
            },
            success: function(oRep) {
                console.log(oRep);
                printPlaces(oRep);


            },
            dataType: "json"
        });
    }
    function printPlaces(oRep){
        var content;
        console.log(oRep.data);
        var isPrivate;
        var stars;
        var idTerrain;
        var photoSrc




        oRep.data.forEach(function (item, index){
            idTerrain = "resultat"+item.id;
            photoSrc = "./images/terrains/"+item.photos[0].nomFichier;
            if(item.private == 1){
                isPrivate = "Contacter l\'Admin";
            } else {
                isPrivate = "Terrain Public";
            }
            stars = "";
            for (i=1;i<=item.note;i++){
                stars += '<img src="./images/Icon%20étoile.svg">'
            }


            content = '<div class="container-fluid" id='+idTerrain+'>' +
                '<div class="row justify-content-center">'+
                '<div class="col-12 row bg-custom-grey pt-4">'+
                '<div class="col-6">'+
                '<h2>Resultat '+(index+1)+'</h2>'+
                 stars+
                '<div class="position-absolute" style="bottom: 0"><h5>'+isPrivate+'</h5></div>'+
                '</div>'+
                '<div class="col-6">'+
                '<div class="text-center">'+
                '<img src='+photoSrc+' class="img-fluid">'+
                '<h5>'+item.name+'</h5>'+
                '</div>'+
                '</div>'+
                '</div>'+
                '</div>'+
                '</div>';

            $("#content").append(content);

        })

    }

</script>


<style>

.wrapper{
    display:flex;
    width: 100%;
    align-items: stretch;
}

#sidebar {
    min-width: 250px;
    max-width: 250px;
    min-height: 100vh;
}

#sidebar.active {
    margin-left: -250px;
}

a[data-toggle="collapse"] {
    position: relative;
}

.dropdown-toggle::after {
    display: block;
    position: absolute;
    top: 50%;
    right: 20px;
    transform: translateY(-50%);
}
@media (max-width: 768px) {
    #sidebar {
        margin-left: -250px;
    }
    #sidebar.active {
        margin-left: 0;
    }
}


/*
    ADDITIONAL DEMO STYLE, NOT IMPORTANT TO MAKE THINGS WORK BUT TO MAKE IT A BIT NICER :)
*/
@import "https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700";


body {
    font-family: 'Poppins', sans-serif;
    background: #dcdcdc;
}

p {
    font-family: 'Poppins', sans-serif;
    font-size: 1.1em;
    font-weight: 300;
    line-height: 1.7em;
    color: #999;
}

a, a:hover, a:focus {
    color: inherit;
    text-decoration: none;
    transition: all 0.3s;
}

#sidebar {
    /* don't forget to add all the previously mentioned styles here too */
    background: #fdedcf;
    color: #000;
    transition: all 0.3s;
}

#sidebar .sidebar-header {
    padding: 20px;
    background: #fdedcf;
}

#sidebar ul.components {
    padding: 20px 0;
    border-bottom: 1px solid #47748b;
}

#sidebar ul p {
    color: #000;
    padding: 10px;
}

#sidebar ul li a {
    padding: 10px;
    font-size: 1.1em;
    display: block;
}
#sidebar ul li a:hover {
    color: #7386D5;
    background: #fff;
}

#sidebar ul li.active > a, a[aria-expanded="true"] {
    color: #000;
    background: #fdedcf;
}
ul ul a {
    font-size: 0.9em !important;
    padding-left: 30px !important;
    background: #fdedcf;
}

#content>div:hover{
    cursor: pointer;
    transform: translateY(-5px);
}
</style>

<script>


$(document).ready(function () {

    $('#sidebarCollapse').on('click', function () {
        $('#sidebar').toggleClass('active');
    });

});
</script>

<div class="wrapper">
    <nav id="sidebar">
        <div class="sidebar-header">
            <h3>Filtres</h3>
        </div>

        <ul class="list-unstyled components">
            <p>Paramètres de recherche</p>

            <form>
                <div class="form-row justify-content-center mb-2">


                    <select class="form-control col-10 ">
                        <option disabled selected>Sport</option>
                        <option>Basket</option>
                        <option>Foot</option>
                        <option>Rugby</option>
                    </select>

                </div>
                <div class="form-row justify-content-center mb-2">
                    <div class="col-5">
                        <select class="form-control" name="heureDebut">
                            <option disabled selected>Heure de début</option>
                            <option>13h</option>
                            <option>14h</option>
                            <option>15h</option>
                            <option>16h</option>
                        </select>
                    </div>
                    <div class="col-5">
                        <select class="form-control" name="heureFin">
                            <option disabled selected>Heure de fin</option>
                            <option>14h</option>
                            <option>15h</option>
                            <option>16h</option>
                            <option>17h</option>
                        </select>
                    </div>
                </div>
                <div class="form-row justify-content-center">
                    <input type="text" class="form-control col-10 mb-2" name="prix_min" placeholder="Prix Minimum">
                    <input type="text" class="form-control col-10 mb-2" name="prix_max" placeholder="Prix Maximum">
                    <input type="text" class="form-control col-10 mb-2" name="distance_max" placeholder="Périmetre maximum">
                    <div class="form-check col-9">
                        <input id="terrainPublic" type="radio" class="form-check-input" name="terrainPublic" checked="checked">
                        <label for="terrainPublic" class="form-check-label text-center">Voulez-vous des terrains public?</label>
                    </div>
                    <div class="form-check col-9">
                        <input id="terrainPrive" type="radio" class="form-check-input" name="terrainPrive" checked="checked">
                        <label for="terrainPrive" class="form-check-label text-center">Voulez-vous des terrains privés?</label>
                    </div>
                </div>
            </form>

        </ul>

    </nav>


    <div id="content">
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container-fluid">
                <button type="button" id="sidebarCollapse" class="btn btn-info">
                    <i class="fas fa-align-left"></i>
                    <span>Changer le filtre</span>
                </button>
            </div>
        </nav>
<!--        <div class="container-fluid" id="resultat1">-->
<!--            <div class="row justify-content-center">-->
<!--                <div class="col-12 row bg-custom-grey pt-4">-->
<!--                    <div class="col-6">-->
<!--                        <h2>Resultat 1:</h2>-->
<!--                        <img src="./images/Icon%20étoile.svg"><img src="./images/Icon%20étoile.svg"><img src="./images/Icon%20étoile.svg"><img src="./images/Icon%20étoile.svg"><img src="./images/Icon%20étoile.svg">-->
<!--                        <div class="position-absolute" style="bottom: 0"><h5>Contacter l'Admin</h5></div>-->
<!--                    </div>-->
<!--                    <div class="col-6">-->
<!--                        <div class="text-center">-->
<!--                            <img src="./images/terrains/terrain1.jpg" class="img-fluid">-->
<!--                            <h5>Hoops Facory Lille</h5>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--        <div class="container-fluid" id="resultat2">-->
<!---->
<!---->
<!--            <div class="row justify-content-center">-->
<!---->
<!--                <div class="col-12 row bg-custom-grey pt-4">-->
<!--                    <div class="col-6">-->
<!--                        <h2>Resultat 2</h2>-->
<!--                        <img src="./images/Icon%20étoile.svg"><img src="./images/Icon%20étoile.svg"><img src="./images/Icon%20étoile.svg"><img src="./images/Icon%20étoile.svg">-->
<!--                        <div class="position-absolute" style="bottom: 0"> <h5>Terrain Public</h5></div>-->
<!--                    </div>-->
<!--                    <div class="col-6">-->
<!--                        <div class="text-center">-->
<!--                            <img src="./images/terrains/terrain2.jpg" class="img-fluid">-->
<!--                            <h5>Playground de la Porte Dorée</h5>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
    </div>
</div>


