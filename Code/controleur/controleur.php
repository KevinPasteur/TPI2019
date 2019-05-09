<?php
/**
 * Created by PhpStorm.
 * User: Kevin.Pasteur
 * Date: 09.05.2019
 * Time: 11:40
 */

//require "modele/modele.php";

/**
 * Description : Affiche l'accueil ()
 */
function accueil()
{
    require "vue/accueil.php";
}


/**
 * Description : Fonction si une action n'est pas reconnue
 * @param $e
 */
function erreur($e)
{
  $_SESSION['erreur']=$e;
  require "vue/vue_erreur.php";
}
























