/* Commentaire sur ce fichier !!!!
* ATTENTION : le player_page.js est utile à afficher le player coté client.
* Le problème rencontré si on veut le supprimer ces le chemin myAjax.ajaxurl dans la fonction générer a playlist
*/
$(document).ready(function(){
    var index_bdd_precedent;
    var myPlaylist = new jPlayerPlaylist({
        //jPlayer: "#mon_canvas",
        jPlayer: "#player_video",
        cssSelectorAncestor: "#container_jplayer"
    }, [

    ],  {
        playlistOptions: {
            enableRemoveControls: false,
            autoPlay: true,
            keyEnabled: true,
        },
        //swfPath: "../../dist/jplayer",
        supplied: "webmv, ogv, m4v, oga, mp3",
        useStateClassSkin: true,
        autoBlur: false,
        smoothPlayBar: true,
        keyEnabled: true,
        audioFullScreen: true,
        wmode : "window",
        emulateHtml : true,
        //backgroundColor : "http://www.le-fil.com/wp-content/themes/lefil_com/apple-icon-152x152.png",

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

/*
  window.onload = function()
  {

      var canvas = document.getElementById("canvas");
      var ctx = canvas.getContext("2d");
      var data =  `<svg xmlns='http://www.w3.org/2000/svg' width='200' height='200'>
                  <foreignObject width='100%' height='100%'>
                    <div xmlns='http://www.w3.org/1999/xhtml' style='font-size:40px'>
                      <em>J'</em> aime <span style='color:white; text-shadow:0 0 2px blue;'>les licornes

                      </span>
                    </div>
                  </foreignObject>
                </svg>`;
      var DOMURL = self.URL || self.webkitURL || self;
      var img = new Image();
      var svg = new Blob([data], {type: "image/svg+xml;charset=utf-8"});
      var url = DOMURL.createObjectURL(svg);
      video.onload = function() {
          ctx.drawImage(img, 0, 0);
          DOMURL.revokeObjectURL(url);
      };
      img.src = url;

    }*/


});
