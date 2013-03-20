<?php
	$title = 'Daily Intake';
	require_once('header.php');
	
	$row = run_procedure( 'Account_GetByID( :id, :out )', array($_SESSION['userid']) );
	$row = get_proc_row($row);

	echo "<div class='container'>\n";
	echo "<div class='fluid-row'>\n";
	echo "Welcome ", $row['FNAME'], " " , $row['LNAME'], "!\n";
	echo "</div>\n";
	echo "</div>\n";

	require_once('footer.php');
?>
