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
	
	// Generate a params string for use by cURL and GET data.
	$params = "recipients=" . urlencode( $recipients ) . "&subject=" . urlencode( $subject ) . "&message=" . urlencode( $message ) . "&target=" . urlencode( $targetmode ) . "&fieldcount=" . urlencode( $fieldcount );
	for ($i = 0; $i < $fieldcount; $i++) {
		$params .= "&fields[$i]=" . urlencode( $fields[$i] );
	}
?>

<body>
<header>
<?php if ($inputType != "post") {echo '<hgroup>';} ?>
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

<form method="<?php echo $inputType;?>" id="hasInfo" action="./">

<div id="middle">
<section>
<h1>Message Data</h1>
<h2>Recipients:</h2>
<textarea name="recipients" id="recipients" class="resizable" rows="10" cols="52" wrap="off" title="Remember, one URL/ID number per line!  By the way, unless you disabled javascript, you can grab the gray bar at the bottom of this box to resize it.">
<?php echo $recipients; ?></textarea>

<h1>Chunk Size</h1>
<p>The list of recipients should be split up into chunks of 
<input type="number" name = "chunksize" id="chunksize" min="0" value="<?php echo $chunksize; ?>" size="4" title="" />
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
