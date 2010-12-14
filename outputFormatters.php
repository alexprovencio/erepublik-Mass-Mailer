<?php

function generateHtmlHrefs( $messageUrls, $profileIDs, $whetherToOpenInNewWindow ) {
	for ($i = 0; $i < count( $messageUrls ); $i++) {
		if ( $whetherToOpenInNewWindow ) {
			$outputs[$i] = '<a href="' . $messageUrls[$i] . '" class="profileLink" target="_blank">' . $profileIDs[$i] . '</a>';
		} else {
			$outputs[$i] =  '<a href="' . $messageUrls[$i] . '" class="profileLink">' . $profileIDs[$i] . '</a>';
		}
	}
	
	return $outputs;
}

?>