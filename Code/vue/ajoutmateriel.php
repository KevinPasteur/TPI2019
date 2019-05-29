<?php
/**
 * Created by PhpStorm.
 * User: Kevin.PASTEUR
 * Date: 22.05.2019
 * Time: 08:47
 */

$titre = "Ajouter un matérielt";
Ob_start();
?>
<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Ajouter un matériel</h1>
    <hr>
    <div class="card shadow mb-4">
        <div class="card-body">
            <!-- Si le ticket a une erreur-->
            <?php if (isset($_GET['erreur'])) {?><div class="alert alert-danger" style="text-align: center" role="alert">Veuillez vérifier les champs</div> <?php }?>

            <!-- Si le ticket a bien été créé -->
            <?php if (isset($_GET['ok'])) {?><div class="alert alert-success" style="text-align: center"  role="alert">Votre matériel a bien été ajouté !</div> <?php }?>

            <form role="form" method="POST" id="ticket" action="index.php?action=ajoutmateriel" class="form-horizontal" enctype="multipart/form-data">
                <div class="form-group">
                    <div class="form-group">
                        <SELECT class="form-control form-control-user col-lg-3" name="categorie" id="categorie" size="1" required>
                            <?php
                            foreach ($result as $row) :
                                echo "<option value='".$row["idCategoriesM"]."'>".$row["nom"]."</option>";
                            endforeach;
                            ?>
                        </SELECT>
                    </div>
                </div>
                <br>
                <div class="form-group">
                    <div class="form-group">
                        <input type="text" class="form-control form-control-user col-lg-3" name="modele" placeholder="Modèle" required>
                    </div>
                </div>
                <br>
                <div class="form-group">
                    <div class="form-group">
                        <input type="text" class="form-control form-control-user col-lg-3"  name="n_inventaire" placeholder="N° inventaire"" required>
                    </div>
                </div>
                <br>
                <div class="form-group">
                    <div class="form-group">
                        <input type="text" class="form-control form-control-user col-lg-3"  name="n_serie" placeholder="N° de série">
                    </div>
                </div>
                <br>
                <div class="form-group">
                    <div class="form-group">
                        <input type="text" class="form-control form-control-user col-lg-3" name="prix" placeholder="Prix"  required>
                    </div>
                </div>
                <hr>
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

