<?php


/**************************************************************************************************************************
**
**
**                                 Fonctions php utilisées pour ajouter une vidéo à la base de donnée
**                                                                                                                
**
****************************************************************************************************************************/


add_action('wp_ajax_ajouter_video', 'ajouter_video');

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

 

function ajouter_video(){
    global $wpdb;

    $titre = $_POST['myParams']['titre'];
    $url = $_POST['myParams']['url_video'];
    $artiste = $_POST['myParams']['artiste_video'];
    $genre = $_POST['myParams']['genre'];
    $album = $_POST['myParams']['album'];
    $annee_prod = $_POST['myParams']['annee'];
    $qualite = $_POST['myParams']['qualite'];   

    //echo "Fonction ajouter_video";
    /*$titre = $_POST['myParams']['titre'];
    echo($titre); */

    $video_id=0;
    $artiste_id=0;
    $genre_id=0;
    $album_id=0;
    $annee_id=0;
    $existante="false";
    $is_album="false";
    $is_artiste="false";
    $is_annee="false";

    // Regarde si le titre est existant
    $req_titre="SELECT id, titre, url FROM " . $wpdb->prefix . "videos_webtv_plugin WHERE titre='".$titre."' AND url='".$url."' LIMIT 1;"; 
    $resultat=$wpdb->get_results($req_titre);
    foreach($resultat as $result){
        $existante="true";
    }


    if ($existante=="false")
    {
    	//Remplissage tableau videos_webtv_plugin
    	$maxi = "SELECT max(id) FROM ".$wpdb->prefix."videos_webtv_plugin;"; 
    	$video_id=$wpdb->get_var($maxi);
        $video_id=$video_id+1;
    	$remplir_table_videos="INSERT INTO " . $wpdb->prefix . "videos_webtv_plugin(titre,url) VALUES('$titre','$url');";
    	$wpdb->query($remplir_table_videos);

    	// On détermine les id des autres paramètres

    	$maxial = "SELECT max(id) FROM ".$wpdb->prefix."album_webtv_plugin;"; 
        $album_id=$wpdb->get_var($maxial)+1;
    	$maxian = "SELECT max(id) FROM ".$wpdb->prefix."annee_webtv_plugin;"; 
    	$annee_id=$wpdb->get_var($maxian);
        $annee_id=$annee_id+1;
    	$maxiar = "SELECT max(id) FROM ".$wpdb->prefix."artiste_webtv_plugin;"; 
    	$artiste_id=$wpdb->get_var($maxiar);
        $artiste_id=$artiste_id+1;
    	
   	// Album
    	$req_album="SELECT id FROM " . $wpdb->prefix . "album_webtv_plugin WHERE album='".$album."' LIMIT 1;"; 
    	$resultat=$wpdb->get_results($req_album);
    	foreach($resultat as $result){
        	$album_id = $wpdb->get_var($req_album);
        	$is_album="true";
    	}
    	if ($is_album=="false")
    	{
    		$remplir_table_album="INSERT INTO `" . $wpdb->prefix . "album_webtv_plugin` (`id`, `album`) VALUES (".$album_id.", '".$album."');";
		    $wpdb->query($remplir_table_album);
    	}

    	// Artiste
    	$req_artiste="SELECT id FROM " . $wpdb->prefix . "artiste_webtv_plugin WHERE nom ='".$artiste."' LIMIT 1;"; 
    	$resultat=$wpdb->get_results($req_artiste);
    	foreach($resultat as $result){
        	$artiste_id = $wpdb->get_var($req_artiste);
        	$is_artiste="true";
    	}
    	if ($is_artiste=="false")
    	{
    		$remplir_table_artiste="INSERT INTO `" . $wpdb->prefix . "artiste_webtv_plugin` (`id`, `nom`) VALUES (".$artiste_id.", '".$artiste."');";
		    $wpdb->query($remplir_table_artiste);
    	}

    	// Année
    	$req_annee="SELECT id FROM " . $wpdb->prefix . "annee_webtv_plugin WHERE annee =".$annee_prod." LIMIT 1;"; 
    	$resultat=$wpdb->get_results($req_annee);
    	foreach($resultat as $result){
        	$annee_id = $wpdb->get_var($req_annee);
        	$is_annee="true";
    	}
    	if ($is_annee=="false")
    	{
    		$remplir_table_annee="INSERT INTO `" . $wpdb->prefix . "annee_webtv_plugin` (`id`, `annee`) VALUES (".$annee_id.", '".$annee_prod."');";
		    $wpdb->query($remplir_table_annee);
    	}

    	// Genre
    	$req_genre="SELECT id FROM " . $wpdb->prefix . "genre_webtv_plugin WHERE Genre ='".$genre."' LIMIT 1;"; 
    	$genre_id = $wpdb->get_var($req_genre);
    	
        // Complétion de la table de relation
        $remplir_table_relation="INSERT INTO " . $wpdb->prefix . "relation_webtv_plugin(video_id,artiste_id,genre_id,album_id,annee_id,qualite_id) VALUES ('$video_id','$artiste_id','$genre_id','$album_id','$annee_id','$qualite')";
        $wpdb->query($remplir_table_relation);
    }
    
 
    //echo "Video insérée avec succès";

    echo $existante;
    wp_die();
}



?>


