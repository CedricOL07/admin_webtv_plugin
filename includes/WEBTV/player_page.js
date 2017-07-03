/* Commentaire sur ce fichier !!!!
* ATTENTION : le player_page.js est utile à afficher le player coté client.
* Le problème rencontré si on veut le supprimer ces le chemin myAjax.ajaxurl dans la fonction générer a playlist
*/
$(document).ready(function(){
    var index_bdd_precedent;
    var myPlaylist = new jPlayerPlaylist({
        jPlayer: "#player_video",
        cssSelectorAncestor: "#container_jplayer"
    }, [

    ],  {
        playlistOptions: {
            enableRemoveControls: false,
            autoPlay: true,
            //keyEnabled: true,
        },
        //swfPath: "../../dist/jplayer",
        supplied: "webmv, ogv, m4v, oga, mp3",
        useStateClassSkin: true,
        autoBlur: false,
        smoothPlayBar: true,
        keyEnabled: true,
        audioFullScreen: true,

    });

    $('#affichage_playlist-page-client').click(function(){
    $('#jp-playlits-id-page-client').toggle('fast');
    });

    /** REQUETE AJAX WORDPRESS
*
*   le terme action:'mon_action' refere à la fonction qui est effectué quand la requete ajax se fait (ici on recupere les url,titre,artiste de la playlist)
*
*   le terme url: ajaxurl  est le chemin vers le fichier qui recupere les requete ajax
*
*
*
*/

  function generer_la_playlist(){
    var tableau_donnees= new Array();
    var artiste;
    $.ajax({
      url: myAjax.ajaxurl,
      data:{
        'action':'recuperer_videos_player_page_principale',
      },
      dataType: 'JSON',
      success: function(data) {
        //console.log(data);
        $.each(data.data, function(index, value) {
          var title=value.titre;
          console.log(title);
          myPlaylist.add({
            title:value.titre,
            m4v:value.url
          });
          myPlaylist.play();// permet de s'affranchir du bouton play lors du chargmenent de la page.
        });
      },

      error: function (xhr, ajaxOptions, thrownError) {
        console.log(xhr.status);
        console.log(thrownError);
      }

    });
  }
  generer_la_playlist();

  /*
  * Fonction : Permet d'actualiser le player à tout instant sans nécessecité d'actualisation de la page.
  * Cette fonction générera la nouvelle vidéo de la playlist par defaut.
  */
  jQuery("#player_video").bind(jQuery.jPlayer.event.ended, function (event)
  {
      var playlist = myPlaylist.playlist;
    $.ajax({
      url:  myAjax.ajaxurl,
      data:{
        'action' : 'recuperer_nouvelle_video_player_page_principal'
      },
      dataType: 'JSON',
      success: function(data) {
        //console.log("data : "+ data);
          $.each(data.data, function(index, value) {
              titre= value.titre;
              //Permet de générer la nouvelle video.
              myPlaylist.add({
  				title:value.titre,
  				m4v:value.url,
  				artist:value.artiste
  			});
          myPlaylist.remove(0);// supprime le premier clip de la playlist.
  		});

          console.log(titre);
      }
    });

  });

  window.onload = function()
  {
      var canvas = document.getElementById('mon_canvas');
          if(!canvas)
          {
              alert("Impossible de récupérer le canvas");
              return;
          }

      var context = canvas.getContext('2d');
          if(!context)
          {
              alert("Impossible de récupérer le context du canvas");
              return;
          }


      //C'est ici que l'on placera tout le code servant à nos dessins.
  }












});
