function add_fconsumable()
{
    i++;

    $(document).ready(function() {
        $.get("modele/modele_getCategoriesC.php?cat="+i, function(data){
            $('#dynamic_field').append(data);
        });
    });
}
