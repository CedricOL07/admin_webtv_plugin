<h3>Insérer du contenu</h3>
<p><label>Entrez les informations relatives au clip pour l'insérer dans la base de donnee</label></p>

<div class="col-md-12" id="warning-insertion"></div>
<p> <label> Titre du clip :</label>
    <input type="text" name="input_titre" id="input_titre_inserer"></p>
<p> <label> Url de la video :</label>
    <input type="text" name="input_url" id="input_url_inserer"></p>
<p> <label> Artiste :</label>
    <input type="text" name="input_artiste" id="input_artiste_inserer">
    <label>(plusieurs possibles mais séparés par des virgules)</label>
</p>
<p>  <label> Genre :</label>
    <select id="genres" name="genres">
        <option value="">-- Genres--</option>
    </select></p>

<p> <label> Album :</label>
    <input type="text" name="input_album"></p>
<p>   <label> Annee de production :</label>
    <input type="text" name="input_annee"></p>
<p>  <label> Qualite du clip :</label>
    <select id="qualite" name="qualite">
        <option value="">-- Qualite--</option>
    </select>
    <label> (comprise entre 1 et 5)</label>
</p>
<p>

    <input type="button" class="btn btn-primary" id="bouton_inserer_contenu" value="Inserer">
</p>
