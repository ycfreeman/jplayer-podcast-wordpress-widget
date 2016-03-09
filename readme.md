JPlayer Podcast Player Wordpress Widget   [![Build Status](https://travis-ci.org/ycfreeman/jplayer-podcast-wordpress-widget.svg?branch=master)](https://travis-ci.org/ycfreeman/jplayer-podcast-wordpress-widget)
===

Wordpress widget that use jPlayer to play Podcast RSS playlists

* [Plugin Page @ wordpress.org](https://wordpress.org/plugins/podcast-player-widget/)

##Description
This plugin parses your podcast feed and generates jplayer playlist, then pump it to jplayer. It uses [a php script by this guy](https://github.com/onigetoc/Podcast-parser-for-jPlayer) or jquery to read your feed. PHP mode requires your server to support file_get_contents, while jquery mode requires the feed side to support [CORS](https://en.wikipedia.org/wiki/Cross-origin_resource_sharing)
The skin is from [these guys](https://github.com/lukemcdonald/jplayer-skin-premium-pixels) and i modified it slightly to get it work without normalize.css.

To check if your feed structure is supported, please check out the [parser's github page](https://github.com/onigetoc/Podcast-parser-for-jPlayer) , they have a [demo page](http://scripts.toolurl.com/audio/Podcast-parser-for-jPlayer/demo.html) there.

##Credits
* https://github.com/onigetoc/Podcast-parser-for-jPlayer
* http://jplayer.org/
* https://github.com/lukemcdonald/jplayer-skin-premium-pixels
