<?php
/**
 * Created by PhpStorm.
 * User: Kevin.Pasteur
 * Date: 29/05/2019
 */




function GetCategoriesC()
{
    $connexion = GetBD();
    //Récupération de toutes les catégories
    $requete = "SELECT * FROM CategoriesC";

    // Exécution de la requête
    $resultat = $connexion->query($requete);

    return $resultat;
}


function GetCategoriesM()
{
    $connexion = GetBD();
    //Récupération de toutes les catégories
    $requete = "SELECT * FROM CategoriesM";

    // Exécution de la requête
    $resultat = $connexion->query($requete);

    return $resultat;

}

/**
 * @param $infos
 * @return false|PDOStatement
 */
function DisableCat($infos)
{
    $connexion = GetBD();
    //Récupération de toutes les catégories sauf celles en prêt
    if(isset($_GET['disableM']))
    {
        $requeteUpd = "UPDATE CategoriesM SET Actif=0 WHERE idCategoriesM = '" . @$infos . "'";
    }
    else
    {
        $requeteUpd = "UPDATE CategoriesC SET Actif=0 WHERE idCategoriesC = '" . @$infos . "'";
    }

    // Exécution de la requête
    $connexion->exec($requeteUpd);

}

/**
 * @param $infos
 */
function ActivateCat($infos)
{

    $connexion = GetBD();
    if(isset($_GET['activateM']))
    {
        $requeteUpd = "UPDATE CategoriesM SET Actif=1 WHERE idCategoriesM = '" . @$infos . "'";
    }
    else
    {
        $requeteUpd = "UPDATE CategoriesC SET Actif=1 WHERE idCategoriesC = '" . @$infos . "'";
    }
    // Exécution de la requête
    $connexion->exec($requeteUpd);


}

function UpdateCategorie($infos,$id)
{
    $connexion = GetBD();
    if(isset($_GET['materiel']))
    {
        $requeteUpd = "UPDATE CategoriesM SET nom='".$infos['nom']."' WHERE idCategoriesM = '" . @$id . "'";

        // Exécution de la requête
        $connexion->exec($requeteUpd);

        header('Location: index.php?action=gerercategories&Materiels&ok');
        exit;
    }
    else
    {
        $requeteUpd = "UPDATE CategoriesC SET nom='".$infos['nom']."'WHERE idCategoriesC = '" . @$id . "'";

        // Exécution de la requête
        $connexion->exec($requeteUpd);

        header('Location: index.php?action=gerercategories&Consommables&ok');
        exit;
    }
}

function AddCategorie($infos,$id)
{
    $connexion = GetBD();
    if(isset($_GET['materiel']))
    {
        $requeteUpd = "INSERT INTO CategoriesM (nom) values ('".$infos['nom']."')";

        // Exécution de la requête
        $connexion->exec($requeteUpd);

        header('Location: index.php?action=gerercategories&Materiels&ajok');
        exit;
    }
    else
    {
        $requeteUpd = "INSERT INTO CategoriesC (nom) values ('".$infos['nom']."')";

        // Exécution de la requête
        $connexion->exec($requeteUpd);

        header('Location: index.php?action=gerercategories&Consommables&ajok');
        exit;
    }
}