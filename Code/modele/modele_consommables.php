<?php
/**
 * Created by PhpStorm.
 * User: Kevin.PASTEUR
 * Date: 22.05.2019
 */

function CountAllConsumables(){

    // Connexion à la BD et au serveur
    $connexion = GetBD();

    $requete = "SELECT count(idConsommables) FROM Consommables";
    // Exécution de la requête
    $resultat = $connexion->query($requete);

    return $resultat;

}

/**
 * @return false|PDOStatement
 */
function GetAllConsumables()
{
    $connexion = GetBD();
    $requete = "SELECT CategoriesC.nom as CategoriesC, modele, nb_exemp, n_reference, prix,FournisseursC.nom as Fournisseur
                FROM Consommables
                LEFT JOIN CategoriesC on fkCategoriesC = idCategoriesC
                LEFT JOIN FournisseursC on fkFournisseursC = idFournisseursC";

    // Exécution de la requête
    $resultat = $connexion->query($requete);

    return $resultat;

}
