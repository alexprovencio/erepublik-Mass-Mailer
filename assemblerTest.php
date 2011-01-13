<?php
include 'assembler.php';

$profileIDs = array(2499294, 1492450, 1929187, 1383549, 1242030);
print_r( $profileIDs );
$subject = "Hello, {{FIELD3}}";
$message = "This is a {{FIELD0}}.  You are person #{{FIELD1}} in my PM list. {{FIELD2}}";
$replacements = array(	array("super-secret message{{FIELD4}}", "special message{{FIELD4}}", "not-so-secret message{{FIELD4}}", "message", "message"),
			array(0, 1, 2, 3, 4),
			array("I think you are a cool guy.", "Nice to meet you.", "Hi again."),
			array("Avruch", "merschel", "Alexander Auctoritas", "George Armstrong Custer", "lietk12"),
			array(" to buy some food for me", " to check the forums", " to jump in a lake")
		);
print_r( $replacements );
print_r( assemble($profileIDs, $subject, $message, $replacements) );

?>
