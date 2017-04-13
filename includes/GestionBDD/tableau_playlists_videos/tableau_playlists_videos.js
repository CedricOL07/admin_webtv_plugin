$(document).ready(function(){


  //Afficher/masquer le tableau
  $('#afficher2').click(function(){
    $('#tableau2').toggle('fast');
    $('#button_line2').toggle('fast');
  });

  //Récuperation des playlists depuis la BDD
  $.ajax({
    url:ajaxurl,
    data:{
      'action':'recuperer_playlists',
    },
    dataType: 'JSON',
    success: function(data){
      //console.log(data);
      let ligne;
      let compteur=1;
      // Création tableau de playlists
      $.each(data,function(key,value){

        ligne+='<tr id="tr'+compteur+'"><td><label><input type="checkbox" name="fooo"></label></td>';
        ligne+='<td>'+value.titre+'</td><td>'+value.poprock+'</td><td>'+value.rap+'</td><td>'+value.jazzblues+'</td><td>'+value.musiquemonde+'</td><td>'+value.electro+'</td><td>'+value.hardrock+'</td><td>'+value.chanson+'</td><td>'+value.autres+'</td>';
        ligne+='</tr>';
        compteur++;
      });
      $('#tableau_corps2').append(ligne);
    },
    error: function(){
      console.log('ERREUR recupération playlists depuis la bdd');
    }
  });

  // Option supprimer playlists
  $('#supprimer2').click(function(){
    if(confirm("Confirmer la suppression des clips sélectionnés?")){
      let datas=[];
      $("#tableau_corps2 tr:has(:checked)").each(function() {
        let nom=$(this).find('td').eq(1).html();
        let poprock=$(this).find('td').eq(2).html();
        let rap=$(this).find('td').eq(3).html();
        let jazzblues=$(this).find('td').eq(4).html();
        let monde=$(this).find('td').eq(5).html();
        let electro=$(this).find('td').eq(6).html();
        let hardrock=$(this).find('td').eq(7).html();
		let chanson=$(this).find('td').eq(8).html();
		let autre=$(this).find('td').eq(9).html();
		

        // Création d'un JSON qui contient les informations sur les clips a supprimer
        let obj={};
        obj.nom=nom;
        obj.poprock=poprock;
        obj.rap=rap;
        obj.jazzblues=jazzblues;
		obj.monde=monde;
        obj.electro=electro;
        obj.hardrock=hardrock;
        obj.chanson=chanson;
		obj.autre=autre;

        datas.push(obj);
		
        if(datas.length>0){
          $.post(
            ajaxurl,
            {
              'action':'supprimer_playlists',
              'data':datas
            },function(response){
                $("#tableau_corps2 tr:has(:checked)").each(function(){
                  $(this).remove();
                  console.log(response);
                });
            });
        };
      });
      //console.log(JSON.stringify(data));
    }

  });
});
