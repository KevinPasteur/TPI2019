<?php

/**
 * Created by PhpStorm.
 * User: Kevin.Pasteur
 * Date: 28/05/2019
 * Time: 09:02
 */

require "modele_getbd.php";


echo "<select class='form-control' name='modele'>";
if (isset($_POST["idCategoriesC"])) {

    // connexion au server de BD MySQL et à la BD
    $connexion = GetBD();

    $requete = "select * from Consommables Inner Join CategoriesC on fkCategoriesC = idCategoriesC WHERE fkCategoriesC = '".$_POST["idCategoriesC"]."' and Consommables.actif = 1";
    // Exécution de la requête
    $resultat = $connexion->query($requete);

    foreach ($resultat as $row) :
        echo "<option value='" . $row["idConsommables"] . "'>" . $row["modele"] . "</option>";
    endforeach;

}
echo "</select>";