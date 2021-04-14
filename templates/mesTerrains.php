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
        //console.log(selected.data());
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
            if (this.id == "current_address") return ;
            console.log(contenu);
            if (this.id == "description") {
                $(this).replaceWith(
                    "<textarea name='description'>" + contenu + "</textarea>"
                );
            } else if (this.id == "capacite" || this.id == "prix") {
                $(this).replaceWith(
                    "<input name='"+this.id+"' type='number' value=\"" + contenu + "\" />"
                );
            } else {
                $(this).replaceWith(
                    "<input name='"+this.id+"' type='text' value=\"" + contenu + "\" />"
                );
            }
        });

        $(document).on("keyup", "#adresse", function () {
            var adress = $("#adresse")[0].value;
            console.log(adress);
            if (adress) {
                get_coord(adress);
            }
        });

        //création form creneau
        $("#ajout_creneaux").append("<input type='hidden' value='" +selected.data().id+ "' name='id_place'/>");
        $("#ajout_creneaux").append("Date : <input id='date' type='date' name='date'/></br>");
        $("#ajout_creneaux").append("Heure de début : <input id='début' type='time' name='debut'/></br>");
        $("#ajout_creneaux").append("Heure de fin : <input id='fin' type='time' name='fin'/></br>");
        $("#ajout_creneaux").append("Capacité : <input id='capacite' type='number' name='capacite'/></br>");
        $("#ajout_creneaux").append("<input id='ajouter_creneau' type='submit' name='action' value='ajouter créneau'/>");

        //création form photo
        $("#ajout_photo").append("<input type='hidden' value='" +selected.data().id+ "' name='id_place'/>");
        $("#ajout_photo").append("<input type='file' name='fileToUpload'/></br>");
        $("#ajout_photo").append("<input id='ajouter_photo' type='submit' name='action' value='ajouter photo'/>");


    });

    function print_choix(coord) {
        add_markers(coord);
        $("#choice").empty();
        for (let i = 0; i < coord.length; i++) {
            var str = JSON.stringify(coord[i]);
            console.log(str);
            $("#choice").append(
                $("<option>").html(coord[i].address)
                    .attr('value', str)
            )
        }
        $("#choice").css('display', 'inline');
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
                print_choix(JSON.parse(oRep).data);
            }
        })
    }

    //Structure html de l'édition d'un terrain
    function print_place_edition(terrain) {
        $("#ajout_creneaux").css('display','block');
        $("#ajout_photo").css('display','block');
        $("#edition").empty();
        $("#creation_place").empty();
        $("#edition").append($("<h5>").html("Photos : "));
        $("#map").css('display', 'none');
        for (let i = 0; i < photos.length; i++) {
            if (photos[i].idLieu == terrain.id) {
                console.log(photos[i]);
                $("#edition").append("<img style='width : 300px;' src=\"images/terrains/" + photos[i].nomFichier + "\"/>");
            }
        }
        $("#edition").append($("<h3>").html("Infos Terrain : "));
        $("#edition").append($("<h4>").html("Nom : "));
        $("#edition").append($("<p id='nom' name='nom'>").html(terrain.nom));
        $("#edition").append($("<h4>").html("Description : "));
        if (terrain.description == ''){
            $("#edition").append($("<p id='description' name='description'>").html('Pas de description'));
        }else{
            $("#edition").append($("<p id='description' name='description'>").html(terrain.description));
        }
        $("#edition").append($("<h4>").html("Adresse : (non modifiable)"));
        $("#edition").append($("<p id='current_address'>").html(terrain.adresse));
        $("#edition").append($("<h4>").html("Capacité : (nombre de personnes)"));
        $("#edition").append($("<p id='capacite' name='capacite'>").html(terrain.capacite));
        $("#edition").append($("<h4>").html("prix : (horaire)"));
        $("#edition").append($("<p id='prix' name='prix' >").html(terrain.prix));
        $("#edition").append($("<h4>").html("sport : "));
        $("#edition").append($("<p id='sport' name='sport'>").html(terrain.sport));
        $("#edition").append("<input name='action' type='hidden' value='modif_place'>");
        $("#edition").append("<input name='id_place' type='hidden' value='" +terrain.id+ "'>");
        $("#edition").append("</br><input type='button' value='Enregistrer modifications' onClick='submit();'>");
    }

    function modif_infos(){

    }

    //Structure html de la création d'un terrain
    function print_new_place_creation() {
        $("#creation_place").empty();
        $("#edition").empty();
        $("#ajout_creneaux").css('display','none');
        $("#ajout_photo").css('display','none');
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
        $("#creation_place").append("<input id='prive' type='radio' name='type' value=1 />" +
            "<label for='prive'>Privé</label>");

        $("#creation_place").append("</br>");
        $("#creation_place").append($("<h5>").html("Description générale"));
        $("#creation_place").append("<textarea id='description' class='crea' name='description'></textarea></br>");
        $("#creation_place").append($("<span>").html("Photo de votre terrain :"));
        $("#creation_place").append("<input id='fileToUpload' type='file' name='fileToUpload'/></br>");
        $("#creation_place").append("<input id='creation' name='action' type='submit' value='Créer terrain'/>");
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
    }


</script>

<div id="liste_terrains">
    <h2>Mes Terrains</h2>
    <select>
    </select>

</div>
<div id="map"></div>

<form id="ajout_creneaux" action="controleur.php" style="display:none;">
    <h3>Ajouter un créneau</h3>
</form>
<?php
if ($msg = valider('msg2')) {
    echo "<span style='color:red'>$msg</span>";
}
?>

<form id="edition" action="controleur.php" method="post">
</form>

<form id='creation_place' action='controleur.php' method="POST" enctype="multipart/form-data">
</form>

<?php
if ($msg = valider('msg')) {
    echo "<span style='color:red'>$msg</span>";
}

?>

<form id="ajout_photo" action="controleur.php" method='post' style="display:none;" enctype="multipart/form-data">
    <h3>Ajouter une photo</h3>
</form>

<?php
if ($msg = valider('msg3')) {
    echo "<span style='color:red'>$msg</span>";
}

?>
