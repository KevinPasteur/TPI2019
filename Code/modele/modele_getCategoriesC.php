<?php
/**
 * Created by PhpStorm.
 * User: Kevin.Pasteur
 * Date: 81/05/2019
 * Time: 11:44
 */

require "modele_getbd.php";

// connexion au server de BD MySQL et à la BD
$connexion = GetBD();

$requete = "select distinct(CategoriesC.nom) as Categorie, idCategoriesC from Consommables Inner Join CategoriesC on fkCategoriesC = idCategoriesC WHERE nb_exemp >= 1";
// Exécution de la requête
$resultat = $connexion->query($requete);


?>
    <div class="form-group">
        <label class="col-lg-2 control-label">Catégorie</label>
        <div class="col-lg-6">
            <select class='form-control' name='categorie<?= $_GET['cat']; ?>' id="categorie<?= $_GET['cat']; ?>" onchange='search_fc(<?=  $_GET['cat']; ?>);'>
                <?php
                foreach ($resultat as $row) :
                    echo "<option value='" . $row["idCategoriesC"] . "'>" . $row["Categorie"] . "</option>";
                endforeach;
                ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-2 control-label">Modèle</label>
        <div id="modele" class="col-lg-6">
            <select class="form-control" name='modele<?= $_GET['cat']; ?>' id="modele<?= $_GET['cat']; ?>" required>
                <option value='-1'>Choisissez d'abord une catégorie</option>
            </select>
        </div>
    </div>
    <div>
        <label class="col-lg-2 control-label">Nombre d'exemplaire</label>
        <div class="col-lg-2">
            <input class="form-control" type=number name="nb_exemp" required/>
        </div>
    </div>

    <br>

