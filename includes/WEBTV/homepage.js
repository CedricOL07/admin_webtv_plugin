$(document).ready(function(){
/*
  $.post(
    ajaxurl,
    {
      'action': 'recup_val_par_defaut'
    },
    function (reponse){
      console.log(reponse);
      $.each(reponse.data,function(key,value){
          val_par_defaut = value.ParDefaut;
      });
    }
  );
*/

  //if (val_par_defaut == 0){// permet d'éviter les valeur NULL des horaires car la playlist par défaut n'en a pas.
    $.post(
      ajaxurl,
      {
        'action': 'recuperer_programmation'
      },
      function(response){
        $('#table_programmation').append('<thead><tr><th>Date Début</th><th>Heure Début</th><th>Date Fin</th><th>Heure Fin</th><th>Nom</th></tr></thead>');
        var i=0;
        $.each(response.data,function(key,value){
          if(value.Debut != '' && value.nom !=''){

            var date_debut=value.Debut.substring(0,10);
            var heure_debut= value.Debut.substring(11);
            var date_fin=value.Fin.substring(0,10);
            var heure_fin=value.Fin.substring(11);
            var nom=value.nom;
            if(key==0){
              $('#table_programmation').append('<tbody><tr class="success"><td><strong>'+date_debut+'</strong></td><td><strong>'+heure_debut+'</strong></td><td><strong>'+date_fin+'</strong></td><td><strong>'+heure_fin+'</strong></td><td><strong>'+nom+'</strong></td></tr></tbody>');
            }else{
              $('#table_programmation').append('<tbody><tr class="active"><td>'+date_debut+'</td><td>'+heure_debut+'</td><td>'+date_fin+'</td><td>'+heure_fin+'</td><td>'+nom+'</td></tr></tbody>');
            }
          }
        });
      }
    );

  //}
});
