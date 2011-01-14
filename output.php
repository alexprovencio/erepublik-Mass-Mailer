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
if (isset($_POST["fields"])) {
	$fields = $_POST["fields"];
} else {
	$fields = $_GET["fields"];
}
for ($i = 0; $i < count( $fields ); $i++) {
	$fields[$i] = preg_split( "/[\r]?\n/", $fields[$i] );
	for ($j = 0; $j < count( $fields[$i] ); $j++) {
		$fields[$i][$j] = stripslashes( $fields[$i][$j] );
	}
}

if ((strlen( $recipients ) == 0) && (strlen( $message ) == 0) && (strlen( $subject ) == 0)) {
	$output = '
				<!DOCTYPE html>
				<html>
				
				<head>
					<meta charset="UTF-8">
					<title>eRepublik Mass Mailer Output.php Documentation</title>
					<link rel="stylesheet" type="text/css" href="reset.css" />
					<link rel="stylesheet" type="text/css" href="style.css" />
					<link rel="stylesheet" href="webfonts/stylesheet.css" type="text/css" charset="utf-8" />
				</head>
				
				<body>
					<header>
					<h1>Output.php Documentation</h1>
					<p>Hi, you probably found me out of curiosity or malformed code or something. In any case, you might be interested in how I work (I am the component of lietk12\'s project who processes web inputs to prepare them for assembly into a list of links).</p>
					</header>
					<h2><a name="inputting">Inputting Data</a></h2>
					<p>I parse POST and GET data sent to me, with POST data taking precedence. If you have a form and you want to send data to Output.php, your form\'s action attribute (or your html5 submit button\'s formaction attribute) should be "http://' . $_SERVER[SERVER_NAME] . $_SERVER["PHP_SELF"] . '". If you\'re using cURL with PHP, set CURLOPT_URL to "http://' . $_SERVER[SERVER_NAME] . $_SERVER["PHP_SELF"] . '" (along with necessary parameters (see below) if you plan to send me variables using GET).</p>
					<p>POST/GET Variables that I require are "recipients", "subject", and ""message". These should be self-explanatory. If you fail to provide me with one or two of those variables, I will return an error message: "Your recipient list, subject, AND message ALL must have things in them!". If you leave all those variables blank, I will return this page, (the one which you are reading right now).</p>
					<p>I currently have one optional variable, "target". This directly specifies the "target" attribute for the links.</p>
					<h2><a name="formats">Data Formats</a></h2>
					<p>At the moment, there isn\'t very much to say about this. Your subject should be a string at most 50 chars long (that\'s eRepublik\'s limitation). Your message itself should be no more than 2000 chars long (again, eRepublik\'s limitation). Your recipient list should be a list of any combination of the following formats, with each recipient having one line of his/her/its own:</p>
					<ul>
						<li>Profile IDs, with a "#" prepended to each ID, like <code>#' . rand(2, 4225400) . '</code></li>
						<li>Player names, like <code>Eugene Harlot</code></li>
						<li>Player URLs which end in the player\'s ID, like <code>http://www.erepublik.com/en/citizen/profile/' . rand(2, 4225400) . '</code>, <code>http://www.erepublik.com/en/messages/compose/' . rand(2, 4225400) . '</code>, <code>http://economy.erepublik.com/en/citizen/donate/' . rand(2, 4225400) . '</code>, <code>http://economy.erepublik.com/en/citizen/donate/list/' . rand(2, 4225400) . '</code>, etc. If you have some other kind of URL with the ID following a <code>?</code>, <code>/</code>, or <code>=</code>, it should work, too. For those of you who know regexes, the pattern I use to detect URLs is <code>/^http.*[/?=]([0-9]+).*$/</code>.</li>
					</ul>
					<p>By the way, I also ignore leading or trailing whitespace and empty lines. Thusly is an example of a list of recipients that I can work with:</p>
					<code style="display: block; white-space: pre-line;">';
					$listSize = rand(5, 40);
					for ($i = 0; $i < $listSize; $i++) {
						$recipientType = rand(0, 100);
						$recipient = rand(2, 4225400);
						// Add leading whitespace
						if (rand(0, 10) < 4) {
							for ($j = 0; $j < rand(0, 100) % 20; $j++ ) {
									$output .= "&nbsp;";
							}
						}
						// Add user entry
						if (0 <= $recipientType && $recipientType < 30) {
							$output .= "#" . $recipient;
						} else if (30 <= $recipientType && $recipientType < 50) {
							$output .= "http://www.erepublik.com/en/citizen/profile/" . $recipient;
						} else if (50 <= $recipientType && $recipientType < 60) {
							$output .= "";
						} else if (60 <= $recipientType && $recipientType < 70) {
							$people = array("Scrabman", "Justinious Mcwalburgson III", "Uncle Sam", "PrincessMedyPi", "Moishe", "One Eye", "Benn Dover", "DesertFalcon", "Ananias", "Leroy Combs", "Emerick", "Eugene Harlot", "Joe DaSmoe", "Publius", "Tiacha", "Michael Lewis", "Kyle321n", "Pearlswine", "Alby", "Jewitt", "John Woodman", "HeadmistressTalia", "Istarlan", "NeilP99", "ghvandyk", "Claire Littleton", "ProggyPop", "John Jay", "greecelightning", "Nathan Woods", "William Shafer", "NoneSuch", "MoDog", "ClammyJim", "Nave Saikiliah", "shoepuck", "SamWystan", "Henry Baldwin", "Queball_Jenkins");
							$output .= $people[array_rand($people)];
						} else if (70 <= $recipientType && $recipientType < 80) {
							$output .= "http://www.erepublik.com/en/messages/compose/" . $recipient;
						} else if (80 <= $recipientType && $recipientType < 90) {
							$output .= "http://economy.erepublik.com/en/citizen/donate/" . $recipient;
						} else {
							$output .= "http://economy.erepublik.com/en/citizen/donate/list/" . $recipient;
						}
						// Add trailing whitespace
						if (rand(0, 10) < 4) {
							for ($j = 0; $j < rand(0, 100) % 20; $j++ ) {
									$output .= "&nbsp;";
							}
						}
						$output .= "\n";
					}
	$output .=		'</code>
					
					<h2><a name="fields">Replacement Fields</a></h2>
					<p>I can do some very flexible things with making individualized message bodies/message subjects. The easiest way to figure this out is to look at an example of its usage. Before you read on, make sure you try out <a href="http://null.cluenet.org/~lietk12/mmdev/?recipients=%23772321%0D%0A%231983919%0D%0A%235119%0D%0A%23133211%0D%0A%231224939%0D%0A%232290537&subject=Graduation+Exam+Information%3A+{{FIELD4}}&message=Hi%2C+{{FIELD0}}%2C%0D%0A%0D%0AYour+score+on+the+graduation+exam+is+{{FIELD1}}.+Thus%2C+{{FIELD2}}.+You+will+be+contacted+by+{{FIELD3}}.%0D%0A%0D%0ARegards%2C%0D%0ANobody&target=self&generate=Put+the+links+in+column+to+the+left&fieldcount=5&fields[0]=Eugene+Harlot%0D%0AAndyC%0D%0A%0D%0AUncle+Sam%0D%0AJewitt%0D%0AKentel&fields[1]=100%25%0D%0A60%25%0D%0A40%25%0D%0A0%25%0D%0A100%25%0D%0A100%25&fields[2]=you+have+passed+the+course+with+honors%0D%0Ayou+have+passed+the+course%0D%0Ayou+have+passed+the+course%0D%0Ayou+must+retake+the+course%0D%0Ayou+have+passed+the+course%0D%0Ayou+have+passed+the+course&fields[3]=Commander+Shepard%0D%0ACaptain+Mal%0D%0ACaptain+Mal%0D%0Ayour+teacher%0D%0ACaptain+Anderson%0D%0ACaptain+Mal&fields[4]=Congratulations!%0D%0AGood+Work!%0D%0AYou+Passed.%0D%0AYou+Suck.%0D%0ACongratulations!%0D%0ACongratulations!">this example</a>. Okay. Because this is a simple concept that is hard to explain, that\'s all the documentation I\'m giving for now.</p>
					<h2><a name="errors">Possible Errors in Output</a></h2>
					<p>If the API is being stupid, or if you gave me an invalid name or forty, I will output one of several errors:</p>
					<ul>
						<li>If I couldn\'t find the player ID for a given player name, I will not generate a link for that person, and I will make a note of the problem in the list of links.</li>
						<li>If the API looks like it\'s down, I will not generate a link for any player names, and I will tell you that the API is down.</li>
						<li>If you gave me a name which doesn\'t have a player ID associated with it, but which looks like a player ID (e.g. <code>' . rand(2, 4225400). '</code>), I will assume that you meant to put in the player ID (i.e. the number with a <code>#</code> in front of it), and I will treat it as such and generate a link for that person. However, I will make a note of it, just so you know. While this theoretically allows you to put in a list of profile IDs without the <code>#</code> symbol, I would not recommend that, because some numbers (e.g. <code>1234</code>) <strong>do</strong> have players with those numbers as their names</li>
					</ul>
					<h2><a name="output">Using the Output</a></h2>
					<p>There are a few things you can do with my output, which consists of a series of links with class "profileLink". The easiest thing to do is to send data with me as the form action, so that users just see a blank page with links. However, if you want better integration, you can either use iframes (but that\'s dumb), AJAX/javascript/whatever, or server-side scripting, such as using PHP\'s awesome cURL functionality to send GET/POST data to me and then embedding my output in whatever you\'re doing. If you want to do more complex/advanced stuff, you may want to <a href="https://github.com/lietk12/erepublik-Mass-Mailer/blob/master/output.php">find me on github</a> and use me as an example write your own script.</p>
					
					<footer><p>Bugs?  Feature requests?  Design suggestions?  Comments?  Please talk to <a href="http://www.erepublik.com/en/citizen/profile/1242030">lietk12</a>!<br />
					This project is being developed at <a href="https://github.com/lietk12/erepublik-Mass-Mailer">github</a>&mdash;contact lietk12 if you want to contribute.<br />
					You can go to the web frontend for this page <a href=./>here</a>.</p></footer>
					
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
	// Split recipients list into an array, strip off trailing/leading whitespace, and process it
	$recipientIDs = preg_split( "/[\r]?\n/", $recipients );
	for ($i = 0; $i < count($recipientIDs); $i++) {
		$recipientIDs[$i] = trim( $recipientIDs[$i] );
	}
	$originalRecipientList = $recipientIDs; // Copy the original recipient list before processing into a new array
	$recipientIDs = urlToId( $recipientIDs );
	list( $recipientIDs, $recipientIDNotes ) = playerNameToId( $recipientIDs );
	$recipientIDs = idToIdNum( $recipientIDs );
	$output = UrlArrayToHtml( generateHtmlHrefs( assemble( $recipientIDs, $subject, $message, $fields ), $originalRecipientList, $recipientIDs, $recipientIDNotes, $target ) );
}

echo $output;

function generateHtmlHrefs( $messageUrls, $originalRecipients, $profileIDs, $profileIDNotes, $target ) {
	for ($i = 0; $i < count( $messageUrls ); $i++) {
		if ($messageUrls[$i] != "") {
			$outputs[$i] = '<a href="' . $messageUrls[$i] . '" class="profileLink" title="' . $originalRecipients[$i] . '"';
			if (isset( $target )) {
				$outputs[$i] .=  ' target="' . $target . '"';
			}
			$outputs[$i] .= '>';
		}
		$outputs[$i] .= $profileIDs[$i];
		if ($profileIDNotes[$i] != "") {
			if ($outputs[$i] != "") {
				$outputs[$i] .= "; ";
			}
			$outputs[$i] .= $profileIDNotes[$i];
		}
		if ($messageUrls[$i] != "") {
			$outputs[$i] .= '</a>';
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