
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
  <head>
    <meta charset="utf-8">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <title>WEBTVFIL</title>
  </head>
  <body class="hold-transition skin-black sidebar-mini">

    <div class="wrapper">

      <!-- Main Header -->

      <!-- Left side column. contains the logo and sidebar -->
      <!-- Control Sidebar -->


      <?php
      //include( MY_PLUGIN_PATH . '../../templates/homepage/sidebar_homepage.template.php');?>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            WEBTVFIL
            <!--<small>Optional description</small>-->
          </h1>

        </section>

        <!-- Main content -->
        <section class="content">


          <div class="container-fluid">

            <div class="bootstrap-wpadmin">
                <div class="row col-md-12 col-sm-12" >
                  <h2>
                    Playlist - EXCLUSIF

                  </h2>
                  <div class="col-md-3 col-sm-3">
                    <select name="plage_horaire_playlist_exclusif" id="plage_horaire_playlist_exclusif" value="Choisir la durée de passage de la playlist" style="margin-bottom:10px;">
                      <option >--durée de passage de la playlist--</option>
                      <option value="1">1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                      <option value="4">4</option>
                      <option value="5">5</option>
                      <option value="6">6</option>
                      <option value="7">7</option>
                      <option value="8">8</option>
                      <option value="9">9</option>
                      <option value="10">10</option>
                      <option value="11">11</option>
                      <option value="12">12</option>
                      <option value="24">24</option>
                    </select>
                    <button class="btn btn-primary btn-block" id="Pop-rock_btn">Pop-rock</button>
                    <button class="btn btn-danger btn-block" id="Hip-Hop_et_Rap_btn">Hip-Hop et Rap</button>
                    <button class="btn btn-warning btn-block" id="Jazz_et_Blues_btn">Jazz et Blues</button>
                    <button class="btn btn-block" style="background-color:#00833D; color:#FEFEFE; " id="Musique_du_monde_et_Reggae_btn">Monde &  Reggae</button>
                    <button class="btn btn-block" style="background-color:#750071; color:#FEFEFE;"  id="Hard_Rock_et_Metal_btn">Hard Rock et Métal</button>
                    <button class="btn btn-info btn-block" id="Electro_btn">Electro</button>
                    <button class="btn btn-block" style="background-color:#EA39A4; color:#FEFEFE; "id="Chanson_btn">Chanson</button>
                    <button class="btn btn-success btn-block" style="margin-bottom: 20px;"  id="Autres_btn">Autres</button>
                  </div>

                  <div class="col-md-6 col-md-offset-2 col-sm-6 col-sm-offset-2" id="lecteur_video">
                    <div id="container_jplayer" class="jp-video jp-video-270p" role="application" aria-label="media player">
                      <button class="btn btn-block" style="background-color:#F90000; color:#FEFEFE;" id="Stop_playlist">Arrêter la playlist en cours</button>
                      <div class="jp-type-playlist">
                        <div id="player_video" class="jp-jplayer"></div>
                        <div class="jp-gui">
                          <div class="jp-video-play">
                            <button class="jp-video-play-icon" role="button" tabindex="0">play</button>
                          </div>
                          <div class="jp-interface">
                            <div class="jp-progress">
                              <div class="jp-seek-bar">
                                <div class="jp-play-bar"></div>
                              </div>
                            </div>
                            <!-- <div class="jp-current-time" role="timer" aria-label="time">&nbsp;</div>
                            <div class="jp-duration" role="timer" aria-label="duration">&nbsp;</div>-->
                            <div class="jp-current-time" role="timer" aria-label="time" style="display">&nbsp;</div>
                            <div class="jp-duration" role="timer" aria-label="duration" style="display" >&nbsp;</div>
                            <div class="jp-controls-holder"style="height:35px;">
                              <div class="jp-controls" >
                                <button class="jp-previous" role="button" tabindex="0" style="display:none;">previous</button>
                                <button class="jp-play" role="button" tabindex="0" style="display:none;">play</button>
                                <button class="jp-next" role="button" tabindex="0" style="display:none;">next</button>
                                <button class="jp-stop" role="button" tabindex="0" style="display:none;">stop</button>
                              </div>
                              <div class="jp-volume-controls">
                                <button class="jp-mute" role="button" tabindex="0">mute</button>
                                <button class="jp-volume-max" role="button" tabindex="0">max volume</button>
                                <div class="jp-volume-bar">
                                  <div class="jp-volume-bar-value"></div>
                                </div>
                              </div>
                              <div class="jp-toggles" >
                                <button class="jp-repeat" role="button" tabindex="0" style="display:none;">repeat</button>
                                <button class="jp-shuffle" role="button" tabindex="0" style="display:none;">shuffle</button>
                                <button class="jp-full-screen" role="button" tabindex="0">full screen</button>
                              </div>
                            </div>
                            <div class="jp-details">
                              <div class="jp-title" aria-label="title">&nbsp;</div>
                            </div>
                          </div>
                        </div>
                        <input id="affichage_playlist_homepage" type="button"  data-toggle="toggle" value="Afficher/cacher la liste clips" >
                        <div id="jp-playlits-id-homepage" class="jp-playlist" style="display;">
                          <ul>
                            <li>&nbsp;</li>
                          </ul>
                        </div>
                        <!-- The method Playlist.displayPlaylist() uses this unordered list -->
                        <div class="jp-no-solution">
                          <span>Update Required</span>
                          To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
                        </div>
                      </div>
                    </div>
                </div>
              </div>
              </div>
              <div class="col-md-8 col-sm-8">
              <?php include( MY_PLUGIN_PATH . 'includes/WEBTV/page_principale/calendrier.php');?>
              </div>
          </div>
          <style type="text/css">

          .jp-previous{
            display:none;
          }
          </style>
        </section>
      </div>
    </div>
  </body>
</html>
