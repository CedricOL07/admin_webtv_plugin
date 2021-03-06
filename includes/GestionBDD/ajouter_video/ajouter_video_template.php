<!DOCTYPE html>
<html lang="fr">
    <head>
        <title>Gestion du contenu</title>
        <meta charset="utf-8">
        <meta http-equiv="Cache-control" content="no-cache">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
		<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
		<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">
		<link rel="stylesheet" href="https://glyphsearch.com/bower_components/font-awesome/css/font-awesome.min.css">




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

			<!-- Variables utilisées à la fois dans le script js et php par la suite
			FILEPATH et FILENALE : chemin et fichier origine à copier
			CHEMINARRIVE : Chemin de copie: à adapter si nécessaire en ligne 173 -->

				<input type="hidden" id="CHEMINARRIVE" name="CHEMINARRIVE" value=" ">
				<input type="hidden" id="FILEPATH" name="FILEPATH" value=" ">
				<input type="hidden" id="FILENAME" name="FILENAME" value=" ">

				<!-- Ligne 0 -->
				<div class="form-group">
				    &nbsp;
				</div>

				<!-- Ligne 1 -->
				<div class="row">
					<div class="col-md-2">
						<label for="titre">Titre :</label>
					</div>
					<div class="col-md-2">
						<input type="text" class="form-control" name="titre" id="titre" placeholder="Titre"/>
					</div>
					<div class="col-md-1">
						<span class="glyphicon glyphicon-question-sign" style='color:#0964CD; font-size:120%; padding-top: 15%;' title="Titre du clip" > </span>
					</div>
				<!-- album -->
					<div class="col-md-offset-2 col-md-2">
						<label for="album">Album :</label>
					</div>
					<div class="col-md-2">
						<input type="text" class="form-control input" name="album" id="album" placeholder="Album" />
					</div>
					<div class="col-md-1">
						<span class="glyphicon glyphicon-question-sign" style='color:#0964CD; font-size:120%; padding-top: 15%;' title="Album ou 'Live'" > </span>
					</div>
				</div>
				<!-- Ligne 2 -->
				<div class="row">
					<div class="col-md-2">
						<label for="artiste"> Artiste :</label>
					</div>
					<div class="col-md-2">
						<input type="text" class="form-control" name="artiste" id="artiste" placeholder="Artiste" />
					</div>
					<div class="col-md-1">
						<span class="glyphicon glyphicon-question-sign" style='color:#0964CD; font-size:120%; padding-top: 15%;' title="Chanteur, groupe ou prestataire" > </span>
					</div>

					<div class="col-md-offset-2 col-md-2">
					<label for="annee_prod">Date :</label>
					</div>
					<div class="col-md-2">
	                 	<input type='text' class="form-control" name="annne_prod" id='annne_prod' placeholder="Date prestation" />
					</div>
					<div class="col-md-1">
						<span class="glyphicon glyphicon-question-sign" style='color:#0964CD; font-size:120%; padding-top: 15%;' title="Date au format jj/mm/aaaa" > </span>
					</div>
				</div>
				<!-- Ligne 3 -->
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
							<option value="Publicité Interne">Publicité Interne</option>
							<option value="Publicité Externe">Publicité Externe</option>
							<option value="Logo">Logo</option>
							<option value="Autre">Autre...</option>
						</select>
					</div>
					<div class="col-md-1">
						<span class="glyphicon glyphicon-question-sign" style='color:#0964CD; font-size:120%; padding-top: 15%;' title="Genre musical, publicité ou logo du Fil" > </span>
					</div>

					<div class="col-md-offset-2 col-md-2">
					<label for="qualite"> Qualité :</label>
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
					<div class="col-md-1">
						<span class="glyphicon glyphicon-question-sign" style='color:#0964CD; font-size:120%; padding-top: 15%;' title="Qualité de la vidéo" > </span>
					</div>
				</div>

				<!-- Ligne 4 -->
				<div class="row">
					<div class="col-md-2">
						<label for="path">Source :</label>
					</div>
					<div class="col-md-2">
						<input type="text" class="form-control" name="path" id="path"  placeholder="Emplacement" onchange="changePath(this)">
					</div>
					<div class="col-md-1">
						<span class="glyphicon glyphicon-question-sign" style='color:#0964CD; font-size:120%; padding-top: 15%;' title="Dossier de la vidéo à enregistrer
Completer pour déverouiller le bouton 'Parcourir'" > </span>
					</div>
				</div>

				<!-- Ligne 5 -->
				<div class="row">
					<div class="col-md-2">
						<label for="url">Vidéo :</label>
					</div>
					<div class="col-md-7">
						<div class="input-group">
							<label class="input-group-btn">
								<span class="btn btn-sm btn-primary">
									Parcourir <!-- &hellip; --> <input type="file" id="chemin1" style="display: none;" multiple>
								</span>
							</label>
							<input type="text" class="form-control input-sm" name="url" id="url" placeholder="..." onblur="changeFinalFolder(this)">
						</div>
					</div>
					<div class="col-md-2">
						<button class="btn btn-block btn-sm btn-secondary" id="bouton_modifier_url_par_defaut" type="button" onclick="unlockPath()"> Modifier URL par défaut
						</button>
					</div>
					<div class="col-md-1">
						<span class="glyphicon glyphicon-question-sign" style='color:#0964CD; font-size:120%; padding-top: 15%;' title="- Parcourir: Selection de la vidéo à mettre en ligne
- URL par défaut: Domaine et dossier de destination lors de l'upload de la vidéo" > </span>
					</div>
				</div>

				<div class="form-group">
				    &nbsp;
				</div>

				<div class="row">
				  <div class="col-md-offset-4 col-md-4">
						<button class="btn btn-block btn-primary" id="bouton_inserer_contenu" type="input">Insérer
						</button>
				  </div>
				</div>

		        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

				<script type="text/javascript">
					document.getElementById('chemin1').disabled = 'disabled';
					document.getElementById('url').disabled = 'disabled';
				</script>
			</form>


		</div>




		<script type="text/javascript" src="<?php echo plugins_url('admin_webtv_plugin/includes/GestionBDD/ajouter_video/ajouter_video.js');?>">
		</script>
    </body>


	<script>

/////////////////////////////////////////\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
			// CHEMIN A ADAPTER POUR L'ENREGISTREMENT DES VIDEOS \\


		var newpath="";
		var filename="";
		var filepath="";

		var finalfolder = localStorage.getItem("finalfolder");		// finalfolder = localPath + endOfPath
		var endOfPath = localStorage.getItem("endOfPath");			// Par défaut : wordpress/wp-content/uploads/2017/07
		var domaine = localStorage.getItem("domaine");				// Par defaut : http://webtv.le-fil.com/
		var localPath = localStorage.getItem("localPath");			// Récupéré à partir de l'emplacement de ce fichier, utilisé pour la copie (CHEMINARRIVE)


		localStorage.removeItem("localPath");
		if (endOfPath===null || typeof endOfPath === 'undefined' || endOfPath === "")
		{
			endOfPath = "wordpress/wp-content/uploads/2017/07";
			localStorage.setItem("endOfPath", endOfPath);
		}

		if (domaine===null || typeof domaine === 'undefined' || domaine === "")
		{
			domaine = "http://localhost/";
			localStorage.setItem("domaine", domaine);
		}
		if (localPath===null || typeof localPath === 'undefined' || localPath === "")
		{
			localPath = `<?php echo addslashes(__DIR__ )?>`;
			var deb = localPath.indexOf("wordpress");
			localPath = localPath.substring(0,deb);		// Récupère le chemin local
			localStorage.setItem("localPath", localPath);
			////console.log("\ndomaine = " + domaine +"\nlocalPath = " + localPath +"\nendOfPath = " + endOfPath +"\nfinalfolder = " + finalfolder);
		}
		if (finalfolder===null || typeof finalfolder === 'undefined' || finalfolder === "")
		{
			setFinalfolder();
		}

		// Si chemin en local : utiliser des anti-slash \
		// Si chemin html (localhost...): utiliser des slash /
/////////////////////////////////////////\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\


		document.getElementById('url').placeholder = domaine+endOfPath+"/...";
		document.getElementById("CHEMINARRIVE").value=finalfolder;


		function setEndOfPath(pat)
		{
			i = pat.indexOf('wordpress');
			endOfPath = pat.substring(i);
			localStorage.setItem("endOfPath", endOfPath);
		}
		function setDomaine(pat)
		{
			i = pat.indexOf('wordpress');
			domaine = pat.substring(0,i);
			localStorage.setItem("domaine", domaine);
		}
		function setFinalfolder()
		{
			if (localPath.indexOf('\\')>0)	// si localPath est constitué avec des '\' (windows)
			{
				finalfolder=localPath+endOfPath.replace(/\//g, '\\');
			} else 							// si localPath est constitué avec des '/' (linux...)
			{
				finalfolder=localPath+endOfPath.replace(/\\/g, '/')
			}

			localStorage.setItem("finalfolder", finalfolder);
		}

		// Dévérouille le textfield du chemin par défaut lors de l'appui sur le bouton
		function unlockPath(){
			document.getElementById('url').disabled = '';
			document.getElementById('url').value = domaine+endOfPath;
			document.getElementById('url').focus();	// Met le focus sur le textField
		}

		// Met à jour le chemin par défaut au moment où on enlève le focus du textfield
		function changeFinalFolder(selectObj){
			if(selectObj.value!=""){
				setEndOfPath(selectObj.value);
				setDomaine(selectObj.value);
				setFinalfolder();
			}
			if (filename != "")					// Si on avait déjà récupéré une vidéo avec 'parcourir', on actualise la page
			{
				document.location.href = document.location.toString();;
			}
			document.getElementById('url').placeholder = domaine+endOfPath+"/...";
			document.getElementById('url').value = "";
			document.getElementById('url').disabled = 'disabled';
		}

		// Active le bouton parcourir si on entre un chemin valide dans "chemin initial"
		function commentUrl(){
	        if(document.getElementById('path').value!=""){
	            document.getElementById('chemin1').disabled = '';
	        }
	        else{
	            document.getElementById('chemin1').disabled = 'disabled';
	        }
	    }

	    // Met à jour le "chemin initial"
		function changePath(selectObj)
		{
			newpath = document.location.toString();

			filepath = selectObj.value;
			if (filename != "")					// Si on avait déjà récupéré une vidéo avec 'parcourir', on actualise la page
			{
				document.location.href = newpath;
			}

			commentUrl();
		}

		// Met à jour les élément du POST pour la copie
		function copier()
		{
			//finalfolder = finalfolder.replace(/\//g, '\\');
			document.getElementById("CHEMINARRIVE").value = finalfolder;
			document.getElementById("FILEPATH").value = filepath;
			document.getElementById("FILENAME").value = filename;

			//finalfolder = finalfolder.replace(/\\/g, '/');
		}

		$(function() {



			// Permet d'ouvrir la fenetre "parcourir" de l'explorateur
			$(document).on('change', ':file', function() {
			  var input = $(this),
				  numFiles = input.get(0).file ? input.get(0).file.length : 1,
				  label = input.val().replace(/\\/g, '/').replace(/.*\//, '');

				  filename = label;
 				  // history.pushState({path:this.path}, '', document.location.href+'&filename='+label);	// n'actualise pas la page tout de suite
 				  //document.location.href = document.location.href+'&filename='+label;	// sert à passer la variable au php

 				  if (filename!="" && filepath!="")
 				  {
 				  	copier();
 				  }


				  // var cheminURL = "localhost/wordpress/wp-content/uploads/2017/05/";

			 	  var cheminURL = domaine+endOfPath + '/' + filename;
			 	  document.getElementById('url').placeholder = cheminURL;
			 	  document.getElementById('url').value = document.getElementById('url').placeholder ;
				/*
				  //////console.log(cheminURL);
				  var tempad = document.location.toString()
				  tempad = tempad.substr(0, tempad.indexOf('&filename'))
				  //history.pushState({path:this.path}, '', tempad);	// n'actualise pas la page tout de suite
				*/
				  input.trigger('fileselect', [numFiles, cheminURL]);

			});

			// Remplissage auto du champ de l'url
			$(document).ready( function() {
				$(':file').on('fileselect', function(event, numFiles, label) {

					var input = $(this).parents('.input-group').find(':text'),
					//var input = $(this),
						//label = input.val().replace(/\\/g, '/').replace(/.*\//, ''),
						log = numFiles > 1 ? numFiles + ' files selected' : label;

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
