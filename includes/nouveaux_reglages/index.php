<html>
    <head>
        <meta charset="utf-8">
        
        <title>WEBTVFIL</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
 
    </head>
<?php 
    
    do_action('pluginwebtv_eliminer_anciennes_playlists');
    ?>
    <body class="hold-transition skin-black sidebar-mini">

        <div class="wrapper">
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Nouveaux Réglages - WEBTVFIL
                        <!--<small>Optional description</small>-->
                    </h1>
                  
                </section>

                <!-- Main content -->
                <section class="content">


                    <?php include( MY_PLUGIN_PATH . 'templates/nouveaux_reglages/nouveaux_reglages.template.php');?>

                </section>
                <!-- /.content -->
            </div>

        </div>
     
    </body>
</html>
