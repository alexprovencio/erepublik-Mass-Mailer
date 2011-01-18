<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<title>eRepublik Name/Profile ID Lookup</title>
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
	<?php
		include 'links.php';
		include 'inputInterface.php';
	?>
	
	<script type="text/javascript" src="./js/plugins.js"></script>
	
	<!--[if lt IE 9]>
	<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
</head>

<?php
	// Handle post/get input type conversion
	$submit = $_POST['convert'];
	
	// Get data
	$recipients = stripslashes( $_POST["recipients"] );
	$outputmode = stripslashes( $_POST["outputmode"] );
	
	// Split recipients list into an array, strip off trailing/leading whitespace, and process it
	$recipientList = preg_split( "/[\r]?\n/", $recipients );
	for ($i = 0; $i < count($recipientList); $i++) {
		$recipientList[$i] = trim( $recipientList[$i] );
	}
	
	if (isset($submit)) {
		if ($outputmode == "id") {
			list( $recipientList, $recipientNotes ) = playerNameToId( $recipientList );
		} else {
			list( $recipientList, $recipientNotes ) = playerIdToName( $recipientList );
		}
		
		for ($i = 0; $i < count( $recipientList ); $i++) {
			$output .= $recipientList[$i] . $recipientNotes[$i] . "<br />";
		}
	}
?>

<body>
<header>
<h1 id="title">lietk12's Transmogrifier</h1>
<p id="tools"><?php links( "t" )?></p>
<p id="description">This is a small tool that you can use to convert a list of player names into profile IDs, or vice versa. Converting player names to profile IDs is useful if you want to save this list for future use on the mass mailer and want to be able to use it conveniently, even when the API is down or being suuuuuuuper-slow. You might want to convert profile IDs into player names if you want to get a list of names for use in replacement fields in the mass mailer. Or maybe you have your own use unrelated to mass mailing. Whatever works for you.</p>

</header>

<div id="container<?php if (isset($submit)) {echo "l";}?>m" <?php if (isset($submit)) {echo 'style="width: 51em;"';}?>>

<?php		
	if (isset($submit)) {
		echo '<div id="left" style="white-space:nowrap; width:16em; overflow:auto;">';
		echo '<h2>Result</h2>';
		echo $output;
		echo '</div>';
	}
?>

<form method="post" id="hasInfo" action="./nameconvert">

<div id="middle" style="float:right;">
<section>
<h1>Player Names/Profile IDs</h1>
<textarea name="recipients" id="recipients" class="resizable" rows="15" cols="52" wrap="off" required="required" title="Remember, one recipient per line! Also, profile IDs should be of the form '#profileID', e.g. #1242030">
<?php echo $recipients; ?></textarea>

<h1>Conversion Mode</h1>
<p>Generate a list of 
<select name="outputmode" >
	<option value="name" <?php if ($outputmode != "id") {echo 'selected="selected"';}?>>player names</option>
	<option value="id" <?php if ($outputmode == "id") {echo 'selected="selected"';}?>>profile IDs</option>
</select>
from the input.
</p>
</section>
<section>
<h1>Convert</h1>
<input type="submit" class="submit" value="Convert" name="convert" />
</section>
</div>

</form>

</div>

<footer>
<p>Bugs?  Feature requests?  Design suggestions?  Comments?  Please talk to <a href="http://www.erepublik.com/en/citizen/profile/1242030">lietk12</a>!<br />
This project is being developed at <a href="https://github.com/lietk12/erepublik-Mass-Mailer">github</a>&mdash;contact lietk12 if you want to contribute.<br />
If you're curious about what the next version will have, you can see the development branch of this tool <a href="../mmdev/splitter">here</a>.</p>
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
