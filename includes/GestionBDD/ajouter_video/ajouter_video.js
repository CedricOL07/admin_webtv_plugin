
$(document).ready(function(){
	
	// Création du dictionnaire français pour le calendrier
	$.datepicker.regional['fr'] = {clearText: 'Effacer', clearStatus: '',
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
	$( '#annne_prod' ).datepicker({
		defaultDate: "-1w",
		changeMonth: true,
		format: 'dd/mm/yyyy',
		language: 'fr'
	});
	var is_linux = true;
	$("#OS").change(function(){
		is_linux = !is_linux;
		console.log(is_linux);
	});		
    $('#bouton_inserer_contenu').click(function(){

	// Appel d'une fonction php pour insérer du contenu dynamiquement
		 
		
		//console.log("Entrée dans le js");
		
		var titre=$('#titre').val();
		var url_video=$('#url').val();
		var artiste_video=$('#artiste').val();
		var genre=$('#genre').val();
		var album=$('#album').val();
		var annee=$('#annne_prod').val();
		var qualite=$('#qualite').val();
		var finalfolder=$('#CHEMINARRIVE').val();
		var filepath=$('#FILEPATH').val();
		var filename=$('#FILENAME').val();
		var is_linux=$('#OS').val();
		
		//console.log(genre);
		//console.log(finalfolder + ' and ' + filepath + ' and ' + filename);
		
		
		
		if(titre != '' && url_video != '' && artiste_video != '' && annee != '' && album != '')
		{	
			$.post(
				ajaxurl,
				{
					'action':'ajouter_video',
					'myParams':
					{
						'is_linux':is_linux,
						'titre':titre,
						'url_video':url_video,
						'artiste_video':artiste_video,
						'genre':genre,
						'album':album,
						'annee':annee,
						'qualite':qualite,
						'finalfolder':finalfolder,
						'filepath':filepath,
						'filename':filename
					}
				},
			function(data)
				{
					console.log(finalfolder);
					console.log("existante :" + data);
					var newpath = document.location.toString();
					var ind1 = newpath.indexOf('&filepath');
					ind1>0 ? newpath = newpath.substr(0,ind1) : newpath = newpath; 	// Si il y a déja un filepath, on l'efface
					document.location.href = newpath.substr(0, ind1);				// On actualise la page
				}
			);
					
			
		}else{
			
			if(titre == ''){
				$('#warning-insertion').append('<strong><span style="color:red;">Vous n\'avez pas entré de titre, veuillez en entrer un</span></strong>');
					console.log('PAS DE TITRE');
			}else{
				if(url_video== ''){
					$('#warning-insertion').append('<strong><span style="color:red;">Vous n\'avez pas entré d\'url pour la vidéo, veuillez en entrer une</span></strong>');
					console.log('PAS D\'URL');
				}else{
					if(artiste_video == ''){
						$('#warning-insertion').append('<strong><span style="color:red;">Vous n\'avez pas entré d\'artiste pour la vidéo, veuillez en entrer un</span></strong>');
					console.log('PAS D\'ARTISTE');
					}else{
						if(annee == ''){
							$('#warning-insertion').append('<strong><span style="color:red;">Vous n\'avez pas sélectionné d\'année pour la vidéo, veuillez en entrer une</span></strong>');
					console.log('PAS D\'ANNEE');
						}else{
							if(album == ''){
								$('#warning-insertion').append('<strong><span style="color:red;">Vous n\'avez pas sélectionné d\'album pour la vidéo, veuillez en entrer un</span></strong>');
					console.log('PAS D\'ALBUM');
							}
						}
					}
				}
			}
		}
	
    });
});