<?php 
	
	$title = 'Create Account';
	require_once('no_sess_header.php');

	echo "$TAB2<div class='container'><!-- Start content -->\n";
	echo "$TAB3<div class='row-fluid'>\n";
	echo "$TAB4<div class='span12'></div>\n";
	echo "$TAB4<div class='span12'></div>\n";
	echo "$TAB4<div class='span12'></div>\n";
	echo "$TAB4<div class='row-fluid'>\n";
	echo "$TAB5<div class='span7 offset2'>\n";

	if( isset($_POST['create']) ) {
		
		/*
		if(completedForm()) {
			createAccount(....);
		}
		else {
			displayErrs();
		}
		 */
	}

	echo "$TAB6<div class='hero-unit'>\n";
	echo "$TAB7<form action='account.php' onSubmit='return true' method='post' class='form-horizontal'>\n";
	echo "$TAB8<input type='hidden' name='account'>\n";
	echo "$TAB8<div class='control-group'>\n";
	echo "$TAB9<label class='control-label' for-'email'>Email</label>\n";
	echo "$TAB9<div class='controls'>\n";
	echo "$TAB9  <input type='text' name='email' id='email' placeholder='Email'>\n";
	echo "$TAB9</div><!-- end controls -->\n";
	echo "$TAB8</div><!-- end control-group -->\n";
	echo "$TAB8<div class='control-group'>\n";
	echo "$TAB9<label class='control-label' for-'password'>Password</label>\n";
	echo "$TAB9<div class='controls'>\n";
	echo "$TAB9  <input type='password' name='password' id='password' placeholder='Password'>\n";
	echo "$TAB9</div><!-- end controls -->\n";
	echo "$TAB8</div><!-- end control-group -->\n";
	echo "$TAB8<div class='control-group'>\n";
	echo "$TAB9<label class='control-label' for-'password2'>Password</label>\n";
	echo "$TAB9<div class='controls'>\n";
	echo "$TAB9  <input type='password' name='password2' id='password2' placeholder='Password'>\n";
	echo "$TAB9</div><!-- end controls -->\n";
	echo "$TAB8</div><!-- end control-group -->\n";
	echo "$TAB8<div class='control-group'>\n";
	echo "$TAB9<div class='controls'>\n";
	echo "$TAB9  <button type='submit' class='btn' name='create'>Submit</button>\n";
	echo "$TAB9</div><!-- end controls -->\n";
	echo "$TAB8</div><!-- end control-group -->\n";
	echo "$TAB7</form>\n";
	echo "$TAB6</div><!-- end hero-unit -->\n";
	echo "$TAB5</div><!-- end span4 offset3 -->\n";
	echo "$TAB4</div><!-- end row-fluid -->\n";
	echo "$TAB3</div><!-- end row-fluid -->\n";
	echo "$TAB2</div><!-- end content container -->\n";


	require_once('footer.php');
?>
