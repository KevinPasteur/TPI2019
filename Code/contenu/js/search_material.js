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