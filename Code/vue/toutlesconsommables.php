<?php

/**
 * Created by PhpStorm.
 * User: Kevin.PASTEUR
 * Date: 24.05.2019
 */

$titre = "Tout les consommables"; ?>
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>Catégorie</th>
                            <th>Modèle</th>
                            <th>Nb Exemplaire</th>
                            <th>N° Référence</th>
                            <?php if ($_SESSION['role'] == "Administrateur") { ?>
                                <th>Fournisseur</th>
                                <th>Prix</th>
                            <?php } ?>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach (@$result as $consommable) : ?>
                            <tr>
                                <td><?= $consommable['categoriesc']; ?> </td>
                                <td><?= $consommable['modele']; ?> </td>
                                <td><?= $consommable['nb_exemp']; ?> </td>
                                <td><?= $consommable['n_reference']; ?> </td>
                                <?php if ($_SESSION['role'] == "Client") { ?>
                                    <td>
                                        <a href="#"><button class="btn btn-info btn-xs"><i class="fa fa-shopping-basket "></i></button></a>
                                    </td>
                                <?php } ?>
                                <?php if ($_SESSION['role'] == "Administrateur") { ?>
                                <td><?= $consommable['fournisseur']; ?></td>
                                <td><?= $consommable['prix']; ?> CHF</td>

                                <td>
                                    <a href="#"><button class="btn btn-info btn-xs"><i class="fa fa-shopping-basket "></i></button></a>
                                    <a href="#"><button class="btn btn-primary btn-xs"><i class="fa fa-pen"></i></button></a>
                                    <a href="#" onclick="return confirm('Supprimer ce consommable ?')"> <button class="btn btn-danger btn-xs"><i class="fa fa-trash "></i></button></a>
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
</div>
<!-- /.container-fluid -->
<!-- End of Main Content -->
<?php $contenu = ob_get_clean();?>
<?php require "vue/gabarit.php";?>
