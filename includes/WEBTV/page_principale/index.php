
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
  <head>
    <meta charset="utf-8">
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <!-- Utile pour le calendrier -->
    <script src="http://cdn.alloyui.com/3.0.1/aui/aui-min.js"></script>
    <link href="http://cdn.alloyui.com/3.0.1/aui-css/css/bootstrap.min.css" rel="stylesheet"></link>

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
              <div class="row">
                <div class="col-md-12">

                  <h3 class="text-center">
                    WEB TV LIVE - Le Fil
                  </h3>
                </div>
                <div class="col-md-12" style="height:5%;"></div>
                <div class="col-md-6">
                  <h3>
                    ON AIR
                  </h3>
                  <div class="col-md-offset-9 col-sm-offset-7 col-md-3 col-sm-5" >
                      <input type="checkbox" id="bouton_voir_cacher_programmation" checked data-toggle="toggle" data-onstyle="default"
                      data-off="<i class='glyphicon glyphicon-download' style='color:#2C4CB3'></i> <i class='glyphicon glyphicon-calendar' style='color:#2C4CB3'></i> "
                      data-on="<i class='glyphicon glyphicon-upload' style='color:#2C4CB3'></i> <i class='glyphicon glyphicon-calendar' style='color:#2C4CB3'></i> "/>
                  </div>
                  <div class="row col-md-6 col-sm-6" id="planning_playlist" >

                      <div id="scheduler_here" class="dhx_cal_container" >
                          <div class="dhx_cal_navline">
                              <div class="dhx_cal_prev_button">&nbsp;</div>
                              <div class="dhx_cal_next_button">&nbsp;</div>
                              <div class="dhx_cal_today_button"></div>
                              <div class="dhx_cal_date"></div>
                              <div class="dhx_cal_tab" name="day_tab" style="right:204px;"></div>
                              <div class="dhx_cal_tab" name="week_tab" style="right:140px;"></div>
                              <div class="dhx_cal_tab" name="month_tab" style="right:76px;"></div>
                          </div>
                          <div class="dhx_cal_header"></div>
                          <div class="dhx_cal_data"></div>
                      </div>
                  </div>
                  <button class="btn btn-primary" id="live_btn">Lancer le LIVE</button>
                </div>
                <div class="col-md-4" style="margin-top:2%;">
                  <div class="row">
                    <div class="col-md-4" id="lecteur_video">
                      <div id="container_jplayer" class="jp-video jp-video-270p" role="application" aria-label="media player">
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
              </div>
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
