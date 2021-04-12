<?php


?>

<style>

</style>

<body>

<h1 style="color: #123455; text-align: center; margin: 40px; ">
    Rechercher
</h1>

<form id="rechercheForm" action="../controleur.php" name="recherche" method="get">
    <div class="form-row justify-content-center">
        <div class="col-10">
            <div class="form-group">
                <label for="selectSport" style="color: #153455; font-size: 1.2rem;">Choisissez votre sport</label>
                <select id="selectSport" class="form-control custom-rounded-corners">
                    <option> - Choisir Sport - </option>
                    <option>Basket</option>
                    <option>Foot</option>
                    <option>Musculation</option>
                </select>
            </div>
        </div>
        <div class="w-100"></div>

        <div class="col-10 mb-3">
            <input class="form-control custom-rounded-corners" type="text" name="adresse" placeholder="Adresse">
        </div>
        <div class="w-100"></div>
        <div class="col-10 mb-3">
            <div class="row mb-2">
                <div class="col-md-3">
                    <input class="form-control custom-rounded-corners" type="text" name="horaireA" placeholder="Horaire Arrivée">
                </div>
                <div class="col-md-3">
                    <input class="form-control custom-rounded-corners" type="text" name="horaireD" placeholder="Horaire Départ">
                </div>
                <div class="col-md-3 mb-2">
                    <input class="form-control custom-rounded-corners" type="text" name="prixMi" placeholder="Prix Minimal">
                </div>
                <div class="col-md-3 mb-2">
                    <input class="form-control custom-rounded-corners" type="text" name="prixMa" placeholder="Prix Maximal">
                </div>
            </div>
        </div>
        <div class="mb-3">
            <label class="radio-container m-r-45" style="color: #153455; font-size: 1.1rem;">Terrain Public
                <input type="radio" checked="checked" name="gender">
                <span class="checkmark"></span>
            </label>
            <label class="radio-container" style="color: #153455; font-size: 1.1rem;">Terrain Privé
                <input type="radio" name="gender">
                <span class="checkmark"></span>
            </label>
        </div>


        <input type="text" name="action" value="Recherche" class="d-none">
    </div>
    <button type="submit" class="btn btn-block col-3 mt-5" style="background-color: #153455; color: #fdedcf;">Rechercher</button>
</form>
</body>

