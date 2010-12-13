#!/usr/bin/php -q

<?php

$direction = $argv[1];

// Read input from stdin
$in = fopen('php://stdin', 'r');
$input = trim ( fgets( $in ) );

// Do the encoding/decoding
switch ($direction) {
	case "getname":
		$xml = simplexml_load_file("http://api.erepublik.com/v2/feeds/citizens/" . $input);
		foreach ($xml->children() as $child) {
		        if ($child->getName() == "name") {
		                fwrite( STDOUT,  $child );
		                break 2;
		        }
		}
		break;
	case "getid":
		$xml = simplexml_load_file("http://api.erepublik.com/v2/feeds/citizen_by_name/xml/" . $input );
		foreach ($xml->children() as $child) {
			if ($child->getName() == "id") {
				fwrite( STDOUT, $child );
				break 2;
			}
		}
		break;
	default:
		fwrite( STDERR, "Invalid request for API data." );
}

exit(0);

?>
