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

add_action('wp_ajax_recuperer_programmation','recuperer_programmation');
add_action('wp_ajax_recuperer_noms_reglages','recuperer_noms_reglages');
add_action('wp_ajax_recuperer_derniers_pourcentages_enregistrees','recuperer_derniers_pourcentages_enregistrees');
add_action('wp_ajax_recuperer_tous_reglages_enregistres','recuperer_tous_reglages_enregistres');
add_action('wp_ajax_supprimer_toutes_videos','supprimer_toutes_videos');
add_action('pluginwebtv_generer_la_playlist_par_defaut', 'generer_la_playlist_par_defaut');
add_action('wp_ajax_enregistrer_reglage_par_defaut','enregistrer_reglage_par_defaut');
add_action('wp_ajax_etat_live','etat_live');
add_action('wp_ajax_recup_val_par_defaut', 'recup_val_par_defaut');
add_action('wp_ajax_recuperer_nouvelle_video_player_page_principal', 'recuperer_nouvelle_video_player_page_principal');
add_action('wp_ajax_recuperer_videos_player_page_principale', 'recuperer_videos_player_page_principale' );
add_action('pluginwebtv_freq_logo', 'freq_logo');

function etat_live(){
    $etat_live;
    if(isset($_POST['data'])){
      $etat_live=$_POST['data'];
      wp_send_json($etat_live);
    }
}

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

function recuperer_noms_reglages(){
    global $wpdb;
    $recuperer_noms="SELECT nom FROM " . $wpdb->prefix . "playlistenregistrees_webtv_plugin;";
    $resut=$wpdb->get_results($recuperer_noms);
    wp_send_json_success($resut);
    //wp_die();
}

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
            do_action('pluginwebtv_freq_logo',$frequence_logo);

    }

    $effacer_existant ="TRUNCATE TABLE " . $wpdb->prefix . "playlist_par_defaut_webtv_plugin;";
    $wpdb->query($effacer_existant);

    //$tab_glob1=array();
    //On met tout ca dans la table Playlist
    $titre = str_replace("'","''",$tab_titres);
    $artistes = str_replace("'","''",$tab_artistes);
    $genres = str_replace("'","''",$tab_genres);
    $annees = str_replace("'","''",$tab_annees);
    $album = str_replace("'","''",$tab_album);
    $logo_titre = str_replace("'","''",$tab_logo_titre);

    // permet de générer le nombre de clips à générer dans la table playlist_par_defaut_webtv_plugin en fonction du nombre de logo(s)
    switch ($frequence_logo) {
      case 0:
        for($k=0;$k<12;$k++){ // remettre sizeof($titre) une fois pb résolu.

            $inserer="INSERT INTO " . $wpdb->prefix . "playlist_par_defaut_webtv_plugin(titre,url,artiste,genre,annee,album) VALUES('$titre[$k]','$tab_url[$k]','$artistes[$k]','$genres[$k]','$annees[$k]', '$album[$k]')";
            $wpdb->query($inserer);
        }
        break;

      case 1:
        for($k=0;$k<12;$k++){ // remettre sizeof($titre) une fois pb résolu.
          if ($k!=6){
            $inserer="INSERT INTO " . $wpdb->prefix . "playlist_par_defaut_webtv_plugin(titre,url,artiste,genre,annee,album) VALUES('$titre[$k]','$tab_url[$k]','$artistes[$k]','$genres[$k]','$annees[$k]', '$album[$k]')";
            $wpdb->query($inserer);
          }
          else{
            $inserer="INSERT INTO " . $wpdb->prefix . "playlist_par_defaut_webtv_plugin(titre,url,artiste,genre,annee,album) VALUES('$logo_titre[0]','$tab_logo_url[0]','undef','undef','undef', 'undef')";
            $wpdb->query($inserer);
          }
        }
        break;

      case 2:
        $l = 0;// permet d'incrémenter pour le tableau de pub
        for($k=0;$k<12;$k++){ // remettre sizeof($titre) une fois pb résolu.
          if ($k!=6 && $k!=11){
            $inserer="INSERT INTO " . $wpdb->prefix . "playlist_par_defaut_webtv_plugin(titre,url,artiste,genre,annee,album) VALUES('$titre[$k]','$tab_url[$k]','$artistes[$k]','$genres[$k]','$annees[$k]', '$album[$k]')";
            $wpdb->query($inserer);
          }
          else{
            $inserer="INSERT INTO " . $wpdb->prefix . "playlist_par_defaut_webtv_plugin(titre,url,artiste,genre,annee,album) VALUES('$logo_titre[$l]','$tab_logo_url[$l]','undef','undef','undef', 'undef')";
            $wpdb->query($inserer);
            $l++;
          }
        }
        break;

      case 3:
        $l = 0;// permet d'incrémenter pour le tableau de pub
        for($k=0;$k<12;$k++){ // remettre sizeof($titre) une fois pb résolu.
          if ($k!=3 && $k!=6 && $k!=9){
            $inserer="INSERT INTO " . $wpdb->prefix . "playlist_par_defaut_webtv_plugin(titre,url,artiste,genre,annee,album) VALUES('$titre[$k]','$tab_url[$k]','$artistes[$k]','$genres[$k]','$annees[$k]', '$album[$k]')";
            $wpdb->query($inserer);
          }
          else{
            $inserer="INSERT INTO " . $wpdb->prefix . "playlist_par_defaut_webtv_plugin(titre,url,artiste,genre,annee,album) VALUES('$logo_titre[$l]','$tab_logo_url[$l]','undef','undef','undef', 'undef')";
            $wpdb->query($inserer);
            $l++;
          }
        }
        break;

      case 4:
        $l = 0;// permet d'incrémenter pour le tableau de pub
        for($k=0;$k<12;$k++){ // remettre sizeof($titre) une fois pb résolu.
          if ($k!=3 && $k!=6 && $k!=9 && $k!=11){
            $inserer="INSERT INTO " . $wpdb->prefix . "playlist_par_defaut_webtv_plugin(titre,url,artiste,genre,annee,album) VALUES('$titre[$k]','$tab_url[$k]','$artistes[$k]','$genres[$k]','$annees[$k]', '$album[$k]')";
            $wpdb->query($inserer);
          }
          else{
            $inserer="INSERT INTO " . $wpdb->prefix . "playlist_par_defaut_webtv_plugin(titre,url,artiste,genre,annee,album) VALUES('$logo_titre[$l]','$tab_logo_url[$l]','undef','undef','undef', 'undef')";
            $wpdb->query($inserer);
            $l++;
          }
        }
        break;

      case 5:
        $l = 0;// permet d'incrémenter pour le tableau de pub
        for($k=0;$k<12;$k++){ // remettre sizeof($titre) une fois pb résolu.
          if ($k!=2 && $k!=4 && $k!=6 && $k!=8 && $k!=10){
            $inserer="INSERT INTO " . $wpdb->prefix . "playlist_par_defaut_webtv_plugin(titre,url,artiste,genre,annee,album) VALUES('$titre[$k]','$tab_url[$k]','$artistes[$k]','$genres[$k]','$annees[$k]', '$album[$k]')";
            $wpdb->query($inserer);
          }
          else{
            $inserer="INSERT INTO " . $wpdb->prefix . "playlist_par_defaut_webtv_plugin(titre,url,artiste,genre,annee,album) VALUES('$logo_titre[$l]','$tab_logo_url[$l]','undef','undef','undef', 'undef')";
            $wpdb->query($inserer);
            $l++;
          }
        }
        break;
    }



    function recuperer_programmation(){
    // permet de récupérer le nom, le début et la fin d'une playlist enregistrée dans la base de donnée

        global $wpdb;
        $query="SELECT nom,Debut,Fin FROM " . $wpdb->prefix . "playlistenregistrees_webtv_plugin;";
        $result=$wpdb->get_results($query);
        wp_send_json_success($result);
    }
    // On genere une nouvelle playlist pour la semaine
    function recuperer_derniers_pourcentages_enregistrees(){

        global $wpdb;
        global $montantpop;
        $recuperer="SELECT * FROM " . $wpdb->prefix . "playlistenregistrees_webtv_plugin ORDER BY id DESC LIMIT 1;";
        $result=$wpdb->get_results($recuperer);

        wp_send_json_success($result);
    }

    function recuperer_tous_reglages_enregistres(){
        global $wpdb;
        $query="SELECT * FROM " . $wpdb->prefix . "playlistenregistrees_webtv_plugin;";
        $result=$wpdb->get_results($query);
        wp_send_json_success($result);

    }

    function supprimer_toutes_videos(){
        global $wpdb;

        $query="DELETE FROM " . $wpdb->prefix . "videos_webtv_plugin;";
        $wpdb->query($query);
        wp_die();

    }

}
/*
* fonction : récupère le nombre de fois que le logo sera insérer dans la playlist
* dans le tableau $tab_video_logo, les doublons sont acceptés.
*/
function freq_logo($frequence_logo){
  global $wpdb;
  global $tab_video_logo;
  global $tab_logo_titre;
  global $tab_logo_url;

  $query_id_video_logo="SELECT video_id FROM " . $wpdb->prefix . "relation_webtv_plugin WHERE genre_id='13' ORDER BY RAND();";// genre du Logo est 13
  $result_id_video_logo = $wpdb->get_results($query_id_video_logo);
  foreach ($result_id_video_logo as   $results) {
    $tab_video_logo_verif[] = $results->video_id;
  }
  //si il n'y a pas de logo dans la table relation_webtv_plugin
 if (sizeof($tab_video_logo_verif) > 0){

   //incrémente un logo tant que la fréquence choisi par l'utilisateur n'est pas atteinte.
   while (sizeof($tab_video_logo) <= ($frequence_logo-1)) {// -1 car le tableau commence à 0

     // insère les logo présent dans le tableau  $tab_video_logo_verif issue de la requète
     for ($i=0; $i < sizeof($tab_video_logo_verif) ; $i++) {

       // si  le tableau de logo final  dépasse la fréquence on stop la boucle sinon on continue de répèter meme s'il y a présence de doublons.
        if (sizeof($tab_video_logo) > ($frequence_logo -1) ) {// -1 car le tableau commence à 0
          break;
        }
        else{
          $tab_video_logo[] = $tab_video_logo_verif[$i];
          //echo(" id video : " . $tab_video_logo[$i]);
        }
      }
    }
    // récupère titre et url du tableau des id_ logo créer
    foreach ($tab_video_logo as $key) {
      $query_titre_url_video_logo="SELECT titre,url FROM " . $wpdb->prefix . "videos_webtv_plugin WHERE id='$key';";
      $tab_logo_titre[] =$wpdb->get_var($query_titre_url_video_logo,0,0);
      $tab_logo_url[] = $wpdb->get_var($query_titre_url_video_logo,1,0);
    }
  }
 else {
   echo '<script>alert(\"Il n\'y a pas de logo dans la base de données donc aucun logo n\'est insérer dans la playlist. \")</script>';
   break;
 }
}

/*
* Fonctions : utile pour le fichier js du player_homepage.js
*
*/

function recuperer_videos_player_page_principale() {
    //do_action('pluginwebtv_generer_la_playlist_par_defaut');
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
    //echo ("max-id : ". $max_id);

    $query_recup_titre_url_nouvelle_video = "SELECT titre, artiste, url, annee, album FROM " . $wpdb->prefix . "playlist_par_defaut_webtv_plugin WHERE id='$max_id' ; ";
    $reponse_recup_titre_url_nouvelle_video = $wpdb->get_results($query_recup_titre_url_nouvelle_video);

    wp_send_json_success($reponse_recup_titre_url_nouvelle_video);

}

?>
