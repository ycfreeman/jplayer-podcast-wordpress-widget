=== JPlayer Podcast Widget ===

Contributors: ycfreeman
Donate link: http://ycfreeman.com
Tags: podcast, jplayer, music player, audio
Requires at least: 3.3.1
Tested up to: 4.4.1
Stable tag: 1.0.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Widget that use jPlayer to play Podcast RSS playlists

== Description ==

Widget that use jPlayer to play Podcast RSS playlists

* [Issue Tracker](https://github.com/ycfreeman/jplayer-podcast-wordpress-widget/issues)
* [Source Code](https://github.com/ycfreeman/jplayer-podcast-wordpress-widget)

== Installation ==

1. Install plugin using Wordpress Plugin page
1. Drag **jPlayer (Podcast)** to your sidebar
1. Enter RSS Feed of your podcast
1. Save and Profit!

== Frequently Asked Questions ==
1. What is this [CORS](https://en.wikipedia.org/wiki/Cross-origin_resource_sharing) option about?
-- CORS mode uses jQuery to parse the feed directly, where not all feed servers would allow that
 while the other one uses PHP to parse the script to javascript then read from it, apparently some website
 hosting doesn't allow you to do this.
-- in short, simply use the one that works for your feed and your website.
1. So which mode is better?
-- Keep the option unchecked (PHP parser mode) is better, since the PHP parser is more feature packed
1. What about feature XXX?
-- If you like this plugin and would like to improve it, please fork the project or suggest in
[Issue Tracker](https://github.com/ycfreeman/jplayer-podcast-wordpress-widget/issues)

== Screenshots ==

== Changelog ==

= 1.0.0 =
first public release

== Upgrade Notice ==

