<?php
include 'assembler.php';
include 'inputInterface.php';

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

if ((strlen( $recipients ) == 0) && (strlen( $message ) == 0) && (strlen( $subject ) == 0)) {
	$output = '
				<!DOCTYPE html>
				<html>
				
				<head>
					<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
					<title>eRepublik Mass Mailer Output.php Documentation</title>
					<link rel="stylesheet" type="text/css" href="style.css" />
				</head>
				
				<body>
					<h1>Output.php Documentation</h1>
					<p>Hi, you probably found me out of curiosity or malformed code or something. In any case, you might be interested in how I work (I am the component of lietk12\'s project who processes web inputs to prepare them for assembly into a list of links).</p>
					<h2><a name="inputting">Inputting Data</a></h2>
					<p>I parse POST and GET data sent to me, with POST data taking precedence. If you have a form and you want to send data to Output.php, your form\'s action attribute (or your html5 submit button\'s formaction attribute) should be "http://' . $_SERVER[SERVER_NAME] . $_SERVER["PHP_SELF"] . '". If you\'re using cURL with PHP, set CURLOPT_URL to "http://' . $_SERVER[SERVER_NAME] . $_SERVER["PHP_SELF"] . '" (along with necessary parameters (see below) if you plan to send me variables using GET).</p>
					<p>POST/GET Variables that I require are "recipients", "subject", and ""message". These should be self-explanatory. If you fail to provide me with one or two of those variables, I will return an error message: "Your recipient list, subject, AND message ALL must have things in them!". If you leave all those variables blank, I will return this page, (the one which you are reading right now).</p>
					<p>I currently have one optional variable, "target". This directly specifies the "target" attribute for the links.</p>
					<h2><a name="formats">Data Formats</a></h2>
					<p>At the moment, there isn\'t very much to say about this. Your subject should be a string at most 50 chars long (that\'s eRepublik\'s limitation). Your message itself should be no more than 2000 chars long (again, eRepublik\'s limitation). Your recipient list should be a list of any combination of the following formats, with each recipient having one line of his/her/its own:</p>
					<ul>
						<li>Profile IDs, with a "#" prepended to each ID, like <code>#' . rand(2, 4225400) . '</code></li>
						<li>Player URLs which end in the player\'s ID, like <code>http://www.erepublik.com/en/citizen/profile/' . rand(2, 4225400) . '</code>, <code>http://www.erepublik.com/en/messages/compose/' . rand(2, 4225400) . '</code>, <code>http://economy.erepublik.com/en/citizen/donate/' . rand(2, 4225400) . '</code>, <code>http://economy.erepublik.com/en/citizen/donate/list/' . rand(2, 4225400) . '</code>, etc.</li>
					</ul>
					<p>Thus is an example of a list of recipients that I can work with:</p>
					<code style="display: block; white-space: pre-line;">';
					$listSize = rand(5, 20);
					for ($i = 0; $i < $listSize; $i++) {
						$recipientType = rand(0, 100);
						$recipient = rand(2, 4225400);
						if (0 <= $recipientType && $recipientType < 30) {
							$output .= "#" . $recipient;
						} else if (30 <= $recipientType && $recipientType< 60) {
							$output .= "http://www.erepublik.com/en/citizen/profile/" . $recipient;
						} else if (60 <= $recipientType && $recipientType < 80) {
							$output .= "http://www.erepublik.com/en/messages/compose/" . $recipient;
						} else if (80 <= $recipientType && $recipientType < 90) {
							$output .= "http://economy.erepublik.com/en/citizen/donate/" . $recipient;
						} else {
							$output .= "http://economy.erepublik.com/en/citizen/donate/list/" . $recipient;
						}
						$output .= "\n";
					}
	$output .=		'</code>
					<h2><a name="output">Using the Output</a></h2>
					<p>There are a few things you can do with my output, which consists of a series of links with class "profileLink". The easiest thing to do is to send data with me as the form action, so that users just see a blank page with links. However, if you want better integration, you can either use iframes (but that\'s dumb), AJAX/javascript/whatever, or server-side scripting, such as using PHP\'s awesome cURL functionality to send GET/POST data to me and then embedding my output in whatever you\'re doing. If you want to do more complex/advanced stuff, you may want to <a href="https://github.com/lietk12/erepublik-Mass-Mailer/blob/master/output.php">find me on github</a> and use me as an example write your own script.</p>
					
					<p id="footer">Bugs?  Feature requests?  Design suggestions?  Comments?  Please talk to <a href="http://www.erepublik.com/en/citizen/profile/1242030">lietk12</a>!<br />
					This project is being developed at <a href="https://github.com/lietk12/erepublik-Mass-Mailer">github</a>&mdash;contact lietk12 if you want to contribute.<br />
					You can go to the web frontend for this page <a href=./>here</a>.</p>
					
					<script type="text/javascript">
					var clicky = { log: function(){ return; }, goal: function(){ return; }};
					var clicky_site_id = 66364389;
					(function() {
					  var s = document.createElement(\'script\');
					  s.type = \'text/javascript\';
					  s.async = true;
					  s.src = ( document.location.protocol == \'https:\' ? \'https://static.getclicky.com/js\' : \'http://static.getclicky.com/js\' );
					  ( document.getElementsByTagName(\'head\')[0] || document.getElementsByTagName(\'body\')[0] ).appendChild( s );
					})();
					</script>
					<a title="Google Analytics Alternative" href="http://getclicky.com/66364389"></a>
					<noscript><p><img alt="Clicky" width="1" height="1" src="http://in.getclicky.com/66364389ns.gif" /></p></noscript>
				</body>
				
				</html>
			';
} else if ((strlen( $recipients ) == 0) || (strlen( $message ) == 0) || (strlen( $subject ) == 0)) {
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
	$output = UrlArrayToHtml( generateHtmlHrefs( assemble( $recipientIDs, $subject, $message, $replacements ), $recipientIDs, $target ) );
}

echo $output;

function generateHtmlHrefs( $messageUrls, $profileIDs, $target ) {
	for ($i = 0; $i < count( $messageUrls ); $i++) {
		if ( !isset($target) ) {
			$outputs[$i] = '<a href="' . $messageUrls[$i] . '" class="profileLink">' . $profileIDs[$i] . '</a>';
		} else {
			$outputs[$i] =  '<a href="' . $messageUrls[$i] . '" class="profileLink" target="' . $target . '">' . $profileIDs[$i] . '</a>';
		}
	}
	
	return $outputs;
}

function UrlArrayToHtml( $urls )
{
	// Split array for one element per html line
	for ($i = 0; $i < count( $urls ); $i++) {
		$output .= $urls[$i] . '<br />';
	}
	
	return $output;
}

?>