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
  var artiste_album_annee_gener = new String();
  $.ajax({
    url: myAjax.ajaxurl,
    data:{
      'action':'recuperer_videos_player_page_principale_par_defaut',
    },
    dataType: 'JSON',
    success: function(data) {
      //console.log(data);
      $.each(data.data, function(index, value) {
        //On va récupérer le nom de l'artiste pour chaque titre
        artiste_album_annee_gener=  value.artiste + " - " + value.album  + " - " +value.annee;
        var title=value.titre;

        myPlaylist.add({
    			title:value.titre,
    			m4v:value.url,
    			artist:artiste_album_annee_gener
        });
        //console.log(value.url);
        myPlaylist.play();// permet de s'affranchir du bouton play lors du chargmenent de la page.
        console.log(title);
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
  var bdd_logo = false;
  var current = myPlaylist.current;
  var playlist = myPlaylist.playlist;
  var titre_current_track=myPlaylist.playlist[myPlaylist.current].title;
  var genre_logo;
  var artiste_album_annee_ajout = new String();
  var taille = myPlaylist.playlist.length;

  $.post(
    myAjax.ajaxurl,
    {
      'action': 'recup_genre_video_courante_logo',
      'videocourante': titre_current_track
    },
    function(response){

      genre_logo =response;
      //console.log("GENRE : " + genre_logo +" fds");
    // supprime la video de logo et on se remet en place
    // ATTENTION le == ou === ne fonctionne pas.
      if( genre_logo >= 1){

        myPlaylist.remove(current);
        myPlaylist.select(0);
        myPlaylist.play(0);
        bdd_logo = true;
      }
      else{
      myPlaylist.remove(0);// efface le premier clip de la playlist du player.
      }
      /*
      * Fonction : Permet d'actualiser le player à tout instant sans nécessecité d'actualisation de la page.
      * Cette fonction générera la nouvelle vidéo de la playlist par defaut.
      */


       $.ajax({
          url: myAjax.ajaxurl,
          data:{
            'action' : 'recuperer_nouvelle_video_player_page_principal',
          },
          dataType: 'JSON',
          success: function(data) {
          //console.log("data : "+ data);
            $.each(data.data, function(index, value) {
              genre = value.genre;
              // si une video avec le genre logo forcer à la lire
              if (genre === "Logo" && bdd_logo = true){

                titre = value.titre;
                url = value.url;
                artiste_album_annee_ajout =  value.artiste + " - " + value.album  + " - " +value.annee;
              //Permet de générer la nouvelle video avec le logo.
                myPlaylist.add({
                  title:value.titre,
                  m4v:value.url,
                  artist: artiste_album_annee_ajout,
                }, true);

                //console.log("entré pour le logo : " + taille);
              }

              // la taille est fixé à la limite du nombre de clips dans la playlist ain d'éviter l'erreur de répétition de clip après la suppression du logo.
              else if (taille<13){
                titre2= value.titre;
                artiste_album_annee_ajout =  value.artiste + " - " + value.album  + " - " +value.annee;

              //Permet de générer la nouvelle video.
                myPlaylist.add({
                  title:value.titre,
                  m4v:value.url,
                  artist: artiste_album_annee_ajout
                });
                //console.log("ajout dans le player : " + titre2);
              }
            });
          }
        });
      }
    );
  });
});
