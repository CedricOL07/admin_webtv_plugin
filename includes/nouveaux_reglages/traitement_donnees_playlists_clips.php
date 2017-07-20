<?php
/*
*Fonction : Ce fichier permet de traiter les données liées au playlist de clips générer par l'interface nouvelle playlist.
*
*
*/

/*Les add_action permettant de déclarer les fonctions php dans dans tout le dossier Wordpress*/
add_action('wp_ajax_enregistrement_playlist_clips_pourcentage', 'enregistrement_playlist_clips_pourcentage' );
add_action('wp_ajax_generer_la_playlist_clips','generer_la_playlist_clips');
add_action('wp_ajax_nopriv_generer_la_playlist_clips','generer_la_playlist_clips');
add_action('wp_ajax_recuperer_nouvelle_video_playlist_clip_player_page_principal', 'recuperer_nouvelle_video_playlist_clip_player_page_principal');
add_action('wp_ajax_nopriv_recuperer_nouvelle_video_playlist_clip_player_page_principal', 'recuperer_nouvelle_video_playlist_clip_player_page_principal');
add_action('wp_ajax_recuperer_videos_playlist_clip_player_page_principale', 'recuperer_videos_playlist_clip_player_page_principale' );
add_action('wp_ajax_nopriv_recuperer_videos_playlist_clip_player_page_principale', 'recuperer_videos_playlist_clip_player_page_principale' );
add_action('wp_ajax_recup_freq_logo_playlist_clip','recup_freq_logo_playlist_clip');
add_action('wp_ajax_nopriv_recup_freq_logo_playlist_clip','recup_freq_logo_playlist_clip');
add_action('wp_ajax_recup_id_video_courante_playlist_clip','recup_id_video_courante_playlist_clip');
add_action('wp_ajax_nopriv_recup_id_video_courante_playlist_clip','recup_id_video_courante_playlist_clip');

/*
*Fonction : Permet de récupérer les paramètres de la playlist.
*Ensuite on stock ces paramètres dans la table wp_playlistsenregistrees_webtv_plugin
*/
function enregistrement_playlist_clips_pourcentage(){
  global $wpdb;
//Recupère les différentes paramètres issues des balises html de la page index.php dans le dossier nouveaux_reglages.
  if(isset($_POST['nom_reglage'])){$nom_reglage=$_POST['nom_reglage'];}
  if(isset($_POST['pourcentage_poprock'])){ $pourcentage_poprock=$_POST['pourcentage_poprock'];}
  if(isset($_POST['pourcentage_hiphop'])){ $pourcentage_hiphop=$_POST['pourcentage_hiphop'];}
  if(isset($_POST['pourcentage_jazzblues'])){ $pourcentage_jazzblues=$_POST['pourcentage_jazzblues'];}
  if(isset($_POST['pourcentage_musiquemonde'])){ $pourcentage_musiquemonde=$_POST['pourcentage_musiquemonde'];}
  if(isset($_POST['pourcentage_hardrock'])){ $pourcentage_hardrock=$_POST['pourcentage_hardrock'];}
  if(isset($_POST['pourcentage_electro'])){ $pourcentage_electro=$_POST['pourcentage_electro'];}
  if(isset($_POST['pourcentage_chanson'])){ $pourcentage_chanson=$_POST['pourcentage_chanson'];}
  if(isset($_POST['pourcentage_autres'])){ $pourcentage_autres=$_POST['pourcentage_autres'];}
  if(isset($_POST['pubs_internes'])){ $pubs_internes = $_POST['pubs_internes'];} else { $pubs_internes = "no_pub_int"; }
  if(isset($_POST['pubs_externes'])){ $pubs_externes = $_POST['pubs_externes'];} else { $pubs_externes = "no_pub_ext"; }
  if(isset($_POST['artistehighlight'])){ $artiste_en_highlight=$_POST['artistehighlight'];} else { $artiste_en_highlight = "no_highlight"; }
  if(isset($_POST['annee_min'])){ $annee_min=$_POST['annee_min'];}
  if(isset($_POST['annee_max'])){ $annee_max=$_POST['annee_max'];}
  if(isset($_POST['qualite_min'])){ $qualite_min=$_POST['qualite_min'];}
  if(isset($_POST['date_debut'])){ $debut=$_POST['date_debut'];}
  if(isset($_POST['date_fin'])){ $fin=$_POST['date_fin'];}
  if(isset($_POST['pardefaut'])){ $par_defaut=$_POST['pardefaut'];}
  if(isset($_POST['freq_logo'])){$freq_logo = $_POST['freq_logo'];}

  if ($par_defaut == 0){  /////////////////////////////////////////////////////////////////////////////////////////// AJOUTER LES LOGO DANS LA REQUETE QUAND ILS SERONT FONCTIONNELS

    $inserer_nouvelle_playlist="INSERT INTO " . $wpdb->prefix . "playlistenregistrees_webtv_plugin(nom,pourcentage_poprock,pourcentage_rap,pourcentage_jazzblues,pourcentage_musiquemonde, pourcentage_hardrock,pourcentage_electro,pourcentage_chanson,pourcentage_autres,publicites_internes,publicites_externes,artiste_highlight,annee_max,annee_min,qualite_min,Debut,Fin,ParDefaut) VALUES('$nom_reglage','$pourcentage_poprock','$pourcentage_hiphop','$pourcentage_jazzblues', '$pourcentage_musiquemonde','$pourcentage_hardrock','$pourcentage_electro','$pourcentage_chanson','$pourcentage_autres','$pubs_internes','$pubs_externes','$artiste_en_highlight','$annee_max','$annee_min','$qualite_min','$debut','$fin','$par_defaut');";

    $select = $wpdb->query($inserer_nouvelle_playlist);

  }

}

function generer_la_playlist_clips(){

    global $wpdb;
    global $tab_url_clip;
    global $tab_titres_clip;
    global $tab_artistes_clip;
    global $tab_annees_clip;
    global $tab_genres_clip;
    global $tab_albums_clip;
    global $max_clip;

    if(isset($_POST["nom_playlist"])){$nom_playlist = $_POST["nom_playlist"];}

    $nom_playlist = explode("\n",$nom_playlist);
    $nom_requete_playlist = end($nom_playlist);

    $querydefaut="SELECT * FROM " . $wpdb->prefix . "playlistenregistrees_webtv_plugin WHERE nom='$nom_requete_playlist' LIMIT 1;";
    $resultdefaut=$wpdb->get_results($querydefaut);

    foreach($resultdefaut as $resdefaut){
        $nomdefaut =$resdefaut->nom;
        //NULL si case vide
        $artistehighlightdefaut=$resdefaut->artiste_highlight;
        $pubinternedefaut=$resdefaut->publicites_internes;
        $pubexternedefaut=$resdefaut->publicites_externes;
        $poprockdefaut=$resdefaut->pourcentage_poprock;
        $hiphopdefaut=$resdefaut->pourcentage_rap;
        $jazzbluesdefaut=$resdefaut->pourcentage_jazzblues;
        $musiquemondedefaut=$resdefaut->pourcentage_musiquemonde;
        $electrodefaut=$resdefaut->pourcentage_electro;
        $hardrockdefaut=$resdefaut->pourcentage_hardrock;
        $chansondefaut=$resdefaut->pourcentage_chanson;
        $autresdefaut=$resdefaut->pourcentage_autres;
        $amax=$resdefaut->annee_max;
        $amin=$resdefaut->annee_min;
        $qmin=$resdefaut->qualite_min;
      //  $frequence_logo = $resdefaut->Freq_logo;            ////////////////////////////// LOGO

        $debut = $resdefaut->Debut;
        $fin = $resdefaut->Fin;


        do_action('pluginwebtv_generer_playlist_clips',$poprockdefaut,$hiphopdefaut,$jazzbluesdefaut,$musiquemondedefaut,$hardrockdefaut,$electrodefaut,$chansondefaut,$autresdefaut,$pubinternedefaut,$pubexternedefaut,$artistehighlightdefaut,$amax,$amin,$qmin,$debut,$fin);


      //  do_action('pluginwebtv_freq_logo',$frequence_logo); ///////////////////////////////// LOGO
        /*
        $ppp = "\n".sizeof($tab_titres_clip)." - ".sizeof($tab_artistes_clip)." - ".$max_clip."\n";
        for ($i=0; $i<$max_clip; $i++)
        {
          $ppp = $ppp.("\n- ".$tab_artistes_clip[$i]." - ".$tab_titres_clip[$i]." - ".$tab_albums_clip[$i]);
        }
        echo ($ppp);
        */
    }


    //$tab_glob1=array();
    //On met tout ca dans la table Playlist
    $titres=str_replace("'","''",$tab_titres_clip);
    $urls=str_replace("'","''",$tab_url_clip);
    $artistes=str_replace("'","''",$tab_artistes_clip);
    $genres=str_replace("'","''",$tab_genres_clip);
    $annees=str_replace("'","''",$tab_annees_clip);
    $albums=str_replace("'","''",$tab_albums_clip);

        $wpdb->query("TRUNCATE TABLE " . $wpdb->prefix . "playlistclip_webtv_plugin");
    // permet de générer le nombre de clips à générer dans la table playlist_par_defaut_webtv_plugin
    for($k=0;$k<$max_clip;$k++){ // remettre count($titre) une fois pb résolu.

        // On insère sur toutes les cases les mêmes dates de début et de fin, elles nous permettront à la fin de chaque clip de déterminer si il faut arreter ou non la playlist

        $inserer="INSERT INTO " . $wpdb->prefix . "playlistclip_webtv_plugin(titre,url,artiste,genre,annee,album,Debut,Fin) VALUES('$titres[$k]','$urls[$k]','$artistes[$k]','$genres[$k]','$annees[$k]', '$albums[$k]', '$debut','$fin')";
        $wpdb->query($inserer);
    }

    echo("Playlist clip ". $nom_requete_playlist." générée ! ");
    wp_die();

}


/*
* Fonctions : utile pour le fichier js du player_homepage.js
*
*/

function recuperer_videos_playlist_clip_player_page_principale() {
    global $wpdb;
    $query="SELECT titre, artiste, url, annee, album, Debut, Fin FROM " . $wpdb->prefix . "playlistclip_webtv_plugin;";
    $result=$wpdb->get_results($query);
    wp_send_json_success($result);
}


/*
*  Fonction : Permet de trouver le max id d'une video dans la table playlist clip.
*  Très utile pour la fonction situé dans le player_homepage.js permettant d'ajouter
*  lA derniere video ajoutée dans la playlist.
*/
 function recuperer_nouvelle_video_playlist_clip_player_page_principal(){
    global $wpdb;
    $max_id = 0;

    //Phase obligatoire pour connaitre l'id de la nouvelle video car celui ci est générer automatiquement lors de l'insertion
    $query_recup_id_nouvelle_video = "SELECT id FROM " . $wpdb->prefix . "playlistclip_webtv_plugin; ";
    $reponse_recup_id_nouvelle_video = $wpdb->get_results($query_recup_id_nouvelle_video);
    foreach ($reponse_recup_id_nouvelle_video as $key ) {
      if ($max_id <= $key->id){
        $max_id = $key->id;
      }else{
        $max_id = $max_id ;
      }
    }
    $query_recup_genre_nouvelle_video = "SELECT genre FROM " . $wpdb->prefix . "playlistclip_webtv_plugin WHERE id='$max_id' ; ";
    $reponse_recup_genre_nouvelle_video = $wpdb->get_var($query_recup_genre_nouvelle_video);

    if($reponse_recup_genre_nouvelle_video == "Logo"){

      $max_id_vid = $max_id -1;// récupère la video précédent le logo
      $query_recup_titre_url_nouvelle_video_et_logo = "SELECT titre, artiste, url, annee, album, genre, Debut, Fin FROM " . $wpdb->prefix . "playlistclip_webtv_plugin WHERE id IN ('$max_id','$max_id_vid');";
      $reponse_recup_titre_url_nouvelle_video_et_logo = $wpdb->get_results($query_recup_titre_url_nouvelle_video_et_logo);
      wp_send_json_success($reponse_recup_titre_url_nouvelle_video_et_logo);
    }
    else {
      $query_recup_titre_url_nouvelle_video_ou_logo = "SELECT titre, artiste, url, annee, album, genre, Debut, Fin FROM " . $wpdb->prefix . "playlistclip_webtv_plugin WHERE id='$max_id' ; ";
      $reponse_recup_titre_url_nouvelle_video_ou_logo = $wpdb->get_results($query_recup_titre_url_nouvelle_video_ou_logo);
      wp_send_json_success($reponse_recup_titre_url_nouvelle_video_ou_logo);
    }

}


/*
* Fonction recupère la fréquence logo pour le fichier js du player_homepage.js et player_page.js
*
*/
function recup_freq_logo_playlist_clip(){
  global $wpdb;
  if(isset($_POST['nom_playlist'])){$nom_playlist = $_POST['nom_playlist'];}
  $query_recup_freq_logo_bdd = "SELECT Freq_logo FROM ". $wpdb->prefix ."playlistenregistrees_webtv_plugin WHERE nom='nom_playlist' LIMIT 1;";
  $reponse_recup_freq_logo_bdd = $wpdb->get_var($query_recup_freq_logo_bdd);
  echo($reponse_recup_freq_logo_bdd);
}
/*
* Fonction recupère l'id de la video courante utile pour le fichier js du player_homepage.js et player_page.js
*
*/
function recup_id_video_courante_playlist_clip(){
  global $wpdb;
  if(isset($_POST['videocourante'])){$videocourante = $_POST['videocourante'];}

  $query_recup_id_video_courante = "SELECT id FROM ". $wpdb->prefix ."playlistclip_webtv_plugin WHERE titre='$videocourante' LIMIT 1;";
  $reponse_query_recup_id_video_courante = $wpdb->get_var($query_recup_id_video_courante);
  echo ($reponse_query_recup_id_video_courante);
}



?>
