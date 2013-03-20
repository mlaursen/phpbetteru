<?php
	require_once('util.php');
	require_once('sess_util.php');

	function getIngredients( $catg=false, $brand=false ) {
		if( $catg && $brand && !matchAll($catg) && !matchAll($brand) ) {
			return run_procedure( 'Ingredient_GetByCategoryBrand( :catg, :brand, :out )', array($catg, $brand) );
		}
		else if( $catg && !matchAll($catg) ) {
			return run_procedure( 'Ingredient_GetByCategory( :catg, :out )', array($catg) );
		}
		else if( $brand && !matchAll($brand) ) {
			return run_procedure( 'Ingredient_GetByBrand( :brand, :out )', array($brand) );
		}
		else
			return run_procedure( 'Ingredient_GetAll( :out )' );
	}

	function getColumns( $table ) {
		return run_procedure( 'PHP_Columns_GetAllByTableName( :name, :out )', array($table) );
	}

	function getBrands() {
		return run_procedure( 'Brand_GetAll( :out )' );
	}

	function getCategories() {
		return run_procedure( 'Food_Category_GetAll( :out )' );
	}

	function getBrandID( $name ) {
		return run_procedure( 'Brand_GetID( :name, :out)', array($name) );
	}

	function insertIngredient( $post ) {
		$msg=false;
		$name = getTrimmedInput('name', $post);
		$brand = getTrimmedInput('brand', $post);
		$brandid = getBrandID($brand);
		if(!$brandid || sizeof($brandid)===0) {
			run_procedure( 'Brand_Insert( :name )', array($brand), true);
			$msg = "Brand `$brand` Added!";
			$brandid = getBrandID($brand);
		}
		$brandid = get_one_col($brandid, 'brandid');

		$categoryid = get_one_col( run_procedure( 'Food_Category_GetID( :name, :out )', array(getTrimmedInput('category', $post)) ), 'categoryid');

		$servSize = getTrimmedInput('servingsize', $post);
		$servUnit = getTrimmedInput('servingunit', $post);
		$cals = getTrimmedInput('calories', $post);
		$fat = getTrimmedInput('fat', $post);
		$carbs = getTrimmedInput('carbohydrates', $post);
		$protein = getTrimmedInput('protein', $post);
		run_procedure('Ingredient_Insert( :brand, :catg, :name, :servsize, :servunit, :cals, :fat, :carbs, :protein )', array($brandid, $categoryid, $name, $servSize, $servUnit, $cals, $fat, $carbs, $protein), true );
		$ing = "Ingredient `$name` Added!";
		return $msg ? array($ing, $msg) : $msg;
	}

	function createAccount($user, $pass, $fname, $lname) {
		$hash=createHash($user, $pass);
		$exists = run_procedure( 'Account_GetByUsername( :user, :out )', array($user));
		if($exists)
			return displayErrors( array('Username already exists') );
		else {
			$res = run_procedure( 'Account_Insert( :fname, :lname, :user, :hash )', array($fname, $lname, $user, $hash), true);
			return displaySuccess('Account created! You can now log in.');
		}
	}

	function getUserID_Hash($user) {
		return run_procedure('Account_GetHashUserIDByUser( :user, :out )', array($user) );
	}
?>
