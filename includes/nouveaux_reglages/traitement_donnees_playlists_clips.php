<?php
/*
*Fonction : Ce fichier permet de traiter les données liées au playlist de clips générer par l'interface nouvelle playlist.
*
*
*/

/*Les add_action permettant de déclarer les fonctions php dans dans tout le dossier Wordpress*/
add_action('wp_ajax_enregistrement_playlist_clips_pourcentage', 'enregistrement_playlist_clips_pourcentage' );
add_action('pluginwebtv_generer_la_playlist_clips','generer_la_playlist_clips');

/*
*Fonction : Permet de récupérer les paramètres de la playlist.
*Ensuite on stock ces paramètres dans la table wp_playlistsenregistrees_webtv_plugin
*/
function enregistrement_playlist_clips_pourcentage(){
  global $wpdb;

//Recupère les différentes paramètres issues des balises html de la page index.php dans le dossier nouveaux_reglages.
  if(isset($_POST['nom_reglage'])){$nom_reglage=$_POST['nom_reglage'];}
  if(isset($_POST['pourcentage_poprock'])){ $pourcentage_poprock=$_POST['pourcentage_poprock'];}
  if(isset($_POST['pourcentage_hiphop'])){ $pourcentage_hiphop=$_POST['pourcentage_hiphop'];}
  if(isset($_POST['pourcentage_jazzblues'])){ $pourcentage_jazzblues=$_POST['pourcentage_jazzblues'];}
  if(isset($_POST['pourcentage_musiquemonde'])){ $pourcentage_musiquemonde=$_POST['pourcentage_musiquemonde'];}
  if(isset($_POST['pourcentage_hardrock'])){ $pourcentage_hardrock=$_POST['pourcentage_hardrock'];}
  if(isset($_POST['pourcentage_electro'])){ $pourcentage_electro=$_POST['pourcentage_electro'];}
  if(isset($_POST['pourcentage_chanson'])){ $pourcentage_chanson=$_POST['pourcentage_chanson'];}
  if(isset($_POST['pourcentage_autres'])){ $pourcentage_autres=$_POST['pourcentage_autres'];}
  if(isset($_POST['pubs_internes'])){ $pubs_internes = $_POST['pubs_internes'];}
  if(isset($_POST['pubs_externes'])){ $pubs_externes = $_POST['pubs_externes'];}
  if(isset($_POST['artistehighlight'])){ $artiste_en_highlight=$_POST['artistehighlight'];}
  if(isset($_POST['annee_min'])){ $annee_min=$_POST['annee_min'];}
  if(isset($_POST['annee_max'])){ $annee_max=$_POST['annee_max'];}
  if(isset($_POST['qualite_min'])){ $qualite_min=$_POST['qualite_min'];}
  if(isset($_POST['date_debut'])){ $debut=$_POST['date_debut'];}
  if(isset($_POST['date_fin'])){ $fin=$_POST['date_fin'];}
  if(isset($_POST['pardefaut'])){ $par_defaut=$_POST['pardefaut'];}


  if ($par_defaut == 0){

    $inserer_nouvelle_playlist="INSERT INTO " . $wpdb->prefix . "playlistenregistrees_webtv_plugin(nom,pourcentage_poprock,pourcentage_rap,pourcentage_jazzblues,pourcentage_musiquemonde, pourcentage_hardrock,pourcentage_electro,pourcentage_chanson,pourcentage_autres,annee_max,annee_min,qualite_min,Debut,Fin,ParDefaut) VALUES('$nom_reglage','$pourcentage_poprock','$pourcentage_hiphop','$pourcentage_jazzblues', '$pourcentage_musiquemonde','$pourcentage_hardrock','$pourcentage_electro','$pourcentage_chanson','$pourcentage_autres','$annee_max','$annee_min','$qualite_min','$debut','$fin','$par_defaut');";

    $select = $wpdb->query($inserer_nouvelle_playlist);

  }

  generer_la_playlist_clips($nom_reglage);
  
}

function generer_la_playlist_clips($nom_playlist){

    global $wpdb;
    global $tab_url;
    global $tab_titres;
    global $tab_genres;
    global $tab_artistes;
    global $tab_durees;
    global $duree_total;

    
    $tableau_dates_debut=array();
    $tableau_dates_fin=array();

    $querydefaut="SELECT * FROM " . $wpdb->prefix . "playlistenregistrees_webtv_plugin WHERE nom='$nom_playlist' LIMIT 1;";
    $resultdefaut=$wpdb->get_results($querydefaut);
    foreach($resultdefaut as $resdefaut){
        $nomdefaut =$resdefaut->nom;
        //NULL si case vide
        $artistehightdefaut=$resdefaut->artiste_highlight;
        $pubsinternesdefaut=$resdefaut->publicites_internes;
        $pubsexternesdefaut=$resdefaut->publicites_externes;
        $poprockdefaut=$resdefaut->pourcentage_poprock;
        $hiphopdefaut=$resdefaut->pourcentage_rap;
        $jazzbluesdefaut=$resdefaut->pourcentage_jazzblues;
        $musiquemondedefaut=$resdefaut->pourcentage_musiquemonde;
        $electrodefaut=$resdefaut->pourcentage_electro;
        $hardrockdefaut=$resdefaut->pourcentage_hardrock;
        $chansondefaut=$resdefaut->pourcentage_chanson;
        $autresdefaut=$resdefaut->pourcentage_autres;
        $amax=$resdefaut->annee_max;
        $amin=$resdefaut->annee_min;
        $qmin=$resdefaut->qualite_min;

        $debut = $resdefaut->Debut;
        $fin = $resdefaut->Fin;

        do_action('pluginwebtv_generer_playlist_clips',$poprockdefaut,$hiphopdefaut,$jazzbluesdefaut,$musiquemondedefaut,$hardrockdefaut,$electrodefaut,$chansondefaut,$autresdefaut,$pubsinternesdefaut,$pubsexternesdefaut,$artistehightdefaut,$amax,$amin,$qmin,$debut);

    }
    
    echo ($tab_artistes[0].$tab_artistes[1]." = ".$tab_durees[1]." - ".$tab_durees[2]." - ".$tab_durees[3]." - ".$tab_durees[4]." - ".$tab_durees[5]." - ".$tab_durees[0]." - ");


    
    //$heure_fin = $debut

/*
    $ajouter_fin ="INSERT INTO " . $wpdb->prefix . "playlistclip_webtv_plugin (Fin) VALUES ($heure_fin);";
    $wpdb->query($effacer_existant);


    //$tab_glob1=array();
    //On met tout ca dans la table Playlist
    $titre=str_replace("'","''",$tab_titres);
    $artistes=str_replace("'","''",$tab_artistes);
    $genres=str_replace("'","''",$tab_genres);
    $annees=str_replace("'","''",$tab_annees);
    $album=str_replace("'","''",$tab_album);

    // permet de générer le nombre de clips à générer dans la table playlist_par_defaut_webtv_plugin
    for($k=0;$k<12;$k++){ // remettre sizeof($titre) une fois pb résolu.

        $inserer="INSERT INTO " . $wpdb->prefix . "playlist_par_defaut_webtv_plugin(titre,url,artiste,genre,annee,album) VALUES('$titre[$k]','$tab_url[$k]','$artistes[$k]','$genres[$k]','$annees[$k]', '$album[$k]')";
        $wpdb->query($inserer);
    }
*/
}



?>
