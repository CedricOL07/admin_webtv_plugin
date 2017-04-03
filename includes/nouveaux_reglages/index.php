<html>
    <head>
        <meta charset="utf-8">
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <title>WEBTVFIL</title>

        <!--<style type="text/css">
            div {
                border : red 2px solid;
            }


        </style>-->
    </head>
    


        <?php 
        do_action('pluginwebtv_eliminer_anciennes_playlists');
        ?>



    <body class="hold-transition skin-black sidebar-mini">

        <div class="container">
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

                        <div class="bootstrap-wpadmin">
        
                            <div class="row col-md-12">
                            <!-- Une seule ligne (row) pour tout l'affichage qui permet d'aligner toutes les boxes blanches -->
    
                                <!--*************** Nom reglage *****************-->
                                <div class="col-md-6"> 
                                    <div class="box">
                                        <div class=" box-header with-border">
                                            <h3 class="box-title"> Identification du réglage</h3>
                                        </div>

                                        <div id="nom_reglage">
                                            Nom :  <input type="name" name="nom_reglage"  id="input_nom_reglage" >
                                        </div>

                                    </div>

                                
                                    <!--  ************* Couleur playlist ****************-->
        
                                    <div id="slider_pop_rock"></div>

                                    <label for="amount">Hip-Hop et Rap</label>
                                    

                                    <div id="slider_hiphop"></div>


                                    <label for="amount">Jazz et Blues :</label>
                                    

                                    <div id="slider_jazz"></div>


                                    <label for="amount">Musique du monde et Reggae</label>
                                    

                                    <div id="slider_musiquemonde"></div>

                                    <label for="amount">Hard Rock et Métal</label>
                                    

                                    <div id="slider_hardrock"></div>

                                    <label for="amount">Electro</label>
                                    

                                    <div id="slider_electro" ></div>
                                    <label for="amount">Chanson</label>
                                    

                                    <div id="slider_chanson" ></div>
                                    <label for="amount">Autres</label>
                                    

                                    <div id="slider_autres" ></div>

                                </div>
                                <div class="col-md-7 col-sm-7 " id="chart_div">
                                </div>

                   

                    <!--  Choix playlist par défaut -->
                        <div class="col-md-11 col-sm-11">
                            <div class="box">
                                <div class=" box-header with-border">
                                    <h3 class="box-title"> Definir comme réglage par défaut</h3>
                                </div>
                                <div class="checkbox" style="padding-bottom:1%;padding-left:1%;">
                                    <label><input type="checkbox" name="checkbox_par_defaut" id="checkbox_par_defaut" value="">Faire de ce réglage le réglage par défaut</label>
                                </div>
                            </div>
                        </div>


                    <div class="col-md-12 col-sm-12 " >
                    <!-- cette balise div englobe les balise publicité, mettre un artiste en higlight diffusion afin d'aligner les boxes verticalement.


                <!-- ************************Publicités *******************************-->
                    

                        <div class="col-md-11 col-sm-11 box" id="partie_publicites">

                            <div class=" box-header with-border">
                                
                                <h3 class="box-title"> Publicités</h3>

                            </div>

                            <div class="col-md-6 col-sm-6" id="pub-box">

                                <div class="col-md-4 col-sm-4" id="select_pub_label"> 

                                Selectionner une pub : 

                                </div>
                  
                                <div class="col-md-6 col-sm-6" id="pub_selector_box">

                                    <select id="pubs-selector" >
                                        <option value="default">-- Choisir une pub  --</option>

                                    </select>

                                </div>
                            </div>

                        </div>



                <!--****************** Artiste en highlights ************************-->


                        
                        <div class="col-md-11 col-sm-11 box" id="partie_highlight">
                            <div id="highlights">  


                                <div class=" box-header with-border">
                                    
                                    <h3 class="box-title"> Mettre un artiste en highlights</h3>
                                
                                </div>

                                <div for="tags" class="glyphicon glyphicon-search">

                                </div>

                                <select id="hightlight-selector" multiple="multiselect">

                                    <option value="default">-- Choisir un artiste  --</option>
                                    <option value="value.nom">bob</option>
                                </select>

                            </div>
                        </div>


                    <!--***************** Diffusion ****************-->


                        <div class="col-md-11 col-sm-11 box" id="partie_diffusion">

                            <div id="diffusion">

                                <div class=" box-header with-border">

                                    <h3 class="box-title"> Diffusion</h3>
                                
                                </div>

                                <div  class="col-md-7 col-sm-7" >

                                    <input type="button" id="bouton_choisir_date" value="Choisir la date" class="btn btn-primary display"/>

                                    <div id="picker_choisir_date">
                                    </div>

                                    <div id="trigger_choisir_date" class="hidden">

                                        <div id="datetimepicker">

                                            <label for="from">Debut</label>
                                            <input type="text" id="from" name="from"/>
                                            <label for="to">Fin</label>
                                            <input type="text" id="to" name="to"/>
                                            <input type="button" id="annuler_choisir_date" value="annuler" class="btn btn-primary"/>

                                        </div>

                                        <label id="label_warning_calendar" style="color:red;">
                                        </label>

                                        <div id="calendrier_dates">

                                        <input type="button" id="bouton_voir_programmation" value="Voir la programmation" class="btn btn-primary display" />  

                                        </div>
                                    </div>
                                </div>

                            <div class="col-md-5 col-sm-5">

                                <input type="button" id="bouton_voir_premiere_date_disponible" value="Passer la playlist dès que possible" class="btn btn-primary display"/>

                                <div id="trigger_premiere_date_dispo" class="hidden" >

                                    <div id="text_prochain_passage">
                                    </div>

                                    <input type='button' class='btn btn-primary' id='annuler_date_dispo' value='Annuler' />

                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="col-md-6 col-sm-6 col-md-offset-8 col-sm-offset-8" id="boutons_div">
                        <div  class="col-md-12 col-sm-12 " id="boutons"> <!----- boutons ----->
                            <div >
                               <!-- <a href="<?php //echo admin_url('admin.php?page=pagevalidation');?>">-->
                            <button type="button" class="btn btn-default" id="bouton_enregistrer_reglage" >
                                    Enregistrer
                            </button>

                            <a href="index.php" >

                                <button type="button" class="btn btn-default" id="bouton_annuler_reglage">
                                        Annuler
                                </button>

                            </a>   
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
