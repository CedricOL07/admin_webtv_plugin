
$(document).ready(function(){
	
	
	$( "#datetimepicker" ).datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        timeFormat: 'dd/mm/yyyy'
    });

	
    $('#bouton_inserer_contenu').click(function(){

	// Appel d'une fonction php pour insérer du contenu dynamiquement
		 
		
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