
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
<head>
  <meta charset="utf-8">

  <title>WEBTVFIL</title>
  <!-- Tell the browser to be responsive to screen width --

  <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
  page. However, you can choose any other skin. Make sure you
  apply the skin class to the body tag so the changes take effect.
-->


<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script
<![endif]-->



<!-- Fichiers CSS locaux -->
<!--  <link rel="stylesheet" href="../../assets/css/homepage.css">
<link rel="stylesheet" href="../../assets/css/AdminLTE.min.css">
<link rel="stylesheet" href="../../assets/css/skins/_all-skins.min.css">-->
<!-- <link rel="stylesheet" href="../../assets/css/style.css">-->



<!-- <link href="assets/css/jplayer.blue.monday.min.css" rel="stylesheet" type="text/css" />-->
<!-- <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">-->
<!------ JQuery ------->
<!-- <script type="text/javascript" src="//cdn.jsdelivr.net/jquery/1/jquery.min.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>-->
<!--  <script src="../assets/js/WebTV/player_homepage.js"></script>
<script src="../assets/js/dist/jplayer/jquery.jplayer.min.js">
</script>
<script src="../assets/js/dist/jplayer/jplayer.playlist.min.js"></script>-->
</head>
<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to get the
desired effect
|---------------------------------------------------------|
| SKINS         | skin-blue                               |
|               | skin-black                              |
|               | skin-purple                             |
|               | skin-yellow                             |
|               | skin-red                                |
|               | skin-green                              |
|---------------------------------------------------------|
|LAYOUT OPTIONS | fixed                                   |
|               | layout-boxed                            |
|               | layout-top-nav                          |
|               | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->
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
                <div id="table-programmation-page-principale"  style="overflow:auto;height:300px;">
                  <table id="table_programmation" class="table table-hover table-striped" >
                  </table>
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
                              <div class="jp-toggles">
                                <!--<button class="jp-repeat" role="button" tabindex="0">repeat</button>
                                <button class="jp-shuffle" role="button" tabindex="0">shuffle</button>-->
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
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Main Footer -->



    <!-- ./wrapper -->





    <!-- Bootstrap 3.3.6 -->

    <!----- PLayer video page principale  -->




    <!-- Optionally, you can add Slimscroll and FastClick plugins.
    Both of these plugins are recommended to enhance the
    user experience. Slimscroll is required when using the
    fixed layout. -->
  </div>

</body>
</html>
