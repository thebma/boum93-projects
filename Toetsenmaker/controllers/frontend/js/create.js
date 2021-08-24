

$("#new_cat").hide()
$("#new_toets").hide()

$('#select_cat').on('change',function(){
    if( $(this).val()==="Nieuwe categorie toevoegen"){
        $("#new_cat").show();
        $("#new_toets").hide()
    }

    else if( $(this).val()==="Selecteer een categorie"){
        $("#new_cat").hide()
        $("#new_toets").hide()
    }

    else{
        $("#new_toets").show();
        $("#new_cat").hide()
    }
});