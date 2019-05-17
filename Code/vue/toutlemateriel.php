<?php
/**
 * Created by PhpStorm.
 * User: Kevin.PASTEUR
 * Date: 16.05.2019
 */


$titre = "Accueil";
Ob_start();
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->

    <h1 class="h3 mb-2 text-gray-800">Tout le matériel</h1>
    <hr>
    <div>
        <a class="btn btn-primary btn-icon-split" href="#">
            <span class="text">Emprunter</span>
        </a>
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
        <a class="btn btn-primary btn-icon-split" href="#">
            <span class="text">Ajouter un matériel</span>
        </a>
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
                        <th>N° Inventaire</th>
                        <th>N° Série</th>
                        <th>Statut</th>
                        <?php if ($_SESSION['role'] == "Administrateur") { ?>
                            <th>N° Référence</th>
                            <th>Prix</th>
                        <?php } ?>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach (@$result as $materiel) : ?>
                        <tr>
                            <td><?= $materiel['Catégorie']; ?> </td>
                            <td><?= $materiel['Modèle']; ?> </td>
                            <td><?= $materiel['N° Inventaire']; ?> </td>
                            <td><?= $materiel['N° Série']; ?> </td>
                            <td>
                                <?php  if (!isset($materiel["Statut"]))echo "<span class=\"text-success\">Disponible</span>";
                                else echo "<span class=\"text-danger\">Indisponible</span>";
                                ?>
                            </td>
                            <?php if ($_SESSION['role'] == "Client" && (!isset($materiel["Statut"]))) { ?>
                                <td>
                                    <a href="#"><button class="btn btn-info btn-xs"><i class="fa fa-shopping-basket "></i></button></a>
                                </td>
                            <?php } ?>
                            <?php if ($_SESSION['role'] == "Administrateur") { ?>
                            <td><?= $materiel['N° Référence']; ?></td>
                            <td><?= $materiel['prix']; ?> CHF</td>
                            <td>
                                    <a href="#"><button class="btn btn-info btn-xs"><i class="fa fa-shopping-basket "></i></button></a>
                                    <a href="#"><button class="btn btn-primary btn-xs"><i class="fa fa-pen"></i></button></a>
                                    <a href="#" onclick="return confirm('Supprimer ce matériel ?')"> <button class="btn btn-danger btn-xs"><i class="fa fa-trash "></i></button></a>
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
