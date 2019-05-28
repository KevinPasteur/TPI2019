<?php
/**
 * Created by PhpStorm.
 * User: Kevin.PASTEUR
 * Date: 22.05.2019
 */

/**
 * @return false|PDOStatement
 * Description : Récupération du nombre total de tous les consommables présent dans la base de données.
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
 * Description : Récupération de tous les consommables qui ne sont pas épuisés et les trier par catégories.
 */
function GetAllConsumables()
{
    $connexion = GetBD();
    $requete = "SELECT CategoriesC.nom as categoriesc, modele, nb_exemp, n_reference, prix,FournisseursC.nom as fournisseur
                FROM Consommables
                LEFT JOIN CategoriesC on fkCategoriesC = idCategoriesC
                LEFT JOIN FournisseursC on fkFournisseursC = idFournisseursC
                WHERE nb_exemp >= 1
                ORDER BY categoriesc";

    // Exécution de la requête
    $resultat = $connexion->query($requete);

    return $resultat;

}
