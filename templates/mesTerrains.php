<?php
include_once "libs/modele.php";
include_once "libs/maLibUtils.php";
include_once "libs/maLibForms.php";

// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
if (basename($_SERVER["PHP_SELF"]) != "index.php") {
    header("Location:../index.php?view=mesTerrains");
    die("");
}

$id_user=valider("id_user","SESSION");
$mesTerrains = get_places($id_user);
$photos = get_photos();

?>
<style>
    h5+p:hover{
        cursor:pointer;
    }
</style>

<script>
    var terrains = <?php echo json_encode($mesTerrains); ?>;
    var photos = <?php echo json_encode($photos); ?>;
    $(document).ready(function () {

        console.log(terrains);
        console.log(photos);


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
        if (selected.html() == '+'){
            print_new_place_creation();
        }else{
            print_place_edition(selected.data());
        }

        $("#liste_terrains select").change(function(){
            selected = $("#liste_terrains select option:selected");
            if (selected.html() == '+'){
                print_new_place_creation();
            }else{
                print_place_edition(selected.data());
            }
        })


    });

    //Structure html de l'édition d'un terrain
    function print_place_edition(terrain){
        console.log(terrain);
        $("#edition").empty();
        for (let i = 0; i < photos.length; i++) {
            if (photos[i].idLieu == terrain.id){
                $("#edition").append("<img style='width : 300px;' src=\"images/terrains/"+photos[i].nomFichier+"\"/>");
            }
        }
        $("#edition").append($("<h2>").html("Edition de terrain"));
        $("#edition").append($("<h5>").html("Nom : "));
        $("#edition").append($("<p id='nom'>").html(terrain.nom));
        $("#edition").append($("<h5>").html("Description : "));
        $("#edition").append($("<p id='description'>").html(terrain.description));
        $("#edition").append($("<h5>").html("Adresse : "));
        $("#edition").append($("<p id='adresse'>").html(terrain.adresse));
        $("#edition").append($("<h5>").html("Capacité : (nombre de personnes)"));
        $("#edition").append($("<p id='capacite'>").html(terrain.capacite));
        $("#edition").append($("<h5>").html("prix : (horaire)"));
        $("#edition").append($("<p id='prix' >").html(terrain.prix));
        $("#edition").append($("<h5>").html("sport : "));
        $("#edition").append($("<p id='sport'>").html(terrain.sport));
        $("#edition").append("<input id='modif' type='button' value='Enregistrer Modifications'/>");
    }

    //Structure html de la création d'un terrain
    function print_new_place_creation(){
        console.log('new');
        $("#edition").empty();
        $("#edition").append($("<h2>").html("Création d'un nouveau terrain"));
        $("#edition").append($("<span>").html("Adresse :"));
        $("#edition").append("<input id='adresse' type='text' placeholder='1500 Avenue Médicis, Paris'/></br>");
        $("#edition").append($("<span>").html("Sport :"));
        $("#edition").append("<input id='sport' type='text' placeholder='tennis'/></br>");
        $("#edition").append($("<span>").html("Prix :"));
        $("#edition").append("<input id='prix' type='number' placeholder='50'/></br>");
        $("#edition").append($("<span>").html("Type :"));
        $("#edition").append("</br>");
        $("#edition").append("<input id='publique' type='radio' name='type' value=0 checked/>" +
            "<label for='publique'>Publique</label>");
        $("#edition").append("<input id='prive' type='radio' name='type' value=1/>" +
            "<label for='prive'>Privé</label>");

        $("#edition").append("</br>");
        $("#edition").append($("<h5>").html("Description générale"));
        $("#edition").append($("<p id='description'>").html("Description vide"));
        $("#edition").append("<input id='creation' type='button' value='Créer terrain'/>");
    }

</script>

<div id="liste_terrains">
    <h2>Mes Terrains</h2>
    <select>
    </select>

</div>


<div id="edition">
</div>