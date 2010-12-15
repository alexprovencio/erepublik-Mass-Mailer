<?php

function generateHtmlHrefs( $messageUrls, $profileIDs, $target ) {
	for ($i = 0; $i < count( $messageUrls ); $i++) {
		if ( !isset($target) ) {
			$outputs[$i] = '<a href="' . $messageUrls[$i] . '" class="profileLink">' . $profileIDs[$i] . '</a>';
		} else {
			$outputs[$i] =  '<a href="' . $messageUrls[$i] . '" class="profileLink" target="' . $target . '">' . $profileIDs[$i] . '</a>';
		}
	}
	
	return $outputs;
}

?>