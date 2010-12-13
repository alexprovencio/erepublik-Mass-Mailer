<?php
include 'assembler.php';

$profileIDs = array(2499294, 1492450, 1929187, 1383549, 1242030);
print_r( $profileIDs );
$subject = "Hello, {{FIELD4}}";
$message = "This is a {{FIELD1}}.  You are person #{{FIELD2}} in my PM list. {{FIELD3}}";
$replacements = array(	array("super-secret message{{FIELD5}}", "special message{{FIELD5}}", "not-so-secret message{{FIELD5}}", "message", "message"),
			array(1, 2, 3, 4, 5),
			array("I think you are a cool guy.", "Nice to meet you.", "Hi again."),
			array("Avruch", "merschel", "Alexander Auctoritas", "George Armstrong Custer", "lietk12"),
			array(" to buy some food for me", " to check the forums", " to jump in a lake")
		);
print_r( $replacements );
print_r( assemble($profileIDs, $subject, $message, $replacements) );

?>
