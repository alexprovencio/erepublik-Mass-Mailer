<!DOCTYPE html>
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Mass-Mailer</title>
	<link rel="stylesheet" type="text/css" href="style.css" />
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.4.4.js"></script>
	<script type="text/javascript" src="./js/autoresize.js"></script>
	<script type="text/javascript" src="./js/textlimit.js"></script>
	<script type="text/javascript" src="./js/textarearesizer.js"></script>
	<script type="text/javascript" src="./js/plugins.js"></script>
</head>

<body>
<h1>lietk12's eRepublik Mass Mailer</h1>
<!--<h2>The mass mailer is currently unusable</h2>-->

<?php
include 'assembler.php';
include 'outputFormatters.php';
include 'inputInterface.php';
	
	$submit = $_GET['submit'];
	$inputType = $_GET['input'];
	if ($submit == "submit" || $inputType == "get") {
		$inputType = "get";
		$submit = $_GET['submit'];
	} else {
		$inputType = "post";
		$submit = $_POST['submit'];
	}
		if (isset($_GET["recipients"]) && !isset($_POST["recipients"])) {
			$recipients = stripslashes( $_GET["recipients"] );
		} else {
			$recipients = stripslashes( $_POST["recipients"] );
		}
		if ($_GET["subject"] && !isset($_POST["subject"])) {
			$subject = stripslashes( $_GET["subject"] );
		} else {
			$subject = stripslashes( $_POST["subject"] );
		}
		if ($_GET["message"] && !isset($_POST["message"])) {
			$message = stripslashes( $_GET["message"] );
		} else {
			$message = stripslashes( $_POST["message"] );
		}
	
	if ($inputType == "post") {
		echo 'This mass mailer is a simpler version of <a href="http://erep.thepenry.net/mailer.php">AndraX2000\'s mass mailer</a>; for a version which allows you to bookmark specific recipients/subjects/messages, click <a href="./?input=get&recipients=' . urlencode( $recipients ) . '&subject=' . urlencode( $subject ) . '&message=' . urlencode( $message ) . '">here</a>.</p>';
	} else {
		echo '<h2>(Bookmarkable Version)</h2><p>This mass mailer is a bookmarkable version of <a href="./index.php">lietk12\'s mass mailer</a>; for super-long lists of people or long messages, this version may behave strangely, in which case you should use <a href="./?input=post&recipients=' . urlencode( $recipients ) . '&subject=' . urlencode( $subject ) . '&message=' . urlencode( $message ) . '">the other version</a> instead.</p>';
	}
	
	if (isset($submit)) {
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
				echo "<td>" . $output . "</td>";
				echo "<td>";
	}
?>
For the recipients list, as long as you have one player per line, you can use any combination of the following formats to specify the players:
<ul>
<li>Player profile URLs (e.g. <code>http://www.erepublik.com/en/citizen/profile/2</code> )</li>
<li>Player PM URLs (e.g. <code>http://www.erepublik.com/en/messages/compose/2</code> )</li>
<li>Profile IDs in the form of a "#" with the number afterwards (e.g. <code>#2</code> ).</li>
</ul>
<form method="<?php echo $inputType;?>" action="./">
<table>
<tr valign="top">
<td>
<h3>Recipients:</h3>
<textarea name="recipients" id="recipients" class="resizable" rows="10" cols="52" wrap="off" >
<?php echo $recipients; ?></textarea><br /><br />
<h3>Subject:</h3>
<input type="text" name="subject" id="subject" value="<?php echo $subject; ?>" size="52" maxlength="50" /> <br /><br />
<h3>Message:</h3>
<textarea name="message" id="message" rows="10" cols="52" wrap="soft">
<?php echo $message; ?></textarea><br />
<input type="submit" value="submit" name="submit" />
</td>
</tr>
</table>
</form>

<?php
	if (isset($_POST['submit'])) {
		// Finish the table
				echo "</td>";
			echo "</tr>";
		echo "</table>";
	}
?>
<p id="footer">Bugs?  Feature requests?  Design suggestions?  Comments?  Please talk to <a href="http://www.erepublik.com/en/citizen/profile/1242030">lietk12</a>!<br />
This project is being developed at <a
href="https://github.com/lietk12/erepublik-Mass-Mailer/tree/shellscripted">github</a>&#151;contact lietk12 if you want to contribute.</p>

</body>

</html>
