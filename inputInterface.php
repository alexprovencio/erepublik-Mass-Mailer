<?php
include 'apiData.php';

// RECIPIENT LIST CONVERTERS

// Converts URLs ending with the player's ID into player IDs of the form "#1242030".  This function should always be called before playerNameToId and before idToIdNum.
function urlToId( $recipientList )
{
	for ($i = 0; $i < count($recipientList); $i++) {
		$recipientList[$i] = preg_replace( "/^http.*[\/\?\=]([0-9]+).*/", "#$1", $recipientList[$i] );
	}
	
	return $recipientList;
}

// Uses API lookup to convert player names into player IDs of the form "#1242030". This function should always be called before idToIdNum. Returns recipientList (array of IDs) and recipientListNotes (error messages associated with API lookups)
function playerNameToId( $recipientList )
{
	$apiFunctionality = apiFunctionality();
	for ($i = 0; $i < count($recipientList); $i++) {
		if (preg_match( '/^[^#].+/', $recipientList[$i] )) { // Assume non-blank lines that don't start with "#" are names.
			if ($apiFunctionality) {
				$id = getInfo( rawurlencode( $recipientList[$i] ), "id" );
				if ($id != false) { // Success
					$recipientList[$i] = "#" . $id;
					$recipientListNotes[$i] .= "";
				} else { // If we couldn't find the person but the API is still up
					if (preg_match( '/^[0-9]+$/', $recipientList[$i] )) { // If the name looks like an ID, assume the user meant it as such, but give a warning.
						$recipientListNotes[$i] = "I couldn't find a player named \"" . $recipientList[$i] . "\", so I treated the name like a profile ID number.";
						$recipientList[$i] = "#" . $recipientList[$i];
					} else { // Standard error message
						$recipientListNotes[$i] = "I couldn't find a player named \"" . $recipientList[$i] . "\".";
						$recipientList[$i] = "";
					}
				}
			} else { // API is down
				$recipientListNotes[$i] = "I didn't look for a player named \"" . $recipientList[$i] . "\" because the API is down.";
				$recipientList[$i] = "";
			}
		} else {
			$recipientListNotes[$i] .= "";
		}
	}
	
	return array( $recipientList, $recipientListNotes );
}

function playerIdToName( $recipientList )
{
	$apiFunctionality = apiFunctionality();
	for ($i = 0; $i < count($recipientList); $i++) {
		if (preg_match( '/^[#].+/', $recipientList[$i] )) { // Assume non-blank lines that start with "#" are IDs.
			if ($apiFunctionality) {
				$name = getInfo( $recipientList[$i], "name" );
				if ($name != false) { // Success
					$recipientList[$i] = $name;
					$recipientListNotes[$i] .= "";
				} else { // If we couldn't find the person but the API is still up
					$recipientListNotes[$i] = "I couldn't find a player with ID \"" . $recipientList[$i] . "\".";
					$recipientList[$i] = "";
				}
			} else { // API is down
				$recipientListNotes[$i] = "I didn't look for a player with ID \"" . $recipientList[$i] . "\" because the API is down.";
				$recipientList[$i] = "";
			}
		} else {
			$recipientListNotes[$i] .= "";
		}
	}
	
	return array( $recipientList, $recipientListNotes );
}

// Converts IDs of the form "#1242030" to the form "1242030"
function idToIdNum( $recipientList )
{
	for ($i = 0; $i < count($recipientList); $i++) {
		$recipientList[$i] = preg_replace( "/\#/", "", $recipientList[$i] );
	}
	
	return $recipientList;
}

// FIELD CONVERTERS

?>
