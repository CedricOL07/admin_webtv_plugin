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
add_action( 'wp_ajax_delete_playlist', 'delete_playlist' );
add_action( 'wp_ajax_gestion_une_playlist_a_la_fois', 'gestion_une_playlist_a_la_fois' );



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
    $check_name="SELECT count(*) FROM " . $wpdb->prefix . "playlistenregistrees_webtv_plugin WHERE nom = '".$ancien_nom."';";
    $name=$wpdb->get_var($check_name);
    if ($name==0)
    {
        echo("Aucune playlist avec ce nom : ".$ancien_nom);
        wp_die();
    } else
    {
        // Si elle existe, on met son nom à jour
        $update_name="UPDATE " . $wpdb->prefix . "playlistenregistrees_webtv_plugin SET nom='$nouveau_nom' WHERE nom='$ancien_nom';";
        $wpdb->query($update_name);
        echo ($ancien_nom." correctement renommée en ".$nouveau_nom);
    }
}

function delete_playlist(){

/*
Cette fonction supprime la playlist indiquée
*/

    global $wpdb;

    if(isset($_POST['nom_event'])){ $nom_event=$_POST['nom_event']; }               // appel depuis le js
    else{if(isset($_SESSION['nom_event'])){ $nom_event=$_SESSION['nom_event']; } }  // appel depuis la fct php gestion_une_playlist_a_la_fois

    // Verification qu'il y ai une playlist de ce nom
    $check_name="SELECT count(*) FROM " . $wpdb->prefix . "playlistenregistrees_webtv_plugin WHERE nom = '".$nom_event."';";
    $name=$wpdb->get_var($check_name);
    if ($name==0)
    {
        echo("Aucune playlist avec ce nom : ".$nom_event);
        wp_die();
    } else
    {
        // Si elle existe, on la supprime
        $update_name="DELETE FROM " . $wpdb->prefix . "playlistenregistrees_webtv_plugin WHERE nom='$nom_event';";
        $wpdb->query($update_name);
        echo ($nom_event." correctement supprimé");
    }
}

function gestion_une_playlist_a_la_fois(){

/*
Assure que deux playlists ne se chevauchent pas
pour chaque playlist: date debut=pdd, date fin=pdf
nouvelle playist:  date debut=dd, date fin=df
si pdf>dd:
                        oui--> pdd = df                        pdd> ---
        oui--> pdd<df?  non--> rien à faire             dd ---------|-|---------------------------------------
pdf>df?                                                             | | -- donnera -->
        non--> pdd<dd?  oui--> pdf = dd                 df ---------|-|-----------------pdd>-___--------------
                        non--> supprimer playlist                   | |                      | |
                                                               pdf> ---                 pdf> ---

*/

    global $wpdb;

    if(isset($_POST['nom_playlist'])){ $nom_playlist=$_POST['nom_playlist']; }  // appel depuis le js
    if(isset($_POST['date_debut'])){ $dd=$_POST['date_debut']; }
    if(isset($_POST['date_fin'])){ $df=$_POST['date_fin']; }

    $dd = Date(DATE_ATOM, strtotime($dd));
    $df = Date(DATE_ATOM, strtotime($df));

    // Verification des playlist pas par défaut
    $check_playlists="SELECT nom, Debut, Fin FROM " . $wpdb->prefix . "playlistenregistrees_webtv_plugin WHERE ParDefaut=0 AND nom!='$nom_playlist';";
    $playlists = $wpdb->get_results($check_playlists);
    foreach ($playlists as $playlist_n) {
        $nom_n = $playlist_n->nom;
        $debut_n = $playlist_n->Debut;
        $fin_n = $playlist_n->Fin;

        $pdd = Date(DATE_ATOM, strtotime($debut_n));
        $pdf = Date(DATE_ATOM, strtotime($fin_n));

        $to_be_changed = 0;

        if($pdf>$dd)
        {
            if ($pdf>$df)
            {
                if ($pdd<$df)
                {
                    $pdd = $df;
                    $to_be_changed = 1;
                }
            } else
            {
                if ($pdd<$dd)
                {
                    $pdf = $dd;
                    $to_be_changed = 1;
                } else
                {
                    $_SESSION['nom_event'] = $nom_n;
                    delete_playlist();
                    unset($_SESSION['nom_event']);
                }
            }
        }
        if($to_be_changed==1)
        {
            $update_date_query = "UPDATE " . $wpdb->prefix . "playlistenregistrees_webtv_plugin SET Debut='$pdd', Fin='$pdf' WHERE nom='$nom_n';";
            $wpdb->query($update_date_query);
        }
    }

}


?>
