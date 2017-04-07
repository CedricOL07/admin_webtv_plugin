$(document).ready(function(){


  //Afficher/masquer le tableau
  $('#afficher').click(function(){
    $('#tableau').toggle('fast');
    $('#button_line').toggle('fast');
  });

  //Récuperation des clips depuis la BDD
  $.ajax({
    url:ajaxurl,
    data:{
        'action':'recuperer_clips',
    },
    dataType: 'JSON',
    success: function(data){
      console.log(data);
      let ligne;
      let compteur=1;
      // Création tableau taille dynamique
      $.each(data,function(key,value){

        ligne+='<tr id=ligne_'+compteur+'><td><label><input type="checkbox" name="foo" value=""></label></td>';
        ligne+='<td>'+value.titre+'</td><td>'+value.artiste+'</td><td>'+value.album+'</td><td>'+value.genre+'</td><td>'+value.annee+'</td><td>'+value.qualite+'</td><td>'+value.url+'</td>';
        ligne+='</tr>';
        compteur++;
      });
      $('#tableau_corps').append(ligne);
    },
    error: function(){
      console.log('ERREUR recupération données depuis la bdd');
    }
  });
});
