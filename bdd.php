<?php

function ajouter_video($titre,$artiste,$album,$annee,$url,$genre,$qualite){
  // Variables de connexion avec la base de données
  $user="root"; //Nom d'utilisateur
  $passwd="023Mugen";// Mot de passe de connexion à la base de données
  $host="localhost"; // Addresse de la base de données
  $bddname="wpdatabase"; // Nom de la base de données


  $mysqli=new mysqli($host,$user,$passwd,$bddname);
  if ($mysqli->connect_errno) {
      echo "Echec lors de la connexion à MySQL : (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
  }

  $inserer_video="INSERT INTO wp_videos_webtv_plugin(titre,url) VALUES('$titre','$url');";
  $mysqli->query($inserer_video);

  $recup_video_id="SELECT id FROM wp_videos_webtv_plugin WHERE url='$url';";
  $video_id=$mysqli->query($recup_video_id)->fetch_array()['id'];

  $inserer_artiste="INSERT INTO wp_artiste_webtv_plugin(nom) VALUES('$artiste');";
  $mysqli->query($inserer_artiste);


  $recup_artiste_id="SELECT id FROM wp_artiste_webtv_plugin WHERE nom='$artiste';";
  $artiste_id=$mysqli->query($recup_artiste_id)->fetch_array()['id'];

  $recup_genre_id="SELECT id FROM wp_genre_webtv_plugin WHERE Genre='$genre';";
  $genre_id=$mysqli->query($recup_genre_id)->fetch_array()['id'];


  $inserer_annee="INSERT INTO wp_annee_webtv_plugin(annee) VALUES('$annee');";
  $mysqli->query($inserer_annee);

  $recup_annee_id="SELECT id FROM wp_annee_webtv_plugin WHERE annee='$annee';";
  $annee_id=$mysqli->query($recup_annee_id)->fetch_array()['id'];

  $inserer_album="INSERT INTO wp_album_webtv_plugin(album) VALUES('$album');";
  $mysqli->query($inserer_album);

  $recup_album_id="SELECT id FROM wp_album_webtv_plugin WHERE album='$album';";
  $album_id=$mysqli->query($recup_album_id)->fetch_array()['id'];


  $remplir_relation="INSERT INTO wp_relation_webtv_plugin(video_id,artiste_id,album_id,annee_id,genre_id,qualite_id) VALUES('$video_id','$artiste_id','$album_id','$annee_id','$genre_id','$qualite');";
  $mysqli->query($remplir_relation);
  $mysqli->close();
  echo "$video_id,$artiste_id,$album_id,$annee_id,$genre_id,$qualite";

}

function vider_bdd(){
  // Variables de connexion avec la base de données
  $user="root"; //Nom d'utilisateur
  $passwd="023Mugen";// Mot de passe de connexion à la base de données
  $host="localhost"; // Addresse de la base de données
  $bddname="wpdatabase"; // Nom de la base de données


  $mysqli=new mysqli($host,$user,$passwd,$bddname);
  if ($mysqli->connect_errno) {
      echo "Echec lors de la connexion à MySQL : (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
  }
  $tab=array('wp_album_webtv_plugin','wp_annee_webtv_plugin','wp_artiste_webtv_plugin','wp_relation_webtv_plugin','wp_videos_webtv_plugin');
  foreach($tab as $table){
      $mysqli->query("TRUNCATE TABLE $table");
  }

  $mysqli->close();
  printf('TABLES VIDEES');

}

vider_bdd();
ajouter_video('Get Lucky','Daft Punk','RAM','20140101','http://localhost/wordpress/wp-content/plugins/admin_webtv_plugin/mp4/1.mp4','Autre','5');
ajouter_video('The Pretender','Foo Fighters','Foo','2003','http://localhost/wordpress/wp-content/plugins/admin_webtv_plugin/mp4/2.mp4','Hard-rock & Metal','5');
ajouter_video('Hurt','Johnny Cash','Cash','19850101','http://localhost/wordpress/wp-content/plugins/admin_webtv_plugin/mp4/3.mp4','Jazz & Blues','5');
ajouter_video('I kissed a girl','Katy Perry','Katy','2015','http://localhost/wordpress/wp-content/plugins/admin_webtv_plugin/mp4/4.mp4','Pop-rock','5');
ajouter_video('Poker Face','Lady Gaga','Fame','20080101','http://localhost/wordpress/wp-content/plugins/admin_webtv_plugin/mp4/5.mp4','Pop-rock','5');
ajouter_video('Nothing Else Matters','Metallica','Black Album','19870101','http://localhost/wordpress/wp-content/plugins/admin_webtv_plugin/mp4/6.mp4','Hard-rock & Metal','5');
ajouter_video('Amaranth','Nightwish','Dark Passion Play','20100101','http://localhost/wordpress/wp-content/plugins/admin_webtv_plugin/mp4/7.mp4','Hard-rock & Metal','5');
ajouter_video('Elan logo','Nightwish','Endless Form Of Beautiful','20150101','http://localhost/wordpress/wp-content/plugins/admin_webtv_plugin/mp4/8.mp4','Logo','5');
ajouter_video('Dont Speak','No Doubt','Gwen','2000','http://localhost/wordpress/wp-content/plugins/admin_webtv_plugin/mp4/9.mp4','Pop-rock','5');
ajouter_video('Snow','Red Hot Chilli Peppers','RHCP','20040101','http://localhost/wordpress/wp-content/plugins/admin_webtv_plugin/mp4/10.mp4','Pop-rock','5');
ajouter_video('Papaoutai','Stromae','Maestro','20120101','http://localhost/wordpress/wp-content/plugins/admin_webtv_plugin/mp4/11.mp4','Musique du monde','5');
ajouter_video('Chop Suey','System of a Down','SOAD','20020101','http://localhost/wordpress/wp-content/plugins/admin_webtv_plugin/mp4/12.mp4','Hard-rock & Metal','5');
ajouter_video('The kids arent alright logo','The Offspring','Punk','20010101','http://localhost/wordpress/wp-content/plugins/admin_webtv_plugin/mp4/13.mp4','Logo','5');
ajouter_video('Zombie','The Cranberries','Ireland','19960101','http://localhost/wordpress/wp-content/plugins/admin_webtv_plugin/mp4/14.mp4','Pop-rock','5');
ajouter_video('Tous les cris les SOS','ZAZ','France','20160101','http://localhost/wordpress/wp-content/plugins/admin_webtv_plugin/mp4/15.mp4','Musique du monde','5');

?>
