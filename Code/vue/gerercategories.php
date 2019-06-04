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
    <h1 class="h3 mb-2 text-gray-800">Gestion des catégories
        <?php if (isset($_GET['Materiels'])) echo " - Matériels"; ?>
        <?php if (isset($_GET['Consommables'])) echo " - Consommables"; ?>
    </h1>
    <hr>
    <?php if (isset($_GET['Materiels'])) { ?>
    <div>
        <a class="btn btn-primary btn-icon-split" href="index.php?action=ajoutcategorie&Materiel">
            <span class="text">Ajouter une catégorie</span>
        </a>
    </div>
    <?php } else { ?>
        <div>
            <a class="btn btn-primary btn-icon-split" href="index.php?action=ajoutcategorie&Consommable">
                <span class="text">Ajouter une catégorie</span>
            </a>
        </div>
    <?php } ?>
    <br>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <?php if (isset($_GET['dok'])) {?><div class="alert alert-success" style="text-align: center"  role="alert">Votre catégorie a bien été désactivé !</div> <?php }?>
                    <?php if (isset($_GET['aok'])) {?><div class="alert alert-success" style="text-align: center"  role="alert">Votre catégorie a bien été activé !</div> <?php }?>
                    <?php if (isset($_GET['ajok'])) {?><div class="alert alert-success" style="text-align: center"  role="alert">Votre catégorie a bien été ajouté !</div> <?php }?>
                    <!-- Si le ticket a bien été créé -->
                    <?php if (isset($_GET['ok'])) {?><div class="alert alert-success" style="text-align: center"  role="alert">Votre catégorie a bien été modifié !</div> <?php }?>
                    <thead>
                    <tr>
                        <th>Nom</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach (@$result as $categorie) : ?>
                        <tr>
                            <td><?= $categorie['nom']; ?> </td>
                           <?php if ($_SESSION['role'] == "Administrateur" && isset($categorie['idCategoriesM']) && @$categorie['actif']==1) { ?>
                            <td>
                                <a href="index.php?action=modifcat&Materiel&id=<?= @$categorie['idCategoriesM']; ?>"><button class="btn btn-primary btn-xs"><i class="fa fa-pen"></i></button></a>
                                <a href="index.php?action=gerercategories&disableM=<?= @$categorie['idCategoriesM']; ?>" onclick="return confirm('Désactiver cette catégorie ?')"> <button class="btn btn-danger btn-xs"><i class="fa fa-toggle-off "></i> Désactiver</button></a>
                            </td>
                            <?php } elseif ($_SESSION['role'] == "Administrateur" && isset($categorie['idCategoriesC']) && @$categorie['actif']==1) { ?>
                            <td>
                                <a href="index.php?action=modifcat&Consommable&id=<?= @$categorie['idCategoriesC']; ?>"><button class="btn btn-primary btn-xs"><i class="fa fa-pen"></i></button></a>
                                <a href="index.php?action=gerercategories&disableC=<?= @$categorie['idCategoriesC']; ?>" onclick="return confirm('Désactiver cette catégorie ?')"> <button class="btn btn-danger btn-xs"><i class="fa fa-toggle-off "></i> Désactiver</button></a>
                            </td>
                            <?php } ?>

                            <?php if ($_SESSION['role'] == "Administrateur" && isset($categorie['idCategoriesM']) && @$categorie['actif']==0) { ?>
                                <td>
                                    <a href="index.php?action=modifcat&Materiel&id=<?= @$categorie['idCategoriesM']; ?>"><button class="btn btn-primary btn-xs"><i class="fa fa-pen"></i></button></a>
                                    <a href="index.php?action=gerercategories&activateM=<?= @$categorie['idCategoriesM']; ?>" onclick="return confirm('Activer cette catégorie ?')"> <button class="btn btn-success btn-xs"><i class="fa fa-toggle-on "></i> Activer</button></a>
                                </td>
                            <?php } elseif ($_SESSION['role'] == "Administrateur" && isset($categorie['idCategoriesC']) && $categorie['actif']==0) { ?>
                                <td>
                                    <a href="index.php?action=modifcat&Consommable&id=<?= @$categorie['idCategoriesC']; ?>"><button class="btn btn-primary btn-xs"><i class="fa fa-pen"></i></button></a>
                                    <a href="index.php?action=gerercategories&activateC=<?= @$categorie['idCategoriesC']; ?>" onclick="return confirm('Activer cette catégorie ?')"> <button class="btn btn-success btn-xs"><i class="fa fa-toggle-on "></i> Activer</button></a>
                                </td>
                            <?php } ?>
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


