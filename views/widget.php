<?php
global $swfPath;
global $podcastParserPath;

$url = $instance['url'];
$podcastCount = $instance['count'];
$autoPlay = $instance['autoplay'];
$corsenabled = $instance['corsenabled'];

?>

    <div id="jplayer_<?php echo $widgetId ?>" class="jp-jplayer"></div>

    <div id="jp_container_<?php echo $widgetId ?>" class="jp-audio" role="application" aria-label="media player">
        <div class="jp-interface">
            <div class="jp-button jp-playpause-button">
                <button class="jp-play" role="button" tabindex="0"></button>
            </div>
            <div class="jp-time-rail">
                <div class="jp-progress">
                    <div class="jp-seek-bar">
                        <div class="jp-play-bar"></div>
                    </div>
                </div>
            </div>
            <div class="jp-button jp-volume-button">
                <button class="jp-mute" role="button" tabindex="0"></button>
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
            To play the media you will need to either update your browser to a recent version or update your <a
                href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
        </div>
    </div><!-- .jp-audio -->
    <br/>

<?php
$scriptData = array(
    'jPlayer' => "#jplayer_$widgetId",
    'cssSelectorAncestor' => "#jp_container_$widgetId",
    'url' => $url,
    'podcastCount' => $podcastCount,
    'autoPlay' => $autoPlay ? true : false,
    'swfPath' => $swfPath,
    'podcastParserPath' => $podcastParserPath,
    'cors' => $corsenabled ? true : false
);

$instanceScriptHandle = $this->get_widget_slug() . '-script-' . $widgetId;

wp_register_script($instanceScriptHandle, plugins_url('../js/widget.js', __FILE__), array('jquery'));
wp_localize_script($instanceScriptHandle, 'data', $scriptData);
wp_enqueue_script($instanceScriptHandle);

