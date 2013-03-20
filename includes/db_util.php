<?php

    require_once('db_connect.php'); // provides db_connect.  Returns a connection to my database

	/**
	 * Connects to the database, binds all variables, runs the procedure, frees the procedure statements, and closes the connection.
	 *
	 *
	 * $proc		A string of the procedure name including variables to bind.
	 * $args		An array of arguments to be bound.  If there are no arguments, it binds it to a cursor (array of arrays)
	 * $noReturn	Boolean for if this procedure should return a value.
	 *
	 * Example use: run_procedure( 'Insert_Into_Table( :id, :name )', array('4324', 'Bob'), true );;
	 * 				There would be no return value for this.
	 *
	 * 				run_procedure( 'Get_All_From_Table ( :out )' );
	 * 				Would return an oracle cursor for you to loop over.
	 *
	 * return		Either a cursor or an empty string.
	 */
	function run_procedure( $proc, $args=array(), $noReturn=false) {
		$conn = db_connect();
		preg_match_all( '/:\w+/', $proc, $id );
		$id = $id[0];
		$cursorOut = oci_new_cursor( $conn );
		$cursorIn  = oci_parse( $conn, "BEGIN $proc; END;" );
		$j = 0;
		for($i = 0; $i < sizeof($id); $i++) {
			if($noReturn || $j < sizeof($args)) {
				oci_bind_by_name( $cursorIn, $id[$i], $args[$i] );
				$j++;
			}
			else {
				oci_bind_by_name( $cursorIn, $id[$i], $cursorOut, -1, OCI_B_CURSOR );
			}

		}

		oci_execute($cursorIn);
		oci_execute($cursorOut);

		if($noReturn)
			$result = '';
		else
			oci_fetch_all( $cursorOut, $result, null, null, OCI_FETCHSTATEMENT_BY_ROW );

		oci_free_statement($cursorIn);
		oci_free_statement($cursorOut);
		oci_close($conn);
		return $result;
	}


	/**
	 * Gets one entire row from an oracle cursor resultset.
	 * The resultset came from calling the run_procedure function.
	 *
	 * $proc	The procedure resultset.
	 * $i		The row to get.  Default is set to the first row.  Useful if you only need one row.
	 *
	 * return	An entire row.
	 */
	function get_proc_row( $proc, $i=0 ) {
		return $proc[$i];
	}

	/**
	 * Converts a cursor resultset into a single array.
	 *
	 * $cursor	The cursor to change
	 *
	 * return	An array of values in the cursor.
	 */
	function cursor_to_array($cursor) {
		$arr =array();
		for($i = 0; $i < sizeof($cursor); $i++) {
			$row =  get_proc_row($cursor, $i);
			foreach($row as $val) {
				$arr[] = $val;
			}
		}
		return $arr;
	}

	/**
	 * Gets the column value of an oracle cursor resultset.
	 * It automattically converts the column name to uppercase so there are no errors.
	 *
	 * $array	The oracle cursor resultset.
	 * $col		The column to retreive.
	 *
	 * return	The single column value.
	 */
	function get_col( $array, $col ) {
		$col = strtoupper($col);
		return $array[$col];
	}

	function get_one_col( $array, $col ) {
		$col = strtoupper($col);
		$row = get_proc_row($array);
		return $row[$col];
	}
	
	
?>	
