
$.ajax({
    url: ajaxurl, 
    data:{
        'action':'recuperer_derniers_pourcentages_enregistrees',
    },
    dataType: 'JSON',
    success: function(data){

        
        console.log('test');
        console.log(data);


    },
    error: function (xhr, ajaxOptions, thrownError) {
        alert(xhr.status);
        alert(thrownError);
    }
}); 


//google.charts.load('current', {'packages':['corechart']});

// Set a callback to run when the Google Visualization API is loaded.
google.charts.setOnLoadCallback(drawChart1);
// Callback that creates and populates a data table,
// instantiates the pie chart, passes in the data and
// draws it.
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
    chart.draw(data, options);
}
