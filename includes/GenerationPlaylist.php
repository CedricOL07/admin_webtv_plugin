<?php


/**************************************************************************************************************************
**
**
**                                 Fonctions php utilisées pour générer une playlist
**
**
*******************************************************************************************************************************/





add_action( 'pluginwebtv_generer_playlist', 'generer_playlist',10,11);
add_action( 'pluginwebtv_recup_videos', 'recup_videos',15,2);
add_action( 'pluginwebtv_verifier_restant', 'verifier_restant',15,1);
add_action( 'pluginwebtv_ajouter_hightlight', 'ajouter_hightlight',16,1);
add_action( 'pluginwebtv_ajouter_pubs_internes', 'ajouter_pubs_internes',17,2);
add_action( 'pluginwebtv_ajouter_pubs_externes', 'ajouter_pubs_externes',17,2);
//add_action( 'pluginwebtv_recuperer_artistes_nouvelle_playlist', 'recuperer_artistes_nouvelle_playlist');



//Variables globales qu'on va remplir avec les morceaux de la playlist
$tab_url=array();
$tab_titres=array();
//$tab_artistes=array();
//$tab_artistes_id=array();


//Génère une playlist de 8 morceaux selon les pourcentages choisit par l'utilisateur
function generer_playlist($pourcentagepoprock,$pourcentagehiphop,$pourcentagejazzblues,$pourcentagemusiquemonde,$pourcentagehardrock,$pourcentageelectro,$pourcentagechanson,$pourcentageautres,$pubsinternes,$pubsexternes,$artistehighlight){


    global $tab_url;
    global $tab_titres;
    global $tab_artistes;
    $poprock=$pourcentagepoprock;
    $hiphop=$pourcentagehiphop;
    $jazzblues=$pourcentagejazzblues;
    $musiquemonde=$pourcentagemusiquemonde;
    $hardrock=$pourcentagehardrock;
    $electro=$pourcentageelectro;
    $chanson=$pourcentagechanson;
    $autres=$pourcentageautres;

    // Variables utiles
    $compteur=0;
    $genre_id;

    $tableaupourcentages=array();

    $tableaupourcentages[0] = $pourcentagepoprock;
    $tableaupourcentages[1] =  $pourcentagehiphop;
    $tableaupourcentages[2] =  $pourcentagejazzblues;
    $tableaupourcentages[3] = $pourcentagemusiquemonde;
    $tableaupourcentages[4] = $pourcentagehardrock;
    $tableaupourcentages[5] = $pourcentageelectro;
    $tableaupourcentages[6] = $pourcentagechanson;
    $tableaupourcentages[7] = $pourcentageautres;


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


        if($valeur_camembert<20){

          do_action('pluginwebtv_recup_videos',$genre_id,1);
        }else{
            if($valeur_camembert<30){

               do_action('pluginwebtv_recup_videos',$genre_id,2);
            }else{
                if($valeur_camembert<40){
                   do_action('pluginwebtv_recup_videos',$genre_id,3);
                }else{
                    if($valeur_camembert<50){
                       do_action('pluginwebtv_recup_videos',$genre_id,4);

                    }else{
                        if($valeur_camembert<60){
                           do_action('pluginwebtv_recup_videos',$genre_id,5);

                        }else{
                            if($valeur_camembert<70){
                              do_action('pluginwebtv_recup_videos',$genre_id,6);

                            }else{
                                if($valeur_camembert<80){
                                  do_action('pluginwebtv_recup_videos',$genre_id,7);

                                }else{
                                    if($valeur_camembert<90){
                                        do_action('pluginwebtv_recup_videos',$genre_id,8);

                                    }else{
                                        if($valeur_camembert<100){
                                            do_action('pluginwebtv_recup_videos',$genre_id,9);
                                        }
                                        if($valeur_camembert==100){

                                           do_action('pluginwebtv_recup_videos',$genre_id,12);

                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }// -----\ Fin du else /----
    }//----\ Fin du for($i=0;$i<sizeof($tableaupourcentages);$i++) /--------

    //echo 'test tabrul';
    //var_dump($tab_url);

    $nb_track=$compteur;


    //do_action('pluginwebtv_verifier_restant',$tableaupourcentages);

    if($artistehighlight!= NULL){
        do_action('pluginwebtv_ajouter_hightlight',$artistehighlight);
    }
    if($pubsinternes != NULL){
        do_action('pluginwebtv_ajouter_pubs_internes',$pubsinternes);
    }
    //ajouter_pubs($pubsinternes,$pubsexternes);
    if($pubsexternes != NULL){
        do_action('pluginwebtv_ajouter_pubs_esxterne',$pubsexternes);
    }
   // do_action('pluginwebtv_recuperer_artistes_nouvelle_playlist');


}


//Complète la playlist avec 4 morceaux choisi selon l'ordre d'importance des genres
function verifier_restant($tableaupourcentages){

    global $tab_url;
    global $tab_titres;
    global $tab_artistes_id;
    global $tab_artistes;
    global $tab_genres;
    global $nb_track;
    global $wpdb;
    //$tab_donnees = array();

    // Compléter le remplissage (gestion des tracks restantes)
    // Teste l'égalité entre les pourcentages
    /*
    count : compte les éléments d'un tableau
    array_unique : élime tous les doublons
    */
    if (count(array_unique($tableaupourcentages))==1)// Si tous les pourcentages sont égaux
    {

        /*unset($tab_url);
        unset($tab_titres);*/

        //echo 'tous les pourcentages sont égaux';
        //Tableau avec tous les ids video d'un genre
        $tableaugenres = array(2,3,4,5,7,8,9,12);
        //shuffle($tableaugenres); mettez la playlist en mode aléatoire

        foreach($tableaugenres as $results)
        {

            $id_genre= $results;
//ORDER BY RAND()
            $sql_query="SELECT video_id,artiste_id,genre_id FROM " . $wpdb->prefix . "relation_webtv_plugin WHERE genre_id='$id_genre' LIMIT 1;";// limit à 1 car tous les pourcentage sont égaux à 12.5<20 donc 1 clips par genre.
            $tabvideos_id=$wpdb->get_results($sql_query);

            foreach($tabvideos_id as $id){
                $id1=$id->video_id;
                //$id_art1=$id->artiste_id;
                $sql_query2 = "SELECT url,titre FROM " . $wpdb->prefix . "videos_webtv_plugin WHERE id='$id1' ;";
                $tab_url[] = $wpdb->get_var($sql_query2, 0);
                $tab_titres[]= $wpdb->get_var($sql_query2,1);
                $tab_genres[] = $id->genre_id;
                /*$tab_donnees->append(array($url, $titres));
                var_dump($tab_donnees);*/
              /*  foreach($tab_donnees as $t){
                    $tab_url[]= $t[0];
                    $tab_titres[]=$t[1];
                }*/
            }
        }

    }else // Si les pourcentages sont différents entre eux
    {
    /*  unset($tab_url);
      unset($tab_titres);*/
        //   echo 'pourcentages pas égaux';

        $track_restante=12-$nb_track;

        $tab_pourcentages=$tableaupourcentages;



        for ($j=0; $j < $track_restante; $j++)	//combien de fois on va parcourir le tableau_pourcentages
        {
            for ($i=0; $i<sizeof($tab_pourcentages)-1; $i++)	//parcourir le tableau_poucentages pour sélectionner le pourcentage + grand
            {
                if ($tab_pourcentages[$i+1]>$tab_pourcentages[$i])	//case correspondant au pourcentage + grand
                {
                    $u=$i+1;
                }
                else
                {
                    $u=$i;
                }
                if ($u==0)
                {
                    $genre_id=5; //correspond au Pop-rock
                }
                if ($u==1)
                {
                    $genre_id=3; //correspond au Hip-hop & Reggae
                }
                if ($u==2)
                {
                    $genre_id=7; //correspond au Jazz & Blues
                }
                if ($u==3)
                {
                    $genre_id=9; //correspond au Musique du monde
                }
                if ($u==4)
                {
                    $genre_id=2; //correspond au Hard-rock & metal
                }
                if ($u==5)
                {
                    $genre_id=4; //correspond au Musique électronique
                }
                if ($u==6)
                {
                    $genre_id=8; //correspond à Chanson
                }
                if ($u==7)
                {
                    $genre_id=12; //correspond à Autres
                }

            }
            $sql_query1 = "SELECT video_id,artiste_id FROM " . $wpdb->prefix . "relation_webtv_plugin WHERE genre_id='$genre_id' ORDER BY RAND() LIMIT 1;";
            $tabvideos_id=$wpdb->get_results($sql_query1);

            foreach($tabvideos_id as $id){
                $id2=$id->video_id;
                //$tab_artistes_id[]=$id->artiste_id;
                $id_art1=$id->artiste_id;

               /* $query3="SELECT nom FROM " . $wpdb->prefix . "artiste_webtv_plugin WHERE id='$id_art1';";
                $rms=$wpdb->get_results($query3);
                foreach($rms as $re){
                    $art=$re->nom;
                    $tab_artistes[]=$art;
                }*/


                $sql_query2 = "SELECT url, titre FROM " . $wpdb->prefix . "videos_webtv_plugin WHERE id='$id2';";
                $tab_donnees=$wpdb->get_results($sql_query2);
                foreach($tab_donnees as $tab){
                    $tab_url[]=$tab->url;
                    $tab_titres[]=$tab->titre;
                }
            }
            echo $tab_url[1];
            $tab_pourcentages[$u] = 0;
        }
    }

}

//Ajouter l'artiste à mettre en avant sélectionné par l'utilisateur
function ajouter_hightlight($artiste){
    global $wpdb;
    global $tab_url;
    global $tab_titres;
    global $tab_artistes_id;
    global $tab_artistes;

   // $tab_artistes[]=$artiste;

    $art;
    $recup_idartiste="SELECT id FROM " . $wpdb->prefix . "artiste_webtv_plugin WHERE nom='$artiste'";
    $result=$wpdb->get_results($recup_idartiste);
    foreach($result as $r){
        $art=$r->id;
    }
    //On récupère une seule vidéo de l'artiste
    $sql_query1="SELECT video_id,artiste_id FROM " . $wpdb->prefix . "relation_webtv_plugin WHERE artiste_id='$art' ORDER BY RAND() LIMIT 1;";
    $resultat=$wpdb->get_results($sql_query1);
    foreach($resultat as $result){
        $v=$result->video_id;



        $query="SELECT url,titre FROM " . $wpdb->prefix . "videos_webtv_plugin WHERE id='$v';";
        $re=$wpdb->get_results($query);
        foreach($re as $vid){
            $tab_url[]=$vid->url;
            $tab_titres[]=$vid->titre;
        }
    }

}
//Ajouter les pubs externes sélectionnées par l'utilisateur dans la page nouveaux réglages
function ajouter_pubs_externes($pubsexternes){
    global $wpdb;
    global $tab_url;
    global $tab_titres;
    global $tab_artistes_id;
    global $tab_artistes;

    $recup_externes="SELECT video_id,artiste_id FROM " . $wpdb->prefix . "relation_webtv_plugin WHERE genre_id='10' ORDER BY RAND() LIMIT 1; ";
    $res1=$wpdb->get_results($recup_externes);
    foreach($res1 as $r){
        $id1=$r->video_id;
       // $tab_artistes_id[]=$r->artiste_id;
        $id_art1=$id->artiste_id;

      /*  $query3="SELECT nom FROM " . $wpdb->prefix . "artiste_webtv_plugin WHERE id='$id_art1';";
        $rms=$wpdb->get_results($query3);
        foreach($rms as $re){
            $art=$re->nom;
            $tab_artistes[]=$art;
        }*/

        $s="SELECT url,titre FROM " . $wpdb->prefix . "videos_webtv_plugin WHERE id='$id1';";
        $result=$wpdb->get_results($s);
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
    //  global $tab_artistes;
    global $tab_artistes;
    $art;
    $recup_internes="SELECT video_id,artiste_id FROM " . $wpdb->prefix . "relation_webtv_plugin WHERE genre_id='10' ORDER BY RAND() LIMIT 1;";
    $res=$wpdb->get_results($recup_internes);
    foreach($res as $t){
        $id=$t->video_id;
        //$tab_artistes_id[]=$t->artiste_id;
        $id_art1=$id->artiste_id;

       /* $query3="SELECT nom FROM " . $wpdb->prefix . "artiste_webtv_plugin WHERE id='$id_art1';";
        $rms=$wpdb->get_results($query3);
        foreach($rms as $re){
            $art=$re->nom;
            $tab_artistes[]=$art;
        }*/

        $s="SELECT url,titre FROM " . $wpdb->prefix . "videos_webtv_plugin WHERE id='$id';";
        $result=$wpdb->get_results($s);
        foreach($result as $tt){
            $tab_url[]=$tt->url;
            $tab_titres[]=$tt->titre;
            // $tab_artistes[]='Pub';
        }
    }


}
//Récupere un nombre $limt de vidéos du genre $genre en ajoutant l'url et le titre au tableau tab_url et tab_titres
function recup_videos($genre,$limit){
    global $tab_artistes_id;
    global $tab_url;
    global $tab_artistes;
    global $tab_titres;
    global $wpdb;
    global $tab_genres;
    $sql_query1="SELECT video_id,artiste_id,genre_id FROM " . $wpdb->prefix . "relation_webtv_plugin WHERE genre_id='$genre'  LIMIT $limit;";
//ORDER BY RAND()
    $tabvideos=$wpdb->get_results($sql_query1);

    foreach($tabvideos as $id){

        $id_video = $id->video_id;
        $id_art1 = $id->artiste_id;
        $tab_genres[] = $id->genre_id;

        $query_artistes = "SELECT nom FROM " . $wpdb->prefix . "artiste_webtv_plugin WHERE id='$id_art1' LIMIT 1;";
        $tab_donnees = $wpdb->get_results($query_artistes);

        foreach($tab_donnees as $results){

        $tab_artistes[] = $results->nom;

        }

        $query_url_titre = "SELECT url,titre FROM " . $wpdb->prefix . "videos_webtv_plugin WHERE id='$id_video' LIMIT 1;";
        $tab_donnees = $wpdb->get_results($query_url_titre);

        foreach($tab_donnees as $s){

            $tab_url[]=$s->url;

            $tab_titres[]=$s->titre;

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
