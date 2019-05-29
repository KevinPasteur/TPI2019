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
require "modele/modele_search.php";
require "modele/modele_mail.php";

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
            header('Location: index.php?action=connexion&erreur');
            exit;
        }
        else
        {
            header('Location: index.php?action=connexion&erreur');
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
        erreur403();
}

function materiel()
{

    if(!empty($_SESSION['role'])) {

        require "vue/menu_materiel.php";
        if (isset($_POST['q']))
        {
            $materielr = $_POST['q'];
            $rechercheM = SearchM($materielr);
            require "vue/recherchem.php";

        }
        else {
            $result = GetAllMaterial();
            require "vue/toutlemateriel.php";
        }


    }
    else
        erreur403();

}

function consommables()
{

    if(!empty($_SESSION['role'])) {

        require "vue/menu_consommable.php";
        if (isset($_POST['q']))
        {
            $consommabler = $_POST['q'];
            $rechercheC = SearchC($consommabler);
            require "vue/recherchec.php";

        }
        else {
            $result = GetAllConsumables();
            require "vue/toutlesconsommables.php";
        }

    }
    else
        erreur403();

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

                header('Location: index.php?action=emprunt&ok');
                exit;
            }
        }
        else {
            $result = GetAllCategoriesM();
            require "vue/emprunt.php";
        }

    }
    else
        erreur403();
}


function demprunt()
{

    if(!empty($_SESSION['role']) && $_SESSION['role'] == "Administrateur" ) {

        //Vue lorsque les demandes sont "en attente"
        if (isset($_GET['EA']))
        {
            if (isset($_GET['Accept']))
            {
                $info = $_GET['Accept'];
                AcceptRequestM($info);
                header('Location: index.php?action=demprunt&EA');
                exit;
            }

            if (isset($_GET['Decline']) && isset($_GET['Materiel']))
            {
                $emprunt = $_GET['Decline'];
                $materiel = $_GET['Materiel'];
                DeclineRequestM($emprunt, $materiel);
                header('Location: index.php?action=demprunt&EA');
                exit;
            }

            $statut = 1;
            $result = GetRequestsM($statut);

            require "vue/demprunt.php";
        }

        //Vue lorsque les demandes sont "en cours"
        if (isset($_GET['EC']))
        {
            $statut = 2;
            $result = GetRequestsM($statut);


            if(isset($_GET['Check']) && isset($_GET['Materiel']))
            {
                $emprunt = $_GET['Check'];
                $materiel = $_GET['Materiel'];
                CheckRequestM($emprunt, $materiel);
                header('Location: index.php?action=demprunt&EC');
                exit;
            }

            if (isset($_GET['Remind']))
            {
                $id = $_GET['Remind'];
                email_remind($id);
                header('Location: index.php?action=demprunt&EC');
                exit;
            }
            require "vue/demprunt.php";
        }

        //Vue lorsque les demandes sont "Archivés"
        if (isset($_GET['AV']))
        {
            $statut = "'3' or fkStatutsE = '4'";
            $result = GetRequestsM($statut);
            require "vue/demprunt.php";
        }
    }
    else
        erreur403();
}

function octroi()
{
    if(!empty($_SESSION['role'])) {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            if($_POST['modele'] == -1 || !isset($_POST['modele']))
            {
                header('Location: index.php?action=octroi&erreur');
                exit;
            }
            else
            {
                $infos = $_POST;
                //LoanConsumable($infos);

                header('Location: index.php?action=octroi&ok');
                exit;
            }
        }
        else {
            $result = GetAllCategoriesC();
            require "vue/octroi.php";
        }

    }
    else
        erreur403();
}

function doctroi()
{
    if(!empty($_SESSION['role']) && $_SESSION['role'] == "Administrateur" ) {

        //Vue lorsque les demandes sont "en attente"
        if (isset($_GET['EA']))
        {
            if (isset($_GET['Accept']))
            {
                $info = $_GET['Accept'];
                AcceptRequestC($info);
                header('Location: index.php?action=doctroi&EA');
                exit;
            }

            if (isset($_GET['Decline']) && isset($_GET['Consommable']))
            {
                $octroi = $_GET['Decline'];
                $consommable = $_GET['$consommable'];
                DeclineRequestC($octroi, $consommable);
                header('Location: index.php?action=doctroi&EA');
                exit;
            }

            $statut = 1;
            $result = GetRequestsC($statut);

            require "vue/doctroi.php";
        }

        //Vue lorsque les demandes sont "Archivés"
        if (isset($_GET['AV']))
        {
            $statut = "'3' or fkStatutsE = '4'";
            $result = GetRequestsC($statut);
            require "vue/doctroi.php";
        }
    }
    else
        erreur403();


}


function ajoutmateriel()
{
    if(!empty($_SESSION['role']) && $_SESSION['role'] == "Administrateur" ) {

        $result = GetAllCategoriesM();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if(!empty($_POST['modele']) && !empty($_POST['n_inventaire'])  && !empty($_POST['prix']) && !empty($_POST['categorie']) ) {

                $infos = $_POST;

                AddMaterial($infos);

                header('Location: index.php?action=ajoutmateriel&ok');
                exit;
            }
        }


            require "vue/ajoutmateriel.php";

    }
    else
       erreur403();

}

function mesemprunts()
{
    if(!empty($_SESSION['role'])) {
//Vue lorsque les demandes sont "en attente"
        if (isset($_GET['EA']))
        {

            $statut = 1;
            $result = GetMyRequestsM($statut);

            require "vue/mes_emprunts.php";
        }

        //Vue lorsque les demandes sont "en cours"
        if (isset($_GET['EC']))
        {
            $statut = 2;
            $result = GetMyRequestsM($statut);

            require "vue/mes_emprunts.php";
        }

        //Vue lorsque les demandes sont "Archivés"
        if (isset($_GET['AV']))
        {
            $statut = "'3' or fkStatutsE = '4'";
            $result = GetMyRequestsM($statut);
            require "vue/mes_emprunts.php";
        }

        require "vue/mes_emprunts.php";
    }
    else
        erreur403();
}

function erreur403()
{
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
























