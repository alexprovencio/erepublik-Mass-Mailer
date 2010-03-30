<!DOCTYPE html>
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Mass-Mailer</title>
	<style type="text/css">
	</style>
</head>

<body>
<!--<h2>The mass mailer is currently unusable</h2>-->

<?php
	$recipients = stripslashes( $_POST["recipients"] );
	$arrayOne = stripslashes( $_POST["arrayOne"] );
	$subject = stripslashes( $_POST["subject"] );
	$message = stripslashes( $_POST["message"] );
	$recipientsFile = "recipientList";
	$subjectFile = "subject";
	$messageFile = "message";
	$outputList = "output";
	$arrayOneFile = "arrayOne";
	
	if (isset($_POST['submit'])) {
		// Write the recipient list to file
		// First prevent other things from overwriting the recipient list
		exec( "./lock.sh" );
		$fh = fopen( $recipientsFile, 'w' ) or die( "Can't generate a list of the recipients." );
		fwrite( $fh, $recipients );
		fclose( $fh );
		// Write the subject and message to file
		$fh = fopen( $subjectFile, 'w' ) or die( "Can't handle the subject." );
		fwrite( $fh, $subject );
		fclose( $fh );
		$fh = fopen( $messageFile, 'w' ) or die( "Can't handle the message." );
		fwrite( $fh, $message );
		fclose( $fh );
		// Write the arrays to file
		$fh = fopen( $arrayOneFile, 'w' ) or die( "Can't handle the first array." );
		fwrite( $fh, $arrayOne );
		fclose( $fh );

		// Now generate the list of links from file
		exec( "./processList.sh" );
		$fh = fopen( $outputList, 'r' ) or die( "Can't read the generated list of the recipients." );
		if ((filesize( $outputList ) == 0) || (strlen( $message ) == 0) || (strlen( $subject ) == 0)) {
			$output = "Your recipient list, subject, AND message ALL must have things in them!";
		} else {
			$output = fread( $fh, filesize( $outputList ) );

		}
		fclose ( $fh );
		
		// Clear all files
		exec( "echo '' > " . $recipientsFile . " > " . $subjectFile . " > " . $subjectFile . " > " . $outputList . " > " . $arrayOneFile);
		
		// Now we let other things overwrite the user list.
		exec( "./unlock.sh" );


		// Set up a table for prettier layout.
		echo "<table cellpadding=\"5\">";
			echo "<tr align=\"left\">";
				echo "<th>Links</th>";
				echo "<th>Message Data</th>";
			echo "</tr>";
			echo "<tr valign=\"top\">";
				echo "<td><p>" . $output . "</p></td>";
				echo "<td>";
	}
?>
<p>This mass mailer is a simpler version of <a href="http://erep.thepenry.net/mailer.php">AndraX2000's mass mailer</a>.  For the recipients list, paste in URLs (e.g. 
http://www.erepublik.com/en/citizen/profile/2 ), one URL per line.  You can also use profile IDs in the form of a "#" with the number afterwards (e.g. #2).</p>
<p>Array one is a pretty cool thing.  For each entry in the recipient list, the string "{{ARRAYONE}}" in the message/subject will be replaced with the corresponding row in the array 
one list.</p>
<form method="post" action="<?php echo $PHP_SELF;?>">
<table>
<tr valign="top">
<td>
Recipients: <br />
<textarea name="recipients" rows="10" cols="52" wrap="off" >
<?php echo $recipients; ?></textarea><br /><br />
Subject:<br />
<input type="text" name="subject" value="<?php echo $subject; ?>" size="52" maxlength="50" /> <br /><br />
Message:<br />
<textarea name="message" rows="10" cols="52" wrap="soft">
<?php echo $message; ?></textarea><br />
<input type="submit" value="submit" name="submit" />
</td>
<td>
Array one:<br />
<textarea name="arrayOne" rows="10" cols="52" wrap="off" >
<?php echo $arrayOne; ?></textarea><br /><br />
</td>
</tr>
</table>
</form>

<p>Bug reports go to lietk12.</p>

<?php
	if (isset($_POST['submit'])) {
		// Finish the table
				echo "</td>";
			echo "</tr>";
		echo "</table>";
	}
?>

</body>

</html>
