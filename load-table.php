<?php 
if(session_id() == '') {
    // session isn't started
	session_start();
}

require_once('ui_util.php');

//$group = isset($_GET['group']) ? $_GET['group'] : false;
$catg = isset($_GET['catg']) ? $_GET['catg'] : false;
$brand = isset($_GET['brand']) ? $_GET['brand'] : false;

echo ingredientTable($catg, $brand);
/*
if($page) { 
	if($page == "purchasing"){
		purchaseTable($catg, $_SESSION['tid']);
	}
	elseif($page == "pricing"){
		pricingTable($catg, $_SESSION['tid']);
	}
	else{
		echo "Invalid page";
	}
}
else {
	echo "Page not specified";
}
 */
?>
