<?php

function apiFunctionality() {
	if (getFeed( "#772321" ) == false) {
		return false;
	} else {
		return true;
	}
}

function getFeed( $name ) {
	if (preg_match( '/^#[0-9]*/', $name )) {
		$isID = true;
		$url = "http://api.erepublik.com/v2/feeds/citizens/" . substr( $name, 1 ) . ".json";
	} else {
		$isID = false;
		$url = "http://api.erepublik.com/v2/feeds/citizen_by_name/json/" . $name;
	}
	
	$ch = curl_init( $url );
	$options = array(
		CURLOPT_RETURNTRANSFER => true,     // return web page
		CURLOPT_HEADER         => false,    // don't return headers
		CURLOPT_FOLLOWLOCATION => true,     // follow redirects
		CURLOPT_ENCODING       => "",       // handle all encodings
		CURLOPT_USERAGENT      => $_SERVER['HTTP_USER_AGENT'], // who am i
		CURLOPT_AUTOREFERER    => true,     // set referer on redirect
		CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
		CURLOPT_TIMEOUT        => 120,      // timeout on response
		CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
	);
	curl_setopt_array( $ch, $options );
	$result = curl_exec( $ch );
	$header = curl_getinfo( $ch );
	if (curl_errno( $ch ) != 0 || $header["http_code"] != 200 || $result == false) {
		curl_close( $ch );
		return false;
	} else {
		curl_close( $ch );
		return json_decode($result);
	}
}

function getInfo( $name, $info ) {
	$feed = getFeed( $name );
	return $feed->$info;
}

?>