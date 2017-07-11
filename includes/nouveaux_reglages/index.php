<html>
    <head>
        <meta charset="utf-8">

        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <!-- Utile pour le calendrier -->
        <script src="http://cdn.alloyui.com/3.0.1/aui/aui-min.js"></script>
        <link href="http://cdn.alloyui.com/3.0.1/aui-css/css/bootstrap.min.css" rel="stylesheet"></link>
        <title>WEBTVFIL</title>
    </head>


    <!--Pour modifier les emplacements des boxes il y a des commentaires laissé dans le code notamement dans la partie publicité-->

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
                                </div>
                            </div>


                           <div class="row col-md-12" id = "colonne_sliders">

                                <div class="col-md-5">

                                    <!--  ************* Couleur playlist ****************-->

                                    <label for="amount">Pop Rock</label>
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

                                <div class="col-md-6 col-sm-6" id="chart_div" ></div>
                            </div>


                    <!--  Réglages avancés -->

                            <div class="row col-md-12">
                                <div class="col-md-11 col-sm-11 box">
                                    <div class=" box-header with-border">
                                        <h3 class="box-title"> Réglages avancés</h3>
                                    </div>

                                    <div class="col-md-12 col-sm-12" style="margin-top:10px" >
                                        <div id="datepicker" class="col-md-6 col-sm-6" >
                                            <input type="text" id="annee_min" name="annee_min" placeholder="Date minimale... " />
                                            <input type="text" id="annee_max" name="annee_max" placeholder="Date maximale... " />
                                        </div>

                                        <div class="col-md-3 col-sm-3">
                                            <label for="amount">Qualité minimale :</label>
                                        </div>
                                        <select name="qualite_min" id="qualite_min" class="col-md-1 col-sm-1">
                                          <option value="1">1</option>
                                          <option value="2">2</option>
                                          <option value="3">3</option>
                                          <option value="4">4</option>
                                          <option value="5">5</option>
                                        </select>
                                    </div>

                                    <div class="col-md-12 col-sm-12" style="margin-top:10px">
                                        <div class="col-md-offset-6 col-md-3 col-sm-3">
                                            <label for="amount">Lancer le logo tous les : </label>
                                        </div>
                                        <select name="freq_logo" id="freq_logo" class="col-md-1 col-sm-1">
                                            <option value="0">-jamais-</option>
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

                                        </select>
                                        <div class="col-md-1 col-sm-1">
                                            <label for="amount"> clips </label>
                                        </div>
                                    </div>
                                </div>
                            </div>


                    <!--  Choix playlist par défaut -->
                            <div class="row col-md-12">
                                <div class="col-md-11 col-sm-11 box">
                                    <div class=" box-header with-border">
                                        <h3 class="box-title"> Definir comme réglage par défaut</h3>
                                    </div>
                                    <div class="checkbox" style="padding-bottom:1%;padding-left:1%;">
                                        <label><input type="checkbox" name="checkbox_par_defaut" id="checkbox_par_defaut" value="">Faire de ce réglage le réglage par défaut</label>
                                    </div>
                                </div>
                            </div>


                    <div class="row col-md-12">
                    <!-- cette balise div englobe les balise publicité, mettre un artiste en higlight diffusion afin d'aligner les boxes verticalement.


                <!-- ************************Publicités *******************************-->

                    <!--Pour modifier l'emplacement des box(2,3,4) dans une box1 sous bootstrap il faut d'abord modifier la premiere box2 qui est dans la box1 afin de voir la place quelle prend et ainsi de suite (Exemple: modifier la box2 avec l'id="select_pub_label" avant de modifier la box3 avec l'id="pub_selector_box" qui sont toutes les deux dans la box1 .-->

                        <div class="col-md-11 col-sm-11 box" id="partie_publicites">

                            <div class=" box-header with-border">

                                <h3 class="box-title"> Publicités</h3>

                            </div>

                            <div class="col-md-12 col-sm-12" id="pub-box">

                                <div class="col-md-5 col-sm-5" id="select_pub_label">
                                    <div class="col-md-8 col-sm-8" id="select_pub_label">
                                        Sélectionner une pub externe :
                                    </div>
                                    <div class="col-md-4 col-sm-4" id="affichage_pubs_externes" style="font-style: italic">
                                    </div>
                                    <div class="col-md-12 col-sm-12" style="margin-top:10px">
                                        <input type="button" name="select_pubs_externes" id="select_pubs_externes" value="select">
                                        </input>
                                        <input type="button" name="supprimer_pubs_externes" id="supprimer_pubs_externes" value="supprimer">
                                        </input>
                                    </div>
                                </div>


                                <div class="col-md-2 col-sm-2" id="pub_selector_externe_box"  style="margin-top:10px">
                                    <select name="pubs_selector_externe"  id="pubs_selector_externe"  multiple size="5">
                                    </select>
                                </div>

                            </div>

                            <div class="col-md-12 col-sm-12" id="pub-box">

                                <div class="col-md-5 col-sm-5" id="select_pub_label">
                                    <div class="col-md-8 col-sm-8" id="select_pub_label">
                                        Sélectionner une pub interne :
                                    </div>
                                    <div class="col-md-4 col-sm-4" id="affichage_pubs_internes" style="font-style: italic">
                                    </div>
                                    <div class="col-md-12 col-sm-12" style="margin-top:10px">
                                        <input type="button" name="select_pubs_internes" id="select_pubs_internes" value="select">
                                        </input>
                                        <input type="button" name="supprimer_pubs_internes" id="supprimer_pubs_internes" value="supprimer">
                                        </input>
                                    </div>
                                </div>


                                <div class="col-md-2 col-sm-2" id="pub_selector_interne_box" style="margin-top:10px" >
                                    <select name="pubs_selector_interne"  id="pubs_selector_interne"  multiple size="5">
                                    </select>
                                </div>

                            </div>
                        </div>



                <!--****************** Artiste en highlights ************************-->



                        <div class="col-md-11 col-sm-11 box" id="partie_highlight">

                            <div class=" box-header with-border">
                                <h3 class="box-title"> Mettre un artiste en Highlight</h3>
                            </div>

                            <div class="col-md-12 col-sm-12" id="highlights">

                                <div class="col-md-5 col-sm-5" id="select_pub_label">
                                    <div class="col-md-8 col-sm-8" id="select_pub_label">
                                         Sélectionner un artiste highlight :
                                    </div>
                                    <div class="col-md-4 col-sm-4" id="affichage_artiste_higlight" name="affichage_highlight" style="font-style: italic">
                                    </div>
                                    <div class="col-md-12 col-sm-12" style="margin-top:10px">
                                        <input type="button" name="select_artiste_higlight" id="select_artiste_higlight" value="select">
                                        </input>
                                        <input type="button" name="supprimer_artistes_higlight" id="supprimer_artistes_higlight" value="supprimer">
                                        </input>
                                    </div>
                                </div>


                                <div class="col-md-2 col-sm-2" id="highlight_selector_interne_box" style="margin-top:10px" >
                                    <select name="classement_artistes_higlights"  id="classement_artistes_higlights"  size = "5">
                                    </select>
                                </div>

                            </div>

                        </div>

<!--***************** Diffusion ****************-->


                        <div class="col-md-11 col-sm-11 box" id="partie_diffusion">

                            <div id="diffusion">

                                <div class=" box-header with-border">

                                    <h3 class="box-title"> Diffusion</h3>

                                </div>

                                <div  class="row col-md-12 col-sm-12 box-header with-border" style="margin-top:10px; margin-bottom:10px" >

                                    <div id="picker_choisir_date">
                                    </div>
                                    <div id="trigger_choisir_date" class="hidden">
                                        <div id="datetimepicker">
                                            <div>Debut
                                            <input type="text" id="from" name="from"/></div>
                                            <div>Fin
                                            <input type="text" id="to" name="to"/></div>
                                            <!--<input type="button" id="confirmer_date" value="confirmer" class="btn btn-primary"/>-->
                                            <input type="button" id="annuler_choisir_date" value="annuler" class="btn btn-primary"/>
                                        </div>
                                        <label id="label_warning_calendar" style="color:red;">
                                        </label>
                                        <div>
                                            <input type="button" id="bouton_voir_programmation_partie_choix_date" value="Voir la programmation" class="btn btn-primary display" />
                                        </div>
                                        <div id="calendrier_dates_partie_choix_date">
                                        </div>
                                        <div>
                                            <input type="button" name="cacher" id="cacher_programmation_partie_choix_date" value="cacher" class="hidden">
                                        </div>
                                    </div>

                                    <!-- Boutons choisir date / passer dès que possible -->
                                    <div class="col-md-2 col-sm-2">
                                        <input type="button" id="bouton_choisir_date" value="Choisir la date" class="btn btn-primary display"/>
                                    </div>

                                    <div class="col-md-5 col-sm-5">
                                        <input type="button" id="bouton_voir_premiere_date_disponible" value="Passer la playlist dès que possible" class="btn btn-primary display"/>
                                        <div id="trigger_premiere_date_dispo" class="hidden" >
                                            <div id="text_prochain_passage"> </div>
                                            <input type='button' class='btn btn-primary' id='annuler_date_dispo' value='Annuler' />
                                        </div>
                                    </div>
                                </div>

                                <!-- Voir la programmation -->

                                <div  class="row col-md-12 col-sm-12 box-header with-border" style="margin-top:10px"  > 
                                    
                                    <!--
                                    <div class="col-md-2 col-sm-2" >
                                        <input type="button" id="bouton_voir_programmation" value="Voir la programmation" class="btn btn-primary display" />
                                    </div>
                                    
                                    <div id="calendrier_dates"> 
                                    </div>
                                    <div>
                                        <input type="button" name="cacher" id="cacher_programmation" value="cacher" class="hidden" >
                                    </div>
                                    -->
                                </div>
                            
                        </div>
                    </div>

                    <div class="row col-md-11 col-sm-11">

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

                        <!--
                        <div id="wrapper">
                            <div id="calendar"></div>
                        </div>
                        -->
                    </div>


                    <!-- ******Bouton enregistrer et annuler ***** -->

                    <div class="row col-md-6 col-sm-6 col-md-offset-8 col-sm-offset-8" id="boutons_div">
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
                                <div id="rafraichissement"></div>

                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
