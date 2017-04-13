<?php
add_action('wp_ajax_recuperer_playlists', 'recuperer_playlists' );
add_action('wp_ajax_supprimer_palylists','supprimer_playlists');


function recuperer_playlists(){

  global $wpdb;

  $query="SELECT * FROM ".$wpdb->prefix. "playlistenregistrees_webtv_plugin";
  $tab_id=$wpdb->get_results($query);
  $resultats=array();

  foreach ($tab_id as $row) {
    $nom=$row->nom;
	$pourcentage_poprock=$row->pourcentage_poprock;
	$pourcentage_rap=$row->pourcentage_rap;
	$pourcentage_jazzblues=$row->pourcentage_jazzblues;
	$pourcentage_musiquemonde=$row->pourcentage_musiquemonde;
	$pourcentage_electro=$row->pourcentage_electro;
	$pourcentage_hardrock=$row->pourcentage_hardrock;
    $pourcentage_chanson=$row->pourcentage_chanson;
	$pourcentage_autres=$row->pourcentage_autres;

   

  $resultats[]= array("titre"=>$nom,"poprock"=>$pourcentage_poprock,"rap"=>$pourcentage_rap,"jazzblues"=>$pourcentage_jazzblues,"musiquemonde"=>$pourcentage_musiquemonde,"electro"=>$pourcentage_electro,"hardrock"=>$pourcentage_hardrock,"chanson"=>$pourcentage_chanson,"autres"=>$pourcentage_autres);
  }
  

  // Envoi des résultats sous JSON
  echo json_encode($resultats);
  // libération de la base de données
  wp_die();
};

function supprimer_playlists(){
  //A faire : Prise en compte d'entrée multiples (plusieurs titres avec le meme artiste, meme année etc.)
  global $wpdb;
  if(isset($_POST['data'])){
    $data=$_POST['data'];
	echo $data;
	
    foreach($data as $valeurs){
	
	$nom=$valeurs['nom'];
	
     
      //Suppression de la base de données
      $wpdb->query("DELETE FROM ".$wpdb->prefix. "playlistenregistrees_webtv_plugin WHERE nom='$nom';");
      
  }
  echo "SUCCESS";
  }
  else echo "FAILED";
  wp_die();
};

 ?>