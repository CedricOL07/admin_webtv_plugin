<?php


/**************************************************************************************************************************
**
**
**        	Fichier utile pour calculer la durée d'un clip (et par conséquent d'une playlist), 
**
**
*******************************************************************************************************************************/
/*
Appel des différentes fonctions du programme
*/

//add_action( 'wp_ajax_traitement_infos_nouveaux_reglages', 'traitement_infos_nouveaux_reglages' );
add_action('wp_ajax_recuperer_duree_clip','recuperer_duree_clip');

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
