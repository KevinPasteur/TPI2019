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

        $recherche = $connexion->query('SELECT idMateriels, CategoriesM.nom as Catégorie, modele as "Modèle", n_reference as "N° Référence",prix,n_inventaire as "N° Inventaire", n_serie as "N° Série", fkStatutsM as Statut FROM Materiels
                                       LEFT JOIN CategoriesM on fkCategoriesM = idCategoriesM
                                       WHERE modele LIKE "%' . $q . '%" 
                                       ORDER BY idMateriels DESC;');

        if ($recherche->rowCount() == 0) {
            $recherche = $connexion->query('SELECT idMateriels, CategoriesM.nom as Catégorie, modele as "Modèle", n_reference as "N° Référence",prix,n_inventaire as "N° Inventaire", n_serie as "N° Série", fkStatutsM as Statut FROM Materiels
                                           LEFT JOIN CategoriesM on fkCategoriesM = idCategoriesM
                                           WHERE CONCAT(modele) LIKE "%' . $q . '%" 
                                           ORDER BY idMateriels DESC;');
        }

        return $recherche;

}
