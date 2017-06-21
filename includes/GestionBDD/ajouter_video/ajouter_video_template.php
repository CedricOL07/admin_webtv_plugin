<!DOCTYPE html>
<html lang="fr">
    <head>
        <title>Gestion du contenu</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

	</head>
    <body>
		<style type="text/css">

			.formulaire{
				text-align:left;
				font-weight:bold;
			}

			.form-control{
				border-color: black;
				border-radius: 0px;
				border-style:solid;
				border-width:2px;
			}

			.btn{
				border-radius: 0px;
			}
	
			.row{
				margin-bottom: 2px;
			}
		</style>
		<div class="container formulaire">
			<!-- Titre -->
			<div class="row">
			  <div class="col">
				<h1 style="text-align:center"><B><U>Gestion du contenu</U></B></h1>
			  </div>
			</div>
			
			<!-- Création d'un formulaire: appelera le fichier ajouter_video.php -->
			<form method="post" name="ajout" enctype="multipart/form-data">
			<div class="col-md-12" id="warning-insertion"></div>
			
				<!-- Ligne 1 -->
				<div class="row">
					<div class="col-md-2">
						<label for="titre">Titre :</label>
					</div>
					<div class="col-md-2">
						<input type="text" class="form-control" name="titre" id="titre" placeholder="Titre" />
					</div>
				<!-- album -->
					<div class="col-md-offset-3 col-md-2">
						<label for="album">Album :</label>
					</div>
					<div class="col-md-2">
						<input type="text" class="form-control input" name="album" id="album" placeholder="Album" />
					</div>
				</div>
				<!-- Ligne 2 -->
				<div class="row">
					<div class="col-md-2">
						<label for="path">Chemin complet :</label>
					</div>
					<div class="col-md-2">
						<input type="text" class="form-control" name="path" id="path"  placeholder="Chemin" onchange="changePath(this)">
					</div>
					<div class="col-md-offset-3 col-md-2">
						<label for="url">URL Vidéo :</label>
					</div>
					<div class="col-md-3">
						<div class="input-group">
							<input type="text" class="form-control" name="url" id="url" placeholder="URL">
							<label class="input-group-btn">
								<span class="btn btn-primary">
									Parcourir <!-- &hellip; --> <input type="file" id="chemin1" style="display: none;" multiple> 
									
								</span>
							</label>
						</div>
					</div>
				</div>
				<!-- Ligne 3 -->
				<div class="row">
					<div class="col-md-2">
						<label for="artiste"> Artiste :</label>
					</div>
					<div class="col-md-2">
						<div class="input-group">
							<input type="text" class="form-control" name="artiste" id="artiste" placeholder="Artiste">
						</div>
					</div>

					<div class="col-md-offset-3 col-md-2">
					<label for="annee_prod">Année de production :</label>
					</div>
					<div class="col-md-2">
						<input type="text" class="form-control" name="annne_prod" id="annne_prod"  placeholder="Année production">
					</div>
				</div>
				<!-- Ligne 4 -->
				<div class="row">
					<div class="col-md-2">
						<label for="genre"> Genre :</label>
					</div>
					<div class="col-md-2">
						<select name="genre" id="genre" class="form-control">
							<option value="Pop-rock">Pop-Rock</option>
							<option value="Hip-hop & Reggae">Hip-Hop & Reggae</option>
							<option value="Jazz & Blues">Jazz & Blues</option>
							<option value="Musique du monde">Musique du Monde</option>
							<option value="Hard-rock & Metal">Métal & Hard-Rock</option>
							<option value="Musique electronique">Electro</option>
							<option value="Chanson française">Chanson Française</option>
							<option value="Autre">Autre...</option>
						</select>
					</div>

					<div class="col-md-offset-3 col-md-2">
					<label for="qualite"> Qualité du clip :</label>
					</div>
					<div class="col-md-2">
						<select name="qualite" id="qualite" class="form-control">
						   <option value="1">1</option>
						   <option value="2">2</option>
						   <option value="3">3</option>
						   <option value="4">4</option>
						   <option value="5">5</option>
					   </select>
					</div>
					
				</div>
				<div class="row">
				  <div class="col-md-offset-4 col-md-4">
						<button class="btn btn-block btn-primary" id="bouton_inserer_contenu" type="input">Insérer
						</button>
				  </div>
				</div>
			</form>
		</div>
			
		<script type="text/javascript" src="<?php echo plugins_url('admin_webtv_plugin/includes/GestionBDD/ajouter_video/ajouter_video.js');?>">
		</script>
    </body>
<!--
<script>
String function adresse(){

	//nom = $_FILES['chemin1']['name'] ;    //Le nom original du fichier, comme sur le disque du visiteur (exemple : mon_icone.png).
	nom = chemin1['name'];
	chem = chemin1['tmp_name'];
	//chem = $_FILES['chemin1']['tmp_name'] ;//L'adresse vers le fichier uploadé dans le répertoire temporaire.
	tot = nom; //+chem
	document.getElementById("url").value=tot;
	return nom;

}-->	
</script>
		
	
	<script>

		function changePath(selectObj)
		{
			var newpath = document.location.toString();
			var ind1 = newpath.indexOf('&filepath');
			// if (ind1 > 0)	// si il y a déja un filepath (il faudra le supprimer)
			// {
			// 	var ind2 = newpath.indexOf('&filename'); // si il y a un filename, déterminer si il est avant ou après
			//	
			//	newpath = ind2 > ind1 ? newpath.substr(0, ind1)+newpath.substr(ind2) : newpath.substr(0, ind1);			
			// }
			// newpath = newpath + '&filepath='+selectObj.value;
			ind1>0 ? newpath = newpath.substr(0,ind1) : newpath = newpath; // Si il y a déja un filepath, on l'efface
			newpath = newpath + '&filepath='+selectObj.value;
			console.log(newpath);
			history.pushState({path:this.IRL}, '', newpath);	// n'actualise pas la page tout de suite
			if (document.ajout.url.value != "")
			{
				document.location.href = newpath.substr(0, ind1);
			}
		}

		$(function() {
			// Permet d'ouvrir la fenetre "parcourir" de l'explorateur
			$(document).on('change', ':file', function() {
			  var input = $(this),
				  numFiles = input.get(0).file ? input.get(0).file.length : 1,
				  label = input.val().replace(/\\/g, '/').replace(/.*\//, '');

 				  history.pushState({path:this.path}, '', document.location.href+'&filename='+label);	// n'actualise pas la page tout de suite
 				  //document.location.href = document.location.href+'&filename='+label;	// sert à passer la variable au php

			 	  `<?php
			 	  ////////////////////////////////////////////////////////////////////////////////
			 	  	// CHEMIN A ADAPTER POUR L'ENREGISTREMENT DES VIDEOS
			 	    $cheminArrive = "C:\wamp64\www\wordpress\wp-content\uploads\\2017\\05\\";
			 	  ////////////////////////////////////////////////////////////////////////////////

			 	  	$fich = $_GET[filename];
			 	  	$path = $_GET[filepath];
			 	  	if($path && $fich)
			 	  	{
			 	  		copy($path."\\".$fich, $cheminArrive.$fich);
			 	  	}
				  	
				  ?>`;
				  var cheminArrive = "C:/wamp64/www/wordpress/wp-content/uploads/2017/05/";

			 	  cheminArrive = cheminArrive + label;
			 	  
				  //console.log(cheminArrive);
				  var tempad = document.location.toString()
				  tempad = tempad.substr(0, tempad.indexOf('&filename'))
				  //history.pushState({path:this.path}, '', tempad);	// n'actualise pas la page tout de suite

				  input.trigger('fileselect', [numFiles, cheminArrive]);
 				  
			});

			// Remplissage auto du champ de l'url
			$(document).ready( function() {
				$(':file').on('fileselect', function(event, numFiles, label) {

					var input = $(this).parents('.input-group').find(':text'),
					//var input = $(this),
						//label = input.val().replace(/\\/g, '/').replace(/.*\//, ''),
						log = numFiles > 1 ? numFiles + ' files selected' : label;
					console.log(label);	

					if( input.length ) {
						input.val(log);
					} else {
						if( log ) alert(log);
					}

				});
			});
		});
	</script>


    
</html>

