<?php


/**************************************************************************************************************************
**
**
**        Fichier contenant les fonctions exécutées par les différentes reqûetes ajax de la page NOUVEAUX REGLAGES POUR LA
**                                                    LA PLAYLIST PAR DEFAUT
**
**
*******************************************************************************************************************************/
/*
Appel des différentes fonctions du programme
*/

//add_action( 'wp_ajax_traitement_infos_nouveaux_reglages', 'traitement_infos_nouveaux_reglages' );
add_action('wp_ajax_recuperer_programmation','recuperer_programmation');
add_action('wp_ajax_recuperer_noms_reglages','recuperer_noms_reglages');
add_action('wp_ajax_recuperer_derniers_pourcentages_enregistrees','recuperer_derniers_pourcentages_enregistrees');
add_action('wp_ajax_recuperer_tous_reglages_enregistres','recuperer_tous_reglages_enregistres');
add_action('wp_ajax_supprimer_toutes_videos','supprimer_toutes_videos');
add_action('pluginwebtv_generer_la_playlist_par_defaut', 'generer_la_playlist_par_defaut');
add_action('wp_ajax_enregistrer_reglage_par_defaut','enregistrer_reglage_par_defaut');
//add_action( 'pluginwebtv_eviter_repetition_tous_les_n_morceaux', 'eviter_repetition_tous_les_n_morceaux');
add_action('wp_ajax_etat_live','etat_live');
//add_action('wp_recupérer_id_par_defaut','recupérer_id_par_defaut');
add_action('wp_ajax_recup_val_par_defaut', 'recup_val_par_defaut');

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
        if(isset($_POST['nom_reglage'])){
            $nom_reglage=$_POST['nom_reglage'];
        }
        if(isset($_POST['pourcentage_poprock'])){
            $pourcentage_poprock=$_POST['pourcentage_poprock'];
        }
        if(isset($_POST['pourcentage_hiphop'])){
            $pourcentage_hiphop=$_POST['pourcentage_hiphop'];
        }
        if(isset($_POST['pourcentage_jazzblues'])){
            $pourcentage_jazzblues=$_POST['pourcentage_jazzblues'];
        }
        if(isset($_POST['pourcentage_musiquemonde'])){
            $pourcentage_musique_monde=$_POST['pourcentage_musiquemonde'];
        }
        if(isset($_POST['pourcentage_hardrock'])){
            $pourcentage_hardrock=$_POST['pourcentage_hardrock'];
        }
        if(isset($_POST['pourcentage_electro'])){
            $pourcentage_electro=$_POST['pourcentage_electro'];
        }
        if(isset($_POST['pourcentage_chanson'])){
            $pourcentage_chanson=$_POST['pourcentage_chanson'];
        }
        if(isset($_POST['pourcentage_autres'])){
            $pourcentage_autres=$_POST['pourcentage_autres'];
        }
        if(isset($_POST['annee_max'])){
            $annee_max=$_POST['annee_max'];
        }
        if(isset($_POST['annee_min'])){
            $annee_min=$_POST['annee_min'];
        }
        if(isset($_POST['qualite_min'])){
            $qualite_min=$_POST['qualite_min'];
        }


        if ($par_defaut == 1){

          $effacer_ancienne_playlist_par_defaut="DELETE FROM " . $wpdb->prefix . "playlistenregistrees_webtv_plugin WHERE ParDefaut='$par_defaut';";
          $select1=$wpdb->query($effacer_ancienne_playlist_par_defaut);

          $inserer_nouvelle_playlist_par_defaut="INSERT INTO " . $wpdb->prefix . "playlistenregistrees_webtv_plugin(nom,pourcentage_poprock,pourcentage_rap,pourcentage_jazzblues,pourcentage_musiquemonde,
          pourcentage_hardrock,pourcentage_electro,pourcentage_chanson,pourcentage_autres,annee_min,annee_max,qualite_min,ParDefaut) VALUES('$nom_reglage','$pourcentage_poprock','$pourcentage_hiphop','$pourcentage_jazzblues','$pourcentage_musique_monde','$pourcentage_hardrock','$pourcentage_electro','$pourcentage_chanson','$pourcentage_autres','$par_defaut');";

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
    $tableau_dates_debut=array();
    $tableau_dates_fin=array();

    //On chope les playlists enregistrés, on tri par date et quand creneau libre on met playlist defaut
    $ldefaut=1;
    //$querydefaut="SELECT * FROM " . $wpdb->prefix . "playlistenregistrees_webtv_plugin WHERE ParDefaut='$ldefaut';";
    $querydefaut="SELECT * FROM " . $wpdb->prefix . "playlistenregistrees_webtv_plugin";
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
      //for($i=0;$i<$nb_heures_a_completer2defaut;$i++){
            do_action('pluginwebtv_generer_playlist_par_defaut',$poprockdefaut,$hiphopdefaut,$jazzbluesdefaut,$musiquemondedefaut,$hardrockdefaut,$electrodefaut,$chansondefaut,$autresdefaut,$pubsinternesdefaut,$pubsexternesdefaut,$artistehightdefaut,$annee_max,$annee_min,$qualite_min);
        //}

    }

    $effacer_existant ="TRUNCATE TABLE " . $wpdb->prefix . "playlist_par_defaut_webtv_plugin;";
    $wpdb->query($effacer_existant);


    //$tab_glob1=array();
    //On met tout ca dans la table Playlist
    $titre=str_replace("'","''",$tab_titres);
    $artistes=str_replace("'","''",$tab_artistes);
    $genres=str_replace("'","''",$tab_genres);

    // permet de générer le nombre de clips à générer dans la table playlist_par_defaut_webtv_plugin
    for($k=0;$k<12;$k++){ // remettre sizeof($titre) une fois pb résolu.

        $inserer="INSERT INTO " . $wpdb->prefix . "playlist_par_defaut_webtv_plugin(titre,url,artiste,genre) VALUES('$titre[$k]','$tab_url[$k]','$artistes[$k]','$genres[$k]')";
        $wpdb->query($inserer);
    }


    function recup_val_par_defaut(){
      global $wpdb;
      $query_val_par_def="SELECT ParDefaut FROM " . $wpdb->prefix . "playlistenregistrees_webtv_plugin;";
      $result_val_par_def=$wpdb->get_var($query_val_par_def);
      wp_send_json_success($result);
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

?>