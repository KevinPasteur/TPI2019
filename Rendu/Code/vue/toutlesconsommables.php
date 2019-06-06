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
                        <?php if (isset($_GET['dok'])) {?><div class="alert alert-success" style="text-align: center"  role="alert">Votre consommable a bien été désactivé !</div> <?php }?>
                        <?php if (isset($_GET['aok'])) {?><div class="alert alert-success" style="text-align: center"  role="alert">Votre consommable a bien été activé !</div> <?php }?>
                        <?php if (isset($_GET['mok'])) {?><div class="alert alert-success" style="text-align: center"  role="alert">Votre consommable a bien été modifié !</div> <?php }?>
                        <thead>
                        <tr>
                            <th>Catégorie</th>
                            <th>Modèle</th>
                            <th>Nb Exemplaire</th>
                            <th>N° Référence</th>
                            <?php if ($_SESSION['role'] == "Administrateur") { ?>
                                <th>Fournisseur</th>
                                <th>Prix</th>
                                <th>Limite inférieure</th>
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
                                <?php if ($_SESSION['role'] == "Administrateur") { ?>
                                <td><?= $consommable['fournisseur']; ?></td>
                                <td><?= $consommable['prix']; ?> CHF</td>
                                <td><?php if ($consommable['limite_inf']=="") echo 0; else echo $consommable['limite_inf']; ?></td>

                                <td>
                                    <?php  if (@$consommable["nb_exemp"] > '1' && @$consommable['actifC'] == 1) { ?><a href="#"><button class="btn btn-info btn-xs"><i class="fa fa-shopping-basket "></i></button></a>
                                        <a href="index.php?action=modifconso&id=<?= @$consommable['idConsommables']; ?>"><button class="btn btn-primary btn-xs"><i class="fa fa-pen"></i></button></a>
                                        <a href="index.php?action=consommables&disable=<?= @$consommable['idConsommables']; ?>" onclick="return confirm('Désactiver ce consommable ?')"> <button class="btn btn-danger btn-xs"><i class="fa fa-toggle-off "></i> Désactiver</button></a>
                                    <?php } elseif(@$consommable['actifC'] == 0) {  ?>
                                        <a href="index.php?action=modifconso&id=<?= @$consommable['idConsommables']; ?>"><button class="btn btn-primary btn-xs"><i class="fa fa-pen"></i></button></a>
                                        <a href="index.php?action=consommables&activate=<?= $consommable['idConsommables']; ?>" onclick="return confirm('Réactiver ce consommable ?')"> <button class="btn btn-success btn-xs"><i class="fa fa-toggle-on "></i> Activer</button></a>
                                    <?php } ?>
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
