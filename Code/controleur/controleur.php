<?php
/**
 * Created by PhpStorm.
 * User: Kevin.Pasteur
 * Date: 09.05.2019
 * Time: 11:40
 */

require "modele/modele_getbd.php";
require "modele/modele_authentication.php";
require "modele/modele_getChart.php";
require "modele/modele_materiel.php";
require "modele/modele_consommables.php";

/**
 * Description : Affiche l'accueil ()
 */
function connexion()
{
    //Si la variable session email est déjà initié on la détruit
    if(isset($_SESSION['email']) && !isset($_GET['vide'])){
        unset($_SESSION['email']);

        session_destroy();

        header('Location: index.php?action=connexion');
        exit;
    }
    //Sinon on se connecte
    else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (!empty($_POST['email']) && !empty($_POST['mdp'])) {

            $infos = $_POST;
            $resultat = GetLogin($infos); // pour récupérer les données du login dans la BD

            //Boucle afin de récupérer les infos dans des variables session
            foreach ($resultat as $compte) :
                $_SESSION['id'] = $compte['idComptes'];
                $_SESSION['email'] = $compte['email'];
                $_SESSION['prenom'] = $compte['prenom'];
                $_SESSION['nom'] = $compte['nom'];
                switch ($compte['role']) {
                    case '2':
                        $_SESSION['role'] = "Client";
                        break;
                    case '1':
                        $_SESSION['role'] = "Administrateur";
                        break;
                }
            endforeach;

            //Test pour savoir si l'id est valide
            if(!empty($_SESSION['id'])) {
                header('Location: index.php?action=accueil');
                exit;
            }
            header('Location: index.php?action=connexion&vide');
            exit;
        }
        else
        {
            header('Location: index.php?action=connexion&vide');
            exit;
        }

    }
    require "vue/connexion.php";
}

/**
 * Description : Fonction qui permet de s'inscrire
 */
function inscription()
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        if (!(empty($_POST['prenom'])) || !(empty($_POST['nom'])) || !(empty($_POST['email']))|| !(empty($_POST['mdp']))|| !(empty($_POST['confM']))) {
            if ($_POST['mdp'] == $_POST['confM']) {
                $infos = $_POST;
                Register($infos);
            }
            else {

                header('Location: index.php?action=inscription&erreur');
                exit;
            }
        }
        else
        {
            header('Location: index.php?action=inscription&erreur');
            exit;
        }
    }
    require 'vue/inscription.php';
}

function accueil()
{
    if(!empty($_SESSION['role'])) {
        $resultat = CountAllMaterial();
        $totalM = $resultat->fetch(PDO::FETCH_BOTH);

        $resultat = CountAllConsumables();
        $totalC = $resultat->fetch(PDO::FETCH_BOTH);

        graphC();
        graphM();
        require "vue/accueil.php";
    }
    else
        require "vue/erreur403.php";
}

function materiel()
{

    if(!empty($_SESSION['role'])) {

            $result = GetAllMaterial();
            require "vue/toutlemateriel.php";
    }
    else
        require "vue/erreur403.php";

}

function graphM()
{
    $resultat = GetChartM(); // pour récupérer les données des graphiques

    //Boucle afin de récupérer les infos dans des variables session
    foreach ($resultat as $resultats) :
        $disponible = $resultats['disponible'];
        $indisponible = $resultats['indisponible'];
    endforeach;

    ?>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load("current", {packages:["corechart"]});
        google.charts.setOnLoadCallback(drawChart);
        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Task', 'Hours per Day'],
                ['Disponible',     <?= $disponible; ?>],
                ['Indisponible',      <?= $indisponible; ?>],

            ]);

            var options = {
                pieHole: 0.5,
            };

            var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
            chart.draw(data, options);
        }
    </script>
    <?php
}

function graphC()
{
    $resultat = GetChartC(); // pour récupérer les données des graphiques

    //Boucle afin de récupérer les infos dans des variables session
    foreach ($resultat as $resultats) :
        $disponible = $resultats['disponible'];
        $indisponible = $resultats['indisponible'];
    endforeach;

    $rDisponible = $disponible - $indisponible;
    ?>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load("current", {packages:["corechart"]});
        google.charts.setOnLoadCallback(drawChart);
        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Task', 'Hours per Day'],
                ['Disponible',     <?= $rDisponible; ?>],
                ['Indisponible',      <?= $indisponible; ?>],

            ]);

            var options = {
                pieHole: 0.5,
            };

            var chart = new google.visualization.PieChart(document.getElementById('donutchart2'));
            chart.draw(data, options);
        }
    </script>
    <?php
}


function emprunt()
{
    if(!empty($_SESSION['role'])) {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            if($_POST['modele'] == -1 || !isset($_POST['modele']))
            {
                header('Location: index.php?action=emprunt&erreur');
                exit;
            }
            else
            {
                $infos = $_POST;
                LoanMaterial($infos);
            }
            require "vue/emprunt.php";
        }
        else {
            $result = GetAllCategoriesM();
            require "vue/emprunt.php";
        }

    }
    else
        require "vue/erreur403.php";
}


function demprunt()
{

    if(!empty($_SESSION['role']) && $_SESSION['role'] == "Administrateur" ) {


        if ($_SERVER['REQUEST_METHOD'] == 'POST') {


        }

        //Vue lorsque les demandes sont "en attente"
        if (isset($_GET['EA']))
        {
            if (isset($_GET['Accept']))
            {
                $info = $_GET['Accept'];
                AcceptRequest($info);
            }

            if (isset($_GET['Decline']))
            {
                $info = $_GET['Decline'];
                DeclineRequest($info);
            }
            if (isset($_GET['Remind']))
            {

            }
            $statut = 1;
            $result = GetRequests($statut);

            require "vue/demprunt.php";
        }

        //Vue lorsque les demandes sont "en cours"
        if (isset($_GET['EC']))
        {
            $statut = 2;
            $result = GetRequests($statut);
            require "vue/demprunt.php";
        }

        //Vue lorsque les demandes sont "Archivés"
        if (isset($_GET['AV']))
        {
            $statut = 3;
            $result = GetRequests($statut);
            require "vue/demprunt.php";
        }

    }
    else
        require "vue/erreur403.php";
}

/**
 * Description : Fonction si une action n'est pas reconnue
 * @param $e
 */
function erreur($e)
{
  $_SESSION['erreur']=$e;
  require "vue/erreur.php";
}
























