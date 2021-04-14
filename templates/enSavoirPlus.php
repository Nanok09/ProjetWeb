<?php

include_once "libs/libUtils.php";
include_once "libs/libSQL.pdo.php";
include_once "libs/libSecurisation.php";
include_once "libs/modele.php";
include_once "libs/upload_photo.php";


$id_place=valider('id');
$photos = get_photos_place($id_place);
$note=get_note_place($id_place);
$terrain=get_place_info($id_place);
$createur_id=get_createur_lieu($id_place);
$createur = get_user_info($createur_id);


?>

<link rel="stylesheet" type="text/css" href="./css/common.css">

<style>
.image_custom_center{
    display : block;
    margin: auto;
}
</style>
<script>
    $(document).ready(function () {
        $(document).on("click","#louer",function(){
            document.location.href="\'index.php?view=reserver&id=<?php echo $id_place; ?>";
        });
    });
</script>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-10">
            <?php
            foreach($photos as $photo){
                echo"<img src='./images/terrains/".$photo['nomFichier']."' class='image_custom_center img-fluid custom-rounded-corners my-3'>";
            }
            ?>
        </div>
    </div>
</div>
<div class="container">
    <div class="row justify-content-center">
        <div class="row w-50 justify-content-around">
            <div class="my-4 pt-3 col-4 bg-custom-grey custom-rounded-corners">
                <p class="body-color-blue text-center"><?php echo $terrain['sport']; ?></p>
            </div>
            <div class="my-4 pt-3 col-4 bg-custom-grey custom-rounded-corners">
                <p class="body-color-blue text-center">
                    <?php
                    if ($terrain['prive']){
                        echo "Privé";
                    }else{
                        echo "Public";
                    }
                    ?>
                </p>
            </div>
        </div>
    </div>
</div>
<div class="container mb-5">
    <div class="row justify-content-around">
        <div class="col-4 bg-custom-grey custom-rounded-corners h-50">
            <h3 class="mt-3 body-color-blue" style="text-align: center;">Résultat</h3>
            <?php
            if (round($note['mean'])==0){
                echo"</br>";
            }
            for ($i = 1; $i <=round($note['mean']) ; $i++) {
                echo '<img src="./images/Icon%20étoile.svg">';
            }
            ?>
            <p class="mt-1 text-muted" style="font-size: 0.9em">à partir de <?php echo $terrain['prix']; ?> euros par heure</p>
            <input id="louer" type="button" value="Louer" class="btn col-12 my-3 custom-rounded-corners" style="background-color: #153455; color: #fdedcf;">
            <p class="mt-2 ml-2 body-color-blue">
                <?php
                echo "gérant du terrain : ".$createur['pseudo'];
                ?>
            </p>
            <input id="submitForm" type="submit" name="action" value="Discuter avec le gérant" class="btn col-12 mb-5 mt-3 custom-rounded-corners"
                   style="background-color: #153455; color: #fdedcf;">
        </div>

        <div class="col-7 bg-custom-grey custom-rounded-corners">
            <p class="ml-5 mt-5 body-color-blue"><strong>Informations générales</strong></p>
            <p class="mx-5 body-color-blue"><?php echo $terrain['description']; ?></p>
            <hr style="height:1px;width:70%;color:#153455;background-color:#153455">
            <p class="my-2 mx-5 body-color-blue"><strong>Adresse</strong></p>
            <p class="mx-5 body-color-blue"><?php echo $terrain['adresse']; ?></p>
            <p class="ml-5 my-5 body-color-blue" style="display: inline-block"><strong>Capacité maximale</strong></p>
            <p class="ml-3 my-5 body-color-blue" style="display: inline-block"><?php echo $terrain['capacite']; ?></p>
        </div>

    </div>
</div>


