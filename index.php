<!DOCTYPE html>
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Mass-Mailer</title>
	<style type="text/css">
	</style>
</head>

<body>

<?php
	$recipients = $_POST["recipients"];
	$subject = urlencode( $_POST["subject"] );
	$message = urlencode( $_POST["message"] );
	$recipientList = "recipientList";
	$outputList = "output";
	
	if (isset($_POST['submit'])) {
		// Write the recipient list to file so we can use shell scripting magic on it because I don't yet know how to make php pipe vars into stdin of scripts.
		// First prevent other things from overwriting the recipient list
		exec( "./lock.sh" );
		$fh = fopen( $recipientList, 'w') or die("Can't generate a list of the recipients." );
		fwrite( $fh, $recipients );
		fclose( $fh );
		// Now generate the list of links from file
		exec( "./processList.sh " . $subject . " " . $message );
		$fh = fopen( $outputList, 'r' ) or die( "Can't read the generated list of the recipients." );
		if (filesize( $outputList ) > 0) {
			$output = fread( $fh, filesize( $outputList ) );
		} else {
			$output = "Please specify a list of recipients!";
		}
		fclose ( $fh );
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

<p>This mass mailer is a simpler version of <a href="http://erep.thepenry.net/mailer.php">AndraX2000's mass mailer</a>.  For the recipients list, paste in URLs (e.g. http://www.erepublik.com/en/citizen/profile/2 ), one URL per line.</p>
<form method="post" action="<?php echo $PHP_SELF;?>">
Recipients: <br />
<textarea name="recipients" rows="10" cols="52" wrap="off" >
<?php echo $recipients; ?></textarea><br /><br />
Subject:<br />
<input type="text" name="subject" value="<?php echo urldecode( $subject ); ?>" size="52" maxlength="50" /> <br /><br />
Message:<br />
<textarea name="message" rows="10" cols="52" wrap="soft">
<?php echo urldecode( $message ); ?></textarea><br />
<input type="submit" value="submit" name="submit" />
</form>

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
