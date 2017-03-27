            <html>
    <body>
        <div class="bootstrap-wpadmin">
        <div class="container">
            <div class="row col-md-12">
              
                    <div class="col-md-6"> 
                    <div class="box"><!------ Nom reglage ------>
                        <div class=" box-header with-border">
                            <h3 class="box-title"> Identification du réglage</h3>
                        </div>

                        <div id="nom_reglage">
                            Nom :  <input type="name" name="nom_reglage"  id="input_nom_reglage" >
                        </div>

                    </div><!------/ Nom reglage ------->
                </div>
                <div class="col-md-11"><!---- Couleur playlist --->  
                    <div class="col-md-12 col-sm-12 col-lg-12 box">
                        <div class=" box-header with-border">
                            <h3 class="box-title"> Couleur de la playlist</h3>
                        </div>


                        <div class="col-md-5 col-sm-5 " id="sliders_genres">
                            <label for="amount">Pop-Rock :</label>
                            <!--<input type="text" id="amount_pop_rock" readonly style="border:0; color:#3366cc; font-weight:bold;">-->
                            <div id="slider_pop_rock"></div>

                            <label for="amount">Hip-Hop et Rap</label>
                            <!-- <input type="text" id="amount_rap" readonly style="border:0; color:#dc3912; font-weight:bold;">-->

                            <div id="slider_hiphop"></div>


                            <label for="amount">Jazz et Blues :</label>
                            <!-- <input type="text" id="amount_jazz" readonly style="border:0; color:#ff9900; font-weight:bold;">-->

                            <div id="slider_jazz"></div>


                            <label for="amount">Musique du monde et Reggae</label>
                            <!--  <input type="text" id="amount_musiquemonde" readonly style="border:0; color:#109618; font-weight:bold;">-->

                            <div id="slider_musiquemonde"></div>

                            <label for="amount">Hard Rock et Métal</label>
                            <!-- <input type="text" id="amount_hardrock" readonly style="border:0; color:#990099; font-weight:bold;">-->

                            <div id="slider_hardrock"></div>

                            <label for="amount">Electro</label>
                            <!-- <input type="text" id="amount_electro" readonly style="border:0; color:#0099c6; font-weight:bold;">-->

                            <div id="slider_electro" ></div>
                            <label for="amount">Chanson</label>
                            <!-- <input type="text" id="amount_electro" readonly style="border:0; color:#0099c6; font-weight:bold;">-->

                            <div id="slider_chanson" ></div>
                            <label for="amount">Autres</label>
                            <!-- <input type="text" id="amount_electro" readonly style="border:0; color:#0099c6; font-weight:bold;">-->

                            <div id="slider_autres" ></div>

                        </div>
                        <div class="col-md-7 col-sm-7 " id="chart_div"></div>
                        <!--<input type="button" id="bouton" class="btn btn-default" value="valeurs_sliders">  -->  
                    </div>

                </div>    <!--- / Couleur playlist --->

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
                
                <div class="col-md-6 col-sm-6"id="partie_publicites" ><!---- Publicités ---->
                    <div class="col-md-12 col-sm-12 box" >

                        <div class=" box-header with-border">
                            <h3 class="box-title"> Publicités</h3>
                        </div>
                        <p></p>
                        <div class="col-md-12  col-sm-12" id="pub-box">

                            <div class="col-md-6 col-sm-6" id="select_pub_label"> Selectionner une pub : </div>
                            <!--<select id="pubs" name="pubs" >
<option value="sss">-- Choisir une pub--</option>
</select>-->
                            <div class="col-md-6 col-sm-6" id="pub_selector_box">
                                <select id="pubs-selector" multiple="multiple" >

                                </select>

                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-md-5 col-sm-5 " id="partie_highlight">
                    <div class="col-md-12 col-sm-12 box" id="highlights">  <!--------- Artiste en highlights debut ---------->
                        <div class=" box-header with-border">
                            <h3 class="box-title"> Mettre un artiste en highlights</h3>
                        </div>

                        <div for="tags" class="glyphicon glyphicon-search"> </div>
                        <select id="hightlight-selector"  >
                            <option value="default">-- Choisir un artiste  --</option>
                        </select>

                    </div><!---------/ Artiste en highlights fin ---------->
                </div>
                <div class="col-md-11 col-sm-11" id="partie_diffusion">
                    <div class="col-md-12 col-sm-12 box" id="diffusion">
                        <div class=" box-header with-border">
                            <h3 class="box-title"> Diffusion</h3>
                        </div>



                        <div  class="col-md-7 col-sm-7" >

                            <!--<label> Selectionner l'heure de passage de la playlist :</label>-->
                            <input type="button" id="bouton_choisir_date" value="Choisir la date" class="btn btn-primary display">
                            <div id="picker_choisir_date"> </div>
                            <div id="trigger_choisir_date" class="hidden">

                                <div id="datetimepicker">
                                    <label for="from">Debut</label>
                                    <input type="text" id="from" name="from">
                                    <label for="to">Fin</label>
                                    <input type="text" id="to" name="to">
                                    <input type="button" id="annuler_choisir_date" value="annuler" class="btn btn-primary">

                                </div>
                                <label id="label_warning_calendar" style="color:red;"></label>
                                <div id="calendrier_dates">  <input type="button" id="bouton_voir_programmation" value="Voir la programmation" class="btn btn-primary display" >  
                            </div>
                            </div>
                        </div>

                        <div class="col-md-5 col-sm-5">

                            <input type="button" id="bouton_voir_premiere_date_disponible" value="Passer la playlist dès que possible" class="btn btn-primary display"/>
                            <div id="trigger_premiere_date_dispo" class="hidden" >
                              <div id="text_prochain_passage"></div> <input type='button' class='btn btn-primary' id='annuler_date_dispo' value='Annuler' >

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
                            <a href="index.php" ><button type="button" class="btn btn-default" id="bouton_annuler_reglage">
                                Annuler
                                </button></a>
                            
                        </div>
                    </div><!------- / boutons ------->
                </div>
                <!----/ Publicités ---->
               
            </div>
        </div>
        </div>
    </body>
</html>