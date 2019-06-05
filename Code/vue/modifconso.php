<?php
/**
 * Created by PhpStorm.
 * User: Kevin.PASTEUR
 * Date: 22.05.2019
 * Time: 08:47
 */

$titre = "Modifier un matériel";
Ob_start();
?>
<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Modifier un matériel</h1>
    <hr>
    <div class="card shadow mb-4">
        <div class="card-body">
            <!-- Si le ticket a une erreur-->
            <?php if (isset($_GET['erreur'])) {?><div class="alert alert-danger" style="text-align: center" role="alert">Veuillez vérifier les champs</div> <?php }?>

            <!-- Si le ticket a bien été créé -->
            <?php if (isset($_GET['ok'])) {?><div class="alert alert-success" style="text-align: center"  role="alert">Votre consommable a bien été modifié !</div> <?php }?>

            <form role="form" method="POST" id="ticket" action="index.php?action=modifconso&id=<?= $id; ?>" class="form-horizontal" enctype="multipart/form-data">
                <div class="form-group">
                    <div class="form-group">
                        <span> <b>Catégorie:</b></span>
                        <SELECT class="form-control form-control-user col-lg-3" name="categorie" id="categorie" size="1" required>
                            <?php
                            foreach ($result2 as $cat) :
                                echo "<option value='".$cat["idCategoriesC"]."'>".$cat["nom"]."</option>";
                            endforeach;
                            ?>
                        </SELECT>
                    </div>
                </div>
                <?php
                foreach ($result as $consommable) : ?>
                    <div class="form-group">
                        <div class="form-group">
                            <span> <b>Modèle:</b></span>
                            <input type="text" class="form-control form-control-user col-lg-3" value="<?= $consommable['modele']; ?>" name="modele" placeholder="Modèle" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-group">
                            <span> <b>Nombre d'exemplaire:</b></span>
                            <input type="number" class="form-control form-control-user col-lg-3" value="<?= $consommable['nb_exemp']; ?>"  name="nb_exemp" placeholder="Nombre d'exemplaire" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-group">
                            <span> <b>N° de référence:</b></span>
                            <input type="text" class="form-control form-control-user col-lg-3" value="<?= $consommable['n_reference']; ?>"  name="n_reference" placeholder="N° de référence">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-group">
                            <span> <b>Prix :</b></span>
                            <input type="number" step="any" class="form-control form-control-user col-lg-3" value="<?= $consommable['prix']; ?>" name="prix" placeholder="Prix"  required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-group">
                            <span> <b>Limite inférieure :</b></span>
                            <input type="number" class="form-control form-control-user col-lg-3" value="<?= $consommable['limite_inf']; ?>" name="limite_inf" placeholder="Limite inférieure"  required>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group">
                        <div class="col-lg-offset-2 col-lg-10">
                            <button class="btn btn-primary" type="submit">Envoyer</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </form>

        </div>
    </div>

</div>
<?php $contenu = ob_get_clean();?>
<?php require "vue/gabarit.php";?>


