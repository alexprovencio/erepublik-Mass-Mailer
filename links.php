<?php

function links( $abbr ) {
	$abbrs = array( 'mm', 'bmm', 'dac' );
	$links = array( './', './?input=get', './splitter' );
	$names = array( './' => 'Mass Mailer', './?input=get' => 'Bookmarkable Mass Mailer', './splitter' => 'Divide and Conquer'  );
	$descs = array( './' => 'lietk12\'s mass mailer, with advanced functionality', './?input=get' => 'A bookmarkable version of lietk12\'s mass mailer', './splitter' => 'A tool to split a long list of message recipients into smaller chunks that you can delegate to other people');

	for ($i = 0; $i < count($links); $i++) {
		if ($abbr == $abbrs[$i]) {
			echo '<b>' . $names[$links[$i]] . '</b>';
		} else {
			echo '<a href="' . $links[$i] . '" title="' . $descs[$links[$i]] . '" class="toolLink">' . $names[$links[$i]] . '</a>';
		}
		if ($i < count($links) - 1) {
			echo " | ";
		}
	}
}
?>
