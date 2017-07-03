<?php
/*
*Fonction : Ce fichier permet de traiter les données liées au playlist de clips générer par l'interface nouvelle playlist.
*
*
*/

/*Les add_action permettant de déclarer les fonctions php dans dans tout le dossier Wordpress*/
add_action('wp_ajax_enregistrement_playlist_clips_pourcentage', 'enregistrement_playlist_clips_pourcentage' );
add_action('pluginwebtv_generer_playlist_clips','generer_playlist_clips');

/*
*Fonction : Permet de récupérer les paramètres de la playlist.
*Ensuite on stock ces paramètres dans la table wp_playlistsenregistrees_webtv_plugin
*/
function enregistrement_playlist_clips_pourcentage(){
  global $wpdb;

//Recupère les différentes paramètres issues des balises html de la page index.php dans le dossier nouveaux_reglages.
  if(isset($_POST['nom_reglage'])){$nom_reglage=$_POST['nom_reglage'];}
  if(isset($_POST['pourcentage_poprock'])){$pourcentage_poprock=$_POST['pourcentage_poprock'];}
  if(isset($_POST['pourcentage_hiphop'])){$pourcentage_hiphop=$_POST['pourcentage_hiphop'];}
  if(isset($_POST['pourcentage_jazzblues'])){$pourcentage_jazzblues=$_POST['pourcentage_jazzblues'];}
  if(isset($_POST['pourcentage_musiquemonde'])){$pourcentage_musique_monde=$_POST['pourcentage_musiquemonde'];}
  if(isset($_POST['pourcentage_hardrock'])){$pourcentage_hardrock=$_POST['pourcentage_hardrock'];}
  if(isset($_POST['pourcentage_electro'])){$pourcentage_electro=$_POST['pourcentage_electro'];}
  if(isset($_POST['pourcentage_chanson'])){$pourcentage_chanson=$_POST['pourcentage_chanson'];}
  if(isset($_POST['pourcentage_autres'])){$pourcentage_autres=$_POST['pourcentage_autres'];}
  if(isset( $_POST['pubs_internes'])){$pubs_internes = $_POST['pubs_internes'];}
  if(isset($_POST['pubs_externes'])){$pubs_externes = $_POST['pubs_externes'];}
  if(isset($_POST['artistehighlight'])){$artiste_en_highlight=$_POST['artistehighlight'];}
  if(isset($_POST['date_debut'])){$debut=$_POST['date_debut'];}
  if(isset($_POST['date_fin'])){$fin=$_POST['date_fin'];}
  if(isset($_POST['pardefaut'])){$par_defaut=$_POST['pardefaut'];}


  $query_stocker_info_table_playlistenregistrees = "INSERT INTO " . $wpdb->prefix . "playlistenregistrees_webtv_plugin(nom, pourcentage_poprock, pourcentage_rap, pourcentage_jazzblues, pourcentage_musiquemonde, pourcentage_electro, pourcentage_hardrock, pourcentage_chanson, pourcentage_autres, publicites_internes, publicites_externes, artiste_highlight, Debut, Fin, ParDefaut) VALUES('$nom_reglage','$pourcentage_poprock','$pourcentage_hiphop','$pourcentage_jazzblues','$pourcentage_musique_monde','$pourcentage_electro','$pourcentage_hardrock','$pourcentage_chanson','$pourcentage_autres','$pubs_internes','$pubs_externes','$artiste_en_highlight','$debut','$fin','$par_defaut');";
  $wpdb->query($query_stocker_info_table_playlistenregistrees);

  generer_playlist_clips($nom_reglage);

}

function generer_playlist_clips($nom_playlist_clips){

  global $wpdb;
  global $tab_url;
  global $tab_titres;
  global $tab_genres;
  global $tab_artistes;
  $tableau_dates_debut=array();
  $tableau_dates_fin=array();

  $querydefaut="SELECT * FROM " . $wpdb->prefix . "playlistenregistrees_webtv_plugin WHERE nom='$nom_playlist_clips'";
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
      $annee_max=$resdefaut->annee_max;
      $annee_min=$resdefaut->annee_min;
      $qualite_min=$resdefaut->qualite_min;
          do_action('pluginwebtv_generer_playlist_clips',$poprockdefaut,$hiphopdefaut,$jazzbluesdefaut,$musiquemondedefaut,$hardrockdefaut,$electrodefaut,$chansondefaut,$autresdefaut,$pubsinternesdefaut,$pubsexternesdefaut,$artistehightdefaut,$annee_max,$annee_min,$qualite_min);

  }

}



?>
