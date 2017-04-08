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
      //console.log(data);
      let ligne;
      let compteur=1;
      // Création tableau de clips
      $.each(data,function(key,value){

        ligne+='<tr id="tr'+compteur+'"><td><label><input type="checkbox" name="foo"></label></td>';
        ligne+='<td>'+value.titre+'</td><td>'+value.artiste+'</td><td>'+value.album+'</td><td>'+value.genre+'</td><td>'+value.annee+'</td><td>'+value.qualite+'</td><td>'+value.url+'</td>';
        ligne+='</tr>';
        compteur++;
      });
      $('#tableau_corps').append(ligne);
    },
    error: function(){
      console.log('ERREUR recupération clips depuis la bdd');
    }
  });

  // Option supprimer clips
  $('#supprimer').click(function(){
    if(confirm("Confirmer la suppression des clips sélectionnés?")){
      let data=[];
      $("#tableau_corps tr:has(:checked)").each(function() {
        let titre=$(this).find('td').eq(1).html();
        let artiste=$(this).find('td').eq(2).html();
        let album=$(this).find('td').eq(3).html();
        let genre=$(this).find('td').eq(4).html();
        let annee=$(this).find('td').eq(5).html();
        let qualite=$(this).find('td').eq(6).html();
        let url=$(this).find('td').eq(7).html();

        // Création d'un JSON qui contient les informations sur les clips a supprimer
        let obj={};
        obj.titre=titre;
        obj.artiste=artiste;
        obj.album=album;
        obj.genre=genre;
        obj.annee=annee;
        obj.qualite=qualite;
        obj.url=url;

        data.push(obj);

        if(data.length>0){
          $.post(
            ajaxurl,
            {
              'action':'supprimer_clips',
              'data':data,
            },function(){
                $("#tableau_corps tr:has(:checked)").each(function(){
                  $(this).remove();
                });
            });
        };
      });
      console.log(JSON.stringify(data));
    }

  });
});
