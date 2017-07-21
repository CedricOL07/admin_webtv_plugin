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
        $('#bouton_choisir_date').hide();
        $('#trigger_choisir_date').toggleClass('hidden display');
        $('#bouton_voir_premiere_date_disponible').hide();
        $('#bouton_voir_premiere_date_disponible').attr("disabled", "disabled");
    });


    $('#annuler_choisir_date').click(function(){
        $('#bouton_voir_premiere_date_disponible').removeAttr("disabled");
        $('#trigger_choisir_date').toggleClass('display hidden');
        $('#bouton_choisir_date').show();
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

	var is_pardefaut = false;
    //Checkbox pour mettre par defaut ou non le réglage
    $('#checkbox_par_defaut').change(function(){

        if(this.checked){
			$('#planning_playlist').hide();
            $('#partie_highlight').hide();
            $('#partie_publicites').hide();
            $('#partie_diffusion').hide();
			is_pardefaut = true;
        }else{
			$('#planning_playlist').show();
            $('#partie_highlight').show();
            $('#partie_publicites').show();
            $('#partie_diffusion').show();
			is_pardefaut = false;
        }
    });


    /*
    ***********Recupere et affiche l'artiste en highlight**********
    */
    var artiste_choisi; // permet de récupérer l'artiste choisi lors de l'enregistrement
	var artiste_highlight;

    $('#select_artiste_higlight').click(function(){
        artiste_highlight = null;
		artiste_highlight = $('#classement_artistes_higlights').val();
        //mettre string devant artiste_highlight sinon la fonction replace n'est pas une fonction.
        if (artiste_highlight == null){
            alert('Aucun artiste selectionné...');
        }else
		{
            $('#select_artiste_higlight').attr("disabled", "disabled"); // on sélectionne qu'un seul artiste donc on bloque sélectionner si 1 artistes est sélectionné.
            $('#affichage_artiste_higlight').append('<div id="ah"> '+artiste_highlight+' </div>'); // crée le texte avec l'artiste highlight
			artiste_choisi = artiste_highlight;
			////console.log(artiste_choisi);
        }
    });
    //supprimer l'affichage de l'artiste highlight avec la selection dans le multiple (encadrer blanc où il y a les artistes de la BDD)
    $('#supprimer_artistes_higlight').click(function(){
        if (artiste_highlight == null){
            alert('Aucun artiste selectionné à supprimer.');
        }else
		{
            $('#select_artiste_higlight').removeAttr("disabled", "disabled");
			artiste_highlight = null;
			artiste_choisi=null;
			$('#ah').remove();
		}
    });

    /*
    ***********Recupere et affiche les pubs externes**********
    */
    var pub_externe_choisie; // permet de récupérer l'artiste choisi lors de l'enregistrement
	var pubs_externes;

    $('#select_pubs_externes').click(function(){
        pubs_externes = null;
		pubs_externes = $('#pubs_selector_externe').val();
        if (pubs_externes == null){
            alert('Aucune pub externe selectionnée...');
        }else
		{
            $('#select_pubs_externes').attr("disabled", "disabled"); // on sélectionne qu'un seul artiste donc on bloque sélectionner si 1 artistes est sélectionné.
            $('#affichage_pubs_externes').append('<div id="pe"> '+pubs_externes+' </div>'); // crée le texte avec la pub externe
			pub_externe_choisie = pubs_externes;
			////console.log(artiste_choisi);
        }
    });
    //supprimer l'affichage de la pub externe
    $('#supprimer_pubs_externes').click(function(){
        if (pubs_externes == null){
            alert('Aucune pub externe selectionnée...');
        }else
		{
            $('#select_pubs_externes').removeAttr("disabled", "disabled");
			pubs_externes = null;
			pub_externe_choisie=null;
			$('#pe').remove();
		}
    });


    /*
    ***********Recupere et affiche les pubs internes**********
    */
    var pub_interne_choisie; // permet de récupérer l'artiste choisi lors de l'enregistrement
	var pubs_internes;

    $('#select_pubs_internes').click(function(){
        pubs_internes = null;
		pubs_internes = $('#pubs_selector_interne').val();
        if (pubs_internes == null){
            alert('Aucune pub interne selectionnée...');
        }else
		{
            $('#select_pubs_internes').attr("disabled", "disabled"); // on sélectionne qu'un seul artiste donc on bloque sélectionner si 1 artistes est sélectionné.
            $('#affichage_pubs_internes').append('<div id="pe"> '+pubs_internes+' </div>'); // crée le texte avec la pub interne
			pub_interne_choisie = pubs_internes;
			////console.log(artiste_choisi);
        }
    });
    //supprimer l'affichage de la pub interne
    $('#supprimer_pubs_internes').click(function(){
        if (pubs_internes == null){
            alert('Aucune pub interne selectionnée...');
        }else
		{
            $('#select_pubs_internes').removeAttr("disabled", "disabled");
			pubs_internes = null;
			pub_interne_choisie=null;
			$('#pe').remove();
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
		maxDate: 'today',
		format: 'dd/mm/yyyy',
		language: 'fr',
		onSelect: function(date){
			var msecsInADay = 86400000;
			var date_now = date.split('/');
			date = date_now[2]+'-'+date_now[1]+'-' + date_now[0];       // Met la date au format aaaa-mm-jj
			time = (new Date(date)).getTime()
			$("#annee_max").datepicker( "option", "minDate", new Date( time + msecsInADay));
			//console.log(new Date( time+ msecsInADay));
		}
	});
	$( '#annee_max' ).datepicker({
		changeMonth: true,
		changeYear: true,
		maxDate: 'today',
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
                ////console.log(response);
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
                // //console.log(response);
                if(response=='occupe'){
                    $('#label_warning_calendar').text('Une playlist est déjà prévue à cette heure, choisissez un autre créneau');

                    $('#to').datetimepicker('setDate', null);

                }
            }
        );

    }

	var passer_des_que_possible_clicked = false;

    function recuperer_creneau_dispo(){
        $.post(
            ajaxurl,
            {
                'action': 'trouver_creneau_dispo'
            },
            function(response){
              //  //console.log(response);
                var heuredeb =response.data[0]['date'];
                var heure_debut=(heuredeb.substr(11)).substr(0,5);;

                // var heure_debut1=heure_debut.susbtr(0,5);
                var day=response.data[0]['date'];
                var day1=day.substr(0,11);
                var heurefin =response.data[1]['date'];
                var heure_fin=(heurefin.substr(11)).substr(0,5);
                // var heure_fin1=heure_fin.susbtr(0,5);
				passer_des_que_possible_clicked = true;
                $('#text_prochain_passage').text('La playlist passera le '+day1+' de '+heure_debut+' à '+heure_fin+'');

            }
        );
    }


/*------------------------------------- Gestion du calendrier / planning -------------------------------------------*/
// doc : https://docs.dhtmlx.com/scheduler/how_to_start.html
// signaux: https://docs.dhtmlx.com/api__dhtmlxcalendar_onchange_event.html
// 			https://docs.dhtmlx.com/scheduler/api__scheduler_oneventsave_event.html
//////////////////////////////////////////////////////////////////////////

//Afficher/masquer le tableau
  $('#bouton_voir_cacher_programmation').change(function(){
    $('#planning_playlist').toggle('fast');
	if ($('#bouton_voir_cacher_programmation').val() == "Cacher la programmation")
	{
		document.getElementById("bouton_voir_cacher_programmation").value = "Afficher la programmation";
	} else{
		document.getElementById("bouton_voir_cacher_programmation").value = "Cacher la programmation";
	}
  });

	$('#scheduler_here').height($(document).width()*0.5);
	$('#scheduler_here').width($(document).width()*0.7);
	scheduler.init('scheduler_here', new Date(),"week");

	var events = [];
	var indice_event = 0;
	$.when(							// Permet d'attendre que la requête Ajax soit terminée
		$.ajax({
			url: ajaxurl,
			data:{
				'action':'get_playlist_content',
			},
			dataType: 'JSON',
			success: function(data) {

				$.each(data.data, function(index, value) {

					var startDate = value.Debut;
					var endDate = value.Fin;
					var nom_event = value.nom;

					var date_time = startDate.split(' ');				// {date jj/mm/aaaa , heure hh:mm)
					var date_now = date_time[0].split('/');
					startDate = date_now[2]+'-'+date_now[1]+'-'+date_now[0]+' '+date_time[1];   	// Met la date au format aaaa-mm-jj hh:mm
					startDate = new Date(startDate);

					var date_time = endDate.split(' ');				// {date jj/mm/aaaa , heure hh:mm)
					var date_now = date_time[0].split('/');
					endDate = date_now[2]+'-'+date_now[1]+'-'+date_now[0]+' '+date_time[1];   	// Met la date au format aaaa-mm-jj hh:mm
					endDate = new Date(endDate);

					var ligne_playlist_enregistrees = {
						id			: indice_event,
						text 		: nom_event,
						end_date 	: endDate,
						start_date 	: startDate
					};
					indice_event++;

					events.push(ligne_playlist_enregistrees);
				});
			},
			error: function (xhr, ajaxOptions, thrownError) {
				console.log(xhr.status);
				console.log(thrownError);
			}
		})
	).then (function(){

		// Lorsqu'un évènement est renommé
		var changed_event_title;
		var changed_event_startDate;
		var changed_event_endDate;

		scheduler.attachEvent("onBeforeLightbox", function (id){
			changed_event_title = scheduler.getEvent(id).text; //use it to get the object of the changed event
			changed_event_startDate = scheduler.getEvent(id).start_date; //use it to get the object of the changed event
			changed_event_endDate = scheduler.getEvent(id).end_date; //use it to get the object of the changed event
			return true;
		});

		scheduler.attachEvent("onEventSave",function(id,ev,is_new){
			if (!ev.text) {
				alert("Text must not be empty");
				return false;
			} else
			{
				//console.log(ev.text);
				var ancien_nom = changed_event_title;
				var nouveau_nom = ev.text;

				$.post(
					ajaxurl,
					{
						'action': 'change_playlist_name',
						'ancien_nom':ancien_nom,
						'nouveau_nom':nouveau_nom
					},
					function(response){
					   //console.log("echo : "+ response);
					}
				);
				ev.start_date = changed_event_startDate;
				ev.end_date = changed_event_endDate;
				return true;
			}
		});

		// Lorsqu'un évènement est déplacé/étiré
		var dragged_event;
		scheduler.attachEvent("onBeforeDrag", function (id, mode, e){
			dragged_event=scheduler.getEvent(id); //use it to get the object of the dragged event
			return true;
		});

		scheduler.attachEvent("onDragEnd", function(){
			var event_obj = dragged_event;
			var nouvelle_start_date = event_obj.start_date;
			var nouvelle_end_date = event_obj.end_date;
			var nom_event = event_obj.text;

			var tzoffset = (new Date()).getTimezoneOffset() * 60000; //offset in milliseconds du fuseau horaire
			nouvelle_start_date = (new Date(nouvelle_start_date - tzoffset)).toISOString().slice(0,-1);
			nouvelle_end_date = (new Date(nouvelle_end_date - tzoffset)).toISOString().slice(0,-1);	// slice(0,-1) supprime le Z de fin (qui représente la Zulu timezone)

			nouvelle_start_date=nouvelle_start_date.replace("T", " ");
			nouvelle_end_date=nouvelle_end_date.replace("T", " ");

			//console.log(nom_event+" : "+nouvelle_start_date+" - "+nouvelle_end_date);
			$.post(
				ajaxurl,
				{
					'action': 'change_playlist_date',
					'nouvelle_start_date':nouvelle_start_date,
					'nouvelle_end_date':nouvelle_end_date,
					'nom_event':nom_event
				},
				function(response){
				}
			);
			$.post(
				ajaxurl,
				{
					'action': 'gestion_une_playlist_a_la_fois',
					'date_debut':nouvelle_start_date,
					'date_fin':nouvelle_end_date,
					'nom_playlist':nom_event
				},
				function(response){
				}
			);

		});

		// Lorsqu'un évenement est supprimé
		var deleted_event_name;
		scheduler.attachEvent("onBeforeEventDelete", function(id,e){
			deleted_event_name = scheduler.getEvent(id).text;
			return true;
		});
		scheduler.attachEvent("onEventDeleted", function(id){
			var nom_event_supprime = deleted_event_name;
			//console.log (nom_event_supprime);
			$.post(
				ajaxurl,
				{
					'action': 'delete_playlist',
					'nom_event':nom_event_supprime
				},
				function(response){
				   //console.log("echo : "+ response);
				}
			);
		});

		scheduler.parse(events, "json");//takes the name and format of the data source

	});



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
        defaultDate: "today",
        changeMonth: true,
        timeFormat: 'HH:mm',
        stepHour: 1,// permet de chosir le pas pour les heures
        stepMinute: 1,// permet de chosir le pas pour les minutes
        onClose: function( selectedDate ) {
            $( "#to" ).datepicker( "option", "minDate", selectedDate );
            date_debut_selectionnee=selectedDate;


        }
    });
    $( "#to" ).datetimepicker({
        defaultDate: "today",
        changeMonth: true,
        timeFormat: 'HH:mm',
        stepHour: 1,// permet de chosir le pas pour les herues
        stepMinute: 1,// permet de chosir le pas pour les minutes
        onClose: function( selectedDate ) {
            date_fin_selectionnee=selectedDate;
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
                alert(" -alerte artiste highlight");
                alert(" -alerte highlight.");
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
                    $('#pubs_selector_externe').append('<option value="'+value+'">'+ value +'</option>');
                });


            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert("- pub ext");
                alert("- pub ext.");
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
					$('#pubs_selector_interne').append('<option value="'+value+'">'+ value +'</option>');
                });


            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert("- pub int");
                alert("- pub int.");
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
                alert(xhr.status+" -alerte récupérer_noms");
                alert(thrownError+" -alerte récupérer_noms.");
            }
        });

    }
    recuperer_noms();






    /*
*
*-------------generer_la_playlist_par_defaut-------------------------------------------   Boutons   ----------------------------------------------------------
*
*/


    /*
    * --------------------------------------------- BOUTON PAGE PRINCIPALE GENERER 1 HEURE une PLAYLIST DU GENRE DESIRER ---------------------------------------------
    */

	function bouton_1h(num_bouton_1h)
	{
		var nom_reglage ;
    var plage_horaire_playlist_exclusif = $("#plage_horaire_playlist_exclusif").val();
		var pc_pr = 0; // % poprock
		var pc_hh = 0; // % hip-hop
		var pc_jb = 0; // % jazz-blues
		var pc_mm = 0; // % musique du monde
		var pc_el = 0; // % electro
		var pc_hr = 0; // % hard rock
		var pc_ch = 0; // % chanson
		var pc_au = 0; // % autres

		switch (num_bouton_1h){
			case 1: //Pop-rock
				nom_reglage = "Pop-rock_1h";
				pc_pr = 100;
				break;
			case 2: //hip-hop
				nom_reglage = "Hip-Hop_et_Rap_1h";
				pc_hh = 100;
				break;
			case 3: //jazz-blues
				nom_reglage = "Jazz_et_Blues_1h";
				pc_jb = 100;
				break;
			case 4: //musique du monde
				nom_reglage = "Musique_du_monde_et_Reggae_1h";
				pc_mm = 100;
				break;
			case 5: //electro
				nom_reglage = "Electro_1h";
				pc_el = 100;
				break;
			case 6: //hard rock
				nom_reglage = "Hard_Rock_et_Metal_1h";
				pc_hr = 100;
				break;
			case 7: //chanson
				nom_reglage = "Chanson_1h";
				pc_ch = 100;
				break;
			default: //autres
				nom_reglage = "Autres_1h";
				pc_au = 100;
		}
    /////////////////////////////////////////////////////////////////////////
    Date.prototype.addHours = function(h) {
       this.setTime(this.getTime() + (h*60*60*1000));
       return this;
    }
    /////////////////////////////////////////////////////////////////////////	
	var offset = (new Date()).getTimezoneOffset()*60000;
	var date = new Date(Date.now() - offset);
	
	console.log(date);
	
    var str_date_debut = (date.toISOString().slice(0,10)+" "+date.toISOString().slice(11,16));
    console.log("Debut :" +str_date_debut);
		// récupère la date actuelle

    date.addHours(plage_horaire_playlist_exclusif);
    var str_date_fin = (date.toISOString().slice(0,10)+" "+date.toISOString().slice(11,16));
    //console.log("Fin :" +str_date_fin);

		var pardefaut = 0;
		var annee_max = '99991231';
		var annee_min= '00010101';
		var qualite_min = 1;
		var date_debut_selectionnee = str_date_debut;
		var date_fin_selectionnee = str_date_fin;
		var freq_logo = 6;
		$.post(
			ajaxurl,
			{
				'action': 'gestion_une_playlist_a_la_fois',
				'date_debut':date_debut_selectionnee,
				'date_fin':date_fin_selectionnee,
				'nom_playlist':nom_reglage
			},
			function(response){
				console.log(response);
			}
		);
		$.when(
			$.post(
				ajaxurl,
				{
					'action': 'delete_playlist',
					'nom_event':nom_reglage
				},
				function(response){
				}
			)
		).then(
			$.post(
				ajaxurl,
				{
					'action': 'enregistrement_playlist_clips_pourcentage',
					'pardefaut':pardefaut,
					'annee_max':annee_max,
					'annee_min':annee_min,
					'qualite_min':qualite_min,
					'pourcentage_poprock':pc_pr,
					'pourcentage_hiphop':pc_hh,
					'pourcentage_jazzblues':pc_jb,
					'pourcentage_musiquemonde':pc_mm,
					'pourcentage_electro':pc_el,
					'pourcentage_hardrock':pc_hr,
					'pourcentage_chanson':pc_ch,
					'pourcentage_autres':pc_au,
					'nom_reglage':nom_reglage,
					'date_debut':date_debut_selectionnee,
					'date_fin':date_fin_selectionnee,
					'freq_logo':freq_logo,
				},
				function(response){
					$.post(
						ajaxurl,
						{
							'action': 'vider_table_playlist_clip'
						},
						function(response2){
							//console.log(response2);
						}
					)
				}
			)
		);


		location.reload();
	}


    $("#Pop-rock_btn").click(function(){
		bouton_1h(1);
    });

    $("#Hip-Hop_et_Rap_btn").click(function(){
		bouton_1h(2);
    });

	$("#Jazz_et_Blues_btn").click(function(){
		bouton_1h(3);
    });

    $("#Musique_du_monde_et_Reggae_btn").click(function(){
		bouton_1h(4);
    });

	$("#Electro_btn").click(function(){
		bouton_1h(5);
    });

	$("#Hard_Rock_et_Metal_btn").click(function(){
		bouton_1h(6);
    });

	$("#Chanson_btn").click(function(){
		bouton_1h(7);
    });

	$("#Autres_btn").click(function(){
		bouton_1h(8);
    });


    /*
    * --------------------------------------------- BOUTON ENREGISTRER REGLAGE ---------------------------------------------
    */
    $("#bouton_enregistrer_reglage").click(function(){

        var pardefaut = 0;
		var annee_max = $("#annee_max").val();
		var annee_min = $("#annee_min").val();
		var qualite_min= $("#qualite_min").val();
        var artiste_mis_en_avant = artiste_choisi;
        var pubsinternes = pub_interne_choisie;
        var pubsexternes = pub_externe_choisie;
        var nom_reglage = $("#input_nom_reglage").val();
        var tableau_pourcentages = recuperer_pourcentages();
        var passer_des_que_possible = false;
        var date_debut;
        var date_fin;
        var freq_logo = $("#freq_logo").val();

        var nom_disponible = true;

        /*
		* --------------------------  VERIFICATION DES DATES MIN ET MAX   -----------------------------------
		*/

		if (annee_max != "")
		{
			var date_now = annee_max.split('/');
			annee_max = date_now[2]+date_now[1] + date_now[0];       // Met la date au format aaaammjj
			//console.log(annee_max);
		} else
		{
			annee_max = "99991231";
		}
		if (annee_min != "")
		{
			var date_now = annee_min.split('/');
			annee_min = date_now[2]+date_now[1] + date_now[0];       // Met la date au format aaaammjj
			//console.log(annee_min);
		} else
		{
			annee_min = "00010101"; // 01/01/0001
		}


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

      			if(is_pardefaut){

    /*  /!\--------------- Partie enregistrant les playlist par defaut!!!!!  --------------/!\   */
				    pardefaut = 1;
                    //On récupere nom du réglage + pourcentages et on indique (avec un boolean) que c'est playlist par defaut
                    $.post(
                        ajaxurl,
                        {
                            'action': 'enregistrer_reglage_par_defaut',
                            'pardefaut':pardefaut,
							'annee_max':annee_max,
							'annee_min':annee_min,
							'qualite_min':qualite_min,
                            'pourcentage_poprock':tableau_pourcentages.poprock,
                            'pourcentage_hiphop':tableau_pourcentages.hiphop,
                            'pourcentage_jazzblues':tableau_pourcentages.jazzblues,
                            'pourcentage_musiquemonde':tableau_pourcentages.musiquemonde,
                            'pourcentage_electro':tableau_pourcentages.electro,
                            'pourcentage_hardrock':tableau_pourcentages.hardrock,
                            'pourcentage_chanson':tableau_pourcentages.chanson,
                            'pourcentage_autres':tableau_pourcentages.autres,
                            'nom_reglage':nom_reglage,
                            'freq_logo':freq_logo
                        },
                        function(response){
                           //console.log("echo : "+ response);
                        }
                    );
               // return false;
				} else {

            /*  /!\------ Partie enregistrant les playlist clips !!!!!  ------/!\*/
                    ////console.log("affichage");
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
                    if(date_debut_selectionnee && date_fin_selectionnee && passer_des_que_possible_clicked==false){
                        passer_des_que_possible=true;
                        duree_picked=true;
						//console.log("Duree picked = true");
                    } else{
						//console.log("Duree picked = false");
					}
                    ////console.log('requeteajax');
                if(duree_picked==true){

					var startDate = date_debut_selectionnee;
					var endDate = date_fin_selectionnee;

					var date_time = startDate.split(' ');				// {date jj/mm/aaaa , heure hh:mm)
					var date_now = date_time[0].split('/');
					date_debut_selectionnee = date_now[2]+'-'+date_now[1]+'-'+date_now[0]+' '+date_time[1];   	// Met la date au format aaaa-mm-jj hh:mm

					var date_time = endDate.split(' ');				// {date jj/mm/aaaa , heure hh:mm)
					var date_now = date_time[0].split('/');
					date_fin_selectionnee = date_now[2]+'-'+date_now[1]+'-'+date_now[0]+' '+date_time[1];   	// Met la date au format aaaa-mm-jj hh:mm

                    $.post(
                        ajaxurl,
                        {
							'action': 'enregistrement_playlist_clips_pourcentage',
                            'pardefaut':pardefaut,
							'annee_max':annee_max,
							'annee_min':annee_min,
							'qualite_min':qualite_min,
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
                            'freq_logo':freq_logo

                        },
                        function(response){

                            //console.log("echo : "+response);

                        }
                    );

                    //débloque le bouton choisir la date lors de l'actualisation
                    $('#bouton_choisir_date').removeAttr("disabled");
                    $('#bouton_voir_premiere_date_disponible').removeAttr("disabled");
                }else{
                    alert('Veuillez choisir une date de diffusion pour la playlist');
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
