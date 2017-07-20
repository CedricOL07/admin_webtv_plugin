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
add_action('wp_ajax_vider_table_playlist_clip','vider_table_playlist_clip');
add_action('wp_ajax_chargement_page_quelle_playlist_charger','chargement_page_quelle_playlist_charger');
add_action('wp_ajax_verifier_playlist_clip_charger_dans_la_table','verifier_playlist_clip_charger_dans_la_table');


function chargement_page_quelle_playlist_charger() {

    /*
    * Fonction qui renvoie selon la demande:
    *   'bool'       : Si il existe une playlist qui peut être lu dès maintenant
    *   'name'       : Le nom de cette playlist si elle existe, "" sinon
    *   'date_debut' : La date de début de cette playlist si elle existe
    */

    global $wpdb;

    date_default_timezone_set('Europe/Paris'); //offset du fuseau horaire
    $current_date = Date(DATE_ATOM);

    $nom_a_lire="";
    $playlist_a_lire_exist=false;
    $start_date;
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
                $start_date = $date_debut;
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
    /*
    * Fonction : Vérifie si les date de début et fin chargée dans la table playlistclip sont 
    * les mêmes qu'une playlist de la base de donnée. Si une playlist a été créée sur les mêmes
    * horaires que celle chargée dans playlistclip, la table playlistclip ne sera pas actualisée
    * même si les pourcentages sont différents entre les deux playlists. Il faudra donc vider
    * cette table au préalable
    */

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
    wp_die();
}

function vider_table_playlist_clip(){
    /*
    * Fonction : Vide la table playlistclip. Utilisée dans nouveaux_reglages.js lors de l'appui sur un bouton de génération de 1h d'un genre.
    * Permet de recharger la table si on appui sur deux boutons différents dans la même minute, où si une playlist d'une heure était déjà chargée
    * exactement à cette heure.
    */

    $effacer_playlistclip="DELETE FROM " . $wpdb->prefix . "playlistenregistrees_webtv_plugin where 1;";
    $wpdb->query($effacer_playlistclip);

}



