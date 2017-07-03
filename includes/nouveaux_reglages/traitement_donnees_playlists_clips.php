<?php
/*
*Fonction : Ce fichier permet de traiter les données liées au playlist de clips générer par l'interface nouvelle playlist.
*
*
*/

/*Les add_action permettant de déclarer les fonctions php dans dans tout le dossier Wordpress*/
add_action('wp_ajax_enregistrement_playlist_clips_pourcentage', 'enregistrement_playlist_clips_pourcentage' );

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

  echo("bouh!");

  $query_stocker_info_table_playlistenregistrees = "INSERT INTO " . $wpdb->prefix . "playlistenregistrees_webtv_plugin(nom, pourcentage_poprock, pourcentage_rap, pourcentage_jazzblues, pourcentage_musiquemonde, pourcentage_electro, pourcentage_hardrock, pourcentage_chanson, pourcentage_autres, publicites_internes, publicites_externes, artiste_highlight, Debut, Fin, ParDefaut) VALUES('$nom_reglage','$pourcentage_poprock','$pourcentage_hiphop','$pourcentage_jazzblues','$pourcentage_musique_monde','$pourcentage_electro','$pourcentage_hardrock','$pourcentage_chanson','$pourcentage_autres','$pubs_internes','$pubs_externes','$artiste_en_highlight','$debut','$fin','$par_defaut');";
  $wpdb->query($query_stocker_info_table_playlistenregistrees);
  echo $query_stocker_info_table_playlistenregistrees;
}
?>
