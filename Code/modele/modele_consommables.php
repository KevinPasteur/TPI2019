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
                WHERE nb_exemp >= 1 and Consommables.actif = 1
                ORDER BY Consommables.actif DESC, CategoriesC.nom";

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
 * @return false|PDOStatement
 */
function GetAnCategorieC($id)
{
    $connexion = GetBD();
    //Récupération de toutes les catégories sauf celles en prêt

    $requete = "SELECT * FROM CategoriesC where idCategoriesC = $id";

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

/**
 * @param $statut
 * @return false|PDOStatement
 */
function GetRequestsC($statut)
{
    $connexion = GetBD();
    //Récupération de toutes les catégories sauf celles en prêt
    $requete = "SELECT idOctroi,idConsommables,email, modele,nb_exemp,nb_octroi, fkStatutsO,CategoriesC.nom as categorie,StatutsO.nom as 'Statut'  FROM Octroi
                INNER JOIN Comptes on idComptes = fkComptes
                INNER JOIN OctroiConso on idOctroi = fkOctroi
                INNER JOIN Consommables on idConsommables = fkConsommables
                INNER JOIN StatutsO on idStatutsO = fkStatutsO
                INNER JOIN CategoriesC on idCategoriesC = fkCategoriesC
                WHERE fkStatutsO = $statut";

    // Exécution de la requête
    $resultat = $connexion->query($requete);

    return $resultat;
}

/**
 * @param $infos
 */
function LoanConsumable($infos,$x)
{

    $connexion = GetBD();
    $requeteIns = "INSERT INTO Octroi (fkComptes,fkStatutsO) values ('".$_SESSION['id']."','1')";
    $connexion->exec($requeteIns);
    $id = $connexion->lastInsertId();

    $requeteIns = "INSERT INTO OctroiConso (fkOctroi,fkConsommables,nb_octroi) values ('".$id."','".$infos["modele$x"]."','".$infos["nb_exemp$x"]."')";
    $connexion->exec($requeteIns);

    $requeteUpd = "UPDATE Consommables SET nb_exemp=nb_exemp-'".$infos["nb_exemp$x"]."' WHERE idConsommables = '".$infos["modele$x"]."'";
    $connexion->exec($requeteUpd);
}


/**
 * @param $statut
 * @return false|PDOStatement
 */
function GetMyRequestsC($statut)
{
    $connexion = GetBD();
    //Récupération de toutes les catégories sauf celles en prêt
    $requete = "SELECT idOctroi,idConsommables,email, modele, nb_octroi,fkStatutsO,StatutsO.nom as 'Statut',CategoriesC.nom as categorie FROM Octroi
                INNER JOIN Comptes on idComptes = fkComptes
                INNER JOIN OctroiConso on idOctroi = fkOctroi
                INNER JOIN Consommables on idConsommables = fkConsommables
                INNER JOIN StatutsO on idStatutsO = fkStatutsO
                INNER JOIN CategoriesC on idCategoriesC = fkCategoriesC
                WHERE fkStatutsO = $statut AND email =  '".$_SESSION['email']."'";

    // Exécution de la requête
    $resultat = $connexion->query($requete);

    return $resultat;
}

/**
 * @param $infos
 */
function AcceptRequestC($infos)
{

    $connexion = GetBD();
    $requeteUpd = "UPDATE Octroi SET fkStatutsE=2 WHERE idOctroi = '".@$infos."'";

    $connexion->exec($requeteUpd);
}

/**
 * @param $emprunt
 * @param $materiel
 */
function DeclineRequestC($octroi,$consommable)
{

    $connexion = GetBD();

    $requeteUpd = "UPDATE Octroi SET fkStatutsO=3 WHERE idOctroi = '".@$octroi."'";
    $connexion->exec($requeteUpd);

    $requete = "SELECT nb_octroi FROM OctroiConso WHERE fkOctroi ='".@$octroi."'";
    $resultat = $connexion->query($requete);
    $result=$resultat->fetch();

    $requeteUpd = "UPDATE Consommables SET nb_exemp=nb_exemp+'".$result['nb_octroi']."' WHERE idConsommables = '".@$consommable."'";
    $connexion->exec($requeteUpd);
}