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

add_action( 'wp_ajax_traitement_infos_nouveaux_reglages', 'traitement_infos_nouveaux_reglages' );
add_action('wp_ajax_recuperer_programmation','recuperer_programmation');
add_action('wp_ajax_recuperer_noms_reglages','recuperer_noms_reglages');
add_action('wp_ajax_recuperer_derniers_pourcentages_enregistrees','recuperer_derniers_pourcentages_enregistrees');
add_action('wp_ajax_recuperer_tous_reglages_enregistres','recuperer_tous_reglages_enregistres');
add_action('wp_ajax_supprimer_toutes_videos','supprimer_toutes_videos');
add_action( 'pluginwebtv_generer_la_playlist_par_defaut', 'generer_la_playlist_par_defaut');
add_action('wp_ajax_enregistrer_reglage_par_defaut','enregistrer_reglage_par_defaut');
//add_action( 'pluginwebtv_eviter_repetition_tous_les_n_morceaux', 'eviter_repetition_tous_les_n_morceaux');
add_action('wp_ajax_etat_live','etat_live');
//add_action('wp_recupérer_id_par_defaut','recupérer_id_par_defaut');


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

function enregistrer_reglage_par_defaut()
    {
        global $wpdb;
        // Liste des variables transmises dans la requête ajax
        // On passe un booléen pour vérifier que la playlist a été définie comme par défaut ou non
        if(isset($_POST['pardefaut'])){

            $par_defaut=$_POST['pardefaut'];
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


        if ($par_defaut == true){
          $effacer_ancienne_playlist_par_defaut="DELETE FROM " . $wpdb->prefix . "playlistenregistrees_webtv_plugin WHERE ParDefaut='$pardefaut';";
          $select1=$wpdb->query($effacer_ancienne_playlist_par_defaut);

          $inserer_nouvelle_playlist_par_defaut="INSERT INTO " . $wpdb->prefix . "playlistenregistrees_webtv_plugin(nom,pourcentage_poprock,pourcentage_rap,pourcentage_jazzblues,pourcentage_musiquemonde,pourcentage_hardrock,pourcentage_electro,pourcentage_chanson,pourcentage_autres,ParDefaut) VALUES('$nom_reglage','$pourcentage_poprock','$pourcentage_hiphop','$pourcentage_jazzblues','$pourcentage_musique_monde','$pourcentage_hardrock','$pourcentage_electro','$pourcentage_chanson','$pourcentage_autres','$par_defaut');";

          $select=$wpdb->query($inserer_nouvelle_playlist_par_defaut);
          wp_die();

        }
        echo("reussi : " . $par_defaut);
        do_action('pluginwebtv_generer_la_playlist_par_defaut');

    }

function recuperer_programmation(){
// permet de récupérer le nom, le début et la fin d'une playlist enregistrée dans la base de donnée

    global $wpdb;
    $query="SELECT nom,Debut,Fin FROM " . $wpdb->prefix . "playlistenregistrees_webtv_plugin;";
    $result=$wpdb->get_results($query);
    wp_send_json_success($result);
    wp_die();

}

function recuperer_noms_reglages(){
    global $wpdb;
    $recuperer_noms="SELECT nom FROM " . $wpdb->prefix . "playlistenregistrees_webtv_plugin;";
    $resut=$wpdb->get_results($recuperer_noms);
    wp_send_json_success($resut);
    wp_die();
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

function generer_la_playlist_par_defaut(){


    global $wpdb;
    global $tab_url;
    global $tab_titres;
    global $tab_genres;
    global $tab_artistes;
    $tableau_dates_debut=array();
    $tableau_dates_fin=array();

    //On chope les playlists enregistrés, on tri par date et quand creneau libre on met playlist defaut
    $query="SELECT Debut,Fin FROM " . $wpdb->prefix . "playlistenregistrees_webtv_plugin;";
    $result=$wpdb->get_results($query);
    foreach($result as $res){

        $debut_playlist=$res->Debut;
        $fin_playlist=$res->Fin;
        //On converti en date
        if($debut_playlist != '' && $fin_playlist != ''){
            $date_debut_playlist=DateTime::createFromFormat('m/d/Y H:i', $debut_playlist,new DateTimeZone('Europe/Berlin'));
            $date_fin_playlist=DateTime::createFromFormat('m/d/Y H:i', $fin_playlist,new DateTimeZone('Europe/Berlin'));
            //On stock tout ca dans 2 tableaux
            $tableau_dates_debut[]=$date_debut_playlist;
            $tableau_dates_fin[]=$date_fin_playlist;

        }
    }




        $currentdate = new DateTime("+4 days",new DateTimeZone('Europe/Berlin'));
        $currentdate1 = new DateTime("",new DateTimeZone('Europe/Berlin'));


        $intervaldefaut=$currentdate1->diff($currentdate);
        $nb_anneedefaut=$intervaldefaut->format('%Y');
        $nb_moisdefaut=$intervaldefaut->format('%m');
        $nb_joursdefaut=$intervaldefaut->format('%a');
        $nb_heuresdefaut=$intervaldefaut->format('%H');
        $tdefaut=$nb_anneedefaut*8760;
        $t1defaut=$nb_moisdefaut*720;
        $t2defaut=$nb_joursdefaut*24;
        //On recupere le nombre d'heure à compléter avec la playlist par defaut
        $nb_heures_a_completer2defaut=$tdefaut+$t1defaut+$t2defaut+$nb_heuresdefaut;


        $ldefaut=true;
        $queryydefaut="SELECT * FROM " . $wpdb->prefix . "playlistenregistrees_webtv_plugin WHERE ParDefaut='$ldefaut';";
        $result13defaut=$wpdb->get_results($queryydefaut);
        foreach($result13defaut as $resdefaut){

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

            for($i=0;$i<$nb_heures_a_completer2defaut;$i++){
                do_action('pluginwebtv_generer_playlist_par_defaut',$poprockdefaut,$hiphopdefaut,$jazzbluesdefaut,$musiquemondedefaut,$hardrockdefaut,$electrodefaut,$chansondefaut,$autresdefaut,$pubsinternesdefaut,$pubsexternesdefaut,$artistehightdefaut);
            }
        }

    $effacer_existant ="TRUNCATE TABLE " . $wpdb->prefix . "playlist_par_defaut_webtv_plugin;";
    $wpdb->query($effacer_existant);


    //$tab_glob1=array();
    //On met tout ca dans la table Playlist
    $titre=str_replace("'","''",$tab_titres);
    $artistes=str_replace("'","''",$tab_artistes);
    $genres=str_replace("'","''",$tab_genres);

    // permet de générer le nombre de clips à générer dans la table playlist_par_defaut_webtv_plugin
    for($k=0;$k<15;$k++){ // remettre sizeof($titre) une fois pb résolu.

        $inserer="INSERT INTO " . $wpdb->prefix . "playlist_par_defaut_webtv_plugin(titre,url,artiste,genre) VALUES('$titre[$k]','$tab_url[$k]','$artistes[$k]','$genres[$k]')";
        $wpdb->query($inserer);
    }
    //do_action('pluginwebtv_eviter_repetition_tous_les_n_morceaux');

}

?>
