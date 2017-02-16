
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


                    <?php 
                    include( MY_PLUGIN_PATH . 'templates/homepage/homepage.template.php');    
                    ?>

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
