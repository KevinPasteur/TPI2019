<?php
/**
 * Created by PhpStorm.
 * User: Kevin.Pasteur
 * Date: 09.05.2019
 * Time: 11:40
 */

require "modele/modele_getbd.php";

/**
 * Description : Affiche l'accueil ()
 */
function connexion()
{
    require "vue/connexion.php";
}

/**
 * Description : Fonction qui permet de s'inscrire
 */
function inscription()
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (!(empty($_POST['prenom'])) || !(empty($_POST['nom'])) || !(empty($_POST['email']))|| !(empty($_POST['mdp']))|| !(empty($_POST['confmdp']))) {
            if ($_POST['mdp'] == $_POST['confmdp']) {
                Register($_POST);
            }
            else {
                $_SESSION['info'] = 'mdp';
                require 'vue/inscription.php';
            }
        }
        else
        {
            $_SESSION['info'] = 'vide';
            require 'vue/inscription.php';
        }
    }
    $_SESSION['erreur'] = '';
    require 'vue/inscription.php';
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
























