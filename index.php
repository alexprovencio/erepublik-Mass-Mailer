<!DOCTYPE html>
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>eRepublik Mass Mailer</title>
	<link rel="stylesheet" type="text/css" href="style.css" />
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.4.4.js"></script>
	<script type="text/javascript" src="./js/autoresize.js"></script>
	<script type="text/javascript" src="./js/textarearesizer.js"></script>
	<script type="text/javascript" src="./js/plugins.js"></script>
</head>

<?php
include 'assembler.php';
include 'outputFormatters.php';
include 'inputInterface.php';
	
	// Handle post/get input type conversion
	$submit = $_GET['submit'];
	$inputType = $_GET['input'];
	if (isset($submit) || $inputType == "get") {
		$inputType = "get";
		$submit = $_GET['submit'];
	} else {
		$inputType = "post";
		$submit = $_POST['submit'];
	}
	
	// Get data; post data always takes precedence
	if (isset($_POST["recipients"])) {
		$recipients = stripslashes( $_POST["recipients"] );
	} else {
		$recipients = stripslashes( $_GET["recipients"] );
	}
	if (isset($_POST["subject"])) {
		$subject = stripslashes( $_POST["subject"] );
	} else {
		$subject = stripslashes( $_GET["subject"] );
	}
	if (isset($_POST["message"])) {
		$message = stripslashes( $_POST["message"] );
	} else {
		$message = stripslashes( $_GET["message"] );
	}
	if (isset($_POST["target"])) {
		$targetmode = stripslashes( $_POST["target"] );
	} else {
		$targetmode = stripslashes( $_GET["target"] );
	}
	if (isset($_POST["output"])) {
		$outputmode = stripslashes( $_POST["output"] );
	} else {
		$outputmode = stripslashes( $_GET["output"] );
	}
	
	if (isset($submit)) {
		if ((strlen( $recipients ) == 0) || (strlen( $message ) == 0) || (strlen( $subject ) == 0)) {
			$output = "Your recipient list, subject, AND message ALL must have things in them!";
		} else {
			// Convert target mode to actual target values
			switch ($targetmode) {
				case "self":
					$target = "" ;
					break;
				case "new":
					$target = "_blank";
					break;
				case "one":
					$target = "one";
					break;
			}
			// Split recipients list into an array
			$recipientIDs = idToIdNum( urlToId( explode( "\n", $recipients ) ) );
			// Generate link array
			$outputArray = generateHtmlHrefs( assemble( $recipientIDs, $subject, $message, $replacements ), $recipientIDs, $target );
			// Split array for one element per html line
			for ($i = 0; $i < count( $outputArray ); $i++) {
				$output = $output . $outputArray[$i] . '<br />';
			}
		}
	}
?>

<body>

<h1>lietk12's eRepublik Mass Mailer (v0.5)</h1>

<?php
	if ($inputType == "post") {
		echo '<p>This mass mailer is a simpler version of <a href="http://erep.thepenry.net/mailer.php">AndraX2000\'s mass mailer</a>.';
		// If the url has string length of 8000 or more, don't offer this option
		if (strlen( $recipients . $message . $subject . $replacements ) < 8000) {
			echo '  For a version which allows you to bookmark specific recipients/subjects/messages, click <a href="./?input=get&amp;recipients=' . urlencode( $recipients ) . '&amp;subject=' . urlencode( $subject ) . '&amp;message=' . urlencode( $message ) . '">here</a>.</p>';
		} else {
			echo '</p>';
		}
	} else {
		echo '<h2>(Bookmarkable Version)</h2><p>This mass mailer is a bookmarkable version of <a href="./index.php">lietk12\'s mass mailer</a>; for super-long lists of people or long messages, this version may behave strangely, in which case you should use <a href="./?input=post&amp;recipients=' . urlencode( $recipients ) . '&amp;subject=' . urlencode( $subject ) . '&amp;message=' . urlencode( $message ) . '">the other version</a> instead.</p>';
	}
?>

<div id="container">
<div id="containerrow">

<?php		
	if ($outputmode != "self" && $outputmode != "new" && isset($submit)) {
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
<textarea name="recipients" id="recipients" class="resizable" rows="10" cols="52" required="required">
<?php echo $recipients; ?></textarea>

<h3>Subject:</h3>
<input type="text" name="subject" id="subject" value="<?php echo $subject; ?>" size="54" maxlength="50" required="required" />

<h3>Message:</h3>
<textarea name="message" id="message" rows="10" cols="52" maxlength="2000" wrap="soft" required="required">
<?php echo $message; ?></textarea>
<h2>Options</h2>
The list of links should go
<select name="output">
	<option value="column" <?php if ($outputmode == "column") {echo 'selected="selected"';}?>>in a column to the left</option>
	<option value="new" <?php if ($outputmode == "new") {echo 'selected="selected"';}?>>in a new tab</option>
	<option value="self" <?php if ($outputmode == "self") {echo 'selected="selected"';}?>>in this tab as a new page</option>
</select><br /> (Note: this feature is currently nonfunctional)
<br />
Links, when left-clicked, will 
<select name="target">
	<option value="self" <?php if ($targetmode == "self") {echo 'selected="selected"';}?>>open in this tab</option>
	<option value="new" <?php if ($targetmode == "new") {echo 'selected="selected"';}?>>open a new tab for each link</option>
	<option value="one" <?php if ($targetmode == "one") {echo 'selected="selected"';}?>>all go into one new tab</option>
</select>

<input type="submit" id="submit" value="Generate" name="submit" />
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
This project is being developed at <a href="https://github.com/lietk12/erepublik-Mass-Mailer">github</a>&mdash;contact lietk12 if you want to contribute.</p>


<script type="text/javascript">
var clicky = { log: function(){ return; }, goal: function(){ return; }};
var clicky_site_id = 66364389;
(function() {
  var s = document.createElement('script');
  s.type = 'text/javascript';
  s.async = true;
  s.src = ( document.location.protocol == 'https:' ? 'https://static.getclicky.com/js' : 'http://static.getclicky.com/js' );
  ( document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0] ).appendChild( s );
})();
</script>
<a title="Google Analytics Alternative" href="http://getclicky.com/66364389"></a>
<noscript><p><img alt="Clicky" width="1" height="1" src="http://in.getclicky.com/66364389ns.gif" /></p></noscript>
</body>

</html>
