<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<title>eRepublik Mass Mailer</title>
	<link rel="stylesheet" href="reset.css" />
	<link rel="stylesheet" href="style.css" />
	<link rel="stylesheet" href="./js/tipsy.css" />
	<link rel="stylesheet" href="webfonts/stylesheet.css" />
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.4.4.js"></script>
	<script type="text/javascript" src="./js/autoresize.js"></script>
	<script type="text/javascript" src="./js/textarearesizer.js"></script>
	<script type="text/javascript" src="./js/tipsy.js"></script>
	<script type="text/javascript" src="./js/cookie.js"></script>
	<script type="text/javascript" src="./js/showhide.js"></script>
	
	<script type="text/javascript" src="./js/plugins.js"></script>
	
	<!--[if lt IE 9]>
	<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	
	<?php
		include 'links.php';
	?>
</head>

<?php
	// Handle post/get input type conversion
	$submit = $_GET['generate'];
	$inputType = $_GET['input'];
	if (isset($submit) || $inputType == "get" || isset($_GET['submitFields']) || isset($_POST['submitFields']) ) {
		$inputType = "get";
		$submit = $_GET['generate'];
	} else {
		$inputType = "post";
		$submit = $_POST['generate'];
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
	if (isset($_POST["fieldcount"])) {
		$fieldcount = stripslashes( $_POST["fieldcount"] );
	} else {
		$fieldcount = stripslashes( $_GET["fieldcount"] );
	}
	if (isset($_POST["fields"])) {
		$fields = $_POST["fields"];
	} else {
		$fields = $_GET["fields"];
	}
	for ($i = 0; $i < count( $fields ); $i++) {
		$fields[$i] = stripslashes( $fields[$i] );
	}
	if (!isset( $fieldcount ) && count( $fields ) > 0) {
		$fieldcount = count( $fields );
	} else {
		$fieldcount += 0;
	}
	
	// Generate a params string for use by cURL and GET data.
	$params = "recipients=" . urlencode( $recipients ) . "&subject=" . urlencode( $subject ) . "&message=" . urlencode( $message ) . "&target=" . urlencode( $targetmode ) . "&fieldcount=" . urlencode( $fieldcount );
	for ($i = 0; $i < $fieldcount; $i++) {
		$params .= "&fields[$i]=" . urlencode( $fields[$i] );
	}
	
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
<header>
<h1 id="title">lietk12's <?php if ($inputType != "post") {echo "Bookmarkable ";} ?>Mass Mailer (v0.7.2)</h1>
<p id="tools"><?php if ($inputType == "post") {links( "mm" );} else {links( "bmm" );} ?></p>

<?php
	if ($inputType == "post") {
		echo '<p id="description">This mass mailer is a stand-alone alternative to <a href="http://erep.thepenry.net/mailer.php" class="testing">AndraX2000\'s mass mailer</a>.';
		// If the url has string length of 8000 or more, don't offer this option
		if (strlen( $params ) < 8000) {
			echo '  For a version which allows you to bookmark specific recipients/subjects/messages, click <a href="./?input=get&amp;' . $params . '">here</a>.</p>';
		} else {
			echo '</p>';
		}
	} else {
		echo '<p id="description">This mass mailer is a bookmarkable version of <a href="./">lietk12\'s mass mailer</a>; for super-long lists of people or long messages, you should use <a href="./?input=post&amp;' . str_replace( "&", "&amp;", $params ) . '">the other version</a> instead to ensure stability.</p>';
	}
?>
</header>

<div id="container<?php if ($outputmode != "self" && $outputmode != "new" && isset($submit)) {echo "l";}?>mr">

<?php		
	if ($outputmode != "self" && $outputmode != "new" && isset($submit)) {
		echo '<div id="left">';
		echo '<h2>Links</h2>';
		echo $output;
		echo '</div>';
	}
?>

<form method="<?php echo $inputType;?>" id="hasInfo" action="./">

<div id="middle">
<section>
<h1>Message Data</h1>
<h2>Recipients:</h2>
<textarea name="recipients" id="recipients" class="resizable" rows="10" cols="52" wrap="off" title="Remember, one URL/ID number per line!  By the way, unless you disabled javascript, you can grab the gray bar at the bottom of this box to resize it.">
<?php echo $recipients; ?></textarea>

<h2>Subject:</h2>
<input type="text" name="subject" id="subject" value="<?php echo $subject; ?>" size="54" maxlength="50" placeholder="This is, like, the subject, yo!" title="Your subject must be at most 50 characters long." />

<h2>Message:</h2>
<textarea name="message" id="message" class="autoresize" rows="10" cols="52" maxlength="2000" wrap="soft" placeholder="Given the existence as uttered forth in the public works of Puncher and Wattmann of a personal God quaquaquaqua with white beard quaquaquaqua outside time without extension who from the heights of divine apathia divine athambia divine aphasia loves us dearly with some exceptions for reasons unknown but" title="Unless you disabled javascript, this box will autoresize to fit your message.  Your message must be shorter than 2000 characters.">
<?php echo $message; ?></textarea>
</section>
<section>
<h1>Options</h1>
<p>Links, when left-clicked, will 
<select name="target" >
	<option value="self" <?php if ($targetmode == "self") {echo 'selected="selected"';}?>>open in this tab/window</option>
	<option value="new" <?php if ($targetmode == "new") {echo 'selected="selected"';}?>>open a new tab for each link</option>
	<option value="one" <?php if ($targetmode == "one") {echo 'selected="selected"';}?>>all go into one new tab</option>
</select></p>
</section>
<section>
<h1>Generate Link List</h1>
<input type="submit" class="submit" value="Put the links in column to the left" name="generate" />
<input type="submit" class="submit" value="Put the links in a new tab/window" name="generate" formtarget="_blank" formaction="output.php"/>
</section>
</div>

<div id="right">
<section id="help">
	<h1>Notes</h1>
	<p>For the recipients list, as long as you have one player per line, you can use any combination of the following formats to specify the players:</p>
	<ul>
		<li>Player profile URLs</li>
		<li>Player names</li>
		<li>Profile IDs in the form of a number prefixed by a <code>#</code> symbol<br />
		    (e.g. <code>#<?php echo rand(2, 4225400);?></code> ).</li>
	</ul>
	<p>More detailed documentation with examples and with other less common but still acceptable inputs can be found <a href="./output#formats">here</a>.</p>
</section>

<section id="replacements">
<h1>Replacement Fields<!--<span id="showhide" style="display: none;">--> (<a href="#" class="toggle" title="fieldData">Hide</a>)<!--</span>--></h1>
<p>This is an advanced feature that you can safely disregard; you can think of it as mail merge functionality. If you're interested in how to use it, you can <a href="http://www.screencast.com/users/lietk12/folders/Jing/media/5ec8916a-812c-4681-9fce-c9d92f38faa0" target="_blank">view a demonstration</a> involving a scenario of assigning blockers to 61 regions.</p>
<div id="fieldData">
<p>Number of fields: <input type="number" name = "fieldcount" id="fieldcount" min="0" max="64" value="<?php echo $fieldcount; ?>" size="2" maxlength="2" title="A number between 0 and 64, inclusive. Press the &quot;Update the field data boxes&quot; button at the bottom of this column to synchronize the number of visible boxes with the number of boxes specified in this field." /></p>
<?php
for ($i = 0; $i < $fieldcount; $i++) {
	echo "<p>Field replacement data for <code>{{FIELD" . $i . "}}</code>:";
	echo '<textarea name="fields[' . $i . ']" id="field" class="resizable" rows="10" cols="60" wrap="off">';
	echo $fields[$i];
	echo "</textarea></p>";
}
?>
<input type="submit" class="submit" value="Update the field data boxes" name="submitFields" />
</div>
</section>
</div>

</form>

</div>

<footer>
<p>Bugs?  Feature requests?  Design suggestions?  Comments?  Please talk to <a href="http://www.erepublik.com/en/citizen/profile/1242030">lietk12</a>!<br />
This project is being developed at <a href="https://github.com/lietk12/erepublik-Mass-Mailer">github</a>&mdash;contact lietk12 if you want to contribute.<br />
If you're curious about what the next version will have, you can see the often-broken development branch of this massmailer <a href="../mmdev/">here</a>.</p>
</footer>

<script type="text/javascript">document.getElementById('showhide').style.display = 'inline';</script>

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
