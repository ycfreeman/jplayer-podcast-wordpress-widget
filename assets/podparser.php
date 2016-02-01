<?php
//header('Access-Control-Allow-Origin: *');

$url = $_GET["url"];
$podCount = $_GET["count"] ?: 20;

	$pod->pod = @file_get_contents($url);

	$pod->pod = str_replace('itunes:', '', $pod->pod);
	$pod->pod = simplexml_load_string($pod->pod);

$main_poster = $pod->pod->channel->image['href'];
if(!$main_poster) 
$main_poster = $pod->pod->channel->image->url;

// get main chanel author
$main_author = $pod->pod->channel->author;

$items = $pod->pod->channel->item;


$i = 0;
$data = array();
foreach($items as $item) {  //loop over elements you want to return
	
	$datum = parse_url($item->enclosure['url']);
	$parts = pathinfo($datum['path']);
	$type = $parts['extension'];
	
	if($type=="mp4") $type = "m4v";
	if($type=="ogg") $type = "oga";
	//audio/mp3	
	
	//Get item poster
	$poster = $item->image['href'];
	if(!$poster) $poster = $main_poster;
	
	//Get item author
	$author = $item->author;
	if(!$author) $author = $main_author;

	$singleData = array(
		'title' => (string)$item->title,
		$type => (string)$item->enclosure['url'],//replace this with the XML elements you want to get
	);
	if (!empty($poster)) {
		$singleData['poster'] = (string)$poster;
	}
	if (!empty($author)) {
		$singleData['artist'] = (string)$author;
	}
	$data[] = $singleData;
	if ($podCount > 0){
		if ($i > -1 && ++$i == $podCount) break;// change this to the number of elements you want to get
	}
}

// Order by date help: http://stackoverflow.com/questions/20662389/is-there-a-way-to-sort-by-pubdate-in-descending-order

$jsdata = ($_GET['callback'].'('.json_encode($data).');');
echo htmlspecialchars($jsdata, ENT_NOQUOTES, 'utf-8'); // return JSON wrapped in callback
