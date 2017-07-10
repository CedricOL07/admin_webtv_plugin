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


    //echo 'test tabrul';
    //var_dump($tab_url_clip);

   // $nb_track=$compteur;
    $max_clip = 12;

    //do_action('pluginwebtv_verifier_restant',$tableaupourcentages);

    if($highlight != "no_highlight"){
        do_action('pluginwebtv_ajouter_highlight',$highlight);
        $max_clip++;
    }

    if($pint != "no_pub_int"){
        do_action('pluginwebtv_ajouter_pubs_internes',$pint);
        $max_clip++;
    }
    //ajouter_pubs($pubsinternes,$pubsexternes);
    if($pext != "no_pub_ext"){
        do_action('pluginwebtv_ajouter_pubs_externe',$pext);
        $max_clip++;
    }

    echo("highlight : ".$highlight);
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
        $tab_genres_clip[$max_clip] = $tab_donnees_genre;    

    $query_annees = "SELECT annee FROM " . $wpdb->prefix . "annee_webtv_plugin WHERE id='$id_annees' LIMIT 1;";
    $tab_donnees_annees = (string)$wpdb->get_var($query_annees);
        $tab_annees_clip[$max_clip] = $tab_donnees_annees;

    $query_albums = "SELECT album FROM " . $wpdb->prefix . "album_webtv_plugin WHERE id='$id_albums' LIMIT 1;";
    $tab_donnees_albums = $wpdb->get_var($query_albums);
        $tab_albums_clip[$max_clip] = $tab_donnees_albums;

    $query="SELECT url,titre FROM " . $wpdb->prefix . "videos_webtv_plugin WHERE id='$id_video' LIMIT 1;";
    $tab_donnees_titre_url=$wpdb->get_results($query);
    foreach($tab_donnees_titre_url as $id){
        $tab_url_clip[$max_clip]=$id->url;
        $tab_titres_clip[$max_clip]=$id->titre; 
    }

    $tab_artistes_clip[$max_clip] = $nom_artiste; 


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

    $recup_externes="SELECT video_id,artiste_id FROM " . $wpdb->prefix . "relation_webtv_plugin WHERE genre_id='10' ORDER BY RAND() LIMIT 1; ";
    $res1=$wpdb->get_results($recup_externes);
    foreach($res1 as $id){
        
        $id_video = $id->video_id;
        $id_genres = $id->genre_id;
        $id_annees = $id->annee_id;
        $id_albums = $id->album_id;
    }

    $query_genre = "SELECT Genre FROM " . $wpdb->prefix . "genre_webtv_plugin WHERE id='$id_genres' LIMIT 1;";
    $tab_donnees_genre = $wpdb->get_var($query_genre);
        $tab_genres_clip[$max_clip] = $tab_donnees_genre;    

    $query_artistes = "SELECT nom FROM " . $wpdb->prefix . "artiste_webtv_plugin WHERE id='$id_artistes';";
    $tab_donnees_artistes = $wpdb->get_var($query_artistes);
        $tab_artistes_clip[$max_clip] = $tab_donnees_artistes;    

    $query_annees = "SELECT annee FROM " . $wpdb->prefix . "annee_webtv_plugin WHERE id='$id_annees' LIMIT 1;";
    $tab_donnees_annees = (string)$wpdb->get_var($query_annees);
        $tab_annees_clip[$max_clip] = $tab_donnees_annees;

    $query_albums = "SELECT album FROM " . $wpdb->prefix . "album_webtv_plugin WHERE id='$id_albums' LIMIT 1;";
    $tab_donnees_albums = $wpdb->get_var($query_albums);
        $tab_albums_clip[$max_clip] = $tab_donnees_albums;

    $query="SELECT url,titre FROM " . $wpdb->prefix . "videos_webtv_plugin WHERE id='$id_video' LIMIT 1;";
    $tab_donnees_titre_url=$wpdb->get_var($query);
        $tab_url_clip[$max_clip]=$tab_donnees_titre_url->url;
        $tab_titres_clip[$max_clip]=$tab_donnees_titre_url->titre;
    
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
    $id_video;
    $id_genres;
    $id_annees;
    $id_albums;

    $recup_internes="SELECT video_id,artiste_id FROM " . $wpdb->prefix . "relation_webtv_plugin WHERE genre_id='10' ORDER BY RAND() LIMIT 1;";
    $res2=$wpdb->get_results($recup_internes);
    foreach($res2 as $id){
        
        $id_video = $id->video_id;
        $id_genres = $id->genre_id;
        $id_annees = $id->annee_id;
        $id_albums = $id->album_id;
    }

    $query_genre = "SELECT Genre FROM " . $wpdb->prefix . "genre_webtv_plugin WHERE id='$id_genres' LIMIT 1;";
    $tab_donnees_genre = $wpdb->get_var($query_genre);
        $tab_genres_clip[$max_clip] = $tab_donnees_genre;    

    $query_artistes = "SELECT nom FROM " . $wpdb->prefix . "artiste_webtv_plugin WHERE id='$id_artistes';";
    $tab_donnees_artistes = $wpdb->get_var($query_artistes);
        $tab_artistes_clip[$max_clip] = $tab_donnees_artistes;    

    $query_annees = "SELECT annee FROM " . $wpdb->prefix . "annee_webtv_plugin WHERE id='$id_annees' LIMIT 1;";
    $tab_donnees_annees = (string)$wpdb->get_var($query_annees);
        $tab_annees_clip[$max_clip] = $tab_donnees_annees;

    $query_albums = "SELECT album FROM " . $wpdb->prefix . "album_webtv_plugin WHERE id='$id_albums' LIMIT 1;";
    $tab_donnees_albums = $wpdb->get_var($query_albums);
        $tab_albums_clip[$max_clip] = $tab_donnees_albums;

    $query="SELECT url,titre FROM " . $wpdb->prefix . "videos_webtv_plugin WHERE id='$id_video' LIMIT 1;";
    $tab_donnees_titre_url=$wpdb->get_var($query);
        $tab_url_clip[$max_clip]=$tab_donnees_titre_url->url;
        $tab_titres_clip[$max_clip]=$tab_donnees_titre_url->titre;
    


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




?>
