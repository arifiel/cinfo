<?php
/*
connect()
query($the_query, $bypass=0)
fetch_row($query_id = "")
get_affected_rows()
get_num_rows()
get_insert_id()
get_query_cnt()
free_result($query_id="")
close_db()
get_table_names()
get_result_fields($query_id="")
fatal_error($the_error)
compile_db_insert_string($data)
compile_db_update_string($data)
field_exists($field, $table)
*/


class db_driver {
	function db_driver(){
	global $obj,$conf;
		$this->obj['sql_host']=$conf['db']['host'];
		$this->obj['sql_user']=$conf['db']['user'];
		$this->obj['sql_pass']=$conf['db']['pass'];
		$this->obj['sql_database']=$conf['db']['base'];
	}

     var $query_id      = "";
     var $connection_id = "";
     var $query_count   = 0;
     var $record_row    = array();
     var $return_die    = 0;
     var $error         = "";
     var $failed        = 0;

    /*========================================================================*/
    // Connect to the database
    /*========================================================================*/

    function connect() {
		$this->connection_id = mysql_connect( $this->obj['sql_host'] ,
											  $this->obj['sql_user'] ,
											  $this->obj['sql_pass']
											);

        if ( !mysql_select_db($this->obj['sql_database'], $this->connection_id) )
        {
            echo ("<p>ERROR: Cannot find database ".$this->obj['sql_database'].'</p>');			return 0;
        }				return 1;
    }



    /*========================================================================*/
    // Process a query
    /*========================================================================*/

    function query($the_query, $bypass=0) {

    	//--------------------------------------
        // Change the table prefix if needed
        //--------------------------------------

        $this->query_id = mysql_query($the_query, $this->connection_id);

        if (! $this->query_id )
        {
            $this->fatal_error("mySQL query error: $the_query");
        }

        //addtocount
        $this->query_count++;

        return $this->query_id;
    }


    /*========================================================================*/
    // Fetch a row based on the last query
    /*========================================================================*/

    function fetch_row($query_id = "") {

    	if ($query_id == "")
    	{
    		$query_id = $this->query_id;
    	}

        $this->record_row = mysql_fetch_array($query_id, MYSQL_ASSOC);

        return $this->record_row;

    }

	/*========================================================================*/
    // Fetch the number of rows affected by the last query
    /*========================================================================*/

    function get_affected_rows() {
        return mysql_affected_rows($this->connection_id);
    }

    /*========================================================================*/
    // Fetch the number of rows in a result set
    /*========================================================================*/

    function get_num_rows() {
        return mysql_num_rows($this->query_id);
    }

    /*========================================================================*/
    // Fetch the last insert id from an sql autoincrement
    /*========================================================================*/

    function get_insert_id() {
        return mysql_insert_id($this->connection_id);
    }

    /*========================================================================*/
    // Return the amount of queries used
    /*========================================================================*/

    function get_query_cnt() {
        return $this->query_count;
    }

    /*========================================================================*/
    // Free the result set from mySQLs memory
    /*========================================================================*/

    function free_result($query_id="") {

   		if ($query_id == "") {
    		$query_id = $this->query_id;
    	}

    	@mysql_free_result($query_id);
    }

    /*========================================================================*/
    // Shut down the database
    /*========================================================================*/

    function close_db() {
        return mysql_close($this->connection_id);
    }

    /*========================================================================*/
    // Return an array of tables
    /*========================================================================*/

    function get_table_names() {

		$result     = mysql_list_tables($this->obj['sql_database']);
		$num_tables = @mysql_numrows($result);
		for ($i = 0; $i < $num_tables; $i++)
		{
			$tables[] = mysql_tablename($result, $i);
		}

		mysql_free_result($result);

		return $tables;
   	}

   	/*========================================================================*/
    // Return an array of fields
    /*========================================================================*/

    function get_result_fields($query_id="") {

   		if ($query_id == "")
   		{
    		$query_id = $this->query_id;
    	}

		while ($field = mysql_fetch_field($query_id))
		{
            $Fields[] = $field;
		}

		//mysql_free_result($query_id);

		return $Fields;
   	}

    /*========================================================================*/
    // Basic error handler
    /*========================================================================*/

    function fatal_error($the_error) {
    	global $INFO;


    	// Are we simply returning the error?

    	if ($this->return_die == 1)
    	{
    		$this->error    = mysql_error();
//    		$this->error_no = mysql_errno();
    		$this->failed   = 1;
    		return;
    	}

    	$the_error .= "\n\nmySQL error: ".mysql_error()."\n";
//    	$the_error .= "mySQL error code: ".$this->error_no."\n";
    	$the_error .= "Date: ".date("l dS of F Y h:i:s A");

    	$out = "&nbsp;<br><br><blockquote><b>�� ������� ��� ��������� ��-�� ������ � ���� ������ {$INFO['board_name']}.</b><br>
    		   ���������� �������� ��������, ������� <a href=\"javascript:window.location=window.location;\">�����</a>, ����
    		   ������ ��������� �����, �� �� ������ ��������� �� ������� ���������<br>e-mail: <a href='mailto:{$INFO['email_in']}?subject=SQL+Error'>{$INFO['email_in']}</a>
    		   <br>icq: 7394738

			   <br><br><b>������� ������:</b><br>
    		   <form name='mysql'><textarea rows=\"15\" cols=\"60\">".htmlspecialchars($the_error)."</textarea></form><br>�� ���������� �� ���������� ����������.</blockquote>";


#        echo($out);
//        die("");
    }

    /*========================================================================*/
    // Create an array from a multidimensional array returning formatted
    // strings ready to use in an INSERT query, saves having to manually format
    // the (INSERT INTO table) ('field', 'field', 'field') VALUES ('val', 'val')
    /*========================================================================*/

    function compile_db_insert_string($data) {

    	$field_names  = "";
		$field_values = "";

		foreach ($data as $k => $v)
		{
			//$v = preg_replace( "/'/", "\\'", $v );
			//$v = preg_replace( "/#/", "\\#", $v );
                        //$v = str_replace("\\\\", "/", $v);
                        //$v = str_replace("\\\\", "\\\\\\\\", $v);
                        $v = addslashes($v);
			$field_names  .= "$k,";
			$field_values .= "'$v',";
		}

		$field_names  = preg_replace( "/,$/" , "" , $field_names  );
		$field_values = preg_replace( "/,$/" , "" , $field_values );

		return array( 'FIELD_NAMES'  => $field_names,
					  'FIELD_VALUES' => $field_values,
					);
	}

	/*========================================================================*/
    // Create an array from a multidimensional array returning a formatted
    // string ready to use in an UPDATE query, saves having to manually format
    // the FIELD='val', FIELD='val', FIELD='val'
    /*========================================================================*/

    function compile_db_update_string($data) {

		$return_string = "";

		foreach ($data as $k => $v)
		{
			//$v = preg_replace( "/'/", "\\'", $v );
                        //$v = str_replace("\\\\", "\\\\", $v);
                        //$v = str_replace("\\\\", "\\\\\\\\", $v);
                        $v = addslashes($v);

                        $return_string .= $k . "='".$v."',";
		}

		$return_string = preg_replace( "/,$/" , "" , $return_string );

		return $return_string;
	}

	/*========================================================================*/
    // Test to see if a field exists by forcing and trapping an error.
    // It ain't pretty, but it do the job don't it, eh?
    // Posh my ass.
    // Return 1 for exists, 0 for not exists and jello for the naked guy
    // Fun fact: The number of times I spelt 'field' as 'feild'in this part: 104
    /*========================================================================*/

    function field_exists($field, $table) {

		$this->return_die = 1;
		$this->error = "";

		$this->query("SELECT COUNT($field) as count FROM $table");

		$return = 1;

		if ( $this->failed )
		{
			$return = 0;
		}

		$this->error = "";
		$this->return_die = 0;
		$this->error_no   = 0;
		$this->failed     = 0;

		return $return;
	}

} // end class
?>