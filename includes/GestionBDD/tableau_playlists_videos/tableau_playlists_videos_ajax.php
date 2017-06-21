<?php
add_action('wp_ajax_recuperer_playlists', 'recuperer_playlists' );
add_action('wp_ajax_supprimer_playlists','supprimer_playlists');
add_action('wp_ajax_dynamic_updates','dynamic_updates');


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

function dynamic_updates(){
  global $wpdb;
  $champ=$_POST['data']["champ"];
  echo $champ;
  
  switch($champ){

    case "pourcentage_poprock":
	  $avant=$_POST['data']["avant"];
      $titre=$_POST['data']["titre"];
      $i=$_POST['data']["P"];
      $rap=$wpdb->get_var("SELECT pourcentage_rap FROM " . $wpdb->prefix . "playlistenregistrees_webtv_plugin WHERE nom='$titre';");
	  $raps=round(($rap - (($rap/(100-$avant))*($i - $avant))),2);
      $jazzblues=$wpdb->get_var("SELECT pourcentage_jazzblues FROM " .$wpdb->prefix . "playlistenregistrees_webtv_plugin WHERE nom='$titre';");
	  $jazzbluess=round(($jazzblues - (($jazzblues/(100-$avant))*($i - $avant))),2);
	  
	  $musiquemonde=$wpdb->get_var("SELECT pourcentage_musiquemonde FROM " . $wpdb->prefix . "playlistenregistrees_webtv_plugin WHERE nom='$titre';");
	  $musiquemondes=round(($musiquemonde - (($musiquemonde/(100-$avant))*($i - $avant))),2);
	  
      $electro=$wpdb->get_var("SELECT pourcentage_electro FROM " .$wpdb->prefix . "playlistenregistrees_webtv_plugin WHERE nom='$titre';");
	  $electros=round(($electro - (($electro/(100-$avant))*($i - $avant))),2);
	  
	  $hardrock=$wpdb->get_var("SELECT pourcentage_hardrock FROM " . $wpdb->prefix . "playlistenregistrees_webtv_plugin WHERE nom='$titre';");
	  $hardrocks=round(($hardrock - (($hardrock/(100-$avant))*($i - $avant))),2);
	  
      $chanson=$wpdb->get_var("SELECT pourcentage_chanson FROM " .$wpdb->prefix . "playlistenregistrees_webtv_plugin WHERE nom='$titre';");
	  $chansons=round(($chanson - (($chanson/(100-$avant))*($i - $avant))),2);
	  
	  $autres=$wpdb->get_var("SELECT pourcentage_autres FROM " .$wpdb->prefix . "playlistenregistrees_webtv_plugin WHERE nom='$titre';");
	  $autress=round(($autres - (($autres/(100-$avant))*($i - $avant))),2);
	  

      $wpdb->query("UPDATE ".$wpdb->prefix. "playlistenregistrees_webtv_plugin SET pourcentage_poprock='$i' WHERE pourcentage_poprock='$avant';");
	  $wpdb->query("UPDATE ".$wpdb->prefix. "playlistenregistrees_webtv_plugin SET pourcentage_rap='$raps' WHERE pourcentage_rap='$rap';");
	  $wpdb->query("UPDATE ".$wpdb->prefix. "playlistenregistrees_webtv_plugin SET pourcentage_jazzblues='$jazzbluess' WHERE pourcentage_jazzblues='$jazzblues';");
	  $wpdb->query("UPDATE ".$wpdb->prefix. "playlistenregistrees_webtv_plugin SET pourcentage_musiquemonde='$musiquemondes' WHERE pourcentage_musiquemonde='$musiquemonde';");
	  $wpdb->query("UPDATE ".$wpdb->prefix. "playlistenregistrees_webtv_plugin SET pourcentage_electro='$electros' WHERE pourcentage_electro='$electro';");
	  $wpdb->query("UPDATE ".$wpdb->prefix. "playlistenregistrees_webtv_plugin SET pourcentage_hardrock='$hardrocks' WHERE pourcentage_hardrock='$hardrock';");
	  $wpdb->query("UPDATE ".$wpdb->prefix. "playlistenregistrees_webtv_plugin SET pourcentage_chanson='$chansons' WHERE pourcentage_chanson='$chanson';");
	  $wpdb->query("UPDATE ".$wpdb->prefix. "playlistenregistrees_webtv_plugin SET pourcentage_autres='$autress' WHERE pourcentage_autres='$autres';");
      break;
    case "pourcentage_rap":
	  $avant=$_POST['data']["avant"];
      $titre=$_POST['data']["titre"];
      $i=$_POST['data']["R"];
      $poprock=$wpdb->get_var("SELECT pourcentage_poprock FROM " . $wpdb->prefix . "playlistenregistrees_webtv_plugin WHERE nom='$titre';");
	  $poprocks=round(($poprock - (($poprock/(100-$avant))*($i - $avant))),2);
      $jazzblues=$wpdb->get_var("SELECT pourcentage_jazzblues FROM " .$wpdb->prefix . "playlistenregistrees_webtv_plugin WHERE nom='$titre';");
	  $jazzbluess=round(($jazzblues - (($jazzblues/(100-$avant))*($i - $avant))),2);
	  
	  $musiquemonde=$wpdb->get_var("SELECT pourcentage_musiquemonde FROM " . $wpdb->prefix . "playlistenregistrees_webtv_plugin WHERE nom='$titre';");
	  $musiquemondes=round(($musiquemonde - (($musiquemonde/(100-$avant))*($i - $avant))),2);
	  
      $electro=$wpdb->get_var("SELECT pourcentage_electro FROM " .$wpdb->prefix . "playlistenregistrees_webtv_plugin WHERE nom='$titre';");
	  $electros=round(($electro - (($electro/(100-$avant))*($i - $avant))),2);
	  
	  $hardrock=$wpdb->get_var("SELECT pourcentage_hardrock FROM " . $wpdb->prefix . "playlistenregistrees_webtv_plugin WHERE nom='$titre';");
	  $hardrocks=round(($hardrock - (($hardrock/(100-$avant))*($i - $avant))),2);
	  
      $chanson=$wpdb->get_var("SELECT pourcentage_chanson FROM " .$wpdb->prefix . "playlistenregistrees_webtv_plugin WHERE nom='$titre';");
	  $chansons=round(($chanson - (($chanson/(100-$avant))*($i - $avant))),2);
	  
	  $autres=$wpdb->get_var("SELECT pourcentage_autres FROM " .$wpdb->prefix . "playlistenregistrees_webtv_plugin WHERE nom='$titre';");
	  $autress=round(($autres - (($autres/(100-$avant))*($i - $avant))),2);
	  

      $wpdb->query("UPDATE ".$wpdb->prefix. "playlistenregistrees_webtv_plugin SET pourcentage_poprock='$poprocks' WHERE pourcentage_poprock='$poprock';");
	  $wpdb->query("UPDATE ".$wpdb->prefix. "playlistenregistrees_webtv_plugin SET pourcentage_rap='$i' WHERE pourcentage_rap='$avant';");
	  $wpdb->query("UPDATE ".$wpdb->prefix. "playlistenregistrees_webtv_plugin SET pourcentage_jazzblues='$jazzbluess' WHERE pourcentage_jazzblues='$jazzblues';");
	  $wpdb->query("UPDATE ".$wpdb->prefix. "playlistenregistrees_webtv_plugin SET pourcentage_musiquemonde='$musiquemondes' WHERE pourcentage_musiquemonde='$musiquemonde';");
	  $wpdb->query("UPDATE ".$wpdb->prefix. "playlistenregistrees_webtv_plugin SET pourcentage_electro='$electros' WHERE pourcentage_electro='$electro';");
	  $wpdb->query("UPDATE ".$wpdb->prefix. "playlistenregistrees_webtv_plugin SET pourcentage_hardrock='$hardrocks' WHERE pourcentage_hardrock='$hardrock';");
	  $wpdb->query("UPDATE ".$wpdb->prefix. "playlistenregistrees_webtv_plugin SET pourcentage_chanson='$chansons' WHERE pourcentage_chanson='$chanson';");
	  $wpdb->query("UPDATE ".$wpdb->prefix. "playlistenregistrees_webtv_plugin SET pourcentage_autres='$autress' WHERE pourcentage_autres='$autres';");
      break;
	  
	case "pourcentage_jazzblues":
	  $avant=$_POST['data']["avant"];
      $titre=$_POST['data']["titre"];
      $i=$_POST['data']["J"];
      $rap=$wpdb->get_var("SELECT pourcentage_rap FROM " . $wpdb->prefix . "playlistenregistrees_webtv_plugin WHERE nom='$titre';");
	  $raps=round(($rap - (($rap/(100-$avant))*($i - $avant))),2);
      $poprock=$wpdb->get_var("SELECT pourcentage_poprock FROM " .$wpdb->prefix . "playlistenregistrees_webtv_plugin WHERE nom='$titre';");
	  $poprocks=round(($poprock - (($poprock/(100-$avant))*($i - $avant))),2);
	  
	  $musiquemonde=$wpdb->get_var("SELECT pourcentage_musiquemonde FROM " . $wpdb->prefix . "playlistenregistrees_webtv_plugin WHERE nom='$titre';");
	  $musiquemondes=round(($musiquemonde - (($musiquemonde/(100-$avant))*($i - $avant))),2);
	  
      $electro=$wpdb->get_var("SELECT pourcentage_electro FROM " .$wpdb->prefix . "playlistenregistrees_webtv_plugin WHERE nom='$titre';");
	  $electros=round(($electro - (($electro/(100-$avant))*($i - $avant))),2);
	  
	  $hardrock=$wpdb->get_var("SELECT pourcentage_hardrock FROM " . $wpdb->prefix . "playlistenregistrees_webtv_plugin WHERE nom='$titre';");
	  $hardrocks=round(($hardrock - (($hardrock/(100-$avant))*($i - $avant))),2);
	  
      $chanson=$wpdb->get_var("SELECT pourcentage_chanson FROM " .$wpdb->prefix . "playlistenregistrees_webtv_plugin WHERE nom='$titre';");
	  $chansons=round(($chanson - (($chanson/(100-$avant))*($i - $avant))),2);
	  
	  $autres=$wpdb->get_var("SELECT pourcentage_autres FROM " .$wpdb->prefix . "playlistenregistrees_webtv_plugin WHERE nom='$titre';");
	  $autress=round(($autres - (($autres/(100-$avant))*($i - $avant))),2);
	  

      $wpdb->query("UPDATE ".$wpdb->prefix. "playlistenregistrees_webtv_plugin SET pourcentage_poprock='$poprocks' WHERE pourcentage_poprock='$poprock';");
	  $wpdb->query("UPDATE ".$wpdb->prefix. "playlistenregistrees_webtv_plugin SET pourcentage_rap='$raps' WHERE pourcentage_rap='$rap';");
	  $wpdb->query("UPDATE ".$wpdb->prefix. "playlistenregistrees_webtv_plugin SET pourcentage_jazzblues='$i' WHERE pourcentage_jazzblues='$avant';");
	  $wpdb->query("UPDATE ".$wpdb->prefix. "playlistenregistrees_webtv_plugin SET pourcentage_musiquemonde='$musiquemondes' WHERE pourcentage_musiquemonde='$musiquemonde';");
	  $wpdb->query("UPDATE ".$wpdb->prefix. "playlistenregistrees_webtv_plugin SET pourcentage_electro='$electros' WHERE pourcentage_electro='$electro';");
	  $wpdb->query("UPDATE ".$wpdb->prefix. "playlistenregistrees_webtv_plugin SET pourcentage_hardrock='$hardrocks' WHERE pourcentage_hardrock='$hardrock';");
	  $wpdb->query("UPDATE ".$wpdb->prefix. "playlistenregistrees_webtv_plugin SET pourcentage_chanson='$chansons' WHERE pourcentage_chanson='$chanson';");
	  $wpdb->query("UPDATE ".$wpdb->prefix. "playlistenregistrees_webtv_plugin SET pourcentage_autres='$autress' WHERE pourcentage_autres='$autres';");
      break;
	  
	case "pourcentage_musiquemonde":
	  $avant=$_POST['data']["avant"];
      $titre=$_POST['data']["titre"];
      $i=$_POST['data']["M"];
      $rap=$wpdb->get_var("SELECT pourcentage_rap FROM " . $wpdb->prefix . "playlistenregistrees_webtv_plugin WHERE nom='$titre';");
	  $raps=round(($rap - (($rap/(100-$avant))*($i - $avant))),2);
      $jazzblues=$wpdb->get_var("SELECT pourcentage_jazzblues FROM " .$wpdb->prefix . "playlistenregistrees_webtv_plugin WHERE nom='$titre';");
	  $jazzbluess=round(($jazzblues - (($jazzblues/(100-$avant))*($i - $avant))),2);
	  
	  $poprock=$wpdb->get_var("SELECT pourcentage_poprock FROM " . $wpdb->prefix . "playlistenregistrees_webtv_plugin WHERE nom='$titre';");
	  $poprocks=round(($poprock - (($poprock/(100-$avant))*($i - $avant))),2);
	  
      $electro=$wpdb->get_var("SELECT pourcentage_electro FROM " .$wpdb->prefix . "playlistenregistrees_webtv_plugin WHERE nom='$titre';");
	  $electros=round(($electro - (($electro/(100-$avant))*($i - $avant))),2);
	  
	  $hardrock=$wpdb->get_var("SELECT pourcentage_hardrock FROM " . $wpdb->prefix . "playlistenregistrees_webtv_plugin WHERE nom='$titre';");
	  $hardrocks=round(($hardrock - (($hardrock/(100-$avant))*($i - $avant))),2);
	  
      $chanson=$wpdb->get_var("SELECT pourcentage_chanson FROM " .$wpdb->prefix . "playlistenregistrees_webtv_plugin WHERE nom='$titre';");
	  $chansons=round(($chanson - (($chanson/(100-$avant))*($i - $avant))),2);
	  
	  $autres=$wpdb->get_var("SELECT pourcentage_autres FROM " .$wpdb->prefix . "playlistenregistrees_webtv_plugin WHERE nom='$titre';");
	  $autress=round(($autres - (($autres/(100-$avant))*($i - $avant))),2);
	  

      $wpdb->query("UPDATE ".$wpdb->prefix. "playlistenregistrees_webtv_plugin SET pourcentage_poprock='$poprocks' WHERE pourcentage_poprock='$poprock';");
	  $wpdb->query("UPDATE ".$wpdb->prefix. "playlistenregistrees_webtv_plugin SET pourcentage_rap='$raps' WHERE pourcentage_rap='$rap';");
	  $wpdb->query("UPDATE ".$wpdb->prefix. "playlistenregistrees_webtv_plugin SET pourcentage_jazzblues='$jazzbluess' WHERE pourcentage_jazzblues='$jazzblues';");
	  $wpdb->query("UPDATE ".$wpdb->prefix. "playlistenregistrees_webtv_plugin SET pourcentage_musiquemonde='$i' WHERE pourcentage_musiquemonde='$avant';");
	  $wpdb->query("UPDATE ".$wpdb->prefix. "playlistenregistrees_webtv_plugin SET pourcentage_electro='$electros' WHERE pourcentage_electro='$electro';");
	  $wpdb->query("UPDATE ".$wpdb->prefix. "playlistenregistrees_webtv_plugin SET pourcentage_hardrock='$hardrocks' WHERE pourcentage_hardrock='$hardrock';");
	  $wpdb->query("UPDATE ".$wpdb->prefix. "playlistenregistrees_webtv_plugin SET pourcentage_chanson='$chansons' WHERE pourcentage_chanson='$chanson';");
	  $wpdb->query("UPDATE ".$wpdb->prefix. "playlistenregistrees_webtv_plugin SET pourcentage_autres='$autress' WHERE pourcentage_autres='$autres';");
      break;
	  
	case "pourcentage_electro":
	  $avant=$_POST['data']["avant"];
      $titre=$_POST['data']["titre"];
      $i=$_POST['data']["E"];
      $rap=$wpdb->get_var("SELECT pourcentage_rap FROM " . $wpdb->prefix . "playlistenregistrees_webtv_plugin WHERE nom='$titre';");
	  $raps=round(($rap - (($rap/(100-$avant))*($i - $avant))),2);
      $jazzblues=$wpdb->get_var("SELECT pourcentage_jazzblues FROM " .$wpdb->prefix . "playlistenregistrees_webtv_plugin WHERE nom='$titre';");
	  $jazzbluess=round(($jazzblues - (($jazzblues/(100-$avant))*($i - $avant))),2);
	  
	  $musiquemonde=$wpdb->get_var("SELECT pourcentage_musiquemonde FROM " . $wpdb->prefix . "playlistenregistrees_webtv_plugin WHERE nom='$titre';");
	  $musiquemondes=round(($musiquemonde - (($musiquemonde/(100-$avant))*($i - $avant))),2);
	  
      $poprock=$wpdb->get_var("SELECT pourcentage_poprock FROM " .$wpdb->prefix . "playlistenregistrees_webtv_plugin WHERE nom='$titre';");
	  $poprocks=round(($poprock - (($poprock/(100-$avant))*($i - $avant))),2);
	  
	  $hardrock=$wpdb->get_var("SELECT pourcentage_hardrock FROM " . $wpdb->prefix . "playlistenregistrees_webtv_plugin WHERE nom='$titre';");
	  $hardrocks=round(($hardrock - (($hardrock/(100-$avant))*($i - $avant))),2);
	  
      $chanson=$wpdb->get_var("SELECT pourcentage_chanson FROM " .$wpdb->prefix . "playlistenregistrees_webtv_plugin WHERE nom='$titre';");
	  $chansons=round(($chanson - (($chanson/(100-$avant))*($i - $avant))),2);
	  
	  $autres=$wpdb->get_var("SELECT pourcentage_autres FROM " .$wpdb->prefix . "playlistenregistrees_webtv_plugin WHERE nom='$titre';");
	  $autress=round(($autres - (($autres/(100-$avant))*($i - $avant))),2);
	  

      $wpdb->query("UPDATE ".$wpdb->prefix. "playlistenregistrees_webtv_plugin SET pourcentage_poprock='$poprocks' WHERE pourcentage_poprock='$poprock';");
	  $wpdb->query("UPDATE ".$wpdb->prefix. "playlistenregistrees_webtv_plugin SET pourcentage_rap='$raps' WHERE pourcentage_rap='$rap';");
	  $wpdb->query("UPDATE ".$wpdb->prefix. "playlistenregistrees_webtv_plugin SET pourcentage_jazzblues='$jazzbluess' WHERE pourcentage_jazzblues='$jazzblues';");
	  $wpdb->query("UPDATE ".$wpdb->prefix. "playlistenregistrees_webtv_plugin SET pourcentage_musiquemonde='$musiquemondes' WHERE pourcentage_musiquemonde='$musiquemonde';");
	  $wpdb->query("UPDATE ".$wpdb->prefix. "playlistenregistrees_webtv_plugin SET pourcentage_electro='$i' WHERE pourcentage_electro='$avant';");
	  $wpdb->query("UPDATE ".$wpdb->prefix. "playlistenregistrees_webtv_plugin SET pourcentage_hardrock='$hardrocks' WHERE pourcentage_hardrock='$hardrock';");
	  $wpdb->query("UPDATE ".$wpdb->prefix. "playlistenregistrees_webtv_plugin SET pourcentage_chanson='$chansons' WHERE pourcentage_chanson='$chanson';");
	  $wpdb->query("UPDATE ".$wpdb->prefix. "playlistenregistrees_webtv_plugin SET pourcentage_autres='$autress' WHERE pourcentage_autres='$autres';");
      break;
	  
	case "pourcentage_hardrock":
	  $avant=$_POST['data']["avant"];
      $titre=$_POST['data']["titre"];
      $i=$_POST['data']["H"];
      $rap=$wpdb->get_var("SELECT pourcentage_rap FROM " . $wpdb->prefix . "playlistenregistrees_webtv_plugin WHERE nom='$titre';");
	  $raps=round(($rap - (($rap/(100-$avant))*($i - $avant))),2);
      $jazzblues=$wpdb->get_var("SELECT pourcentage_jazzblues FROM " .$wpdb->prefix . "playlistenregistrees_webtv_plugin WHERE nom='$titre';");
	  $jazzbluess=round(($jazzblues - (($jazzblues/(100-$avant))*($i - $avant))),2);
	  
	  $musiquemonde=$wpdb->get_var("SELECT pourcentage_musiquemonde FROM " . $wpdb->prefix . "playlistenregistrees_webtv_plugin WHERE nom='$titre';");
	  $musiquemondes=round(($musiquemonde - (($musiquemonde/(100-$avant))*($i - $avant))),2);
	  
      $electro=$wpdb->get_var("SELECT pourcentage_electro FROM " .$wpdb->prefix . "playlistenregistrees_webtv_plugin WHERE nom='$titre';");
	  $electros=round(($electro - (($electro/(100-$avant))*($i - $avant))),2);
	  
	  $poprock=$wpdb->get_var("SELECT pourcentage_poprock FROM " . $wpdb->prefix . "playlistenregistrees_webtv_plugin WHERE nom='$titre';");
	  $poprocks=round(($poprock - (($poprock/(100-$avant))*($i - $avant))),2);
	  
      $chanson=$wpdb->get_var("SELECT pourcentage_chanson FROM " .$wpdb->prefix . "playlistenregistrees_webtv_plugin WHERE nom='$titre';");
	  $chansons=round(($chanson - (($chanson/(100-$avant))*($i - $avant))),2);
	  
	  $autres=$wpdb->get_var("SELECT pourcentage_autres FROM " .$wpdb->prefix . "playlistenregistrees_webtv_plugin WHERE nom='$titre';");
	  $autress=round(($autres - (($autres/(100-$avant))*($i - $avant))),2);
	  

      $wpdb->query("UPDATE ".$wpdb->prefix. "playlistenregistrees_webtv_plugin SET pourcentage_poprock='$poprocks' WHERE pourcentage_poprock='$poprock';");
	  $wpdb->query("UPDATE ".$wpdb->prefix. "playlistenregistrees_webtv_plugin SET pourcentage_rap='$raps' WHERE pourcentage_rap='$rap';");
	  $wpdb->query("UPDATE ".$wpdb->prefix. "playlistenregistrees_webtv_plugin SET pourcentage_jazzblues='$jazzbluess' WHERE pourcentage_jazzblues='$jazzblues';");
	  $wpdb->query("UPDATE ".$wpdb->prefix. "playlistenregistrees_webtv_plugin SET pourcentage_musiquemonde='$musiquemondes' WHERE pourcentage_musiquemonde='$musiquemonde';");
	  $wpdb->query("UPDATE ".$wpdb->prefix. "playlistenregistrees_webtv_plugin SET pourcentage_electro='$electros' WHERE pourcentage_electro='$electro';");
	  $wpdb->query("UPDATE ".$wpdb->prefix. "playlistenregistrees_webtv_plugin SET pourcentage_hardrock='$i' WHERE pourcentage_hardrock='$avant';");
	  $wpdb->query("UPDATE ".$wpdb->prefix. "playlistenregistrees_webtv_plugin SET pourcentage_chanson='$chansons' WHERE pourcentage_chanson='$chanson';");
	  $wpdb->query("UPDATE ".$wpdb->prefix. "playlistenregistrees_webtv_plugin SET pourcentage_autres='$autress' WHERE pourcentage_autres='$autres';");
      break;
	      
		  
	case "pourcentage_chanson":
	  $avant=$_POST['data']["avant"];
      $titre=$_POST['data']["titre"];
      $i=$_POST['data']["C"];
      $rap=$wpdb->get_var("SELECT pourcentage_rap FROM " . $wpdb->prefix . "playlistenregistrees_webtv_plugin WHERE nom='$titre';");
	  $raps=round(($rap - (($rap/(100-$avant))*($i - $avant))),2);
      $jazzblues=$wpdb->get_var("SELECT pourcentage_jazzblues FROM " .$wpdb->prefix . "playlistenregistrees_webtv_plugin WHERE nom='$titre';");
	  $jazzbluess=round(($jazzblues - (($jazzblues/(100-$avant))*($i - $avant))),2);
	  
	  $musiquemonde=$wpdb->get_var("SELECT pourcentage_musiquemonde FROM " . $wpdb->prefix . "playlistenregistrees_webtv_plugin WHERE nom='$titre';");
	  $musiquemondes=round(($musiquemonde - (($musiquemonde/(100-$avant))*($i - $avant))),2);
	  
      $electro=$wpdb->get_var("SELECT pourcentage_electro FROM " .$wpdb->prefix . "playlistenregistrees_webtv_plugin WHERE nom='$titre';");
	  $electros=round(($electro - (($electro/(100-$avant))*($i - $avant))),2);
	  
	  $hardrock=$wpdb->get_var("SELECT pourcentage_hardrock FROM " . $wpdb->prefix . "playlistenregistrees_webtv_plugin WHERE nom='$titre';");
	  $hardrocks=round(($hardrock - (($hardrock/(100-$avant))*($i - $avant))),2);
	  
      $poprock=$wpdb->get_var("SELECT pourcentage_poprock FROM " .$wpdb->prefix . "playlistenregistrees_webtv_plugin WHERE nom='$titre';");
	  $poprocks=round(($poprock - (($poprock/(100-$avant))*($i - $avant))),2);
	  
	  $autres=$wpdb->get_var("SELECT pourcentage_autres FROM " .$wpdb->prefix . "playlistenregistrees_webtv_plugin WHERE nom='$titre';");
	  $autress=round(($autres - (($autres/(100-$avant))*($i - $avant))),2);
	  

      $wpdb->query("UPDATE ".$wpdb->prefix. "playlistenregistrees_webtv_plugin SET pourcentage_poprock='$poprocks' WHERE pourcentage_poprock='$poprock';");
	  $wpdb->query("UPDATE ".$wpdb->prefix. "playlistenregistrees_webtv_plugin SET pourcentage_rap='$raps' WHERE pourcentage_rap='$rap';");
	  $wpdb->query("UPDATE ".$wpdb->prefix. "playlistenregistrees_webtv_plugin SET pourcentage_jazzblues='$jazzbluess' WHERE pourcentage_jazzblues='$jazzblues';");
	  $wpdb->query("UPDATE ".$wpdb->prefix. "playlistenregistrees_webtv_plugin SET pourcentage_musiquemonde='$musiquemondes' WHERE pourcentage_musiquemonde='$musiquemonde';");
	  $wpdb->query("UPDATE ".$wpdb->prefix. "playlistenregistrees_webtv_plugin SET pourcentage_electro='$electros' WHERE pourcentage_electro='$electro';");
	  $wpdb->query("UPDATE ".$wpdb->prefix. "playlistenregistrees_webtv_plugin SET pourcentage_hardrock='$hardrocks' WHERE pourcentage_hardrock='$hardrock';");
	  $wpdb->query("UPDATE ".$wpdb->prefix. "playlistenregistrees_webtv_plugin SET pourcentage_chanson='$i' WHERE pourcentage_chanson='$avant';");
	  $wpdb->query("UPDATE ".$wpdb->prefix. "playlistenregistrees_webtv_plugin SET pourcentage_autres='$autress' WHERE pourcentage_autres='$autres';");
      break;
	  
	case "pourcentage_autres":
	  $avant=$_POST['data']["avant"];
      $titre=$_POST['data']["titre"];
      $i=$_POST['data']["A"];
      $rap=$wpdb->get_var("SELECT pourcentage_rap FROM " . $wpdb->prefix . "playlistenregistrees_webtv_plugin WHERE nom='$titre';");
	  $raps=round(($rap - (($rap/(100-$avant))*($i - $avant))),2);
      $jazzblues=$wpdb->get_var("SELECT pourcentage_jazzblues FROM " .$wpdb->prefix . "playlistenregistrees_webtv_plugin WHERE nom='$titre';");
	  $jazzbluess=round(($jazzblues - (($jazzblues/(100-$avant))*($i - $avant))),2);
	  
	  $musiquemonde=$wpdb->get_var("SELECT pourcentage_musiquemonde FROM " . $wpdb->prefix . "playlistenregistrees_webtv_plugin WHERE nom='$titre';");
	  $musiquemondes=round(($musiquemonde - (($musiquemonde/(100-$avant))*($i - $avant))),2);
	  
      $electro=$wpdb->get_var("SELECT pourcentage_electro FROM " .$wpdb->prefix . "playlistenregistrees_webtv_plugin WHERE nom='$titre';");
	  $electros=round(($electro - (($electro/(100-$avant))*($i - $avant))),2);
	  
	  $hardrock=$wpdb->get_var("SELECT pourcentage_hardrock FROM " . $wpdb->prefix . "playlistenregistrees_webtv_plugin WHERE nom='$titre';");
	  $hardrocks=round(($hardrock - (($hardrock/(100-$avant))*($i - $avant))),2);
	  
      $chanson=$wpdb->get_var("SELECT pourcentage_chanson FROM " .$wpdb->prefix . "playlistenregistrees_webtv_plugin WHERE nom='$titre';");
	  $chansons=round(($chanson - (($chanson/(100-$avant))*($i - $avant))),2);
	  
	  $poprock=$wpdb->get_var("SELECT pourcentage_poprock FROM " .$wpdb->prefix . "playlistenregistrees_webtv_plugin WHERE nom='$titre';");
	  $poprocks=round(($poprock - (($poprock/(100-$avant))*($i - $avant))),2);
	  

      $wpdb->query("UPDATE ".$wpdb->prefix. "playlistenregistrees_webtv_plugin SET pourcentage_poprock='$poprocks' WHERE pourcentage_poprock='$poprock';");
	  $wpdb->query("UPDATE ".$wpdb->prefix. "playlistenregistrees_webtv_plugin SET pourcentage_rap='$raps' WHERE pourcentage_rap='$rap';");
	  $wpdb->query("UPDATE ".$wpdb->prefix. "playlistenregistrees_webtv_plugin SET pourcentage_jazzblues='$jazzbluess' WHERE pourcentage_jazzblues='$jazzblues';");
	  $wpdb->query("UPDATE ".$wpdb->prefix. "playlistenregistrees_webtv_plugin SET pourcentage_musiquemonde='$musiquemondes' WHERE pourcentage_musiquemonde='$musiquemonde';");
	  $wpdb->query("UPDATE ".$wpdb->prefix. "playlistenregistrees_webtv_plugin SET pourcentage_electro='$electros' WHERE pourcentage_electro='$electro';");
	  $wpdb->query("UPDATE ".$wpdb->prefix. "playlistenregistrees_webtv_plugin SET pourcentage_hardrock='$hardrocks' WHERE pourcentage_hardrock='$hardrock';");
	  $wpdb->query("UPDATE ".$wpdb->prefix. "playlistenregistrees_webtv_plugin SET pourcentage_chanson='$chansons' WHERE pourcentage_chanson='$chanson';");
	  $wpdb->query("UPDATE ".$wpdb->prefix. "playlistenregistrees_webtv_plugin SET pourcentage_autres='$i' WHERE pourcentage_autres='$avant';");
      break;
  }
};

 ?>