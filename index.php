<!DOCTYPE html>
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>eRepublik Mass Mailer</title>
	<link rel="stylesheet" type="text/css" href="style.css" />
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.4.4.js"></script>
	<script type="text/javascript" src="./js/autoresize.js"></script>
	<script type="text/javascript" src="./js/textlimit.js"></script>
	<script type="text/javascript" src="./js/textarearesizer.js"></script>
	<script type="text/javascript" src="./js/plugins.js"></script>
</head>

<body>

<?php
include 'assembler.php';
include 'outputFormatters.php';
include 'inputInterface.php';
	
	$submit = $_GET['submit'];
	$inputType = $_GET['input'];
	if ($submit == "Generate" || $inputType == "get") {
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
?>

<h1>lietk12's eRepublik Mass Mailer (v0.5)</h1>

<?php
	if ($inputType == "post") {
		echo '<p>This mass mailer is a simpler version of <a href="http://erep.thepenry.net/mailer.php">AndraX2000\'s mass mailer</a>; for a version which allows you to bookmark specific recipients/subjects/messages, click <a href="./?input=get&recipients=' . urlencode( $recipients ) . '&subject=' . urlencode( $subject ) . '&message=' . urlencode( $message ) . '">here</a>.</p>';
	} else {
		echo '<h2>(Bookmarkable Version)</h2><p>This mass mailer is a bookmarkable version of <a href="./index.php">lietk12\'s mass mailer</a>; for super-long lists of people or long messages, this version may behave strangely, in which case you should use <a href="./?input=post&recipients=' . urlencode( $recipients ) . '&subject=' . urlencode( $subject ) . '&message=' . urlencode( $message ) . '">the other version</a> instead.</p>';
	}
?>

<div id="container">
<div id="containerrow">
<?php
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
		
		echo '<div id="left">';
		echo '<h2>Links</h2>';
		echo $output;
		echo '</div>';
	}
?>

<form method="<?php echo $inputType;?>" action="./">

<div id="middle">
<h2>Message Data</h2>
<h3>Recipients:</h3>
<textarea name="recipients" id="recipients" class="resizable" rows="10" cols="52" wrap="off" >
<?php echo $recipients; ?></textarea>

<h3>Subject:</h3>
<input type="text" name="subject" id="subject" value="<?php echo $subject; ?>" size="54" maxlength="50" />

<h3>Message:</h3>
<textarea name="message" id="message" rows="10" cols="52" wrap="soft">
<?php echo $message; ?></textarea>

<input type="submit" id = "submit" value="Generate" name="submit" />
</div>

<div id="right">
<div id="help">
	<h2>Notes</h2>
	For the recipients list, as long as you have one player per line, you can use any combination of the following formats to specify the players:
	<ul>
		<li>Player profile URLs (e.g. <code>http://www.erepublik.com/en/citizen/profile/2</code> )</li>
		<li>Player PM URLs (e.g. <code>http://www.erepublik.com/en/messages/compose/2</code> )</li>
		<li>Profile IDs in the form of a "#" with the number afterwards (e.g. <code>#2</code> ).</li>
	</ul>
</div>
<!--
<div id="replacements">
<h2>Replacement Data</h2>
Blah.
</div>-->
</div>

</form>

</div>
</div>

<p id="footer">Bugs?  Feature requests?  Design suggestions?  Comments?  Please talk to <a href="http://www.erepublik.com/en/citizen/profile/1242030">lietk12</a>!<br />
This project is being developed at <a href="https://github.com/lietk12/erepublik-Mass-Mailer">github</a>&#151;contact lietk12 if you want to contribute.</p>

</body>

</html>
