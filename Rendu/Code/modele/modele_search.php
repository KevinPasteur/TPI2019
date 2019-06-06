<?php

/**
 * Created by PhpStorm.
 * User: Kevin.Pasteur
 * Date: 09.05.2019
 * Time: 11:40
 * Source : https://www.primfx.com/tuto-php-barre-recherche-337/
 */


/**
 * @param $q
 * @return false|PDOStatement
 */
function SearchM($q)
{
        $connexion = GetBD();
        $q = htmlspecialchars($q);

        $recherche = $connexion->query('SELECT idMateriels, CategoriesM.nom as Catégorie, modele as "Modèle",prix,n_inventaire as "N° Inventaire", n_serie as "N° Série", fkStatutsM as Statut FROM Materiels
                                       LEFT JOIN CategoriesM on fkCategoriesM = idCategoriesM
                                       WHERE modele LIKE "%' . $q . '%"  OR CategoriesM.nom LIKE "%' . $q . '%" 
                                       ORDER BY idMateriels DESC;');

        if ($recherche->rowCount() == 0) {
            $recherche = $connexion->query('SELECT idMateriels, CategoriesM.nom as Catégorie, modele as "Modèle",prix,n_inventaire as "N° Inventaire", n_serie as "N° Série", fkStatutsM as Statut FROM Materiels
                                           LEFT JOIN CategoriesM on fkCategoriesM = idCategoriesM
                                           WHERE CONCAT(modele) LIKE "%' . $q . '%"  OR CategoriesM.nom LIKE "%' . $q . '%"
                                           ORDER BY idMateriels DESC;');
        }

        return $recherche;

}


function SearchC($q)
{
    $connexion = GetBD();
    $q = htmlspecialchars($q);

    $recherche = $connexion->query('SELECT CategoriesC.nom as categoriesc, modele, nb_exemp, n_reference, prix,FournisseursC.nom as fournisseur
                FROM Consommables
                LEFT JOIN CategoriesC on fkCategoriesC = idCategoriesC
                LEFT JOIN FournisseursC on fkFournisseursC = idFournisseursC
                WHERE nb_exemp >= 1 AND modele  LIKE "%' . $q . '%" OR CategoriesC.nom LIKE "%' . $q . '%"
                ORDER BY categoriesc ');

    if ($recherche->rowCount() == 0) {
        $recherche = $connexion->query('SELECT CategoriesC.nom as categoriesc, modele, nb_exemp, n_reference, prix,FournisseursC.nom as fournisseur
                FROM Consommables
                LEFT JOIN CategoriesC on fkCategoriesC = idCategoriesC
                LEFT JOIN FournisseursC on fkFournisseursC = idFournisseursC
                WHERE nb_exemp >= 1 AND CONCAT(modele)  LIKE "%' . $q . '%" OR CONCAT(CategoriesC.nom) LIKE "%' . $q . '%" 
                ORDER BY categoriesc ');
    }

    return $recherche;

}