/**
 * Created by PhpStorm.
 * User: Kevin.PASTEUR
 * Date: 23.05.2019
 * Source : https://www.youtube.com/watch?v=rVmZXJj5lH0
 */



/**
 * Méthode qui sera appelée sur le click du bouton
 */
function search_fm(){
    xhr = new XMLHttpRequest();
    // On défini ce qu'on va faire quand on aura la réponse
    xhr.onreadystatechange = function(){
        leselect = xhr.responseText;
        document.getElementById('modele').innerHTML = leselect;
    }

    // Ici on va voir comment faire du post
    xhr.open("POST","modele/modele_search_fm.php",true);
    // ne pas oublier ça pour le post
    xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    // ne pas oublier de poster les arguments
    // ici, l'id de l'auteur
    sel = document.getElementById('categorie');
    idcategorie = sel.options[sel.selectedIndex].value;
    xhr.send("idCategoriesM="+idcategorie);
}



/**
 * Méthode qui sera appelée sur le click du bouton
 */
function search_fc(a){

    xhr = new XMLHttpRequest();
    // On défini ce qu'on va faire quand on aura la réponse
    xhr.onreadystatechange = function(){
        leselect = xhr.responseText;
        document.getElementById('modele'+a).innerHTML = leselect;
    }

    // Ici on va voir comment faire du post
    xhr.open("POST","modele/modele_search_fc.php",true);
    // ne pas oublier ça pour le post
    xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    // ne pas oublier de poster les arguments
    // ici, l'id de l'auteur
    sel = document.getElementById('categorie'+a);
    idcategorie = sel.options[sel.selectedIndex].value;
    xhr.send("idCategoriesC="+idcategorie);
}


/**
 * Méthode qui sera appelée sur le click du bouton
 */
function search_ex(a){


    sel = document.getElementById('modele'+a);
    idmodele = sel.options[sel.selectedIndex].value;

    $(document).ready(function() {
        $.get("modele/modele_search_exemp.php?id="+idmodele+"&row="+a, function(data){
            $('#f_nb_exemp').replaceWith(data);
        });
    });
}