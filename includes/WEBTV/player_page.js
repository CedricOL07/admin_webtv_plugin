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
    myPlaylist.option("displayTime", 0);

  /*    myPlaylist.setPlaylist([
        {
            title:"Big Buck Bunny Trailer",
            artist:"artiste",
            m4v:"http://www.jplayer.org/video/m4v/Big_Buck_Bunny_Trailer.m4v",
            ogv:"http://www.jplayer.org/video/ogv/Big_Buck_Bunny_Trailer.ogv",
            webmv: "http://www.jplayer.org/video/webm/Big_Buck_Bunny_Trailer.webm",
            poster:"http://www.jplayer.org/video/poster/Big_Buck_Bunny_Trailer_480x270.png"
        },
        {
            title:"Finding Nemo Teaser",
            artist:"Pixar",
            m4v: "http://www.jplayer.org/video/m4v/Finding_Nemo_Teaser.m4v",
            ogv: "http://www.jplayer.org/video/ogv/Finding_Nemo_Teaser.ogv",
            webmv: "http://www.jplayer.org/video/webm/Finding_Nemo_Teaser.webm",
            poster: "http://www.jplayer.org/video/poster/Finding_Nemo_Teaser_640x352.png"
        },
        {
            title:"Incredibles Teaser",
            artist:"Pixar",
            m4v: "http://www.jplayer.org/video/m4v/Incredibles_Teaser.m4v",
            ogv: "http://www.jplayer.org/video/ogv/Incredibles_Teaser.ogv",
            webmv: "http://www.jplayer.org/video/webm/Incredibles_Teaser.webm",
            poster: "http://www.jplayer.org/video/poster/Incredibles_Teaser_640x272.png"
        }
    ]);


/*
*/

    /*
    *       Generer des playli      myPlaylist.displayPlaylist();sts
    */
    /*myAjax.ajaxurl
*  Requête Ajax pour générer des playlists à volonté.
*/


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
          //On va récupérer le nom de l'artiste pour chaque titre

          var title=value.titre;
          console.log(title);

          myPlaylist.add({
            title:value.titre,
            m4v:value.url
          });
          //console.log(value.url);
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


});
