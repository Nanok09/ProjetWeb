<?php
?>

<script>

    $("window").ready(function (){
        $("#adresseInput").keyup(function (){
            $('#maLocalisation').attr("disabled","disabled");
        });

        $("#maLocalisation").click(function (){
            if($("#maLocalisation").prop("checked")){
                $('#adresseInput').attr("disabled","disabled");
            }else {
                $("#adresseInput").removeAttr("disabled");
            }
            ;
        })


        setInterval(function(){
            if($("#adresseInput").val() == ""){
                $("#maLocalisation").removeAttr("disabled");
            };
        }, 1000);


    })


</script>


<div class="bg-custom-grey custom-rounded-corners mx-4">


<h1 style="color: #123455; text-align: center; margin: 40px; ">
    Rechercher
</h1>
<div class="container">
<form id="rechercheForm" action="../controleur.php" name="recherche" method="get">
    <div class="form-row justify-content-center">
        <div class="col-12">
            <div class="form-group">
                <label for="selectSport" style="color: #153455; font-size: 1.2rem;">Choisissez votre sport</label>
                <select id="selectSport" class="form-control custom-rounded-corners" name="sports" required>
                    <option value=""> - Choisir Sport - </option>
                    <option>Basket</option>
                    <option>Foot</option>
                    <option>Musculation</option>
                </select>
            </div>
        </div>
        <div class="w-100"></div>

        <div class="col-11 mb-3">
            <label for="maLocalisation" class="checkbox-container m-r-45" style="color: #153455; font-size: 1.1rem;">Chercher un terrain proche de moi
                <input id="maLocalisation" type="checkbox" name="maLocalisation">
                <span class="checkmark"></span>
            </label>

        </div>
        <p class="col-1"> ou </p>

        <div class="col-12 mb-3">
            <input id="adresseInput" class="form-control custom-rounded-corners" type="text" name="adresse" placeholder="Adresse" required>
        </div>
        <div class="w-100"></div>
        <div class="col-12 mb-3">
            <div class="row mb-2">
                <div class="col-md-3 col-6 mb-2">
                    <input class="form-control custom-rounded-corners" type="text" name="horaireA" placeholder="Heure de début">
                </div>
                <div class="col-md-3 col-6 mb-2">
                    <input class="form-control custom-rounded-corners" type="text" name="horaireD" placeholder="Heure de fin">
                </div>
                <div class="col-md-3 col-6 mb-2">
                    <input class="form-control custom-rounded-corners" type="text" name="prixMi" placeholder="Prix Minimal">
                </div>
                <div class="col-md-3 col-6 mb-2">
                    <input class="form-control custom-rounded-corners" type="text" name="prixMa" placeholder="Prix Maximal">
                </div>
            </div>
        </div>
        <div class="col-12 mb-1 row justify-content-center">
            <div class="form-group col-4">
                <label for="publicTerrains" class="radio-container m-r-45" style="color: #153455; font-size: 1.1rem;">Terrains Public</label>
                <input id="publicTerrains" type="checkbox" checked="checked" name="public">
                <span class="checkmark"></span>
            </div>

            <div class="form-group col-4">
                <label for="priveTerrains" class="radio-container" style="color: #153455; font-size: 1.1rem;">Terrains Privés</label>
                <input id="priveTerrains" type="checkbox" checked="checked" name="prive">
                <span class="checkmark"></span>
            </div>
        </div>
        <input type="submit" name="action" value="Recherche" class="btn col-3 my-2" style="background-color: #153455; color: #fdedcf;">
    </div>
</form>

</div>

</div>


