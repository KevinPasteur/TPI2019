<?php
/**
 * Created by PhpStorm.
 * User: Kevin.PASTEUR
 * Date: 22.02.2019
 * Time: 09:50
 */


?>
<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>ElectroStock - Connexion</title>

    <!-- Custom fonts for this template-->
    <link href="contenu/css/font/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="contenu/css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

<div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

        <div class="col-xl-10 col-lg-12 col-md-9">

            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Bienvenue sur ElectroStock</h1>
                                </div>
                                <?php if(isset($_GET['erreur'])) { ?> <div class="alert alert-danger" style="text-align: center" role="alert">Votre email ou mot de passe est incorrect</div> <?php } ?>
                                <?php if(isset($_GET['disable'])) { ?> <div class="alert alert-danger" style="text-align: center" role="alert">Votre compte a été désactivé. Si c'est une erreur, contactez : contact@electrostock.mycpnv.ch</div> <?php } ?>
                                <?php if(isset($_GET['ok'])) { ?> <div class="alert alert-success" style="text-align: center" role="alert">Votre compte a bien été créé !</div> <?php } ?>
                                <form method="POST" action="index.php?action=connexion">
                                    <div class="form-group">
                                        <input type="email" class="form-control form-control-user" id="email" name="email" placeholder="Adresse email" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-user" id="mdp" name="mdp" placeholder="Mot de passe" required>
                                    </div>
                                    <button class="btn btn-primary btn-userbtn-block col-lg-12"  type="submit"><i class="fa fa-pencil"></i> Envoyer</button>
                                    <hr>
                                </form>
                                <hr>
                                <div class="text-center">
                                    <a class="small" href="index.php?action=inscription">Inscription</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>

<!-- Bootstrap core JavaScript-->
<script src="contenu/jquery/jquery.min.js"></script>
<script src="contenu/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="contenu/jquery/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="contenu/js/sb-admin-2.min.js"></script>

</body>

</html>
