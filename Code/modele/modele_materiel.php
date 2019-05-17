<?php

function CountAllMaterial(){

    // Connexion à la BD et au serveur
    $connexion = GetBD();

    $requete = "SELECT count(idMateriels) FROM Materiels";
    // Exécution de la requête
    $resultat = $connexion->query($requete);

    return $resultat;

}


function GetAllMaterial()
{
    $connexion = GetBD();
    $requete = "SELECT idMateriels,CategoriesM.nom as Catégorie, modele as 'Modèle', n_reference as 'N° Référence',prix,n_inventaire as 'N° Inventaire', n_serie as 'N° Série', fkStatutsE as Statut FROM Materiels
LEFT JOIN CategoriesM on fkCategoriesM = idCategoriesM
LEFT JOIN Emprunt on idMateriels = fkMateriels";

    // Exécution de la requête
    $resultat = $connexion->query($requete);

    return $resultat;

}