<div id="dialog" title="Confirmation Requise" class="btn btn-primary">
    Êtes vous certain de vouloir faire ça ?
</div>


<div id="dialog_verifier_tous_supprimer" title="Suppression de tout le contenu" class="btn btn-primary">
    Êtes vous certain de vouloir faire ça ?
</div>

<!--
-
------------ Supprimer par artiste ----------------
-
-->



<div class="col-md-12">
    <h3>Supprimer les morceaux d'un artiste</h3>
</div>

<div class="col-md-5"  style="margin-top:4%;" >
    
    <label> Entrez le nom d'un artiste :</label>
    <input type="text" id="input_supprimer_artiste" >
</div>


<div class="col-md-7" style="margin-top:4%;">
    
    <input type="button" id="bouton_supprimer_tout_artiste" value="Supprimer morceaux de l'artiste" class="btn btn-primary">
   <!-- <input type="button" id="bouton_supprimer_un_morceau_artiste" value="Choisir le(s) morceau(x) à supprimer" class="btn btn-primary">-->
</div>
<div class="col-md-12 hidden" id="liste_titres_artiste">
    
    <select id="titres_boite"  multiple="multiple">
      
    </select>

</div>
<div class="col-md-12" id="div_liste_artistes">


    <div class="hidden" id="div_liste_artistes1">
        <div id="texte_liste_artist_avant"><span style="color:red;">L'artiste que vous avez entré n'est pas dans la base de donnée</span></div>

        <select id="liste_artistes" >
            <option value="default">-- Choisir un artiste  --</option>
        </select>
    </div>

</div>
<!--
-
-------------- Supprimer par nom ----------------
-
-->
<div class="col-md-12">
    <h3>Supprimer un morceau par titre :</h3>
</div>
<div class="col-md-5"  style="margin-top:4%;" >

    <label> Entrez le titre du morceau à supprimer :</label>
    <input type="text" id="input_supprimer_morceau">
</div>
<div class="col-md-7" style="margin-top:4%;">    <input type="button" id="bouton_supprimer_morceau" value="Supprimer le morceau" class="btn btn-primary"></div>

<div class="col-md-12">
    <h3>Vider la base de vidéos :</h3>
</div>
<div class="col-md-5"><input type="button" class="btn btn-primary" id="bouton_tout_supprimer" value="Tout Supprimer"></div>

<style type="text/css">
    
    
    #input_supprimer_artiste{
        width:250px;
    }
    .hidden{
        display:none;
    }
    .ui-autocomplete {
        max-height: 200px;
        overflow-y: auto;
        /* prevent horizontal scrollbar */
        overflow-x: hidden;
    }
    /* IE 6 doesn't support max-height
    * we use height instead, but this forces the menu to always be this tall
    */
    * html .ui-autocomplete {
        height: 200px;
    }

</style>