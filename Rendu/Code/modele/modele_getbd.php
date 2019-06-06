<?php

/**
 * Created by PhpStorm.
 * User: Kevin.PASTEUR
 * Date: 16.05.2019
 */

function GetBD()
{
    // connexion au server de BD MySQL et à la BD
    $connexion = new PDO('mysql:host=localhost; dbname=pasteurk_db', 'root', 'Pa$$w0rd');
    $connexion->exec("set names utf8");
    // permet d'avoir plus de détails sur les erreurs retournées
    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $connexion;

}


