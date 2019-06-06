<?php
/**
 * Created by PhpStorm.
 * User: Kevin.PASTEUR
 * Date: 24.05.2019
 */




function email_remind($id)
{

    // Connexion à la BD et au serveur
    $connexion = GetBD();

    // Création de la string pour la requête
    $requete = "SELECT email, modele FROM Emprunt
                INNER JOIN Comptes on idComptes = fkComptes
                INNER JOIN EmpruntMate on idEmprunt = fkEmprunt
                INNER JOIN Materiels on idMateriels = fkMateriels
                WHERE idEmprunt = $id";

    // Exécution de la requête
    $resultat = $connexion->query($requete);

    foreach ($resultat as $mail) :
        $email = $mail['email'];
        $modele = $mail['modele'];
    endforeach;

    // Le message
    $message = "Bonjour, le matériel : $modele que vous avez emprunté n'est pas de retour. Veuillez s'il vous plaît le rapporter.
                \r\nPour toutes questions ou remarques globales, envoyez un mail à : contact@electrostock.mycpnv.ch";


    // Dans le cas où nos lignes comportent plus de 120 caractères, nous les coupons en utilisant wordwrap()
    $message = wordwrap($message, 120, "\r\n");

    // Envoi du mail
    $to = $email;
    $sujet = 'Votre emprunt chez electrostock.ch';
    mail($to,$sujet,$message,"From: DoNotReply@electrostock.ch");

}

/**
 * @param $id
 * @param $type
 * @param $demande
 */
function email_request($id,$type,$demande)
{

    // Connexion à la BD et au serveur
    $connexion = GetBD();

    //Test pour savoir si la demande a été acceptée
    if ($demande=="M"){
        // Création de la string pour la requête
        $requete = "SELECT email, modele FROM Emprunt
                INNER JOIN Comptes on idComptes = fkComptes
                INNER JOIN EmpruntMate on idEmprunt = fkEmprunt
                INNER JOIN Materiels on idMateriels = fkMateriels
                WHERE idEmprunt = $id";

        // Exécution de la requête
        $resultat = $connexion->query($requete);

        foreach ($resultat as $mail) :
            $email = $mail['email'];
            $modele = $mail['modele'];
        endforeach;

        if($type=="A"){
            // Le message
            $message = "Bonjour, votre demande pour le matériel : $modele a été acceptée.
                \r\nPour toutes questions ou remarques globales, envoyez un mail à : contact@electrostock.mycpnv.ch";
        } else if($type=="D"){

            $message = "Bonjour, votre demande pour le matériel : $modele a été refusée.
                \r\nPour toutes questions ou remarques globales, envoyez un mail à : contact@electrostock.mycpnv.ch";
        }

        $sujet = "Votre demande d'emprunt chez electrostock.ch";

    } else if ($demande == "C"){
        // Création de la string pour la requête
        $requete = "SELECT email, modele FROM Octroi
                INNER JOIN Comptes on idComptes = fkComptes
                INNER JOIN OctroiConso on idOctroi = fkOctroi
                INNER JOIN Consommables on idConsommables = fkConsommables
                WHERE idOctroi = $id";

        // Exécution de la requête
        $resultat = $connexion->query($requete);

        foreach ($resultat as $mail) :
            $email = $mail['email'];
            $modele = $mail['modele'];
        endforeach;

        if($type=="A"){
            // Le message
            $message = "Bonjour, votre demande pour le consommable : $modele a été acceptée.
                \r\nPour toutes questions ou remarques globales, envoyez un mail à : contact@electrostock.mycpnv.ch";
        } else if($type == "D"){

            $message = "Bonjour, votre demande pour le consommable : $modele a été refusée.
                \r\nPour toutes questions ou remarques globales, envoyez un mail à : contact@electrostock.mycpnv.ch";
        }

        $sujet = "Votre demande d'octroi chez electrostock.ch";

    }


    // Dans le cas où nos lignes comportent plus de 120 caractères, nous les coupons en utilisant wordwrap()
    $message = wordwrap($message, 120, "\r\n");

    // Envoi du mail
    $to = $email;

    mail($to,$sujet,$message,"From: DoNotReply@electrostock.ch");

}


/**
 * @param $id
 */
function email_limit($id)
{

    // Connexion à la BD et au serveur
    $connexion = GetBD();

    // Création de la string pour la requête
    $requete = "SELECT CategoriesC.nom as Categorie,modele,n_reference FROM Consommables
                INNER JOIN CategoriesC on idCategoriesC = fkCategoriesC
                WHERE idConsommables = $id";

    // Récupération de tous les Admins
    $requete2 = "SELECT email FROM Comptes
                 WHERE fkRoles = 1";

    // Exécution de la requête
    $resultat = $connexion->query($requete);
    $resultat2 = $connexion->query($requete);

    foreach ($resultat as $conso) :
        $categorie .= $conso['Categorie'];
        $modele = $conso['modele'];
        $reference = $conso['n_reference'];
    endforeach;

    foreach ($resultat2 as $mail) :
        $email .= $mail['email'].";";
    endforeach;

        // Le message
    $message = "Bonjour, la limite pour le consommable: $categorie - $modele a été atteinte. La référence de ce consommable est : $reference, commandé chez Distrelec: 
                \r\nPour toutes questions ou remarques globales, envoyez un mail à : contact@electrostock.mycpnv.ch";


    $sujet = "Limite atteinte consommable - electrostock.ch";




    // Dans le cas où nos lignes comportent plus de 120 caractères, nous les coupons en utilisant wordwrap()
    $message = wordwrap($message, 120, "\r\n");

    // Envoi du mail
    $to = $email;

    mail($to,$sujet,$message,"From: DoNotReply@electrostock.ch");

}