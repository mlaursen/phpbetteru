<?php
	$title = 'Must be logged in';
	require_once('logging_header.php');
	
	$codes = array( '100'=>'You have logged out.'
				  , '101'=>'You must be logged in to view this page.'
	              );
	$msg='You must supply a valid code.';
	if(isset($_GET['code'])) {
		$code = $_GET['code'];
		if(array_key_exists($code, $codes))
			$msg=$codes[$code];

	}
	echo tab(2) . "<div class='container'><!-- Start content -->\n";
	echo tab(3) . "<div class='row-fluid'>\n";
	echo tab(4) . "<div class='span12'></div>\n";
	echo tab(4) . "<div class='span12'></div>\n";
	echo tab(4) . "<div class='span12'></div>\n";
	echo tab(4) . "<div class='row-fluid'>\n";
	echo tab(5) . "<div class='span7 offset2'>\n";
	echo tab(6) . "<div class='alert alert-error'>\n";
	echo tab(7) . "$msg<br />\nRedirecting to login page in 3 seconds.\n";



	echo tab(6) . "</div><!-- end alert alert-error -->\n";
	echo tab(5) . "</div><!-- end span4 offset3 -->\n";
	echo tab(4) . "</div><!-- end row-fluid -->\n";
	echo tab(3) . "</div><!-- end row-fluid -->\n";
	echo tab(2) . "</div><!-- end content container -->\n";
	redirect( 'index.php', 3 );
	
	require_once('footer.php');
?>
