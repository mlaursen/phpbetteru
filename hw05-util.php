<?php
	
	function login() {
		$_SESSION['username'] = $_POST['username'];
		updateTimeout();
	}

	function updateTimeout() {
		$_SESSION['timeout'] = time() + 30;
	}

	function validLogin() {
		$user = getTrimmedInput('username');
		$pswd = getTrimmedInput('password');
		return ($user === 'i325' && $pswd === 'web2');
	}

	function viewSkill($skillname, $description, $minlevel, $traits, $classes, $username) {
		global $TAB2;
		echo "$TAB2<h3>Skill Description:</h3>\n";
		echo "$TAB2<p>$description</p>\n";
		echo $TAB2, "Minimum level required: $minlevel<br />\n";
		echo $TAB2, "Tied to: $traits<br />\n";
		echo $TAB2, "Available to: ", toCommaList( $classes ) , "<br />\n";
		echo $TAB2, "<p class='additional-info'>$skillname was submitted by $username on ", formattedDate(), "</p>";

	}

	function printSkill($skillname, $description, $minlevel, $traits, $classes, $username ) {
		global $TAB2;
		echo "$TAB2<h3>New Skill: $skillname</h3>\n";
		viewSkill( $skillname, $description, $minlevel, $traits, $classes, $username );
	}

	function loggedIn() {
		 return (isset($_SESSION['username']) && isset($_SESSION['timeout']));
	}

	function notLoggedIn() {
		echo "<html><head><title>Requires Login</title></head><body>";
		echo "<p style='color: red'>User must be logged in to view this page.<br />Redirecting to login page in 2 seconds.</p>\n";
		echo redirect( 'login.php', '2' );
		echo "</body></html>";
		exit(0);
	}

	function logout() {
		session_unset();
		session_destroy();
		setcookie( session_name(), '', 1, '/' );
	}
	
	function timedOut() {
		if( loggedIn() ) {
			if($_SESSION['timeout'] < time()) {
				logout();
				if( basename($_SERVER['SCRIPT_NAME']) === 'skill-form.php' ) {
					notLoggedIn();
				}
			}
			else {
				updateTimeout();
			}
		}
	}

	function verifyLogin() {
		if( basename($_SERVER['SCRIPT_NAME']) === 'skill-form.php' ) {
			if( !isset($_SESSION['username']) ) {
				notLoggedIn();
			}
		}
		timedOut();
	}
?>
