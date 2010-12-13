<?php
include 'assembler.php';

$profileIDs = array(2499294, 1492450, 1929187, 1383549, 1242030);
print_r( $profileIDs );
$subject = "Subject {{FIELD1}}";
$message = "This is a message.  You are the {{FIELD1}}th person in the list. My password is {{FIELD2}}";
$replacements = array( array("{{FIELD2}}", 2, 3, 4, 5), array("foobar", "yarrr", "blah") );
print_r( $replacements );
print_r( assemble($profileIDs, $subject, $message, $replacements) );

?>