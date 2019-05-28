<?php
/**
 * Created by PhpStorm.
 * User: Kevin.PASTEUR
 * Date: 22.02.2019
 * Time: 09:54
 */


session_start();
require "controleur/controleur.php";

try {
    if(isset($_GET['action'])){
        $action = $_GET['action'];
        switch ($action){
            case 'connexion':
                connexion();
                break;
            case 'inscription':
                inscription();
                break;
            case 'accueil':
                accueil();
                break;
            case 'materiel':
                materiel();
                break;
            case 'emprunt':
                emprunt();
                break;
            case 'demprunt':
                demprunt();
                break;
            case 'consommables':
                consommables();
                break;
            case 'octroi':
                octroi();
                break;
            case 'doctroi':
                doctroi();
                break;
            case 'ajoutmateriel':
                ajoutmateriel();
                break;

            default:
                erreur403();
                break;
        }
    }
    else
        connexion();
}
catch(Exception $e) {
    erreur($e->getMessage());
}