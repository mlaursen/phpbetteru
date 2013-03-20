<?php 
	ob_start();
	
	// require_once on all php files in the includes directory
	require_once('util.php');
	requireAllIncludes();
	ini_set('display_errors', 'stderr');
	ini_set('display_startup.errors', true);
	error_reporting(E_ALL | E_STRICT);
	session_start();
	verifyLogin();
	date_default_timezone_set('America/New_York');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <title><?php echo ($title ? $title : 'Fitness Helper'); ?></title>
    <link href="style/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="style/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
    <link href="style/main.css" rel="stylesheet">
    <script src="scripts/jquery-1.8.3.min.js"></script>
    <script src="scripts/util.js"></script>
    <script src="style/bootstrap/js/bootstrap.js"></script>
  </head>
  <body>
<?php
	echo titleBar();
	echo addIngredientModal();
	echo addRecipeModal();
?>
