#!/usr/bin/php -q

<?php

$direction = $argv[1];

// Read input from stdin
$in = fopen('php://stdin', 'r');
while (!feof( $in )) {
	$input = $input . fgets( $in );
}

// Do the encoding/decoding
switch ($direction) {
	case "encode":
		fwrite( STDOUT, urlencode( $input ) );
		break;
	case "decode":
		fwrite( STDOUT, urldecode( $input ) );
		break;
	default:
		fwrite( STDERR, "Invalid direction of translation" );
}

exit(0);

?>
