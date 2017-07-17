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
* Fonction : Permet d'ajouter une nouvelle video du meme genre et dans la meme tranche d'année
* que la video qui a été effacer dans le player.
* Gère la gestion d'ajout et de suppression dans la bdd de la video logo.
*/
var bool_video_logo = false;
jQuery("#player_video").bind(jQuery.jPlayer.event.ended, function (event)
{
	var current = myPlaylist.current;
	var playlist = myPlaylist.playlist;
  var titre_current_track=myPlaylist.playlist[myPlaylist.current].title;
  var genre_logo;
  var artiste_album_annee_ajout = new String();
  var titre;
  var url;
  var genre;// var genre logo différent pour d'autre utilisation

	//On efface le morceau de la base de donnée également
	var titre_previous_current_track=myPlaylist.playlist[myPlaylist.current-1].title;// le -1 permet de récupérer la vidéo précédente.
  console.log(bool_video_logo);
  if (bool_video_logo == true){
    myPlaylist.remove(current);
    myPlaylist.select(0);
    myPlaylist.play(0);
    bool_video_logo = false;
  }
  // agit que sur la bdd
  else{
    myPlaylist.remove(current-1);

  }
  /*
  * Fonction : Permet d'actualiser le player à tout instant sans nécessecité d'actualisation de la page.
  * Cette fonction générera la nouvelle vidéo de la playlist par defaut.
  */
  var taille = myPlaylist.playlist.length;
  setTimeout(doSomething, 100);
  function doSomething() {
    var freq_logo;
    var id_video_courante;
    //console.log("SUCCES");

  $.post(
     myAjax.ajaxurl,
     {
       'action' : 'recup_freq_logo',
     },
     function(response) {

         freq_logo = response;
         //console.log(freq_logo);
         $.post(
            myAjax.ajaxurl,
            {
              'action' : 'recup_id_video_courante',
              'videocourante': titre_current_track
            },
            function(response2) {
                id_video_courante = response2;
                console.log("id " +id_video_courante);
                if (id_video_courante % freq_logo == 0  && freq_logo != 0 && bool_video_logo== false && id_video_courante!=0 ){
                  bool_video_logo = true;
                  console.log(bool_video_logo);
                  $.ajax({
                     url: myAjax.ajaxurl,
                     data:{
                       'action' : 'insertion_logo',
                     },
                     dataType: 'JSON',
                     success: function(data) {
                       $.each(data.data, function(index, value) {

                        // si une video avec le genre logo forcer à la lire
                        // Permet de générer la nouvelle video avec le logo.
                        myPlaylist.add({
                          title:value.titre,
                          m4v:value.url,
                        }, true);

                      });
                    }
                  });
                }
                else{
                 $.ajax({
                    url: myAjax.ajaxurl,
                    data:{
                      'action' : 'recuperer_nouvelle_video_player_page_principal',
                    },
                    dataType: 'JSON',
                    success: function(data) {
                      //console.log("data : "+ data);
                        $.each(data.data, function(index, value) {
                          // la taille est fixé à la limite du nombre de clips dans la playlist ain d'éviter l'erreur de répétition de clip après la suppression du logo.
                           if (taille<13){
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
              }
            );
          }
        );
      }

  });
});
