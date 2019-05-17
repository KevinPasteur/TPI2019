<?php

function GetChartM(){

    // Connexion à la BD et au serveur
    $connexion = GetBD();

    $requete = "Select count(fkStatutsE) as indisponible, (SELECT count(idMateriels) FROM electrostock_db.materiels) as disponible from Emprunt where fkStatutsE = 1";
    // Exécution de la requête
    $resultat = $connexion->query($requete);

    return $resultat;
}

function GetChartC(){

    // Connexion à la BD et au serveur
    $connexion = GetBD();

    $requete = "Select count(fkStatutsO) as indisponible, (SELECT count(idConsommables) FROM electrostock_db.consommables) as disponible from Octroi where fkStatutsO = 1";
    // Exécution de la requête
    $resultat = $connexion->query($requete);

    return $resultat;
}



