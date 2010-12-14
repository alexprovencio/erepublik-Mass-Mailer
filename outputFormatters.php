<?php

$messageUrls = array( "http://www.erepublik.com/en/messages/compose/2499294?message_subject=Hello%2C+Avruch&message_body=This+is+a+super-secret+message+to+buy+some+food+for+me.++You+are+person+%231+in+my+PM+list.+I+think+you+are+a+cool+guy.", "http://www.erepublik.com/en/messages/compose/1492450?message_subject=Hello%2C+merschel&message_body=This+is+a+special+message+to+check+the+forums.++You+are+person+%232+in+my+PM+list.+Nice+to+meet+you." );

$profileIDs = array( 2499294, 1492450 );

print_r( generateHtmlHrefs( $messageUrls, $profileIDs, false ) );

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