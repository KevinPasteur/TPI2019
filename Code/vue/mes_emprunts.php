<?php
/**
 * Created by PhpStorm.
 * User: Kevin.PASTEUR
 * Date: 29.05.2019
 */


$titre = "Mes emprunts";
Ob_start();

?>


<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Mes emprunts
        <?php if (isset($_GET['EA'])) echo " - En attente"; ?>
        <?php if (isset($_GET['EC'])) echo " - En cours"; ?>
        <?php if (isset($_GET['AV'])) echo " - Archivées"; ?>
    </h1>
    <hr>
    <div>
        <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
            <div class="input-group">
                <input class="form-control bg-light border-0 small" aria-describedby="basic-addon2" aria-label="Search" type="text" placeholder="Rechercher...">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="button">
                        <i class="fas fa-search fa-sm"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>Catégorie</th>
                        <th>Modèle</th>
                        <th>Date Emprunt</th>
                        <th>Date retour</th>

                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach (@$result as $demande) : ?>
                        <tr>
                            <td><?= $demande['categorie']; ?> </td>
                            <td><?= $demande['modele']; ?> </td>
                            <td><?= $demande['date_e']; ?> </td>
                            <td><?= $demande['date_r']; ?> </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
<?php $contenu = ob_get_clean();?>
<?php require "vue/gabarit.php";?>


