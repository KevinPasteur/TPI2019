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
    <h1 class="h3 mb-2 text-gray-800">Demandes d'emprunt
        <?php if (isset($_GET['EA'])) echo " - En attente"; ?>
        <?php if (isset($_GET['EC'])) echo " - En cours"; ?>
        <?php if (isset($_GET['AV'])) echo " - Archivées"; ?>
    </h1>
    <hr>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <?php if (isset($_GET['dok'])) {?><div class="alert alert-success" style="text-align: center"  role="alert">Votre demande a bien été refusé !</div> <?php } ?>
                    <?php if (isset($_GET['aok'])) {?><div class="alert alert-success" style="text-align: center"  role="alert">Votre demande a bien été accepté !</div> <?php } ?>
                    <thead>
                    <tr>
                        <th>Compte</th>
                        <th>Catégorie</th>
                        <th>Modèle</th>
                        <th>Date Emprunt</th>
                        <th>Date retour</th>

                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach (@$result as $demande) : ?>
                        <tr>
                            <td><?= $demande['email']; ?> </td>
                            <td><?= $demande['categorie']; ?> </td>
                            <td><?= $demande['modele']; ?> </td>
                            <td><?= $demande['date_e']; ?> </td>
                            <td><?= $demande['date_r']; ?> </td>

                                <?php if ($demande['fkStatutsE'] == 1) { ?>
                                    <td>
                                        <a href="index.php?action=demprunt&EA&Accept=<?= $demande['idEmprunt']; ?>" onclick="return confirm('Accepter cette demande ?')"><button class="btn btn-success btn-xs"><i class="fa fa-check"></i></button></a>
                                        <a href="index.php?action=demprunt&EA&Decline=<?= $demande['idEmprunt']; ?>&Materiel=<?= $demande['idMateriels']; ?>" onclick="return confirm('Refuser cette demande ?')"> <button class="btn btn-danger btn-xs"><i class="fa fa-times "></i></button></a>
                                    </td>
                                <?php } if ($demande['fkStatutsE'] == 2) { ?>
                                            <td>
                                                <a href="index.php?action=demprunt&EC&Check=<?= $demande['idEmprunt']; ?>&Materiel=<?= $demande['idMateriels']; ?>" onclick="return confirm('Accepter cette demande ?')"><button class="btn btn-primary btn-xs">Check-Out</button></a>
                                                <?php if ($demande['date_r'] < date("Y-m-d")) { ?> <a href="index.php?action=demprunt&EC&Remind=<?= $demande['idEmprunt']; ?>"> <button class="btn btn-primary btn-xs"><i class="fa fa-bell "></i></button></a> <?php } ?>
                                            </td>
                                        <?php } ?>
                        <?php if ($demande['fkStatutsE'] == 3 || $demande['fkStatutsE'] == 4) { ?> <td><?= $demande['Statut']; ?></td> <?php } ?>
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

