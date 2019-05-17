<?php
/**
 * Created by PhpStorm.
 * User: Kevin.PASTEUR
 * Date: 16.05.2019
 */


$titre = "Accueil";
Ob_start();
?>

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Tableau de bord</h1>
        </div>


        <!-- Content Row -->

        <div class="row">
            <!-- Total Matériel -->
            <div class="col-xl-6 col-md-6 mb-6">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1" style="text-align: center;">Total matériel</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800" style="text-align: center;"><?= $totalM[0]; ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-dollar-sign fa-tv text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <!-- Total Consommables -->
            <div class="col-xl-6 col-md-6 mb-6">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1" style="text-align: center;">Total consommables</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800" style="text-align: center;"><?= $totalC[0]; ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-dollar-sign fa-tint text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- Graphiques Matériel -->
            <div class="col-xl-6 col-lg-6">
                <div class="card shadow mb-6">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Statut Matériel</h6>
                    </div>
                    <div id="donutchart" style="width: 900px; height: 500px;"></div>
                </div>
            </div>

        <!-- Graphique Consommables -->
            <div class="col-xl-6 col-lg-6">
                <div class="card shadow mb-6">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Statut Consommables</h6>
                    </div>
                    <div id="donutchart2" style="width: 900px; height: 500px;"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- End of Main Content -->

<?php $contenu = ob_get_clean();?>
<?php require "vue/gabarit.php";?>