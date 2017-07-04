<?php
/* Plugin Name: PluginWEBTVFIL
 * Plugin URI: http://prometheearchimonde.net
 * Description: Plugin de l'interface de gestion des playlists pour la webtv du Fil
 * Version: 2.0
 * Author: Equipe Projet Ingénierie WEBTVFil
 * Author URI:
 * License:
 */
if ( ! defined( 'ABSPATH' ) ) exit;
define( 'MY_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );

// les add_action ('wp_ajax....', '...') permettes de déclarer les fonction PHP dans touts wordpress afin que les fonction ajax dans les fichiers javascript puissent les réutiliser
add_action( 'wp_ajax_recuperer_nouvelle_video_player_page_principal', 'recuperer_nouvelle_video_player_page_principal');


//do_action('pluginwebtv_maj_playlist_table');
// ce sont des fichiers avec seulement des fonctions (pas de html)
function php_includes(){

  //  include('includes/GenerationPlaylist.php');
    include('includes/GenerationPlaylist_par_defaut.php');
    include('includes/nouveaux_reglages/traitement_donnees_playlist_par_defaut.php');
    include('includes/nouveaux_reglages/traitement_donnees_playlists_clips.php');
    include('includes/GestionBDD/gestionbdd-ajax.php');
    include('includes/GestionBDD/tableau_clips_videos/tableau_clips_videos_ajax.php');
    include('includes/GestionBDD/tableau_playlists_videos/tableau_playlists_videos_ajax.php');
    include('includes/GestionBDD/ajouter_video/ajouter_video.php');

}
php_includes();

// Includes des pages html
function gestion_bdd_callback(){include('includes/GestionBDD/gestionbdd.php');}
function callback_menu_webtv(){include('includes/WEBTV/page_principale/index.php');}
function callback_menu_erreur(){include('includes/WEBTV/page_principale/erreur.php');}
function nouveaux_reglages_callback(){require_once('includes/nouveaux_reglages/index.php');}


 // Hook pour ajouter l'action dans la pile WP
function plugin_webtvfil(){


    if ( is_plugin_active( 'wordpress-bootstrap-css/hlt-bootstrapcss.php')==false){

        $page_menu=add_menu_page( 'WEBTV Plugin Menu', 'WEBTV', 'manage_options', 'sous-menu-webtv', 'callback_menu_erreur', plugins_url( 'admin_webtv_plugin/image/iconetv.png' ));
    }else{

     //add_management_page('WEBTV_ADMIN','WEBTV','manage_options','webtv-tools','tools_callback');//Page dans outils
        $page_menu=add_menu_page( 'WEBTV Plugin Menu', 'WEBTV', 'manage_options', 'sous-menu-webtv', 'callback_menu_webtv', plugins_url( 'admin_webtv_plugin/image/iconetv.png' ));
        $page_nouveaux_reglages=add_submenu_page( 'sous-menu-webtv', 'Nouveaux Réglages', 'Nouvelle Playlist', 'manage_options', 'myplugin-submenu1', 'nouveaux_reglages_callback' );
      //  add_submenu_page( 'sous-menu-webtv', 'Réglages Enregistrés', 'Réglages de Playlist Enregistrés', 'manage_options', 'myplugin-submenu2', 'reglages_enregistres_callback' );
        $gestioncontenu=add_submenu_page( 'sous-menu-webtv', 'Réglages Enregistrés', 'Gestion du contenu', 'manage_options', 'myplugin-submenu2', 'gestion_bdd_callback' );



        add_action('admin_print_styles-' . $page_menu, 'scripts_page_principale');
        add_action('admin_print_styles-'.$gestioncontenu,'scripts_gestion_contenu');
        add_action('admin_print_styles-' .  $page_nouveaux_reglages, 'scripts_nouveaux_reglages');
    }

}

add_action( 'admin_menu', 'plugin_webtvfil' );

function scripts_page_principale(){
    wp_enqueue_script("homepagejs",  plugins_url("includes/WEBTV/homepage.js", __FILE__), FALSE);
	wp_enqueue_script("playerhompagejs",  plugins_url("includes/WEBTV/player_homepage.js", __FILE__), FALSE);
	wp_enqueue_style("playrebluemondaycss", plugins_url("assets/css/jplayer.blue.monday.min.css", __FILE__), FALSE);
	wp_enqueue_style("allskincss", plugins_url("assets/css/skins/_all-skins.min.css", __FILE__), FALSE);
    wp_enqueue_script("jplayerplaylistjs",  plugins_url("assets/js/dist/jplayer/jplayer.playlist.min.js", __FILE__), FALSE);
    wp_enqueue_script("jqueryjplayerjs",  plugins_url("assets/js/dist/jplayer/jquery.jplayer.min.js", __FILE__), FALSE);
    wp_enqueue_style("nouveaureglagecustomcss",plugins_url('assets/css/nouveau_reglage.css',__FILE__) , FALSE);
}


function scripts_gestion_contenu(){

    // Register déclare le script à wordpress sans l'executer
    //wp_register_script("tableau_clips_videosjs",plugins_url('admin_webtv_plugin/includes/GestionBDD/tableau_clips_videos/tableau_clips_videos.js', __FILE__), FALSE);
    wp_register_script("ajouter_videojs",plugins_url('admin_webtv_plugin/includes/GestionBDD/ajouter_video/ajouter_video.js', __FILE__), FALSE);

    // enqueue exécute le script
    wp_register_script( 'bootstrap_multiselectjs',plugins_url('assets/js/dist/bootstrap-multiselect.js',__FILE__),FALSE);
    wp_enqueue_script('bootstrap_multiselectjs');
    wp_enqueue_style("bootstrap_multiselectcss",plugins_url('assets/css/bootstrap-multiselect.css',__FILE__) , FALSE);

    //wp_register_script("gestionbddjs",  plugins_url("js/gestionbdd.js", __FILE__), FALSE);
    wp_enqueue_style("timepickercss",plugins_url('assets/css/timepicker.css',__FILE__) , FALSE);
    wp_register_script( 'datetimepickerjs',plugins_url('assets/js/dist/datetimepicker.js',__FILE__),FALSE);
    wp_enqueue_script('datetimepickerjs');
//wp_enqueue_script ('gestionbddjs');

}

function scripts_nouveaux_reglages(){

    wp_register_script( 'nouveaureglagejs', plugins_url('includes/nouveaux_reglages/nouveaux_reglages.js',__FILE__), array(), null, false );
    wp_enqueue_script('nouveaureglagejs');
    wp_register_script( 'bootstrap_multiselectjs',plugins_url('assets/js/dist/bootstrap-multiselect.js',__FILE__),FALSE);
    wp_enqueue_script('bootstrap_multiselectjs');
    wp_enqueue_style("bootstrap_multiselectcss",plugins_url('assets/css/bootstrap-multiselect.css',__FILE__) , FALSE);
    wp_enqueue_style("nouveaureglagecustomcss",plugins_url('assets/css/nouveau_reglage.css',__FILE__) , FALSE);
    wp_enqueue_style("timepickercss",plugins_url('assets/css/timepicker.css',__FILE__) , FALSE);
    wp_register_script( 'datetimepickerjs',plugins_url('assets/js/dist/datetimepicker.js',__FILE__),FALSE);
    wp_enqueue_script('datetimepickerjs');
}

/*
function eliminer_anciennes_playlists(){
    global $wpdb;
    $timezone = new DateTimeZone('Europe/Berlin');
    $date_actuelle= new DateTime("",new DateTimeZone('Europe/Berlin'));
    $query="SELECT nom,Debut,Fin FROM " . $wpdb->prefix . "playlistenregistrees_webtv_plugin;";
    $result=$wpdb->get_results($query);
    foreach($result as $res){
        $debut=$res->Debut;
        $fin=$res->Fin;
        $nom=$res->nom;
        if($fin!='' && $debut!=''){
            $date_debut=DateTime::createFromFormat('m/d/Y H:i', $debut,$timezone);
            $date_fin=DateTime::createFromFormat('m/d/Y H:i', $fin,$timezone);

            if($date_actuelle>=$date_fin){
                // echo $date_actuelle->format('m/d/Y H').' et '.$date_fin->format('m/d/Y H');

                $query1="DELETE FROM " . $wpdb->prefix . "playlistenregistrees_webtv_plugin WHERE nom='$nom';";
                $wpdb->query($query1);

            }
        }
        //ON efface les playlists qui sont finies
    }
}

add_action( 'pluginwebtv_eliminer_anciennes_playlists', 'eliminer_anciennes_playlists');
do_action('pluginwebtv_eliminer_anciennes_playlists');

*/

function creer_page_webtv(){
    wp_enqueue_script("playerpagejs",  plugins_url("includes/WEBTV/player_page.js", __FILE__), FALSE);
    wp_localize_script( 'playerpagejs', 'myAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));
   // wp_enqueue_style("webtv_view",plugins_url('assets/css/webtv_view.css',__FILE__) , FALSE);
    wp_enqueue_style("fontapigoogle", 'http://fonts.googleapis.com/css?family=Fjalla+One', FALSE);
    wp_enqueue_style("playerbluemondaycss1", plugins_url("assets/css/jplayer.blue.monday.min.css", __FILE__), FALSE);// gère le css des boutons du player
    wp_enqueue_style("allskincss1", plugins_url("assets/css/skins/_all-skins.min.css", __FILE__), FALSE);
    wp_enqueue_script("jplayerplaylistjs1",  plugins_url("assets/js/dist/jplayer/jplayer.playlist.min.js", __FILE__), FALSE);
    wp_enqueue_script("jqueryjplayerjs1",  plugins_url("assets/js/dist/jplayer/jquery.jplayer.min.js", __FILE__), FALSE);
    wp_enqueue_style("nouveaureglagecustomcss1",plugins_url('assets/css/nouveau_reglage.css',__FILE__) , FALSE);
    require_once('includes/WEBTV/templates/webtv.template.php');

}
add_shortcode('webtvlefil' , 'creer_page_webtv' );
/*
function shortcode_plugin_telecom(){
    wp_enqueue_script("playerpagejs",  plugins_url("admin_webtv_plugin/includes/WEBTV/player_page.js", __FILE__), FALSE);
    wp_localize_script( 'playerpagejs', 'myAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));
    // wp_enqueue_style("webtv_view",plugins_url('assets/css/webtv_view.css',__FILE__) , FALSE);
    wp_enqueue_style("fontapigoogle", 'http://fonts.googleapis.com/css?family=Fjalla+One', FALSE);
    wp_enqueue_style("playrebluemondaycss1", plugins_url("assets/css/jplayer.blue.monday.min.css", __FILE__), FALSE);
    wp_enqueue_style("allskincss1", plugins_url("assets/css/skins/_all-skins.min.css", __FILE__), FALSE);
    wp_enqueue_script("jplayerplaylistjs1",  plugins_url("assets/js/dist/jplayer/jplayer.playlist.min.js", __FILE__), FALSE);
    wp_enqueue_script("jqueryjplayerjs1",  plugins_url("assets/js/dist/jplayer/jquery.jplayer.min.js", __FILE__), FALSE);
    wp_enqueue_style("nouveaureglagecustomcss1",plugins_url('assets/css/nouveau_reglage.css',__FILE__) , FALSE);
    require_once('includes/WEBTV/templates/webtv-telecom.template.php');
}

add_shortcode('webtvtelecom' , 'shortcode_plugin_telecom' );
*/
function chargement_jquery_cdn()
{
    wp_deregister_script('jquery');
    wp_register_script('jquery','http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js', false, '');
    wp_enqueue_script('jquery');
    wp_register_script( 'jquery-ui', '//code.jquery.com/ui/1.11.4/jquery-ui.js', array(), null, false );
    wp_enqueue_script('jquery-ui');
    wp_register_style( 'jquery-uicss', '//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css', array(), null, false );
    wp_enqueue_style('jquery-uicss');
    wp_register_script('bootstrapjs', '//netdna.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js', array(), '3.3.6');
    wp_enqueue_script('bootstrapjs');
    wp_register_script( 'momentjs', '//cdn.jsdelivr.net/momentjs/latest/moment.min.js',FALSE);
    wp_enqueue_script('momentjs');
    wp_register_script( 'loaderjs', 'https://www.gstatic.com/charts/loader.js',FALSE);
    wp_enqueue_script('loaderjs');
    wp_enqueue_style("datatimepickercss", '//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css', FALSE);


}
add_action( 'admin_enqueue_scripts', 'chargement_jquery_cdn' );
add_action( 'wp_enqueue_scripts', 'chargement_jquery_cdn' );



function creation_tables_plugin(){
    global $wpdb;

    $creer_table_album="
CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "album_webtv_plugin` (
    `id` int(255) NOT NULL,
    `album` varchar(255) DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;";

    $alter_table_album=" ALTER TABLE `" . $wpdb->prefix . "album_webtv_plugin`
    ADD UNIQUE (album),
MODIFY `id` int(255) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;";

    $creer_table_annee="
CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "annee_webtv_plugin` (
    `id` int(255) NOT NULL,
    `annee` date DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=48 DEFAULT CHARSET=utf8;";
    $alter_table_annee="ALTER TABLE `" . $wpdb->prefix . "annee_webtv_plugin`
      ADD UNIQUE (annee),
 MODIFY `id` int(255) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=48;";



    $creer_table_artiste="
CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "artiste_webtv_plugin` (
    `id` int(11) NOT NULL,
    `nom` varchar(255) DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=55 DEFAULT CHARSET=utf8;";
    $alter_table_artiste=" ALTER TABLE `" . $wpdb->prefix . "artiste_webtv_plugin`
       ADD UNIQUE (nom),
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=55;
";

    $creer_table_genre="CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "genre_webtv_plugin` (
    `id` int(255) NOT NULL,
    `Genre` varchar(255) DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;";

    $alter_table_genre=" ALTER TABLE `" . $wpdb->prefix . "genre_webtv_plugin`
        ADD UNIQUE (Genre),
 MODIFY `id` int(255) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=34;";


    $creer_table_defaut_playlist="CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "playlist_par_defaut_webtv_plugin` (
    `id` int(255) NOT NULL,
    `titre` varchar(255) NOT NULL,
    `url` varchar(255) NOT NULL,
    `artiste` varchar(255) NOT NULL,
    `genre` varchar(255) NOT NULL,
    `annee` date NOT NULL,
    `album` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";

    $alter_table_defaut_playlist=" ALTER TABLE `" . $wpdb->prefix . "playlist_par_defaut_webtv_plugin`
        ADD UNIQUE (id),
    MODIFY `id` int(255) NOT NULL AUTO_INCREMENT";

    $creer_table_playlist_clip="CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "playlistclip_webtv_plugin` (
    `id` int(255) NOT NULL,
    `titre` varchar(255) NOT NULL,
    `url` varchar(255) NOT NULL,
    `artiste` varchar(255) NOT NULL,
    `genre` varchar(255) NOT NULL,
    `annee` date NOT NULL,
    `album` varchar(255) NOT NULL
    `Debut` varchar(255) DEFAULT '',
    `Fin` varchar(255) DEFAULT '',
    PRIMARY KEY (`nom`)
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8;";


    $creer_table_playlists_enregistrees="CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "playlistenregistrees_webtv_plugin` (
    `nom` varchar(255) NOT NULL,
    `pourcentage_poprock` varchar(255) NOT NULL,
    `pourcentage_rap` varchar(255) NOT NULL,
    `pourcentage_jazzblues` varchar(255) NOT NULL,
    `pourcentage_musiquemonde` varchar(255) NOT NULL,
    `pourcentage_electro` varchar(255) NOT NULL,
    `pourcentage_hardrock` varchar(255) NOT NULL,
    `pourcentage_chanson` varchar(255) NOT NULL,
    `pourcentage_autres` varchar(255) NOT NULL,
    `publicites_internes` varchar(255) DEFAULT '',
    `publicites_externes` varchar(255) DEFAULT '',
    `artiste_highlight` varchar(255) DEFAULT '',
    `annee_max` date DEFAULT '1999-12-31',
    `annee_min` date DEFAULT '0001-01-01',
    `qualite_min` int(11) NOT NULL,
    `Debut` varchar(255) DEFAULT '',
    `Fin` varchar(255) DEFAULT '',
    `ParDefaut` tinyint(1) NOT NULL DEFAULT '0',
    PRIMARY KEY (`nom`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";


    $creer_table_qualite="   CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "qualite_webtv_plugin` (
    `valeur` int(11) NOT NULL,
    PRIMARY KEY (`valeur`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;";
    $alter_table_qualite="   ALTER TABLE `" . $wpdb->prefix . "qualite_webtv_plugin`
    MODIFY `valeur` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;";


    $creer_table_relation="CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "relation_webtv_plugin` (
    `video_id` int(11) NOT NULL,
    `artiste_id` int(11) NOT NULL,
    `genre_id` int(11) NOT NULL,
    `album_id` int(11) NOT NULL,
    `annee_id` int(11) NOT NULL,
    `qualite_id` int(11) NOT NULL,
    PRIMARY KEY (`video_id`,`artiste_id`,`genre_id`,`album_id`,`annee_id`,`qualite_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";

    $alter_table_relation=" ALTER TABLE `" . $wpdb->prefix . "relation_webtv_plugin`

    ADD CONSTRAINT `relation_ibfk_1` FOREIGN KEY (`video_id`) REFERENCES `" . $wpdb->prefix . "videos_webtv_plugin` (`id`) ON DELETE CASCADE,
ADD CONSTRAINT `relation_ibfk_2` FOREIGN KEY (artiste_id) REFERENCES `" . $wpdb->prefix . "artiste_webtv_plugin` (`id`) ON DELETE CASCADE,
ADD CONSTRAINT `relation_ibfk_3` FOREIGN KEY (`genre_id`) REFERENCES `" . $wpdb->prefix . "genre_webtv_plugin` (`id`) ON DELETE CASCADE,
ADD CONSTRAINT `relation_ibfk_4` FOREIGN KEY (`album_id`) REFERENCES `" . $wpdb->prefix . "album_webtv_plugin` (`id`) ON DELETE CASCADE,
ADD CONSTRAINT `relation_ibfk_5` FOREIGN KEY (`annee_id`) REFERENCES `" . $wpdb->prefix . "annee_webtv_plugin` (`id`) ON DELETE CASCADE,
ADD CONSTRAINT `relation_ibfk_6` FOREIGN KEY (`qualite_id`) REFERENCES `" . $wpdb->prefix . "qualite_webtv_plugin` (`valeur`) ON DELETE CASCADE;";


    $creer_table_videos="CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "videos_webtv_plugin` (
    `id` int(255) NOT NULL,
    `titre` varchar(255) NOT NULL,
    `url` varchar(255) NOT NULL,
    PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=55 DEFAULT CHARSET=utf8;
";

// Remplissage des tables genre et qualite

    $alter_table_videos="    ALTER TABLE `" . $wpdb->prefix . "videos_webtv_plugin`
MODIFY `id` int(255) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=55;";


    $remplir_table_genre="INSERT INTO `" . $wpdb->prefix . "genre_webtv_plugin` (`id`, `Genre`) VALUES
    (33, ''),(12, 'Autre'),(8, 'Chanson française'),
    (2, 'Hard-rock & Metal'),
    (3, 'Hip-hop & Reggae'),
    (7, 'Jazz & Blues'),
    (9, 'Musique du monde'),
    (4, 'Musique electronique'),
    (5, 'Pop-rock'),
    (11, 'Publicité Externe'),
    (10, 'Publicité Interne'),
    (13, 'Logo');";

    $remplir_table_qualite="
    INSERT INTO `" . $wpdb->prefix . "qualite_webtv_plugin` (`valeur`) VALUES (1),(2),(3),(4),(5);";

// Creation des tables
    $wpdb->query($creer_table_album);
    $wpdb->query($creer_table_annee);
    $wpdb->query($creer_table_artiste);
    $wpdb->query($creer_table_genre);
    $wpdb->query($creer_table_defaut_playlist);
    $wpdb->query($creer_table_playlists_enregistrees);
    $wpdb->query($creer_table_qualite);
    $wpdb->query($creer_table_relation);
    $wpdb->query($creer_table_videos);
    $wpdb->query($creer_table_playlist_clip);

    $wpdb->query($remplir_table_genre);
    $wpdb->query($remplir_table_qualite);


//Mise en place des clés
    $wpdb->query($alter_table_album);
    $wpdb->query($alter_table_annee);
    $wpdb->query($alter_table_artiste);
    $wpdb->query($alter_table_genre);
    $wpdb->query($alter_table_qualite);
    $wpdb->query($alter_table_videos);
    $wpdb->query($alter_table_relation);
    $wpdb->query($alter_table_defaut_playlist);
}



function pluginwebtv_supprimer_tables(){
    global $wpdb;
    $effacer_table_playlistenregistres="DROP TABLE " . $wpdb->prefix . "playlistenregistrees_webtv_plugin;";
    $effacer_table_album="DROP TABLE " . $wpdb->prefix . "album_webtv_plugin;";
    $effacer_table_annee="DROP TABLE " . $wpdb->prefix . "annee_webtv_plugin;";
    $effacer_table_artiste="DROP TABLE " . $wpdb->prefix . "artiste_webtv_plugin;";
    $effacer_table_playlist="DROP TABLE " . $wpdb->prefix . "playlist_par_defaut_webtv_plugin;";
    $effacer_table_videos="DROP TABLE " . $wpdb->prefix . "videos_webtv_plugin;";
    $effacer_table_qualite="DROP TABLE " . $wpdb->prefix . "qualite_webtv_plugin;";
    $effacer_table_relation="DROP TABLE " . $wpdb->prefix . "relation_webtv_plugin;";
    $effacer_table_playlistclip="DROP TABLE " . $wpdb->prefix . "playlistclip_webtv_plugin;";
    $effacer_table_genre="DROP TABLE " . $wpdb->prefix . "genre_webtv_plugin;";


    $wpdb->query($effacer_table_playlistenregistres);
    $wpdb->query($effacer_table_album);
    $wpdb->query($effacer_table_annee);
    $wpdb->query($effacer_table_artiste);
    $wpdb->query($effacer_table_playlist);
    $wpdb->query($effacer_table_videos);
    $wpdb->query($effacer_table_relation);
    $wpdb->query($effacer_table_videos);
    $wpdb->query($effacer_table_genre);

}



register_activation_hook(__FILE__, 'pluginwebtv_supprimer_tables');
register_activation_hook(__FILE__, 'creation_tables_plugin');


?>
