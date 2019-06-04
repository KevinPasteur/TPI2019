<?php
/**
 * Created by PhpStorm.
 * User: Kevin.PASTEUR
 * Date: 28.05.2019
 */

function GetAccounts()
{
    // Connexion à la BD et au serveur
    $connexion = GetBD();

    // Création de la string pour la requête
    $requete = "SELECT idComptes,Comptes.nom as nom,Roles.nom as roles,prenom,email,actif FROM Comptes
                INNER JOIN Roles on fkRoles = idRoles";
    // Exécution de la requête
    $resultat = $connexion->query($requete);

    return $resultat;
}

function GetAnAccount($id)
{
    // Connexion à la BD et au serveur
    $connexion = GetBD();

    // Création de la string pour la requête
    $requete = "SELECT idComptes,Comptes.nom as nom,prenom,email,actif FROM Comptes WHERE idComptes = $id ";
    // Exécution de la requête
    $resultat = $connexion->query($requete);

    return $resultat;
}

function GetRoles()
{
// Connexion à la BD et au serveur
    $connexion = GetBD();

    // Création de la string pour la requête
    $requete = "SELECT idRoles,Roles.nom as role FROM Roles";
    // Exécution de la requête
    $resultat = $connexion->query($requete);

    return $resultat;
}

/**
 * @param $infos
 */
function DisableA($infos)
{

    $connexion = GetBD();
    $requeteUpd = "UPDATE Comptes SET Actif=0 WHERE idComptes = '".@$infos."'";

    $connexion->exec($requeteUpd);
}

/**
 * @param $infos
 */
function ActivateA($infos)
{

    $connexion = GetBD();
    $requeteUpd = "UPDATE Comptes SET Actif=1 WHERE idComptes = '".@$infos."'";

    $connexion->exec($requeteUpd);
}

/**
 * @param $infos
 *
 */
function UpdateAccount($infos,$id)
{
    // Connexion à la BD et au serveur
    $connexion = GetBD();

    //Test pour savoir si l'adresse email existe déjà
    $requeteE = "select Count(email) from Comptes WHERE email =  '".$infos['email']."'";

    // Exécution de la requête
    $resultatE = $connexion->query($requeteE);
    $result = $resultatE->fetchColumn();

    //Test pour savoir si l'adresse email existe déjà
    $requete2 = "select email from Comptes WHERE email =  '".$infos['email']."' && idComptes = '".$id."'";
    // Exécution de la requête
    $resultat2 = $connexion->query($requete2);
    $result2 = $resultat2->fetchColumn();

    if($result == "0" || $result2 == $infos['email']) {

        //HASHAGE DU MOT DE PASSE
        $hash = hash('sha256', $infos['motdepasse']);

        // Ajout du compte
        $reqUpd = "UPDATE Comptes SET nom='".$infos['nom']."',prenom='".$infos['prenom']."',motdepasse='".$hash."',email='".$infos['email']."',fkRoles=".$infos['role']." WHERE idComptes = '".$id."'";
        $connexion->exec($reqUpd);

        header('Location: index.php?action=gerercomptes&ok');
        exit;

    }
    else
    {
        header('Location: index.php?action=gerercomptes&email');
        exit;
    }
}

