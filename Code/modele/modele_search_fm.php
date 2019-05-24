<?php
/**
 * Created by PhpStorm.
 * User: Kevin.Pasteur
 * Date: 21/05/2019
 * Time: 20:17
 */

require "modele_getbd.php";

    echo "<select class='form-control' name='modele'>";
    if (isset($_POST["idCategoriesM"])) {

        // connexion au server de BD MySQL et à la BD
        $connexion = GetBD();

        $requete = "select * from Materiels Inner Join CategoriesM on fkCategoriesM = idCategoriesM WHERE fkCategoriesM = '".$_POST["idCategoriesM"]."' and fkStatutsM = '1'";
        // Exécution de la requête
        $resultat = $connexion->query($requete);

        foreach ($resultat as $row) :
            echo "<option value='" . $row["idMateriels"] . "'>" . $row["modele"] . "</option>";
        endforeach;

    }
    echo "</select>";