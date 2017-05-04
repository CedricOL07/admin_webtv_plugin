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

        ligne+='<tr><td><label><input type="checkbox" name="foo"></label></td>';
        ligne+='<td name="titre">'+value.titre+'</td><td name="nom">'+value.artiste+'</td><td name="album">'+value.album+'</td><td name="Genre">'+value.genre+'</td><td name="annee">'+value.annee+'</td><td name="qualite">'+value.qualite+'</td><td name="url">'+value.url+'</td>';
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
              'data':data
            },function(response){
                $("#tableau_corps tr:has(:checked)").each(function(){
                  $(this).remove();
                  console.log(response);
                });
            });
        };
      });
      //console.log(JSON.stringify(data));
    }

  });


  // Scripts pour la modification du tableau -> Update BDD
  //Rendre la case du tableau éditable quand on double clique dessus
  let contenu_avant;
  let contenu_apres;
  let champ_bdd;
  $('#tableau_corps').on('dblclick','td',function(){
    $(this).prop('contenteditable', true);
    if($(this).attr("contenteditable")=="true"){
      contenu_avant = $(this).text();
      champ_bdd = $(this).attr("name");
      console.log(contenu_avant);
      console.log(champ_bdd);
    }});

  //Remettre la case en non éditable a la désélection
  $('#tableau_corps').on('blur','td',function(){
    $(this).prop('contenteditable', false);
    contenu_apres = $(this).text();
    console.log(contenu_apres);
    if (contenu_avant != contenu_apres) {
        let update_data={"champ" : champ_bdd,
                         "before" : contenu_avant,
                          "after" : contenu_apres}
        $.post(
          ajaxurl,
          {
            'action' : 'dynamic_update',
            'data':update_data
          },function(response){
            console.log(response);
          });
          };
    });



});
