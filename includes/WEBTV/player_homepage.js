/* Fonction de ce fichier :
*Il permet de gérer les interactions avec le player coté product owner.
*Tous les contrôles du player de jplayer et l'implémentation des clips dans la  playlist du Player se font ici.
* Tous les affichages et l'aspect visuel se font dans le fichier index.php dans le dossier page_principal
* Les fonctions dans la rubrique action des fonction ajax sont dans les fichiers  includes/GenerationPlaylist_par_defaut.php et
* includes/nouveaux_reglages/traitement_donnees_playlist_par_defaut.php
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
      loopOnPrevious: true,
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

  });

  $('#affichage_playlist_homepage').click(function(){
  $('#jp-playlits-id-homepage').toggle('fast');
  });

/*
*       Generer des playlists
*
*  Requête Ajax pour générer des playlists à volonté.
*/


/** REQUETE AJAX WORDPRESS
*
*   le terme action:'mon_action' refere à la fonction qui est effectué quand la requete ajax se fait (ici on recupere les url,titre,artiste de la playlist)
*
*   le terme url: ajaxurl  est le chemin vers le fichier qui recupere les requete ajax
*
*
*/

/*
* fonction : Permet de génerer la playlist des 12 clips video à l'aide de la playlist par defaut de la bdd wordpress
*
*/

function generer_la_playlist(){
  var artiste_album_annee_gener = new String();
  $.ajax({
    url: ajaxurl,
    data:{
      'action':'recuperer_videos_player_page_principale_par_defaut',
    },
    dataType: 'JSON',
    success: function(data) {
      //console.log("génération de la playlist: "+data);
      $.each(data.data, function(index, value) {
        //On va récupérer le nom de l'artiste pour chaque titre
        artiste_album_annee_gener=  value.artiste + " - " + value.album  + " - " +value.annee;
        var title=value.titre;
        var url = value.url;

        myPlaylist.add({
    			title:value.titre,
    			m4v:value.url,
    			artist:artiste_album_annee_gener
        });
        //console.log(value.url);
        myPlaylist.play();// permet de s'affranchir du bouton play lors du chargmenent de la page.
        //console.log(url);
      });

    },
    error: function (xhr, ajaxOptions, thrownError) {
      console.log(xhr.status);
      console.log(thrownError);
    }
  });
}
generer_la_playlist();



/*--------------------------------------- Règles internes --------------------------------------------------*/


/*
* Fonction :
* _Permet d'ajouter une nouvelle video du meme genre
* et dans la meme tranche d'année avec une qualité identique ou supérieur
* que la video qui a été effacer dans le player.
* _Gère la gestion d'ajout et de suppression dans la bdd de la video logo.
* _ toutes les actions sont font à la fin d'un clip.
*/
var bool_video_logo = false;
jQuery("#player_video").bind(jQuery.jPlayer.event.ended, function (event)
{
	var current = myPlaylist.current;// récupère l'id de la video courante dans la playlist du player pas de la bdd
	var playlist = myPlaylist.playlist; // récupère la playlist du player sous forme de tableau
  var titre_current_track=myPlaylist.playlist[myPlaylist.current].title; // récupère le titre du clip qui est entrain d'être joué
  var genre_logo;
  var artiste_album_annee_ajout = new String(); // obligatoire pour former un string
  var titre;
  var url;
  var genre;
  var titre_previous_current_track=myPlaylist.playlist[myPlaylist.current-1].title;// le -1 permet de récupérer la vidéo précédente.
	//On efface le morceau de la base de donnée également

  // utile lorsque le player a fini de lire le logo cette condition permet de supprimé le logo de la playlist et de retourner au debut de la playlist
  if (bool_video_logo == true){
    myPlaylist.remove(current);// supprime la video courante
    myPlaylist.select(0);// sélectionne le la première video
    myPlaylist.play(0);// lit la première video
    bool_video_logo = false;
  }
  // agit que sur la bdd en ajoutant ou en
  else{
    myPlaylist.remove(current-1);// enlève la video précédente lorsque le payer lit la prochaine video execpté une video logo.
    $.post(
		ajaxurl,
		{
			'action': 'effacer_et_ajouter_video_dans_table_playlist_par_defaut_webtv_plugin',
			'videocouranteprevious': titre_previous_current_track
		},
		function(response){
    }
	 );
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
    $.post(
       ajaxurl,
       {
         'action' : 'recup_freq_logo',
       },
       function(response) {
         freq_logo = response;
         $.post(
            ajaxurl,
            {
              'action' : 'recup_id_video_courante',
              'videocourante': titre_current_track
            },
            function(response2) {
                id_video_courante = response2;
                // condition de passage au logo ou pas
                if (id_video_courante % freq_logo == 0  && freq_logo != 0 && bool_video_logo== false && id_video_courante!=0 ){
                  bool_video_logo = true;
                  $.ajax({
                     url: ajaxurl,
                     data:{
                       'action' : 'insertion_logo',
                     },
                     dataType: 'JSON',
                     success: function(data) {
                       $.each(data.data, function(index, value) {
                        // si une video avec le genre logo  le true force à la lire
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
                    url: ajaxurl,
                    data:{
                      'action' : 'recuperer_nouvelle_video_player_page_principal',
                    },
                    dataType: 'JSON',
                    success: function(data) {
                      $.each(data.data, function(index, value) {
                        // la taille est fixé à la limite du nombre de clips dans la playlist ain d'éviter l'erreur de répétition de clip après la suppression du logo.
                         if (taille<13){
                          artiste_album_annee_ajout =  value.artiste + " - " + value.album  + " - " +value.annee;
                          //Permet de générer la nouvelle video dans le player.
                          myPlaylist.add({
                    				title:value.titre,
                    				m4v:value.url,
                    				artist: artiste_album_annee_ajout
                    			});
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


/*
* Fonction : Permet d'afficher la durée du clip en cours de lecture
*/
jQuery("#player_video").bind(jQuery.jPlayer.event.play, function (event)
{

	var current     = myPlaylist.current;
	playlist        = myPlaylist.playlist;
  var taile_playlist  = myPlaylist.playlist.length;
  var titre_current_track=myPlaylist.playlist[myPlaylist.current].title;
	var nom_clip_courant = playlist[current].title,
	artiste_clip_courant = playlist[current].artist,
	url_clip_courant = playlist[current].m4v;

	$.post(
		ajaxurl,
		{
			'action': 'recuperer_duree_clip',
			'nom_clip': nom_clip_courant,
			'url_clip': url_clip_courant
		},
		function(response){
			//console.log("Vidéo : " + artiste_clip_courant + " - " + nom_clip_courant + "\nDurée : " + response);
		}
	);

});



/*-------------------------------------- FIN Règles internes ---------------------------------------------*/
/* REGLAGES DU LIVE */
  /*var on_live=false;
  $("#player_video").bind(jQuery.jPlayer.event.ended , function (event){
    //console.log(on_live);
    if(on_live==true ){
      myPlaylist.remove();
      myPlaylist.setPlaylist([{
        title:"LIVE",
        artist:"LE FIL",
        m4v:"http://localhost/wordpress/wp-content/plugins/admin_webtv_plugin/mp4/liveTest.mp4"
      }]);
      myPlaylist.option("autoPlay",true);
      myPlaylist.play();
    }
  });


  $('#live_btn').click(function(){
    if(on_live==false){
      on_live=true;
      $(this).html("Arreter le LIVE");
      //$('#player_video').prop('title', 'live_on');
      $.post(ajaxurl,{
        'action' : 'etat_live',
        'data' : on_live
      },function(response){
        //console.log(response);
      })
    }
    else if(on_live=true){
      on_live=false;
      myPlaylist.pause();
      myPlaylist.remove();
      generer_la_playlist();
      $(this).html("Lancer le LIVE");
      //$('#player_video').prop('title', 'live_off');
      $.post(ajaxurl,{
        'action' : 'etat_live',
        'data' : on_live
      },function(response){
       // console.log(response);
      })
    }
  });*/

});
