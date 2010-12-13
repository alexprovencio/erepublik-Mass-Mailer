<?php

function assemble( $profileIDs, $subject, $message, $replacements )
{
	// Walk through the profile IDs, and generate PM URLs
	for ($i = 0; $i < count($profileIDs); $i++) {
		$outputs[$i] = "http://www.erepublik.com/en/messages/compose/" . $profileIDs[$i] . "?message_subject=" . $subject . "&message_body=" . $message;
	}
	
	// Walk through the array of replacement arrays
	for ($r = 0; $r < count($replacements); $r++) {
		// Assume that, if a replacement array is shorter than the profile ID array, all further replacements will be blank
		while (count($outputs) > count($replacements[$r])) {
			$replacements[$r][] = "";
		}
		// With the current replacement array, replace the field tag of the current replacement array with the corresponding string for each element of the output array
		for ($i = 0; $i < count($outputs); $i++) {
			$outputs[$i] = str_replace( "{{FIELD" . ($r + 1) . "}}", $replacements[$r][$i], $outputs[$i] );
		}
	}
	// Encode each URL to make it valid
	return urlencode($outputs);
}

?>