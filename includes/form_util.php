<?php 
	require_once('util.php');

	function createForm( $action, $parts, $i=3, $end=true, $onSubmit='true', $method='post', $class='form-horizontal' ) {
		$h  = tab($i) . "<form action='$action' onSubmit='return $onSubmit' method='$method' class='$class'>\n";
		$i++;
		foreach($parts as $part)
			$h .= $part;
		$i--;
		$h .= tab($i) . ($end ? '</form>' : '') . "\n";
		return $h;
	}

	/*
		$html .= tab(9) . "<div class='control-group'>\n";
		$html .= tab(10) . "<div class='controls'>\n";
		$html .= tab(11) . "<label class='' >\n";
		$html .= tab(10) . "</div> <!-- end controls -->\n";
		$html .= tab(9) . "</div> <!-- end control-group -->\n";
	 */
	function validKey($key) {
		return $key !== 'label' && $key !== 'init' && $key !== 'inline' && $key !== 'after';
	}

	function createPassword( $i=4, $name='password', $placeholder='Password', $span=3) {
		return createFormPart( 'password', array( 'name'=>$name, 'placeholder'=>$placeholder, 'id'=>$name, 'label'=>$placeholder, 'class'=>"span$span" ), $i );
	}

	function createPasswordConfirm($i=4, $name='password-confirm', $placeholder='Password', $span=3 ) {
		return createFormPart( 'password', array( 'name'=>$name
												, 'placeholder'=>$placeholder
												, 'id'=>$name
												, 'label'=>$placeholder
												, 'class'=>"span$span" 
												)
												, $i );

	}

	function createTextbox( $name, $placeholder='', $i=4, $span=3 ) {
		return createFormPart( 'text'
							 , array( 'name'=>$name
									, 'placeholder'=>$placeholder
									, 'id'=>$name
									, 'label'=>$placeholder
									, 'class'=>"span$span"
								    )
							 , $i
						 	 );
	}

	function createButtonDropdown( $name, $items=array(), $i=4, $label=false, $func=false ) {
		$h  = tab($i) . "<div class='control-group'>\n";
		$i++;
		$h .= tab($i) . "<div class='controls'>\n";
		$i++;
		$h .= tab($i) . "<div class='input-append'>\n";
		$i++;
		$h .= tab($i) . "<div class='btn-group'>\n";
		$i++;
		$h .= tab($i) . "<button id='$name-button' class='btn dropdown-toggle' data-toggle='dropdown'>" . $items[0] . " <span class='caret'></span></button>\n";
		$h .= tab($i) . "<input type='hidden' id='$name' name='$name' value=''>\n";
		$h .= tab($i) . "<ul class='dropdown-menu'>\n";
		$i++;
		$divider=true;
		foreach($items as $item) {
			$h .= tab($i) . "<li><a href='#' " . ($func ? "onClick='$func(\"$item\", \"$name\")" : '') . "'>$item</a></li>\n";
			if($divider===true)
				$h .= tab($i) . "<li class='divider'></li>\n";
			$divider=false;
		}
		$i--;
		$h .= tab($i) . "</ul>\n";
		$i--;
		$h .= tab($i) . "</div> <!-- end btn-group-->\n";
		$i--;
		$h .= tab($i) . "</div> <!-- end input-append -->\n";
		$h .= tab($i) . "<span class='help-block error' id='$name-help'></span>\n";
		$i--;
		$h .= tab($i) . "</div> <!-- end controls -->\n";
		$i--;
		$h .= tab($i) . "</div> <!-- end control-group -->\n";
		return $h;
	}

	function createTextAction( $name, $items=array(), $i=4, $label=false, $func=false ) {
		$h  = tab($i) . "<div class='control-group'>\n";
		$i++;
		$h .= $label ? ( tab($i) . "<label class='control-label' for-'$name'>$label</label>\n" ) : '';
		$h .= tab($i) . "<div class='controls'>\n";
		$i++;
		$h .= tab($i) . "<div class='input-append'>\n";
		$i++;
		$h .= tab($i) . "<input type='text' id='$name' name='$name' placeholder='$label' class='span3'>\n";
		$h .= tab($i) . "<div class='btn-group'>\n";
		$i++;
		$h .= tab($i) . "<button id='brand-button' class='btn dropdown-toggle' data-toggle='dropdown'>" . $items[0] . " <span class='caret'></span></button>\n";
		$h .= tab($i) . "<ul class='dropdown-menu'>\n";
		$i++;
		$divider=true;
		foreach($items as $item) {
			$h .= tab($i) . "<li><a href='#' " . ($func ? "onClick=\"$func('" . addslashes($item) . "', '$name')" : '') . "\">$item</a></li>\n";
			if($divider===true)
				$h .= tab($i) . "<li class='divider'></li>\n";
			$divider=false;
		}
		$i--;
		$h .= tab($i) . "</ul>\n";
		$i--;
		$h .= tab($i) . "</div> <!-- end btn-group-->\n";
		$i--;
		$h .= tab($i) . "</div> <!-- end input-append -->\n";
		$h .= tab($i) . "<span class='help-block error' id='$name-help'></span>\n";
		$i--;
		$h .= tab($i) . "</div> <!-- end controls -->\n";
		$i--;
		$h .= tab($i) . "</div> <!-- end control-group -->\n";

		return $h;
	}

	function createSubmit( $init='Submit', $i=4 ) {
		return createFormPart( 'button', array( 'type'=>'submit', 'class'=>'btn', 'init'=>$init ), $i );
	}


	function createDropdown( $options, $i=5 ) {
		return createFormPart( 'dropdown', $options, $i );
	}

	function createFormPart( $name, $attrs, $i=4 ) {
		$h  = tab($i) . "<div class='control-group'>\n";
		$i++;

		$label = keyInArray('label', $attrs);
		$label = $label ? ( tab($i) . "<label class='control-label' for-'" . slimName($label) . "'>$label</label>\n" ) : '';
		$h .= $label;

		$h .= tab($i) . "<div class='controls'>\n";
		$i++;
		
		$h .= tab($i);
		if($name==='button') {
			$h .= "<button";
			$h2 = " />" . keyInArray('init', $attrs) . "</button>\n";
		}
		else if($name==='dropdown') {
			$h .= "<select>\n";
			$i++;
			foreach($attrs as $part) 
				$h .= tab($i) . "<option value='$part'>$part</option>\n";
			$i--;
			$h .= tab($i) . "</select>\n";
			$h .= tab($i--) . "</div> <!-- end controls -->\n";
			$h .= tab($i) . "</div> <!-- end control-group -->\n";
			return $h;
		}
		else {
			$h .= "<input type='$name'";
			$h2 = " />\n";
		}
		
		$i--;
		foreach( $attrs as $key => $attr ) {
			if( validKey( $key ) ) {
				$h .= " $key='$attr'";
			}
		}
		$id = keyInArray( 'id', $attrs );
		$val = keyInArray( 'value', $attrs );
		$value = keyInArray( $id, $_POST );
		if($name === 'checkbox')
			$h .= $value ? " checked='checked'" : "";
		else if($name !== 'password')
			$h .= " value='" . ($value ? $value : $val) . "'";

		$h .= $h2;
		$h .= tab($i + 1) . "<span class='help-block error' id='" . slimName(keyInArray('name', $attrs)) . "-help'></span>\n";
		$h .= tab($i--) . "</div> <!-- end controls -->\n";
		$h .= tab($i) . "</div> <!-- end control-group -->\n";
		return $h;
	}

	/*
	echo tab(2) . "<div class='container'><!-- Start content -->\n";
	echo tab(3) . "<div class='row-fluid'>\n";
	echo tab(4) . "<div class='span12'></div>\n";
	echo tab(4) . "<div class='span12'></div>\n";
	echo tab(4) . "<div class='span12'></div>\n";
	echo tab(4) . "<div class='row-fluid'>\n";
	echo tab(5) . "<div class='span7 offset2'>\n";

	if( isset($_POST['login']) ) {
		if(validLogin()) {
			login();
			//echo "<pre>", print_r($_POST), "</pre>";
			redirect( 'home.php' );
		}
		else {
			echo displayErrors( array('Invalid username or password') );
		}
	}

	echo tab(6) . "<div class='hero-unit'>\n";
	echo tab(7) . "<form action='login.php' onSubmit='return true' method='post' class='form-horizontal'>\n";
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
	echo tab(10) . "<a href='account.php' class='btn btn-primary' name='create'>Create Account</a>\n";
	echo tab(9) . "</div><!-- end controls -->\n";
	echo tab(8) . "</div><!-- end control-group -->\n";
	echo tab(7) . "</form>\n";
	echo tab(6) . "</div><!-- end hero-unit -->\n";
	echo tab(5) . "</div><!-- end span4 offset3 -->\n";
	echo tab(4) . "</div><!-- end row-fluid -->\n";
	echo tab(3) . "</div><!-- end row-fluid -->\n";
	echo tab(2) . "</div><!-- end content container -->\n";
	 */
?>
<?php

	function generateCheckboxInTable( $name, $value, $after ) {
		global $TAB2;
		return "$TAB2<tr width='125'><label><td align='right' width='75'>" . ($after ? "" : $value . "</td><td>") . "<input type='checkbox' name='$name' value='$value' />" . ($after ? "<td>" . $value : "") . "</label></td>\n";
	}

	function arrayToCheckboxTable( $name, $values, $after=false ) {
		global $TAB2;
		$htmlSoFar = "$TAB2<table>\n";
		foreach($values as $value) {
			$htmlSoFar .= "  " . generateCheckboxInTable( $name, $value, $after );
		}
		return $htmlSoFar . "$TAB2</table>\n";
	}

	function generateForm( $action, $parts, $onsubmit='true', $method="post" ) {
		global $TAB, $TAB2;
		$htmlSoFar = "$TAB2<form action='$action' onSubmit='return $onsubmit' method='$method'>\n";
		foreach($parts as $part) {
			$htmlSoFar .= "  $part";
		}
		return $htmlSoFar . "$TAB2</form>\n";
	}

	function inTableCheckbox( $name, $value, $after ) {
		global $TAB2, $TAB3, $TAB4;
		$html = "$TAB2<tr width='125'>\n";
		$html .= "$TAB3<td align='right' width='75'>" . ($after ? "" : $value . "</td>\n$TAB3<td>");
		$checked = keyInArray( 'classes', $_POST );
		$checked = $checked ? in_array( $value, $checked ) : "";
		$html .= "<input type='checkbox' name='$name' value='$value' " . ($checked ? "checked='checked' " : '') . "/>";
		$html .= ($after ? "<td>" . $value : "") . "</label></td>\n";
		return $html;
	}

	function checkboxTable( $name, $values, $after=false ) {
		global $TAB2;
		$htmlSoFar = "$TAB2<table>\n";
		foreach($values as $value) {
			$htmlSoFar .= "  " . inTableCheckbox( $name, $value, $after );
		}
		return $htmlSoFar . "$TAB2</table>\n";

	}

	/**
	 *  Modified 11/14/2012
	 *  Added functionality to remeber stored values
	 *  if it has been submitted and failed.
	 */
	function generateFormPart( $name, $attributes ) {
		global $TAB, $TAB2, $TAB3, $TAB4;
		$html = "";
		$inline = (array_key_exists('inline', $attributes) ? "" : "<br />") . "\n";
		$after = array_key_exists('after', $attributes);
		if($name === "checkbox" && array_key_exists( "groupby", $attributes ) ) {
			$start .= "<input type='$name'";
			if( array_key_exists( "values", $attributes ) ) {
				$checked = in_array( array($value), $_POST );
				foreach( $attributes["values"] as $val ) {
					$html .= "$TAB2<label>" . ($after ? "" : $val) . "$start name='$attributes[groupby]' value='$val' ";
					$html .= ($checked ? "checked='checked'" : '') . "/>" . ($after ? $val : "") . "</label>$inline";
				}
			}
			return $html;
		}
		else {
			$label = keyInArray( "label", $attributes );
			$html = $TAB2 . ($label ? ("<label>" . ($after ? "" : $label)) : "");
			if($name === 'area') {
				$html .= ( $label ? "<br />" : "" ) . "<textarea";
				$init = keyInArray('description', $_POST);
				$init2 = keyInArray('init', $attributes);
				$html2 = ">" . ($init ? $init : $init2) . "</textarea>";
			}
			else if($name === 'dropdown') {
				$html .= "<select name='" . keyInArray( "name", $attributes, "dropdown" ) . "'>\n";
				$selected = keyInArray( 'traits', $_POST);
				if( array_key_exists( "options", $attributes ) ) {
					foreach( $attributes["options"] as $option ) {
						$html .= "$TAB4<option value='$option' ";
						$html .= $selected == $option ? "selected='selected' " : '';
						$html .= ">$option</option>\n";
					}
				}
				return $html . "$TAB3</select><br />\n";
			}
			else {	// assuming it is a valid "<input type='$name'>"
				$html .= "<input type='$name'";
				$html2 = " />";
			}
	
			foreach( $attributes as $key => $attr ) {
				if( $key !== 'label' && $key !== 'init' && $key !== 'inline' && $key !== 'after' ) {
					$html .= " $key='$attr'";
				}
			}
			$id = keyInArray( 'id', $attributes );
			$val = keyInArray( 'value', $attributes );
			$value = keyInArray( $id, $_POST );
			if($name === 'checkbox')
				$html .= $value ? " checked='checked'" : "";
			else if($name !== 'password')
				$html .= " value='" . ($value ? $value : $val) . "'";
	
			return "$html$html2" . ($label ? (($after ? $label : "") . "</label>") : "") . $inline;
		}
	}

?>
