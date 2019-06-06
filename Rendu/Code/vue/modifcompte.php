<?php
/**
 * Created by PhpStorm.
 * User: Kevin.PASTEUR
 * Date: 22.05.2019
 */

$titre = "Modifier un compte";
Ob_start();
?>
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Modifier un compte</h1>
        <hr>
        <div class="card shadow mb-4">
            <div class="card-body">
                <!-- Si le ticket a une erreur-->
                <?php if (isset($_GET['erreur'])) {?><div class="alert alert-danger" style="text-align: center" role="alert">Veuillez vérifier les champs</div> <?php }?><!-- Si le ticket a une erreur-->
                <?php if (isset($_GET['email'])) {?><div class="alert alert-danger" style="text-align: center" role="alert">L'email est déjà utilisé</div> <?php }?>

                <!-- Si le ticket a bien été créé -->
                <?php if (isset($_GET['ok'])) {?><div class="alert alert-success" style="text-align: center"  role="alert">Votre compte a bien été modifié !</div> <?php }?>

                <form role="form" method="POST" id="compte" action="index.php?action=modifcompte&id=<?= $id ?>" class="form-horizontal" enctype="multipart/form-data">

                        <div class="form-group">
                            <div class="form-group">
                                <SELECT class="form-control form-control-user col-lg-3" name="role" id="role" size="1" required>
                                    <?php foreach ($result2 as $role) :
                                     echo "<option value='".$role["idRoles"]."'>".$role["role"]."</option>";
                                     endforeach; ?>
                                </SELECT>
                            </div>
                        </div>

                    <br>
                    <?php foreach ($result as $compte) : ?>
                        <div class="form-group">
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user col-lg-3" name="nom" value="<?= $compte['nom']; ?>" placeholder="Nom" required>
                            </div>
                        </div>
                        <br>
                        <div class="form-group">
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user col-lg-3"  name="prenom" value="<?= $compte['prenom']; ?>" placeholder="Prénom" required>
                            </div>
                        </div>
                        <br>
                        <div class="form-group">
                            <div class="form-group">
                                <input type="email" class="form-control form-control-user col-lg-3"  name="email" value="<?= $compte['email']; ?>" placeholder="Email">
                            </div>
                        </div>
                        <br>
                        <div class="form-group">
                            <div class="form-group">
                                <input type="password" class="form-control form-control-user col-lg-3" name="mdp" placeholder="Mot de passe"  required>
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
    <!-- /.container-fluid -->
    </div>
<?php $contenu = ob_get_clean();?>
<?php require "vue/gabarit.php";?>


