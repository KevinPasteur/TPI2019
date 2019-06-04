<?php
/**
 * Created by PhpStorm.
 * User: Kevin.PASTEUR
 * Date: 29.05.2019
 */


$titre = "Gestion des comptes";
Ob_start();

?>


<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Gestion des comptes</h1>
    <hr>
    <div>
            <a class="btn btn-primary btn-icon-split" href="index.php?action=ajoutcompte">
                <span class="text">Ajouter un compte</span>
            </a>
    </div>
    <br>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <?php if (isset($_GET['dok'])) {?><div class="alert alert-success" style="text-align: center"  role="alert">Votre compte a bien été désactivé !</div> <?php }?>
                    <?php if (isset($_GET['aok'])) {?><div class="alert alert-success" style="text-align: center"  role="alert">Votre compte a bien été activé !</div> <?php }?>
                    <?php if (isset($_GET['ok'])) {?><div class="alert alert-success" style="text-align: center"  role="alert">Votre compte a bien été modifié !</div> <?php }?>
                    <?php if (isset($_GET['email'])) {?><div class="alert alert-danger" style="text-align: center"  role="alert">Cette email existe déjà !</div> <?php }?>
                    <thead>
                    <tr>
                        <th>Roles</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Email</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach (@$result as $compte) : ?>
                        <tr>
                            <td><?= $compte['roles']; ?> </td>
                            <td><?= $compte['nom']; ?> </td>
                            <td><?= $compte['prenom']; ?> </td>
                            <td><?= $compte['email']; ?> </td>
                            <td>
                                <?php  if ($compte['actif'] == 1) { ?>
                                <a href="index.php?action=modifcompte&id=<?= @$compte['idComptes']; ?>"><button class="btn btn-primary btn-xs"><i class="fa fa-pen"></i></button></a>
                                <a href="index.php?action=gerercomptes&disable=<?= @$compte['idComptes']; ?>" onclick="return confirm('Désactiver ce compte ?')"> <button class="btn btn-danger btn-xs"><i class="fa fa-toggle-off "></i> Désactiver</button></a>
                                <?php } elseif($compte['actif'] == 0) {  ?>
                                <a href="index.php?action=modifcompte&id=<?= @$compte['idComptes']; ?>"><button class="btn btn-primary btn-xs"><i class="fa fa-pen"></i></button></a>
                                <a href="index.php?action=gerercomptes&activate=<?= @$compte['idComptes']; ?>" onclick="return confirm('Activer ce compte ?')"> <button class="btn btn-success btn-xs"><i class="fa fa-toggle-on "></i> Activer</button></a>
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


