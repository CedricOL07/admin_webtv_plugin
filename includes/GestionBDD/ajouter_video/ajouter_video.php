<?php


/**************************************************************************************************************************
**
**
**                                 Fonctions php utilisées pour ajouter une vidéo à la base de donnée
**                                                                                                                
**
****************************************************************************************************************************/


add_action( 'pluginwebtv_ajouter_video', 'ajouter_video',10,7);

/*
$titre=$_POST['titre'];
$album=$_POST['album'];
$url=$_POST['url'];
$annee_prod=$_POST['annee_prod'];
$artiste=$_POST['artiste'];
$qualite=$_POST['qualite'];
$genre=$_POST['genre'];

do_action('pluginwebtv_ajouter_video', $titre, $album, $url, $annee_prod, $artiste, $qualite, $genre)

// Redirection vers la page de gestion du contenu
//header('Location: gestionbdd.php');
//exit();

*/

if (isset($_POST['myFunction']) && $_POST['myFunction'] != '')
{
 
   ${$_POST['myFunction']}($_POST['myParams']['titre'], 
                            $_POST['myParams']['url_video'], $_POST['myParams']['artiste_video'],
                            $_POST['myParams']['genre'], $_POST['myParams']['album'], 
                            $_POST['myParams']['annee'], $_POST['myParams']['qualite']);
   console.log("Entrée dans ajouter_video.php...");
}
 

function ajouter_video($titre, $url, $artiste, $genre, $album, $annee_prod, $qualite){
    global $wpdb;

    console.log("Fonction ajouter_video");

    $video_id;
    $artiste_id;
    $genre_id;
    $album_id;
    $annee_id;
    $existante=false;
    $is_album=false;
    $is_artiste=false;
    $is_annee=false;

    $titre="SELECT id, titre, url FROM " . $wpdb->prefix . "videos_webtv_plugin WHERE titre='$titre' AND url='$url' ORDER BY RAND() LIMIT 1;"; 
    $resultat=$wpdb->get_results($titre);
    foreach($resultat as $result){
        console.log("Video déjà existante !");
        $existante=true;
    }

    if ($existante==false)
    {
    	//Remplissage tableau videos_webtv_plugin
    	$max = "SELECT max(id) FROM " . $wpdb->prefix . "videos_webtv_plugin;"; 
    	$video_id=$wpdb->get_results($max)+1;
    	$remplir_table_videos=" INSERT INTO `" . $wpdb->prefix . "videos_webtv_plugin` (`id`,`titre`,`url`) VALUES ($video_id, $titre, $url);";
    	$wpdb->query($remplir_table_videos);

    	// On détermine les id des autres paramètres

    	$max = "SELECT max(id) FROM " . $wpdb->prefix . "album_webtv_plugin;"; 
    	$album_id=$wpdb->get_results($max)+1;
    	$max = "SELECT max(id) FROM " . $wpdb->prefix . "annee_webtv_plugin;"; 
    	$annee_id=$wpdb->get_results($max)+1;
    	$max = "SELECT max(id) FROM " . $wpdb->prefix . "artiste_webtv_plugin;"; 
    	$artiste_id=$wpdb->get_results($max)+1;
    	
    	// Album
    	$alb="SELECT id, album FROM " . $wpdb->prefix . "album_webtv_plugin WHERE album='$album' ORDER BY RAND() LIMIT 1;"; 
    	$resultat=$wpdb->get_results($alb);
    	foreach($resultat as $result){
        	$album_id = $result->id;
        	$is_album=true;
    	}
    	if ($is_album==false)
    	{
    		$remplir_table_album="INSERT INTO `" . $wpdb->prefix . "album_webtv_plugin` (`id`, `album`) VALUES ($album_id, $album);";
		    $wpdb->query($remplir_table_album);
    	}

    	// Artiste
    	$art="SELECT id, nom FROM " . $wpdb->prefix . "artiste_webtv_plugin WHERE nom ='$artiste' ORDER BY RAND() LIMIT 1;"; 
    	$resultat=$wpdb->get_results($art);
    	foreach($resultat as $result){
        	$artiste_id = $result->id;
        	$is_artiste=true;
    	}
    	if ($is_artiste==false)
    	{
    		$remplir_table_artiste="INSERT INTO `" . $wpdb->prefix . "artiste_webtv_plugin` (`id`, `nom`) VALUES ($artiste_id, $artiste);";
		    $wpdb->query($remplir_table_artiste);
    	}

    	// Année
    	$ann="SELECT id, annee FROM " . $wpdb->prefix . "annee_webtv_plugin WHERE annee ='$annee' ORDER BY RAND() LIMIT 1;"; 
    	$resultat=$wpdb->get_results($ann);
    	foreach($resultat as $result){
        	$annee_id = $result->id;
        	$is_annee=true;
    	}
    	if ($is_annee==false)
    	{
    		$remplir_table_annee="INSERT INTO `" . $wpdb->prefix . "annee_webtv_plugin` (`id`, `annee`) VALUES ($annee_id, $annee);";
		    $wpdb->query($remplir_table_annee);
    	}

    	// Genre
    	$gen="SELECT id, Genre FROM " . $wpdb->prefix . "genre_webtv_plugin WHERE Genre ='$genre' ORDER BY RAND() LIMIT 1;"; 
    	$resultat=$wpdb->get_results($gen);
    	foreach($resultat as $result){
        	$genre_id = $result->id;
    	}

    }
    

	$remplir_table_relation="INSERT INTO `" . $wpdb->prefix . "relation_webtv_plugin` (`video_id`, `artiste_id`, `genre_id`, `album_id`, `annee_id`, `qualite_id`) VALUES ($video_id, $artiste_id, $genre_id, $album_id, $annee_id, $qualite);";
    $wpdb->query($remplir_table_relation);
    console.log("Video insérée avec succès");

}



?>


