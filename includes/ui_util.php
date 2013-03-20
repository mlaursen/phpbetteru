<?php

	require_once('util.php');
	require_once('db_util.php');
	require_once('procedures.php');

	function titleBar() {
		$bar = tab(2) . "<div class='navbar navbar-inverse'>\n";
		$bar .= tab(3) . "<div class='navbar-inner'>\n";
		$bar .= tab(4) . "<a class='brand' href='about.php'>INFO</a>\n";
		$bar .= tab(4) . "<ul class='nav'>\n";
		$bar .= tab(5) . "<li><a href='home.php'>Home</a></li>\n";
		$bar .= tab(5) . "<li><a href='days.php'>Day Info</a></li>\n";
		$bar .= tab(5) . "<li><a href='settings.php'>Settings</a></li>\n";
		$bar .= tab(5) . "<li><a href='ingredients.php'>Ingredients</a></li>\n";
		$bar .= tab(5) . "<li><a href='recipes.php'>Recipes</a></li>\n";
		$bar .= tab(4) . "</ul>\n";
		$bar .= tab(4) . "<ul class='nav pull-right'>\n";
		$bar .= tab(5) . "<li><a data-toggle='modal' href='handle-forms.php#add-ingredient'>Add Ingredient</a></li>\n";
		$bar .= tab(5) . "<li><a data-toggle='modal' href='recipes.php#add-recipe'>Add Recipe</a></li>\n";
		$bar .= tab(5) . "<li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>\n";
		$bar .= tab(5) . "<li><a href='logout.php'>Logout</a></li>\n";
		$bar .= tab(4) . "</ul>\n";
		$bar .= tab(3) . "</div><!-- end navbar-inner -->\n";
		$bar .= tab(2) . "</div><!-- end navbar navbar-inverse -->\n";
		$bar .= tab(2) . "<!-- end title bar -->\n";
		return $bar;
	}

	function addIngredientModal() {
		$html = tab(2) . "<div id='add-ingredient' class='modal hide fade' tabindex=-1' role='dialog' aria-labelledby'addIngredientLabel' aria-hidden='true'>\n";
		$html .= tab(3) . "<div class='modal-header'>\n";
		$html .= tab(4) . "<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>x</button>\n";
		$html .= tab(4) . "<h3 id='addIngredientLabel'>Add New Ingredient</h3>\n";
		$html .= tab(3) . "</div> <!-- end model-header -->\n";
		$html .= tab(3) . "<form action='ingredients.php' onSubmit='return validateIngredientForm()' method='post' class='form-horizontal'>\n";
		$html .= tab(4) . "<input type='hidden' name='add-ingredient' />\n";
		$html .= tab(4) . "<div class='modal-body'>\n";

		$cols = getColumns( 'Ingredients' );
		for($i = 0; $i < sizeof($cols); $i++) {
			$col = get_col(get_proc_row($cols, $i), 'php_value');
			if($col === 'Brand') {
				$brands	= cursor_to_array( getBrands() );
				array_splice($brands, 0, 0, 'New Brand');
				$html .= createTextAction( 'brand', $brands, 5, 'Brand Name', 'selectItem');

			}
			else if($col === 'Category') {
				$catgs = cursor_to_array( getCategories() );
				array_splice($catgs, 0, 0, 'Select Category');
				$html .= createButtonDropdown( 'category', $catgs, 5, 'Category Name', 'selectItem');

			}
			else {
				$html .= createTextbox(slimName($col), $col, 5);
			}
		}



		$html .= tab(4) . "</div> <!-- end model-body -->\n";
		$html .= tab(4) . "<div class='modal-footer'>\n";
		$html .= tab(4) . "<button class='btn' data-dismiss='modal'>Close</button>\n";
		$html .= tab(4) . "<button class='btn btn-primary' type='submit'>Add Ingredient</button>\n";
		$html .= tab(4) . "</div> <!-- end modal-footer -->\n";
		$html .= tab(3) . "</form>\n";

		$html .= tab(2) . "</div> <!-- end modal -->\n";
		return $html;
	}

	function addRecipeModal() {
		return '';
	}

	function intakeTableRow($row, $day) {
		$html = tab(8) . "<tr>\n";
		$html .= tab(9) . "<th>$row</th>\n";

		$rowVals = array(); // eventually db_query
		for($i = sizeof($rowVals) + 1; $i <= 6; $i++) {
			$rowVals[] = 0;
		}

		foreach($rowVals as $val) {
			$html .= tab(9) . "<td>" . formatNum($val) . "</td>\n";
		}

		$expected = 1800;
		$total = array_sum($rowVals);
		$remaining = $expected - $total;
		$html .= tab(9) . "<td>" . formatNum($expected) . "</td>\n";
		$html .= tab(9) . "<td>" . formatNum($total) . "</td>\n";
		$html .= tab(9) . "<td>" . formatNum($remaining) . "</td>\n";
		return $html . tab(8) . "</tr>\n";
	}


	function intakeTable($day) {
		$meal = array();
		$table = tab(7) . "<h4>$day</h4>\n";
		$table .= tab(7) . "<table class='table table-striped table-condensed'>\n";
		$table .= tab(8) . "<tr>\n";
		$table .= tab(9) . "<th></th>\n";
		for($i = sizeof($meal) + 1; $i <= 6; $i++) {
			$meal[] = "Meal 0$i";
		}
		foreach($meal as $m) {
			$table .= tab(9) . "<th>$m</th>\n";
		}
		$table .= tab(9) . "<th>Expected Total</th>\n";
		$table .= tab(9) . "<th>My Total</th>\n";
		$table .= tab(9) . "<th>Remaining Total</th>\n";
		$table .= tab(8) . "</tr>\n";

		$table .= intakeTableRow('Calories', $day);
		$table .= intakeTableRow('Fat', $day);
		$table .= intakeTableRow('Carbohydrates', $day);
		$table .= intakeTableRow('Protein', $day);

		$table .= tab(7) . "</table>\n";
		return $table;
	}


	/**
	 * Creates the html for the Ingredients page table, listing all ingredients or all ingredients
	 * in a certain category and/or certain brand.  The default is set to view all.
	 *
	 * $catg	The category to view
	 * $brand	The brand to view.
	 *
	 * return 	Valid html for the ingredients page table.
	 */
	function ingredientTable($catg=false, $brand=false) {
		$html = tab(6) . "<h4>Ingredients</h4>\n";
		$html .= tab(6) . "<table class='table table-striped table-bordered table-hover table-condensed'>\n";
		$html .= tab(7) . "<tr>\n";

		$ingredients = getIngredients($catg, $brand);
		$cols = getColumns( 'Ingredients' );
		//$cols = run_procedure( 'PHP_Columns_GetAllByTableName( :name, :out )', array('Ingredients') );
		for($i = 0; $i < sizeof($cols); $i++) {
			$row = get_proc_row($cols, $i);
			$html .= tab(8) . "<th>" . $row['PHP_VALUE'] . "</th>\n";
			
		}
		$html .= tab(7) . "</tr>\n";

		// loop over the $res array/cursor
		for($i = 0; $i < sizeof($ingredients); $i++) {
			$html .= tab(7) . "<tr>\n";
			$row = get_proc_row($ingredients, $i);
			
			// loop over the $cols array/cursor to add all the table data.
			for($j = 0; $j < sizeof($cols); $j++) {
				$col = get_proc_row($cols, $j);

				$html .= tab(8) . "<td>";
				$col = get_col($row, $col['COLUMN_NAME']);
				$html .= (is_numeric($col) ? formatNum($col) : $col) . "</td>\n";
			}
			$html .= tab(7) . "</tr>\n";
		}
		
		$html .= tab(6) . "</table>\n";
		return $html;
	}


	function pageTableNavListItems( $title, $name, $arr=array(), $tableName="") {
		$html = tab(6) . "<ul name='catg-nav' class='nav nav-list'>\n";
		$html .= tab(7) . "<li class='nav-header'>$title</li>\n";
		$i=0;
		foreach($arr as $val) {
			$valSlimmed = slimName($val);
			$html .= tab(7) . "<li id='$valSlimmed' ";
			$html .= ($i===0 ? "class='active' " : '');
			$html .= "name='$name' " . catgNavLink($val, $valSlimmed, $name, $tableName) . "><a href='#'>$val</a></li>\n";
			$i++;
		}
		$html .= tab(6) . "</ul>\n";
		return $html;
	}

	/**
	 * Returns a Navigation Table for the page's table(s)
	 *
	 * $items	An array of arrays to be displayed in the nav table.
	 * 			The array is in order of title, name, and an array of values.
	 * $page	The page that the nav table is on
	 *
	 * return	Valid html for the navication table.
	 */
	function pageTableNav( $items, $page="" ) {
		$html = tab(4) . "<div class='span2'>\n";
		$html .= tab(5) . "<div class='well sidebar-nav'>\n";
		$j=0;
		foreach( $items as $item ) {
			if($j < sizeof($items) && $j !== 0)
				$html .= tab(5) . "<hr />\n";
			$html .= pageTableNavListItems( $item[0], $item[1], $item[2], $page );
			$j++;
		}
		$html .= tab(5) . "</div> <!-- end well sidebar-nav -->\n";
		$html .= tab(4) . "</div> <!-- end span2 -->\n";
		$html .= tab(4) . "<!-- end navigation table -->\n";

		return $html;
	}

	/**
	 * Creates an onClick element for the navigation table link.
	 *
	 * $catg	The name of the category to view
	 * $name	The group name to change
	 * $page	The page to apply the change to
	 *
	 * return	Html for an onClick element in a <li> tag
	 */
	function catgNavLink($catg, $catgSlimmed, $name, $page="") {
		return "onClick=\"load" . $page . "Table('" . addslashes($catg) . "', '$catgSlimmed', '$name');\" ";
	}

	/**
	 * Creates the top part of the html for a page with a navigation table.
	 *
	 * $items	An array of arrays to be displayed in the navigation table.
	 * $page	The page the navigation table is on.
	 *
	 * Example use: pageTop( array( array( 'Title', 'Group Name', array('food', 'more food!') ) ), 'Foods' );
	 * 				would return a nav table with only one navigation table list.
	 *
	 * 				pageTop( array( array( 'Title', 'Group Name', array('food', 'more food!') )
	 * 							  , array( 'Title2', 'Group Name 2', array('food2', 'more food2')
	 * 							  )
	 * 					   , 'Foods'
	 * 					   );
	 * 				This would return a nav table with two table lists, one with Title and another with Title 2
	 *
	 * return	Valid html for the start of a page with a navigation table.
	 */
	function pageTop( $items, $page="", $success="" ) {
		$html = tab(2) . "<div class='container-fluid'>\n";
		$html .= tab(3) . "<div class='row-fluid'>\n";
		$html .= pageTableNav( $items, $page );
		$html .= $success ? "<div id='success' class='span4'>$success</div>" : '';
		$html .= tab(4) . "<div class='span10'>\n";
		$html .= tab(5) . "<div id='table-content'>\n";
		return $html;
	}
	/**
	 * Creates the bottom part of the html for a page with a navigation table.
	 * Should be used when pageTop is used.
	 *
	 * return 	Valid html for the end of a page with a navigation table
	 */
	function pageBot() {
		$html = tab(5) . "</div> <!-- end table-content -->\n";
		$html .= tab(4) . "</div> <!-- end span8 -->\n";
		$html .= tab(3) . "</div> <!-- end row-fluid -->\n";
		$html .= tab(2) . "</div> <!-- end container-fluid -->\n";
		return $html;
	}

	
?>
