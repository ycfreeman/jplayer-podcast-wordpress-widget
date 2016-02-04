(function (window, $, data, undefined) {
    'use strict';

    var fileExtension = function (url) {
        return url.split('.').pop().split(/\#|\?/)[0];
    };

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
        if (!data.cors) {
            // if file_get_contents works
            $.getJSON(data.podcastParserPath + "?callback=?&url=" + url + "&count=" + count,
                {},
                function (playlist) {
                    player.setPlaylist(playlist);
                });

        }else{
            // use jquery to parse
            $.get(url, function (data) {
                var $xml     = $(data);
                var playlist = [];
                $xml.find("item").each(function () {
                    var $this = $(this),
                        item  = {
                            title: $this.find("title").text(),
                            link: $this.find("link").text(),
                            enclosure: $this.find("enclosure").attr('url'),
                            description: $this.find("description").text(),
                            pubDate: $this.find("pubDate").text(),
                            author: $this.find("author").text()
                        };

                    var podcastItem                            = {
                        title: item.title
                    };
                    podcastItem[fileExtension(item.enclosure)] = item.enclosure;

                    playlist.push(podcastItem);

                });
                player.setPlaylist(playlist);
            })
        }




    }

})(window, jQuery, data);