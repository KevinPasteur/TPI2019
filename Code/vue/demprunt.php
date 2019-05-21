<?php
/**
 * Created by PhpStorm.
 * User: Kevin.PASTEUR
 * Date: 16.05.2019
 */


$titre = "Demandes d'emprunt";
Ob_start();

?>


<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Demandes d'emprunt</h1>
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
                        <th>Compte</th>
                        <th>Modèle</th>
                        <th>Date Emprunt</th>
                        <th>Date retour</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach (@$result as $demande) : ?>
                        <tr>
                            <td><?= $demande['email']; ?> </td>
                            <td><?= $demande['modele']; ?> </td>
                            <td><?= $demande['date_e']; ?> </td>
                            <td><?= $demande['date_r']; ?> </td>
                            <td>
                                <?php if ($_SESSION['role'] == "Administrateur") { ?>
                                    <a href="index.php?action=demprunt&EA&Accept=<?= $demande['idEmprunt']; ?>" onclick="return confirm('Accepter cette demande ?')"><button class="btn btn-success btn-xs"><i class="fa fa-check"></i></button></a>
                                    <a href="index.php?action=demprunt&EA&Decline=<?= $demande['idEmprunt']; ?>" onclick="return confirm('Refuser cette demande ?')"> <button class="btn btn-danger btn-xs"><i class="fa fa-times "></i></button></a>
                                    <?php

                                    if ($demande['date_r'] < date("Y-m-d")) { ?> <a href="#"> <button class="btn btn-primary btn-xs"><i class="fa fa-bell "></i></button></a> <?php } ?>
                                    <?php } ?>
                            </td>
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

