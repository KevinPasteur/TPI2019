
<?php
/**
 * Created by PhpStorm.
 * User: Kevin.PASTEUR
 * Date: 16.05.2019
 */


$titre = "Menu consommable";
Ob_start(); ?>
<div class="container-fluid">
    <!-- Begin Page Content -->
    <h1 class="h3 mb-2 text-gray-800">Tout les consommables</h1>
    <hr>
    <div>
        <a class="btn btn-primary btn-icon-split" href="index.php?action=emprunt">
            <span class="text">Emprunter</span>
        </a>
        <form method="POST" action="index.php?action=consommables" class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
            <div class="input-group">
                <input class="form-control bg-light border-0 small" aria-describedby="basic-addon2" aria-label="Search" name="q" type="search" placeholder="Rechercher...">
                <div class="input-group-append">
                    <input class="btn btn-primary" type="submit" />
                </div>
            </div>
        </form>
        <a class="btn btn-primary btn-icon-split" href="#">
            <span class="text">Ajouter un matériel</span>
        </a>
    </div>


