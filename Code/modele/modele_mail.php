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