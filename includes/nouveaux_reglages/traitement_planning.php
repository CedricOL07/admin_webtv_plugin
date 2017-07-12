<?php


/**************************************************************************************************************************
**
**
**        Fichier contenant les fonctions exécutées pour l'affichage du calendrier appelées dans nouveaux_reglages.js
**
**
*******************************************************************************************************************************/
/*
Appel des différentes fonctions du programme
*/

add_action( 'wp_ajax_get_playlist_content', 'get_playlist_content' );
add_action( 'wp_ajax_change_playlist_date', 'change_playlist_date' );
add_action( 'wp_ajax_change_playlist_name', 'change_playlist_name' );



function get_playlist_content(){

/*
Cette fonction retourne la liste des noms et dates de début et fin des playlist pas par défaut
*/

    global $wpdb;

    $query="SELECT nom, Debut, Fin FROM " . $wpdb->prefix . "playlistenregistrees_webtv_plugin WHERE ParDefaut = 0;"; // Récupère les noms et dates des playlists pas par défaut
    $result=$wpdb->get_results($query);
    wp_send_json_success($result);

}

function change_playlist_date(){

/*
Cette fonction change les dates de début et fin de la playlist indiquée
*/

    global $wpdb;

    if(isset($_POST['nouvelle_start_date'])){ $nouvelle_start_date=$_POST['nouvelle_start_date']; }
    if(isset($_POST['nouvelle_end_date'])){ $nouvelle_end_date=$_POST['nouvelle_end_date']; }
    if(isset($_POST['nom_event'])){ $nom_event=$_POST['nom_event']; }

    // Verification qu'il y ai une playlist de ce nom
    $check_name="SELECT count(*) FROM " . $wpdb->prefix . "playlistenregistrees_webtv_plugin WHERE nom = '".$nom_event."';";
    $name=$wpdb->get_var($check_name);
    if ($name!=0)
    {
        $update_date="UPDATE " . $wpdb->prefix . "playlistenregistrees_webtv_plugin SET Debut='".$nouvelle_start_date."', Fin='".$nouvelle_end_date."' WHERE nom='".$nom_event."';"; 
        $wpdb->query($update_date);
        echo($nom_event." définie du ".$nouvelle_start_date." au ".$nouvelle_end_date);
    } else
    {
        echo ("la playlist $nom_event n'existe pas");
    }
}

function change_playlist_name(){

/*
Cette fonction change le nom de la playlist indiquée
*/

    global $wpdb;

    if(isset($_POST['ancien_nom'])){ $ancien_nom=$_POST['ancien_nom']; }
    if(isset($_POST['nouveau_nom'])){ $nouveau_nom=$_POST['nouveau_nom']; }

    // Verification qu'il y ai une playlist de ce nom
    $check_name="SELECT count(*) FROM " . $wpdb->prefix . "playlistenregistrees_webtv_plugin WHERE 'nom' = ".$ancien_nom.";";
    $name=$wpdb->get_var($check_name);
    if ($name==0)
    {
        echo("Aucune playlist avec ce nom : ".$ancien_nom);
        wp_die();
    } else
    {
        // Si elle existe, on met son nom à jour
        $update_name="UPDATE " . $wpdb->prefix . "playlistenregistrees_webtv_plugin SET 'nom'='$nouveau_nom' WHERE 'nom'='ancien_nom';"; 
        $wpdb->query($update_name);
        echo ($ancien_nom." correctement renommée en ".$nouveau_nom);
    }
}


?>
