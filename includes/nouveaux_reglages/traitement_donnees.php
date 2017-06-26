<?php


/**************************************************************************************************************************
**
**
**        Fichier contenant les fonctions exécutées par les différentes reqûetes ajax de la page NOUVEAUX REGLAGES
**
**
*******************************************************************************************************************************/
/*
Appel des différentes fonctions du programme
*/

add_action( 'wp_ajax_traitement_infos_nouveaux_reglages', 'traitement_infos_nouveaux_reglages' );
add_action( 'wp_ajax_verifier_dates_debut_calendrier', 'verifier_dates_debut_calendrier' );
add_action( 'wp_ajax_verifier_dates_fin_calendrier', 'verifier_dates_fin_calendrier' );

add_action( 'wp_ajax_trouver_creneau_dispo', 'trouver_creneau_dispo' );
add_action('wp_ajax_recuperer_programmation','recuperer_programmation');
add_action('wp_ajax_recuperer_noms_reglages','recuperer_noms_reglages');
add_action('wp_ajax_recuperer_derniers_pourcentages_enregistrees','recuperer_derniers_pourcentages_enregistrees');
add_action('wp_ajax_recuperer_tous_reglages_enregistres','recuperer_tous_reglages_enregistres');
add_action('wp_ajax_supprimer_toutes_videos','supprimer_toutes_videos');
add_action('wp_ajax_inserer_contenu_pluginwebtv','inserer_contenu_pluginwebtv');
add_action( 'pluginwebtv_generer_la_playlist', 'generer_la_playlist');
add_action('wp_ajax_recuperer_artiste_with_title','recuperer_artiste_with_title');

add_action( 'pluginwebtv_eviter_repetition_tous_les_n_morceaux', 'eviter_repetition_tous_les_n_morceaux');
add_action('wp_ajax_etat_live','etat_live');
add_action('wp_recupérer_id_par_defaut','recupérer_id_par_defaut');


function etat_live(){
    $etat_live;
    if(isset($_POST['data'])){
      $etat_live=$_POST['data'];
      wp_send_json($etat_live);
    }
}

function recuperer_id_playlist_par_defaut(){
      $query = "SELECT ParDefaut FROM" . $wpdb->prefix . "playlistenregistrees_webtv_plugin;";
      $result=$wpdb->get_results($query);

}

function traitement_infos_nouveaux_reglages(){

/*
Cette focntion initialise les variable créer $par_defaut,$nom_reglage,...
par les instructions données par le client lors de la demande POST.
*/

    global $montantpop;
    global $wpdb;

    $par_defaut;
    $nom_reglage;
    $passer_des_que_possible;
    $pubs_internes;
    $pubs_externes;
    $artiste_en_highlight;
    $debut;
    $fin;
    $tableaupourcentages=array();

    // Liste des variables transmises dans la requête ajax
    // On passe un booléen pour vérifier que la playlist a été définie comme par défaut ou non
    if(isset($_POST['pardefaut'])){

        $par_defaut=$_POST['pardefaut'];
    }
    // = true si playlist définie comme par défaut
    // On passe un booléen pour vérifier que la playlist doit être passer directement à la suite ou non
    if(isset($_POST['passer_des_que_possible'])){
        $passer_des_que_possible=$_POST['passer_des_que_possible'];
    }
    if(isset($_POST['nom_reglage'])){
        $nom_reglage=$_POST['nom_reglage'];
    }
    if(isset( $_POST['pubs_internes'])){
        $pubs_internes = $_POST['pubs_internes'];
        //var_dump( $pubs_internes);
    }
    if(isset($_POST['pubs_externes'])){
        $pubs_externes = $_POST['pubs_externes'];
        // var_dump( $pubs_externes);
    }
    if(isset($_POST['artistehighlight'])){
        $artiste_en_highlight=$_POST['artistehighlight'];
    }
    // =true si on doit passer de que possible

    if(isset($_POST['date_debut'])){
        $debut=$_POST['date_debut'];
    }
    if(isset($_POST['date_fin'])){
        $fin=$_POST['date_fin'];
    }

    $tab_url=array();
    $tab_titres=array();
    $tab_artistes=array();
    $nb_track;





    function recup_artistes(){
    /*

    */
        global $tab_titres;
        global $tab_artistes;
        global $wpdb;

        for($k=0;$k<sizeof($tab_url);$k++){
            $url=$tab_url[$k];
            $query="SELECT id FROM " . $wpdb->prefix . "videos_webtv_plugin WHERE url='$url';";
            $result=$wpdb->get_results($query);
            foreach($result as $id){
                $idvideo=$id->id;
                $query1="SELECT artiste_id FROM " . $wpdb->prefix . "relation_webtv_plugin WHERE video_id='$idvideo';";
                $result1=$wpdb->get_results($query1);
                foreach($result1 as $res){
                    $idartiste=$res->artiste_id;
                    $query2="SELECT nom FROM " . $wpdb->prefix . "artiste_webtv_plugin WHERE id='$idartiste';";
                    $result2=$wpdb->get_results($query2);
                    foreach($result2 as $nomartiste){
                        $nom=$nomartiste->nom;
                        $tab_artistes[]=$nom;
                    }
                }

            }
        }
    }


    function recuperer_fin_derniere_playlist(){
        global $wpdb;

        $tableau_date=array();
        function datefr2en($heure,$minutes,$annee,$jour,$mois){

            return date('Y-m-d H:i',mktime($heure,$minutes,0,$mois,$jour,$annee));
        }


        $query="SELECT Fin FROM " . $wpdb->prefix . "playlistenregistrees_webtv_plugin;";
        $result=$wpdb->get_results($query);
        foreach($result as $date){
            $time=$date->Fin;
            $jour=explode("/",$time)[0];
            $mois=explode("/",explode('/',$time)[1])[0];
            $annee=substr(explode(" ",$time)[0],-4);
            $heure=explode(":",explode(" ",$time)[1])[0];
            $minutes=explode(":",explode(" ",$time)[1])[1];
            $d=datefr2en($heure,$minutes,$annee,$jour,$mois);

            $tableau_date[]=$d;
        }
        $date_la_plus_recente;

        for($k=0;$k<sizeof($tableau_date);$k++){
            $d1=new DateTime($tableau_date[$k]);
            $d2=new DateTime($tableau_date[$k+1]);
            if($d1<$d2){
                $date_la_plus_recente=$tableau_date[$k];


            }
        }


        // On recupere la date la plus récente
        //On la retourne
        return $date_la_plus_recente;

    }



    function enregistrer_reglage_pardefaut($nom,$pourcentagepoprock,$pourcentagehiphop,$pourcentagejazzblues,$pourcentagemusiquemonde,$pourcentagehardrock,$pourcentageelectro,$pourcentagechanson,$pourcentageautres){
        global $wpdb;
        $pardefaut=true;
        $effacer_ancienne_playlist_par_defaut="DELETE FROM " . $wpdb->prefix . "playlistenregistrees_webtv_plugin WHERE ParDefaut='$pardefaut';";
        $select1=$wpdb->query($effacer_ancienne_playlist_par_defaut);

        $inserer_nouvelle_playlist_par_defaut="INSERT INTO " . $wpdb->prefix . "playlistenregistrees_webtv_plugin(nom,pourcentage_poprock,pourcentage_rap,pourcentage_jazzblues,pourcentage_musiquemonde,pourcentage_hardrock,pourcentage_electro,pourcentage_chanson,pourcentage_autres,ParDefaut) VALUES('$nom','$pourcentagepoprock','$pourcentagehiphop','$pourcentagejazzblues','$pourcentagemusiquemonde','$pourcentagehardrock','$pourcentageelectro','$pourcentagechanson','$pourcentageautres','$pardefaut');";

        $select=$wpdb->query($inserer_nouvelle_playlist_par_defaut);
        wp_die();
    }

    function enregistrer_reglage_passerdesquepossible($nom,$pourcentagepoprock,$pourcentagehiphop,$pourcentagejazzblues,$pourcentagemusiquemonde,$pourcentagehardrock,$pourcentageelectro,$pourcentagechanson,$pourcentageautres,$pubs_internes,$pubs_externes,$artiste_highlight){
        /*
        Fonction : Cette fonction permet d'enregistrer les clips de musics les uns à la suite des autres tout en les délimitant par un début et une fin.
        paramètre : $nom,$pourcentagepoprock,$pourcentagehiphop,$pourcentagejazzblues,$pourcentagemusiquemonde,$pourcentagehardrock,$pourcentageelectro,$pourcentagechanson,$pourcentageautres,$pubs_internes,$pubs_externes,$artiste_highlight
        */


        global $wpdb;
        //On récupère la date de fin de la playlist en cours et verifier si aucune date de début ne correspond on met la playlist par defaut directement apres
        //Récupérer dans de fin de la playlist en cours (normalement date = heure suivante de l'heure en cours )
        $tableau_dates_debut=array();
        $tableau_dates_fin=array();


        $playlist_prevue_directement_apres=false;
        $pub_exter=implode(",",$pubs_externes);
        $pub_inter=implode(",",$pubs_internes);



        $da = new DateTime("+ 1 hour",new DateTimeZone('Europe/Berlin'));
        $he=$da->format('m/d/Y H');
        $heure_suivant=$he.':00';

        $heure_suivante=DateTime::createFromFormat('m/d/Y H:i', $heure_suivant,new DateTimeZone('Europe/Berlin'));

        $query="SELECT Debut,Fin FROM " . $wpdb->prefix . "playlistenregistrees_webtv_plugin;";
        $tab_fins=$wpdb->get_results($query);
        foreach($tab_fins as $fin){
            if($fin->Debut != ''){
                $debuts_play=$fin->Debut;
                $fin_play=$fin->Fin;
                $date_recup_debut = DateTime::createFromFormat('m/d/Y H:i', $debuts_play,new DateTimeZone('Europe/Berlin'));
                $date_recup_fin = DateTime::createFromFormat('m/d/Y H:i', $fin_play,new DateTimeZone('Europe/Berlin'));
                //On verifie les dates de debuts des autres playlists
                array_push($tableau_dates_debut,$date_recup_debut);
                array_push($tableau_dates_fin,$date_recup_fin);

                if($date_recup_debut==$heure_suivante){
                    $playlist_prevue_directement_apres=true;
                }
            }
        }
        if($playlist_prevue_directement_apres==false){

            $datedebut = new DateTime("+ 1 hour",new DateTimeZone('Europe/Berlin'));
            $h=$datedebut->format('m/d/Y H');
            $heure_debut=$h.':00';

            $datefin = new DateTime("+ 2 hour",new DateTimeZone('Europe/Berlin'));
            $he=$datefin->format('m/d/Y H');
            $heure_fin=$he.':00';



            $enregistrer_directement_apres="INSERT INTO " . $wpdb->prefix . "playlistenregistrees_webtv_plugin(nom,pourcentage_poprock,pourcentage_rap,pourcentage_jazzblues,pourcentage_musiquemonde,pourcentage_hardrock,pourcentage_electro,pourcentage_chanson,pourcentage_autres,publicites_internes,publicites_externes,artiste_highlight,Debut,Fin) VALUES('$nom','$pourcentagepoprock','$pourcentagehiphop','$pourcentagejazzblues','$pourcentagemusiquemonde','$pourcentagehardrock','$pourcentageelectro','$pourcentagechanson','$pourcentageautres','$pub_inter','$pub_exter','$artiste_highlight','$heure_debut','$heure_fin');";
            $wpdb->query($enregistrer_directement_apres);
            wp_die();


        }else{

            function comparis($a, $b)
            {
                if ($a== $b) {
                    return 0;
                }
                return ($a < $b) ? -1 : 1;
            }

            usort($tableau_dates_debut, 'comparis');
            usort($tableau_dates_fin, 'comparis');

            //On verifie si un créneau est disponible
            //On compare les dates de fin et de début pour voir si il y a un créneau de plus d'une heure--> On regarde alors
            // var_dump($tableau_dates_fin);
            $creneau_trouve=false;

            //Placement de l'heure du début à l'heure de fin du crénau de la playlist
            for($i=0;$i<sizeof($tableau_dates_debut);$i++){
                if($tableau_dates_fin[$i]!=$tableau_dates_debut[$i+1]){

                    $heure_debut_prochain_creneau1=$tableau_dates_fin[$i];
                    $h=$tableau_dates_fin[$i];

                    $time_immut=DateTimeImmutable::createFromMutable( $h);

                    $heure_fin_prochain_creneau1 =$time_immut->add(new DateInterval('PT1H00S'));

                    $heure_debut=$heure_debut_prochain_creneau1->format('m/d/Y H:i');
                    $heure_fin=$heure_fin_prochain_creneau1->format('m/d/Y H:i');


                    //S'il n'y a pas de crénau de playlist le programme insert automatiquement dans la base de donnée la playlist choisit
                    if($creneau_trouve==false){

                        $enregistrer_premier_creneau="INSERT INTO " . $wpdb->prefix . "playlistenregistrees_webtv_plugin(nom,pourcentage_poprock,pourcentage_rap,pourcentage_jazzblues,pourcentage_musiquemonde,pourcentage_hardrock,pourcentage_electro,pourcentage_chanson,pourcentage_autres,publicites_internes,publicites_externes,artiste_highlight,Debut,Fin) VALUES('$nom','$pourcentagepoprock','$pourcentagehiphop','$pourcentagejazzblues','$pourcentagemusiquemonde','$pourcentagehardrock','$pourcentageelectro','$pourcentagechanson','$pourcentageautres','$pub_inter','$pub_exter','$artiste_highlight','$heure_debut','$heure_fin');";

                        $wpdb->query($enregistrer_premier_creneau);


                    }
                    $creneau_trouve=true;
                }
            }
        }
    }

    function enregistrer_reglage_complet($nom,$pourcentagepoprock,$pourcentagehiphop,$pourcentagejazzblues,$pourcentagemusiquemonde,$pourcentagehardrock,$pourcentageelectro,$pourcentagechanson,$pourcentageautres,$debut,$fin,$pubs_internes,$pubs_externes,$artiste_highlight){
        //Les dates sont vérifiées en amont pendant la sélection. Les créneaux sont normalement déjà disponibles
        global $wpdb;
        $enregistrer="INSERT INTO " . $wpdb->prefix . "playlistenregistrees_webtv_plugin(nom,pourcentage_poprock,pourcentage_rap,pourcentage_jazzblues,pourcentage_musiquemonde,pourcentage_hardrock,pourcentage_electro,pourcentage_chanson,pourcentage_autres,publicites_internes,publicites_externes,artiste_highlight,Debut,Fin) VALUES('$nom','$pourcentagepoprock','$pourcentagehiphop','$pourcentagejazzblues','$pourcentagemusiquemonde','$pourcentagehardrock','$pourcentageelectro','$pourcentagechanson','$pourcentageautres','$pubs_internes','$pubs_externes','$artiste_highlight','$debut','$fin');";

        $wpdb->query($enregistrer);
        wp_die();
    }


    if($par_defaut=='true'){

    /* enregistrement de la playlist par défaut : elle réunit tous les styles différents*/

        enregistrer_reglage_pardefaut($nom_reglage,$_POST['pourcentage_poprock'],$_POST['pourcentage_hiphop'],$_POST['pourcentage_jazzblues'],$_POST['pourcentage_musiquemonde'],$_POST['pourcentage_hardrock'],$_POST['pourcentage_electro'],$_POST['pourcentage_chanson'],$_POST['pourcentage_autres']);

    }else{

        // Cas ou on passe la playlist des que possible, le programme envoie une playlist choisie par le product owner différente de la playlist par défaut.
        if($passer_des_que_possible=='true'){

            enregistrer_reglage_passerdesquepossible($nom_reglage,$_POST['pourcentage_poprock'],$_POST['pourcentage_hiphop'],$_POST['pourcentage_jazzblues'],$_POST['pourcentage_musiquemonde'],$_POST['pourcentage_hardrock'],$_POST['pourcentage_electro'],$_POST['pourcentage_chanson'],$_POST['pourcentage_autres'],$pubs_internes,$pubs_externes,$artiste_en_highlight);

        }
        else{
            // Cas ou on doit enregistrer la playlist pour une certaine date
            if($debut!='undefined' && $fin!='undefined' && $passer_des_que_possible=='false'){

                enregistrer_reglage_complet($nom_reglage,$_POST['pourcentage_poprock'],$_POST['pourcentage_hiphop'],$_POST['pourcentage_jazzblues'],$_POST['pourcentage_musiquemonde'],$_POST['pourcentage_hardrock'],$_POST['pourcentage_electro'],$_POST['pourcentage_chanson'],$_POST['pourcentage_autres'],$debut,$fin,$pubs_internes,$pubs_externes,$artiste_en_highlight);


            }
        }
    }

    do_action('pluginwebtv_generer_la_playlist');



}


function recuperer_programmation(){
/* permet de récupérer le nom, le début et la fin d'une playlist enregistrée dans la base de donnée*/

    global $wpdb;
    $query="SELECT nom,Debut,Fin FROM " . $wpdb->prefix . "playlistenregistrees_webtv_plugin;";
    $result=$wpdb->get_results($query);
    wp_send_json_success($result);
    wp_die();

}

function verifier_dates_debut_calendrier(){
    $creneau_libre='libre';
    // Fonction à laquelle on envoit la date pour voir si elle est disponible
    $tableau_date_debut=array();
    $tableau_date_fin=array();

    $date_debut=$_POST['date_debut'];
    $date_deb=DateTime::createFromFormat('m/d/Y H:i', $date_debut,new DateTimeZone('Europe/Berlin'));
    global $wpdb;
    $query="SELECT Debut,Fin FROM " . $wpdb->prefix . "playlistenregistrees_webtv_plugin;";
    $result=$wpdb->get_results($query);
    foreach($result as $p){
        $d=$p->Debut;
        $d1=$p->Fin;
        $deb=DateTime::createFromFormat('m/d/Y H:i', $d,new DateTimeZone('Europe/Berlin'));
        $fin=DateTime::createFromFormat('m/d/Y H:i', $d1,new DateTimeZone('Europe/Berlin'));
        array_push($tableau_date_debut,$deb);
        array_push($tableau_date_fin,$fin);
    }


    //SI la date de début est != de celle des playlists enregistrées et que l'intervalle entre une date de début et sa date de fin ne comprend pas cette date alors on renvoit true

    for($i=0;$i<sizeof($tableau_date_debut);$i++){
        printf($tableau_date_debut[$i] );
        if($date_deb>=$tableau_date_debut[$i] && $date_deb<=$tableau_date_fin[$i]){
            //Le créneau est déjà utilisé
            $creneau_libre='occupe';

        }
    }
    echo $creneau_libre;
    wp_die();
}

//Verifie si le crénveau est libre (date passée en paramètre de la reqûete ajax).
function verifier_dates_fin_calendrier(){
    $creneau_libre='libre';
    // Fonction à laquelle on envoit la date pour voir si elle est disponible
    $tableau_date_debut=array();
    $tableau_date_fin=array();

    $date_debut=$_POST['date_debut'];
    $date_deb=DateTime::createFromFormat('m/d/Y H:i', $date_debut,new DateTimeZone('Europe/Berlin'));

    $date_fin=$_POST['date_fin'];
    printf($date_fin);
    $date_f=DateTime::createFromFormat('m/d/Y H:i', $date_fin,new DateTimeZone('Europe/Berlin'));
    global $wpdb;
    $query="SELECT Debut,Fin FROM " . $wpdb->prefix . "playlistenregistrees_webtv_plugin;";
    $result=$wpdb->get_results($query);
    foreach($result as $p){
        $d=$p->Debut;
        $d1=$p->Fin;
        $deb=DateTime::createFromFormat('m/d/Y H:i', $d,new DateTimeZone('Europe/Berlin'));
        $fin=DateTime::createFromFormat('m/d/Y H:i', $d1,new DateTimeZone('Europe/Berlin'));
        array_push($tableau_date_debut,$deb);
        array_push($tableau_date_fin,$fin);
    }


    // Deux cas : - La date de fin est dans un créneau déjà utilisé (cas simple)
    //           - La date de fin est en dehors d'un créneau mais l'intervalle de passage comprend un interval déjà enregistré (date fin-date debut )
    for($i=0;$i<sizeof($tableau_date_debut);$i++){
        printf($tableau_date_debut[$i]);
        if($date_f>$tableau_date_debut[$i] && $date_f<=$tableau_date_fin[$i] || $date_deb<$tableau_date_debut[$i] && $date_f>$tableau_date_debut[$i] ){
            //Le créneau est déjà utilisé
            $creneau_libre='occupe';
        }
    }
    echo $creneau_libre;
    wp_die();
}

//Permet de trouver le prochain créneau horaire disponible en fonction des playlists enregistrées dans la base de données
function trouver_creneau_dispo(){
    global $wpdb;
    $prochaine_heure_dispo=true;
    $tableau_dates_debut=array();
    $tableau_dates_fin=array();
    $datefin = new DateTime("+2 hours",new DateTimeZone('Europe/Berlin'));
    $he=$datefin->format('m/d/Y H');
    $heure_fin=$he.':00';
    $hfinn=DateTime::createFromFormat('m/d/Y H:i',$heure_fin,new DateTimeZone('Europe/Berlin'));
    $current = new DateTime("+1 hours",new DateTimeZone('Europe/Berlin'));
    $he=$current->format('m/d/Y H');
    $heure_suivant=$he.':00';
    $hsuiv=DateTime::createFromFormat('m/d/Y H:i',$heure_suivant,new DateTimeZone('Europe/Berlin'));


    $query="SELECT Debut,Fin FROM " . $wpdb->prefix . "playlistenregistrees_webtv_plugin;";
    $result=$wpdb->get_results($query);
    foreach($result as $res){
        if($res->Debut != ''){
            $debut=$res->Debut;
            $fin=$res->Fin;

            $deb=DateTime::createFromFormat('m/d/Y H:i',$debut,new DateTimeZone('Europe/Berlin'));
            $fi=DateTime::createFromFormat('m/d/Y H:i',$fin,new DateTimeZone('Europe/Berlin'));
            array_push($tableau_dates_debut,$deb);
            array_push($tableau_dates_fin,$fi);

            if($deb == $hsuiv){
                $prochaine_heure_dispo=false;
            }
        }
    }
    if($prochaine_heure_dispo==true){
        $tableau_don=array();
        array_push($tableau_don,$hsuiv);
        array_push($tableau_don,$hfinn);
        wp_send_json_success($tableau_don);
        wp_die();
    }
    if($prochaine_heure_dispo==false){


        function comparis($a, $b)
        {
            if ($a== $b) {
                return 0;
            }
            return ($a < $b) ? -1 : 1;
        }
        usort($tableau_dates_debut, 'comparis');
        usort($tableau_dates_fin, 'comparis');
        //On compare les dates de fin et de début pour voir si il y a un créneau de plus d'une heure--> On regarde alors
        $creneau_trouve=false;


        $heure_debut_prochain_creneau;
        $heure_fin_prochain_creneau;
        $datetime=new DateTime("",new DateTimeZone('Europe/Berlin'));
        //  var_dump($datetime);

        for($i=0;$i<sizeof($tableau_dates_debut);$i++){


            if($tableau_dates_fin[$i]!=$tableau_dates_debut[$i+1] &&$tableau_dates_fin[$i]>$datetime){
                //Pas de playlist directement apres ce creaneau

                $heure_debut_prochain_creneau=$tableau_dates_fin[$i];
                $h=$tableau_dates_fin[$i];

                $time_immut=DateTimeImmutable::createFromMutable( $h);

                $heure_fin_prochain_creneau =$time_immut->add(new DateInterval('PT1H00S'));


                if($creneau_trouve==false){
                    $tab=array();

                    array_push($tab,$heure_debut_prochain_creneau);
                    array_push($tab, $heure_fin_prochain_creneau);
                    wp_send_json_success($tab);
                    wp_die();

                }
                $creneau_trouve=true;
            }
        }
    }

}

function recuperer_noms_reglages(){
    global $wpdb;

    $recuperer_noms="SELECT nom FROM " . $wpdb->prefix . "playlistenregistrees_webtv_plugin;";
    $resut=$wpdb->get_results($recuperer_noms);
    wp_send_json_success($resut);
    wp_die();
}
// On genere une nouvelle playlist pour la semaine
function recuperer_derniers_pourcentages_enregistrees(){

    global $wpdb;
    global $montantpop;
    $recuperer="SELECT * FROM " . $wpdb->prefix . "playlistenregistrees_webtv_plugin ORDER BY id DESC LIMIT 1;";
    $result=$wpdb->get_results($recuperer);

    wp_send_json_success($result);


}

function recuperer_tous_reglages_enregistres(){
    global $wpdb;
    $query="SELECT * FROM " . $wpdb->prefix . "playlistenregistrees_webtv_plugin;";
    $result=$wpdb->get_results($query);
    wp_send_json_success($result);

}

function supprimer_toutes_videos(){
    global $wpdb;

    $query="DELETE FROM " . $wpdb->prefix . "videos_webtv_plugin;";
    $wpdb->query($query);
    wp_die();

}

function inserer_contenu_pluginwebtv(){
    /*
    A l'aide des infos données par le product owner provenant de la page de gestion de BDD, le programme insert directement les nouveaux paramètres enregistrées dans la base de donnée.
    */
    $titre;
    $artiste;
    $url;
    $album;
    $genre;
    $qualite;
    $annee;

    $video_id;
    $artiste_id;
    $genre_id;
    $qualite_id;
    $album_id;
    $annee_id;


    $titre=$_POST['titre'];
    $artiste=$_POST['artiste_video'];
    $url=$_POST['url_video'];
    $genre=$_POST['genre'];


    if(isset($_POST['album'])){
        $album=$_POST['album'];
    }else{
        $album=13;
    }
    if(isset($_POST['annee'])){
        $annee=$_POST['annee'];}
    else{
        $annee=2016;
    }

    if(isset($_POST['qualite'])){
        $qualite=$_POST['qualite'];
    }else{
        $qualite=1;
    }


    $inserer_video="INSERT INTO " . $wpdb->prefix . "videos_webtv_plugin(titre,url) VALUES('$titre','$url');";
    $wpdb->query($inserer_video);
    $recup_id_video="SELECT id FROM " . $wpdb->prefix . "videos_webtv_plugin WHERE url='$url';";
    $result_id_video=$wpdb->get_results($recup_id_video);
    foreach($result_id_video as $id_video){
        $video_id=$id_video->id;
    }

    $inserer_artiste="INSERT INTO " . $wpdb->prefix . "artiste_webtv_plugin(nom) VALUES('$artiste');";
    $wpdb->query($inserer_artiste);;
    $recup_id_artiste="SELECT id FROM " . $wpdb->prefix . "videos_webtv_plugin WHERE nom='$artiste';";
    $result_artiste=$wpdb->get_results($recup_id_artiste);
    foreach($result_artiste as $id_artiste){
        $artiste_id=$id_artiste->id;
    }

    $recup_genre="SELECT id FROM " . $wpdb->prefix . "genre_webtv_plugin WHERE Genre='$genre';";
    $genre_recup=$wpdb->get_results($recup_genre);
    foreach($genre_recup as $id_genre){
        $genre_id=$id_genre->id;
    }


    $inserer_annee="INSERT INTO " . $wpdb->prefix . "annee_webtv_plugin(annee) VALUES('$annee');";
    $wpdb->query($inserer_annee);
    $recup_id_annee="SELECT id FROM " . $wpdb->prefix . "annee_webtv_plugin WHERE annee='$annee';";
    $result_id_annee=$wpdb->get_results($recup_id_annee);
    foreach($result_id_annee as $id_annee){
        $annee_id=$id_annee->id;
    }

    $inserer_album="INSERT INTO " . $wpdb->prefix . "album_webtv_plugin(album) VALUES('$album');";
    $wpdb->query($inserer_album);
    $recup_id_album="SELECT id FROM " . $wpdb->prefix . "album_webtv_plugin WHERE album='$album';";
    $result_id_album=$wpdb->get_results($recup_id_album);
    foreach($result_id_album as $album_id_r){
        $album_id=$album_id_r->id;
    }


    $remplir_relation="INSERT INTO " . $wpdb->prefix . "relation_webtv_plugin(video_id,artiste_id,album_id,annee_id,genre_id) VALUES('$video_id','$artiste_id','$album_id','$annee_id','$genre_id','$qualite');";
    $wpdb->query($remplir_relation);


}

function recuperer_artiste_with_title(){
    // wp_send_json_success("teteteg");
    global $wpdb;
    $title=$_POST['title'];

    $query="SELECT id FROM " . $wpdb->prefix . "videos_webtv_plugin WHERE titre='$title';";
    $result=$wpdb->get_results($query);
    foreach($result as $res){
        $id=$res->id;
        $query1="SELECT artiste_id FROM " . $wpdb->prefix . "relation_webtv_plugin WHERE video_id='$id';";
        $result1=$wpdb->get_results($query1);
        foreach($result1 as $res1){
            $id_artiste=$res1->artiste_id;
            $query2="SELECT nom FROM " . $wpdb->prefix . "artiste_webtv_plugin WHERE id='$id_artiste';";
            $result3=$wpdb->get_results($query2);
            foreach($result3 as $res3){
                $nom_artiste=$res3->nom;
                wp_send_json_success($nom_artiste);
            }
        }
    }

}


function eviter_repetition_tous_les_n_morceaux($nb_limite){
/* On compare deux tableaux indentique. Le premier tableau est comparé une cellule par une cellule. Chaque cellule sont comparées à toutes les autres cellules du second tableau et si il y a 2 meme morcreaux identique ont supprime un morceaux.*/


    $position=0;
    global $wpdb;
    $tab_20=array();
    $tab_20_id=array();

    $query="SELECT titre,id FROM " . $wpdb->prefix . "playlist_par_defaut_webtv_plugin LIMIT 10;";
    $result=$wpdb->get_results($query);
    foreach($result as $res){

        $titre=$res->titre;
        $id=$res->id;
        //On verifie tous les n morceaux
        $tab_20[]=$titre;
        $tab_20_id[]=$id;
        if(sizeof($tab_20)==2){
            $tab_20bis=array();
            $tab_20bis=$tab_20;
            //on check dans le tableau si on a 2 titres différents
            for($i=0;$i<sizeof($tab_20);$i++){
                for($k=1;$k<sizeof($tab_20bis);$k++){
                    if($tab_20[$i]==$tab_20bis[$k]){
                        //On a 2 meme morceaux dans les n

                        $id_del=$tab_20_id[$i];
                        $delete="DELETE FROM " . $wpdb->prefix . "playlist_par_defaut_webtv_plugin WHERE id='$id_del';";
                        $wpdb->query($delete);

                    }

                }
            }

            $tab_20=array();
            $tab_20_id=array();
            $position=0;
        }

        $position=$position+1;
    }



}

function generer_la_playlist(){


    global $wpdb;
    global $tab_url;
    global $tab_titres;
    global $tab_genres;
    global $tab_artistes;
    $tableau_dates_debut=array();
    $tableau_dates_fin=array();

    //On chope les playlists enregistrés, on tri par date et quand creneau libre on met playlist defaut
    $query="SELECT Debut,Fin FROM " . $wpdb->prefix . "playlistenregistrees_webtv_plugin;";
    $result=$wpdb->get_results($query);
    foreach($result as $res){

        $debut_playlist=$res->Debut;
        $fin_playlist=$res->Fin;
        //On converti en date
        if($debut_playlist != '' && $fin_playlist != ''){
            $date_debut_playlist=DateTime::createFromFormat('m/d/Y H:i', $debut_playlist,new DateTimeZone('Europe/Berlin'));
            $date_fin_playlist=DateTime::createFromFormat('m/d/Y H:i', $fin_playlist,new DateTimeZone('Europe/Berlin'));
            //On stock tout ca dans 2 tableaux
            $tableau_dates_debut[]=$date_debut_playlist;
            $tableau_dates_fin[]=$date_fin_playlist;

        }
    }

    /*
*
*********************************** Si on a que la playlist par defaut dans le tableau
*
*/




    if(sizeof($tableau_dates_debut)==0){

        $currentdate = new DateTime("+4 days",new DateTimeZone('Europe/Berlin'));
        $currentdate1 = new DateTime("",new DateTimeZone('Europe/Berlin'));


        $intervaldefaut=$currentdate1->diff($currentdate);
        $nb_anneedefaut=$intervaldefaut->format('%Y');
        $nb_moisdefaut=$intervaldefaut->format('%m');
        $nb_joursdefaut=$intervaldefaut->format('%a');
        $nb_heuresdefaut=$intervaldefaut->format('%H');
        $tdefaut=$nb_anneedefaut*8760;
        $t1defaut=$nb_moisdefaut*720;
        $t2defaut=$nb_joursdefaut*24;
        //On recupere le nombre d'heure à compléter avec la playlist par defaut
        $nb_heures_a_completer2defaut=$tdefaut+$t1defaut+$t2defaut+$nb_heuresdefaut;


        $ldefaut=true;
        $queryydefaut="SELECT * FROM " . $wpdb->prefix . "playlistenregistrees_webtv_plugin WHERE ParDefaut='$ldefaut';";
        $result13defaut=$wpdb->get_results($queryydefaut);
        foreach($result13defaut as $resdefaut){

            $nomdefaut =$resdefaut->nom;
            //NULL si case vide
            $artistehightdefaut=$resdefaut->artiste_highlight;
            $pubsinternesdefaut=$resdefaut->publicites_internes;
            $pubsexternesdefaut=$resdefaut->publicites_externes;
            $poprockdefaut=$resdefaut->pourcentage_poprock;
            $hiphopdefaut=$resdefaut->pourcentage_rap;
            $jazzbluesdefaut=$resdefaut->pourcentage_jazzblues;
            $musiquemondedefaut=$resdefaut->pourcentage_musiquemonde;
            $electrodefaut=$resdefaut->pourcentage_electro;
            $hardrockdefaut=$resdefaut->pourcentage_hardrock;
            $chansondefaut=$resdefaut->pourcentage_chanson;
            $autresdefaut=$resdefaut->pourcentage_autres;

            for($i=0;$i<$nb_heures_a_completer2defaut;$i++){
                do_action('pluginwebtv_generer_playlist',$poprockdefaut,$hiphopdefaut,$jazzbluesdefaut,$musiquemondedefaut,$hardrockdefaut,$electrodefaut,$chansondefaut,$autresdefaut,$pubsinternesdefaut,$pubsexternesdefaut,$artistehightdefaut);
            }
        }
    }else{

        /*
*
*********************************** Si des playlists sont enregistrées
*
*/



        function tri_tableau($a, $b)
        {
            if ($a== $b) {

                return 0;

            }
            return ($a < $b) ? -1 : 1;
        }

        usort($tableau_dates_debut, 'tri_tableau');
        usort($tableau_dates_fin, 'tri_tableau');
        $nb_playlists_defaut_a_generer=0;

        $tableau_dates_debut2=$tableau_dates_debut;
        $tableau_dates_fin2=$tableau_dates_fin;

        //On parcours les playlists enregistrees (dans l'ordre chrono)

        for($i=0;$i<sizeof($tableau_dates_debut2);$i++){

            $debut1=$tableau_dates_debut[$i];
            $fin1=$tableau_dates_fin[$i];
            $inter=$debut1->diff($fin1);
            $int_annees=$inter->format('%Y');
            $int_mois=$inter->format('%m');
            $int_jours=$inter->format('%a');
            $int_heures=$inter->format('%H');


            /*
*
******************** Tant qu'on est pas à la fin du tableau on compare les dates de debut aux dates fin   *******************
*
*/

            if($i<sizeof($tableau_dates_debut2)-1 ){
                if(($tableau_dates_fin2[$i]==$tableau_dates_debut2[$i+1])){


                    if($int_heures>1 || $int_jours>0 || $int_mois>0 || $int_annees>0){

                        // CAS 1
                        //On a une playlist prevue pour plus d'une heure donc on la repete n fois (n étant le nombre d'heure)
                        $tbis=$int_annees*8760;
                        $tbis1=$int_mois*720;
                        $tbis2=$int_jours*24;
                        $nb_de_repetitions_playlist_a_faire=$tbis+$tbis1+$tbis2+$int_heures;
                        $date_debutt=$tableau_dates_debut[$i]->format('m/d/Y H:i');
                        // echo 'date debut'.$date_debutt;
                        $query="SELECT * FROM " . $wpdb->prefix . "playlistenregistrees_webtv_plugin WHERE Debut='$date_debutt';";
                        $result3=$wpdb->get_results($query);
                        foreach($result3 as $res){
                            //On recupere les infos du réglage qui dure plus d'une heure
                            $nom =$res->nom;
                            //NULL si case vide
                            $artistehight=$res->artiste_highlight;
                            $pubsinternes=$res->publicites_internes;
                            $pubsexternes=$res->publicites_externes;
                            $poprock=$res->pourcentage_poprock;
                            $hiphop=$res->pourcentage_rap;
                            $jazzblues=$res->pourcentage_jazzblues;
                            $musiquemonde=$res->pourcentage_musiquemonde;
                            $electro=$res->pourcentage_electro;
                            $hardrock=$res->pourcentage_hardrock;
                            $chanson=$res->pourcentage_chanson;
                            $autres=$res->pourcentage_autres;
                            //echo 'Playlist de plus d\'une heure, on la genere';
                            // echo 'On doit la repeter'.$nb_de_repetitions_playlist_a_faire.'';
                            for($i=0;$i<$nb_de_repetitions_playlist_a_faire;$i++){
                                do_action('pluginwebtv_generer_playlist',$poprock,$hiphop,$jazzblues,$musiquemonde,$hardrock,$electro,$chanson,$autres,$pubsinternes,$pubsexternes,$artistehight);
                            }

                        }
                    }else{

                        $fin0=$tableau_dates_fin2[$i]->format('m/d/Y H:i');
                        //Quand une playlist est prévue on la remplie
                        $queryy="SELECT * FROM " . $wpdb->prefix . "playlistenregistrees_webtv_plugin WHERE Fin='$fin0';";
                        $result45=$wpdb->get_results($queryy);
                        foreach($result45 as $res){

                            $nom =$res->nom;
                            //NULL si case vide
                            $artistehight=$res->artiste_highlight;
                            $pubsinternes=$res->publicites_internes;
                            $pubsexternes=$res->publicites_externes;
                            $poprock=$res->pourcentage_poprock;
                            $hiphop=$res->pourcentage_rap;
                            $jazzblues=$res->pourcentage_jazzblues;
                            $musiquemonde=$res->pourcentage_musiquemonde;
                            $electro=$res->pourcentage_electro;
                            $hardrock=$res->pourcentage_hardrock;
                            $chanson=$res->pourcentage_chanson;
                            $autres=$res->pourcentage_autres;
                            // echo 'Playlist Enregistree, on l\'ajoute';
                            do_action('pluginwebtv_generer_playlist',$poprock,$hiphop,$jazzblues,$musiquemonde,$hardrock,$electro,$chanson,$autres,$pubsinternes,$pubsexternes,$artistehight);


                        }




                    }

                }
                //Si on a un trou dans la programmation
                if(($tableau_dates_fin2[$i]!=$tableau_dates_debut2[$i+1])){

                    // CAS 2
                    //On a un créneau qui n'est pas occupé
                    //On rempli avec la playlist par defaut n fois (n est le nombre d'heures entre la fin playlist et le debut playlist)
                    //Recuperer le nombre d'heures entre fin et debut


                    if($tableau_dates_debut2[$i+1]==NULL){

                        //Recuperer la fin de la semaine (7 jours)
                        $currentdate = new DateTime("+4 days",new DateTimeZone('Europe/Berlin'));

                        if($currentdate>$tableau_dates_fin2[$i]){
                            //Cas ou on dit completer la semaine avec des playlists par defaut

                            //La derniere date du tableau est dans moins de 7 jours, on complete pour le reste de la semaine
                            $comp1=$currentdate;
                            $comp2=$tableau_dates_fin2[$i];
                            $intervale=$comp1->diff($comp2);
                            $int_annees1=$intervale->format('%Y');
                            $int_mois1=$intervale->format('%m');
                            $int_jours1=$intervale->format('%a');
                            $int_heures1=$intervale->format('%H');


                            $tbis1=$int_annees1*8760;
                            $tbis3=$int_mois1*720;
                            $tbis4=$int_jours1*24;
                            $nb_de_repetitions_pardefaut1=$tbis1+$tbis3+$tbis4+$int_heures1;
                            $l2=true;
                            $query11="SELECT * FROM  " . $wpdb->prefix . "playlistenregistrees_webtv_plugin WHERE ParDefaut='$l2';";
                            $result12=$wpdb->get_results($query11);
                            foreach($result12 as $res){
                                $nom =$res->nom;
                                //NULL si case vide
                                $artistehight=$res->artiste_highlight;
                                $pubsinternes=$res->publicites_internes;
                                $pubsexternes=$res->publicites_externes;
                                $poprock=$res->pourcentage_poprock;
                                $hiphop=$res->pourcentage_rap;
                                $jazzblues=$res->pourcentage_jazzblues;
                                $musiquemonde=$res->pourcentage_musiquemonde;
                                $electro=$res->pourcentage_electro;
                                $hardrock=$res->pourcentage_hardrock;
                                $chanson=$res->pourcentage_chanson;
                                $autres=$res->pourcentage_autres;
                                // echo 'Fin du tableau, on genere '.$nb_de_repetitions_pardefaut1.' playlists';
                                for($i=0;$i<$nb_de_repetitions_pardefaut1;$i++){
                                    do_action('pluginwebtv_generer_playlist',$poprock,$hiphop,$jazzblues,$musiquemonde,$hardrock,$electro,$chanson,$autres,$pubsinternes,$pubsexternes,$artistehight);
                                }
                            }

                        }


                    }else{



                        //Tant que on est pas sur la derniere date du tableau
                        $currentdate = new DateTime("+4 days",new DateTimeZone('Europe/Berlin'));

                        if($tableau_dates_debut2[$i+1]<= $currentdate){
                            $fin_avant=$tableau_dates_fin2[$i];
                            $debut_prochaine=$tableau_dates_debut2[$i+1];
                            $d1=$debut_prochaine->format('m/d/Y H:i');
                            //var_dump($debut_prochaine);
                            $interval=$fin_avant->diff($debut_prochaine);

                            $nb_annee=$interval->format('%Y');

                            $nb_mois=$interval->format('%m');
                            $nb_jours=$interval->format('%a');
                            $nb_heures=$interval->format('%H');
                            $t=$nb_annee*8760;
                            $t1=$nb_mois*720;
                            $t2=$nb_jours*24;
                            //On recupere le nombre d'heure à compléter avec la playlist par defaut
                            $nb_heures_a_completer=$t+$t1+$t2+$nb_heures;
                            $l=true;
                            $queryy="SELECT * FROM " . $wpdb->prefix . "playlistenregistrees_webtv_plugin WHERE ParDefaut='$l';";
                            $result4=$wpdb->get_results($queryy);
                            foreach($result4 as $res){

                                $nom =$res->nom;
                                //NULL si case vide
                                $artistehight=$res->artiste_highlight;
                                $pubsinternes=$res->publicites_internes;
                                $pubsexternes=$res->publicites_externes;
                                $poprock=$res->pourcentage_poprock;
                                $hiphop=$res->pourcentage_rap;
                                $jazzblues=$res->pourcentage_jazzblues;
                                $musiquemonde=$res->pourcentage_musiquemonde;
                                $electro=$res->pourcentage_electro;
                                $hardrock=$res->pourcentage_hardrock;
                                $chanson=$res->pourcentage_chanson;
                                $autres=$res->pourcentage_autres;
                                // echo 'On doit generer '.$nb_heures_a_completer.' playlists';
                                for($i=0;$i<$nb_heures_a_completer;$i++){
                                    do_action('pluginwebtv_generer_playlist',$poprock,$hiphop,$jazzblues,$musiquemonde,$hardrock,$electro,$chanson,$autres,$pubsinternes,$pubsexternes,$artistehight);
                                }
                            }
                        }
                    }


                }


            }

            /*
*
******************** On est à la fin du tableau, on compare la derniere date à la date actuelle +7 jours ==> si il reste du temps , on complete avec la playlist par defaut *******************
*
*/

            if($i==(sizeof($tableau_dates_debut2)-1)){



                $currentdate = new DateTime("+4 days",new DateTimeZone('Europe/Berlin'));
                $derniere_date_table=$tableau_dates_fin2[$i];


                //si il reste du temps libre avant la fin de la semaine, on complete
                if($currentdate>$derniere_date_table){

                    $interval=$derniere_date_table->diff($currentdate);
                    $nb_annee=$interval->format('%Y');

                    $nb_mois=$interval->format('%m');
                    $nb_jours=$interval->format('%a');
                    $nb_heures=$interval->format('%H');
                    $t=$nb_annee*8760;
                    $t1=$nb_mois*720;
                    $t2=$nb_jours*24;
                    //On recupere le nombre d'heure à compléter avec la playlist par defaut
                    $nb_heures_a_completer1=$t+$t1+$t2+$nb_heures;


                    $l=true;
                    $queryy="SELECT * FROM " . $wpdb->prefix . "playlistenregistrees_webtv_plugin WHERE ParDefaut='$l';";
                    $result132=$wpdb->get_results($queryy);
                    foreach($result132 as $res){

                        $nom =$res->nom;
                        //NULL si case vide
                        $artistehight=$res->artiste_highlight;
                        $pubsinternes=$res->publicites_internes;
                        $pubsexternes=$res->publicites_externes;
                        $poprock=$res->pourcentage_poprock;
                        $hiphop=$res->pourcentage_rap;
                        $jazzblues=$res->pourcentage_jazzblues;
                        $musiquemonde=$res->pourcentage_musiquemonde;
                        $electro=$res->pourcentage_electro;
                        $hardrock=$res->pourcentage_hardrock;
                        $chanson=$res->pourcentage_chanson;
                        $autres=$res->pourcentage_autres;

                        for($i=0;$i<$nb_heures_a_completer1;$i++){
                            do_action('pluginwebtv_generer_playlist',$poprock,$hiphop,$jazzblues,$musiquemonde,$hardrock,$electro,$chanson,$autres,$pubsinternes,$pubsexternes,$artistehight);
                        }
                    }
                }
            }
        }



    }


    $effacer_existant ="TRUNCATE TABLE " . $wpdb->prefix . "playlist_par_defaut_webtv_plugin;";
    $wpdb->query($effacer_existant);


    //$tab_glob1=array();
    //On met tout ca dans la table Playlist
    $titre=str_replace("'","''",$tab_titres);
    $artistes=str_replace("'","''",$tab_artistes);
// permet de générer le nombre de clips à générer dans la table playlist_par_defaut_webtv_plugin
    for($k=0;$k<15;$k++){ // remettre sizeof($titre) une fois pb résolu.
        $inserer="INSERT INTO " . $wpdb->prefix . "playlist_par_defaut_webtv_plugin(titre,url,artiste,genre) VALUES('$titre[$k]','$tab_url[$k]','$artistes[$k]','$tab_genres[$k]')";
        $wpdb->query($inserer);
    }


//do_action('pluginwebtv_eviter_repetition_tous_les_n_morceaux');

}

?>
