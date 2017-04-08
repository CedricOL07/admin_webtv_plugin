<?php
add_action('wp_ajax_recuperer_clips', 'recuperer_clips' );
add_action('wp_ajax_supprimer_clips','supprimer_clips');


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

};

 ?>
