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
	// Generate a params string for use by cURL and GET data.
	$params = "recipients=" . urlencode( $recipients ) . "&subject=" . urlencode( $subject ) . "&message=" . urlencode( $message ) . "&target=" . urlencode( $targetmode );
	
	if (isset($submit)) {
		// Gets the directory of this page
		$backwards = strrev($_SERVER['PHP_SELF']);	// Gets the path to this page, backwards
		while ($char != '/') {
			$char = substr($backwards, 0, 1);
			$backwards = substr($backwards, 1);
		}
		$pageDir = "http://" . $_SERVER[SERVER_NAME] . strrev($backwards);
		
		// Send data to output.php and retrieve the results
		$ch = curl_init();
		$options = array(
			CURLOPT_RETURNTRANSFER => true,     // return web page
			CURLOPT_HEADER         => false,    // don't return headers
			CURLOPT_FOLLOWLOCATION => true,     // follow redirects
			CURLOPT_ENCODING       => "",       // handle all encodings
			CURLOPT_USERAGENT      => $_SERVER['HTTP_USER_AGENT'], // who am i
			CURLOPT_AUTOREFERER    => true,     // set referer on redirect
			CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
			CURLOPT_TIMEOUT        => 120,      // timeout on response
			CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
		);
		curl_setopt_array( $ch, $options );
		if ($inputType == "get") {
			curl_setopt($ch, CURLOPT_URL, $pageDir . "/output.php?" . $params );
		} else {
			curl_setopt($ch, CURLOPT_URL, $pageDir . "/output.php");
			curl_setopt( $ch, CURLOPT_POST, true );
			curl_setopt( $ch, CURLOPT_POSTFIELDS, $params );
		}	
		$output = curl_exec( $ch );
		$header = curl_getinfo( $ch );
		if (curl_errno( $ch ) != 0 || $header["http_code"] != 200) {
			echo "<h1>Sorry, but I couldn't generate the list of links!</h1>";
			echo "<pre>";
			print_r($header);
			echo "</pre>";
		}
		curl_close( $ch );
	}
?>

<body>

<h1>lietk12's eRepublik Mass Mailer (v0.6)</h1>

<?php
	if ($inputType == "post") {
		echo '<p class="centered">This mass mailer is an alternative to <a href="http://erep.thepenry.net/mailer.php">AndraX2000\'s mass mailer</a>, which is currently missing in action.';
		// If the url has string length of 8000 or more, don't offer this option
		if (strlen( $recipients . $message . $subject . $replacements ) < 8000) {
			echo '  For a version which allows you to bookmark specific recipients/subjects/messages, click <a href="./?input=get&amp;' . $params . '">here</a>.</p>';
		} else {
			echo '</p>';
		}
	} else {
		echo '<h2>(Bookmarkable Version)</h2><p class="centered">This mass mailer is a bookmarkable version of <a href="./index.php">lietk12\'s mass mailer</a>; for super-long lists of people or long messages, this version may behave strangely, in which case you should use <a href="./?input=post&amp' . $params . '">the other version</a> instead.</p>';
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
<textarea name="recipients" id="recipients" class="resizable" rows="10" cols="52" required="required" wrap="off" placeholder="Remember, one URL/ID number per line!  By the way, unless you disabled javascript, you can grab the gray bar at the bottom of this box to resize it.">
<?php echo $recipients; ?></textarea>

<h3>Subject:</h3>
<input type="text" name="subject" id="subject" value="<?php echo $subject; ?>" size="54" maxlength="50" required="required" placeholder="This is, like, the subject, yo (50 letter limit)" />

<h3>Message:</h3>
<textarea name="message" id="message" rows="10" cols="52" maxlength="2000" wrap="soft" required="required" placeholder="Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip blahblahblah.  Unless you disabled javascript, this box will autoresize to fit your message.  Your message must be shorter than 2000 characters.">
<?php echo $message; ?></textarea>
<h2>Options</h2>
Links, when left-clicked, will 
<select name="target">
	<option value="self" <?php if ($targetmode == "self") {echo 'selected="selected"';}?>>open in this tab/window</option>
	<option value="new" <?php if ($targetmode == "new") {echo 'selected="selected"';}?>>open a new tab for each link</option>
	<option value="one" <?php if ($targetmode == "one") {echo 'selected="selected"';}?>>all go into one new tab</option>
</select>

<input type="submit" id="submit" value="Put the links in column to the left" name="submit" />
<input type="submit" id="submit" value="Put the links in a new tab/window" name="submit" formtarget="_blank" formaction="output.php"/>
</div>

<div id="right">
<div id="help">
	<h2>Notes</h2>
	<p>For the recipients list, as long as you have one player per line, you can use any combination of the following formats to specify the players:</p>
	<ul>
		<li>Player profile URLs (e.g. <code>http://www.erepublik.com/en/citizen/profile/<?php echo rand(2, 4225400);?></code> )</li>
		<li>Player PM URLs (e.g. <code>http://www.erepublik.com/en/messages/compose/<?php echo rand(2, 4225400);?></code> )</li>
		<li>Profile IDs in the form of a "#" with the number afterwards (e.g. <code>#<?php echo rand(2, 4225400);?></code> ).</li>
	</ul>
	<p>More detailed documentation can be found <a href="./output#formats">here</a>.</p>
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
