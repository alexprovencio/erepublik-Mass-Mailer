<?php

function assemble( $profileIDs, $subject, $message, $replacements )
{
	// Walk through the profile IDs, and generate an array of data-less PM URLs, an array of message subjects, and an array of message bodies
	for ($i = 0; $i < count($profileIDs); $i++) {
		$outputs[$i] = "http://www.erepublik.com/en/messages/compose/" . $profileIDs[$i];
		$subjects[$i] = $subject;
		$messages[$i] = $message;
	}
	
	if (isset( $replacements )) {
		// Walk through the array of replacement arrays
		for ($r = 0; $r < count($replacements); $r++) {
			// Assume that, if a replacement array is shorter than the profile ID array, all further replacements will be blank
			while (count($outputs) > count($replacements[$r])) {
				$replacements[$r][] = "";
			}
			// With the current replacement array, replace the field tag of the current replacement array with the corresponding string for each element of the output array
			for ($i = 0; $i < count($outputs); $i++) {
				$subjects[$i] = str_replace( "{{FIELD" . ($r + 1) . "}}", $replacements[$r][$i], $subjects[$i] );
				$messages[$i] = str_replace( "{{FIELD" . ($r + 1) . "}}", $replacements[$r][$i], $messages[$i] );
			}
		}
	}
	
	// Encode each subject and message to make it valid
	for ($i = 0; $i < count($outputs); $i++) {
		$subjects[$i] = urlencode( $subjects[$i] );
		$messages[$i] = urlencode( $messages[$i] );
	}
	
	// Assemble data-less URLs, subjects, and messages
	for ($i = 0; $i < count($profileIDs); $i++) {
		$outputs[$i] = $outputs[$i] . "?message_subject=" . $subjects[$i] . "&message_body=" . $messages[$i];
	}
	
	return $outputs;
}

?>
