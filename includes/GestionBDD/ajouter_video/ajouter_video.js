
$(document).ready(function(){


    $('#bouton_inserer_contenu').click(function(){

	// Appel d'une fonction php pour insérer du contenu dynamiquement
		/* */
		console.log('Entrée dans le js');
		
		var titre=$('#titre').val();
		var url_video=$('#url').val()
		var artiste_video=$('#artiste').val()
		var genre=$('#genre').val();
		var album=$('#album').val()
		var annee=$('#annne_prod').val()
		var qualite=$('#qualite').val()
		console.log(genre);
			
		if(titre != '' && url_video != '' && artiste_video != '' && annee != '' && album != '')
		{	

			$.ajax({
				url:ajaxurl,
				type:'POST',
				dataType:"json",
				data:{
					'action':'ajouter_video',
					'myParams':{
						'titre':titre,
						'url_video':url_video,
						'artiste_video':artiste_video,
						'genre':genre,
						'album':album,
						'annee':annee,
						'qualite':qualite
					}
				},
				success:function(data)
				{
					console.log(data);
			}
			});
					
			
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