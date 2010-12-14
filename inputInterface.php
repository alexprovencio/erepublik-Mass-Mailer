<?php

// RECIPIENT LIST CONVERTERS

// Converts player profile URLs into player IDs of the form "#1242030"
function urlToId( $recipientList )
{
	for ($i = 0; $i < count($recipientList); $i++) {
		$recipientList[$i] = "#" . preg_replace( "/.*\//", "", $recipientList[$i] );
	}
	
	return $recipientList;
}

// Uses API lookup to convert player names into player IDs of the form "#1242030"
function playerNameToId( $recipientList )
{
	
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