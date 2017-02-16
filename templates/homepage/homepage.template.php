

<div class="container-fluid">
 
    <div class="bootstrap-wpadmin">
    <div class="row">
        <div class="col-md-12">

            <h3 class="text-center">
                WEB TV LIVE - Le Fil
            </h3>
        </div>
        <div class="col-md-12" style="height:5%;"></div>
        <div class="col-md-6">

            <h3>
                ON AIR
            </h3>
            <div id="table-programmation-page-principale"  style="overflow:auto;height:300px;">
                <table id="table_programmation" class="table table-hover table-striped" >
       
                </table>
            </div>

        </div>
      
        <div class="col-md-4" style="margin-top:2%;">
            <div class="row">


                <div class="col-md-4" id="lecteur_video">
                    <div id="container_jplayer" class="jp-video jp-video-270p" role="application" aria-label="media player">
                        <div class="jp-type-playlist">
                            <div id="player_video" class="jp-jplayer"></div>
                            <div class="jp-gui">
                                <div class="jp-video-play">
                                    <button class="jp-video-play-icon" role="button" tabindex="0">play</button>
                                </div>
                                <div class="jp-interface">
                                    <div class="jp-progress">
                                        <div class="jp-seek-bar">
                                            <div class="jp-play-bar"></div>
                                        </div>
                                    </div>
                                   <!-- <div class="jp-current-time" role="timer" aria-label="time">&nbsp;</div>
                                    <div class="jp-duration" role="timer" aria-label="duration">&nbsp;</div>-->
                                    <div class="jp-controls-holder"style="height:35px;">
                                        <div class="jp-controls" >
                                            <button class="jp-previous" role="button" tabindex="0" style="display:none;">previous</button>
                                            <button class="jp-play" role="button" tabindex="0" style="display:none;">play</button>
                                            <button class="jp-next" role="button" tabindex="0" style="display:none;">next</button>
                                            <button class="jp-stop" role="button" tabindex="0" style="display:none;">stop</button>
                                        </div>
                                        <div class="jp-volume-controls">
                                            <button class="jp-mute" role="button" tabindex="0">mute</button>
                                            <button class="jp-volume-max" role="button" tabindex="0">max volume</button>
                                            <div class="jp-volume-bar">
                                                <div class="jp-volume-bar-value"></div>
                                            </div>
                                        </div>
                                         <div class="jp-toggles">
<!--<button class="jp-repeat" role="button" tabindex="0">repeat</button>
<button class="jp-shuffle" role="button" tabindex="0">shuffle</button>-->
<button class="jp-full-screen" role="button" tabindex="0">full screen</button>
</div>
                                    </div>
                                    <div class="jp-details">
                                        <div class="jp-title" aria-label="title">&nbsp;</div>
                                    </div>
                                </div>
                            </div>
                            <div class="jp-playlist" style="display:none;">
                                <ul>

                                    <li>&nbsp;</li>
                                </ul>
                            </div>
                            <!-- The method Playlist.displayPlaylist() uses this unordered list -->
                            <div class="jp-no-solution">
                                <span>Update Required</span>
                                To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
                            </div>
                        </div>
                    </div>
                </div>



            </div>

        </div>
      
      

    </div>
    
</div>
</div>
<style type="text/css">

    .jp-previous{
        display:none;
    }
</style>