<!DOCTYPE html>
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Mass-Mailer</title>
	<link rel="stylesheet" type="text/css" href="style.css" />
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.4.4.js"></script>
	<script type="text/javascript" src="./autoresize.jquery.js"></script>
	<script type="text/javascript" src="./js/autoresize.js"></script>
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
<p>This mass mailer is a simpler version of <a href="http://erep.thepenry.net/mailer.php">AndraX2000's mass mailer</a>; for a version which allows you to bookmark specific recipients/subjects/messages, try <a href="./simple.php">this</a>.  For the recipients list, as long as you have one player per line, you can use any combination of the following formats to specify the players:
<ul>
<li>Player profile URLs (e.g. <code>http://www.erepublik.com/en/citizen/profile/2</code> )</li>
<li>Player PM URLs (e.g. <code>http://www.erepublik.com/en/messages/compose/2</code> )</li>
<li>Profile IDs in the form of a "#" with the number afterwards (e.g. <code>#2</code> ).</li>
</ul>
</p>
<form method="post" action="<?php echo $PHP_SELF;?>">
<table>
<tr valign="top">
<td>
<h3>Recipients:</h3>
<textarea name="recipients" id="recipients" rows="10" cols="52" wrap="off" >
<?php echo $recipients; ?></textarea><br /><br />
<h3>Subject:</h3>
<input type="text" name="subject" id="subject" value="<?php echo $subject; ?>" size="52" maxlength="50" /> <br /><br />
<h3>Message:</h3>
<script type="text/javascript">
document.write('<textarea name="message" id="message" rows="5" cols="52" wrap="soft">');
document.write('<?php echo $message; ?></textarea><br />');
</script>
<noscript>
<textarea name="message" id="message" rows="10" cols="52" wrap="soft">
<?php echo $message; ?></textarea><br />
</noscript>
<input type="submit" value="submit" name="submit" />
</td>
</tr>
</table>
</form>

<p id="footer">Bugs?  Feature requests?  Design suggestions?  Comments?  Please talk to <a href="http://www.erepublik.com/en/citizen/profile/1242030">lietk12</a>!<br />
This project is being developed at <a 
href="https://github.com/lietk12/erepublik-Mass-Mailer/tree/shellscripted">github</a>&#151;contact lietk12 if you want to contribute.</p>

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
