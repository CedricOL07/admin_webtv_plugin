<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Tableau Clips</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <style type="text/css">
    table
    {
      table-layout: fixed;
    }
    td div { width: 200px; overflow: hidden; }
    </style>
  </head>
  <body>
    <div class="container">
      <div class="row">
        <div class="col">
          <h4 style="color:#9191FA"><B>Clips vidéos :</B>  <button type="button" class="btn btn-primary btn-xs" id="afficher">Afficher</button></h4>
        </div>
      </div>
      <div class="row" id="tableau" style="display:none">
        <table class="table table-bordered">
          <thead>
            <tr style="background-color:#9191FA;color:black;"  id="tr0">
              <th><label><input type="checkbox" onClick="toggle(this)" />Tout sélectionner</label></th>
              <th>Titre</th>
              <th>Artiste</th>
              <th>Album</th>
              <th class="col-md-2">Genre</th>
              <th class="col-sm-1">Année</th>
              <th class="col-sm-1">Qualité</th>
              <th class="col-md-3">URL</th>
            </tr>
          </thead>
          <tbody id='tableau_corps'>
          </tbody>
        </table>
      </div>
      <div class="row" style="display:none" id="button_line">
        <div class="col-md-offset-4 col-md-4">
          <button type="button" class="btn btn-block btn-primary" id="supprimer">Supprimer</button>
        </div>
      </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo plugins_url('admin_webtv_plugin/includes/GestionBDD/tableau_clips_videos/tableau_clips_videos.js');?>"></script>
    <script type='text/javascript'>
    // Cocher toutes les cases
      function toggle(source) {
        checkboxes = document.getElementsByName('foo');
        for(var i=0, n=checkboxes.length;i<n;i++) {
          checkboxes[i].checked = source.checked;
        }
      };
      </script>
  </body>
</html>
