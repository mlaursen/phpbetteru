<?php

	require_once('db_util.php');

	function login() {
		$_SESSION['userid'] = $_POST['userid'];
	}

	function logout() {
		session_unset();
		session_destroy();
		setcookie( session_name(), '', 1, '/' );
	}

	function verifyLogin() {
		if( !isset($_SESSION['userid']) ) {
			notLoggedIn();
		}
	}

	function loggedIn() {
		 return (isset($_SESSION['username'])); 
	}

	function validLogin() {
		$user = $_POST['username'];
		$pswd  = $_POST['password'];
		$res = getUserID_Hash($user);
		if(sizeof($res) <= 0)
			return false;


		$salt = substr( get_one_col($res, 'hash'), 0, 64 );
		$hash = $salt . $pswd;

		for($i=0; $i<10000; $i++) {
			$hash = hash('sha256', $hash);
		}

		$hash = $salt . $hash;
		if($hash === get_one_col($res, 'hash')) {
			$_POST['userid'] = get_one_col($res, 'accountid');
			return true;
		}
		else
			return false;

	}


	function notLoggedIn() {
		echo "<html><head><title>Requires Login</title></head><body>";
		echo "<p style='color: red'>User must be logged in to view this page.<br />Redirecting to login page in 2 seconds.</p>\n";
		echo redirect( 'index.php', '2' );
		echo "</body></html>";
		exit(0);
	}


	function createHash($user, $pswd) {
		$salt = hash('sha256', uniqid(mt_rand(), true) . 'ooga booga' . strtolower($user));
		$hash = $salt . $pswd;
		for($i = 0; $i < 10000; $i++) {
			$hash = hash('sha256', $hash);
		}

		$hash = $salt . $hash;
		return $hash;
	}

?>
