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
add_action( 'wp_ajax_get_playlist_endDate', 'get_playlist_endDate' );
add_action( 'wp_ajax_get_playlist_startDate', 'get_playlist_startDate' );



function get_playlist_content(){

/*
Cette focntion retourne la liste des noms 
par les instructions données par le client lors de la demande POST.
*/

    global $wpdb;

    $query="SELECT nom, Debut, Fin FROM " . $wpdb->prefix . "playlistenregistrees_webtv_plugin WHERE ParDefaut = 0;"; // Récupère les nom et date des playlist pas par défaut
    $result=$wpdb->get_results($query);
    wp_send_json_success($result);

}
    // Liste des variables transmises dans la requête ajax

  /*  if(isset($_POST['pardefaut'])){ $par_defaut=$_POST['pardefaut']; }

    if(isset($_POST['passer_des_que_possible'])){
        $passer_des_que_possible=$_POST['passer_des_que_possible'];
    }
    if(isset($_POST['nom_reglage'])){
        $nom_reglage=$_POST['nom_reglage'];
    }
    if(isset( $_POST['pubs_internes'])){
        $pubs_internes = $_POST['pubs_internes'];
        //var_dump( $pubs_internes);
    }
    if(isset($_POST['pubs_externes'])){
        $pubs_externes = $_POST['pubs_externes'];
        // var_dump( $pubs_externes);
    }
    if(isset($_POST['artistehighlight'])){
        $artiste_en_highlight=$_POST['artistehighlight'];
    }
    // =true si on doit passer de que possible

    if(isset($_POST['date_debut'])){
        $debut=$_POST['date_debut'];
    }
    if(isset($_POST['date_fin'])){
        $fin=$_POST['date_fin'];
    }

    $tab_url=array();
    $tab_titres=array();
    $tab_artistes=array();
    $nb_track;


*/


?>
