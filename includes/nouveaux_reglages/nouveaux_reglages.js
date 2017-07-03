$(document).ready(function(){
    /*
*
*
*   Fichier contenant toutes les fonctions utilisées pour l'affichage des différents composants
*
*   - Affichage dynamique des boutons (cliquable/non cliquable)
*
*   - Affichage du sélecteur de date (calendrier)
*
*   -  Affichage du camembert associé aux sliders pour le choix des différents genres
*
*   - Champ de recherche intelligente pour le/les artiste(s) à mettre en avant (Highlights)
*
*   - Publicités
*
*
*/





    /*
* ---------------------------------- AFFICHAGE DYNAMIQUE BOUTONS (CLIQUABLE/NON CLIQUABLE)---------------------------------------
*/
    //bouton remise en état de fonction
    $('#select_artiste_higlight').removeAttr("disabled", "disabled");
    $('#bouton_voir_premiere_date_disponible').removeAttr("disabled", "disabled");
    $('#bouton_choisir_date').removeAttr("disabled", "disabled");

    // probleme si on clique une deuxieme fois sans annuler on ne peut plus choisir la date... à corriger
    $('#bouton_voir_premiere_date_disponible').click(function(){
        $('#trigger_premiere_date_dispo').toggleClass('hidden display');
        $('#bouton_voir_premiere_date_disponible').toggleClass('display hidden');
        $('#bouton_choisir_date').attr("disabled", "disabled");
        $('#bouton_voir_premiere_date_disponible').attr("disabled", "disabled");
        recuperer_creneau_dispo();
    });

    $('#bouton_choisir_date').click(function(){
        $('#bouton_voir_programmation').hide();
        $('#bouton_choisir_date').hide();
        $('#trigger_choisir_date').toggleClass('hidden display');
        $('#bouton_voir_premiere_date_disponible').hide();
        $('#bouton_voir_premiere_date_disponible').attr("disabled", "disabled");
        $('#calendrier_dates').hide();
        $("#cacher_programmation").hide();
    });

   /* $("#confirmer_date").click(function () {
        $('#bouton_voir_programmation_partie_choix_date').hide();
        $('#bouton_voir_premiere_date_disponible').hide();
        afficher_programmation_partie_choix_date();

    })*/

    $('#annuler_choisir_date').click(function(){
        $('#bouton_voir_programmation').show();
        $('#bouton_voir_premiere_date_disponible').removeAttr("disabled");
        $('#trigger_choisir_date').toggleClass('display hidden');
        $('#bouton_choisir_date').show();
        $('#calendrier_dates').hide();
        $('#bouton_voir_premiere_date_disponible').show();

    });
    $('#annuler_date_dispo').click(function(){
        $('#trigger_premiere_date_dispo').toggleClass('display hidden');
        $('#bouton_voir_premiere_date_disponible').toggleClass('hidden display');
        $('#bouton_choisir_date').removeAttr("disabled");
        $('#bouton_voir_premiere_date_disponible').removeAttr("disabled");
    });
    $('#annuler_choix_date').click(function(){
        $('#trigger_choisir_date').toggleClass('display hidden');
        $('#bouton_voir_premiere_date_disponible').removeAttr("disabled");
        $('#bouton_choisir_date').toggleClass('hidden display');
    });

    $('#bouton_voir_programmation').click(function(){
        $('#bouton_voir_programmation').hide();
        $("#cacher_programmation").show();// montre le bouton
        $("#cacher_programmation").html();//permet de l'écrire dans la page html
        $('#calendrier_dates').show();
        $('#calendrier_dates').html('');
        afficher_programmation();

    });

    $('#bouton_voir_programmation_partie_choix_date').click(function(){
        $('#bouton_voir_programmation_partie_choix_date').hide();
        $("#cacher_programmation_partie_choix_date").show();// montre le bouton
        $("#cacher_programmation_partie_choix_date").html();//permet de l'écrire dans la page html
        $('#calendrier_dates_partie_choix_date').show();
        $('#calendrier_dates_partie_choix_date').html('');
        afficher_programmation_partie_choix_date();

    });

    $('#cacher_programmation').click(function(){
        $('#calendrier_dates').hide();
        $('#cacher_programmation').hide();
        $('#bouton_voir_programmation').show();
    });

    $('#cacher_programmation_partie_choix_date').click(function(){
        $('#calendrier_dates_partie_choix_date').hide();
        $('#cacher_programmation_partie_choix_date').hide();
        $('#bouton_voir_programmation_partie_choix_date').show();
    });

    //Checkbox pour mettre par defaut ou non le réglage
    $('#checkbox_par_defaut').click(function(){

        if(this.checked){

            $('#partie_highlight').hide();
            $('#partie_publicites').hide();
            $('#partie_diffusion').hide();
        }else{
            $('#partie_highlight').show();
            $('#partie_publicites').show();
            $('#partie_diffusion').show();
        }
    });

    //recupere et affiche les artistes en higlight
    var compteur_artistes_highlights = 0 ;// permet d'avoir un id unique à notre option afin d'eviter les doublons
    var artiste_choisi; // permet de récupérer l'artiste choisi lors de l'enregistrement

    $('#select_artiste_higlight').click(function(){

        var artiste_highlight = $('#classement_artistes_higlights').val();
        var artiste_highlight_sans_espace = String(artiste_highlight).replace(' ',"_");
        //mettre string devant artiste_highlight sinon la fonction replace n'est pas une fonction.

        if (artiste_highlight == null){

            alert('Aucun artiste selectionné à ajouter.');

        }

        else{

            compteur_artistes_highlights++; // on place le compteur au début afin d'éviter qu'il soit décalé.
            $('#select_artiste_higlight').attr("disabled", "disabled");// on sélectionne qu'un seul artiste donc on bloque sélectionner si 1 artistes est sélectionné.
            $('#affichage_artiste_higlight').show();
            $('#affichage_artiste_higlight').append('<option id="'+artiste_highlight_sans_espace + compteur_artistes_highlights +'" value="'+artiste_highlight+'">'+ artiste_highlight +'</option>');
            artiste_choisi = $('#'+artiste_highlight_sans_espace + compteur_artistes_highlights).val();

        }
        //faire une fonction communicant avec la base de données afin de récupérer l'artiste highlits
    });

    //supprimer l'affichage de l'artiste highlight avec la selection dans le multiple (encadrer blanc où il y a les artistes de la BDD)
    $('#supprimer_artistes_higlight').click(function(){

        var artiste_highlight = $('#classement_artistes_higlights').val();
        var artiste_highlight_sans_espace = String(artiste_highlight).replace(' ',"_");

        if (artiste_highlight == null){
            alert('Aucun artiste selectionné à supprimer.');
        }

        else{
            //on compare la valeur sélectionner dans le tableau avec la valeur de l'id de l'option créer  entre les balise de l'id select_artiste_higlight.
            if ($('#classement_artistes_higlights').val() == $('#'+artiste_highlight_sans_espace + compteur_artistes_highlights).val() ) {

                $('#select_artiste_higlight').removeAttr("disabled", "disabled");
                $('#'+artiste_highlight_sans_espace + compteur_artistes_highlights).hide('<option id="'+ artiste_highlight_sans_espace + compteur_artistes_highlights +'" value="'+artiste_highlight+'">'+ artiste_highlight +'</option>');

            }
        }
    });

    /*
    ***********Recupere et affiche les pubs externes**********
    */

    var compteur_pubs = 0 ;// permet d'avoir un id unique à notre option afin d'eviter les doublons et se restreindre à 3 pubs max (externes et internes comprises)
     //recupere et affiche les pubs externes
    $('#select_pubs_externes').click(function(){

        var pubs_externes = $('#pubs_selector_externe').val();
        var pubs_externes_sans_espaces = String(pubs_externes).replace(' ',"_");
        //mettre string devant pubs_externessinon la fonction replace n'est pas une fonction.

        if (pubs_externes == null){
            alert('Aucune pub externe selectionnée à ajouter.')
        }

        else{
            compteur_pubs++; // on place le compteur au début afin d'éviter qu'il soit décalé.
            $('#select_pubs_externes').attr("disabled", "disabled");// on sélectionne qu'un seul artiste donc on bloque sélectionner si 1 artistes est sélectionné.
            $('#affichage_pubs_externes').show();
            $('#affichage_pubs_externes').append('<option id="'+pubs_externes_sans_espaces + compteur_pubs +'" value="'+pubs_externes+'">'+ pubs_externes +'</option>');

        }
        //faire une fonction communicant avec la base de données afin de récupérer l'artiste highlits
    });

    //supprimer l'affichage de l'artiste highlight avec la selection dans le multiple (encadrer blanc où il y a les artistes de la BDD)
    $('#supprimer_pubs_externes').click(function(){

        var pubs_externes = $('#pubs_selector_externe').val();
        var pubs_externes_sans_espaces = String(pubs_externes).replace(' ',"_");


        if (pubs_externes==null){
            alert('Aucune pub externe selectionnée à supprimer.');
        }

        else{

            //on compare la valeur sélectionner dans le tableau avec la valeur de l'id de l'option créer  entre les balise de l'id select_artiste_higlight.
            if ($('#pubs_selector_externe').val() == $('#'+pubs_externes_sans_espaces + compteur_pubs).val() ) {

                $('#select_pubs_externes').removeAttr("disabled", "disabled");
                $('#'+pubs_externes_sans_espaces + compteur_pubs).hide('<option id="'+ pubs_externes_sans_espaces + compteur_pubs +'" value="'+pubs_externes+'">'+ pubs_externes +'</option>');

            }
        }
    });


    /*
    ***********Recupere et affiche les pubs internes**********
    */
    $('#select_pubs_internes').click(function(){

        var pubs_internes = $('#pubs_selector_interne').val();
        var pubs_internes_sans_espace = String(pubs_internes).replace(' ',"_");
        //mettre string devant pubs_internes sinon la fonction replace n'est pas une fonction.

        if (pubs_internes == null){
            alert('Aucune pub interne selectionnée à ajouter.')
        }

        else{
        compteur_pubs++; // on place le compteur au début afin d'éviter qu'il soit décalé.
        $('#select_pubs_internes').attr("disabled", "disabled");// on sélectionne qu'un seul artiste donc on bloque sélectionner si 1 artistes est sélectionné.
        $('#affichage_pubs_internes').show();
        $('#affichage_pubs_internes').append('<option id="'+pubs_internes_sans_espace + compteur_pubs +'" value="'+pubs_internes+'">'+ pubs_internes +'</option>');

        }
        //faire une fonction communicant avec la base de données afin de récupérer l'artiste highlits
    });

    //supprimer l'affichage de l'artiste highlight avec la selection dans le multiple (encadrer blanc où il y a les artistes de la BDD)
    $('#supprimer_pubs_internes').click(function(){

        var pubs_internes = $('#pubs_selector_interne').val();
        var pubs_internes_sans_espace = String(pubs_internes).replace(' ',"_");

        if (pubs_internes==null){
            alert('Aucune pubs interne selectionnée à supprimer.');
        }

        else{
            //on compare la valeur sélectionner dans le tableau avec la valeur de l'id de l'option créer  entre les balise de l'id select_artiste_higlight.
            if ($('#pubs_selector_interne').val() == $('#'+pubs_internes_sans_espace + compteur_pubs).val() ) {

            $('#select_pubs_internes').removeAttr("disabled", "disabled");
            $('#'+pubs_internes_sans_espace + compteur_pubs).hide('<option id="'+ pubs_internes_sans_espace + compteur_pubs +'" value="'+pubs_internes+'">'+ pubs_internes +'</option>');

            }
        }
    });


    /*
* ------------------------- DATEPICKER ET AFFICHAGE DE LA PROGRAMMATION ET CRENEAUX DISPONIBLES  ------------------------------------
*/

	// Création du dictionnaire français pour le calendrier
	$.datepicker.regional['fr'] = {	clearText: 'Effacer', clearStatus: '',
									closeText: 'Fermer', closeStatus: 'Fermer sans modifier',
									prevText: '<Préc', prevStatus: 'Voir le mois précédent',
									nextText: 'Suiv>', nextStatus: 'Voir le mois suivant',
									currentText: 'Courant', currentStatus: 'Voir le mois courant',
									monthNames: ['Janvier','Février','Mars','Avril','Mai','Juin',
									'Juillet','Août','Septembre','Octobre','Novembre','Décembre'],
									monthNamesShort: ['Jan','Fév','Mar','Avr','Mai','Jun',
									'Jul','Aoû','Sep','Oct','Nov','Déc'],
									monthStatus: 'Voir un autre mois', yearStatus: 'Voir un autre année',
									weekHeader: 'Sm', weekStatus: '',
									dayNames: ['Dimanche','Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'],
									dayNamesShort: ['Dim','Lun','Mar','Mer','Jeu','Ven','Sam'],
									dayNamesMin: ['Di','Lu','Ma','Me','Je','Ve','Sa'],
									dayStatus: 'Utiliser DD comme premier jour de la semaine', dateStatus: 'Choisir le DD, MM d',
									dateFormat: 'dd/mm/yy', firstDay: 0,
									initStatus: 'Choisir la date', isRTL: false};

	// Ouvre le calendrier lors de l'appui sur date
	$.datepicker.setDefaults($.datepicker.regional['fr'])
	$( '#annee_min' ).datepicker({
		changeMonth: true,
		changeYear: true,
		format: 'dd/mm/yyyy',
		language: 'fr'
	});
	$( '#annee_max' ).datepicker({
		changeMonth: true,
		changeYear: true,
		format: 'dd/mm/yyyy',
		language: 'fr'
	});


    function verifier_date_debut(date){
        $.post(
            ajaxurl,
            {
                'action': 'verifier_dates_debut_calendrier',
                'date_debut':date
            },
            function(response){
                //console.log(response);
                if(response=='occupe'){
                    $('#label_warning_calendar').text('Une playlist est déjà prévue à cette heure, choisissez un autre créneau');
                    $('#from').datetimepicker('setDate', null);
                }
            }
        );
    }



    function verifier_date_fin(datedebut,datefin){
        $.post(
            ajaxurl,
            {
                'action': 'verifier_dates_fin_calendrier',
                'date_debut': datedebut,
                'date_fin': datefin
            },
            function(response){
                // console.log(response);
                if(response=='occupe'){
                    $('#label_warning_calendar').text('Une playlist est déjà prévue à cette heure, choisissez un autre créneau');

                    $('#to').datetimepicker('setDate', null);

                }
            }
        );

    }
    function afficher_programmation(){

        $.post(
            ajaxurl,
            {
                'action': 'recuperer_programmation'
            },
            function(response){
                $('#calendrier_dates').append('<table id="table_cal" style="width:100%">');

                $('#table_caltbody').append('<tr>');
                $('#table_cal').append('<th>Réglage</th>');
                $('#table_cal').append('<th>Debut</th>');
                $('#table_cal').append('<th>Fin</th>');
                $('#table_cal').append('</tr>');

                $.each(response.data,function(key,value){
                    if(value.Debut != '' && value.nom !=''){
                        $('#table_cal').append('<tr><td>'+value.nom+'</td><td>'+value.Debut+'</td><td>'+value.Fin+'</td></tr>');

                    }
                });
                $('#calendrier_dates').append('<style type="text/css">table, th, td {border: 1px solid black;}</style>');
            }
        );
    }

// création d'une fonction similaire à afficher_programmation à cause des doublons de classe car la l'affichge n'etais pas bon
// avec le bouton voir la programmation_partie_choix_date.
    function afficher_programmation_partie_choix_date(){

        $.post(
            ajaxurl,
            {
                'action': 'recuperer_programmation'
            },
            function(response){
                $('#calendrier_dates_partie_choix_date').append('<table id="table_cal" style="width:100%">');

                $('#table_caltbody').append('<tr>');
                $('#table_cal').append('<th>Réglage</th>');
                $('#table_cal').append('<th>Debut</th>');
                $('#table_cal').append('<th>Fin</th>');
                $('#table_cal').append('</tr>');

                $.each(response.data,function(key,value){
                    if(value.Debut != '' && value.nom !=''){
                        $('#table_cal').append('<tr><td>'+value.nom+'</td><td>'+value.Debut+'</td><td>'+value.Fin+'</td></tr>');

                    }
                });
                $('#calendrier_dates_partie_choix_date').append('<style type="text/css">table, th, td {border: 1px solid black;}</style>');
            }
        );
    }


    function afficher_playlists_jour(datedebut){
        /* $.post(
            ajaxurl,
            {
                'action': 'recuperer_playlists_jour',
                'date_debut':datedebut

            },
            function(response){
                 var tmd;
                $('#liste_playlists').html('');
                $('#liste_playlists').append('<p><h4>Programmation du '+response.data[3]+'</h4></p>')
               tmd=response.data[0];
                for(var i=0;i<tmd.length;i++){
                    var h=response.data[0][i].date.substr(11);
                    var heure_debut=h.substr(0,5);
                    var h1=response.data[1][i].date.substr(11);
                    var heure_fin=h1.substr(0,5);
                    $('#liste_playlists').append('<p>Playlist <strong>'+response.data[2][i]+'</strong> de '+heure_debut+' à '+heure_fin+'</p>')
                }

            }
        ); */
    }
    function afficher_playlists_jour_fin(datefin){
        /*$.post(
            ajaxurl,
            {
                'action': 'recuperer_playlists_jour_fin',
                'date_fin':datefin

            },
            function(response){
                var tmd;
                $('#liste_playlists_fin').html('');
                $('#liste_playlists_fin').append('<p><h4>Programmation du '+response.data[3]+'</h4></p>')
                tmd=response.data[0];
                for(var i=0;i<tmd.length;i++){
                    var h=response.data[0][i].date.substr(11);
                    var heure_debut=h.substr(0,5);
                    var h1=response.data[1][i].date.substr(11);
                    var heure_fin=h1.substr(0,5);
                    $('#liste_playlists_fin').append('<p>Playlist <strong>'+response.data[2][i]+'</strong> de '+heure_debut+' à '+heure_fin+'</p>')
                }

            }
        ); */

    }
    function recuperer_creneau_dispo(){
        $.post(
            ajaxurl,
            {
                'action': 'trouver_creneau_dispo'
            },
            function(response){
              //  console.log(response);
                var heuredeb =response.data[0]['date'];
                var heure_debut=(heuredeb.substr(11)).substr(0,5);;

                // var heure_debut1=heure_debut.susbtr(0,5);
                var day=response.data[0]['date'];
                var day1=day.substr(0,11);
                var heurefin =response.data[1]['date'];
                var heure_fin=(heurefin.substr(11)).substr(0,5);
                // var heure_fin1=heure_fin.susbtr(0,5);

                $('#text_prochain_passage').text('La playlist passera le '+day1+' de '+heure_debut+' à '+heure_fin+'');

            }
        );
    }

/*------------------ Modification sur la mise en place du début et de la fin de la playlist ------------------*/


    var date_debut_selectionnee;
    var date_fin_selectionnee;


    $('#from').click(function(){
        $('#label_warning_calendar').html('');

    });

    $('#to').click(function(){
        $('#label_warning_calendar').html('');

    });

    // Il faut modifier le time format avec HH:ss pour pour pouvoir modifier les secondes sur la page
    $( "#from" ).datetimepicker({
        defaultDate: "+1w",
        changeMonth: true,
        timeFormat: 'HH:mm',
        stepHour: 1,// permet de chosir le pas pour les heures
        stepMinute: 1,// permet de chosir le pas pour les minutes
        onClose: function( selectedDate ) {
            $( "#to" ).datepicker( "option", "minDate", selectedDate );
            date_debut_selectionnee=selectedDate;
            // afficher_playlists_jour(date_debut_selectionnee);


        }
    });
    $( "#to" ).datetimepicker({
        defaultDate: "+1w",
        changeMonth: true,
        timeFormat: 'HH:mm',
        stepHour: 1,// permet de chosir le pas pour les herues
        stepMinute: 1,// permet de chosir le pas pour les minutes
        onClose: function( selectedDate ) {
            $( "#from" ).datepicker( "option", "maxDate", selectedDate );
            date_fin_selectionnee=selectedDate;
            // afficher_playlists_jour_fin(date_fin_selectionnee);
        }
    });





    /*
* -------------------------------------- RECUPERER ARTISTES POUR HIGHLIGHTS   ------------------------------------------
*/


   /* var artistes_enregistres=new Array();
    var artiste_highlight;*/

    // la fonction recuperer_artistes est dans le fichier gestionbdd-ajax (11/04/2017)
    function artistehighlight(){
        $.ajax({
            url: ajaxurl,
            data:{
                'action':'recuperer_artistes',

            },
            dataType: 'JSON',
            success: function(data){

                $.each(data.data,function(key,value){

                    $('#classement_artistes_higlights').append('<option value="'+value.nom+'">'+ value.nom +'</option>');
                });

                //$("#hightlight-selector").multiselect('rebuild');


            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
            }
        });
    }
    artistehighlight();

    /*
* -------------------------------------- RECUPERER PUBS EXTERNES   ------------------------------------------
*/

   /* var artistes_enregistres=new Array();
    var artiste_highlight;*/

    // la fonction recup_pubs_externes est dans le fichier gestionbdd-ajax (11/04/2017)
    function pubs_externes(){
        $.ajax({
            url: ajaxurl,
            data:{
                'action':'recup_pubs_externes',
            },
            dataType: 'JSON',
            success: function(data){

                $.each(data.data,function(key,value){

                    $('#pubs_selector_externe').append('<option value="'+value.nom+'">'+ value.nom +'</option>');
                    //$('#pubs_selector_externe').append('<option value="exemple> exemple </option>');
                });

                //$("#hightlight-selector").multiselect('rebuild');


            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
            }
        });
    }
    pubs_externes();
    /*
* -------------------------------------- RECUPERER PUBS INTERNES   ------------------------------------------
*/

    /*var artistes_enregistres=new Array();
    var artiste_highlight;*/

    // la fonction recup_pubs_internes est dans le fichier gestionbdd-ajax (11/04/2017)
    function pubs_internes () {
        $.ajax({
            url: ajaxurl, // chemin permettant d'accéder aux fonctions liées à Wordpress
            data:{
                'action':'recup_pubs_internes',

            },
            dataType: 'JSON',
            success: function(data){

                $.each(data.data,function(key,value){

                $('#pubs_selector_interne').append('<option value="'+value.nom+'">'+ value.nom +'</option>');
                //$('#pubs_selector_externe').append('<option value="exemple> exemple </option>');
                });
                 //$('#pubs_selector_interne').append('<option value="exemple>exemple </option>');
                //$("#hightlight-selector").multiselect('rebuild');


            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
            }
        });

    }
    pubs_internes ();

    /*
* ---------------------------------- SLIDERS + CAMEMBERT DYNAMIQUE (GOOGLE PIECHART)----------------------------------------
*/


    var data =null;
    var chart;
    var options;
    var pourcentagepoprock;
    var pourcentagehiphop;
    var pourcentagejazz;
    var pourcentagemusiquemonde;
    var pourcentagehardrock;
    var pourcentageelectro;
    var pourcentageautres;
    var pourcentagechanson;
    var total;
    var el;
    var m;

    // Load the Visualization API and the corechart package.
    google.charts.load('current', {'packages':['corechart']});

    // Set a callback to run when the Google Visualization API is loaded.

    google.charts.setOnLoadCallback(drawChart);
    // Callback that creates and populates a data table,
    // instantiates the pie chart, passes in the data and
    // draws it.
    function drawChart() {

        // Create the data table.
        data = new google.visualization.DataTable();

        data.addColumn('string', 'Topping');
        data.addColumn('number', 'Slices');
        data.addRows([
            ['Pop-Rock', 20],
            ['Hip-Hop & Reggae', 20],
            ['Jazz & Blues', 20],
            ['Musique du monde', 20],
            ['Hard Rock & Métal', 20],
            ['Musique électronique', 20],
            ['chanson', 20],
            ['autres', 20]


        ]);

        // Set chart options
		var h = $('#colonne_sliders').height();
        options = {'title':'Repartition des genres dans la playlist',
                   //'width':h*1.2,
                   'height':h*1.2,
                   is3D: true,
                   legend: {
                       position: 'labeled',
                   },
                   backgroundColor: 'transparent'

                  };
        // Instantiate and draw our chart, passing in some options.
        chart = new google.visualization.PieChart(document.getElementById('chart_div'));
		chart.draw(data, options);


    }


    /*
    *---------------------- Slider -----------------------
    */


    $( "#slider_pop_rock" ).slider({
        value:20,
        min: 0,
        max: 100,
        step: 20,
        slide: function( event, ui ) {
            montantsliders.montant_poprock=ui.value;
            data.removeRow(0);
            data.insertRows(0, [['Pop-Rock', ui.value]]);
            chart.draw(data,options);
        }
    });

    $( "#slider_hiphop" ).slider({
        value:20,
        min: 0,
        max: 100,
        step: 20,
        slide: function( event, ui ) {
            // Affichage
            montantsliders.montant_hiphop=ui.value;
            data.removeRow(1);
            data.insertRows(1, [['Hip-Hop & Reggae', ui.value]]);
            chart.draw(data,options);
        }
    });
    $( "#slider_jazz" ).slider({
        value:20,
        min: 0,
        max: 100,
        step: 20,
        slide: function( event, ui ) {
            montantsliders.montant_jazz=ui.value;
            data.removeRow(2);
            data.insertRows(2, [['Jazz & Blues', ui.value]]);
            chart.draw(data,options);
        }
    });
    $( "#slider_musiquemonde" ).slider({
        value:20,
        min: 0,
        max: 100,
        step: 20,
        slide: function( event, ui ) {
            montantsliders.montant_musiquemonde=ui.value;
            montantmusiquemonde=ui.value;
            data.removeRow(3);
            data.insertRows(3, [['Musique du monde', ui.value]]);
            chart.draw(data,options);
        }
    });
    $( "#slider_hardrock" ).slider({
        value:20,
        min: 0,
        max: 100,
        step: 20,
        slide: function( event, ui ) {

            montantsliders.montant_hardrock=ui.value;
            data.removeRow(4);
            data.insertRows(4, [['Hard Rock & Métal', ui.value]]);
            chart.draw(data,options);
        }
    });

    $( "#slider_electro" ).slider({
        value:20,
        min: 0,
        max: 100,
        step: 20,
        slide: function( event, ui ) {
            // Affichage
            montantsliders.montant_electro=ui.value;
            data.removeRow(5);
            data.insertRows(5, [['Musique électronique', ui.value]]);
            chart.draw(data,options);
        }
    });
    $( "#slider_chanson" ).slider({
        value:20,
        min: 0,
        max: 100,
        step: 20,
        slide: function( event, ui ) {
            // Affichage
            montantsliders.montant_chanson=ui.value;
            data.removeRow(6);
            data.insertRows(6, [['chanson', ui.value]]);
            chart.draw(data,options);
        }
    });
    $( "#slider_autres" ).slider({
        value:20,
        min: 0,
        max: 100,
        step: 20,
        slide: function( event, ui ) {
            // Affichage
            montantsliders.montant_autres=ui.value;
            data.removeRow(7);
            data.insertRows(7, [['autres', ui.value]]);
            chart.draw(data,options);
        }
    });
    $( "#amount_electro" ).val( $( "#slider_electro" ).slider( "value" ) );
    $( "#amount_pop_rock" ).val( $( "#slider_pop_rock" ).slider( "value" ) );
    $( "#amount_hardrock" ).val( $( "#slider_hardrock" ).slider( "value" ) );
    $( "#amount_jazz" ).val( $( "#slider_jazz" ).slider( "value" ) );
    $( "#amount_musiquemonde" ).val( $( "#slider_musiquemonde" ).slider( "value" ) );
    $( "#amount_hiphop" ).val( $( "#slider_hiphop" ).slider( "value" ) );
    $( "#amount_chanson").val( $( "#slider_chanson" ).slider( "value" ) );
    $( "#amount_autres" ).val( $( "#slider_autres" ).slider( "value" ) );

    var montantsliders = {
        montant_poprock: $( "#slider_pop_rock" ).slider( "value" ),
        montant_hiphop: $( "#slider_hiphop" ).slider( "value" ),
        montant_jazz:$( "#slider_jazz" ).slider( "value" ),
        montant_musiquemonde:$( "#slider_musiquemonde" ).slider( "value" ),
        montant_hardrock:$( "#slider_hardrock" ).slider( "value" ),
        montant_electro:$( "#slider_electro" ).slider( "value" ),
        montant_chanson:$( "#slider_chanson" ).slider( "value" ),
        montant_autres:$( "#slider_autres" ).slider( "value" )


    };



    var tableau_noms_reglages_enregistres=new Array();
    function recuperer_noms(){
        $.ajax({
            url: ajaxurl,
            data:{
                'action':'recuperer_noms_reglages',
            },
            dataType: 'JSON',
            success: function(data){


                $.each(data.data,function(key,value){


                    tableau_noms_reglages_enregistres.push(value.nom);
                });



            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
            }
        });




    }
    recuperer_noms();










    /*
* -----------------------------------------------------  Publicités   --------------------------------------------------------
*/


    /*var pubs_internes= new Array();
    var pubs_externes = new Array();
    function pubs(){
        function remove(value){

            //permet de détecter si il n'y a rien dans le tableau
            var idx = this.indexOf(value);
            if (idx != -1) {
                return this.splice(idx, 1); // The second parameter is the number of elements to remove.
            }
            return false;
        }

        $('#pubs-selector').multiselect({
            enableFiltering: true,
            nonSelectedText: 'Choisir une ou plusieurs publicites',
            onChange: function(options, checked) {
                var $option = $(options);


                var $group = $option.parent('optgroup');
                if ($group.hasClass('pubs_externes_group')) {
                    var $options = $('option', $group);
                    $options = $options.filter(':selected');
                    if(checked){
                        pubs_externes.push(options.val());
                    }else{
                        pubs_externes.splice($.inArray(options.val(), pubs_externes),1);
                    }
                    // console.log(pubs_externes);
                }
                if ($group.hasClass('pubs_internes_group')) {
                    var $options = $('option', $group);
                    $options = $options.filter(':selected');
                    if(checked){
                        pubs_internes.push(options.val());
                    }else{
                        pubs_internes.splice($.inArray(options.val(), pubs_internes),1);
                        //pubs_internes.remove(options.val());
                    }
                    // console.log(pubs_internes);
                }

            }

        });

    }
    pubs();
    function recup_pubs_externes(){
        $.ajax({
            url: ajaxurl,
            data:{
                'action':'recup_pubs_externes',
            },
            dataType: 'JSON',
            success: function(data){

                $('#pubs-selector').append('<optgroup class="pubs_externes_group" label="Publicités Externes">');

                $.each(data.data,function(key,value){


                    $('.pubs_externes_group').append('<option value="'+value+'">'+ value +'</option>');

                });
                $('#pubs-selector-externe').append('<option value=exemple>exemple(problème)</option>');
                $("#pubs-selector").multiselect('rebuild');


            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
            }
        });
        // $('#pubs-selector').append('</optgroup>');

    }
    function recup_pubs_internes(){
        $.ajax({
            url: ajaxurl,
            data:{
                'action':'recup_pubs_internes',
            },
            dataType: 'JSON',
            success: function(data){
                //$('#pubs-selector').append('<optgroup class="pubs_internes_group" label="Publicités Internes">');
                $.each(data.data,function(key,value){
                    $('#pubs-selector-interne').append('<option value="'+value+'">'+ value +'</option>');

                });
                    $('#pubs-selector-interne').append('<option value=exemple>exemple(problème)</option>');

                    $("#pubs-selector").multiselect('rebuild');
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
            }
        });


    }

    recup_pubs_externes();
    recup_pubs_internes();



*/


    /*
*
*-------------generer_la_playlist_par_defaut-------------------------------------------   Boutons   ----------------------------------------------------------
*
*/
    /*
    * --------------------------------------------- BOUTON CONFIRMER HORAIRE---------------------------------------------
    */




    /*
    * --------------------------------------------- BOUTON ENREGISTRER REGLAGE ---------------------------------------------
    */
    $("#bouton_enregistrer_reglage").click(function(){


        var pardefaut = 0;
        var artiste_mis_en_avant = artiste_choisi;
        var pubsinternes = pubs_internes;
        var pubsexternes = pubs_externes;
        var nom_reglage = $("#input_nom_reglage").val();
        var tableau_pourcentages = recuperer_pourcentages();
        var passer_des_que_possible = false;
        var date_debut;
        var date_fin;

        var nom_disponible = true;

        /*
            * --------------------------  VERIFICATION DES NOMS   -----------------------------------
            */

       for(var i = 0; i < tableau_noms_reglages_enregistres.length ; i++){
            if(tableau_noms_reglages_enregistres[i] == nom_reglage){
                nom_disponible = false;
            }
        }
        //à l'insertion du champ



        if(nom_disponible == false){


            alert('Le nom de réglage que vous avez entré  est déjà utilisé, veuillez en choisir un nouveau');
           return false;
        }
        else{

      			if($('input[name=checkbox_par_defaut]').is(':checked') ){

            /*  /!\------ Partie enregistrant les playlist par defaut!!!!!  ------/!\*/

                    pardefaut = 1;
                    //On récupere nom du réglage + pourcentages et on indique (avec un boolean) que c'est playlist par defaut
                    $.post(
                        ajaxurl,
                        {
                            'action': 'enregistrer_reglage_par_defaut',
                            'pardefaut':pardefaut,
                            'pourcentage_poprock':tableau_pourcentages.poprock,
                            'pourcentage_hiphop':tableau_pourcentages.hiphop,
                            'pourcentage_jazzblues':tableau_pourcentages.jazzblues,
                            'pourcentage_musiquemonde':tableau_pourcentages.musiquemonde,
                            'pourcentage_electro':tableau_pourcentages.electro,
                            'pourcentage_hardrock':tableau_pourcentages.hardrock,
                            'pourcentage_chanson':tableau_pourcentages.chanson,
                            'pourcentage_autres':tableau_pourcentages.autres,
                            'nom_reglage':nom_reglage,
                        },
                        function(response){
                           console.log(response);
                        }
                    );
               // return false;
            } else {

            /*  /!\------ Partie enregistrant les playlist clips !!!!!  ------/!\*/
                    //console.log("affichage");
                    pardefaut = 0;
                    var duree_picked=false;
                // On recupere nom + pourcentages + artiste hightlight + pubs + date
                    if( $('#bouton_voir_premiere_date_disponible').is(':disabled')){

                        date_debut_selectionnee= $('#from').val();
                        date_fin_selectionnee= $('#to').val();
                        verifier_date_debut(date_debut_selectionnee);
                        verifier_date_fin(date_debut_selectionnee,date_fin_selectionnee);
                        /*alert(date_debut_selectionnee);
                        alert(date_fin_selectionnee);*/
                        //date_passage=duree;
                        duree_picked=true;

                    }
                    if( $('#bouton_choisir_date').is(':disabled')){
                        passer_des_que_possible=true;
                        duree_picked=true;
                    }
                    //console.log('requeteajax');
                if(duree_picked==true){

                    $.post(
                        ajaxurl,
                        {
                            'action': 'enregistrement_playlist_clips_pourcentage',
                            'pardefaut':pardefaut,
                            'passer_des_que_possible':passer_des_que_possible,
                            'pourcentage_poprock':tableau_pourcentages.poprock,
                            'pourcentage_hiphop':tableau_pourcentages.hiphop,
                            'pourcentage_jazzblues':tableau_pourcentages.jazzblues,
                            'pourcentage_musiquemonde':tableau_pourcentages.musiquemonde,
                            'pourcentage_electro':tableau_pourcentages.electro,
                            'pourcentage_hardrock':tableau_pourcentages.hardrock,
                            'pourcentage_chanson':tableau_pourcentages.chanson,
                            'pourcentage_autres':tableau_pourcentages.autres,
                            'nom_reglage':nom_reglage,
                            'pubs_internes':pubsinternes,
                            'pubs_externes':pubsexternes,
                            'artistehighlight':artiste_mis_en_avant,
                            'date_debut':date_debut_selectionnee,
                            'date_fin':date_fin_selectionnee,
                            'camembert_poprock':montantsliders.montant_poprock,
                            'camembert_hiphop':montantsliders.montant_hiphop,
                            'camembert_jazzblues':montantsliders.montant_jazz,
                            'camembert_musiquemonde':montantsliders.montant_musiquemonde,
                            'camembert_electro':montantsliders.montant_electro,
                            'camembert_chanson':montantsliders.montant_chanson,
                            'camembert_autres':montantsliders.montant_autres,
                            'camembert_hardrock':montantsliders.montant_hardrock

                        },
                        function(response){
                                console.log("echo : " +response);

                        }
                    );

                    //débloque le bouton choisir la date lors de l'actualisation
                    $('#bouton_choisir_date').removeAttr("disabled");
                    $('#bouton_voir_premiere_date_disponible').removeAttr("disabled");
                }else{
                    alert('Veuillez choisir une option de diffusion pour la playlist');
                    return false;
                    }
                }



        }
        /*tableau_pourcentages= { poprock:'', rap:'', jazzblues:'',musiquemonde:'', hardrock:'', electro:'' };*/
        $('#input_nom_reglage').val();
        location.reload();
    });

/*


    /*
    * --------------------------------------------- BOUTON ANNULER REGLAGE---------------------------------------------
    */

    $("#bouton_annuler_reglage").click(function(){
        alert('Régagle annulé');
        exit();
    });

    /*
*-----------------------------------------  Recupération des informations -------------------------------------------------
*
*/

    function recuperer_pourcentages(){
        var total;
        var tableau_pourcentages= {
            poprock:'',
            hiphop:'',
            jazzblues:'',
            musiquemonde:'',
            hardrock:'',
            electro:'',
            chanson:'',
            autres:''
        };
        total=montantsliders.montant_electro+montantsliders.montant_hardrock+montantsliders.montant_jazz+montantsliders.montant_musiquemonde+montantsliders.montant_poprock+montantsliders.montant_hiphop+montantsliders.montant_autres+montantsliders.montant_chanson;

        pourcentagepoprock= Math.round(montantsliders.montant_poprock/total * 1000) / 10 ;
        pourcentagehiphop= Math.round(montantsliders.montant_hiphop/total * 1000) / 10 ;
        pourcentagejazz= Math.round(montantsliders.montant_jazz/total * 1000) / 10 ;
        pourcentagemusiquemonde= Math.round(montantsliders.montant_musiquemonde/total * 1000) / 10 ;
        pourcentagehardrock= Math.round(montantsliders.montant_hardrock/total * 1000) / 10 ;
        pourcentageelectro= Math.round(montantsliders.montant_electro/total * 1000) / 10 ;
        pourcentagechanson= Math.round(montantsliders.montant_chanson/total * 1000) / 10 ;
        pourcentageautres= Math.round(montantsliders.montant_autres/total * 1000) / 10 ;

        tableau_pourcentages.poprock=pourcentagepoprock;
        tableau_pourcentages.hiphop=pourcentagehiphop;
        tableau_pourcentages.jazzblues=pourcentagejazz;
        tableau_pourcentages.musiquemonde=pourcentagemusiquemonde;
        tableau_pourcentages.hardrock=pourcentagehardrock;
        tableau_pourcentages.electro=pourcentageelectro;
        tableau_pourcentages.chanson=pourcentagechanson;
        tableau_pourcentages.autres=pourcentageautres;


        return tableau_pourcentages;
    }


});
