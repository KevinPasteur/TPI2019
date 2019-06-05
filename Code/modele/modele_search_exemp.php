<?php

/**
 * Created by PhpStorm.
 * User: Kevin.Pasteur
 * Date: 05/06/2019
 */

require "modele_getbd.php";

// connexion au server de BD MySQL et à la BD
$connexion = GetBD();

$requete = "select nb_exemp from Consommables WHERE idConsommables = '".$_GET["id"]."'";
// Exécution de la requête
$resultat = $connexion->query($requete);

$reference = $resultat->fetch();


?>
<script>
    document.getElementById("nb_exemp<?=$_GET["row"];?>").max ="<?= $reference[0]; ?>";
    document.getElementById("nb_exemp<?=$_GET["row"]-1;?>").setAttribute("name","nb_exemp<?=$_GET["row"];?>");
    document.getElementById("nb_exemp<?=$_GET["row"]-1;?>").setAttribute("id","nb_exemp <?=$_GET["row"];?>");
</script>
<div class="form-group" id="f_nb_exemp">
    <label class="col-lg-2 control-label">Nombre d'exemplaire</label>
    <div class="col-lg-6">
        <input class="form-control" type=number max=""  name='nb_exemp1' id="nb_exemp1" required >
    </div>
</div>


