<?php


/**************************************************************************************************************************
**
**
**                                 Fonctions php utilisées pour générer une playlist
**
**
*******************************************************************************************************************************/





add_action( 'pluginwebtv_generer_playlist_clips', 'generer_playlist_clips',15,16);
add_action( 'pluginwebtv_recup_videos', 'recup_videos',15,5);
add_action( 'pluginwebtv_verifier_restant', 'verifier_restant',15,1);
add_action( 'pluginwebtv_ajouter_hightlight', 'ajouter_hightlight',16,1);
add_action( 'pluginwebtv_ajouter_pubs_internes', 'ajouter_pubs_internes',17,2);
add_action( 'pluginwebtv_ajouter_pubs_externes', 'ajouter_pubs_externes',17,2);
//add_action( 'pluginwebtv_recuperer_artistes_nouvelle_playlist', 'recuperer_artistes_nouvelle_playlist');



//Variables globales qu'on va remplir avec les morceaux de la playlist


//Génère une playlist de 8 morceaux selon les pourcentages choisit par l'utilisateur
function generer_playlist_clips($pourcentagepoprock, $pourcentagehiphop, $pourcentagejazzblues, $pourcentagemusiquemonde, $pourcentagehardrock, $pourcentageelectro, $pourcentagechanson, $pourcentageautres, $pubsinternes, $pubsexternes,$artistehighlight,$annee_max, $annee_min, $qualite_min, $debut, $fin){


    global $tab_url;
    global $tab_titres;
    global $tab_artistes;
    global $tab_genres;
    global $tab_ids;
    global $tab_durees;
    global $duree_total;
    $poprock=$pourcentagepoprock;
    $hiphop=$pourcentagehiphop;
    $jazzblues=$pourcentagejazzblues;
    $musiquemonde=$pourcentagemusiquemonde;
    $hardrock=$pourcentagehardrock;
    $electro=$pourcentageelectro;
    $chanson=$pourcentagechanson;
    $autres=$pourcentageautres;
    $amin = $annee_min;
    $amax = $annee_max;
    $qualite = $qualite_min;
    $deb = $debut;
    $end = $fin;

    // Efface les tableaux
    $tab_url=array();
    $tab_titres=array();
    $tab_artistes=array();
    $tab_genres=array();
    $tab_annees=array();
    $tab_albums=array();


    $tableaupourcentages=array();

    $tableaupourcentages[0] = $pourcentagepoprock;
    $tableaupourcentages[1] = $pourcentagehiphop;
    $tableaupourcentages[2] = $pourcentagejazzblues;
    $tableaupourcentages[3] = $pourcentagemusiquemonde;
    $tableaupourcentages[4] = $pourcentagehardrock;
    $tableaupourcentages[5] = $pourcentageelectro;
    $tableaupourcentages[6] = $pourcentagechanson;
    $tableaupourcentages[7] = $pourcentageautres;


    while (sizeof($tab_titres)<12){
        for($i=0;$i<sizeof($tableaupourcentages);$i++){

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

                  do_action('pluginwebtv_recup_videos',$genre_id,1,$amax, $amin, $qualite);
                }else{
                    if($valeur_camembert<30){

                       do_action('pluginwebtv_recup_videos',$genre_id,2,$amax, $amin, $qualite);
                    }else{
                        if($valeur_camembert<40){
                           do_action('pluginwebtv_recup_videos',$genre_id,3,$amax, $amin, $qualite);
                        }else{
                            if($valeur_camembert<50){
                               do_action('pluginwebtv_recup_videos',$genre_id,4,$amax, $amin, $qualite);

                            }else{
                                if($valeur_camembert<60){
                                   do_action('pluginwebtv_recup_videos',$genre_id,5,$amax, $amin, $qualite);

                                }else{
                                    if($valeur_camembert<70){
                                      do_action('pluginwebtv_recup_videos',$genre_id,6,$amax, $amin, $qualite);

                                    }else{
                                        if($valeur_camembert<80){
                                          do_action('pluginwebtv_recup_videos',$genre_id,7,$amax, $amin, $qualite);

                                        }else{
                                            if($valeur_camembert<90){
                                                do_action('pluginwebtv_recup_videos',$genre_id,8,$amax, $amin, $qualite);

                                            }else{
                                                if($valeur_camembert<100){
                                                    do_action('pluginwebtv_recup_videos',$genre_id,9,$amax, $amin, $qualite);
                                                }
                                                if($valeur_camembert==100){

                                                   do_action('pluginwebtv_recup_videos',$genre_id,12,$amax, $amin, $qualite);

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

    if (sizeof($tab_titres)>12)
    {
        for($i=12; $i<sizeof($tab_titres); $i++)
        {
            unset($tab_titres[$i]);
            unset($tab_artistes[$i]);
            unset($tab_url[$i]);
            unset($tab_genres[$i]);
            unset($tab_annees[$i]);
            unset($tab_albums[$i]);
        }
    }
    //echo 'test tabrul';
    //var_dump($tab_url);

   // $nb_track=$compteur;

    //do_action('pluginwebtv_verifier_restant',$tableaupourcentages);

    if($artistehighlight!= NULL){
        do_action('pluginwebtv_ajouter_hightlight',$artistehighlight);
    }


    if($pubsinternes != NULL){
        do_action('pluginwebtv_ajouter_pubs_internes',$pubsinternes);
    }
    //ajouter_pubs($pubsinternes,$pubsexternes);
    if($pubsexternes != NULL){
        do_action('pluginwebtv_ajouter_pubs_externe',$pubsexternes);
    }

/*
    for ($i=0; $i<sizeof($tab_url); $i++)
    {
        $duree_total = $duree_total+$tab_durees[$i];
    }    
*/

}



//Ajouter l'artiste à mettre en avant sélectionné par l'utilisateur
function ajouter_hightlight($artiste){
    global $wpdb;
    global $tab_url;
    global $tab_titres;
    global $tab_artistes_id;
    global $tab_artistes;
    global $tab_ids;


   // $tab_artistes[]=$artiste;

    $art;
    $recup_idartiste="SELECT id FROM " . $wpdb->prefix . "artiste_webtv_plugin WHERE nom='$artiste'";
    $result=$wpdb->get_results($recup_idartiste);
    foreach($result as $r){
        $art=$r->id;
    }
    //On récupère une seule vidéo de l'artiste
    $sql_query1="SELECT video_id,album_id,genre_id,annee_id FROM " . $wpdb->prefix . "relation_webtv_plugin WHERE artiste_id='$art' ORDER BY RAND() LIMIT 1;";
    $resultat=$wpdb->get_results($sql_query1);
    foreach($resultat as $result){
        
        $id_video = $id->video_id;
        $id_genres = $id->genre_id;
        $id_annees = $id->annee_id;
        $id_albums = $id->album_id;


        $query_genre = "SELECT Genre FROM " . $wpdb->prefix . "genre_webtv_plugin WHERE id='$id_genres' LIMIT 1;";
        $tab_donnees_genre = $wpdb->get_results($query_genre);
        foreach($tab_donnees_genre as $results){
            $tab_genres[] = $results->Genre;
        }

        $query_annees = "SELECT annee FROM " . $wpdb->prefix . "annee_webtv_plugin WHERE id='$id_annees' LIMIT 1;";
        $tab_donnees_annees = $wpdb->get_results($query_annees);
        foreach($tab_donnees_annees as $results){
            $tab_annees[] = $results->annee;
        }

        $query_albums = "SELECT album FROM " . $wpdb->prefix . "album_webtv_plugin WHERE id='$id_albums' LIMIT 1;";
        $tab_donnees_albums = $wpdb->get_results($query_albums);
        foreach($tab_donnees_albums as $results){
            $tab_albums[] = $results->album;
        }

        $query="SELECT url,titre FROM " . $wpdb->prefix . "videos_webtv_plugin WHERE id='$id_video' LIMIT 1;";
        $re=$wpdb->get_results($query);
        foreach($re as $vid){
            $tab_url[]=$vid->url;
            $tab_titres[]=$vid->titre; 
        }
    }
    $tab_artistes[] = $artiste; 

}
//Ajouter les pubs externes sélectionnées par l'utilisateur dans la page nouveaux réglages
function ajouter_pubs_externes($pubsexternes){
    global $wpdb;
    global $tab_url;
    global $tab_titres;
    global $tab_artistes_id;
    global $tab_artistes;
    global $tab_ids;

    $recup_externes="SELECT video_id,artiste_id FROM " . $wpdb->prefix . "relation_webtv_plugin WHERE genre_id='10' ORDER BY RAND() LIMIT 1; ";
    $res1=$wpdb->get_results($recup_externes);
    foreach($res1 as $r){
        $id_video = $id->video_id;
        $id_genres = $id->genre_id;
        $id_annees = $id->annee_id;
        $id_albums = $id->album_id;
        $id_artistes =$id->artiste_id;

        $query3="SELECT nom FROM " . $wpdb->prefix . "artiste_webtv_plugin WHERE id='$id_artistes';";
        $rms=$wpdb->get_results($query3);
        foreach($rms as $re){
            $art=$re->nom;
            $tab_artistes[]=$art;
        }

        $query_genre = "SELECT Genre FROM " . $wpdb->prefix . "genre_webtv_plugin WHERE id='$id_genres' LIMIT 1;";
        $tab_donnees_genre = $wpdb->get_results($query_genre);
        foreach($tab_donnees_genre as $results){
            $tab_genres[] = $results->Genre;
        }

        $query_annees = "SELECT annee FROM " . $wpdb->prefix . "annee_webtv_plugin WHERE id='$id_annees' LIMIT 1;";
        $tab_donnees_annees = $wpdb->get_results($query_annees);
        foreach($tab_donnees_annees as $results){
            $tab_annees[] = $results->annee;
        }

        $query_albums = "SELECT album FROM " . $wpdb->prefix . "album_webtv_plugin WHERE id='$id_albums' LIMIT 1;";
        $tab_donnees_albums = $wpdb->get_results($query_albums);
        foreach($tab_donnees_albums as $results){
            $tab_albums[] = $results->album;
        }

        $query_videos="SELECT url,titre FROM " . $wpdb->prefix . "videos_webtv_plugin WHERE id='$id_video';";
        $result=$wpdb->get_results($query_videos);
        foreach($result as $tt){
            $tab_url[]=$tt->url;
            $tab_titres[]=$tt->titre;
            // $tab_artistes[]='Pub';
        }
    }
}
//Ajouter les pubs internes sélectionnées par l'utilisateur dans la page nouveaux réglages
function ajouter_pubs_internes($pubsinternes){
    global $wpdb;
    global $tab_url;
    global $tab_titres;
    global $tab_artistes_id;
    global $tab_ids;
    global $tab_artistes;
    $art;
    $recup_internes="SELECT video_id,artiste_id FROM " . $wpdb->prefix . "relation_webtv_plugin WHERE genre_id='10' ORDER BY RAND() LIMIT 1;";
    $res=$wpdb->get_results($recup_internes);
    foreach($res as $t){
        $id_video = $id->video_id;
        $id_genres = $id->genre_id;
        $id_annees = $id->annee_id;
        $id_albums = $id->album_id;
        $id_artistes =$id->artiste_id;

        $query3="SELECT nom FROM " . $wpdb->prefix . "artiste_webtv_plugin WHERE id='$id_artistes';";
        $rms=$wpdb->get_results($query3);
        foreach($rms as $re){
            $art=$re->nom;
            $tab_artistes[]=$art;
        }

        $query_genre = "SELECT Genre FROM " . $wpdb->prefix . "genre_webtv_plugin WHERE id='$id_genres' LIMIT 1;";
        $tab_donnees_genre = $wpdb->get_results($query_genre);
        foreach($tab_donnees_genre as $results){
            $tab_genres[] = $results->Genre;
        }

        $query_annees = "SELECT annee FROM " . $wpdb->prefix . "annee_webtv_plugin WHERE id='$id_annees' LIMIT 1;";
        $tab_donnees_annees = $wpdb->get_results($query_annees);
        foreach($tab_donnees_annees as $results){
            $tab_annees[] = $results->annee;
        }

        $query_albums = "SELECT album FROM " . $wpdb->prefix . "album_webtv_plugin WHERE id='$id_albums' LIMIT 1;";
        $tab_donnees_albums = $wpdb->get_results($query_albums);
        foreach($tab_donnees_albums as $results){
            $tab_albums[] = $results->album;
        }

        $query_videos="SELECT url,titre FROM " . $wpdb->prefix . "videos_webtv_plugin WHERE id='$id_video';";
        $result=$wpdb->get_results($query_videos);
        foreach($result as $tt){
            $tab_url[]=$tt->url;
            $tab_titres[]=$tt->titre;
            // $tab_artistes[]='Pub';
        }
    }


}
/*
*  Fonction : Récupere un nombre $limt de vidéos du genre $genre en ajoutant l'url et le titre au tableau tab_url et tab_titres
*  Deplus la fonction trie les artistes et les genres en fonction des titres et des url des clips à fin de remplir correctement
*  les tableaux, $tab_artistes_id, $tab_url, $tab_artistes, $tab_titres, $tab_genres. Ces tableaux servent particulièrement au remplissage de la fonctions
*  generer_la_playlist dans le fichier traitement_donnees.php qui rempli la table playlist_par_defaut_webtv_plugin.
*/

function recup_videos($genre,$limit,$annee_max, $annee_min, $qualite_min){
    global $tab_artistes_id;
    global $tab_url;
    global $tab_artistes;
    global $tab_titres;
    global $tab_ids;
    global $wpdb;
    global $tab_genres;

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
            $tab_genres[] = $results->Genre;
        }

        $query_artistes = "SELECT nom FROM " . $wpdb->prefix . "artiste_webtv_plugin WHERE id='$id_art1' LIMIT 1;";
        $tab_donnees_artistes = $wpdb->get_results($query_artistes);
        foreach($tab_donnees_artistes as $results){
            $tab_artistes[] = $results->nom;
        }

        $query_url_titre = "SELECT url,titre FROM " . $wpdb->prefix . "videos_webtv_plugin WHERE id='$id_video' LIMIT 1;";
        $tab_donnees_url_titre = $wpdb->get_results($query_url_titre);
        foreach($tab_donnees_url_titre as $s){
            $tab_url[]=$s->url;
            $tab_titres[]=$s->titre;
        }

        $query_annees = "SELECT annee FROM " . $wpdb->prefix . "annee_webtv_plugin WHERE id='$id_annees' LIMIT 1;";
        $tab_donnees_annees = $wpdb->get_results($query_annees);
        foreach($tab_donnees_annees as $results){
            $tab_annees[] = $results->annee;
        }

        $query_albums = "SELECT album FROM " . $wpdb->prefix . "album_webtv_plugin WHERE id='$id_albums' LIMIT 1;";
        $tab_donnees_albums = $wpdb->get_results($query_albums);
        foreach($tab_donnees_albums as $results){
            $tab_albums[] = $results->album;
        }
    }





}


//
/*function recuperer_artistes_nouvelle_playlist(){
    global $wpdb;
    global $tab_url;
    global $tab_artistes;
    global $tab_artistes_id;
   //

    for($i=0;$i<sizeof($tab_artistes_id);$i++){
        $id=$tab_artistes_id[$i];
        $query="SELECT nom FROM " . $wpdb->prefix . "artiste_webtv_plugin WHERE id='$id';";
        $result=$wpdb->get_results($query);
        foreach($result as $r){
            $tab_artistes[]=$r->nom;
        }
    }
    //$query="SELECT nom FROM " . $wpdb->prefix . "artiste_webtv_plugin WHERE id='';";
    //var_dump($tab_artistes);
}*/




?>
