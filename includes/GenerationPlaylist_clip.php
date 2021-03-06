<?php


/**************************************************************************************************************************
**
**
**                                 Fonctions php utilisées pour générer une playlist
**
**
*******************************************************************************************************************************/





add_action( 'pluginwebtv_generer_playlist_clips', 'generer_playlist_clips',15,16);
add_action( 'pluginwebtv_recup_videos_clip', 'recup_videos_clip',15,5);
add_action( 'pluginwebtv_ajouter_highlight', 'ajouter_highlight',16,1);
add_action( 'pluginwebtv_ajouter_pubs_internes', 'ajouter_pubs_internes',17,1);
add_action( 'pluginwebtv_ajouter_pubs_externes', 'ajouter_pubs_externes',17,1);
add_action('wp_ajax_effacer_et_ajouter_video_dans_table_playlist_clip_webtv_plugin','effacer_et_ajouter_video_dans_table_playlist_clip_webtv_plugin' );
add_action('pluginwebtv_nouvelle_video_comparaison_playlist_clip','nouvelle_video_comparaison_playlist_clip',1,5 );
//add_action( 'pluginwebtv_recuperer_artistes_nouvelle_playlist', 'recuperer_artistes_nouvelle_playlist');



//Variables globales qu'on va remplir avec les morceaux de la playlist


//Génère une playlist de 8 morceaux selon les pourcentages choisit par l'utilisateur
function generer_playlist_clips($pourcentagepoprock, $pourcentagehiphop, $pourcentagejazzblues, $pourcentagemusiquemonde, $pourcentagehardrock, $pourcentageelectro, $pourcentagechanson, $pourcentageautres, $pubsinternes, $pubsexternes,$artistehighlight,$annee_max, $annee_min, $qualite_min, $debut, $fin){

    global $tab_url_clip;
    global $tab_titres_clip;
    global $tab_artistes_clip;
    global $tab_annees_clip;
    global $tab_genres_clip;
    global $tab_albums_clip;
    global $max_clip;

    // Efface les tableaux
    $tab_url_clip=array();
    $tab_titres_clip=array();
    $tab_artistes_clip=array();
    $tab_genres_clip=array();
    $tab_annees_clip=array();
    $tab_albums_clip=array();
    $tableaupourcentages=array();

    $poprock=$pourcentagepoprock;
    $hiphop=$pourcentagehiphop;
    $jazzblues=$pourcentagejazzblues;
    $musiquemonde=$pourcentagemusiquemonde;
    $hardrock=$pourcentagehardrock;
    $electro=$pourcentageelectro;
    $chanson=$pourcentagechanson;
    $autres=$pourcentageautres;

    $pint=$pubsinternes;
    $pext=$pubsexternes;
    $highlight=$artistehighlight;

    $amin = $annee_min;
    $amax = $annee_max;
    $qualite = $qualite_min;

    $deb = $debut;
    $end = $fin;




    $tableaupourcentages[0] = $pourcentagepoprock;
    $tableaupourcentages[1] = $pourcentagehiphop;
    $tableaupourcentages[2] = $pourcentagejazzblues;
    $tableaupourcentages[3] = $pourcentagemusiquemonde;
    $tableaupourcentages[4] = $pourcentagehardrock;
    $tableaupourcentages[5] = $pourcentageelectro;
    $tableaupourcentages[6] = $pourcentagechanson;
    $tableaupourcentages[7] = $pourcentageautres;



    while (count($tab_titres_clip)<12){
        for($i=0;$i<count($tableaupourcentages);$i++){

            $valeur_camembert=$tableaupourcentages[$i];

            if ($i==0)
            {
                $genre_id=5; //correspond au Pop-rock
            }
            if ($i==1)
            {
                $genre_id=3; //correspond au Hip-hop & Reggae
            }
            if ($i==2)
            {
                $genre_id=7; //correspond au Jazz & Blues
            }
            if ($i==3)
            {
                $genre_id=9; //correspond au Musique du monde
            }
            if ($i==4)
            {
                $genre_id=2; //correspond au Hard-rock & metal
            }
            if ($i==5)
            {
                $genre_id=4; //correspond au Musique électronique
            }
            if ($i==6)
            {
                $genre_id=8; //correspond à Chanson Française
            }
            if ($i==7)
            {
                $genre_id=12; //correspond à Autre
            }

            if ( $valeur_camembert > 0){
                if($valeur_camembert<20){

                  do_action('pluginwebtv_recup_videos_clip',$genre_id,1,$amax, $amin, $qualite);
                }else{
                    if($valeur_camembert<30){

                       do_action('pluginwebtv_recup_videos_clip',$genre_id,2,$amax, $amin, $qualite);
                    }else{
                        if($valeur_camembert<40){
                           do_action('pluginwebtv_recup_videos_clip',$genre_id,3,$amax, $amin, $qualite);
                        }else{
                            if($valeur_camembert<50){
                               do_action('pluginwebtv_recup_videos_clip',$genre_id,4,$amax, $amin, $qualite);

                            }else{
                                if($valeur_camembert<60){
                                   do_action('pluginwebtv_recup_videos_clip',$genre_id,5,$amax, $amin, $qualite);

                                }else{
                                    if($valeur_camembert<70){
                                      do_action('pluginwebtv_recup_videos_clip',$genre_id,6,$amax, $amin, $qualite);

                                    }else{
                                        if($valeur_camembert<80){
                                          do_action('pluginwebtv_recup_videos_clip',$genre_id,7,$amax, $amin, $qualite);

                                        }else{
                                            if($valeur_camembert<90){
                                                do_action('pluginwebtv_recup_videos_clip',$genre_id,8,$amax, $amin, $qualite);

                                            }else{
                                                if($valeur_camembert<100){
                                                    do_action('pluginwebtv_recup_videos_clip',$genre_id,9,$amax, $amin, $qualite);
                                                }
                                                if($valeur_camembert==100){

                                                   do_action('pluginwebtv_recup_videos_clip',$genre_id,12,$amax, $amin, $qualite);

                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }// -----\ Fin du else /----
            }
        }//----\ Fin du for($i=0;$i<sizeof($tableaupourcentages);$i++) /--------
    }

    $max_clip = 12;

    if($pint != "no_pub_int"){
        do_action('pluginwebtv_ajouter_pubs_internes',$pint);
        $max_clip++;
    }

    if($highlight != "no_highlight"){
        do_action('pluginwebtv_ajouter_highlight',$highlight);
        $max_clip++;
    }

    if($pext != "no_pub_ext"){
        do_action('pluginwebtv_ajouter_pubs_externes',$pext);
        $max_clip++;
    }

}



//Ajouter l'artiste à mettre en avant sélectionné par l'utilisateur
function ajouter_highlight($artiste){
    global $wpdb;
    global $tab_url_clip;
    global $tab_titres_clip;
    global $tab_genres_clip;
    global $tab_annees_clip;
    global $tab_artistes_clip;
    global $tab_albums_clip;
    global $max_clip;

    $nom_artiste = $artiste;
    $id_video;
    $id_genres;
    $id_annees;
    $id_albums;
    $art="";

    $recup_idartiste="SELECT id FROM " . $wpdb->prefix . "artiste_webtv_plugin WHERE nom='".$artiste."' LIMIT 1";
    $result=$wpdb->get_var($recup_idartiste);
        $art=$result;
    //On récupère une seule vidéo de l'artiste
    $sql_query1="SELECT video_id,album_id,genre_id,annee_id FROM " . $wpdb->prefix . "relation_webtv_plugin WHERE artiste_id='".$art."' ORDER BY RAND() LIMIT 1;";
    $resultat=$wpdb->get_results($sql_query1);
    
    foreach($resultat as $id){
        
        $id_video = $id->video_id;
        $id_genres = $id->genre_id;
        $id_annees = $id->annee_id;
        $id_albums = $id->album_id;
    }

    $query_genre = "SELECT Genre FROM " . $wpdb->prefix . "genre_webtv_plugin WHERE id='$id_genres' LIMIT 1;";
    $tab_donnees_genre = $wpdb->get_var($query_genre);    

    $query_annees = "SELECT annee FROM " . $wpdb->prefix . "annee_webtv_plugin WHERE id='$id_annees' LIMIT 1;";
    $tab_donnees_annees = (string)$wpdb->get_var($query_annees);

    $query_albums = "SELECT album FROM " . $wpdb->prefix . "album_webtv_plugin WHERE id='$id_albums' LIMIT 1;";
    $tab_donnees_albums = $wpdb->get_var($query_albums);

    $query="SELECT url,titre FROM " . $wpdb->prefix . "videos_webtv_plugin WHERE id='$id_video' LIMIT 1;";
    $tab_donnees_titre_url=$wpdb->get_results($query);
    foreach($tab_donnees_titre_url as $id){
        $uurl = $id->url;
        $ttitre = $id->titre;
    }

        array_splice($tab_url_clip, 13, 0, $uurl); //insert à la 6e position 
        array_splice($tab_titres_clip, 13, 0, $ttitre); //insert à la 6e position 
        array_splice($tab_genres_clip, 13, 0, $tab_donnees_genre); //insert à la 6e position 
        array_splice($tab_artistes_clip, 13, 0, $nom_artiste); //insert à la 6e position 
        array_splice($tab_annees_clip, 13, 0, $tab_donnees_annees); //insert à la 6e position 
        array_splice($tab_albums_clip, 13, 0, $tab_donnees_albums); //insert à la 6e position 


}
//Ajouter les pubs externes sélectionnées par l'utilisateur dans la page nouveaux réglages
function ajouter_pubs_externes($pubsexternes){
    global $wpdb;
    global $tab_url_clip;
    global $tab_titres_clip;
    global $tab_artistes_clip;
    global $tab_annees_clip;
    global $tab_genres_clip;
    global $tab_albums_clip;
    global $max_clip;
    $id_video;
    $id_genres;
    $id_annees;
    $id_albums;
    
    $recup_externes="SELECT titre, url FROM " . $wpdb->prefix . "videos_webtv_plugin WHERE titre='$pubsexternes' LIMIT 1; ";
    $res1=$wpdb->get_results($recup_externes);
    foreach($res1 as $id){
        $uurl = $id->url;
        $ttitre = $id->titre;

    }

        array_splice($tab_url_clip, 14, 0, $uurl); //insert à la 6e position 
        array_splice($tab_titres_clip, 14, 0, $ttitre); //insert à la 6e position 
        array_splice($tab_genres_clip, 14, 0, 'Publicité Interne'); //insert à la 6e position 
        array_splice($tab_artistes_clip, 14, 0, ' '); //insert à la 6e position 
        array_splice($tab_annees_clip, 14, 0, '0001-01-01-01:01'); //insert à la 6e position 
        array_splice($tab_albums_clip, 14, 0, ' '); //insert à la 6e position 
}
//Ajouter les pubs internes sélectionnées par l'utilisateur dans la page nouveaux réglages
function ajouter_pubs_internes($pubsinternes){
    global $wpdb;
    global $tab_url_clip;
    global $tab_titres_clip;
    global $tab_artistes_clip;
    global $tab_annees_clip;
    global $tab_genres_clip;
    global $tab_albums_clip;
    global $max_clip;
    $uurl;
    $ttitre;

    $recup_internes="SELECT titre, url FROM " . $wpdb->prefix . "videos_webtv_plugin WHERE titre='$pubsinternes' LIMIT 1; ";
    $res2=$wpdb->get_results($recup_internes);
    foreach($res2 as $id){
        $uurl = $id->url;
        $ttitre = $id->titre;

    }

        array_splice($tab_url_clip, 6, 0, $uurl); //insert à la 6e position 
        array_splice($tab_titres_clip, 6, 0, $ttitre); //insert à la 6e position 
        array_splice($tab_genres_clip, 6, 0, 'Publicité Interne'); //insert à la 6e position 
        array_splice($tab_artistes_clip, 6, 0, ' '); //insert à la 6e position 
        array_splice($tab_annees_clip, 6, 0, '0001-01-01-01:01'); //insert à la 6e position 
        array_splice($tab_albums_clip, 6, 0, ' '); //insert à la 6e position 


}
/*
*  Fonction : Récupere un nombre $limt de vidéos du genre $genre en ajoutant l'url et le titre au tableau tab_url_clip et tab_titres_clip
*  Deplus la fonction trie les artistes et les genres en fonction des titres et des url des clips à fin de remplir correctement
*  les tableaux, $tab_url_clip, $tab_artistes_clip, $tab_titres_clip, $tab_genres_clip. Ces tableaux servent particulièrement au remplissage de la fonctions
*  generer_la_playlist dans le fichier traitement_donnees.php qui rempli la table playlist_par_defaut_webtv_plugin.
*/

function recup_videos_clip($genre,$limit,$annee_max, $annee_min, $qualite_min){
    global $wpdb;
    global $tab_url_clip;
    global $tab_titres_clip;
    global $tab_artistes_clip;
    global $tab_annees_clip;
    global $tab_genres_clip;
    global $tab_albums_clip;

    $sql_query1="SELECT video_id,artiste_id,genre_id,annee_id,album_id FROM " . $wpdb->prefix . "relation_webtv_plugin WHERE genre_id='$genre'
        AND annee_id IN (SELECT id FROM `wp_annee_webtv_plugin` WHERE annee >= '$annee_min' AND annee <= '$annee_max' )
        AND qualite_id >= $qualite_min ORDER BY RAND()  LIMIT $limit;";

    $tabvideos=$wpdb->get_results($sql_query1);

    foreach($tabvideos as $id){

        $id_video = $id->video_id;
        $id_art1 = $id->artiste_id;
        $id_genres = $id->genre_id;
        $id_annees = $id->annee_id;
        $id_albums = $id->album_id;

        $query_genre = "SELECT Genre FROM " . $wpdb->prefix . "genre_webtv_plugin WHERE id='$id_genres' LIMIT 1;";
        $tab_donnees_genre = $wpdb->get_results($query_genre);
        foreach($tab_donnees_genre as $results)
        {
            $tab_genres_clip[] = $results->Genre;
        }

        $query_artistes = "SELECT nom FROM " . $wpdb->prefix . "artiste_webtv_plugin WHERE id='$id_art1' LIMIT 1;";
        $tab_donnees_artistes = $wpdb->get_results($query_artistes);
        foreach($tab_donnees_artistes as $results){
            $tab_artistes_clip[] = $results->nom;
        }

        $query_url_titre = "SELECT url,titre FROM " . $wpdb->prefix . "videos_webtv_plugin WHERE id='$id_video' LIMIT 1;";
        $tab_donnees_url_titre = $wpdb->get_results($query_url_titre);
        foreach($tab_donnees_url_titre as $s){
            $tab_url_clip[]=$s->url;
            $tab_titres_clip[]=$s->titre;
        }

        $query_annees = "SELECT annee FROM " . $wpdb->prefix . "annee_webtv_plugin WHERE id='$id_annees' LIMIT 1;";
        $tab_donnees_annees = $wpdb->get_results($query_annees);
        foreach($tab_donnees_annees as $results){
            $tab_annees_clip[] = $results->annee;
        }

        $query_albums = "SELECT album FROM " . $wpdb->prefix . "album_webtv_plugin WHERE id='$id_albums' LIMIT 1;";
        $tab_donnees_albums = $wpdb->get_results($query_albums);
        foreach($tab_donnees_albums as $results){
            $tab_albums_clip[] = $results->album;
        }
    }

}


/*
Nom : ajouter_video_dans_table_playlist_clip_webtv_plugin()
Fonction : Cette fonction permet de rajouter un clip video dans la table wp_playlist_clip_webtv_plugin de la base de données.
Ceci permet de faire une boucle des vidéos pour la playlist par défaut.
ATTENTION Exemple :WHERE titre='$video_courante' bien mettre des quotes  et non des guillemets sinon impossible d'obtenir la page!!
*/

function effacer_et_ajouter_video_dans_table_playlist_clip_webtv_plugin(){
    global $wpdb;
    global $titre_nouvelle_video;

    $video_courante= $_POST['videocouranteprevious'];// récupérer dans le JSON dans la fonction post AJAX dans le fichier player_homepage.js
    $nom_playlist= $_POST['nom_playlist'];// récupérer dans le JSON dans la fonction post AJAX dans le fichier player_homepage.js

    // Récup la fréquence logo de la playlist clip 'nom_playlist'
    $query_freq_logo_dans_playlist_enregistrees_choix_playlist_clip = "SELECT Freq_logo FROM " . $wpdb->prefix . "playlistenregistrees_webtv_plugin WHERE nom='$nom_playlist';";
    $reponse_freq_logo_dans_playlist_enregistrees_choix_playlist_clip = $wpdb->get_var($query_freq_logo_dans_playlist_enregistrees_choix_playlist_clip);

              //------- Séléction de id_genre de la video courante------//

    // recupération de l'id de la video courante dans la table playlist clip car les id sont différents.
    $query_id_videocouranteprevious_dans_playlist_clip = "SELECT id, Debut, Fin FROM " . $wpdb->prefix . "playlistclip_webtv_plugin WHERE titre='$video_courante';";
    $reponse_id_videocouranteprevious_dans_playlist_clip = $wpdb->get_var($query_id_videocouranteprevious_dans_playlist_clip, 0,0);
    $debut_videocouranteprevious_dans_playlist_clip = $wpdb->get_var($query_id_videocouranteprevious_dans_playlist_clip, 1,0);
    $fin_videocouranteprevious_dans_playlist_clip = $wpdb->get_var($query_id_videocouranteprevious_dans_playlist_clip, 2,0);

    $query_tri_asc = "ALTER TABLE " . $wpdb->prefix . "playlistclip_webtv_plugin ORDER BY id ASC;";
    $wpdb->query($query_tri_asc);

    $query_genre_videocouranteprevious_dans_playlist_clip = "SELECT genre FROM " . $wpdb->prefix . "playlistclip_webtv_plugin WHERE titre='$video_courante';";
    $reponse_genre_videocouranteprevious_dans_playlist_clip = $wpdb->get_var($query_genre_videocouranteprevious_dans_playlist_clip);

    //récupération de l'id de la video courante dans la table video_web_tv.
    $query_id_video_courante = "SELECT id FROM ". $wpdb->prefix . "videos_webtv_plugin WHERE titre='$video_courante' LIMIT 1;";
    $reponse_id_video_courante = $wpdb -> get_var($query_id_video_courante);

    $query_annee_max = "SELECT annee_max FROM ". $wpdb->prefix . "playlistenregistrees_webtv_plugin WHERE nom='$nom_playlist' LIMIT 1;";
    $reponse_annee_max = $wpdb->get_var($query_annee_max);

    $query_annee_min = "SELECT annee_min FROM ". $wpdb->prefix . "playlistenregistrees_webtv_plugin WHERE nom='$nom_playlist' LIMIT 1;";
    $reponse_annee_min = $wpdb->get_var($query_annee_min);

    $query_qualite_min = "SELECT qualite_min FROM ". $wpdb->prefix . "playlistenregistrees_webtv_plugin WHERE nom='$nom_playlist' LIMIT 1;";
    $reponse_qualite_min = $wpdb->get_var($query_qualite_min);

    $query_artiste_highlight = "SELECT artiste_highlight FROM ". $wpdb->prefix . "playlistenregistrees_webtv_plugin WHERE nom='$nom_playlist' LIMIT 1;";
    $reponse_artiste_highlight = $wpdb->get_var($query_artiste_highlight);
    $query_id_artiste_highlight = "SELECT id FROM ". $wpdb->prefix . "artiste_webtv_plugin WHERE nom='$reponse_artiste_highlight' LIMIT 1;";
    $reponse_id_artiste_highlight = $wpdb->get_var($query_id_artiste_highlight);



    //Récupération de l'id du genre et de l'artiste de la vidéo courante
    $query_id_genre_video_courante = "SELECT genre_id, artiste_id FROM ". $wpdb->prefix . "relation_webtv_plugin WHERE video_id='$reponse_id_video_courante' LIMIT 1;";
    $reponse_id_genre_video_courante = $wpdb -> get_var($query_id_genre_video_courante, 0,0);
    $reponse_id_artiste_video_courante = $wpdb -> get_var($query_id_genre_video_courante, 1,0);

    echo($reponse_id_artiste_highlight." + ".$reponse_id_artiste_video_courante);

    if($reponse_id_artiste_highlight == $reponse_id_artiste_video_courante) // Si on passe l'artiste highlight
    {
        nouvelle_video_comparaison_playlist_clip_highlight($reponse_id_artiste_video_courante, $video_courante, $reponse_annee_min, $reponse_annee_max, $reponse_qualite_min );
    }else
    {
            //-------Video à ajouter ------//
        nouvelle_video_comparaison_playlist_clip($reponse_id_genre_video_courante, $video_courante, $reponse_annee_min, $reponse_annee_max, $reponse_qualite_min );
    }


    //Récupère information url et id de la nouvelle video
     $query_id_video_a_ajouter_meme_genre = "SELECT id,url FROM ". $wpdb->prefix . "videos_webtv_plugin WHERE titre='$titre_nouvelle_video' LIMIT 1;"; // order by rand permet de lister aléatoirement les clips musiquaux
     $reponse_id_video_a_ajouter_meme_genre = $wpdb -> get_var($query_id_video_a_ajouter_meme_genre, 0);
     $reponse_url_video_a_ajouter_meme_genre = $wpdb -> get_var($query_id_video_a_ajouter_meme_genre, 1);


     //Récupération des informations liées à la nouvelle video avec le même genre que la vidéo courante.
      $query_ids_video_a_ajouter_meme_genre = "SELECT artiste_id,genre_id, album_id, annee_id FROM ". $wpdb->prefix . "relation_webtv_plugin WHERE video_id='$reponse_id_video_a_ajouter_meme_genre'   LIMIT 1;"; // order by rand permet de lister aléatoirement les clips musiquaux
      $reponse_ids_video_a_ajouter_meme_genre = $wpdb -> get_results($query_ids_video_a_ajouter_meme_genre);

      foreach ( $reponse_ids_video_a_ajouter_meme_genre  as $result){
        $id_genre_video_a_ajouter_meme_genre = $result->genre_id;
        $id_artiste_video_a_ajouter_meme_genre = $result->artiste_id;
        $id_album_video_a_ajouter_meme_genre = $result->album_id;
        $id_annee_video_a_ajouter_meme_genre = $result->annee_id;


        $query_genre_video_a_ajouter_meme_genre = "SELECT Genre FROM ". $wpdb->prefix . "genre_webtv_plugin WHERE id='$id_genre_video_a_ajouter_meme_genre' LIMIT 1;"; // order by rand permet de lister aléatoirement les clips musiquaux
        $reponse_genre_video_a_ajouter_meme_genre = $wpdb -> get_var($query_genre_video_a_ajouter_meme_genre);

        $query_artiste_video_a_ajouter_meme_genre = "SELECT nom FROM ". $wpdb->prefix . "artiste_webtv_plugin WHERE id='$id_artiste_video_a_ajouter_meme_genre' LIMIT 1;"; // order by rand permet de lister aléatoirement les clips musiquaux
        $reponse_artiste_video_a_ajouter_meme_genre = $wpdb -> get_var($query_artiste_video_a_ajouter_meme_genre);

        $query_annee_video_a_ajouter_meme_genre = "SELECT annee FROM ". $wpdb->prefix . "annee_webtv_plugin WHERE id='$id_annee_video_a_ajouter_meme_genre' LIMIT 1;"; // order by rand permet de lister aléatoirement les clips musiquaux
        $reponse_annee_video_a_ajouter_meme_genre = $wpdb -> get_var($query_annee_video_a_ajouter_meme_genre);

        $query_album_video_a_ajouter_meme_genre = "SELECT album FROM ". $wpdb->prefix . "album_webtv_plugin WHERE id='$id_album_video_a_ajouter_meme_genre' LIMIT 1;"; // order by rand permet de lister aléatoirement les clips musiquaux
        $reponse_album_video_a_ajouter_meme_genre = $wpdb -> get_var($query_album_video_a_ajouter_meme_genre);
      }

      //Mise à jour de la table playlist_clip_webtv_plugin avec un clips video du même genre que la video courante supprimé
      $query_titre_url_genres_artistes_annee_album_video_a_ajouter_meme_genre_dans_table_playlist_clip_webtv_plugin = "INSERT INTO " . $wpdb->prefix . "playlistclip_webtv_plugin(titre,url,artiste,genre, annee, album, Debut, Fin) VALUES('$titre_nouvelle_video','$reponse_url_video_a_ajouter_meme_genre','$reponse_artiste_video_a_ajouter_meme_genre','$reponse_genre_video_a_ajouter_meme_genre','$reponse_annee_video_a_ajouter_meme_genre','$reponse_album_video_a_ajouter_meme_genre','$debut_videocouranteprevious_dans_playlist_clip','$fin_videocouranteprevious_dans_playlist_clip')";
      $wpdb -> query($query_titre_url_genres_artistes_annee_album_video_a_ajouter_meme_genre_dans_table_playlist_clip_webtv_plugin);

      //Permet de trier la table par odre croissant !! Utile pour démarer toujours au clip en cours. SELECT n'actualise pas la BDD comme on pourrait le croire si on effectue
      // la requête dans phpmyadmin.
      $query_tri_asc = "ALTER TABLE " . $wpdb->prefix . "playlistclip_webtv_plugin ORDER BY id ASC;";
      $wpdb->query($query_tri_asc);

      //Très utile afin d'éviter la sélection d'un doublon entre la video courante et les videos avec un titre similaire
      $query_select_min_id_de_video_courante = "SELECT MIN(id) FROM " . $wpdb->prefix . "playlistclip_webtv_plugin WHERE titre='$video_courante' ";
      $reponse_select_min_id_de_video_courante = $wpdb->get_var($query_select_min_id_de_video_courante);


      //Requete qui supprime la video courante en fonction de son id de la playlist clip.
      $query_del_titre_video_courante="DELETE FROM " . $wpdb->prefix . "playlistclip_webtv_plugin WHERE id='$reponse_select_min_id_de_video_courante' ";
      $wpdb->query($query_del_titre_video_courante);

}



/*
* Fonction : Permet de comparer les différents titres de vidéo du même genre
* Utilité dans la fonction effacer_et_ajouter_video_dans_table_playlist_clip_webtv_plugin
*/
function nouvelle_video_comparaison_playlist_clip($genre_videocouranteprevious, $titre_video_courante, $reponse_annee_min, $reponse_annee_max, $reponse_qualite_min){
    global $wpdb;
    global $titre_nouvelle_video;

    // --- Fabrication d'un tableau avec les titres des videos ayant le même genre que la vidéo courante --//
    $query_id_video_meme_genre_tranche_annee_meme_qualite_video_courante = "SELECT video_id FROM " . $wpdb->prefix . "relation_webtv_plugin WHERE genre_id='$genre_videocouranteprevious' AND annee_id IN (SELECT id FROM `wp_annee_webtv_plugin` WHERE annee >= '$reponse_annee_min' AND annee <= '$reponse_annee_max' )
        AND qualite_id >= $reponse_qualite_min ORDER BY RAND();";
    $reponse_id_video_meme_genre_tranche_annee_meme_qualite_video_courante = $wpdb->get_results(  $query_id_video_meme_genre_tranche_annee_meme_qualite_video_courante);

    foreach ($reponse_id_video_meme_genre_tranche_annee_meme_qualite_video_courante as $results) {
      $id_video_meme_genre_video_courante = $results->video_id;
      $query_titre_video_meme_genre_video_courante = "SELECT titre FROM " . $wpdb->prefix . "videos_webtv_plugin WHERE id='$id_video_meme_genre_video_courante';";
      $reponse_titre_video_meme_genre_video_courante = $wpdb->get_results($query_titre_video_meme_genre_video_courante);

      foreach ($reponse_titre_video_meme_genre_video_courante as $results) {
        $tab_titre_video_meme_genre_video_courante[] = $results->titre;
      }
    }

      //-------Tableau des titres de la playlist par defaut chargé ------

    //fabrication du tableau des 15 clips vidéos de la playlist clip
    $query_titre_video_playlist_clip="SELECT titre FROM " . $wpdb->prefix . "playlistclip_webtv_plugin LIMIT  15;";
    $reponse_titre_video_playlist_clip = $wpdb -> get_results($query_titre_video_playlist_clip);//requête
    foreach ($reponse_titre_video_playlist_clip as $results){
      $tab_titres_playlist_clip[] = $results->titre;
    }
    // comparaison
    foreach ($tab_titre_video_meme_genre_video_courante as $key_tab_titre_video_meme_genre_video_courante) {
      foreach ($tab_titres_playlist_clip as $key_titre_pl_clip) {

        if( $key_tab_titre_video_meme_genre_video_courante != $key_titre_pl_clip && $key_tab_titre_video_meme_genre_video_courante != $titre_video_courante)
          //Mise à jour de la table playlist_clip_webtv_plugin avec un clips video du même genre que la video courante supprimé
          $titre_nouvelle_video = $key_tab_titre_video_meme_genre_video_courante;
          break;
        }
    }
    //Si il n'y a aucune correspondance on renouvelle la musique.
    if ($titre_nouvelle_video == NULL){
      $titre_nouvelle_video = $titre_video_courante;
    }

    unset($tab_titre_video_meme_genre_video_courante);// supprime le tableau des videos ayant le meme genre afin de le réinitialiser à chaque fois.
    unset($tab_titres_playlist_clip);// supprime le tableau des 15 clips de la playlist clip afin de le réinitialiser à chaque fois.

}


/*
* Fonction : Permet de comparer les différents titres de vidéo du même artiste si c'est l'artiste highlight
* Utilité dans la fonction effacer_et_ajouter_video_dans_table_playlist_clip_webtv_plugin
*/
function nouvelle_video_comparaison_playlist_clip_highlight($highlight_videocouranteprevious, $titre_video_courante, $reponse_annee_min, $reponse_annee_max, $reponse_qualite_min){
    global $wpdb;
    global $titre_nouvelle_video;

    // --- Fabrication d'un tableau avec les titres des videos ayant le même genre que la vidéo courante --//
    $query_id_video_meme_genre_tranche_annee_meme_qualite_video_courante = "SELECT video_id FROM " . $wpdb->prefix . "relation_webtv_plugin WHERE artiste_id='$highlight_videocouranteprevious' AND annee_id IN (SELECT id FROM `wp_annee_webtv_plugin` WHERE annee >= '$reponse_annee_min' AND annee <= '$reponse_annee_max' )
        AND qualite_id >= $reponse_qualite_min ORDER BY RAND();";
    $reponse_id_video_meme_genre_tranche_annee_meme_qualite_video_courante = $wpdb->get_results(  $query_id_video_meme_genre_tranche_annee_meme_qualite_video_courante);

    foreach ($reponse_id_video_meme_genre_tranche_annee_meme_qualite_video_courante as $results) {
      $id_video_meme_genre_video_courante = $results->video_id;
      $query_titre_video_meme_genre_video_courante = "SELECT titre FROM " . $wpdb->prefix . "videos_webtv_plugin WHERE id='$id_video_meme_genre_video_courante';";
      $reponse_titre_video_meme_genre_video_courante = $wpdb->get_results($query_titre_video_meme_genre_video_courante);

      foreach ($reponse_titre_video_meme_genre_video_courante as $results) {
        $tab_titre_video_meme_genre_video_courante[] = $results->titre;
      }
    }

      //-------Tableau des titres de la playlist par defaut chargé ------

    //fabrication du tableau des 15 clips vidéos de la playlist clip
    $query_titre_video_playlist_clip="SELECT titre FROM " . $wpdb->prefix . "playlistclip_webtv_plugin LIMIT  15;";
    $reponse_titre_video_playlist_clip = $wpdb -> get_results($query_titre_video_playlist_clip);//requête
    foreach ($reponse_titre_video_playlist_clip as $results){
      $tab_titres_playlist_clip[] = $results->titre;
    }
    // comparaison
    foreach ($tab_titre_video_meme_genre_video_courante as $key_tab_titre_video_meme_genre_video_courante) {
      foreach ($tab_titres_playlist_clip as $key_titre_pl_clip) {

        if( $key_tab_titre_video_meme_genre_video_courante != $key_titre_pl_clip && $key_tab_titre_video_meme_genre_video_courante != $titre_video_courante)
          //Mise à jour de la table playlist_clip_webtv_plugin avec un clips video du même genre que la video courante supprimé
          $titre_nouvelle_video = $key_tab_titre_video_meme_genre_video_courante;
          break;
        }
    }
    //Si il n'y a aucune correspondance on renouvelle la musique.
    if ($titre_nouvelle_video == NULL){
      $titre_nouvelle_video = $titre_video_courante;
    }

    unset($tab_titre_video_meme_genre_video_courante);// supprime le tableau des videos ayant le meme genre afin de le réinitialiser à chaque fois.
    unset($tab_titres_playlist_clip);// supprime le tableau des 15 clips de la playlist clip afin de le réinitialiser à chaque fois.

}



?>
