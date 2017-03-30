
<style type="text/css">
    .tableaux_morceaux_par_genre_css,
    .tableau_morceaux_par_artiste_css{
        height:400px;
    }
    #div_tableau_morceaux_par_genre{
        margin-bottom:2%;
    }
   

</style>


<div class="col-md-12">
    <h3>Recuperer par genre</h3>
<select id="genres_recuperer">
    <option value="0"> ---- Genres -------</option>

</select>

</div>
<div class="col-md-12" style="margin-top:2%;margin-bottom:4%;">

<input type="button" class="btn btn-primary" id="bouton_recuperer_par_genre" value="Voir morceaux dans ce genre">
</div>
<div class="col-md-8" style="overflow:auto;" id="div_tableau_morceaux_par_genre">
    <table id="tableau_morceaux_par_genre" style="border:black 1px solid;">
    
    
    
    </table>


</div>

<div class="col-md-12">

    <h3>Recuperer par artiste</h3>
    <p>Entrez le nom d'un artiste dont vous voulez voir les morceaux de la base de donnée</p>
    <input type="text" name="input_contenu_artiste" id="input_contenu_artiste">

    <input type="button" class="btn btn-primary" id="bouton-recuperer-par_artiste" value="Voir videos de cet artiste">

  
</div>
<div class="col-md-8" id="div_tableau_morceaux_par_artiste">

    <table id="tableau_morceaux_par_artiste" style="border:black 1px solid;">



    </table>

</div>