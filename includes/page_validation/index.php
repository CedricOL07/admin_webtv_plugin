<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Récapitulatif du réglage - WEBTVFIL
        </h1>

    </section>
    <!-- Main content -->
    <section class="content" style="margin-top:4%;margin-left:0;">

        <div class="row">

            <div class="col-md-12">

                <div class="col-md-7 col-md-offset-2">
                    <div id="chart_div2" ></div>
                </div>

            </div>
            <div class="col-md-7 col-md-offset-2" style="margin-top:1%;">

                <div id="titre_reglage_enregistre"><label><strong> Nom du réglage :</strong> </label> </div>

                <div  id="date_passage_div">

                    <label> <strong>Date de passage :</strong> </label>
                </div>


                <div  id="div_artiste_highlight">
                    <label><strong>Artiste mis en avant :</strong></label>

                </div>

                <div   id="div_publicites_internes">
                    <label><strong>Publicités internes :</strong></label>

                </div>
                <div id="div_publicites_externes">
                    <label><strong>Publicités externes :</strong></label>
                </div>


            </div>

        </div>
        <script type="text/javascript">
            $(document).ready(function(){


                var pourcentagepoprock;
                var pourcentagehiphop;
                var pourcentagejazz;
                var pourcentagemusiquemonde;
                var pourcentagehardrock;
                var pourcentageelectro;
                var pourcentageautres;
                var pourcentagechanson;
                //google.charts.load('current', {'packages':['corechart']});
                // Set a callback to run when the Google Visualization API is loaded.
                google.charts.setOnLoadCallback(drawChart1);
                function drawChart1() {

                    // Create the data table.
                    data = new google.visualization.DataTable();

                    data.addColumn('string', 'Topping');
                    data.addColumn('number', 'Slices');
                    data.addRows([
                        ['Pop-Rock', 20],
                        ['Hip-Hop & Reggae', 20],
                        ['Jazz & Blues', 20],
                        ['Musique du monde', 20],
                        ['Hard Rock & Métal', 20],
                        ['Musique électronique', 20],
                        ['chanson', 20],
                        ['autres', 20]


                    ]);


                    // Set chart options
                    options = {'title':'Repartition des genres dans la playlist',
                               'width':600,
                               'height':400,
                               is3D: true,
                               legend: {
                                   position: 'labeled',
                               },
                               backgroundColor: 'transparent'

                              };

                    // Instantiate and draw our chart, passing in some options.
                    chart = new google.visualization.PieChart(document.getElementById('chart_div2'));
                    chart.draw(data,options); 

                }
                refaire();
                function refaire(){

                    $.ajax({
                        url: ajaxurl, 
                        data:{
                            'action':'recuperer_derniers_pourcentages_enregistrees',
                        },
                        dataType: 'JSON',
                        success: function(response){

                            console.log(response);
                            $.each(response.data,function(key,value){

                                $('#titre_reglage_enregistre').append(value.nom);

                                $('#div_publicites_internes').append(value.publicites_internes);
                                $('#div_publicites_externes').append(value.publicites_externes);
                                $('#div_artiste_highlight').append(value.artiste_highlight);


                                $('#date_passage_div').append('Cette playlist passera du '+value.Debut+' au '+value.Fin);

                                data.removeRow(0);
                                data.insertRows(0, [['Pop-Rock', parseInt(value.pourcentage_poprock)]]);

                                data.removeRow(1);
                                data.insertRows(1, [['Hip-Hop & Reggae', parseInt(value.pourcentage_rap)]]);

                                data.removeRow(2);

                                data.insertRows(2, [['Jazz & Blues', parseInt(value.pourcentage_jazzblues)]]);

                                data.removeRow(3);
                                data.insertRows(3, [['Musique du monde',parseInt(value.pourcentage_musiquemonde)]]);
                                chart.draw(data,options); 
                                data.removeRow(4);
                                data.insertRows(4, [['Hard Rock & Métal', parseInt(value.pourcentage_hardrock)]]);

                                data.removeRow(5);
                                data.insertRows(5, [['Musique électronique', parseInt(value.pourcentage_electro)]]);

                                data.removeRow(6);
                                data.insertRows(6, [['chanson', parseInt(value.pourcentage_chanson)]]);

                                data.removeRow(7);
                                data.insertRows(7, [['autres', parseInt(value.pourcentage_autres)]]);
                                chart.draw(data,options); 

                            });
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            alert(xhr.status);
                            alert(thrownError);
                        }
                    });                               
                }

            });
        </script>
    </section>
    <!-- /.content -->
</div>