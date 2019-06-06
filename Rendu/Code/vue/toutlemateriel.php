<?php
/**
 * Created by PhpStorm.
 * User: Kevin.PASTEUR
 * Date: 16.05.2019
 */

$titre = "Tout le matériel"; ?>
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <?php if (isset($_GET['dok'])) {?><div class="alert alert-success" style="text-align: center"  role="alert">Votre matériel a bien été désactivé !</div> <?php }?>
                    <?php if (isset($_GET['aok'])) {?><div class="alert alert-success" style="text-align: center"  role="alert">Votre matériel a bien été activé !</div> <?php }?>
                    <?php if (isset($_GET['mok'])) {?><div class="alert alert-success" style="text-align: center"  role="alert">Votre matériel a bien été modifié !</div> <?php }?>

                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>Catégorie</th>
                            <th>Modèle</th>
                            <th>N° Inventaire</th>
                            <th>N° Série</th>
                            <th>Statut</th>
                            <?php if ($_SESSION['role'] == "Administrateur") { ?>
                                <th>Prix</th>
                            <?php } ?>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach (@$result as $materiel) :
                            if (@$materiel['actifM'] == 1 || $_SESSION['role'] == "Administrateur") {  ?>
                            <tr>
                                <td><?= @$materiel['Catégorie']; ?> </td>
                                <td><?= @$materiel['Modèle']; ?> </td>
                                <td><?= @$materiel['N° Inventaire']; ?> </td>
                                <td><?= @$materiel['N° Série']; ?> </td>
                                <td>
                                    <?php  if (@$materiel["Statut"] == 1 )echo "<span class=\"text-success\">Disponible</span>";
                                    else echo "<span class=\"text-danger\">Indisponible</span>";
                                    ?>
                                </td>
                                <?php if ($_SESSION['role'] == "Administrateur") { ?>
                                <td><?= @$materiel['prix']; ?> CHF</td>
                                <td>
                                    <?php  if (@$materiel["Statut"] == '1' && @$materiel['actifM'] == 1) { ?><a href="#"><button class="btn btn-info btn-xs"><i class="fa fa-shopping-basket "></i></button></a>
                                        <a href="index.php?action=modifmateriel&id=<?= @$materiel['idMateriels']; ?>"><button class="btn btn-primary btn-xs"><i class="fa fa-pen"></i></button></a>
                                        <a href="index.php?action=materiel&disable=<?= @$materiel['idMateriels']; ?>" onclick="return confirm('Désactiver ce matériel ?')"> <button class="btn btn-danger btn-xs"><i class="fa fa-toggle-off "></i> Désactiver</button></a>
                                    <?php } elseif(@$materiel['actifM'] == 0) {  ?>
                                        <a href="index.php?action=modifmateriel&id=<?= @$materiel['idMateriels']; ?>"><button class="btn btn-primary btn-xs"><i class="fa fa-pen"></i></button></a>
                                        <a href="index.php?action=materiel&activate=<?= $materiel['idMateriels']; ?>" onclick="return confirm('Réactiver ce matériel ?')"> <button class="btn btn-success btn-xs"><i class="fa fa-toggle-on "></i> Activer</button></a>
                                    <?php } ?>
                                </td>
                                <?php } ?>
                            </tr>
                            <?php }  ?>
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
