<?php
	$title = 'Ingredients';
	require_once('header.php');

	$errorMsgs=array();
	$redirect=false;

	// handling the add-ingredient form
	$msg=false;
	if(isset($_POST['add-ingredient'])) {
		//echo "<pre>", print_r($_POST), "</pre>\n";
		if(isset($_POST['name'])) {
			if(fieldIsEmpty($_POST['name']))
				$errorMsgs[] = 'Ingredient name must not be blank';
		}

		if(isset($_POST['brand'])) {
			if($_POST['brand'] == '')
				$errorMsgs[] = 'The brand must be a known brand';
		}

		if(isset($_POST['category'])) {
			if(!in_array($_POST['category'], cursor_to_array( getCategories() )))
				$errorMsgs[] = 'The category must be one of the known categories';
		}
		if(isset($_POST['servingsize'])) {
			if(fieldIsEmpty($_POST['servingsize']))
				$errorMsgs[] = 'The serving size must not be blank.';
			if(!is_numeric($_POST['servingsize']))
				$errorMsgs[] = 'The serving size field must be a number';
		}
		if(isset($_POST['servingunit'])) {
			if(fieldIsEmpty($_POST['servingunit']))
				$errorMsgs[] = 'The serving unit must not be blank.';
		}
		if(isset($_POST['calories'])) {
			if(fieldIsEmpty($_POST['calories']))
				$errorMsgs[] = 'The calories field must not be blank.';
			if(!is_numeric($_POST['calories']))
				$errorMsgs[] = 'The calories field must be a number';
		}
		if(isset($_POST['fat'])) {
			if(fieldIsEmpty($_POST['fat']))
				$errorMsgs[] = 'The fat field must not be blank.';
			if(!is_numeric($_POST['fat']))
				$errorMsgs[] = 'The fat field must be a number';
		}
		if(isset($_POST['carbohydrate'])) {
			if(fieldIsEmpty($_POST['carbohydrate']))
				$errorMsgs[] = 'The carbohydrate field must not be blank.';
			if(!is_numeric($_POST['carbohydrate']))
				$errorMsgs[] = 'The carbohydrate field must be a number';
		}
		if(isset($_POST['protein'])) {
			if(fieldIsEmpty($_POST['protein']))
				$errorMsgs[] = 'The protein field must not be blank.';
			if(!is_numeric($_POST['protein']))
				$errorMsgs[] = 'The protein field must be a number';
		}

		if(!$errorMsgs) {
			$res = insertIngredient( $_POST );
			$msg = displaySuccess($res);
			$redirect=true;
		}
		else {
			$msg = displayErrors( $errorMsgs );
		}
	}


	// actual page content now
	$catgs = cursor_to_array( run_procedure( 'Food_Category_Get( :out )' ) );
	array_splice($catgs, 0, 0, 'All Categories');

	$brands = cursor_to_array( run_procedure( 'Brand_GetAll( :out )' ) );
	array_splice($brands, 0, 0, 'All Brands');

	$items = array( array( 'Food Categories', 'catg', $catgs )
			 	  , array( 'Brands', 'brand-nav', $brands )
			  	  );
	$html = pageTop( $items, 'Ingredients', $msg);
	$html .= ingredientTable();
	$html .= pageBot();

	if($redirect)
		redirect( 'ingredients.php', 3);

	echo $html;

	require_once('footer.php');
?>
