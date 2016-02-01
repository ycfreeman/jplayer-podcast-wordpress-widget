<?php
global $swfPath;
global $podcastParserPath;

$url =  $instance['url'];
$podcastCount = $instance['count'];
$autoPlay = $instance['autoplay'];

?>


<div id="jplayer_<?php echo $widgetId ?>" class="jp-jplayer"></div>

<div id="jp_container_<?php echo $widgetId ?>" class="jp-audio" role="application" aria-label="media player">
    <div class="jp-interface">
        <div class="jp-button jp-playpause-button">
            <button class="jp-play" role="button" tabindex="0">play</button>
        </div>
        <div class="jp-time-rail">
            <div class="jp-progress">
                <div class="jp-seek-bar">
                    <div class="jp-play-bar"></div>
                </div>
            </div>
        </div>
        <div class="jp-button jp-volume-button">
            <button class="jp-mute" role="button" tabindex="0">max volume</button>
        </div>
        <div class="jp-volume-bar">
            <div class="jp-volume-bar-value"></div>
        </div>
    </div>
    <div class="jp-playlist">
        <ul>
            <li>&nbsp;</li>
        </ul>
    </div>
    <div class="jp-no-solution">
        <span>Update Required</span>
        To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
    </div>
</div><!-- .jp-audio -->

<script>


    (function (window, $, undefined) {
        'use strict';
        jQuery(function() {
            var player = new jPlayerPlaylist({
                    jPlayer: '#jplayer_<?php echo $widgetId ?>',
                    cssSelectorAncestor: '#jp_container_<?php echo $widgetId ?>'
                },
                loadPodcast("<?php echo $url?>", <?php echo $podcastCount;?>),
                {
                    playlistOptions: {autoPlay: <?php echo $autoPlay? 'true':'false'?>},
                    swfPath: "<?php echo $swfPath?>",
                    supplied: "mp3,oga,m4a",
                    solution: "flash, html",
                    wmode: "window",
                    useStateClassSkin: true,
                    autoBlur: false
                }
            );

            // Call podparser php
            function loadPodcast(url, count) {
                $.getJSON("<?php echo $podcastParserPath;?>?callback=?&url="+url+"&count="+count, {},function (playlist){
                    console.log(playlist);
                    player.setPlaylist(playlist);
                });
            }

        });




    })(window, jQuery);

</script>