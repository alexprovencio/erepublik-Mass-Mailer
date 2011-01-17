<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<title>eRepublik Recipient List Splitter</title>
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
</head>

<?php
	// Handle post/get input type conversion
	$submit = $_POST['generate'];
	
	// Get data
	$recipients = stripslashes( $_POST["recipients"] );
	$chunksize = stripslashes( $_POST["chunksize"] );
	
	if (isset($submit)) {
		$recipientIDs = preg_split( "/[\r]?\n/", $recipients );
		for ($i = 0; $i < count($recipientIDs); $i++) {
			$recipientIDs[$i] = trim( $recipientIDs[$i] );
		}
		
		for ($i = 0; $i < count($recipientIDs); $i++) {
			$chunk .= $recipientIDs[$i];
			if ($i % $chunksize == 0) {
				$texts[] = $i . "-";
			}
			if ($i % $chunksize == $chunksize - 1 || $i == count($recipientIDs) - 1) {
				$chunks[] = $chunk;
				$texts[-1 + count($texts)] .= $i;
				$chunk = "";
			} else {
			$chunk .=  '%0D%0A';
			}
		}
		
		for ($i = 0; $i < count($chunks);  $i++) {
			$chunks[$i] = './?recipients=' . $chunks[$i];
			$chunks[$i] = '<a href="' . $chunks[$i] . '">' . $texts[$i] . '</a><br />';
			$output .= $chunks[$i];
		}
	}
?>

<body>
<header>
<h1 id="title">lietk12's Divide and Conquer</h1>

<p class="centered">This is a small tool that you can use to split a long list of recipients into smaller chunks of a more manageable size. It'll generate a list of links for <a href="./">lietk12's mass mailer</a>, with each chunk of recipients going into one link, that you can pass onto other people to delegate the mass-mailing process.</p>

</header>

<div id="container" style="width:100px;">
<div id="containerrow">

<?php		
	if ($outputmode != "self" && $outputmode != "new" && isset($submit)) {
		echo '<div id="left">';
		echo '<h2>Links</h2>';
		echo $output;
		echo '</div>';
	}
?>

<form method="post" id="hasInfo" action="./splitter">

<div id="middle">
<section>
<h1>Message Data</h1>
<h2>Recipients:</h2>
<textarea name="recipients" id="recipients" class="resizable" rows="15" cols="52" wrap="off" required="required" title="Remember, one recipient per line!">
<?php echo $recipients; ?></textarea>

<h1>Chunk Size</h1>
<p>The list of recipients should be split up into chunks of 
<input type="number" name = "chunksize" id="chunksize" min="1" value="<?php echo $chunksize; ?>" size="4" title="" required="required" />
people each, with each chunk used to generate a link populating a mass-mailer form.</p>
</section>
<section>
<h1>Generate Link List</h1>
<input type="submit" class="submit" value="Generate" name="generate" />
</section>
</div>

</form>

</div>
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
