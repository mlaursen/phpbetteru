<?php 

	$status = $_GET['status'];
	$codes = array( '400'=>array('400 Bad Request', 'The request cannot be fulfilled due to bad sytax.')
	              , '403'=>array('403 Forbidden', 'The server has refused to fulfil your request.')
				  , '404'=>array('404 Not Found', 'The page requested was not found on this server.')
				  , '405'=>array('405 Method Not Allowed', 'The method specified in the request is not allowed for the specified resource.')
				  , '408'=>array('408 Request Timeout', 'Your browser failed to send a request in the time allowed by the server.')
				  , '500'=>array('500 Internal Server Error', 'The request was unsuccessful due to an unexpected condition encountered by the server.')
				  , '502'=>array('502 Bad Gateway', 'The server received an invalid response while trying to carry out the request.')
				  , '504'=>array('504 Gateway Timeout', 'The upstream server failed to send a request in the time allowed by the server.')
				  );

	$title = $codes[$status][0];
	require_once('header.php');


	$name  = $codes[$status][0];
	$msg   = $codes[$status][1];
	if($name === false && strlen($status) !== 3)
		$msg = 'Please supply a valid HTTP status code.';

	echo "<h1>Hold up! $name detected</h1>\n";
	echo "  <p> $msg</p>";

	require_once('footer.php');
?>
