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
	$recipients = stripslashes( $_GET["recipients"] );
	$replaceOne = stripslashes( $_GET["replaceOne"] );
	$subject = stripslashes( $_GET["subject"] );
	$message = stripslashes( $_GET["message"] );
	$recipientsFile = "messageData/recipientList";
	$subjectFile = "messageData/subject";
	$messageFile = "messageData/message";
	$outputList = "output";
	$replaceOneFile = "messageData/replaceOne";
	
	if (isset($_GET['submit'])) {
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
		// Write the replaces to file
		$fh = fopen( $replaceOneFile, 'w' ) or die( "Can't handle the replace list." );
		fwrite( $fh, $replaceOne );
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
		exec( "echo '' > messageData/message; echo '' > messageData/profileNames; echo '' > messageData/recipientList; echo '' > messageData/replaceOne; echo '' > messageData/subject; echo '' > " . $outputList );
		
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
<p>If you are working with extremely gigantic lists of people with really long messages, it is safer to use <a href="..">this mass-mailer</a> instead.</p>
<form method="get" action="<?php echo $PHP_SELF;?>">
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
</tr>
</table>
</form>

<p>Bug reports go to <a href="http://www.erepublik.com/en/citizen/profile/1242030">lietk12</a>.</p>
<p>This project is being maintained at <a href="https://github.com/lietk12/erepublik-Mass-Mailer/tree/shellscripted">github</a>.</p>

<?php
	if (isset($_GET['submit'])) {
		// Finish the table
				echo "</td>";
			echo "</tr>";
		echo "</table>";
	}
?>

</body>

</html>
