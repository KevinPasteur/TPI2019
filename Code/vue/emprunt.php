<?php
/**
 * Created by PhpStorm.
 * User: Kevin.PASTEUR
 * Date: 22.05.2019
 * Time: 08:47
 */

$titre = "Faire un emprunt";
Ob_start();
?>
<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Formulaire d'emprunt</h1>
    <hr>
    <div class="card shadow mb-4">
        <div class="card-body">
            <!-- Si le ticket a une erreur-->
            <?php if (isset($_GET['erreur'])) {?><div class="alert alert-danger" style="text-align: center" role="alert">Veuillez vérifier les champs</div> <?php }?>

            <!-- Si le ticket a bien été créé -->
            <?php if (isset($_GET['ok'])) {?><div class="alert alert-success" style="text-align: center"  role="alert">Votre emprunt a bien été envoyé !</div> <?php }?>
            <form role="form" method="POST" id="ticket" action="index.php?action=emprunt" class="form-horizontal" enctype="multipart/form-data">
                <div class="form-group">
                    <label class="col-lg-2 control-label">Catégorie</label>
                    <div class="col-lg-6">
                        <SELECT class="form-control" name="categorie" id="categorie" onchange='search_fm();' size="1" required>
                            <option value='-1'>Aucun</option>
                            <?php
                            foreach ($result as $row) :
                                echo "<option value='".$row["idMateriels"]."'>".$row["nom"]."</option>";
                            endforeach;
                            ?>
                        </SELECT>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-2 control-label">Modèle</label>
                    <div id="modele" class="col-lg-6">
                        <select class="form-control" name='modele' required>
                            <option value='-1'>Choisissez d'abord une catégorie</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-2 control-label">Date de l'emprunt</label>
                    <div class="col-lg-6">
                        <input class="form-control" type="date" value="<?= date("Y-m-d"); ?>" name="date_e" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-2 control-label">Date de retour</label>
                    <div class="col-lg-6">
                        <input class="form-control" type="date" min="<?= date("Y-m-d"); ?>" name="date_r" required>
                    </div>
                </div>
                <br>
                <div class="form-group">
                    <div class="col-lg-offset-2 col-lg-10">
                        <button class="btn btn-primary" type="submit">Envoyer</button>
                    </div>
                </div>
            </form>

        </div>
    </div>

</div>
<!-- /.container-fluid -->
</div>
<?php $contenu = ob_get_clean();?>
<?php require "vue/gabarit.php";?>
