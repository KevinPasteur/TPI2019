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


/**
 * @return false|PDOStatement
 */
function GetAllCategoriesC()
{
    $connexion = GetBD();
    //Récupération de toutes les catégories sauf celles en prêt

    $requete = "SELECT  distinct (nom), idCategoriesC FROM CategoriesC
                INNER JOIN Consommables on idCategoriesC = fkCategoriesC
                WHERE nb_exemp >= 1";

    // Exécution de la requête
    $resultat = $connexion->query($requete);

    return $resultat;
}


/**
 * @param $infos
 */
function GiveConsumable($infos)
{

    $connexion = GetBD();
    $requeteIns = "INSERT INTO Emprunt (fkComptes,fkStatutsE,date_e,date_r) values ('".$_SESSION['id']."','1','".$infos['date_e']."','".$infos['date_r']."')";
    $connexion->exec($requeteIns);
    $id = $connexion->lastInsertId();

    $requeteIns = "INSERT INTO EmpruntMate (fkEmprunt,fkMateriels) values ('".$id."','".$infos['modele']."')";
    $connexion->exec($requeteIns);

    $requeteUpd = "UPDATE Materiels SET fkStatutsM=2 WHERE idMateriels = '".$infos["modele"]."'";
    $connexion->exec($requeteUpd);
}