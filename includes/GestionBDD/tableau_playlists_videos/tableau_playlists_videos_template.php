<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Tableau Playlists</title>
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
          <h4 style="color:#F95D5D"><B>Clips playlists :</B>  <button type="button" class="btn btn-primary btn-xs" id="afficher2">Afficher</button></h4>
        </div>
      </div>
      <div class="row" id="tableau2" style="display:none">
        <table class="table table-bordered">
          <thead>
            <tr style="background-color:#F95D5D;color:black;"  id="tr0">
              <th><label><input type="checkbox" onClick="toggles(this)" /> Tout selectionner</label></th>
			  <th>Nom</th>
              <th>Poprock</th>
              <th>rap</th>
              <th>Jazzblues</th>
              <th>Monde</th>
              <th>Electro</th>
              <th>HardRock</th>
			  <th>Chanson</th>
			  <th>Autre</th>
            </tr>
          </thead>
          <tbody id='tableau_corps2'>
          </tbody>
        </table>
      </div>
      <div class="row" style="display:none" id="button_line2">
        <div class="col-md-offset-4 col-md-4">
          <button type="button" class="btn btn-block btn-primary" " id="supprimer2">Supprimer</button>
        </div>
      </div>
    </div>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo plugins_url('admin_webtv_plugin/includes/GestionBDD/tableau_playlists_videos/tableau_playlists_videos.js');?>"></script>
    <script type='text/javascript'>
    // Cocher toutes les cases
      function toggles(source) {
        checkboxes = document.getElementsByName('fooo');
        for(var i=0, n=checkboxes.length;i<n;i++) {
          checkboxes[i].checked = source.checked;
        }
      };
      </script>
  </body>
</html>
