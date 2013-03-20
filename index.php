<?php 
	$title = 'Fitness Tracker Login Page';
	require_once('logging_header.php');
	require_once('util.php');

	$errmsgs=array();
	$msg=false;
	if(isset($_POST['create-account-form'])) {
		if(isset($_POST['username'])) {
			
		}
		else 
			$errmsgs[] = 'The Username field has not been set';

		if(isset($_POST['password'])) {

		}
		else 
			$errmsgs[] = 'The Password field has not been set';

		if(isset($_POST['firstname'])) {

		}
		else 
			$errmsgs[] = 'The First Name field has not been set';

		if(isset($_POST['lastname'])) {

		}
		else 
			$errmsgs[] = 'The Last Name field has not been set';

		if(!$errmsgs) {
			$user = getTrimmedInput('username');
			$pass = getTrimmedInput('password');
			$frst = getTrimmedInput('firstname');
			$last = getTrimmedInput('lastname');
			$msg = createAccount( $user, $pass, $frst, $last );

		}
		else {
			$msg = displayErrors( $errmsgs );
		}
	}

	function createAccountModal() {
		$html = tab(2) . "<div id='create-account' class='modal hide fade' tabindex=-1' role='dialog' aria-labelledby'addIngredientLabel' aria-hidden='true'>\n";
		$html .= tab(3) . "<div class='modal-header'>\n";
		$html .= tab(4) . "<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>x</button>\n";
		$html .= tab(4) . "<h3 id='create-account-label'>Create Account</h3>\n";
		$html .= tab(3) . "</div> <!-- end model-header -->\n";
		$html .= tab(3) . "<form action='" . $_SERVER['PHP_SELF'] . "' onSubmit='return validateCreateAccount()' method='post' class='form-horizontal'>\n";
		$html .= tab(4) . "<input type='hidden' name='create-account-form' />\n";
		$html .= tab(4) . "<div class='modal-body'>\n";
		
		$html .= createTextbox('username', 'Username', 5);
		$html .= createPassword(5);
		$html .= createPasswordConfirm(5);
		$html .= createTextbox('firstname', 'First Name', 5);
		$html .= createTextbox('lastname', 'Last Name', 5);

		$html .= tab(4) . "</div> <!-- end model-body -->\n";
		$html .= tab(4) . "<div class='modal-footer'>\n";
		$html .= tab(4) . "<button class='btn' data-dismiss='modal'>Close</button>\n";
		$html .= tab(4) . "<button class='btn btn-primary' type='submit'>Create</button>\n";
		$html .= tab(4) . "</div> <!-- end modal-footer -->\n";
		$html .= tab(3) . "</form>\n";

		$html .= tab(2) . "</div> <!-- end modal -->\n";
		return $html;
	}
	echo createAccountModal();

	echo tab(2) . "<div class='container'><!-- Start content -->\n";
	echo tab(3) . "<div class='row-fluid'>\n";
	echo tab(4) . "<div class='span12'></div>\n";
	echo tab(4) . "<div class='span12'></div>\n";
	echo tab(4) . "<div class='span12'></div>\n";
	if($msg) {
		echo tab(4) . "<div id='success' class='span4 offset3'>$msg</div>";
	}
	echo tab(4) . "<div class='row-fluid'>\n";
	echo tab(5) . "<div class='span7 offset2'>\n";

	if( isset($_POST['login']) ) {
		if(validLogin()) {
			login();
			redirect( 'home.php' );
		}
		else 
			echo displayerrors( array('Invalid username or password' ) );
	}

	echo tab(6) . "<div class='hero-unit'>\n";
	echo tab(7) . "<form action='" . $_SERVER['PHP_SELF'] . "' onSubmit='return true' method='post' class='form-horizontal'>\n";
	echo tab(8) . "<input type='hidden' name='login'>\n";
	echo tab(8) . "<div class='control-group'>\n";
	echo tab(9) . "<label class='control-label' for-'username'>Username</label>\n";
	echo tab(9) . "<div class='controls'>\n";
	echo tab(10) . "<input type='text' name='username' id='username' placeholder='Username' value='", ((isset($_POST['username'])) ? $_POST['username'] : ''), "'>\n";
	echo tab(9) . "</div><!-- end controls -->\n";
	echo tab(8) . "</div><!-- end control-group -->\n";
	echo tab(8) . "<div class='control-group'>\n";
	echo tab(9) . "<label class='control-label' for-'password'>Password</label>\n";
	echo tab(9) . "<div class='controls'>\n";
	echo tab(10) . "<input type='password' name='password' id='password' placeholder='Password'>\n";
	echo tab(9) . "</div><!-- end controls -->\n";
	echo tab(8) . "</div><!-- end control-group -->\n";
	echo tab(8) . "<div class='control-group'>\n";
	echo tab(9) . "<div class='controls'>\n";
	echo tab(10) . "<button type='submit' class='btn' name='log-in'>Login</button>\n";
	echo tab(10) . "<a href='" . $_SERVER['PHP_SELF'] . "#create-account' data-toggle='modal' class='btn btn-primary' name='create'>Create Account</a>\n";
	echo tab(9) . "</div><!-- end controls -->\n";
	echo tab(8) . "</div><!-- end control-group -->\n";
	echo tab(7) . "</form>\n";
	echo tab(6) . "</div><!-- end hero-unit -->\n";
	echo tab(5) . "</div><!-- end span4 offset3 -->\n";
	echo tab(4) . "</div><!-- end row-fluid -->\n";
	echo tab(3) . "</div><!-- end row-fluid -->\n";
	echo tab(2) . "</div><!-- end content container -->\n";

	echo "
<script>
$('#password').blur( function() {
	var help = $('#password-help').val();
	var len = $('#password').val().length;
	if(len < 8) {
		reportError('password', 'The password must be at least 8 characters.');
	}
	else if( help !== '' )
		removeError('password');
});

$('#password-confirm').blur( function() {
	var p1 = $('#password').val();
	var p2 = $('#password-confirm').val();
	var help1 = $('#password-help').html();
	if(help1 === '' && p1 !== p2) {
		reportError('password', 'The password fields must match.');
		reportError('password-confirm', 'The password fields must match.');
	}
	else {
		removeError('password');
		removeError('password-confirm');
	}
});
</script>";

	require_once('footer.php');
?>
