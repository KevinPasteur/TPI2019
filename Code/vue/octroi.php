<?php
/**
 * Created by PhpStorm.
 * User: Kevin.PASTEUR
 * Date: 28.05.2019
 * Time: 09:00
 */

$titre = "Faire une demande d'octroi";
Ob_start();
?>

<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Formulaire d'octroi</h1>
    <hr>
    <div class="card shadow mb-4">
        <div class="card-body">
            <!-- Si le ticket a une erreur-->
            <?php if (isset($_GET['erreur'])) {?><div class="alert alert-danger" style="text-align: center" role="alert">Veuillez vérifier les champs</div> <?php }?>

            <!-- Si le ticket a bien été créé -->
            <?php if (isset($_GET['ok'])) {?><div class="alert alert-success" style="text-align: center"  role="alert">Votre demande a bien été envoyé !</div> <?php }?>

            <form name="form_consommable" class="form-horizontal" enctype="multipart/form-data" >
                <div id="dynamic_field">
                    <button type="button" name="add" onclick="add_fconsumable(i);" id="add" class="btn btn-success"><i class="fa fa-plus"></i></button>
                    <div class="form-group">
                        <label class="col-lg-2 control-label">Catégorie</label>
                        <div class="col-lg-6">
                            <SELECT class="form-control" name="categorie" id="categorie" onchange='search_fc(1);' size="1" required>
                                <option value='-1'>Aucun</option>
                                <?php
                                foreach ($result as $row) :
                                    echo "<option value='".$row["idCategoriesC"]."'>".$row["nom"]."</option>";
                                endforeach;
                                ?>
                            </SELECT>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 control-label">Modèle</label>
                        <div class="col-lg-6">
                            <select class="form-control" id="modele" name='modele' required>
                                <option value='-1'>Choisissez d'abord une catégorie</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 control-label">Nombre d'exemplaire</label>
                        <div class="col-lg-6">
                            <input class="form-control" type=number name="nb_exemp" required>
                        </div>
                    </div>
                    <br>
                </div>
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

<script>
    var i = 1;
    var a = 1;

    document.getElementById('categorie').setAttribute("name","categorie1");
    document.getElementById('categorie').setAttribute("id","categorie1");

    document.getElementById('modele').setAttribute("name","modele1");
    document.getElementById('modele').setAttribute("id","modele1");

</script>


<?php $contenu = ob_get_clean();?>
<?php require "vue/gabarit.php";?>
