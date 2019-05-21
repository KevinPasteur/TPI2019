<?php

function GetChartM(){

    // Connexion à la BD et au serveur
    $connexion = GetBD();

    $requete = "SELECT count(idMateriels) as disponible,(SELECT count(idMateriels) FROM Materiels where fkStatutsM = 2 ) as indisponible FROM Materiels where fkStatutsM = 1";
    // Exécution de la requête
    $resultat = $connexion->query($requete);

    return $resultat;
}

function GetChartC(){

    // Connexion à la BD et au serveur
    $connexion = GetBD();

    $requete = "Select count(fkStatutsO) as indisponible, (SELECT count(idConsommables) FROM Consommables) as disponible from Octroi where fkStatutsO = 1";
    // Exécution de la requête
    $resultat = $connexion->query($requete);

    return $resultat;
}



