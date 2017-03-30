<div class="col-md-12" style="margin-bottom:2%;">
    <h3>Supprimer un réglage enregistré</h3>
</div>
<div class="col-md-12">
<label> Entrez le nom du réglage que vous voulez supprimer :</label>
    <input type="text" id="input_nom_reglage_supprimer">
    <input type="button" class="btn btn-primary" id="bouton_supprimer_reglage" value="Supprimer">
</div>

<div class="col-md-12" style="margin-top:4%;">

    <div class="tableau_reglages_div" style="overflow:auto;">
        <table id="tableau_reglages" style="border:black 1px solid;">



        </table>
    
    
    </div>
    
    
    
<!-- Table qui affiche le contenu de la table SQL réglage enregistrées-->
<!-- L'utilisateur doit selectionner le nom d'un réglage dans une liste derouante-->


</div>
<style type="text/css">

    .tableau_reglages_div{
        height:'00px; 
     
    }
    #tableau_reglages{
        width:70%;
    }
    td,th{
        border-right:1px solid black;
        text-align: center;
    }
    tr{
        border-bottom:1px solid black;
    }

</style>

<script type="text/javascript">

    

    $.ajax({
        url: ajaxurl, 
        data:{
            'action':'recuperer_tous_reglages_enregistres',
        },
        dataType: 'JSON',
        success: function(response) {
            $('#tableau_reglages').append('<thead style="border-bottom:1px solid black;"><tr><th>Nom</th><th>Debut</th><th>Fin</th></tr></thead>')
            
            $.each(response.data,function(key,value){

                $('#tableau_reglages').append('<tbody><tr><td>'+value.nom+'</td><td>'+value.Debut+'</td><td>'+value.Fin+'</td></tr></tbody>');
            });

        },
        error: function (xhr, ajaxOptions, thrownError) {
            console.log(xhr.status);
            console.log(thrownError);
        }
    });


    $('#bouton_supprimer_reglage').click(function(){
        var nom_reglage_a_supprimer=$('#input_nom_reglage_supprimer').val();  
        $.post(
            ajaxurl,
            {
                'action': 'supprimer_reglage_from_bdd',
                'nom_reglage':nom_reglage_a_supprimer
            },
            function(response){
                console.log(response);
            }
        ); 
        
    });
    

    
    
</script>