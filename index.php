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
	
	if (isset($_POST['submit'])) {
		// Set up a table for prettier layout.
		echo "<table>";
		echo "<tr valign=\"top\">";
		echo "<td>";

		// Write the recipient list to file so we can use shell scripting magic on it because I don't yet know how to make php pipe vars into stdin of scripts.
		// First prevent other things from overwriting the file.
		exec( "./lock" );
		
		$fh = fopen($recipientList, 'w') or die("Can't generate a list of the recipients.");
		fwrite( $fh, $recipients );
		
		 // Now generate the list of links from file
		echo "<pre>";
		$output = shell_exec( "./mailer " . $subject . " " . $message );
		echo $output;
		echo "</pre>";
		
		// Now we let other things overwrite the user list.
		exec( "./unlock" );
		
		// Continue the table
		echo "</td>";
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
<textarea name="message" rows="20" cols="52" wrap="soft">
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
