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
require "modele/modele_categories.php";
require "modele/modele_accounts.php";

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
                if($compte['actif']==0) {
                    header('Location: index.php?action=connexion&disable');
                    exit;
                }
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
                $role=2;
                $ac =0;
                Register($infos,$role);
            }
            else
            {
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
            if(@$_GET['disable'])
            {
                $infos = $_GET['disable'];
                DisableM($infos);

                header('Location: index.php?action=materiel&dok');
                exit;

            }
            if(@$_GET['activate'])
            {
                $infos = $_GET['activate'];
                ActivateM($infos);

                header('Location: index.php?action=materiel&aok');
                exit;

            }

            $result = GetAllMaterial();
            $result2 = TestMaterialExist();
            $result2 = $result2->fetchAll();
            $count = count($result2);
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

            if(@$_GET['disable'])
            {
                $infos = $_GET['disable'];
                DisableC($infos);

                header('Location: index.php?action=consommables&dok');
                exit;

            }
            if(@$_GET['activate'])
            {
                $infos = $_GET['activate'];
                ActivateC($infos);

                header('Location: index.php?action=consommables&aok');
                exit;

            }
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
            $result = GetAllCategoriesMA();
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

                $type="A";
                $demande="M";
                email_request($info,$type,$demande);

                header('Location: index.php?action=demprunt&EA&aok');
                exit;
            }

            if (isset($_GET['Decline']) && isset($_GET['Materiel']))
            {
                $emprunt = $_GET['Decline'];
                $materiel = $_GET['Materiel'];
                DeclineRequestM($emprunt, $materiel);

                $type="D";
                $demande="M";
                email_request($emprunt,$type,$demande);
                header('Location: index.php?action=demprunt&EA&dok');
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

            $test = array_values($_POST);
            $row = count($test)/3;

            for ($x = 1; $x <= $row; $x++) {
                if ($_POST["modele$x"] == -1 || !isset($_POST["modele$x"])) {
                    header('Location: index.php?action=octroi&erreur');
                    exit;
                } else {
                    $infos = $_POST;
                    LoanConsumable($infos,$x);

                    if($x==$row) {
                        header('Location: index.php?action=octroi&ok');
                        exit;
                    }
                }
            }
        }
        else {
            $result2 =
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

                $type="A";
                $demande="C";
                email_request($info,$type,$demande);
                header('Location: index.php?action=doctroi&EA&aok');
                exit;
            }

            if (isset($_GET['Decline']) && isset($_GET['Consommable']))
            {
                $octroi = $_GET['Decline'];
                $consommable = $_GET['Consommable'];
                DeclineRequestC($octroi, $consommable);

                $type="D";
                $demande="C";
                email_request($octroi,$type,$demande);
                header('Location: index.php?action=doctroi&EA&dok');
                exit;
            }

            $statut = 1;
            $result = GetRequestsC($statut);

            require "vue/doctroi.php";
        }

        //Vue lorsque les demandes sont "Archivés"
        if (isset($_GET['AV']))
        {
            $statut = "'2' or fkStatutsO = '3'";
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

        $result = GetAllCategoriesMA();
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

function ajoutconso()
{
    if(!empty($_SESSION['role']) && $_SESSION['role'] == "Administrateur" ) {

        $result = GetAllCategoriesCA();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if(!empty($_POST['modele']) && !empty($_POST['nb_exemp']) && !empty($_POST['n_reference']) && !empty($_POST['limite_inf']) && !empty($_POST['prix']) && !empty($_POST['categorie']) ) {

                $infos = $_POST;

                AddConsumable($infos);

                header('Location: index.php?action=ajoutconso&ok');
                exit;
            }
        }


        require "vue/ajoutconso.php";

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

    }
    else
        erreur403();
}

function mesoctrois()
{
    if(!empty($_SESSION['role'])) {
        //Vue lorsque mes demandes sont "en attente"
        if (isset($_GET['EA']))
        {

            $statut = 1;
            $result = GetMyRequestsC($statut);

            require "vue/mes_octrois.php";
        }

        //Vue lorsque mes demandes sont "Archivés"
        if (isset($_GET['AV']))
        {
            $statut = "'3' or fkStatutsO = '4'";
            $result = GetMyRequestsC($statut);
            require "vue/mes_octrois.php";
        }

    }
    else
        erreur403();
}

function gerercategories()
{
    if(!empty($_SESSION['role']) && $_SESSION['role'] == "Administrateur" ) {



        if (isset($_GET['disableM']))
        {
            $infos = $_GET['disableM'];
            DisableCat($infos);

            header('Location: index.php?action=gerercategories&Materiels&dok');
            exit;
        }

        if (isset($_GET['disableC']))
        {
            $infos = $_GET['disableC'];
            DisableCat($infos);

            header('Location: index.php?action=gerercategories&Consommables&dok');
            exit;
        }

        if (isset($_GET['activateM']))
        {
            $infos = $_GET['activateM'];
            ActivateCat($infos);

            header('Location: index.php?action=gerercategories&Materiels&aok');
            exit;
        }


        if (isset($_GET['activateC']))
        {
            $infos = $_GET['activateC'];
            ActivateCat($infos);

            header('Location: index.php?action=gerercategories&Consommables&aok');
            exit;
        }

        if (isset($_GET['Consommables'])) {
            $result = GetCategoriesC();
        }

        if (isset($_GET['Materiels'])) {
            $result = GetCategoriesM();
        }



        require "vue/gerercategories.php";
    }
    else
        erreur403();


}

function gerercomptes()
{
    if(!empty($_SESSION['role']) && $_SESSION['role'] == "Administrateur" ) {



        if (isset($_GET['disable']))
        {
            $infos = $_GET['disable'];
            DisableA($infos);

            header('Location: index.php?action=gerercomptes&dok');
            exit;
        }

        if (isset($_GET['activate']))
        {
            $infos = $_GET['activate'];
            ActivateA($infos);

            header('Location: index.php?action=gerercomptes&aok');
            exit;
        }
        $result = GetAccounts();
        require "vue/gerercomptes.php";
    }
    else
        erreur403();


}

function ajoutcompte()
{
    if(!empty($_SESSION['role']) && $_SESSION['role'] == "Administrateur" ) {

        if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {

            $infos = $_POST;
            $ac=1;
            Register($infos,$ac);


            header('Location: index.php?action=ajoutcompte&ok');
            exit;

        }

        $result = GetRoles();
        require "vue/ajoutcompte.php";
    }
    else
        erreur403();
}

function modifcompte()
{
    if(!empty($_SESSION['role']) && $_SESSION['role'] == "Administrateur" ) {

        @$id = @$_GET['id'];
        if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            @$id = @$_GET['id'];
            $infos = $_POST;
            UpdateAccount($infos,$id);

            header('Location: index.php?action=modif&ok');
            exit;
        }

        $result = GetAnAccount($id);
        $result2 = GetRoles();


        require "vue/modifcompte.php";
    }
    else
        erreur403();
}

function modifcategorie()
{
    if(!empty($_SESSION['role']) && $_SESSION['role'] == "Administrateur" ) {
        @$id = @$_GET['id'];
        if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            @$id = @$_GET['id'];
            $infos = $_POST;
            UpdateCategorie($infos,$id);
        }

        if (isset($_GET['Materiel']))
        {
            $cat = "materiel";
            $result = GetAnCategorieM($id);
        }

        if (isset($_GET['Consommable']))
        {
            $cat = "consommable";
            $result = GetAnCategorieC($id);
        }

        require "vue/modifcat.php";
    }
    else
        erreur403();
}

function modifmateriel()
{
    if(!empty($_SESSION['role']) && $_SESSION['role'] == "Administrateur" ) {
        @$id = @$_GET['id'];
        if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            @$id = @$_GET['id'];
            $infos = $_POST;
            UpdateMaterial($infos,$id);

            header('Location: index.php?action=materiel&mok');
            exit;

        }
            $result = GetAnMaterial($id);
            $result2 = GetAllCategoriesMA();

        require "vue/modifmateriel.php";
    }
    else
        erreur403();
}

function modifconso()
{
    if(!empty($_SESSION['role']) && $_SESSION['role'] == "Administrateur" ) {
        @$id = @$_GET['id'];
        if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            @$id = @$_GET['id'];
            $infos = $_POST;
            UpdateConsumable($infos,$id);

            header('Location: index.php?action=consommables&mok');
            exit;

        }
        $result = GetAnConsumable($id);
        $result2 = GetAllCategoriesCA();

        require "vue/modifconso.php";
    }
    else
        erreur403();
}

function ajoutcategorie()
{
    if(!empty($_SESSION['role']) && $_SESSION['role'] == "Administrateur" )
    {
        @$id = @$_GET['id'];
        if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            @$id = @$_GET['id'];
            $infos = $_POST;
            AddCategorie($infos,$id);
        }

        if (isset($_GET['Materiel']))
        {
            $cat = "materiel";
        }

        if (isset($_GET['Consommable']))
        {
            $cat = "consommable";
        }

        require "vue/ajoutcategorie.php";
    }
    else
        erreur403();
}

function erreur403()
{
    //Redirection sur la page d'erreur
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
























