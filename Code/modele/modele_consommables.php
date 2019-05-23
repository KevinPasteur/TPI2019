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
