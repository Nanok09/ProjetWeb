<?php
include_once "libs/modele.php";
include_once "libs/libUtils.php";
include_once "libs/libForms.php";

// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
if (basename($_SERVER["PHP_SELF"]) != "index.php") {
    header("Location:../index.php?view=mesTerrains");
    die("");
}

$id_user = valider("id_user", "SESSION");
$mesTerrains = get_places_created_by($id_user);
$photos = get_photos();

?>
<meta name="viewport" content="initial-scale=1,maximum-scale=1,user-scalable=no">
<script src="js/geolocalisation.js"></script>
<style>
    h5 + p:hover {
        cursor: pointer;
    }

    #map {
        width: 400px;
        height: 400px;
        display: none;
    }

</style>
<link href="https://api.mapbox.com/mapbox-gl-js/v2.2.0/mapbox-gl.css" rel="stylesheet">
<script src="https://api.mapbox.com/mapbox-gl-js/v2.2.0/mapbox-gl.js"></script>
<script>
    var terrains = <?php echo json_encode($mesTerrains); ?>;
    var photos = <?php echo json_encode($photos); ?>;
    $(document).ready(function () {


        console.log(terrains);
        //console.log(photos);


        //On affiche le menu qui permet de choisir d'éditer un terrain
        //ou d'en créer un nouveau

        var i;
        for (i = 0; i < terrains.length; i++) {
            $("#liste_terrains select").append(
                $("<option>")
                    .html(terrains[i].nom)
                    .data(terrains[i])
            );
        }
        $("#liste_terrains select").append($("<option>").html('+'))


        //On affiche l'édition ou la création en fonction du choix
        //de l'utilisateur.

        var selected = $("#liste_terrains select option:selected");
        if (selected.html() == '+') {
            print_new_place_creation();
        } else {
            print_place_edition(selected.data());
        }

        $("#liste_terrains select").change(function () {
            selected = $("#liste_terrains select option:selected");
            if (selected.html() == '+') {
                print_new_place_creation();
            } else {
                print_place_edition(selected.data());
            }
        })

        //On passe en mode édition lors du click sur un paragraphe
        $(document).on("click", "p", function () {
            var contenu = this.innerHTML;
            console.log(contenu);
            if (this.id == "description") {
                $(this).replaceWith(
                    "<textarea>" + contenu + "</textarea>"
                );
            } else if (this.id == "capacite" || this.id == "prix") {
                $(this).replaceWith(
                    "<input type='number' value=\"" + contenu + "\" />"
                );
            } else {
                $(this).replaceWith(
                    "<input type='text' value=\"" + contenu + "\" />"
                );
            }
        });


        //appui sur entrée dans un textarea => validation
        $(document).on("keyup", "textarea", function (contexte) {
            if ($(this).val() == '') return;
            if ($(this).hasClass('crea')) return;
            if (contexte.key == "Enter") {
                var newContenu = $(this).val();
                $(this).replaceWith(
                    $("<p>")
                        .html(newContenu)
                );
            }
        });

        //appui sur entrée dans un input lors de l'édition => validation
        $(document).on("keyup", "input", function (contexte) {
            if ($(this).val() == '') return;
            if ($(this).hasClass('crea')) return;
            if (contexte.key == "Enter") {
                var newContenu = $(this).val();
                $(this).replaceWith(
                    $("<p>")
                        .html(newContenu)
                );
            }
        });



        $(document).on("change","#adresse",function () {
            $("#adresse").attr('placeholder','oui');
            var adress = $("#adresse")[0].value;
            console.log(adress);
            if (adress) {
                console.log("Adresse écrite : " + adress);
                //var coord = get_coord(adress);
                var coord = [{
                    coordinates: {'lat': 47, 'long': 3},
                    address: 'Adresse1',
                }, {
                    coordinates: {'lat': 48, 'long': 5},
                    address: 'Adresse2',
                }]
                print_choix(coord);
            }
        });


    });

    function print_choix(coord) {
        add_markers(coord);
        $("#choice").empty();
        for (let i = 0; i < coord.length; i++) {
            console.log(JSON.stringify(coord));
            $("#choice").append(
                "<option value="+JSON.stringify(coord[i])+" >"+coord[i].address+"</option>"
            )
        }
        $("#choice").css('display','inline');
    }

    //recherches coordonnée, requete à notre API
    function get_coord(adresse) {
        //console.log(geolocation);
        $.ajax({
            type: "POST",
            url: "libs/api.php",
            data: {
                'action': 'address_research',
                'address': adresse
            },
            error: function () {
                console.log("Error");
            },
            success: function (oRep) {
                console.log("réponse requête :" + oRep);
                return oRep;
            }
        })
    }

    //Structure html de l'édition d'un terrain
    function print_place_edition(terrain) {
        console.log(terrain);
        $("#edition").empty();
        $("#creation_place").empty();
        $("#map").css('display','none');
        for (let i = 0; i < photos.length; i++) {
            if (photos[i].idLieu == terrain.id) {
                $("#edition").append("<img style='width : 300px;' src=\"images/terrains/" + photos[i].nomFichier + "\"/>");
            }
        }
        $("#edition").append($("<h2>").html("Edition de terrain"));
        $("#edition").append($("<h5>").html("Nom : "));
        $("#edition").append($("<p id='nom'>").html(terrain.nom));
        $("#edition").append($("<h5>").html("Description : "));
        $("#edition").append($("<p id='description'>").html(terrain.description));
        $("#edition").append($("<h5>").html("Adresse : "));
        $("#edition").append($("<p id='current_address'>").html(terrain.adresse));
        $("#edition").append($("<h5>").html("Capacité : (nombre de personnes)"));
        $("#edition").append($("<p id='capacite'>").html(terrain.capacite));
        $("#edition").append($("<h5>").html("prix : (horaire)"));
        $("#edition").append($("<p id='prix' >").html(terrain.prix));
        $("#edition").append($("<h5>").html("sport : "));
        $("#edition").append($("<p id='sport'>").html(terrain.sport));
        $("#edition").append("<input id='modif' type='button' value='Enregistrer Modifications'/>");
    }

    //Structure html de la création d'un terrain
    function print_new_place_creation() {
        $("#creation_place").empty();
        $("#edition").empty();
        $("#creation_place").append($("<h2>").html("Création d'un nouveau terrain"));
        $("#creation_place").append($("<span>").html("Nom :"));
        $("#creation_place").append("<input class='crea' id='nom' type='text' name='nom' placeholder='Nouveau Terrain'/></br>");
        $("#creation_place").append($("<span>").html("Adresse :"));
        $("#creation_place").append("<input class='crea' id='adresse' type='text' placeholder='1500 Avenue Médicis, Paris'/></br>");
        $("#creation_place").append("<select class='crea' id='choice' name='coord' style='display:none;'></select></br>");
        $("#creation_place").append($("<span>").html("Sport :"));
        $("#creation_place").append("<input class='crea' id='sport' type='text' name='sport' placeholder='tennis'/></br>");
        $("#creation_place").append($("<span>").html("Prix (horaire):"));
        $("#creation_place").append("<input class='crea' id='prix' type='number' name='prix' placeholder='50'/></br>");
        $("#creation_place").append($("<span>").html("Capacité (nombre de personnes):"));
        $("#creation_place").append("<input class='crea' id='capacite' type='number' name='capacite' placeholder='5'/></br>");
        $("#creation_place").append($("<span>").html("Type :"));
        $("#creation_place").append("</br>");
        $("#creation_place").append("<input id='publique' type='radio' name='type' value=0 checked/>" +
            "<label for='publique'>Publique</label>");
        $("#creation_place").append("<input id='prive' type='radio' name='type' value=1/>" +
            "<label for='prive'>Privé</label>");

        $("#creation_place").append("</br>");
        $("#creation_place").append($("<h5>").html("Description générale"));
        $("#creation_place").append("<textarea id='description' class='crea' name='description'></textarea>");
        $("#creation_place").append("<input id='action' type='hidden' name='action' value='create_place'/>");
        $("#creation_place").append("<input id='creation' type='button' onClick='document.getElementById(\"creation_place\").submit();' value='Créer terrain'/>");
    }

    function add_markers(coord) {
        mapboxgl.accessToken = 'pk.eyJ1IjoiYXlwMzAzIiwiYSI6ImNrbjhueDA1aDB6dGEyeG54cnNiMXU5enIifQ.xF0Hdno28id2nLnF-rqg2w';
        var map = new mapboxgl.Map({
            container: 'map', // container id
            style: 'mapbox://styles/mapbox/streets-v11', // style URL
            center: [3, 47], // starting position [lng, lat]
            zoom: 4 // starting zoom
        });
        $("#map").css('display', 'inline-block');

        var markers = []

        for (let i = 0; i < coord.length; i++) {
            markers.push({
                'type': 'Feature',
                'geometry': {
                    'type': 'Point',
                    'coordinates': [coord[i].coordinates.long, coord[i].coordinates.lat]
                },
                'properties': {
                    'title': coord[i].address
                }
            });
        }


        map.on('load', function () {
// Add an image to use as a custom marker
            map.loadImage(
                'https://docs.mapbox.com/mapbox-gl-js/assets/custom_marker.png',
                function (error, image) {
                    if (error) throw error;
                    map.addImage('custom-marker', image);
// Add a GeoJSON source with 2 points
                    map.addSource('points', {
                        'type': 'geojson',
                        'data': {
                            'type': 'FeatureCollection',
                            'features': markers
                        }
                    });

// Add a symbol layer
                    map.addLayer({
                        'id': 'points',
                        'type': 'symbol',
                        'source': 'points',
                        'layout': {
                            'icon-image': 'custom-marker',
// get the title name from the source's "title" property
                            'text-field': ['get', 'title'],
                            'text-font': [
                                'Open Sans Semibold',
                                'Arial Unicode MS Bold'
                            ],
                            'text-offset': [0, 1.25],
                            'text-anchor': 'top'
                        }
                    });
                }
            );
        });
        console.log("add done");
    }


</script>

<div id="liste_terrains">
    <h2>Mes Terrains</h2>
    <select>
    </select>

</div>
<div id="map"></div>

<div id="edition">
</div>

<form id='creation_place' action='controleur.php' method="POST">
</form>

