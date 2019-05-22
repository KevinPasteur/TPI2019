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
    $requete = "SELECT idMateriels, CategoriesM.nom as Catégorie, modele as 'Modèle', n_reference as 'N° Référence',prix,n_inventaire as 'N° Inventaire', n_serie as 'N° Série', fkStatutsM as Statut FROM Materiels
                LEFT JOIN CategoriesM on fkCategoriesM = idCategoriesM";

    // Exécution de la requête
    $resultat = $connexion->query($requete);

    return $resultat;

}

function GetAllCategoriesM()
{
    $connexion = GetBD();
    //Récupération de toutes les catégories sauf celles en prêt

    $requete = "select distinct nom, idMateriels from CategoriesM RIGHT JOIN Materiels on fkCategoriesM = idCategoriesM WHERE fkStatutsM = 1";

    // Exécution de la requête
    $resultat = $connexion->query($requete);

    return $resultat;
}

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


function GetRequests($statut)
{
    $connexion = GetBD();
    //Récupération de toutes les catégories sauf celles en prêt
    $requete = "SELECT idEmprunt,idMateriels,email, modele, date_e, date_r FROM Emprunt
                INNER JOIN Comptes on idComptes = fkComptes
                INNER JOIN empruntmate on idEmprunt = fkEmprunt
                INNER JOIN Materiels on idMateriels = fkMateriels
                WHERE fkStatutsE = '".$statut."'";

    // Exécution de la requête
    $resultat = $connexion->query($requete);

    return $resultat;
}


function AcceptRequest($infos)
{

    $connexion = GetBD();
    $requeteUpd = "UPDATE Emprunt SET fkStatutsE=2 WHERE idEmprunt = '".@$infos["idEmprunt"]."'";
    $connexion->exec($requeteUpd);
}

function DeclineRequest($infos)
{

    $connexion = GetBD();
    $requeteUpd = "UPDATE Emprunt SET fkStatutsE=4 WHERE idEmprunt = '".@$infos["idEmprunt"]."'";
    $connexion->exec($requeteUpd);
}
