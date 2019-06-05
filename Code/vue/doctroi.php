<?php
/**
 * Created by PhpStorm.
 * User: Kevin.PASTEUR
 * Date: 16.05.2019
 */


$titre = "Demandes d'octroi";
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
                <?php if (isset($_GET['dok'])) {?><div class="alert alert-success" style="text-align: center"  role="alert">Votre demande a bien été refusé !</div> <?php } ?>
                <?php if (isset($_GET['aok'])) {?><div class="alert alert-success" style="text-align: center"  role="alert">Votre demande a bien été accepté !</div> <?php } ?>
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>Compte</th>
                        <th>Catégorie</th>
                        <th>Modèle</th>
                        <th>Nb d'exemplaires</th>
                        <th>Nb octroyés</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach (@$result as $demande) : ?>
                        <tr>
                            <td><?= $demande['email']; ?> </td>
                            <td><?= $demande['categorie']; ?> </td>
                            <td><?= $demande['modele']; ?> </td>
                            <td><?= $demande['nb_exemp']; ?> </td>
                            <td><?= $demande['nb_octroi']; ?> </td>

                            <?php if ($demande['fkStatutsO'] == 1) { ?>
                                <td>
                                    <a href="index.php?action=doctroi&EA&Accept=<?= $demande['idOctroi']; ?>" onclick="return confirm('Accepter cette demande ?')"><button class="btn btn-success btn-xs"><i class="fa fa-check"></i></button></a>
                                    <a href="index.php?action=doctroi&EA&Decline=<?= $demande['idOctroi']; ?>&Consommable=<?= $demande['idConsommables']; ?>" onclick="return confirm('Refuser cette demande ?')"> <button class="btn btn-danger btn-xs"><i class="fa fa-times "></i></button></a>
                                </td>
                            <?php } ?>
                            <?php if ($demande['fkStatutsO'] == 2 || $demande['fkStatutsO'] == 3) { ?> <td><?= $demande['Statut']; ?></td> <?php } ?>
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

