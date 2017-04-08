$(document).ready(function(){


    /*
*---------------------------------------------  INSERTION DE CONTENU   --------------------------------------------
*/

    $.ajax({
        url: ajaxurl,
        data:{
            'action':'recup_qualite_gestionbdd_pluginwebtv',
        },
        dataType: 'JSON',
        success: function(data){
          //  console.log(data);
            $.each(data.data,function(key,value){

              //  $('#qualite').append('<option value="'+ value.valeur+'">'+ value.valeur +'</option>');
            });
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
        }
    });


    // Requete wordpress
    $.ajax({
        url: ajaxurl,
        data:{
            'action':'recup_genres_gestionbdd_pluginwebtv',
        },
        dataType: 'JSON',
        success: function(data){
            $.each(data.data,function(key,value){
                if(value.Genre !=''){
                    $('#genres').append('<option value="'+ value.Genre+'">'+ value.Genre +'</option>');
                    $('#genres_recuperer').append('<option value="'+ value.Genre+'">'+ value.Genre +'</option>');
                }
            });
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
        }
    });

    $('#bouton_inserer_contenu').click(function(){

        var titre=$('#input_titre_inserer').val();
        var url_video=$('#input_url_inserer').val();
        var artiste_video=$('#input_artiste_inserer').val();

        var genres=$('#genres').val();
        var album=$('#input_album').val();
        var annee=$('#input_annee').val();
        var qualite=$('#qualite').val();
        console.log(genres);
        console.log('test');
      if(titre != '' && url_video != '' && artiste_video != '' && genres != ''){
          $.post(
              ajaxurl,
              {
                  'action':'inserer_contenu_pluginwebtv',
                  'genre':genres,
                  'titre':titre,
                  'url_video':url_video,
                  'artiste_video':artiste_video,
                  'album':album,
                  'annee':annee,
                  'qualite':qualite
              },
              function(response){
                  $('#tableau_morceaux_par_genre').html('');
                  $('#div_tableau_morceaux_par_genre').addClass('tableaux_morceaux_par_genre_css');
                  $('#tableau_morceaux_par_genre').append('<thead><tr><th>Titre</th><th>Artiste</th><th>Album</th><th>Url</th><th>Annee</th></tr></thead>');
                  $.each(response.data,function(key,value){

                      $('#tableau_morceaux_par_genre').append('<tbody><tr><td>'+value.titre+'</td><td>'+value.artiste+'</td><td>'+value.album+'</td><td>'+value.url+'</td><td>'+value.annee+'</td></tr></tbody>');
                  });

              }
          );
      }else{
          if(titre == ''){
              $('#warning-insertion').append('<strong><span style="color:red;">Vous n\'avez pas entré de titre, veuillez en entrer un</span></strong>');
          }else{
              if(url_video== ''){
                  $('#warning-insertion').append('<strong><span style="color:red;">Vous n\'avez pas entré d\'url pour la vidéo, veuillez en entrer une</span></strong>');
              }else{
                  if(artiste_video == ''){
                      $('#warning-insertion').append('<strong><span style="color:red;">Vous n\'avez pas entré d\'artiste pour la vidéo, veuillez en entrer un</span></strong>');
                  }else{
                      if(genres == ''){
                          $('#warning-insertion').append('<strong><span style="color:red;">Vous n\'avez pas sélectionné de genres pour la vidéo, veuillez en entrer un</span></strong>');
                      }
                  }
              }
          }
      }
       /**/


    });







    /*
*---------------------------------------------  RECUPERER DU CONTENU  --------------------------------------------
*/
/*

    //Recuperer par genre
    $('#bouton_recuperer_par_genre').click(function(){

        var genre_recup=$('#genres_recuperer').val();

        $.post(
            ajaxurl,
            {
                'action':'get_song_by_genre_gestionbdd_pluginwebtv',
                'genre':genre_recup
            },
            function(response){
                $('#tableau_morceaux_par_genre').html('');
                $('#div_tableau_morceaux_par_genre').addClass('tableaux_morceaux_par_genre_css');
                $('#tableau_morceaux_par_genre').append('<thead><tr><th>Titre</th><th>Artiste</th><th>Album</th><th>Url</th><th>Annee</th></tr></thead>');
                $.each(response.data,function(key,value){

                    $('#tableau_morceaux_par_genre').append('<tbody><tr><td>'+value.titre+'</td><td>'+value.artiste+'</td><td>'+value.album+'</td><td>'+value.url+'</td><td>'+value.annee+'</td></tr></tbody>');
                });

            }
        );
    });

    $('#bouton-recuperer-par_artiste').click(function(){

        var artiste_recup=$('#input_contenu_artiste').val();

        $.post(
            ajaxurl,
            {
                'action':'get_song_by_artiste_gestionbdd_pluginwebtv',
                'artiste':artiste_recup

            },
            function(response){

                if(response.data=='artiste_pas_dans_bdd'){
                    $('#div_tableau_morceaux_par_artiste').append('<div style="color:red;"><h5>L\'artiste n\'est pas enregistré dans la base de donnée</h5></div>');
                }else{

                    if(response.data.length>0){
                        $('#tableau_morceaux_par_artiste').html('');
                        $('#div_tableau_morceaux_par_artiste').addClass('tableau_morceaux_par_artiste_css');
                        $('#tableau_morceaux_par_artiste').append('<thead><tr><th>Titre</th><th>Artiste</th><th>Album</th><th>Url</th><th>Annee</th></tr></thead>');
                        $.each(response.data,function(key,value){

                            $('#tableau_morceaux_par_artiste').append('<tbody><tr><td>'+value.titre+'</td><td>'+value.artiste+'</td><td>'+value.album+'</td><td>'+value.url+'</td><td>'+value.annee+'</td></tr></tbody>');
                        });
                    }else{
                        if(response.data.length==0){
                            $('#div_tableau_morceaux_par_artiste').append('<div style="color:red;"><h5>L\'artiste n\'a aucun morceau enregistré dans la base de donnée</h5></div>');
                        }
                    }
                }
                //Afficher resultat (tableau associatif) dans un <table> ou similaire
            }
        );

    });



    /*
*---------------------------------------------  SUPPRESSION DE CONTENU   ---------------------------------------------------
*/

/*

    $("#dialog_verifier_tous_supprimer").dialog({
        autoOpen: false,
        modal: true
    });

    /***********************  TOUT SUPPRIMER ********************/
/*

    $('#bouton_tout_supprimer').click(function(){


        $("#dialog").dialog({
            buttons : {
                "Confirmer" : function() {

                    $.ajax({
                        url: ajaxurl,
                        data:{
                            'action':'supprimer_toutes_videos',
                        },
                        dataType: 'JSON',
                        success: function(response){
                            $(this).dialog("close");
                        },
                        error: function (xhr, ajaxOptions, thrownError) {

                        }
                    });

                },
                "Annuler" : function() {
                    $(this).dialog("close");
                }
            }
        });

        $("#dialog").dialog("open");



    });





    /***********************  INPUT RECHERCHE ARTISTE ********************/
    var liste_artistes_bdd=[];

    $.ajax({
        url: ajaxurl,
        data:{
            'action':'recup_artistes_gestionbdd_pluginwebtv',
        },
        dataType: 'JSON',
        success: function(response){
            $.each(response.data,function(key,value){

                liste_artistes_bdd.push(value.nom);

            });
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
        }
    });

    $('#input_supprimer_artiste').autocomplete({
        source : liste_artistes_bdd
    });

    /***********************  INPUT RECHERCHE TITRE ********************/
    var liste_titres_bdd=[];

    $.ajax({
        url: ajaxurl,
        data:{
            'action':'recup_titres_gestionbdd_pluginwebtv',
        },
        dataType: 'JSON',
        success: function(response){
            $.each(response.data,function(key,value){

                liste_titres_bdd.push(value.titre);

            });
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
        }
    });

    $('#input_supprimer_morceau').autocomplete({
        source : liste_titres_bdd
    });




    /**************************** Boutons ********************************/
/*
    $("#dialog").dialog({
        autoOpen: false,
        modal: true
    });





    $('#bouton_supprimer_tout_artiste').click(function(){

        var artiste_a_supprimer=$('#input_supprimer_artiste').val();

        $.post(
            ajaxurl,
            {
                'action': 'get_song_by_artiste_gestionbdd_pluginwebtv',
                'artiste':artiste_a_supprimer,
            },
            function(response){
                console.log(response);
                if(response.data=='artiste_pas_dans_bdd'){
                    $('#div_liste_artistes1').toggleClass('hidden display');
                }else{
                    var targetUrl = $(this).attr("href");
                    //On supprimme tous les morceaux de la base de donnée
                    $("#dialog").dialog({
                        buttons : {
                            "Confirmer" : function() {

                                //On supprime tous les morceaux de l'artiste
                            $.ajax({
                                url: ajaxurl,
                                data:{
                                    'action':'supprimer_tous_les_morceaux_artiste_gestionbdd_pluginwebtv',
                                    'artiste':artiste_a_supprimer,
                                },
                                dataType: 'JSON',
                                success: function(data){
                                    $(this).dialog("close");
                                },
                                error: function (xhr, ajaxOptions, thrownError) {
                                  //  alert(xhr.status);
                                //    alert(thrownError);
                                    $(this).dialog("close");
                                }
                            });
                            },
                            "Annuler" : function() {
                                $(this).dialog("close");
                            }
                        }
                    });

                    $("#dialog").dialog("open");


                }
            }
        );



    });


  /*
    $('#titres_boite').multiselect({
        enableFiltering: true,
        nonSelectedText: 'Choisir une ou plusieurs publicites',
    });




    $('#bouton_supprimer_un_morceau_artiste').click(function(){


        var artiste_a_supprimer=$('#input_supprimer_artiste').val();

        $.post(
            ajaxurl,
            {
                'action': 'get_song_by_artiste_gestionbdd_pluginwebtv',
                'artiste':artiste_a_supprimer,
            },
            function(response){

                if(response.data=='artiste_pas_dans_bdd'){
                    $('#div_liste_artistes1').toggleClass('hidden display');
                }else{






                }
            }
        );



    });*/



    /*  $('#bouton_supprimer_un_morceau_artiste').click(function(){


        $.ajax({
            url: ajaxurl,
            data:{
                'action':'get_song_by_name_gestionbdd_pluginwebtv,
            },
            dataType: 'JSON',
            success: function(data){
                console.log(data);
                $.each(data.data,function(key,value){

                    $('#qualite').append('<option value="'+ value.valeur+'">'+ value.valeur +'</option>');
                });
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
            }
        });

    });*/


/*
*
*
***************************************    Bouton supprimer morceau *********************
*
*/
/*

    $('#bouton_supprimer_morceau').click(function(){

        var titre=$('#input_supprimer_morceau').val();

        $("#dialog").dialog({
            buttons : {
                "Confirmer" : function() {

                    $.post(
                        ajaxurl,
                        {
                            'action': 'supprimer_morceau_from_bdd_gestionbdd_pluginwebtv',
                            'titre':titre,
                        },
                        function(response){
                            $(this).dialog("close");
                        }
                    );

                },
                "Annuler" : function() {
                    $(this).dialog("close");
                }
            }
        });

        $("#dialog").dialog("open");






    });*/



});
