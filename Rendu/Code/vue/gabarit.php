<?php
/**
 * Created by PhpStorm.
 * User: Kevin.PASTEUR
 * Date: 22.02.2019
 * Time: 09:50
 */
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>ElectroStock</title>

    <!-- CSS -->
    <!-- Custom fonts for this template-->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">


    <link href="contenu/css/sb-admin-2.min.css" rel="stylesheet">

    <link href="contenu/css/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>

<body id="page-top">

<!-- Page Wrapper -->
<div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php?action=accueil">
            <div class="sidebar-brand-text mx-3">ElectroStock</div>
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Nav Item - Dashboard -->
        <li class="nav-item">
            <a class="nav-link" href="index.php?action=accueil">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Accueil</span></a>
        </li>

        <!-- Nav Item - Charts -->
        <li class="nav-item">
            <a class="nav-link" href="index.php?action=materiel">
                <i class="fas fa-fw fa-tv"></i>
                <span>Matériel</span></a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="index.php?action=consommables">
                <i class="fas fa-fw fa-tint"></i>
                <span>Consommables</span></a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">

        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="index.php?action=demprunt" data-toggle="collapse" data-target="#collapsePages2" aria-expanded="true" aria-controls="collapsePages2">
                <i class="fas fa-fw fa-tasks"></i>
                <span>Mes emprunts</span>
            </a>
            <div id="collapsePages2" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Mes demandes :</h6>
                    <a class="collapse-item" href="index.php?action=mes_emprunts&EA">En attente</a>
                    <a class="collapse-item" href="index.php?action=mes_emprunts&EC">En cours</a>
                    <a class="collapse-item" href="index.php?action=mes_emprunts&AV">Archivés</a>
                </div>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="index.php?action=demprunt" data-toggle="collapse" data-target="#collapsePages5" aria-expanded="true" aria-controls="collapsePages5">
                <i class="fas fa-fw fa-tasks"></i>
                <span>Mes octrois</span>
            </a>
            <div id="collapsePages5" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Mes demandes :</h6>
                    <a class="collapse-item" href="index.php?action=mes_octrois&EA">En attente</a>
                    <a class="collapse-item" href="index.php?action=mes_octrois&AV">Archivés</a>
                </div>
            </div>
        </li>

        <?php if ($_SESSION['role'] == "Administrateur") { ?>
        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">

        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="index.php?action=demprunt" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true" aria-controls="collapsePages">
                <i class="fas fa-fw fa-tasks"></i>
                <span>Demandes emprunt</span>
            </a>
            <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Demandes :</h6>
                    <a class="collapse-item" href="index.php?action=demprunt&EA">En attente</a>
                    <a class="collapse-item" href="index.php?action=demprunt&EC">En cours</a>
                    <a class="collapse-item" href="index.php?action=demprunt&AV">Archivés</a>
                </div>
            </div>
        </li>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="index.php?action=demprunt" data-toggle="collapse" data-target="#collapsePages3" aria-expanded="true" aria-controls="collapsePages2">
                    <i class="fas fa-fw fa-tasks"></i>
                    <span>Demandes octroi</span>
                </a>
                <div id="collapsePages3" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Demandes :</h6>
                        <a class="collapse-item" href="index.php?action=doctroi&EA">En attente</a>
                        <a class="collapse-item" href="index.php?action=doctroi&AV">Archivés</a>
                    </div>
                </div>
            </li>
            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">
            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages4" aria-expanded="true" aria-controls="collapsePages2">
                    <i class="fas fa-fw fa-tasks"></i>
                    <span>Gérer les catégories</span>
                </a>
                <div id="collapsePages4" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Catégories :</h6>
                        <a class="collapse-item" href="index.php?action=gerercategories&Materiels">Matériels</a>
                        <a class="collapse-item" href="index.php?action=gerercategories&Consommables">Consommables</a>
                    </div>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="index.php?action=gerercomptes">
                    <i class="fas fa-fw fa-user"></i>
                    <span>Gérer les comptes</span></a>
            </li>

        <?php } ?>

        <hr class="sidebar-divider d-none d-md-block">

        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
        <!-- Main Content -->
        <div id="content">
            <!-- Topbar -->
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                <!-- Sidebar Toggle (Topbar) -->
                <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                    <i class="fa fa-bars"></i>
                </button>
                <!-- Topbar Navbar -->
                <ul class="navbar-nav ml-auto">

                    <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                    <li class="nav-item dropdown no-arrow d-sm-none">
                        <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-search fa-fw"></i>
                        </a>
                        <!-- Dropdown - Messages -->
                        <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                            <form class="form-inline mr-auto w-100 navbar-search">
                                <div class="input-group">
                                    <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="button">
                                            <i class="fas fa-search fa-sm"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </li>

                    <!-- Nav Item - User Information -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="mr-2 d-none d-lg-inline text-gray-600 "><?= $_SESSION['prenom']. " ".$_SESSION['nom']; ?></span>
                        </a>
                        <!-- Dropdown - User Information -->
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                Déconnexion
                            </a>
                        </div>
                    </li>

                </ul>

            </nav>
            <!-- End of Topbar -->

    <!--__________CONTENU__________-->
    <div class="span12" id="divMain">
        <?=$contenu; ?>
    </div>
    <!--________FIN CONTENU________-->


            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; ElectroStock 2019</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Prêt à partir?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Sélectionnez "Déconnexion" si vous voulez quitter votre session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="index.php?action=connexion">Déconnexion</a>
                </div>
            </div>
        </div>
    </div>


    <script type="text/javascript" src="contenu/jquery/jquery.min.js"></script>
    <script type="text/javascript" src="contenu/js/bootstrap.bundle.min.js"></script>

    <script type="text/javascript" src="contenu/jquery/jquery.easing.min.js"></script>

    <script type="text/javascript" src="contenu/js/sb-admin-2.min.js"></script>


    <!-- Page level plugins -->
    <script src="contenu/js/jquery.dataTables.min.js"></script>
    <script src="contenu/js/dataTables.bootstrap4.min.js"></script>
    <script src="contenu/js/search_material.js"></script>
    <script src="contenu/js/add_form.js"></script>

</body>

</html>
