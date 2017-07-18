
<!DOCTYPE html>
<html lang="fr">


  <head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <!-- Utile pour le calendrier -->
    <script src="http://cdn.alloyui.com/3.0.1/aui/aui-min.js"></script>
    <link href="http://cdn.alloyui.com/3.0.1/aui-css/css/bootstrap.min.css" rel="stylesheet"></link>
  </head>


  <body>
    <div class="row col-md-12 col-sm-12" >
      <div class="col-md-3 col-sm-5">
          <input type="checkbox" id="bouton_voir_cacher_programmation" checked data-toggle="toggle" data-onstyle="default"
          data-off="<i class='glyphicon glyphicon-download' style='color:#2C4CB3'></i> <i class='glyphicon glyphicon-calendar' style='color:#2C4CB3'></i> "
          data-on="<i class='glyphicon glyphicon-upload' style='color:#2C4CB3'></i> <i class='glyphicon glyphicon-calendar' style='color:#2C4CB3'></i> "/>
      </div>
    </div>
    <div class="row col-md-6 col-sm-6" id="planning_playlist" >

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
    </div>
  </body>
</html>
