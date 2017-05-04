<?php
add_action('wp_ajax_recuperer_clips', 'recuperer_clips' );
add_action('wp_ajax_supprimer_clips','supprimer_clips');
add_action('wp_ajax_dynamic_update','dynamic_update');


function recuperer_clips(){

  global $wpdb;

  $query="SELECT * FROM ".$wpdb->prefix. "relation_webtv_plugin";
  $tab_id=$wpdb->get_results($query);
  $resultats=array();

  foreach ($tab_id as $row) {
    $video_id=$row->video_id;
    $artiste_id=$row->artiste_id;
    $genre_id=$row->genre_id;
    $album_id=$row->album_id;
    $annee_id=$row->annee_id;
    $qualite_id=$row->qualite_id;

    // preparation des réquetes SQL
    $stmt1=$wpdb->get_row("SELECT titre,url FROM " .$wpdb->prefix."videos_webtv_plugin where id=$video_id");
    $stmt2=$wpdb->get_row("SELECT nom FROM ".$wpdb->prefix."artiste_webtv_plugin where id=$artiste_id");
    $stmt3=$wpdb->get_row("SELECT Genre FROM ".$wpdb->prefix."genre_webtv_plugin where id=$genre_id");
    $stmt4=$wpdb->get_row("SELECT album FROM ".$wpdb->prefix."album_webtv_plugin where id=$album_id");
    $stmt5=$wpdb->get_row("SELECT annee FROM ".$wpdb->prefix."annee_webtv_plugin where id=$annee_id");


    $resultats[]= array("titre"=>$stmt1->titre,"artiste"=>$stmt2->nom,"album"=>$stmt4->album,"genre"=>$stmt3->Genre,"annee"=>$stmt5->annee,"qualite"=>$qualite_id,"url"=>$stmt1->url);
  }

  // Envoi des résultats sous JSON
  echo json_encode($resultats);
  // libération de la base de données
  wp_die();
};

function supprimer_clips(){
  //A faire : Prise en compte d'entrée multiples (plusieurs titres avec le meme artiste, meme année etc.)
  global $wpdb;
  if(isset($_POST['data'])){
    $data=$_POST['data'];
    foreach($data as $valeurs){
      $titre=$valeurs['titre'];
      // Récuperation des id pour la suppression des valeurs dans la table de relations
      $video_id=$wpdb->get_var("SELECT id FROM ".$wpdb->prefix."videos_webtv_plugin WHERE titre='$titre'",0,0);
      //Suppression de la base de données
      $wpdb->query("DELETE FROM ".$wpdb->prefix."videos_webtv_plugin WHERE titre='$titre';");
      $wpdb->query("DELETE FROM ".$wpdb->prefix."relation_webtv_plugin WHERE video_id=$video_id;");
    }
    echo "SUCCESS";
  }
  else echo "FAILED";
  wp_die();
};

function dynamic_update(){
  global $wpdb;
  if(isset($_POST['data'])){
    $data=$_POST['data'];
    //echo json_encode($data);
    foreach($data as $valeurs){
      $champ=$valeurs["champ"];
      $before=$valeurs["before"];
      $after=$valeurs["after"];
      switch($champ){
        case "titre":
          $wpdb->query("UPDATE " .$wpdb->prefix."videos_webtv_plugin SET titre='$after' WHERE titre='$before'");
          echo "MISE A JOUR DU TITRE REUSSIE";
          break;
        case "album":
          $wpdb->query("UPDATE " .$wpdb->prefix."album_webtv_plugin SET album='$after' WHERE album='$before'");
          echo "MISE A JOUR DE L'ALBUM REUSSIE";
          break;
          // MEME type de cas que annee a gerer
        case "annee":
          // Gestion du cas ou c'est une nouvelle annee ou une annee existante => Changement des id à faire
        case "nom":
          $wpdb->query("UPDATE " .$wpdb->prefix."artiste_webtv_plugin SET nom='$after' WHERE nom='$before'");
          echo "MISE A JOUR DE L'ARTISTE REUSSIE";
          break;
        case "Genre":
          //Changement sur les id et correction syntaxique à faire PAS D'UPDATE STANDARD!!!
        case "qualite":
          // Récuperer ID correspondant au titre et changer la qualité dans la table relation
        case "url":
          $wpdb->query("UPDATE " .$wpdb->prefix."videos_webtv_plugin SET url='$after' WHERE url='$before'");
          echo "MISE A JOUR DE L'URL REUSSIE";
          break;
      }
    }
}};



?>
