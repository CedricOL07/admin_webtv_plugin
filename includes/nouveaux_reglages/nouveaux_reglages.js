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
			//console.log(artiste_choisi);
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
			//console.log(artiste_choisi);
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
			//console.log(artiste_choisi);
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
			console.log(new Date( time+ msecsInADay));
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
	
	var passer_des_que_possible_clicked = false;
	
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
			},	/////////////////// A adapter, cf: http://alloyui.com/examples/scheduler/real-world/    http://alloyui.com/tutorials/scheduler/   http://alloyui.com/api/files/alloy-ui_src_aui-scheduler_js_aui-scheduler-event-recorder.js.html
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
		
		scheduler.attachEvent("onEventSave",function(id,ev,is_new){
			if (!ev.text) {
				alert("Text must not be empty");
				return false;
			} else
			{
				console.log(ev.text);
			}
			console.log("Texte a marché");
			$.post(
				ajaxurl,
				{
					'action': 'change_playlist_name',
					'ancien_nom':ancien_nom,
					'nouveau_nom':nouveau_nom
				},
				function(response){
				   console.log("echo : "+ response);
				}
			);
		});
		
		var dragged_event;
		scheduler.attachEvent("onBeforeDrag", function (id, mode, e){
			dragged_event=scheduler.getEvent(id); //use it to get the object of the dragged event
			return true;
		});
		 
		 
		scheduler.attachEvent("onDragEnd", function(){
			var event_obj = dragged_event;
			var nouvelle_start_date = event_obj.start_date;
			var nouvelle_end_date = event_obj.end_date;
			var nom_event = event_obj.text
			nouvelle_start_date = nouvelle_start_date.toISOString();
			nouvelle_end_date = nouvelle_end_date.toISOString();
			
			nouvelle_start_date=nouvelle_start_date.replace("T", " ").replace("Z", "");
			nouvelle_end_date=nouvelle_end_date.replace("T", " ").replace("Z", "");
			
			console.log(nouvelle_start_date);
			$.post(
				ajaxurl,
				{
					'action': 'change_playlist_date',
					'nouvelle_start_date':nouvelle_start_date,
					'nouvelle_end_date':nouvelle_end_date,
					'nom_event':nom_event
				},
				function(response){
				   console.log("echo : "+ response);
				}
			);
		});
		
		scheduler.parse(events, "json");//takes the name and format of the data source
	
	});
	
	
/*	-------------------------------------------- Ancien scheduler ----------------------------------------------------
YUI().use(
	'aui-scheduler',
	function(Y) {
		var events = new Array;
		
		$.when(							// Permet d'attendre que la requête Ajax soit terminée
			$.ajax({
				url: ajaxurl,
				data:{
					'action':'get_playlist_content',
				},	/////////////////// A adapter, cf: http://alloyui.com/examples/scheduler/real-world/    http://alloyui.com/tutorials/scheduler/   http://alloyui.com/api/files/alloy-ui_src_aui-scheduler_js_aui-scheduler-event-recorder.js.html
				dataType: 'JSON',
				success: function(data) {
					
					$.each(data.data, function(index, value) {
						
						var start_date = value.Debut;
						var end_date = value.Fin;
						var nom_event = value.nom;
						
						var date_time = start_date.split(' ');				// {date jj/mm/aaaa , heure hh:mm)
						var date_now = date_time[0].split('/');
						start_date = date_now[2]+'-'+date_now[1]+'-'+date_now[0]+' '+date_time[1];   	// Met la date au format aaaa-mm-jj hh:mm
						start_date = new Date(start_date);
						
						var date_time = end_date.split(' ');				// {date jj/mm/aaaa , heure hh:mm)
						var date_now = date_time[0].split('/');
						end_date = date_now[2]+'-'+date_now[1]+'-'+date_now[0]+' '+date_time[1];   	// Met la date au format aaaa-mm-jj hh:mm
						end_date = new Date(end_date);
						
						var ligne_playlist_enregistrees = new Y.SchedulerEvent({
							content : nom_event, 
							endDate : end_date,
							startDate : start_date
						});
						
						events.push(ligne_playlist_enregistrees);
					});
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(xhr.status);
					console.log(thrownError);
				}
			})
		).then (function(){
				
			
			var agendaView = new Y.SchedulerAgendaView();
			var dayView = new Y.SchedulerDayView();
			var weekView = new Y.SchedulerWeekView();
			var monthView = new Y.SchedulerMonthView();

			new Y.Scheduler(
			{
				boundingBox: '#calendar',
				date: 'today',
				items: events,
				render: true,
				views: [weekView, dayView, monthView, agendaView]
				
			});
			console.log(SchedulerEvent());
		});
		
	}
);
*/
	

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
            // afficher_playlists_jour(date_debut_selectionnee);


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

                    $('#pubs_selector_externe').append('<option value="'+value.nom+'">'+ value.nom +'</option>');
                    //$('#pubs_selector_externe').append('<option value="exemple> exemple </option>');
                });

                //$("#hightlight-selector").multiselect('rebuild');


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

                $('#pubs_selector_interne').append('<option value="'+value.nom+'">'+ value.nom +'</option>');
                //$('#pubs_selector_externe').append('<option value="exemple> exemple </option>');
                });
                 //$('#pubs_selector_interne').append('<option value="exemple>exemple </option>');
                //$("#hightlight-selector").multiselect('rebuild');


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
    * --------------------------------------------- BOUTON CONFIRMER HORAIRE---------------------------------------------
    */




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
			console.log(annee_max);
		} else
		{
			annee_max = "99991231";
		}
		if (annee_min != "")
		{
			var date_now = annee_min.split('/');
			annee_min = date_now[2]+date_now[1] + date_now[0];       // Met la date au format aaaammjj
			console.log(annee_min);
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
                            'freq_logo':freq_logo,
                        },
                        function(response){
                           console.log("echo : "+ response);
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
                    if(date_debut_selectionnee && date_fin_selectionnee && passer_des_que_possible_clicked==false){
                        passer_des_que_possible=true;
                        duree_picked=true;
						console.log("Duree picked = true");
                    } else{
						console.log("Duree picked = false");
					}
                    //console.log('requeteajax');
                if(duree_picked==true){
					
					console.log("Entrée dans le js-playlist-clip "+annee_max+annee_min+ " qualite_min : " +qualite_min);

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
                            'camembert_poprock':montantsliders.montant_poprock,
                            'camembert_hiphop':montantsliders.montant_hiphop,
                            'camembert_jazzblues':montantsliders.montant_jazz,
                            'camembert_musiquemonde':montantsliders.montant_musiquemonde,
                            'camembert_electro':montantsliders.montant_electro,
                            'camembert_chanson':montantsliders.montant_chanson,
                            'camembert_autres':montantsliders.montant_autres,
                            'camembert_hardrock':montantsliders.montant_hardrock,
                            'freq_logo':freq_logo,

                        },
                        function(response){

                                console.log("echo : "+artiste_mis_en_avant+" : "+response);

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
