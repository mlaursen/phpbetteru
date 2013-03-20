<?php
	$title = 'Daily Intake';
	require_once('header.php');
	
	$html = pageTop( array( array( 'View By', 'view', array('By Month', 'By Week', 'Today') ) ) );
	$rows = array();
	foreach($rows as $row) {
		$html .= intakeTable(date('l, F d, Y', $row['']));
	}
	$html .= intakeTable(date('l, F d, Y', time()));
	$html .= intakeTable( date('l, F d, Y', strtotime('-1 day') ) );
	$html .= pageBot();
	echo $html;


	require_once('footer.php');
?>
