JPlayer Podcast Player Wordpress Widget
=====

[![Build Status](https://travis-ci.org/ycfreeman/jplayer-podcast-wordpress-widget.svg?branch=master)](https://travis-ci.org/ycfreeman/jplayer-podcast-wordpress-widget)

Wordpress widget that use jPlayer to play Podcast RSS playlists

* [Plugin Page @ wordpress.org](https://wordpress.org/plugins/podcast-player-widget/)
* [Demo Site](http://demo.ycfreeman.com)

===
This is a [Wordpress](https://wordpress.org/) plugin that parses your podcast feed, generates a [jplayer](http://jplayer.org/) playlist, pump it to jplayer then show it on your Wordpress site as a widget. It uses [a PHP parser script](https://github.com/onigetoc/Podcast-parser-for-jPlayer) or jQuery to read your feed.

PHP mode requires your server to support file_get_contents() to external files, while jquery mode requires the feed to support [CORS](https://en.wikipedia.org/wiki/Cross-origin_resource_sharing)

The skin is from [these guys](https://github.com/lukemcdonald/jplayer-skin-premium-pixels) and i modified it slightly to get it work without normalize.css.

To check if your feed structure is supported, please check out the [parser's github page](https://github.com/onigetoc/Podcast-parser-for-jPlayer) , they have a [demo page](http://scripts.toolurl.com/audio/Podcast-parser-for-jPlayer/demo.html) there.

##Credits
* https://github.com/onigetoc/Podcast-parser-for-jPlayer
* http://jplayer.org/
* https://github.com/lukemcdonald/jplayer-skin-premium-pixels
