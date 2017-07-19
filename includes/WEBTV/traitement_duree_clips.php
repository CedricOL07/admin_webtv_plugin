<?php


/**************************************************************************************************************************
**
**
**  Fichier utile pour calculer la durée d'un clip (et par conséquent d'une playlist) (non utilisé pour la dernière version),
**  Gère également les verifications si une playlist personnalisée est disponible ou s'il faut lire la playlist par défaut
**  Fonctions appelées dans player_homepage et player_page       
**
**
*******************************************************************************************************************************/
/*
Appel des différentes fonctions du programme
*/

//add_action( 'wp_ajax_traitement_infos_nouveaux_reglages', 'traitement_infos_nouveaux_reglages' );
add_action('wp_ajax_recuperer_duree_clip','recuperer_duree_clip');
add_action('wp_ajax_chargement_page_quelle_playlist_charger','chargement_page_quelle_playlist_charger');
add_action('wp_ajax_verifier_playlist_clip_charger_dans_la_table','verifier_playlist_clip_charger_dans_la_table');

function recuperer_duree_clip(){
    global $tab_durees;
    global $tab_url;
    global $tab_titres;

    
    /*
    if(isset($_POST['nom_clip']) && isset($_POST['url_clip'])){
        $nom_clip=$_POST['nom_clip'];
        $url_clip=$_POST['url_clip'];
    } else {
      wp_die();
    }
    */
    $taille = sizeof($tab_url);
    for ($i=0; $i<$taille; $i++)
    {
        $nom = $tab_titres[$i];
        $url = $tab_url[$i];

       	$filename = $url;

       	if (strpos($filename, "//")>0) // Si on a un chemin de la forme http://.....
       	{
       		
           	$domaine = __DIR__;
        		$deb = strpos($domaine, "wordpress"); 
        		$domaine = substr($domaine, 0, $deb);		// Récupère le chemin local
        		$domaine = str_replace('\\', '/', $domaine);
        		$fin = strpos($filename, "wordpress"); 
        		$filename = $domaine . substr($filename, $fin);
         		/**/
       	}
      	// include getID3() library : https://sourceforge.net/projects/getid3/?SetFreedomCookie
      	require_once('getID3/getid3/getid3.php');
      	// Initialize getID3 engine
      	$getID3 = new getID3;
      	// Analyze file and store returned data in $ThisFileInfo
      	$ThisFileInfo = $getID3->analyze($filename);
      	// Playtime in minutes:seconds, formatted string
      	$tab_durees[$i] = $ThisFileInfo['playtime_string'];

    }

    echo ($tab_titres[0]." = ".sizeof($tab_url).sizeof($tab_titres).sizeof($tab_durees));
    wp_die();

/**/
    // wp_send_json_success($duree);
}


function chargement_page_quelle_playlist_charger() {

    global $wpdb;

    date_default_timezone_set('Europe/Paris'); //offset du fuseau horaire
    $current_date = Date(DATE_ATOM);

    $nom_a_lire="";
    $playlist_a_lire_exist=false;
    if(isset($_POST['demande'])){$demande=$_POST['demande'];}
  
    $result = array();
    $date_debut;
    $date_fin;

    $query_compte="SELECT COUNT(*) FROM " . $wpdb->prefix . "playlistenregistrees_webtv_plugin where ParDefaut = 0;";
    $nb_playlists_clip=$wpdb->get_var($query_compte);
    if($nb_playlists_clip>=1)
    {
        $query="SELECT nom, Debut, Fin FROM " . $wpdb->prefix . "playlistenregistrees_webtv_plugin where ParDefaut = 0;";
        $nom_playlists_clip=$wpdb->get_results($query);
        foreach($nom_playlists_clip as $playlist){
        
            $nom = $playlist->nom;
            $debut = $playlist->Debut;
            $fin = $playlist->Fin;

            $date_debut = Date(DATE_ATOM, strtotime($debut));
            $date_fin = Date(DATE_ATOM, strtotime($fin));

            if($date_debut<$current_date && $date_fin>$current_date)
            {
                $playlist_a_lire_exist = true;
                $nom_a_lire = $nom;
            }
        }
    }
    if ($demande=="bool")
    {
        echo ($playlist_a_lire_exist);
        wp_die();
    } else
    {
        if ($demande=="date_debut")
        {
            echo ($date_debut);
            wp_die();
        } else
        {
            echo($nom_a_lire);
            wp_die();
        }
    } 
}


function verifier_playlist_clip_charger_dans_la_table() {

    global $wpdb;

    date_default_timezone_set('Europe/Paris'); //offset du fuseau horaire
    $current_date = Date(DATE_ATOM);
  
    $result = array();
    $date_debut;
    $date_fin;

    $query_date="SELECT Debut, Fin FROM " . $wpdb->prefix . "playlistclip_webtv_plugin LIMIT 1;";
    $date_table_clip=$wpdb->get_results($query_date);
    foreach($date_table_clip as $date){
        $debut_table_clip = $date->Debut;
        $fin_table_clip = $date->Fin;
    }
    $debut_table_clip = Date(DATE_ATOM, strtotime($debut_table_clip));
    $fin_table_clip = Date(DATE_ATOM, strtotime($fin_table_clip));
    
    $query_compte="SELECT COUNT(*) FROM " . $wpdb->prefix . "playlistenregistrees_webtv_plugin where ParDefaut = 0;";
    $nb_playlists_clip=$wpdb->get_var($query_compte);
    if($nb_playlists_clip>=1)
    {
        $query="SELECT Debut, Fin FROM " . $wpdb->prefix . "playlistenregistrees_webtv_plugin where ParDefaut = 0;";
        $nom_playlists_clip=$wpdb->get_results($query);
        foreach($nom_playlists_clip as $playlist){
        
            $debut = $playlist->Debut;
            $fin = $playlist->Fin;

            $date_debut = Date(DATE_ATOM, strtotime($debut));
            $date_fin = Date(DATE_ATOM, strtotime($fin));

            if($date_debut<$current_date && $date_fin>$current_date)
            {
                $playlist_a_lire_exist = true;
                $nom_a_lire = $nom;
                if ($debut_table_clip!=$date_debut || $fin_table_clip!=$date_fin) // Si les dates de playlist_clip ne sont pas les bonnes
                {
                    $playlist_a_lire_exist = false;
                }
            }
        }
    }

    echo($playlist_a_lire_exist);
}

