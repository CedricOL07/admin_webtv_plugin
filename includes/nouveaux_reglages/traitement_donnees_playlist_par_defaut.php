<?php


/**************************************************************************************************************************
**
**
**        Fichier contenant les fonctions exécutées par les différentes reqûetes ajax de la page NOUVEAUX REGLAGES
**
**
*******************************************************************************************************************************/
/*
Appel des différentes fonctions du programme
*/

add_action('wp_ajax_recuperer_noms_reglages','recuperer_noms_reglages');
add_action('wp_ajax_enregistrer_reglage_par_defaut','enregistrer_reglage_par_defaut');
add_action('wp_ajax_recuperer_nouvelle_video_player_page_principal', 'recuperer_nouvelle_video_player_page_principal');
add_action('wp_ajax_recuperer_videos_player_page_principale_par_defaut', 'recuperer_videos_player_page_principale_par_defaut' );
add_action('wp_ajax_recup_freq_logo','recup_freq_logo');
add_action('wp_ajax_insertion_logo','insertion_logo');
add_action('wp_ajax_recup_id_video_courante','recup_id_video_courante');
add_action('pluginwebtv_generer_la_playlist_par_defaut', 'generer_la_playlist_par_defaut');
add_action('wp_ajax_url_vid_exist','url_vid_exist');



function recuperer_id_playlist_par_defaut(){
      $query = "SELECT ParDefaut FROM" . $wpdb->prefix . "playlistenregistrees_webtv_plugin;";
      $result=$wpdb->get_results($query);

}


/*
Cette focntion initialise les variable créer $par_defaut,$nom_reglage,...
par les instructions données par le client lors de la demande POST.
*/

function enregistrer_reglage_par_defaut(){

        global $wpdb;
        // Liste des variables transmises dans la requête ajax
        // On passe un booléen pour vérifier que la playlist a été définie comme par défaut ou non
        if(isset($_POST['pardefaut'])){
            $par_defaut=$_POST['pardefaut'];
            if ($par_defaut == true){
              $par_defaut =1;
            }
          }

        // = true si playlist définie comme par défaut
        // On passe un booléen pour vérifier que la playlist doit être passer directement à la suite ou non
        if(isset($_POST['nom_reglage'])){$nom_reglage=$_POST['nom_reglage'];}
        if(isset($_POST['pourcentage_poprock'])){$pourcentage_poprock=$_POST['pourcentage_poprock'];}
        if(isset($_POST['pourcentage_hiphop'])){$pourcentage_hiphop=$_POST['pourcentage_hiphop'];}
        if(isset($_POST['pourcentage_jazzblues'])){$pourcentage_jazzblues=$_POST['pourcentage_jazzblues'];}
        if(isset($_POST['pourcentage_musiquemonde'])){$pourcentage_musique_monde=$_POST['pourcentage_musiquemonde'];}
        if(isset($_POST['pourcentage_hardrock'])){$pourcentage_hardrock=$_POST['pourcentage_hardrock'];}
        if(isset($_POST['pourcentage_electro'])){$pourcentage_electro=$_POST['pourcentage_electro'];}
        if(isset($_POST['pourcentage_chanson'])){$pourcentage_chanson=$_POST['pourcentage_chanson'];}
        if(isset($_POST['pourcentage_autres'])){$pourcentage_autres=$_POST['pourcentage_autres'];}
        if(isset($_POST['annee_max'])){$annee_max=$_POST['annee_max'];}
        if(isset($_POST['annee_min'])){$annee_min=$_POST['annee_min'];}
        if(isset($_POST['qualite_min'])){$qualite_min = $_POST['qualite_min'];}
        if(isset($_POST['freq_logo'])){$freq_logo = $_POST['freq_logo'];}

        if ($par_defaut == 1){

          $effacer_ancienne_playlist_par_defaut="DELETE FROM " . $wpdb->prefix . "playlistenregistrees_webtv_plugin WHERE ParDefaut='$par_defaut';";
          $select1=$wpdb->query($effacer_ancienne_playlist_par_defaut);

          $inserer_nouvelle_playlist_par_defaut="INSERT INTO " . $wpdb->prefix . "playlistenregistrees_webtv_plugin(nom,pourcentage_poprock,pourcentage_rap,pourcentage_jazzblues,pourcentage_musiquemonde,
          pourcentage_hardrock,pourcentage_electro,pourcentage_chanson,pourcentage_autres,annee_max,annee_min,qualite_min,Freq_logo,ParDefaut) VALUES('$nom_reglage','$pourcentage_poprock','$pourcentage_hiphop','$pourcentage_jazzblues','$pourcentage_musique_monde','$pourcentage_hardrock','$pourcentage_electro','$pourcentage_chanson','$pourcentage_autres','$annee_max','$annee_min','$qualite_min','$freq_logo','$par_defaut');";

          $select = $wpdb->query($inserer_nouvelle_playlist_par_defaut);

        }

        do_action('pluginwebtv_generer_la_playlist_par_defaut');

    }

/*
*Fonction : permet de récupérer les noms de la playlist enregistrer  : utile dans le fihier nouveaux_reglages.js
*
*/
function recuperer_noms_reglages(){
    global $wpdb;
    $recuperer_noms="SELECT nom FROM " . $wpdb->prefix . "playlistenregistrees_webtv_plugin;";
    $resut=$wpdb->get_results($recuperer_noms);
    wp_send_json_success($resut);
}

/*
* Fonction : générer la playlist dans la table playlist_par_defaut_webtv_plugin dans la bdd wordpress
*
*/

function generer_la_playlist_par_defaut(){

    global $wpdb;
    global $tab_url;
    global $tab_titres;
    global $tab_genres;
    global $tab_artistes;
    global $tab_annees;
    global $tab_album;
    global $tab_logo_titre;
    global $tab_logo_url;

    //On chope les playlists enregistrés, on tri par date et quand creneau libre on met playlist defaut
    $ldefaut=1;
    //$querydefaut="SELECT * FROM " . $wpdb->prefix . "playlistenregistrees_webtv_plugin WHERE ParDefaut='$ldefaut';";
    $querydefaut="SELECT * FROM " . $wpdb->prefix . "playlistenregistrees_webtv_plugin WHERE ParDefaut = 1;";
    $resultdefaut=$wpdb->get_results($querydefaut);
    foreach($resultdefaut as $resdefaut){
        $nomdefaut =$resdefaut->nom;
        //NULL si case vide
        $artistehightdefaut=$resdefaut->artiste_highlight;
        $pubsinternesdefaut=$resdefaut->publicites_internes;
        $pubsexternesdefaut=$resdefaut->publicites_externes;
        $poprockdefaut=$resdefaut->pourcentage_poprock;
        $hiphopdefaut=$resdefaut->pourcentage_rap;
        $jazzbluesdefaut=$resdefaut->pourcentage_jazzblues;
        $musiquemondedefaut=$resdefaut->pourcentage_musiquemonde;
        $electrodefaut=$resdefaut->pourcentage_electro;
        $hardrockdefaut=$resdefaut->pourcentage_hardrock;
        $chansondefaut=$resdefaut->pourcentage_chanson;
        $autresdefaut=$resdefaut->pourcentage_autres;
        $annee_max=$resdefaut->annee_max;
        $annee_min=$resdefaut->annee_min;
        $qualite_min=$resdefaut->qualite_min;
        $frequence_logo = $resdefaut->Freq_logo;

            do_action('pluginwebtv_generer_playlist_par_defaut',$poprockdefaut,$hiphopdefaut,$jazzbluesdefaut,$musiquemondedefaut,$hardrockdefaut,$electrodefaut,$chansondefaut,$autresdefaut,$annee_max,$annee_min,$qualite_min);
            // appelle la fonction de récupération des logo.


    }

    $effacer_existant ="TRUNCATE TABLE " . $wpdb->prefix . "playlist_par_defaut_webtv_plugin;";
    $wpdb->query($effacer_existant);

    //On met tout ca dans la table Playlist
    $titre = str_replace("'","''",$tab_titres);
    $artistes = str_replace("'","''",$tab_artistes);
    $genres = str_replace("'","''",$tab_genres);
    $annees = str_replace("'","''",$tab_annees);
    $album = str_replace("'","''",$tab_album);
    $logo_titre = str_replace("'","''",$tab_logo_titre);

        for($k=0;$k<12;$k++){ // remettre sizeof($titre) une fois pb résolu.

            $inserer="INSERT INTO " . $wpdb->prefix . "playlist_par_defaut_webtv_plugin(titre,url,artiste,genre,annee,album) VALUES('$titre[$k]','$tab_url[$k]','$artistes[$k]','$genres[$k]','$annees[$k]', '$album[$k]')";
            $wpdb->query($inserer);
          }

}

/*
* Fonction récupérer le titre et l'url du logo pour le fichier js du player_homepage.js et player_page.js
*
*/
function insertion_logo(){
  global $wpdb;
  $query_recup_logo_bdd = "SELECT titre,url FROM ". $wpdb->prefix ."videos_logo_webtv_plugin ORDER BY RAND() LIMIT 1;";
  $reponse_recup_logo_bdd = $wpdb->get_results($query_recup_logo_bdd);
  wp_send_json_success($reponse_recup_logo_bdd);
}

/*
* Fonction recupère la fréquence logo pour le fichier js du player_homepage.js et player_page.js
*
*/
function recup_freq_logo(){
  global $wpdb;
  $query_recup_freq_logo_bdd = "SELECT Freq_logo FROM ". $wpdb->prefix ."playlistenregistrees_webtv_plugin WHERE ParDefaut=1 LIMIT 1;";
  $reponse_recup_freq_logo_bdd = $wpdb->get_var($query_recup_freq_logo_bdd);
  echo($reponse_recup_freq_logo_bdd);

}
/*
* Fonction recupère l'id de la video courante utile pour le fichier js du player_homepage.js et player_page.js
*
*/
function recup_id_video_courante(){
  global $wpdb;
  if(isset($_POST['videocourante'])){$videocourante = $_POST['videocourante'];}

  $query_recup_id_video_courante = "SELECT id FROM ". $wpdb->prefix ."playlist_par_defaut_webtv_plugin WHERE titre='$videocourante' LIMIT 1;";
  $reponse_query_recup_id_video_courante = $wpdb->get_var($query_recup_id_video_courante);
  echo ($reponse_query_recup_id_video_courante);
}


/*
* Fonctions : utile pour le fichier js du player_homepage.js et player_page.js dans la fonction générer la playlist
*
*/

function recuperer_videos_player_page_principale_par_defaut() {
    global $wpdb;
    $query="SELECT titre, artiste, url, annee, album FROM " . $wpdb->prefix . "playlist_par_defaut_webtv_plugin;";// plus de limite la playlist par default tournera indéfiniment
    $result=$wpdb->get_results($query);
    wp_send_json_success($result);
}


/*
*Fonction : Permet de trouver le max id d'une video dans la table playlist par defaut.
*Très utile pour la fonction situé dans le player_homepage.js permettant d'ajouter
*lA dernier video ajouté dans la playlist.
*/
 function recuperer_nouvelle_video_player_page_principal(){
    global $wpdb;
    $max_id = 0;

    //Phase obligatoire pour connaitre l'id de la nouvelle video car celui ci est générer automatiquement lors de l'insertion
    $query_recup_id_nouvelle_video = "SELECT id FROM " . $wpdb->prefix . "playlist_par_defaut_webtv_plugin; ";
    $reponse_recup_id_nouvelle_video = $wpdb->get_results($query_recup_id_nouvelle_video);
    foreach ($reponse_recup_id_nouvelle_video as $key ) {
      if ($max_id <= $key->id){
        $max_id = $key->id;
      }else{
        $max_id = $max_id ;
      }
    }
    $query_recup_genre_nouvelle_video = "SELECT genre FROM " . $wpdb->prefix . "playlist_par_defaut_webtv_plugin WHERE id='$max_id' ; ";
    $reponse_recup_genre_nouvelle_video = $wpdb->get_var($query_recup_genre_nouvelle_video);

    if($reponse_recup_genre_nouvelle_video == "Logo"){

      $max_id_vid = $max_id -1;// récupère la video précédent le logo
      $query_recup_titre_url_nouvelle_video_et_logo = "SELECT titre, artiste, url, annee, album, genre FROM " . $wpdb->prefix . "playlist_par_defaut_webtv_plugin WHERE id IN ('$max_id','$max_id_vid');";
      $reponse_recup_titre_url_nouvelle_video_et_logo = $wpdb->get_results($query_recup_titre_url_nouvelle_video_et_logo);
      wp_send_json_success($reponse_recup_titre_url_nouvelle_video_et_logo);
    }
    else {
      $query_recup_titre_url_nouvelle_video_ou_logo = "SELECT titre, artiste, url, annee, album, genre FROM " . $wpdb->prefix . "playlist_par_defaut_webtv_plugin WHERE id='$max_id' ; ";
      $reponse_recup_titre_url_nouvelle_video_ou_logo = $wpdb->get_results($query_recup_titre_url_nouvelle_video_ou_logo);
      wp_send_json_success($reponse_recup_titre_url_nouvelle_video_ou_logo);
    }

}

/*
* Fonction: qui permet de déterminer si le fichier video exist
* La fonction détect le code http du lien avec la commande curl
* si le lien à un code erreur 404 renvoie 1 et donc on supprime
* la video de la playlist
*
*/
function url_vid_exist(){
  if(isset($_POST['url_clip'])){$url_clip = $_POST['url_clip'];}
  $handle = curl_init($url_clip);
  curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);

  /* Get the HTML or whatever is linked in $url. */
  $response = curl_exec($handle);

  /* Check for 404 (file not found). */
  $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
  if($httpCode == 404) {
    echo(1);  /* Handle 404 here. */
  }else {
    echo(0);
  }

}


?>
