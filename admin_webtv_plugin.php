<?php
/* Plugin Name: PluginWEBTVFIL
 * Plugin URI: http://prometheearchimonde.net
 * Description: Plugin de l'interface de gestion des playlists pour la webtv du Fil
 * Version: 1.0
 * Author: Equipe Projet Ingénierie WEBTVFil
 * Author URI:
 * License:
 */
if ( ! defined( 'ABSPATH' ) ) exit;
define( 'MY_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );



//do_action('pluginwebtv_maj_playlist_table');
function php_includes(){

    include('includes/GenerationPlaylist.php');
    include('includes/nouveaux_reglages/traitement_donnees.php');
    //include('includes/GestionBDD/gestionbdd-ajax.php');
    include('includes/GestionBDD/tableau_clips_videos/tableau_clips_videos_ajax.php');
}
php_includes();


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
        $pagevalidation=add_plugins_page('My Plugin Page', 'My Plugin', 'read', 'pagevalidation', 'include_pagevalidation');



        add_action('admin_print_styles-' . $page_menu, 'scripts_page_principale');
        add_action('admin_print_styles-'.$gestioncontenu,'scripts_gestion_contenu');
        add_action('admin_print_styles-' .  $page_nouveaux_reglages, 'scripts_nouveaux_reglages');
    }

}

add_action( 'admin_menu', 'plugin_webtvfil' );



function scripts_page_principale(){

		wp_enqueue_script("playerhompagejs",  plugins_url("js/player_homepage.js", __FILE__), FALSE);
    wp_enqueue_script("homepagejs",  plugins_url("js/homepage.js", __FILE__), FALSE);
	wp_enqueue_style("playrebluemondaycss", plugins_url("assets/css/jplayer.blue.monday.min.css", __FILE__), FALSE);
	wp_enqueue_style("allskincss", plugins_url("assets/css/skins/_all-skins.min.css", __FILE__), FALSE);
    wp_enqueue_script("jplayerplaylistjs",  plugins_url("assets/js/dist/jplayer/jplayer.playlist.min.js", __FILE__), FALSE);
    wp_enqueue_script("jqueryjplayerjs",  plugins_url("assets/js/dist/jplayer/jquery.jplayer.min.js", __FILE__), FALSE);
    wp_enqueue_style("nouveaureglagecustomcss",plugins_url('assets/css/nouveau_reglage.css',__FILE__) , FALSE);
}


function scripts_gestion_contenu(){
    wp_register_script("tableau_clips_videosjs",plugins_url('admin_webtv_plugin/includes/GestionBDD/tableau_clips_videos/tableau_clips_videos.js', __FILE__), FALSE);
    wp_enqueue_script('tableau_clips_videosjs');
    wp_register_script( 'bootstrap_multiselectjs',plugins_url('assets/js/dist/bootstrap-multiselect.js',__FILE__),FALSE);
    wp_enqueue_script('bootstrap_multiselectjs');
    wp_enqueue_style("bootstrap_multiselectcss",plugins_url('assets/css/bootstrap-multiselect.css',__FILE__) , FALSE);

}

function scripts_nouveaux_reglages(){

        wp_register_script( 'nouveaureglagejs', plugins_url('js/nouveaux_reglages.js',__FILE__), array(), null, false );

   //Utile pour passer une url vers un fichier javascript en utilisant plugins_url()
    //On accede à l'url passé dans le tableau avec   alert(jsnouveaureglage.jsnouveaureglagepath);
    $translation_array = array(
        //Url à passer
        'jsnouveaureglagepath' => __( plugins_url("includes/page_validation/index.php", __FILE__), 'plugin-domain' ),
        'a_value' => '10'
    );
    wp_localize_script( 'nouveaureglagejs', 'jsnouveaureglage', $translation_array );
    wp_enqueue_script('nouveaureglagejs');
    wp_register_script( 'bootstrap_multiselectjs',plugins_url('assets/js/dist/bootstrap-multiselect.js',__FILE__),FALSE);
    wp_enqueue_script('bootstrap_multiselectjs');
    wp_enqueue_style("bootstrap_multiselectcss",plugins_url('assets/css/bootstrap-multiselect.css',__FILE__) , FALSE);
    wp_enqueue_style("nouveaureglagecustomcss",plugins_url('assets/css/nouveau_reglage.css',__FILE__) , FALSE);
    wp_enqueue_style("timepickercss",plugins_url('assets/css/timepicker.css',__FILE__) , FALSE);
    wp_register_script( 'datetimepickerjs',plugins_url('assets/js/dist/datetimepicker.js',__FILE__),FALSE);
    wp_enqueue_script('datetimepickerjs');
}


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



function creer_page_webtv(){
    wp_enqueue_script("playerpagejs",  plugins_url("js/player_page.js", __FILE__), FALSE);
    wp_localize_script( 'playerpagejs', 'myAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));
   // wp_enqueue_style("webtv_view",plugins_url('assets/css/webtv_view.css',__FILE__) , FALSE);
    wp_enqueue_style("fontapigoogle", 'http://fonts.googleapis.com/css?family=Fjalla+One', FALSE);
    wp_enqueue_style("playrebluemondaycss1", plugins_url("assets/css/jplayer.blue.monday.min.css", __FILE__), FALSE);
    wp_enqueue_style("allskincss1", plugins_url("assets/css/skins/_all-skins.min.css", __FILE__), FALSE);
    wp_enqueue_script("jplayerplaylistjs1",  plugins_url("assets/js/dist/jplayer/jplayer.playlist.min.js", __FILE__), FALSE);
    wp_enqueue_script("jqueryjplayerjs1",  plugins_url("assets/js/dist/jplayer/jquery.jplayer.min.js", __FILE__), FALSE);
    wp_enqueue_style("nouveaureglagecustomcss1",plugins_url('assets/css/nouveau_reglage.css',__FILE__) , FALSE);
    require_once('templates/WEBTV/webtv.template.php');

}
add_shortcode('webtvlefil' , 'creer_page_webtv' );

function shortcode_plugin_telecom(){
    wp_enqueue_script("playerpagejs",  plugins_url("js/player_page.js", __FILE__), FALSE);
    wp_localize_script( 'playerpagejs', 'myAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));
    // wp_enqueue_style("webtv_view",plugins_url('assets/css/webtv_view.css',__FILE__) , FALSE);
    wp_enqueue_style("fontapigoogle", 'http://fonts.googleapis.com/css?family=Fjalla+One', FALSE);
    wp_enqueue_style("playrebluemondaycss1", plugins_url("assets/css/jplayer.blue.monday.min.css", __FILE__), FALSE);
    wp_enqueue_style("allskincss1", plugins_url("assets/css/skins/_all-skins.min.css", __FILE__), FALSE);
    wp_enqueue_script("jplayerplaylistjs1",  plugins_url("assets/js/dist/jplayer/jplayer.playlist.min.js", __FILE__), FALSE);
    wp_enqueue_script("jqueryjplayerjs1",  plugins_url("assets/js/dist/jplayer/jquery.jplayer.min.js", __FILE__), FALSE);
    wp_enqueue_style("nouveaureglagecustomcss1",plugins_url('assets/css/nouveau_reglage.css',__FILE__) , FALSE);
    require_once('templates/WEBTV/webtv-telecom.template.php');
}

add_shortcode('webtvtelecom' , 'shortcode_plugin_telecom' );

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


function gestion_bdd_callback(){

    include('includes/GestionBDD/gestionbdd.php');
}


function include_pagevalidation(){

    require_once('includes/page_validation/index.php');
    //wp_register_script( 'pagerecapitulatifjs', plugins_url('js/page_recapitulatif_reglage.js',__FILE__), array(), null, false );
    //wp_enqueue_script('pagerecapitulatifjs');
}

function callback_menu_webtv(){
   include('includes/page_principale/index.php');
}
function callback_menu_erreur(){
    include('includes/page_principale/erreur.php');

}


// Includes des pages

function reglages_enregistres_callback(){
    require_once('includes/reglages_enregistrees/index.php');

}

function nouveaux_reglages_callback(){

 require_once('includes/nouveaux_reglages/index.php');

}

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
    `annee` varchar(255) DEFAULT NULL,
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


    $creer_table_playlist="CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "playlist_webtv_plugin` (
    `titre` varchar(255) NOT NULL,
    `url` varchar(255) NOT NULL,
    `artiste` varchar(255) NOT NULL
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
    `Debut` varchar(255) DEFAULT '',
    `Fin` varchar(255) DEFAULT '',
    `ParDefaut` tinyint(1) NOT NULL DEFAULT '0',
    PRIMARY KEY (`nom`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";


    $creer_table_qualite="   CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "qualite_webtv_plugin` (
    `valeur` int(255) NOT NULL,
    PRIMARY KEY (`valeur`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;";
    $alter_table_qualite="   ALTER TABLE `" . $wpdb->prefix . "qualite_webtv_plugin`
    MODIFY `valeur` int(255) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;";


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


    $alter_table_videos="    ALTER TABLE `" . $wpdb->prefix . "videos_webtv_plugin`
MODIFY `id` int(255) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=55;";



// Creation des tables
    $wpdb->query($creer_table_album);
    $wpdb->query($creer_table_annee);
    $wpdb->query($creer_table_artiste);
    $wpdb->query($creer_table_genre);
    $wpdb->query($creer_table_playlist);
    $wpdb->query($creer_table_playlists_enregistrees);
    $wpdb->query($creer_table_qualite);
    $wpdb->query($creer_table_relation);
    $wpdb->query($creer_table_videos);


//Mise en place des clés
$wpdb->query($alter_table_album);
    $wpdb->query($alter_table_annee);
    $wpdb->query($alter_table_artiste);
    $wpdb->query($alter_table_genre);
    $wpdb->query($alter_table_qualite);
    $wpdb->query($alter_table_videos);
    $wpdb->query($alter_table_relation);

}
register_activation_hook(__FILE__, 'creation_tables_plugin');


function remplissage_tables(){
global $wpdb;

    $remplir_table_album="
    INSERT INTO `" . $wpdb->prefix . "album_webtv_plugin` (`id`, `album`) VALUES
    (13, ''),
(7, 'Afro Trap'),
(11, 'Be Sensational'),
(3, 'By Your Side'),
(4, 'Discipline'),
(6, 'Ex Umbra In Solem'),
(2, 'La cour des grands'),
(9, 'labour of Love'),
(10, 'Myriam Road'),
(8, 'Rays of Resistance'),
(5, 'Roses'),
(12, 'War Eternal');";

    $remplir_table_annee="
    INSERT INTO `" . $wpdb->prefix . "annee_webtv_plugin` (`id`, `annee`) VALUES
    (37, '1970'),
(10, '1978'),
(16, '1979'),
(23, '1983'),
(24, '1991'),
(38, '1997'),
(47, '1999'),
(2, '2009'),
(3, '2010'),
(4, '2011'),
(5, '2012'),
(6, '2013'),
(7, '2014'),
(8, '2015'),
(9, '2016');";

    $remplir_table_artiste="
    INSERT INTO `" . $wpdb->prefix . "artiste_webtv_plugin` (`id`, `nom`) VALUES
    (38, 'Action Bronson'),
(26, 'AlunaGeorge'),
(2, 'Arch Enemy'),
(22, 'Awa Ly'),
(29, 'Bibio'),
(3, 'Bigflo & Oli'),
(8, 'Breakbot'),
(39, 'Bricc Baby Shitro'),
(15, 'Brigitte'),
(42, 'Buena Vista Social Club'),
(31, 'Cassius'),
(4, 'Club Cheval'),
(5, 'Coeur de Pirate'),
(23, 'Domo Genesis'),
(6, 'ETHS'),
(32, 'FKJ'),
(20, 'Gilberto Gil'),
(24, 'Grems'),
(21, 'Ibrahim Maalouf '),
(14, 'Ijahman Levi '),
(10, 'Jeanne Added'),
(41, 'Jorge Ben'),
(27, 'Kiss '),
(16, 'L.E.J'),
(44, 'La Yegros '),
(18, 'Mac Demarco '),
(28, 'Metallica'),
(11, 'MHD'),
(12, 'Nâaman'),
(7, 'Natacha Atlas'),
(53, 'Nicolas Winding Refn'),
(17, 'Oxmo Puccino '),
(19, 'Para One'),
(25, 'Paradis '),
(33, 'Paul Kalkbrenner '),
(13, 'Pub'),
(46, 'Quantic & Flowering Inferno'),
(51, 'Rage Against the Machine'),
(50, 'Rise Of The Northstars'),
(54, 'Rone'),
(49, 'Royal Blood'),
(34, 'SÃ©bastien Tellier'),
(47, 'Seu Jorge'),
(35, 'Tahiti Boy & The Palmtree Family '),
(36, 'Tame Impala'),
(37, 'Travis Bretzer'),
(9, 'UB40'),
(43, 'Voilaaa');";

    $remplir_table_genre="

    INSERT INTO `" . $wpdb->prefix . "genre_webtv_plugin` (`id`, `Genre`) VALUES
    (33, ''),
(12, 'Autre'),
(8, 'Chanson française'),
(2, 'Hard-rock & Metal\r\n'),
(3, 'Hip-hop & Reggae'),
(7, 'Jazz & Blues'),
(9, 'Musique du monde'),
(4, 'Musique electronique'),
(5, 'Pop-rock'),
(11, 'Publicité Externe'),
(10, 'Publicité Interne');";



    $remplir_table_playlist="
    INSERT INTO `" . $wpdb->prefix . "playlist_webtv_plugin` (`titre`, `url`, `artiste`) VALUES
    ('You Will Know My Name', 'http://www.prometheearchimonde.net/wp-content/uploads/2016/04/ARCH-ENEMY-You-Will-Know-My-Name-OFFICIAL-VIDEO.mp4', 'Arch Enemy'),
('Discipline', 'http://www.prometheearchimonde.net/wp-content/uploads/2016/04/Club-cheval-Discipline-Official-video.mp4', 'Club Cheval'),
('Oublie-moi', 'http://www.prometheearchimonde.net/wp-content/uploads/2016/04/Coeur-de-Pirate-Oublie-moi.mp4', 'Coeur de Pirate'),
('Crucifere', 'http://www.prometheearchimonde.net/wp-content/uploads/2016/04/ETHS-Crucifère.mp4', 'ETHS'),
('Nile', 'http://www.prometheearchimonde.net/wp-content/uploads/2016/04/natacha-atlas.mp4', 'Natacha Atlas'),
('Look at them', 'http://www.prometheearchimonde.net/wp-content/uploads/2016/04/Jeanne-Added-Look-at-them-clip-officiel.mp4', 'Jeanne Added'),
('Afro Trap Part5', 'http://www.prometheearchimonde.net/wp-content/uploads/2016/04/MHD-AFRO-TRAP-Part-5.mp4', 'Nâaman'),
('Jingle Europe 2', 'http://www.prometheearchimonde.net/wp-content/uploads/2016/04/692_4778.mp4', 'Pub'),
('Pub TL7', 'http://www.prometheearchimonde.net/wp-content/uploads/2016/04/PUB-TL7.mp4\n', 'Pub'),
('Jah Heavy Load', 'http://www.prometheearchimonde.net/wp-content/uploads/2016/04/Ijahman-Levi-Jah-Heavy-Load-original-version.mp4', 'Ijahman Levi '),
('A bouche que veux-tu', 'http://www.prometheearchimonde.net/wp-content/uploads/2016/04/Brigitte-A-bouche-que-veux-tu.mp4', 'Brigitte'),
('La dalle', 'http://www.prometheearchimonde.net/wp-content/uploads/2016/04/L.E.J-La-dalle.mp4', 'L.E.J'),
('Slow Life', 'http://www.prometheearchimonde.net/wp-content/uploads/2016/05/Oxmo-Puccino-Slow-Life.mp4', 'Oxmo Puccino '),
('Let her go', 'http://www.prometheearchimonde.net/wp-content/uploads/2016/04/Mac-Demarco-Let-her-go.mp4', 'Mac Demarco '),
('Lean On Me (feat. Teki Latex)', 'http://www.prometheearchimonde.net/wp-content/uploads/2016/04/Para-One-Lean-On-Me-feat.-Teki-Latex.mp4', 'Para One'),
('Toda Menina Bahiana', 'http://www.prometheearchimonde.net/wp-content/uploads/2016/04/Gilberto-Gil-Toda-menina-Bahiana.mp4', 'Gilberto Gil'),
('Will Soon Be a Woman', 'http://www.prometheearchimonde.net/wp-content/uploads/2016/04/Ibrahim-Maalouf-Will-Soon-Be-a-Woman.mp4', 'Ibrahim Maalouf '),
('Let Me Love You ', 'http://www.prometheearchimonde.net/wp-content/uploads/2016/04/AWA-LY-_-Let-Me-Love-You-Official-Vidéo-.mp4', 'Awa Ly'),
('DAPPER feat. Anderson .Paak', 'http://www.prometheearchimonde.net/wp-content/uploads/2016/05/Domo-Genesis-DAPPER-feat.-Anderson-.Paak-2.mp4', 'Domo Genesis'),
('Bruce / Dormir', 'http://www.prometheearchimonde.net/wp-content/uploads/2016/04/GREMS-Bruce-Dormir.mp4', 'Grems'),
('Garde Le Pour Toi', 'http://www.prometheearchimonde.net/wp-content/uploads/2016/04/Paradis-Garde-Le-Pour-Toi.mp4', 'Paradis '),
('I Remember', 'http://www.prometheearchimonde.net/wp-content/uploads/2016/04/AlunaGeorge-I-Remember.mp4', 'AlunaGeorge'),
('Lick It Up', 'http://www.prometheearchimonde.net/wp-content/uploads/2016/04/Kiss-Lick-It-Up.mp4', 'Kiss '),
('Enter Sandman', 'http://www.prometheearchimonde.net/wp-content/uploads/2016/05/Metallica-Enter-Sandman-Official-Music-Video.mp4', 'Metallica');";

    $remplir_table_playlists_enregistrees="INSERT INTO `" . $wpdb->prefix . "playlistenregistrees_webtv_plugin` (`nom`, `pourcentage_poprock`, `pourcentage_rap`, `pourcentage_jazzblues`, `pourcentage_musiquemonde`, `pourcentage_electro`, `pourcentage_hardrock`, `pourcentage_chanson`, `pourcentage_autres`, `publicites_internes`, `publicites_externes`, `artiste_highlight`, `Debut`, `Fin`, `ParDefaut`) VALUES
    ('', '12.5', '12.5', '12.5', '12.5', '12.5', '12.5', '12.5', '12.5', 'undefined', 'Jingle Europe 2', 'Action Bronson', '2016-05-11 21:00', '2016-05-11 22:00', 0),
('ddd', '12.5', '12.5', '12.5', '12.5', '12.5', '12.5', '12.5', '12.5', 'undefined', 'Pub TL7', 'Action Bronson', '2016-05-11 23:00', '2016-05-12 00:00', 0),
('defesszaz', '12.5', '12.5', '12.5', '12.5', '12.5', '12.5', '12.5', '12.5', 'undefined', 'Jingle Europe 2', 'Action Bronson', '2016-05-12 07:00', '2016-05-12 10:00', 0),
('eeee', '12.5', '12.5', '12.5', '12.5', '12.5', '12.5', '12.5', '12.5', 'undefined', 'Jingle Europe 2', 'AlunaGeorge', '2016-05-11 22:00', '2016-05-11 23:00', 0),
('grrr', '12.5', '12.5', '12.5', '12.5', '12.5', '12.5', '12.5', '12.5', 'undefined', 'Pub TL7', 'AlunaGeorge', '2016-05-12 00:00', '2016-05-12 02:00', 0),
('mille', '12.5', '12.5', '12.5', '12.5', '12.5', '12.5', '12.5', '12.5', '', '', '', '', '', 1),
('mmmm\r\n', '12.5', '12.5', '12.5', '12.5', '12.5', '12.5', '12.5', '12.5', 'undefined', 'Jingle Europe 2', 'Action Bronson', '2016-05-11 20:00', '2016-05-11 21:00', 0),
('ttttt', '12.5', '12.5', '12.5', '12.5', '12.5', '12.5', '12.5', '12.5', 'undefined', 'Jingle Europe 2', 'Action Bronson', '2016-05-12 02:00', '2016-05-12 05:00', 0);";

    $remplir_table_qualite="
    INSERT INTO `" . $wpdb->prefix . "qualite_webtv_plugin` (`valeur`) VALUES
    (1),
(2),
(3),
(4),
(5);";

    $remplir_table_relation="    INSERT INTO `" . $wpdb->prefix . "relation_webtv_plugin` (`video_id`, `artiste_id`, `genre_id`, `album_id`, `annee_id`, `qualite_id`) VALUES
    (2, 2, 2, 12, 7, 1),
(12, 3, 3, 2, 8, 1),
(3, 4, 4, 4, 8, 1),
(4, 5, 8, 5, 8, 1),
(8, 7, 7, 10, 8, 1),
(29, 8, 4, 13, 9, 5),
(10, 9, 3, 9, 23, 3),
(11, 10, 5, 11, 8, 1),
(6, 12, 3, 7, 9, 1),
(7, 12, 3, 8, 8, 2),
(1, 13, 11, 2, 8, 2),
(9, 13, 11, 2, 8, 2),
(13, 14, 3, 13, 10, 1),
(14, 15, 5, 13, 7, 5),
(15, 16, 5, 13, 8, 4),
(16, 17, 3, 13, 8, 5),
(17, 18, 5, 13, 7, 5),
(52, 18, 12, 13, 8, 5),
(18, 19, 4, 13, 5, 5),
(19, 20, 9, 13, 16, 4),
(20, 21, 7, 13, 6, 3),
(21, 22, 7, 13, 9, 4),
(22, 23, 3, 13, 9, 5),
(23, 24, 3, 13, 9, 5),
(39, 24, 3, 13, 5, 3),
(24, 25, 4, 13, 7, 4),
(25, 26, 4, 13, 8, 3),
(26, 27, 2, 13, 23, 3),
(27, 28, 2, 13, 24, 4),
(28, 29, 5, 13, 9, 4),
(30, 31, 4, 13, 9, 4),
(31, 32, 4, 13, 7, 5),
(32, 33, 4, 13, 8, 5),
(33, 34, 5, 13, 7, 3),
(34, 35, 5, 13, 8, 4),
(35, 36, 5, 13, 8, 5),
(36, 37, 5, 13, 7, 3),
(37, 38, 3, 13, 8, 4),
(38, 39, 3, 13, 8, 5),
(40, 41, 9, 13, 37, 3),
(41, 42, 9, 13, 38, 3),
(42, 43, 9, 13, 8, 3),
(43, 44, 9, 13, 6, 5),
(44, 44, 9, 13, 6, 4),
(45, 46, 9, 13, 7, 3),
(46, 47, 9, 13, 5, 5),
(47, 47, 9, 13, 5, 5),
(48, 49, 33, 13, 7, 3),
(49, 50, 2, 13, 5, 4),
(51, 51, 2, 13, 47, 5),
(53, 53, 12, 13, 8, 5),
(54, 54, 12, 13, 2, 4);";

    $remplir_table_videos=" INSERT INTO `" . $wpdb->prefix . "videos_webtv_plugin` (`id`, `titre`, `url`) VALUES
    (14, 'A bouche que veux-tu', 'http://www.prometheearchimonde.net/wp-content/uploads/2016/04/Brigitte-A-bouche-que-veux-tu.mp4'),
(30, 'Action (feat. Cat Power & Mike D.) ', 'http://www.prometheearchimonde.net/wp-content/uploads/2016/05/Cassius-Action-ft.-Cat-Power-Mike-D.mp4'),
(6, 'Afro Trap Part5', 'http://www.prometheearchimonde.net/wp-content/uploads/2016/04/MHD-AFRO-TRAP-Part-5.mp4'),
(34, 'All That You Are', 'http://www.prometheearchimonde.net/wp-content/uploads/2016/05/Tahiti-Boy-And-The-Palmtree-Family-ALL-THAT-YOU-ARE-1.mp4'),
(33, 'Aller Vers Le Soleil', 'http://www.prometheearchimonde.net/wp-content/uploads/2016/05/Sebastien-Tellier-Aller-vers-le-soleil-Official-Video.mp4'),
(12, 'Aujourd''hui', 'http://www.prometheearchimonde.net/wp-content/uploads/2016/04/BigfloetOLI.mp4'),
(39, 'Autumn 2.0 (feat. Peshi & Dutchmassive)', 'http://www.prometheearchimonde.net/wp-content/uploads/2016/05/Autumn-2.0-Grems-feat-Peshi-Dutchmassive-prod-Noza.mp4'),
(37, 'Baby Blue (feat. Chance The Rapper)', 'http://www.prometheearchimonde.net/wp-content/uploads/2016/05/Action-Bronson-feat.-Chance-The-Rapper-Baby-Blue-Official-Music-Video-YTMAs.mp4'),
(23, 'Bruce / Dormir', 'http://www.prometheearchimonde.net/wp-content/uploads/2016/04/GREMS-Bruce-Dormir.mp4'),
(46, 'Burguesinha', 'http://www.prometheearchimonde.net/wp-content/uploads/2016/05/Seu-Jorge-Burguesinha.mp4'),
(41, 'Candela', 'http://www.prometheearchimonde.net/wp-content/uploads/2016/05/Buena-Vista-Social-Club-Candela.mp4'),
(44, 'Chicha Roja', 'http://www.prometheearchimonde.net/wp-content/uploads/2016/05/La-Yegros-Chicha-Roja-Official-Video.mp4'),
(5, 'Crucifere', 'http://www.prometheearchimonde.net/wp-content/uploads/2016/04/ETHS-Crucifère.mp4'),
(45, 'Cumbia Sobre el Mar ', 'http://www.prometheearchimonde.net/wp-content/uploads/2016/05/Quantic-Flowering-Inferno-Cumbia-Sobre-el-Mar-2.mp4'),
(22, 'DAPPER feat. Anderson .Paak', 'http://www.prometheearchimonde.net/wp-content/uploads/2016/05/Domo-Genesis-DAPPER-feat.-Anderson-.Paak-2.mp4'),
(49, 'Demonstrating My Saiya Style', 'http://www.prometheearchimonde.net/wp-content/uploads/2016/05/RISE-OF-THE-NORTHSTAR-Demonstrating-My-Saiya-Style-Official.mp4'),
(3, 'Discipline', 'http://www.prometheearchimonde.net/wp-content/uploads/2016/04/Club-cheval-Discipline-Official-video.mp4'),
(27, 'Enter Sandman', 'http://www.prometheearchimonde.net/wp-content/uploads/2016/05/Metallica-Enter-Sandman-Official-Music-Video.mp4'),
(32, 'Feed Your Head', 'http://www.prometheearchimonde.net/wp-content/uploads/2016/05/Paul-Kalkbrenner-Feed-Your-Head-Official-Music-Video.mp4'),
(28, 'Feeling', 'http://www.prometheearchimonde.net/wp-content/uploads/2016/05/Bibio-â€¢-â€˜Feelingâ€™.mp4'),
(24, 'Garde Le Pour Toi', 'http://www.prometheearchimonde.net/wp-content/uploads/2016/04/Paradis-Garde-Le-Pour-Toi.mp4'),
(25, 'I Remember', 'http://www.prometheearchimonde.net/wp-content/uploads/2016/04/AlunaGeorge-I-Remember.mp4'),
(13, 'Jah Heavy Load', 'http://www.prometheearchimonde.net/wp-content/uploads/2016/04/Ijahman-Levi-Jah-Heavy-Load-original-version.mp4'),
(1, 'Jingle Europe 2', 'http://www.prometheearchimonde.net/wp-content/uploads/2016/04/692_4778.mp4'),
(51, 'Know Your Enemy', 'http://www.prometheearchimonde.net/wp-content/uploads/2016/05/Rage-Against-The-Machine-Know-Your-Enemy.mp4'),
(15, 'La dalle', 'http://www.prometheearchimonde.net/wp-content/uploads/2016/04/L.E.J-La-dalle.mp4'),
(18, 'Lean On Me (feat. Teki Latex)', 'http://www.prometheearchimonde.net/wp-content/uploads/2016/04/Para-One-Lean-On-Me-feat.-Teki-Latex.mp4'),
(17, 'Let her go', 'http://www.prometheearchimonde.net/wp-content/uploads/2016/04/Mac-Demarco-Let-her-go.mp4'),
(21, 'Let Me Love You ', 'http://www.prometheearchimonde.net/wp-content/uploads/2016/04/AWA-LY-_-Let-Me-Love-You-Official-Vidéo-.mp4\n\n\n\n'),
(26, 'Lick It Up', 'http://www.prometheearchimonde.net/wp-content/uploads/2016/04/Kiss-Lick-It-Up.mp4'),
(48, 'Little Monster', 'http://www.prometheearchimonde.net/wp-content/uploads/2016/05/Royal-Blood-Little-Monster-Official-Video.mp4'),
(31, 'Live Improvisation', 'http://www.prometheearchimonde.net/wp-content/uploads/2016/05/FKJ-Live-Improvisation-EM-Sessions.mp4'),
(11, 'Look at them', 'http://www.prometheearchimonde.net/wp-content/uploads/2016/04/Jeanne-Added-Look-at-them-clip-officiel.mp4'),
(47, 'Mina Do CondomÃ­nio', 'http://www.prometheearchimonde.net/wp-content/uploads/2016/05/Seu-Jorge-Mina-Do-CondomÃ­nio.mp4'),
(29, 'My Toy', 'http://www.prometheearchimonde.net/wp-content/uploads/2016/05/Breakbot-My-Toy-Official-Music-Video.mp4'),
(8, 'Nile', 'http://www.prometheearchimonde.net/wp-content/uploads/2016/04/natacha-atlas.mp4'),
(54, 'Ofive', 'http://www.prometheearchimonde.net/wp-content/uploads/2016/05/RONE-Interview-OFIVE.mp4'),
(42, 'On te l''avait dit (feat. Pat Kalla)', 'http://www.prometheearchimonde.net/wp-content/uploads/2016/05/Voilaaa-On-te-lavait-dit-Feat.-Pat-Kalla-Official.mp4'),
(4, 'Oublie-moi', 'http://www.prometheearchimonde.net/wp-content/uploads/2016/04/Coeur-de-Pirate-Oublie-moi.mp4'),
(38, 'Piano Cracc', 'http://www.prometheearchimonde.net/wp-content/uploads/2016/05/Bricc-Baby-Shitro-Piano-Cracc-Official-Video.mp4'),
(52, 'Plane & Skateboarding', 'http://www.prometheearchimonde.net/wp-content/uploads/2016/05/Mac-DeMarco-Interview-â€“-Planes-Skateboarding.mp4'),
(36, 'Promises', 'http://www.prometheearchimonde.net/wp-content/uploads/2016/05/Travis-Bretzer-Promises-Official-Video.mp4'),
(9, 'Pub TL7', 'http://www.prometheearchimonde.net/wp-content/uploads/2016/04/PUB-TL7.mp4\n'),
(40, 'Pulo Pulo', 'http://www.prometheearchimonde.net/wp-content/uploads/2016/05/Jorge-Ben-Pulo-Pulo.mp4'),
(10, 'Red Red Wine', 'http://www.prometheearchimonde.net/wp-content/uploads/2016/04/UB40-Red-Red-Wine.mp4'),
(16, 'Slow Life', 'http://www.prometheearchimonde.net/wp-content/uploads/2016/05/Oxmo-Puccino-Slow-Life.mp4'),
(50, 'Sweet Child O'' Mine', 'http://www.prometheearchimonde.net/wp-content/uploads/2016/05/Guns-N-Roses-Sweet-Child-O-Mine.mp4'),
(53, 'The Act of Seeing', 'http://www.prometheearchimonde.net/wp-content/uploads/2016/05/THE-ACT-OF-SEEING-Interview-Nicolas-Winding-Refn-at-Fantastic-Fest.mp4'),
(35, 'The Less I Know The Better', 'http://www.prometheearchimonde.net/wp-content/uploads/2016/05/Tame-Impala-The-Less-I-Know-The-Better.mp4'),
(19, 'Toda Menina Bahiana', 'http://www.prometheearchimonde.net/wp-content/uploads/2016/04/Gilberto-Gil-Toda-menina-Bahiana.mp4'),
(7, 'Turn Me Loose', 'http://www.prometheearchimonde.net/wp-content/uploads/2016/04/Naâman-Turn-Me-Loose-Clip-Officiel.mp4'),
(43, 'Viene de Mi', 'http://www.prometheearchimonde.net/wp-content/uploads/2016/05/La-Yegros-Viene-de-Mi.mp4'),
(20, 'Will Soon Be a Woman', 'http://www.prometheearchimonde.net/wp-content/uploads/2016/04/Ibrahim-Maalouf-Will-Soon-Be-a-Woman.mp4'),
(2, 'You Will Know My Name', 'http://www.prometheearchimonde.net/wp-content/uploads/2016/04/ARCH-ENEMY-You-Will-Know-My-Name-OFFICIAL-VIDEO.mp4');";



    $wpdb->query($remplir_table_album);
    $wpdb->query($remplir_table_annee);
    $wpdb->query($remplir_table_artiste);
    $wpdb->query($remplir_table_genre);
    $wpdb->query($remplir_table_playlist);
    $wpdb->query($remplir_table_playlists_enregistrees);
    $wpdb->query($remplir_table_qualite);
    $wpdb->query($remplir_table_relation);
    $wpdb->query($remplir_table_videos);


}
register_activation_hook(__FILE__, 'remplissage_tables');


function pluginwebtv_supprimer_tables(){
    global $wpdb;
    $effacer_table_playlistenregistres="DROP TABLE " . $wpdb->prefix . "playlistenregistrees_webtv_plugin;";
    $effacer_table_album="DROP TABLE " . $wpdb->prefix . "album_webtv_plugin;";
    $effacer_table_annee="DROP TABLE " . $wpdb->prefix . "annee_webtv_plugin;";
    $effacer_table_artiste="DROP TABLE " . $wpdb->prefix . "artiste_webtv_plugin;";
    $effacer_table_playlist="DROP TABLE " . $wpdb->prefix . "playlist_webtv_plugin;";
    $effacer_table_videos="DROP TABLE " . $wpdb->prefix . "videos_webtv_plugin;";
    $effacer_table_qualite="DROP TABLE " . $wpdb->prefix . "qualite_webtv_plugin;";
    $effacer_table_relation="DROP TABLE " . $wpdb->prefix . "relation_webtv_plugin;";


    $wpdb->query($effacer_table_playlistenregistres);
    $wpdb->query($effacer_table_album);
    $wpdb->query($effacer_table_annee);
    $wpdb->query($effacer_table_artiste);
    $wpdb->query($effacer_table_playlist);
    $wpdb->query($effacer_table_videos);
    $wpdb->query($effacer_table_relation);
    $wpdb->query($effacer_table_videos);

}

register_deactivation_hook( __FILE__, 'pluginwebtv_supprimer_tables' );





function effacer_video_jouee_player(){
 global $wpdb;
   $video_courante= $_POST['videocourante'];
    $query="DELETE FROM " . $wpdb->prefix . "playlist_webtv_plugin WHERE titre='$video_courante';";
    $wpdb->query($query);
}

add_action( 'wp_ajax_effacer_video_jouee_player', 'effacer_video_jouee_player' );

// A COMPLETER POUR METTRE A JOUR EN FONCTION DES PLAYLITS ENREGISTREES PRESENTES QUAND ON LANCE LE PLAYER

function recuperer_videos_player_page_principale() {
    do_action('pluginwebtv_generer_la_playlist');
    global $wpdb;
    $query="SELECT titre,url FROM " . $wpdb->prefix . "playlist_webtv_plugin LIMIT 150;";
    $result=$wpdb->get_results($query);
    wp_send_json_success($result);


}


add_action( 'wp_ajax_recuperer_videos_player_page_principale', 'recuperer_videos_player_page_principale' );
add_action( 'wp_ajax_nopriv_recuperer_videos_player_page_principale', 'recuperer_videos_player_page_principale' );









?>
