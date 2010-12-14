<!DOCTYPE html>
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Mass-Mailer</title>
	<style type="text/css">
	</style>
</head>

<body>
<h1>lietk12's eRepublik Mass Mailer</h1>
<!--<h2>The mass mailer is currently unusable</h2>-->

<?php
include 'assembler.php';
include 'outputFormatters.php';
include 'inputInterface.php';

	$recipients = stripslashes( $_POST["recipients"] );
	$subject = stripslashes( $_POST["subject"] );
	$message = stripslashes( $_POST["message"] );
	
	if (isset($_POST['submit'])) {
		if ((strlen( $recipients ) == 0) || (strlen( $message ) == 0) || (strlen( $subject ) == 0)) {
			$output = "Your recipient list, subject, AND message ALL must have things in them!";
		} else {
			$recipientIDs = idToIdNum( urlToId( explode( "\n", $recipients ) ) );
			$outputArray = generateHtmlHrefs( assemble( $recipientIDs, $subject, $message, $replacements ), $recipientIDs, true );
			for ($i = 0; $i < count( $outputArray ); $i++) {
				$output = $output . $outputArray[$i] . '<br />';
			}
		}
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
<p>This mass mailer is a simpler version of <a href="http://erep.thepenry.net/mailer.php">AndraX2000's mass mailer</a>.  For the recipients list, as long as you have one player per line, you can use any combination of the following formats to specify the players:
<ul>
<li>Player profile URLs (e.g. http://www.erepublik.com/en/citizen/profile/2)</li>
<li>Player PM URLs (e.g. http://www.erepublik.com/en/messages/compose/2 )</li>
<li>Profile IDs in the form of a "#" with the number afterwards (e.g. #2).</li>
</ul>
</p>
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
</tr>
</table>
</form>

<p>Bug reports go to <a href="http://www.erepublik.com/en/citizen/profile/1242030">lietk12</a>.  This project is being maintained at <a href="https://github.com/lietk12/erepublik-Mass-Mailer/tree/shellscripted">github</a>.</p>

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
