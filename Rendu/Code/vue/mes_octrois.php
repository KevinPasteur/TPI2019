<?php
/**
 * Created by PhpStorm.
 * User: Kevin.PASTEUR
 * Date: 29.05.2019
 */


$titre = "Mes octrois";
Ob_start();

?>


<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Mes emprunts
        <?php if (isset($_GET['EA'])) echo " - En attente"; ?>
        <?php if (isset($_GET['AV'])) echo " - Archivées"; ?>
    </h1>
    <hr>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>Catégorie</th>
                        <th>Modèle</th>
                        <th>Nb octroyé</th>

                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach (@$result as $demande) : ?>
                        <tr>
                            <td><?= $demande['categorie']; ?> </td>
                            <td><?= $demande['modele']; ?> </td>
                            <td><?= $demande['nb_octroi']; ?> </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

<!-- End of Main Content -->
<?php $contenu = ob_get_clean();?>
<?php require "vue/gabarit.php";?>


