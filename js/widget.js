(function (window, $, data, undefined) {
	'use strict';
	jQuery(function () {
		var player = new jPlayerPlaylist({
				jPlayer: data.jPlayer,
				cssSelectorAncestor: data.cssSelectorAncestor
			},
			loadPodcast(data.url, data.podcastCount),
			{
				playlistOptions: {autoPlay: data.autoPlay},
				swfPath: data.swfPath,
				supplied: "mp3,oga,m4a",
				solution: "flash, html",
				wmode: "window",
				useStateClassSkin: true,
				autoBlur: false
			}
		);

		// Call podparser php
		function loadPodcast(url, count) {
			$.getJSON(data.podcastParserPath + "?callback=?&url=" + url + "&count=" + count,
				{},
				function (playlist) {
					player.setPlaylist(playlist);
				});
		}

	});
})(window, jQuery, data);