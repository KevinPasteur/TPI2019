<?php
/**
 * Created by PhpStorm.
 * User: Kevin.Pasteur
 * Date: 09.05.2019
 * Time: 11:40
 */

require "modele/modele_getbd.php";
require "modele/modele_authentication.php";

/**
 * Description : Affiche l'accueil ()
 */
function connexion()
{
    //Si la variable session email est déjà initié on la détruit
    if(isset($_SESSION['email']) && !isset($_GET['vide'])){
        unset($_SESSION['email']);

        session_destroy();

        header('Location: index.php?action=connexion');
        exit;
    }
    //Sinon on se connecte
    else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (!empty($_POST['email']) && !empty($_POST['mdp'])) {

            $infos = $_POST;
            $resultat = GetLogin($infos); // pour récupérer les données du login dans la BD

            //Boucle afin de récupérer les infos dans des variables session
            foreach ($resultat as $compte) :
                $_SESSION['id'] = $compte['idComptes'];
                $_SESSION['email'] = $compte['email'];
                $_SESSION['prenom'] = $compte['prenom'];
                $_SESSION['nom'] = $compte['nom'];
                switch ($compte['role']) {
                    case '2':
                        $_SESSION['role'] = "Client";
                        break;
                    case '1':
                        $_SESSION['role'] = "Administrateur";
                        break;
                }
            endforeach;
            header('Location: index.php?action=accueil');
            exit;
        }
        else
        {
            header('Location: index.php?action=connexion&vide');
            exit;
        }

    }
    require "vue/connexion.php";
}

/**
 * Description : Fonction qui permet de s'inscrire
 */
function inscription()
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        if (!(empty($_POST['prenom'])) || !(empty($_POST['nom'])) || !(empty($_POST['email']))|| !(empty($_POST['mdp']))|| !(empty($_POST['confM']))) {
            if ($_POST['mdp'] == $_POST['confM']) {
                $infos = $_POST;
                Register($infos);
            }
            else {

                header('Location: index.php?action=inscription&erreur');
                exit;
            }
        }
        else
        {
            header('Location: index.php?action=inscription&erreur');
            exit;
        }
    }
    require 'vue/inscription.php';
}

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
  require "vue/erreur.php";
}
























