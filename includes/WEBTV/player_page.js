/* Fonction de ce fichier :
*Il permet de gérer les interactions avec le player coté product owner.
*Tous les contrôles du player de jplayer et l'implémentation des clips dans la  playlist du Player se font ici.
* Tous les affichages et l'aspect visuel se font dans le fichier index.php dans le dossier page_principal
* Les fonctions dans la rubrique action des fonction ajax sont dans les fichiers  includes/GenerationPlaylist_par_defaut.php et
* includes/nouveaux_reglages/traitement_donnees_playlist_par_defaut.php
*/

$(document).ready(function(){
  var index_bdd_precedent;
  var nom_playlist_clip;
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
  console.log("PAGE CHARGEE");

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
var on_joue_la_playlist_par_defaut;
var playlist_prete_a_etre_chargee;

function generer_la_playlist(){
	var artiste_album_annee_gener = new String();
	// On vide d'abord la playlist si elle existe
	myPlaylist.remove();

	// On regarde si il faut charger la playlist par défaut où la playlist clip
	$.when(
		$.post(
			myAjax.ajaxurl,
			{
			  'action': 'chargement_page_quelle_playlist_charger',
			  'demande': 'bool'
			},
			function(response){
				playlist_a_lire = response;
		})
	).then(function(){
		console.log("il existe une playlist = "+playlist_a_lire);
		if(playlist_a_lire == false)
		{
			charger_playlist_par_defaut();
		}
		else
		{
			verifier_et_génerer_playlist_clip();
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
var current;
var playlist;
var titre_current_track;


jQuery("#player_video").bind(jQuery.jPlayer.event.ended, function (event)
{
	myPlaylist.pause();

	current = myPlaylist.current;
	playlist = myPlaylist.playlist;
	titre_current_track=myPlaylist.playlist[myPlaylist.current].title;

	// On détermine si il faut lire dans la playlist par défaut ou playlist clip, et si il faut
	// la regénérer ou juste continuer la lecture

	console.log("on_joue_la_playlist_par_defaut = "+on_joue_la_playlist_par_defaut);

	//														 		--true-> 	generer+lancer cette playlist
	//			--true-> 	existe une PC autour de cette heure?	--false-> 	continuer PPD
	// prec=PPD?
	//			--false-> 	heure de fin de cette PC > cette heure?	--true->	continuer PC
	//																--false->	existe une autre PC autour de cette heure? 	--true->	generer+lancer cette playlist
	//																														--false-> 	lancer PPD


	if(on_joue_la_playlist_par_defaut)	// si précédente musique est une lecture de playlist par défaut
	{
		$.when(
			$.post(
				myAjax.ajaxurl,
				{
				  'action': 'chargement_page_quelle_playlist_charger',
				  'demande': 'bool'
				},
				function(response){
					playlist_a_lire = response;
				}
			)
		).then(function(){
			if(playlist_a_lire==true)
			{	// Si il existe une playlist clip à cet horaire, on lance la requête SQL de
				// génération dans la BDD, puis on recharge la playlist dans le player

				console.log("Il y a une playlist_a_lire");
				verifier_et_génerer_playlist_clip();
			} else
			{
				console.log("Aucune playlist_a_lire");
				myPlaylist.play();
				on_joue_la_playlist_par_defaut = true;
				continuer_playlist_par_defaut();
			}
		});
	}
	else		// si précédente musique est une lecture de playlist clip
	{
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$.post(			// On vérifie si la bonne playlist clip est chargée à partir des dates de début et de fin
			myAjax.ajaxurl,
			{
			  'action': 'verifier_playlist_clip_charger_dans_la_table'
			},
			function(response){
				console.log("playlist terminée? "+response);
				if(response!=false)	// Si les dates coïncident (heure de fin pas encore arrivée et bonne playlist_clip chargée)
				{
					myPlaylist.play();
					continuer_playlist_clip();
				}
				else
				{
					$.post(			// On vérifie si il existe une autre playlist clip à charger à cette heure
						myAjax.ajaxurl,
						{
						  'action': 'chargement_page_quelle_playlist_charger',
						  'demande':'bool'
						},
						function(response2){
							console.log("Une autre playlist a cette heure? "+response2);
							if(response2==false)	// Si aucune autre playlist à cette heure
							{
								charger_playlist_par_defaut();
								myPlaylist.play();
							}else
							{
								verifier_et_génerer_playlist_clip();
							}
						}
					);
				}
			}
		);
	}


});


/*
* Fonction de chargement des musiques de playlist_par_defaut dans le player
*/
function charger_playlist_par_defaut()
{
	// On vide d'abord la playlist si elle existe
	myPlaylist.remove();
	// Si playlist par défaut
	$.ajax({
		url: myAjax.ajaxurl,
		data:{
		  'action':'recuperer_videos_player_page_principale_par_defaut',
		},
		dataType: 'JSON',
		success: function(data) {
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
				myPlaylist.play();// permet de s'affranchir du bouton play lors du chargmenent de la page.
			});
			on_joue_la_playlist_par_defaut = true; // première occurence au chargement de la page
		},
		error: function (xhr, ajaxOptions, thrownError) {
		  console.log(xhr.status);
		  console.log(thrownError);
		}
	});
}

/*
* Fonction de chargement des musiques de playlistclip dans le player
*/
function verifier_et_génerer_playlist_clip()
{
	var nom_playlist_a_lire;
	$.when(
		$.post(			// On récupère le nom de la playlist
			myAjax.ajaxurl,
			{
			  'action': 'chargement_page_quelle_playlist_charger',
			  'demande': 'nom'
			},
			function(response){
				nom_playlist_a_lire = response;
				console.log("a lire : "+nom_playlist_a_lire);
			}
		)
	).then(function(){
		$.post(			// On vérifie si la bonne playlist clip est chargée à partir des dates de début et de fin
			myAjax.ajaxurl,
			{
			  'action': 'verifier_playlist_clip_charger_dans_la_table'
			},
			function(response){
				console.log(response);
				if(response==false)	// Si les dates ne coïncident pas avec la date actuelle
				{
					$.post(			// On la génère dans la bdd
						myAjax.ajaxurl,
						{
						  'action': 'generer_la_playlist_clips',
						  'nom_playlist': nom_playlist_a_lire
						},
						function(is_success){
							console.log(is_success);
						}
					);
				}
				nom_playlist_clip=nom_playlist_a_lire;
			}
		);
		// Attend 1s avant de charger la nouvelle playlist dans le player
		setTimeout(function(){

			myPlaylist.remove();
			// Chargement clips dans la playlist par défaut
			$.ajax({
				url: myAjax.ajaxurl,
				data:{
				  'action':'recuperer_videos_playlist_clip_player_page_principale',
				},
				dataType: 'JSON',
				success: function(data) {
					$.each(data.data, function(index, value) {
						//On va récupérer le nom de l'artiste pour chaque titre
						artiste_album_annee_gener =  value.artiste + " - " + value.album  + " - " +value.annee;
						var title=value.titre;
						var url = value.url;
						myPlaylist.add({
							title:value.titre,
							m4v:value.url,
							artist:artiste_album_annee_gener
						});
					});
					myPlaylist.play();// permet de s'affranchir du bouton play lors du chargmenent de la page.
					console.log("chargement clips");
					on_joue_la_playlist_par_defaut = false; // première occurence au chargement de la page
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(xhr.status);
					console.log(thrownError);
				}
			});
		}, 1000);
	});

}


function continuer_playlist_par_defaut()
{

	current = myPlaylist.current;// récupère l'id de la video courante dans la playlist du player pas de la bdd
	playlist = myPlaylist.playlist; // récupère la playlist du player sous forme de tableau
	titre_current_track=myPlaylist.playlist[myPlaylist.current].title; // récupère le titre du clip qui est entrain d'être joué

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
			myAjax.ajaxurl,
			{
				'action' : 'recup_freq_logo',
			},
			function(response) {
				freq_logo = response;
				$.post(
					myAjax.ajaxurl,
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
								url: myAjax.ajaxurl,
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
								url: myAjax.ajaxurl,
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

}




function continuer_playlist_clip()
{
	current = myPlaylist.current;// récupère l'id de la video courante dans la playlist du player pas de la bdd
	playlist = myPlaylist.playlist; // récupère la playlist du player sous forme de tableau
	titre_current_track=myPlaylist.playlist[myPlaylist.current].title; // récupère le titre du clip qui est entrain d'être joué

	var artiste_album_annee_ajout = new String(); // obligatoire pour former un string
	var titre;
	var url;
	var genre;
	var titre_previous_current_track=myPlaylist.playlist[myPlaylist.current-1].title;// le -1 permet de récupérer la vidéo précédente.
	//On efface le morceau de la base de donnée également

  // utile lorsque le player a fini de lire le logo cette condition permet de supprimé le logo de la playlist et de retourner au debut de la playlist
	if (bool_video_logo == true){
		myPlaylist.remove(current);// supprime la video courante
		myPlaylist.select(0);// sélectionne la première video
		myPlaylist.play(0);// lit la première video
		bool_video_logo = false;
	}
	// agit que sur la bdd en ajoutant ou en
	else{
		myPlaylist.remove(current-1);// enlève la video précédente lorsque le payer lit la prochaine video execpté une video logo.
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
			myAjax.ajaxurl,
			{
				'action' : 'recup_freq_logo_playlist_clip',
				'nom_playlist': nom_playlist_clip
			},
			function(response) {
				freq_logo = response;
				$.post(
					myAjax.ajaxurl,
					{
					  'action' : 'recup_id_video_courante_playlist_clip',
					  'videocourante': titre_current_track
					},
					function(response2) {
						id_video_courante = response2;
						// condition de passage au logo ou pas
						if (id_video_courante % freq_logo == 0  && freq_logo != 0 && bool_video_logo== false && id_video_courante!=0 ){
							bool_video_logo = true;
							$.ajax({
								url: myAjax.ajaxurl,
								data:{
									'action' : 'insertion_logo' // Fonction dans traitement_donnees_playlist_par_defaut
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
								url: myAjax.ajaxurl,
								data:{
									'action' : 'recuperer_nouvelle_video_playlist_clip_player_page_principal',
								},
								dataType: 'JSON',
								success: function(data) {
									$.each(data.data, function(index, value) {
									// la taille est fixée à la limite du nombre de clips dans la playlist ain d'éviter l'erreur de répétition de clip après la suppression du logo.
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
}

  /*
  * Fonction : Permet de gérer si le lien de la video mp4 à disparu de la playlist.
  */

	jQuery("#player_video").bind(jQuery.jPlayer.event.play, function (event)
	{

		var current     = myPlaylist.current;
		playlist        = myPlaylist.playlist;
		var titre_previous_current_track=myPlaylist.playlist[myPlaylist.current].title;
		var url_clip_suivant = playlist[current+1].m4v;
		var url_clip_courant = playlist[current].m4v;

		$.post(
			myAjax.ajaxurl,
			{
				'action': 'url_vid_exist',
				'url_clip_suivant': url_clip_suivant,
				'url_clip_courant' :url_clip_courant
			},
			function(response){
				//console.log("reponse: " + response);
				var reponse = response;
				console.log("reponse " +reponse);
				switch (reponse) {
					case 'b':
						console.log("entrée dans b : ");
						myPlaylist.remove(current+1);
						break;
					case 'c':
						console.log("entrée dans c : ");
						myPlaylist.remove(current);
						myPlaylist.next();
						break;
					default:
						console.log("aucun pb rencontrés");
				}
			}
		);
	});




});
