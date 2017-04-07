<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Bootstrap Case</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
        <script type="text/javascript" src="<?php echo plugins_url('admin_webtv_plugin/assets/js/dist/bootstrap-multiselect.js');?>"></script>
        <link rel="stylesheet" href="<?php echo plugins_url('admin_webtv_plugin/assets/css/bootstrap-multiselect.css');?>" type="text/css"/>



    </head>
    <style type="text/css">
        body{
            background:none;
        }
    </style>
    <body>

        <div class="container">
            <h2>Gestion du contenu</h2>
            <!--0<ul class="nav nav-tabs">
                <!--<li class="active"><a href="#home">General</a></li>-->
                <!--<li class="active"><a href="#menu1" >Insérer du contenu</a></li>
                <li><a href="#menu2">Récupérer du contenu</a></li>
                <li><a href="#menu3">Supprimer du contenu</a></li>
                <li><a href="#menu4">Supprimer un réglage enregistré</a></li>
            </ul>-->

            <div class="tab-content">
               <!-- <div id="home" class="tab-pane fade in active">
                    <h3>general</h3>
                    <?php //include( MY_PLUGIN_PATH . 'templates/gestionbdd/general_view.template.php');?>
                </div>-->

                    <?php include( MY_PLUGIN_PATH . 'includes/GestionBDD/ajouter_video/ajouter_video.html');?>



                <!--<div id="menu3" class="tab-pane fade">-->
                    <?php include( MY_PLUGIN_PATH . 'includes/GestionBDD/tableau_clips_videos/tableau_clips_videos_template.php');?>

                <!--</div>-->

                <!-- <div id="menu4" class="tab-pane fade">-->

                    <?php include( MY_PLUGIN_PATH . 'includes/GestionBDD/tableau_playlists_videos/tableau_playlists_videos.html');?>

                <!--</div>-->


            </div>

        </div>

        <script>
            $(document).ready(function(){
                $(".nav-tabs a").click(function(){
                    $(this).tab('show');
                });
            });
        </script>

    </body>
</html>
