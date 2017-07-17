<?php


/**************************************************************************************************************************
**
**
**                                 Fonctions php utilisées pour générer une playlist
**
**
*******************************************************************************************************************************/





add_action( 'pluginwebtv_generer_playlist_par_defaut', 'generer_playlist_par_defaut',10,11);
add_action( 'pluginwebtv_recup_videos_playlist_par_defaut', 'recup_videos_playlist_par_defaut',15,5);
add_action('wp_ajax_effacer_et_ajouter_video_dans_table_playlist_par_defaut_webtv_plugin','effacer_et_ajouter_video_dans_table_playlist_par_defaut_webtv_plugin' );
add_action('pluginwebtv_nouvelle_video_comparaison','nouvelle_video_comparaison',1,5 );



//Variables globales qu'on va remplir avec les morceaux de la playlist
$tab_url=array();
$tab_titres=array();
//$tab_artistes=array();
//$tab_artistes_id=array();


//Génère une playlist de 8 morceaux selon les pourcentages choisit par l'utilisateur
function generer_playlist_par_defaut($pourcentagepoprock,$pourcentagehiphop,$pourcentagejazzblues,$pourcentagemusiquemonde,$pourcentagehardrock,$pourcentageelectro,$pourcentagechanson,$pourcentageautres,$annee_max,$annee_min,$qualite_min){
    global $tab_url;
    global $tab_titres;
    global $tab_artistes;
    global $tab_genres;
    global $tab_annees;
    $poprock = $pourcentagepoprock;
    $hiphop = $pourcentagehiphop;
    $jazzblues = $pourcentagejazzblues;
    $musiquemonde = $pourcentagemusiquemonde;
    $hardrock = $pourcentagehardrock;
    $electro = $pourcentageelectro;
    $chanson = $pourcentagechanson;
    $autres = $pourcentageautres;
    $annee_min = $annee_min;
    $annee_max = $annee_max;
    $qualite_min = $qualite_min;

    // Variables utiles
    $compteur=0;
    $genre_id;

    $tableaupourcentages=array();

    $tableaupourcentages[0] = $pourcentagepoprock;
    $tableaupourcentages[1] =  $pourcentagehiphop;
    $tableaupourcentages[2] =  $pourcentagejazzblues;
    $tableaupourcentages[3] = $pourcentagemusiquemonde;
    $tableaupourcentages[4] = $pourcentagehardrock;
    $tableaupourcentages[5] = $pourcentageelectro;
    $tableaupourcentages[6] = $pourcentagechanson;
    $tableaupourcentages[7] = $pourcentageautres;

	while (sizeof($tab_titres)<15){
	    for ($i=0; $i <sizeof($tableaupourcentages) ; $i++) {

	          $valeur_camembert=$tableaupourcentages[$i];

	          if ($i==0)
	          {
	              $genre_id=5; //correspond au Pop-rock
	          }
	          if ($i==1)
	          {
	              $genre_id=3; //correspond au Hip-hop & Reggae
	          }
	          if ($i==2)
	          {
	              $genre_id=7; //correspond au Jazz & Blues
	          }
	          if ($i==3)
	          {
	              $genre_id=9; //correspond au Musique du monde
	          }
	          if ($i==4)
	          {
	              $genre_id=2; //correspond au Hard-rock & metal
	          }
	          if ($i==5)
	          {
	              $genre_id=4; //correspond au Musique électronique
	          }
	          if ($i==6)
	          {
	              $genre_id=8; //correspond à Chanson Française
	          }
	          if ($i==7)
	          {
	              $genre_id=12; //correspond à Autre
	          }

	          if ( $valeur_camembert > 0){

	            if($valeur_camembert<20){

	              do_action('pluginwebtv_recup_videos_playlist_par_defaut',$genre_id,1,$annee_max,$annee_min,$qualite_min);

	            }else{
	                if($valeur_camembert<30){

	                   do_action('pluginwebtv_recup_videos_playlist_par_defaut',$genre_id,2,$annee_max,$annee_min,$qualite_min);
	                }else{
	                    if($valeur_camembert<40){
	                       do_action('pluginwebtv_recup_videos_playlist_par_defaut',$genre_id,3,$annee_max,$annee_min,$qualite_min);
	                    }else{
	                        if($valeur_camembert<50){
	                           do_action('pluginwebtv_recup_videos_playlist_par_defaut',$genre_id,4,$annee_max,$annee_min,$qualite_min);

	                        }else{
	                            if($valeur_camembert<60){
	                               do_action('pluginwebtv_recup_videos_playlist_par_defaut',$genre_id,5,$annee_max,$annee_min,$qualite_min);

	                            }else{
	                                if($valeur_camembert<70){
	                                  do_action('pluginwebtv_recup_videos_playlist_par_defaut',$genre_id,6,$annee_max,$annee_min,$qualite_min);

	                                }else{
	                                    if($valeur_camembert<80){
	                                      do_action('pluginwebtv_recup_videos_playlist_par_defaut',$genre_id,7,$annee_max,$annee_min,$qualite_min);

	                                    }else{
	                                        if($valeur_camembert<90){
	                                            do_action('pluginwebtv_recup_videos_playlist_par_defaut',$genre_id,8,$annee_max,$annee_min,$qualite_min);

	                                        }else{
	                                            if($valeur_camembert<100){
	                                                do_action('pluginwebtv_recup_videos_playlist_par_defaut',$genre_id,9,$annee_max,$annee_min,$qualite_min);
	                                            }
	                                            if($valeur_camembert==100){

	                                               do_action('pluginwebtv_recup_videos_playlist_par_defaut',$genre_id,12,$annee_max,$annee_min,$qualite_min);

	                                            }
	                                        }
	                                    }
	                                }
	                            }
	                        }
	                    }
	                }
	            }// -----\ Fin du else /----
	        }
	    }//----\ Fin du for($i=0;$i<sizeof($tableaupourcentages);$i++) /--------
	}
}

/*
*  Fonction : Récupere un nombre $limt de vidéos du genre $genre en ajoutant l'url et le titre au tableau tab_url et tab_titres
*  Deplus la fonction trie les artistes et les genres en fonction des titres et des url des clips à fin de remplir correctement
*  les tableaux, $tab_artistes_id, $tab_url, $tab_artistes, $tab_titres, $tab_genres. Ces tableaux servent particulièrement au remplissage de la fonctions
*  generer_la_playlist dans le fichier traitement_donnees.php qui rempli la table playlist_par_defaut_webtv_plugin.
*/

function recup_videos_playlist_par_defaut($genre,$limit,$annee_max,$annee_min,$qualite_min){
    global $tab_artistes_id;
    global $wpdb;
    global $tab_url;
    global $tab_artistes;
    global $tab_titres;
    global $tab_genres;
    global $tab_annees;
    global $tab_album;


    $sql_query1="SELECT video_id,artiste_id,genre_id,album_id,annee_id FROM " . $wpdb->prefix . "relation_webtv_plugin WHERE genre_id='$genre'
		AND annee_id IN (SELECT id FROM `wp_annee_webtv_plugin` WHERE annee >= '$annee_min' AND annee <= '$annee_max' )
		AND qualite_id >= $qualite_min ORDER BY RAND()  LIMIT $limit;";

    $tabvideos=$wpdb->get_results($sql_query1);
    foreach($tabvideos as $id){

        $id_video = $id->video_id;
        $id_art1 = $id->artiste_id;
        $id_genres = $id->genre_id;
        $id_annees = $id->annee_id;
        $id_album  = $id->album_id;

        $query_album = "SELECT album FROM " . $wpdb->prefix . "album_webtv_plugin WHERE id='$id_album' LIMIT 1;";
        $tab_donnees_album = $wpdb->get_results($query_album);

        foreach($tab_donnees_album as $results)
        {
            $tab_album[] = $results->album;

        }

        $query_annee = "SELECT annee FROM " . $wpdb->prefix . "annee_webtv_plugin WHERE id='$id_annees' LIMIT 1;";
        $tab_donnees_annee = $wpdb->get_results($query_annee);
        foreach($tab_donnees_annee as $results)
        {
            $tab_annees[] = $results->annee;
        }

        $query_genre = "SELECT Genre FROM " . $wpdb->prefix . "genre_webtv_plugin WHERE id='$id_genres' LIMIT 1;";
        $tab_donnees_genre = $wpdb->get_results($query_genre);
        foreach($tab_donnees_genre as $results)
        {
            $tab_genres[] = $results->Genre;
        }

        $query_artistes = "SELECT nom FROM " . $wpdb->prefix . "artiste_webtv_plugin WHERE id='$id_art1' LIMIT 1;";
        $tab_donnees_artistes = $wpdb->get_results($query_artistes);

        foreach($tab_donnees_artistes as $results){

            $tab_artistes[] = $results->nom;

        }

        $query_url_titre = "SELECT url,titre FROM " . $wpdb->prefix . "videos_webtv_plugin WHERE id='$id_video' LIMIT 1;";
        $tab_donnees_url_titre = $wpdb->get_results($query_url_titre);

        foreach($tab_donnees_url_titre as $s){

            $tab_url[]=$s->url;

            $tab_titres[]=$s->titre;

        }
    }
}


/*
Nom : ajouter_video_dans_table_playlist_par_defaut_webtv_plugin()
Fonction : Cette fonction permet de rajouter un clip video dans la table wp_playlist_par_defaut_webtv_plugin de la base de données.
Ceci permet de faire une boucle des vidéos pour la playlist par défaut.
ATTENTION Exemple :WHERE titre='$video_courante' bien mettre des cotes  et non des guillemets sinon impossible d'obtenir la page!!
*/

function effacer_et_ajouter_video_dans_table_playlist_par_defaut_webtv_plugin(){
    global $wpdb;
    global $titre_nouvelle_video;
    $reponse_titre_video_a_ajouter = $video_courante; // nécessaire pour entrer dans la boucle while ci dessous.
    $video_courante= $_POST['videocouranteprevious'];// récupérer dans le JSON dans la fonction post AJAX dans le fichier player_homepage.js

    // Récup la fréquence logo de la playlist par defaut
    $query_freq_logo_dans_playlist_enregistrees_choix_playlist_par_defaut = "SELECT Freq_logo FROM " . $wpdb->prefix . "playlistenregistrees_webtv_plugin WHERE ParDefaut=1;";
    $reponse_freq_logo_dans_playlist_enregistrees_choix_playlist_par_defaut = $wpdb->get_var($query_freq_logo_dans_playlist_enregistrees_choix_playlist_par_defaut);

              //------- Séléction de id_genre de la video courante------//

    // recupération de l'id de la video courante dans la table playlist par defaut car les id sont différents.
    $query_id_videocouranteprevious_dans_playlist_par_defaut = "SELECT id FROM " . $wpdb->prefix . "playlist_par_defaut_webtv_plugin WHERE titre='$video_courante';";
    $reponse_id_videocouranteprevious_dans_playlist_par_defaut = $wpdb->get_var($query_id_videocouranteprevious_dans_playlist_par_defaut);

    $query_tri_asc = "ALTER TABLE " . $wpdb->prefix . "playlist_par_defaut_webtv_plugin ORDER BY id ASC;";
    $wpdb->query($query_tri_asc);

    $query_genre_videocouranteprevious_dans_playlist_par_defaut = "SELECT genre FROM " . $wpdb->prefix . "playlist_par_defaut_webtv_plugin WHERE titre='$video_courante';";
    $reponse_genre_videocouranteprevious_dans_playlist_par_defaut = $wpdb->get_var($query_genre_videocouranteprevious_dans_playlist_par_defaut);
    // Ajoute une pub si on arrive à la video de la playlist qui son id identique à la fréquence des logos.
    if ($reponse_id_videocouranteprevious_dans_playlist_par_defaut % $reponse_freq_logo_dans_playlist_enregistrees_choix_playlist_par_defaut == 0 && $reponse_freq_logo_dans_playlist_enregistrees_choix_playlist_par_defaut > 0 && $reponse_genre_videocouranteprevious_dans_playlist_par_defaut != 'Logo') {

        do_action('pluginwebtv_freq_logo',$reponse_freq_logo_dans_playlist_enregistrees_choix_playlist_par_defaut);
        do_action('pluginwebtv_insertion_logo_dans_playlist_par_defaut',$reponse_freq_logo_dans_playlist_enregistrees_choix_playlist_par_defaut, $reponse_id_videocouranteprevious_dans_playlist_par_defaut, $video_courante);
    }
    // s'l faut ajouter un nouveau clip dans la playslist par defaut.
    else {
    //récupération de l'id de la video courante dans la table video_web_tv.
    $query_id_video_courante = "SELECT id FROM ". $wpdb->prefix . "videos_webtv_plugin WHERE titre='$video_courante' LIMIT 1;";
    $reponse_id_video_courante = $wpdb -> get_var($query_id_video_courante);

    $query_annee_max = "SELECT annee_max FROM ". $wpdb->prefix . "playlistenregistrees_webtv_plugin WHERE ParDefaut=1 LIMIT 1;";
    $reponse_annee_max = $wpdb->get_var($query_annee_max);

    $query_annee_min = "SELECT annee_min FROM ". $wpdb->prefix . "playlistenregistrees_webtv_plugin WHERE ParDefaut=1 LIMIT 1;";
    $reponse_annee_min = $wpdb->get_var($query_annee_min);

    $query_qualite_min = "SELECT qualite_min FROM ". $wpdb->prefix . "playlistenregistrees_webtv_plugin WHERE ParDefaut=1 LIMIT 1;";
    $reponse_qualite_min = $wpdb->get_var($query_qualite_min);


    //Récupération de l'id du genre de la vidéo courante
    $query_id_genre_video_courante = "SELECT genre_id FROM ". $wpdb->prefix . "relation_webtv_plugin WHERE video_id='$reponse_id_video_courante' LIMIT 1;";
    $reponse_id_genre_video_courante = $wpdb -> get_var($query_id_genre_video_courante);

            //-------Video à ajouter ------//
    nouvelle_video_comparaison($reponse_id_genre_video_courante, $video_courante, $reponse_annee_min, $reponse_annee_max, $reponse_qualite_min );



    //Récupère information url et id de la nouvelle video
     $query_id_video_a_ajouter_meme_genre = "SELECT id,url FROM ". $wpdb->prefix . "videos_webtv_plugin WHERE titre='$titre_nouvelle_video' LIMIT 1;"; // order by rand permet de lister aléatoirement les clips musiquaux
     $reponse_id_video_a_ajouter_meme_genre = $wpdb -> get_var($query_id_video_a_ajouter_meme_genre, 0);
     $reponse_url_video_a_ajouter_meme_genre = $wpdb -> get_var($query_id_video_a_ajouter_meme_genre, 1);


     //Récupération des informations liées à la nouvelle video avec le même genre que la vidéo courante.
      $query_ids_video_a_ajouter_meme_genre = "SELECT artiste_id,genre_id, album_id, annee_id FROM ". $wpdb->prefix . "relation_webtv_plugin WHERE video_id='$reponse_id_video_a_ajouter_meme_genre'   LIMIT 1;"; // order by rand permet de lister aléatoirement les clips musiquaux
      $reponse_ids_video_a_ajouter_meme_genre = $wpdb -> get_results($query_ids_video_a_ajouter_meme_genre);

      foreach ( $reponse_ids_video_a_ajouter_meme_genre  as $result){
        $id_genre_video_a_ajouter_meme_genre = $result->genre_id;
        $id_artiste_video_a_ajouter_meme_genre = $result->artiste_id;
        $id_album_video_a_ajouter_meme_genre = $result->album_id;
        $id_annee_video_a_ajouter_meme_genre = $result->annee_id;


        $query_genre_video_a_ajouter_meme_genre = "SELECT Genre FROM ". $wpdb->prefix . "genre_webtv_plugin WHERE id='$id_genre_video_a_ajouter_meme_genre' LIMIT 1;"; // order by rand permet de lister aléatoirement les clips musiquaux
        $reponse_genre_video_a_ajouter_meme_genre = $wpdb -> get_var($query_genre_video_a_ajouter_meme_genre);

        $query_artiste_video_a_ajouter_meme_genre = "SELECT nom FROM ". $wpdb->prefix . "artiste_webtv_plugin WHERE id='$id_artiste_video_a_ajouter_meme_genre' LIMIT 1;"; // order by rand permet de lister aléatoirement les clips musiquaux
        $reponse_artiste_video_a_ajouter_meme_genre = $wpdb -> get_var($query_artiste_video_a_ajouter_meme_genre);

        $query_annee_video_a_ajouter_meme_genre = "SELECT annee FROM ". $wpdb->prefix . "annee_webtv_plugin WHERE id='$id_annee_video_a_ajouter_meme_genre' LIMIT 1;"; // order by rand permet de lister aléatoirement les clips musiquaux
        $reponse_annee_video_a_ajouter_meme_genre = $wpdb -> get_var($query_annee_video_a_ajouter_meme_genre);

        $query_album_video_a_ajouter_meme_genre = "SELECT album FROM ". $wpdb->prefix . "album_webtv_plugin WHERE id='$id_album_video_a_ajouter_meme_genre' LIMIT 1;"; // order by rand permet de lister aléatoirement les clips musiquaux
        $reponse_album_video_a_ajouter_meme_genre = $wpdb -> get_var($query_album_video_a_ajouter_meme_genre);
      }

      //Mise à jour de la table playlist_par_defaut_webtv_plugin avec un clips video du même genre que la video courante supprimé
      $query_titre_url_genres_artistes_annee_album_video_a_ajouter_meme_genre_dans_table_playlist_par_defaut_webtv_plugin = "INSERT INTO " . $wpdb->prefix . "playlist_par_defaut_webtv_plugin(titre,url,artiste,genre, annee, album) VALUES('$titre_nouvelle_video','$reponse_url_video_a_ajouter_meme_genre','$reponse_artiste_video_a_ajouter_meme_genre','$reponse_genre_video_a_ajouter_meme_genre','$reponse_annee_video_a_ajouter_meme_genre','$reponse_album_video_a_ajouter_meme_genre')";
      $wpdb -> query($query_titre_url_genres_artistes_annee_album_video_a_ajouter_meme_genre_dans_table_playlist_par_defaut_webtv_plugin);

      //Permet de trier la table par odre croissant !! Utile pour démarer toujours au clip en cours. SELECT n'actualise pas la BDD comme on pourrait le croire si on effectue
      // la requête dans phpmyadmin.
      $query_tri_asc = "ALTER TABLE " . $wpdb->prefix . "playlist_par_defaut_webtv_plugin ORDER BY id ASC;";
      $wpdb->query($query_tri_asc);

      //Très utile afin d'éviter la sélection d'un doublon entre la video courante et les videos avec un titre similaire
      $query_select_min_id_de_video_courante = "SELECT MIN(id) FROM " . $wpdb->prefix . "playlist_par_defaut_webtv_plugin WHERE titre='$video_courante' ";
      $reponse_select_min_id_de_video_courante = $wpdb->get_var($query_select_min_id_de_video_courante);


      //Requete qui supprime la video courante en fonction de son id de la playlist par defaut.
      $query_del_titre_video_courante="DELETE FROM " . $wpdb->prefix . "playlist_par_defaut_webtv_plugin WHERE id='$reponse_select_min_id_de_video_courante' ";
      $wpdb->query($query_del_titre_video_courante);

    }
}

/*
* Fonction : Permet de comparer les différents titres de vidéo du même genre
* Utilité dans la fonction effacer_et_ajouter_video_dans_table_playlist_par_defaut_webtv_plugin
*/
function nouvelle_video_comparaison($genre_videocouranteprevious, $titre_video_courante, $reponse_annee_min, $reponse_annee_max, $reponse_qualite_min){
    global $wpdb;
    global $titre_nouvelle_video;

    // --- Fabrication d'un tableau avec les titres des videos ayant le même genre que la vidéo courante --//
    $query_id_video_meme_genre_tranche_annee_meme_qualite_video_courante = "SELECT video_id FROM " . $wpdb->prefix . "relation_webtv_plugin WHERE genre_id='$genre_videocouranteprevious' AND annee_id IN (SELECT id FROM `wp_annee_webtv_plugin` WHERE annee >= '$reponse_annee_min' AND annee <= '$reponse_annee_max' )
		AND qualite_id >= $reponse_qualite_min ORDER BY RAND();";
    $reponse_id_video_meme_genre_tranche_annee_meme_qualite_video_courante = $wpdb->get_results(  $query_id_video_meme_genre_tranche_annee_meme_qualite_video_courante);

    foreach ($reponse_id_video_meme_genre_tranche_annee_meme_qualite_video_courante as $results) {
      $id_video_meme_genre_video_courante = $results->video_id;
      $query_titre_video_meme_genre_video_courante = "SELECT titre FROM " . $wpdb->prefix . "videos_webtv_plugin WHERE id='$id_video_meme_genre_video_courante'ORDER BY RAND();";
      $reponse_titre_video_meme_genre_video_courante = $wpdb->get_results($query_titre_video_meme_genre_video_courante);

      foreach ($reponse_titre_video_meme_genre_video_courante as $results) {
        $tab_titre_video_meme_genre_video_courante[] = $results->titre;

      }
    }

      //-------Tableau des titres de la playlist par defaut chargé ------

    //fabrication du tableau des 15 clips vidéos de la playlist par défaut
    $query_titre_video_playlist_par_defaut="SELECT titre FROM " . $wpdb->prefix . "playlist_par_defaut_webtv_plugin LIMIT  15;";
    $reponse_titre_video_playlist_par_defaut = $wpdb -> get_results($query_titre_video_playlist_par_defaut);//requête
    foreach ($reponse_titre_video_playlist_par_defaut as $results){
      $tab_titres_playlist_par_default[] = $results->titre;
    }
    // comparaison
    foreach ($tab_titre_video_meme_genre_video_courante as $key_tab_titre_video_meme_genre_video_courante) {
      foreach ($tab_titres_playlist_par_default as $key_titre_pl_par_def) {

        if( $key_tab_titre_video_meme_genre_video_courante != $key_titre_pl_par_def && $key_tab_titre_video_meme_genre_video_courante != $titre_video_courante)
          //Mise à jour de la table playlist_par_defaut_webtv_plugin avec un clips video du même genre que la video courante supprimé
          $titre_nouvelle_video = $key_tab_titre_video_meme_genre_video_courante;
          break;
        }
    }
    //Si il n'y a aucune correspondance on renouvelle la musique.
    if ($titre_nouvelle_video == NULL){
      $titre_nouvelle_video = $titre_video_courante;
    }

    unset($tab_titre_video_meme_genre_video_courante);// supprime le tableau des videos ayant le meme genre afin de le réinitialiser à chaque fois.
    unset($tab_titres_playlist_par_default);// supprime le tableau des 15 clips de la playlist par defaut afin de le réinitialiser à chaque fois.

}




?>
