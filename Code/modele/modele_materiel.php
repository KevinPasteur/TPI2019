<?php

/**
 * @return false|PDOStatement
 */
function CountAllMaterial(){

    // Connexion à la BD et au serveur
    $connexion = GetBD();

    $requete = "SELECT count(idMateriels) FROM Materiels where Materiels.actif = 1";
    // Exécution de la requête
    $resultat = $connexion->query($requete);

    return $resultat;

}

/**
 * @return false|PDOStatement
 */
function GetAllMaterial()
{
    $connexion = GetBD();
    $requete = "SELECT idMateriels, CategoriesM.nom as Catégorie, modele as 'Modèle',prix,n_inventaire as 'N° Inventaire', n_serie as 'N° Série', fkStatutsM as Statut, Materiels.actif as actifM FROM Materiels
                INNER JOIN CategoriesM on fkCategoriesM = idCategoriesM
                ORDER BY Materiels.actif DESC, CategoriesM.nom";

    // Exécution de la requête
    $resultat = $connexion->query($requete);

    return $resultat;

}

/**
 * @return false|PDOStatement
 */
function GetAnCategorieM($id)
{
    $connexion = GetBD();
    //Récupération de toutes les catégories sauf celles en prêt

    $requete = "SELECT * FROM CategoriesM where idCategoriesM = $id";

    // Exécution de la requête
    $resultat = $connexion->query($requete);

    return $resultat;
}

/**
 * @return false|PDOStatement
 */
function TestMaterialExist()
{
    $connexion = GetBD();
    $requete = "SELECT fkMateriels as tMat FROM EmpruntMate group by fkMateriels order by tMat asc";

    // Exécution de la requête
    $resultat = $connexion->query($requete);

    return $resultat;

}

/**
 * @return false|PDOStatement
 */
function GetAllCategoriesM()
{
    $connexion = GetBD();
    //Récupération de toutes les catégories sauf celles en prêt

    $requete = "SELECT  distinct (nom), idCategoriesM FROM CategoriesM
                INNER JOIN Materiels on idCategoriesM = fkCategoriesM
                Where fkStatutsM in (1) ";

    // Exécution de la requête
    $resultat = $connexion->query($requete);

    return $resultat;
}

/**
 * @return false|PDOStatement
 */
function GetAllCategoriesMA()
{
    $connexion = GetBD();
    //Récupération de toutes les catégories sauf celles en prêt

    /*$requete = "SELECT  distinct (nom), idCategoriesM FROM CategoriesM
                INNER JOIN Materiels on idCategoriesM = fkCategoriesM
                Where fkStatutsM in (1) and CategoriesM.actif = 1";*/

    $requete = "SELECT  distinct (nom), idCategoriesM FROM CategoriesM
                Where CategoriesM.actif = 1";

    // Exécution de la requête
    $resultat = $connexion->query($requete);

    return $resultat;
}

/**
 * @param $infos
 */
function LoanMaterial($infos)
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
function GetRequestsM($statut)
{
    $connexion = GetBD();
    //Récupération de toutes les catégories sauf celles en prêt
    $requete = "SELECT idEmprunt,idMateriels,email, modele, date_e, date_r,fkStatutsE,StatutsE.nom as 'Statut',CategoriesM.nom as categorie FROM Emprunt
                INNER JOIN Comptes on idComptes = fkComptes
                INNER JOIN EmpruntMate on idEmprunt = fkEmprunt
                INNER JOIN Materiels on idMateriels = fkMateriels
                INNER JOIN StatutsE on idStatutsE = fkStatutsE
                INNER JOIN CategoriesM on idCategoriesM = fkCategoriesM
                WHERE fkStatutsE = $statut";

    // Exécution de la requête
    $resultat = $connexion->query($requete);

    return $resultat;
}

/**
 * @param $statut
 * @return false|PDOStatement
 */
function GetMyRequestsM($statut)
{
    $connexion = GetBD();
    //Récupération de toutes les catégories sauf celles en prêt
    $requete = "SELECT idEmprunt,idMateriels,email, modele, date_e, date_r,fkStatutsE,StatutsE.nom as 'Statut',CategoriesM.nom as categorie FROM Emprunt
                INNER JOIN Comptes on idComptes = fkComptes
                INNER JOIN EmpruntMate on idEmprunt = fkEmprunt
                INNER JOIN Materiels on idMateriels = fkMateriels
                INNER JOIN StatutsE on idStatutsE = fkStatutsE
                INNER JOIN CategoriesM on idCategoriesM = fkCategoriesM
                WHERE fkStatutsE = $statut AND email = '".$_SESSION['email']."'";

    // Exécution de la requête
    $resultat = $connexion->query($requete);

    return $resultat;
}

function AddMaterial($infos)
{

    $connexion = GetBD();

    if(!empty($infos['n_serie']))
    {
        $requeteIns = "INSERT INTO Materiels (modele,n_inventaire,n_serie,prix,fkCategoriesM,fkStatutsM) values ('".$infos['modele']."','".$infos['n_inventaire']."','".$infos['n_serie']."','".$infos['prix']."','".$infos['categorie']."','1')";
    }
    else
    {
        $requeteIns = "INSERT INTO Materiels (modele,n_inventaire,prix,fkCategoriesM,fkStatutsM) values ('".$infos['modele']."','".$infos['n_inventaire']."','".$infos['prix']."','".$infos['categorie']."','1')";
    }

    $connexion->exec($requeteIns);
}

/**
 * @param $infos
 */
function AcceptRequestM($infos)
{

    $connexion = GetBD();
    $requeteUpd = "UPDATE Emprunt SET fkStatutsE=2 WHERE idEmprunt = '".@$infos."'";

    $connexion->exec($requeteUpd);
}

/**
 * @param $emprunt
 * @param $materiel
 */
function DeclineRequestM($emprunt,$materiel)
{

    $connexion = GetBD();

    $requeteUpd = "UPDATE Emprunt SET fkStatutsE=4 WHERE idEmprunt = '".@$emprunt."'";
    $connexion->exec($requeteUpd);

    $requeteUpd = "UPDATE Materiels SET fkStatutsM=1 WHERE idMateriels = '".@$materiel."'";
    $connexion->exec($requeteUpd);
}

/**
 * @param $emprunt
 * @param $materiel
 */
function CheckRequestM($emprunt,$materiel)
{

    $connexion = GetBD();

    $requeteUpd = "UPDATE Emprunt SET fkStatutsE=3 WHERE idEmprunt = '".@$emprunt."'";
    $connexion->exec($requeteUpd);

    $requeteUpd = "UPDATE Materiels SET fkStatutsM=1 WHERE idMateriels = '".@$materiel."'";
    $connexion->exec($requeteUpd);
}

/**
 * @param $infos
 */
function DisableM($infos)
{

    $connexion = GetBD();
    $requeteUpd = "UPDATE Materiels SET Actif=0 WHERE idMateriels = '".@$infos."'";

    $connexion->exec($requeteUpd);
}

/**
 * @param $infos
 */
function ActivateM($infos)
{

    $connexion = GetBD();
    $requeteUpd = "UPDATE Materiels SET Actif=1 WHERE idMateriels = '".@$infos."'";

    $connexion->exec($requeteUpd);
}


/**
 * @return false|PDOStatement
 */
function GetAnMaterial($id)
{
    $connexion = GetBD();
    //Récupération de toutes les catégories sauf celles en prêt

    $requete = "SELECT * FROM Materiels where idMateriels = $id";

    // Exécution de la requête
    $resultat = $connexion->query($requete);

    return $resultat;
}


function UpdateMaterial($infos,$id)
{

    $connexion = GetBD();

    if(!empty($infos['n_serie']))
    {
        $requeteUpd = "UPDATE Materiels SET modele ='".$infos['modele']."' ,n_inventaire='".$infos['n_inventaire']."',n_serie='".$infos['n_serie']."',prix='".$infos['prix']."',fkCategoriesM='".$infos['categorie']."' WHERE idMateriels = $id";
    }
    else
    {
        $requeteUpd = "UPDATE Materiels SET modele ='".$infos['modele']."' ,n_inventaire='".$infos['n_inventaire']."',prix='".$infos['prix']."',fkCategoriesM='".$infos['categorie']."' WHERE idMateriels = $id";
    }

    $connexion->exec($requeteUpd);
}