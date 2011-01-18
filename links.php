<?php

function links( $abbr ) {
	$abbrs = array( 'mm', 'bmm', 'dac', 't' );
	$links = array( './', './?input=get', './splitter', './nameconvert' );
	$names = array( './' => 'Mass Mailer', './?input=get' => 'Bookmarkable Mass Mailer', './splitter' => 'Divide and Conquer', './nameconvert' => 'Transmogrifier'  );
	$descs = array( './' => 'lietk12\'s mass mailer, with mail-merge functionality', './?input=get' => 'A bookmarkable version of lietk12\'s mass mailer', './splitter' => 'A tool to split a long list of message recipients into smaller chunks that you can delegate to other people', './nameconvert' => 'A tool that converts a list of player names to profile IDs, or vice versa');

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
