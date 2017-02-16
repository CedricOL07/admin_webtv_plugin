<?php 


/**************************************************************************************************************************
**
**
**        Fichier contenant les fonctions exécutées par les différentes reqûetes ajax de la page GESTION DE CONTENU
**                                                                                                                
**
*******************************************************************************************************************************/



add_action( 'wp_ajax_recup_genres_gestionbdd_pluginwebtv', 'recup_genres_gestionbdd_pluginwebtv' );
add_action( 'wp_ajax_recup_qualite_gestionbdd_pluginwebtv', 'recup_qualite_gestionbdd_pluginwebtv' );
add_action( 'wp_ajax_get_song_by_genre_gestionbdd_pluginwebtv', 'get_song_by_genre_gestionbdd_pluginwebtv' );
add_action( 'wp_ajax_get_song_by_artiste_gestionbdd_pluginwebtv', 'get_song_by_artiste_gestionbdd_pluginwebtv' );
add_action( 'wp_ajax_get_song_by_name_gestionbdd_pluginwebtv', 'get_song_by_name_gestionbdd_pluginwebtv' );
add_action( 'wp_ajax_recup_artistes_gestionbdd_pluginwebtv', 'recup_artistes_gestionbdd_pluginwebtv' );
add_action( 'wp_ajax_supprimer_tous_les_morceaux_artiste_gestionbdd_pluginwebtv', 'supprimer_tous_les_morceaux_artiste_gestionbdd_pluginwebtv' );
add_action( 'wp_ajax_recup_titres_gestionbdd_pluginwebtv', 'recup_titres_gestionbdd_pluginwebtv' );
add_action( 'wp_ajax_supprimer_morceau_from_bdd_gestionbdd_pluginwebtv', 'supprimer_morceau_from_bdd_gestionbdd_pluginwebtv' );
add_action('wp_ajax_supprimer_reglage_from_bdd','supprimer_reglage_from_bdd');

add_action( 'wp_ajax_recup_pubs_externes', 'recup_pubs_externes' );
add_action( 'wp_ajax_recup_pubs_internes', 'recup_pubs_internes' );
add_action( 'wp_ajax_recuperer_genres', 'recuperer_genres' );
add_action( 'wp_ajax_recuperer_artistes', 'recuperer_artistes' );







//Récupère les artistes de la base de données
function recup_artistes_gestionbdd_pluginwebtv(){
    global $wpdb;
    $query="SELECT nom FROM " . $wpdb->prefix . "artiste_webtv_plugin;";
    $result=$wpdb->get_results($query);
    wp_send_json_success($result);
}

//Récupère les titres de toutes les vidéos de la base de données
function recup_titres_gestionbdd_pluginwebtv(){
    global $wpdb;
    $query="SELECT titre FROM " . $wpdb->prefix . "videos_webtv_plugin;";
    $result=$wpdb->get_results($query);
    wp_send_json_success($result);
}


//Récupère les genres de la base de données
function recup_genres_gestionbdd_pluginwebtv(){
    global $wpdb;
    $sql_query = "SELECT Genre FROM " . $wpdb->prefix . "genre_webtv_plugin;";
    $tableau_donnees = $wpdb->get_results($sql_query);
    wp_send_json_success($tableau_donnees);
    wp_die();
}

//Récupère les valeurs de qualité dans le base de données
function recup_qualite_gestionbdd_pluginwebtv(){
    global $wpdb;
    $sql_query = "SELECT valeur FROM " . $wpdb->prefix . "qualite_webtv_plugin;";
    $tableau_donnees = $wpdb->get_results($sql_query);
    wp_send_json_success($tableau_donnees);
    wp_die();

}

//Récupère les vidéos d'un certain genre contenu dans la base de données
function get_song_by_genre_gestionbdd_pluginwebtv(){

    global $wpdb;
    $genre;

    if(isset($_POST['genre'])){
        $genre=$_POST['genre'];

    }else{
        $genre='';
    }



    function recup_artiste_gestionbdd_pluginwebtv($id){
        global $wpdb;
        $query = "SELECT nom FROM " . $wpdb->prefix . "artiste_webtv_plugin WHERE id='$id'";
        $final=$wpdb->get_results($query);
        foreach($final as $art){
            return $art->nom;
        }

    }
    function recup_genre_gestionbdd_pluginwebtv($id){
        global $wpdb;
        $query = "SELECT Genre FROM " . $wpdb->prefix . "genre_webtv_plugin WHERE id='$id'";
        $final=$wpdb->get_results($query);
        foreach($final as $genres){
            return $genres->Genre;
        }

    }
    function recup_video_url_gestionbdd_pluginwebtv($id){
        global $wpdb;
        $query = "SELECT titre,url FROM " . $wpdb->prefix . "videos_webtv_plugin WHERE id='$id'";
        $final=$wpdb->get_results($query);
        foreach($final as $urls){
            return $urls->url;
        }

    }
    function recup_video_titre_gestionbdd_pluginwebtv($id){
        global $wpdb;
        $query = "SELECT titre,url FROM " . $wpdb->prefix . "videos_webtv_plugin WHERE id='$id'";
        $final=$wpdb->get_results($query);
        foreach($final as $titres){
            return $titres->titre;
        }

    }
    function recup_annee_gestionbdd_pluginwebtv($id){
        global $wpdb;
        $query = "SELECT annee FROM " . $wpdb->prefix . "annee_webtv_plugin WHERE id='$id'";
        $final=$wpdb->get_results($query);
        foreach($final as $annees){
            return $annees->annee;
        }
    }
    function recup_album_gestionbdd_pluginwebtv($id){
        global $wpdb;
        $query = "SELECT album FROM " . $wpdb->prefix . "album_webtv_plugin  WHERE id='$id'";
        $final=$wpdb->get_results($query);
        foreach($final as $albums){
            return $albums->album;
        }
    }


    $tableau_videos=array(
        'titre'=>'',
        'url'=>'',
        'artiste'=>'',
        'genre'=>'',
        'album'=>'',
        'annee'=>'',
        'qualite'=>''

    );
    $tableau_glob=array();

    $query = "SELECT id FROM " . $wpdb->prefix . "genre_webtv_plugin WHERE Genre='$genre';";
    $genre_result=$wpdb->get_results($query);
    foreach($genre_result as $r){
        $id_genre=$r->id;
        $query1 ="SELECT * FROM " . $wpdb->prefix . "relation_webtv_plugin  WHERE genre_id='$id_genre';";
        $result=$wpdb->get_results($query1);
        foreach($result as $row){

            $s=recup_artiste_gestionbdd_pluginwebtv($row->artiste_id);
            $s1=recup_video_url_gestionbdd_pluginwebtv($row->video_id);
            $s2=recup_video_titre_gestionbdd_pluginwebtv($row->video_id);
            $s3=recup_annee_gestionbdd_pluginwebtv($row->annee_id);
            $s4=recup_album_gestionbdd_pluginwebtv($row->album_id);
            $s5=$row->qualite_id;

            $tableau_videos['titre']=$s2;
            $tableau_videos['artiste']=$s;
            $tableau_videos['url']=$s1;
            $tableau_videos['genre']=$genre;
            $tableau_videos['album']=$s4;
            $tableau_videos['annee']=$s3;
            $tableau_videos['qualite']=$s5;
            array_push($tableau_glob,$tableau_videos);  
        }
    }


    wp_send_json_success($tableau_glob);
    wp_die();
}

//Récupère les vidéos d'un certain artiste contenu dans le base de données
function get_song_by_artiste_gestionbdd_pluginwebtv(){

    global $wpdb;
    $artiste;

    if(isset($_POST['artiste'])){
        $artiste=$_POST['artiste'];

    }else{
        $artiste='';
    }



    function recup_artiste_gestionbdd_pluginwebtv($id){
        global $wpdb;
        $query = "SELECT nom FROM " . $wpdb->prefix . "artiste_webtv_plugin WHERE id='$id'";
        $final=$wpdb->get_results($query);
        foreach($final as $art){
            return $art->nom;
        }

    }
    function recup_genre_gestionbdd_pluginwebtv($id){
        global $wpdb;
        $query = "SELECT Genre FROM " . $wpdb->prefix . "genre_webtv_plugin WHERE id='$id'";
        $final=$wpdb->get_results($query);
        foreach($final as $genres){
            return $genres->Genre;
        }

    }
    function recup_video_url_gestionbdd_pluginwebtv($id){
        global $wpdb;
        $query = "SELECT titre,url FROM " . $wpdb->prefix . "videos_webtv_plugin WHERE id='$id'";
        $final=$wpdb->get_results($query);
        foreach($final as $urls){
            return $urls->url;
        }

    }
    function recup_video_titre_gestionbdd_pluginwebtv($id){
        global $wpdb;
        $query = "SELECT titre,url FROM " . $wpdb->prefix . "videos_webtv_plugin WHERE id='$id'";
        $final=$wpdb->get_results($query);
        foreach($final as $titres){
            return $titres->titre;
        }

    }
    function recup_annee_gestionbdd_pluginwebtv($id){
        global $wpdb;
        $query = "SELECT annee FROM " . $wpdb->prefix . "annee_webtv_plugin WHERE id='$id'";
        $final=$wpdb->get_results($query);
        foreach($final as $annees){
            return $annees->annee;
        }
    }
    function recup_album_gestionbdd_pluginwebtv($id){
        global $wpdb;
        $query = "SELECT album FROM " . $wpdb->prefix . "album_webtv_plugin  WHERE id='$id'";
        $final=$wpdb->get_results($query);
        foreach($final as $albums){
            return $albums->album;
        }
    }


    $tableau_videos=array(
        'titre'=>'',
        'url'=>'',
        'artiste'=>'',
        'genre'=>'',
        'album'=>'',
        'annee'=>'',
        'qualite'=>''

    );
    $tableau_glob=array();


    $query = "SELECT id FROM " . $wpdb->prefix . "artiste_webtv_plugin WHERE nom='$artiste';";
    $genre_result=$wpdb->get_results($query);
   if(sizeof($genre_result)==0){
       
       wp_send_json_success($genre_result);
       wp_die();
   }else{
       foreach($genre_result as $r){
           // echo $r->id;
           $id_genre=$r->id;
           $query1 ="SELECT * FROM " . $wpdb->prefix . "relation_webtv_plugin  WHERE artiste_id='$id_genre';";
           $result=$wpdb->get_results($query1);
           foreach($result as $row){

               $s=recup_genre_gestionbdd_pluginwebtv($row->genre_id);
               $s1=recup_video_url_gestionbdd_pluginwebtv($row->video_id);
               $s2=recup_video_titre_gestionbdd_pluginwebtv($row->video_id);
               $s3=recup_annee_gestionbdd_pluginwebtv($row->annee_id);
               $s4=recup_album_gestionbdd_pluginwebtv($row->album_id);
               $s5=$row->qualite_id;

               $tableau_videos['titre']=$s2;
               $tableau_videos['artiste']=$artiste;
               $tableau_videos['url']=$s1;
               $tableau_videos['genre']=$s;
               $tableau_videos['album']=$s4;
               $tableau_videos['annee']=$s3;
               $tableau_videos['qualite']=$s5;
               array_push($tableau_glob,$tableau_videos);  
           }
       }


       wp_send_json_success($tableau_glob);
       wp_die();
   }
    
}


//Récupère l'url d'un clip avec son titre
function get_song_by_name_gestionbdd_pluginwebtv(){
    
    global $wpdb;
    $name;
    
    if(isset($_POST['titre'])){
        $name=$_POST['titre'];

    }else{
        $name='';
    }
    
    $query="SELECT titre FROM " . $wpdb->prefix . "videos_webtv_plugin WHERE titre='$name' ;";
    $result=$wpdb->get_results($query);
    //var_dump($result);
     
    
    

}

//Supprime les morceaux d'un artiste passé un paramètre de la reqûete ajax de la base de données
function supprimer_tous_les_morceaux_artiste_gestionbdd_pluginwebtv(){
    global $wpdb;
    if(isset($_POST['artiste'])){
        $artiste=$_POST['artiste'];

    }else{
        $artiste='';
    }
    
    $artiste_dans_base;
    
    $query="SELECT id FROM " . $wpdb->prefix . "artiste_webtv_plugin WHERE UPPER(nom)=UPPER('$artiste');";
    $result=$wpdb->get_results($query);
    if($result==NULL){
        wp_send_json_success('NULL');
    }else{
        foreach($result as $res){

            $id=$res->id;
            $query1="SELECT video_id FROM " . $wpdb->prefix . "relation_webtv_plugin WHERE artiste_id='$id';";
            $result1=$wpdb->get_results($query1);
            foreach($result1 as $res1){
                $id_video=$res1->video_id;
                $query2="DELETE FROM " . $wpdb->prefix . "videos_webtv_plugin WHERE id='$id_video';";
                $result3=$wpdb->query($query2);
            }
        }
    }

  
    
}

//Supprimer le morceau passé en paramètre de la requête ajax de la base de données
function supprimer_morceau_from_bdd_gestionbdd_pluginwebtv(){
    global $wpdb;
    $titre;
    if(isset($_POST['titre'])){
        $titre=$_POST['titre'];

    }else{
        $titre='';
    }

    
    $query="DELETE FROM " . $wpdb->prefix . "videos_webtv_plugin WHERE titre='$titre';";
    $wpdb->query($query);
    
}

//Supprime le réglage de la base de données à partir de son nom 
function supprimer_reglage_from_bdd(){
    $nom_reglage;
    if(isset($_POST['nom_reglage'])){
        $nom_reglage=$_POST['nom_reglage'];
        
        $query="DELETE FROM " . $wpdb->prefix . "playlistenregistrees_webtv_plugin WHERE nom='$nom_reglage';";
        $wpdb->query($query);
        
    }else{
        wp_send_json_success('vide');
    }

}


function recup_pubs_externes(){
    global $wpdb;
    $tableau_pubs_externes=array();
    $sql_query = "SELECT video_id FROM " . $wpdb->prefix . "relation_webtv_plugin WHERE genre_id='11';";
    $tableau_donnees=$wpdb->get_results($sql_query);
    foreach($tableau_donnees as $id_pub){

        $id=$id_pub->video_id;
        $sql_query1 = "SELECT titre,url FROM " . $wpdb->prefix . "videos_webtv_plugin WHERE id='$id';";

        $tableau_pub = $wpdb->get_results($sql_query1);
        foreach($tableau_pub as $p){
            array_push($tableau_pubs_externes,$p->titre);
        }    
    }
    wp_send_json_success($tableau_pubs_externes);

    wp_die();
}



function recup_pubs_internes(){
    global $wpdb;
    $sql_query = "SELECT video_id FROM " . $wpdb->prefix . "relation_webtv_plugin WHERE genre_id='10';";
    $tableau_donnees=$wpdb->get_results($sql_query);

    $tableau_pubs_internes=array();

    foreach($tableau_donnees as $id_pub){

        $id=$id_pub->video_id;
        $sql_query1 = "SELECT titre,url FROM " . $wpdb->prefix . "videos_webtv_plugin WHERE id='$id';";
        $tableau_pub = $wpdb->get_results($sql_query1);
        foreach($tableau_pub as $p){
            array_push($tableau_pubs_internes,$p->titre);
        }    
    }

    wp_send_json_success($tableau_pubs_internes);

    wp_die();
}



function recuperer_artistes(){
    global $wpdb;
    $sql_query = "SELECT nom FROM " . $wpdb->prefix . "artiste_webtv_plugin;";
    $result=$wpdb->get_results($sql_query);
    wp_send_json_success($result);
    wp_die();
}

function recuperer_genres(){
    global $wpdb;
    $sql_query = "SELECT Genre FROM " . $wpdb->prefix . "genre_webtv_plugin;";
    $result=$wpdb->get_results($sql_query);
    wp_send_json_success($result);
    wp_die();
}








?>