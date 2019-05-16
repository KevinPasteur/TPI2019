<?php
/**
 * Created by PhpStorm.
 * User: Kevin.PASTEUR
 * Date: 02.2019
 * Time: 08:46
 */
$titre = "erreur";
Ob_start();
?>

<article>
    <header>
        <h2>Erreur</h2>
        <p>L'action demandée est inconnue!</p>
        <?=@$_SESSION['erreur'];?>
    </header>
</article>
<hr/>

<?php $contenu = ob_get_clean();?>
<?php require "vue/gabarit.php";?>
