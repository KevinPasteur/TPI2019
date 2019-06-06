<?php

/**
 * Created by PhpStorm.
 * User: Kevin.PASTEUR
 * Date: 16.05.2019
 */



/**
 * Description : Fonction qui permet à l'utilisateur de se loguer
 */
function GetLogin($infos)
{
    // Connexion à la BD et au serveur
    $connexion = GetBD();

    $Password = hash('sha256',$infos['mdp']);
    // Création de la string pour la requête
    $requete = "select idComptes,nom,prenom,email,fkRoles AS role,actif  from Comptes WHERE email ='".$infos['email']."' AND motdepasse = '".$Password."'";
    // Exécution de la requête
    $resultat = $connexion->query($requete);

    return $resultat;
}

/**
 * @param $infos
 *
 */
function Register($infos,$ac)
{
    // Connexion à la BD et au serveur
    $connexion = GetBD();

    //Test pour savoir si l'adresse email existe déjà
    $requeteE = "select Count(email) from Comptes WHERE email =  '".$infos['email']."'";

    // Exécution de la requête
    $resultatE = $connexion->query($requeteE);
    $result = $resultatE->fetchColumn();


    if($result == "0") {

        //HASHAGE DU MOT DE PASSE
        $hash = hash('sha256', @$infos['mdp']);

        $role = 2;

        if (isset($infos['fkRoles'])) $role = $infos['fkRoles'];

        // Ajout du compte
        $reqIns = "INSERT INTO Comptes (nom,prenom,motdepasse,email,fkRoles) VALUES ('" . $infos['nom'] . "','" . $infos['prenom'] . "','" . $hash . "','" . $infos['email'] . "','".$role."')";
        $connexion->exec($reqIns);

        if($ac == 1)
        {
            header('Location: index.php?action=ajoutcompte&ok');
            exit;
        }
        header('Location: index.php?action=connexion&ok');
        exit;

    }
    else
    {
        if($ac == 1)
        {
            header('Location: index.php?action=ajoutcompte&erreur');
            exit;
        }
        header('Location: index.php?action=inscription&email');
        exit;
    }
}