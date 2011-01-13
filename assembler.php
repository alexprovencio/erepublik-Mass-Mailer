<?php

function assemble( $profileIDs, $subject, $message, $replacements )
{
	// Walk through the profile IDs, and generate an array of data-less PM URLs, an array of message subjects, and an array of message bodies; don't generate anything for blank profile ID entries.
	for ($i = 0; $i < count($profileIDs); $i++) {
		if ($profileIDs[$i] != "") {
			$outputs[$i] = "http://www.erepublik.com/en/messages/compose/" . $profileIDs[$i];
			$subjects[$i] = $subject;
			$messages[$i] = $message;
		} else {
			$outputs[$i] = "";
			$subjects[$i] = "";
			$messages[$i] = "";
		}
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
				$subjects[$i] = str_replace( "{{FIELD" . ($r) . "}}", $replacements[$r][$i], $subjects[$i] );
				$messages[$i] = str_replace( "{{FIELD" . ($r) . "}}", $replacements[$r][$i], $messages[$i] );
			}
		}
	}
	
	// Urlencode each subject and message to make it valid
	for ($i = 0; $i < count($outputs); $i++) {
		$subjects[$i] = urlencode( $subjects[$i] );
		$messages[$i] = urlencode( $messages[$i] );
	}
	
	// Assemble data-less URLs with subjects and messages, as long as the URLs exist
	for ($i = 0; $i < count($profileIDs); $i++) {
		if ($outputs[$i] != "") {
			$outputs[$i] .= "?message_subject=" . $subjects[$i] . "&message_body=" . $messages[$i];
		}
	}
	
	return $outputs;
}

?>
