<?php

	function tab($num=1) {
		$tab = "  ";
		if($num === 1)
			return $tab;
		else
			return $tab . tab($num - 1);
	}

	function fieldIsEmpty( $field ) {
		return $field=='';
		
	}

	function addApostrophe( $str ) {
		return str_replace("'", "''", $str);
	}

	function slimName($name) {
		return strtolower( preg_replace( '/\(\w*\)/', '', str_replace("'", '', str_replace(' ', '', $name) )));
	}

	function requireAllIncludes() {
		foreach( scandir("./includes") as $fName )
			if( !isExcluded($fName) )
				require_once($fName);
	}

	function isExcluded($fName) {
		return $fName === '.' || $fName === '..' || preg_match( '/.+\.swp$/', $fName);
	}


	function matchAll( $subject ) {
		return preg_match('/^all/i', $subject);
	}

	function formatNum($num) {
		return number_format($num, 2, '.', '');
	}


	function excludedTitle($title) {
		return $title === 'INGREDIENTID';
	}

	function keyInArray( $key, $arr, $returnIfFailed="" ) {
		return array_key_exists( $key, $arr ) ? $arr["$key"] : $returnIfFailed;
	}

	/**
	 * Creates an alert div to put all the errors in.
	 * Didn't inclue the tabs because you never actually *see* the code.
	 *
	 * $errors	An array of errors to display.
	 *
	 * return	Valid html for a div tag with all the errors displayed.
	 */
	function displayErrors( $errors ) {
		$html = "<div class='alert alert-error alert-block'>\n";
		$html .= "<button type='button' class='close' data-dismiss='alert'>&times;</button>\n";
		foreach($errors as $error) {
			$html .= "<strong>$error</strong><br />\n";
		}
		$html .= "</div>\n";
		return $html;
	}

	function displaySuccess( $msg ) {
		$h = "<div class='alert alert-success" . (is_array($msg) ? ' alert-block' : '') . "'>\n";
		$h .= "<button type='button' class='close' data-dismiss='alert'>&times;</button>\n";
		if(!is_array($msg))
			$msg=array($msg);
		foreach($msg as $m)
			$h .= "<strong>$m</strong><br />\n";
		$h .= "</div>\n";
		return $h;
	}



	function redirect($url, $refresh="") {
		header( $refresh ? "refresh:$refresh; url=$url" : "Location: $url" );
	}


	function lastMod( $fileName ) {
		return "Last modified: " . formattedDate($fileName);
	}

	function cleanString( $str ) {
		if(is_array($str)) {
			$newArr = array();
			foreach( $str as $key=>$s ) {
				 $newArr["$key"] = cleanString( $s );
			}
			return $newArr;
		}
		else {
			return preg_replace( '/ +/', ' ', trim( $str ) );
		}
	}


	function getTrimmedInput( $attr, $arr=false ) {
		if(!$arr)
			$arr=$_POST;
		if(array_key_exists( $attr, $arr ) ) {
			return is_array( $arr["$attr"] ) ? $arr["$attr"] : trim ( get_magic_quotes_gpc() ? stripslashes( $arr["$attr"] ) : $arr["$attr"] );
		}
		return false;
	}

	function sanitizeHtml( $rawText ) {
		return nl2br( htmlspecialchars( $rawText ) );
	}


	function trimAndSanitize( $attr ) {
		return sanitizeHtml( getTrimmedInput( $attr ) );
	}

	function formattedDate( $file=false ) {
		return date( "Y.M.d (D) H:i.", ($file ? filemtime($file) : time()) );
	}

    function pluralize( $num, $noun ) {
        return $num . " " . ( $num == 1 ? $noun  : pluralHelper( $noun ) );
    }

    function pluralHelper( $noun ) {
        $special = array("s", "f", "x", "z", "o", "ch", "sh");
		$lastTwoChar = substr( $noun, strlen($noun) - 2, strlen($noun) );
        foreach ( $special as $sp ) {
            if($lastTwoChar === $sp || $lastTwoChar{1} === $sp) {
				return $noun . "es";
            }
            else if( substr($noun, strlen($noun) - 1, strlen($noun)) === "y") {
            	return substr($noun, 0, strlen($noun) - 1) . "ies";
            }
        }
        return $noun . "s";
    }

    function hyperlink( $url, $linkTxt=false ) {
        return "<a href='$url'>" . ($linkTxt ? $linkTxt : $url  ). "</a>";
	}


?>
