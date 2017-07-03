<?php


/**************************************************************************************************************************
**
**
**        	Fichier utile pour calculer la durée d'un clip (et par conséquent d'une playlist), et qui effectue les
**			traitements relatifs à ces durées (annonce des prochains titres, calcul si nécessaire de rajouter des clips à une playlist...) 
**
**
*******************************************************************************************************************************/
/*
Appel des différentes fonctions du programme
*/

//add_action( 'wp_ajax_traitement_infos_nouveaux_reglages', 'traitement_infos_nouveaux_reglages' );
add_action('wp_ajax_recuperer_duree_clip','recuperer_duree_clip');

function recuperer_duree_clip($url_clip, $nom_clip){
    $nom = $nom_clip;
    $url = $url_clip;
    /*
    if(isset($_POST['nom_clip']) && isset($_POST['url_clip'])){
      	$nom_clip=$_POST['nom_clip'];
      	$url_clip=$_POST['url_clip'];
   	} else {
   		wp_die();
   	}
    */
   	$filename = $url;

   	if (strpos($filename, "//"))
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
	echo ($ThisFileInfo['playtime_string']);

/**/
    // wp_send_json_success($duree);
}
