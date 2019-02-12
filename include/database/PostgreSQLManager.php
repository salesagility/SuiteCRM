<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2012 SugarCRM Inc.
 * 
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 * 
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more
 * details.
 * 
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 * 
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 * 
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 * 
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo. If the display of the logo is not reasonably feasible for
 * technical reasons, the Appropriate Legal Notices must display the words
 * "Powered by SugarCRM".
 ********************************************************************************/

/*********************************************************************************

* Description: This file handles the Data base functionality for the application.
* It acts as the DB abstraction layer for the application. It depends on helper classes
* which generate the necessary SQL. This sql is then passed to PEAR DB classes.
* The helper class is chosen in DBManagerFactory, which is driven by 'db_type' in 'dbconfig' under config.php.
*
* All the functions in this class will work with any bean which implements the meta interface.
* The passed bean is passed to helper class which uses these functions to generate correct sql.
*
*
* Portions created by Antonio Musarra are Copyright (C) Antonio Musarra
* All Rights Reserved.
* Contributor(s): Antonio Musarra <antonio.musarra@gmail.com>
********************************************************************************/

/**
 * PgSQL manager implementation for pgsql extension
 * 
 * @link PostgreSQL 8.4.12 Documentation http://www.postgresql.org/docs/8.4/static/index.html
 * @link PHP PostgreSQL Module http://php.net/manual/en/book.pgsql.php
 */
class PostgreSQLManager extends DBManager
{
	/**
	 * @see DBManager::$dbType
	 */
	public $dbType = 'pgsql';
	public $variant = 'PostgreSQL';
	public $dbName = 'PgSQL';
	public $label = 'LBL_PGSQL';

	/**
	 * PostgreSQL SQL Syntax
	 * 
	 * @link Chapter 4. SQL Syntax http://www.postgresql.org/docs/8.4/static/sql-syntax.html#SQL-SYNTAX-IDENTIFIERS
	 * @var array
	 */
	protected $maxNameLengths = array(
		'table' => 63,
		'column' => 63,
		'index' => 63,
		'alias' => 63
	);

	/**
	 * Data type mapping
	 * 
	 * @link Chapter 8. Data Types http://www.postgresql.org/docs/8.4/static/datatype.html
	 * @var array
	 */
	protected $type_map = array(
			'int'      => 'integer',
			'double'   => 'double precision',
			'float'    => 'double precision',
			'uint'     => 'bigint',
			'ulong'    => 'bigint',
			'long'     => 'bigint',
			'short'    => 'smallint',
			'varchar'  => 'varchar',
			'text'     => 'text',
			'longtext' => 'text',
			'longhtml' => 'text',
			'date'     => 'date',
			'enum'     => 'varchar(255)',
			'relate'   => 'varchar(255)',
			'multienum'=> 'text',
			'html'     => 'text',
			'datetime' => 'timestamp without time zone',
			'datetimecombo' => 'timestamp without time zone',
			'time'     => 'timestamp',
			'bool'     => 'smallint',
			'tinyint'  => 'smallint',
			'char'     => 'char',
			'blob'     => 'text',
			'longblob' => 'text',
			'currency' => 'decimal(26,6)',
			'decimal'  => 'decimal(20,2)',
			'decimal2' => 'decimal(30,6)',
			'id'       => 'char(36)',
			'url'      => 'varchar',
			'encrypt'  => 'varchar',
			'file'     => 'varchar',
			'decimal_tpl' => 'decimal(%d, %d)',

	);

	protected $capabilities = array(
		"affected_rows" => true,
		"select_rows" => true,
		"create_user" => true,
		"fulltext" => true,
	    "collation" => false,
	    "create_db" => true,
	    "auto_increment_sequence" => true,
	);
	
	/**
	 * (non-PHPdoc)
	 * @see DBManager::query()
	 */
	public function query($sql, $dieOnError = false, $msg = '', $suppress = false, $keepResult = false)
	{
		if(is_array($sql)) {
			return $this->queryArray($sql, $dieOnError, $msg, $suppress);
		}

		parent::countQuery($sql);
		$GLOBALS['log']->info('Query:' . $sql);
		$this->checkConnection();
		$this->query_time = microtime(true);
		$this->lastsql = $sql;
		$result = $suppress?@pg_query($this->database, $sql):pg_query($this->database, $sql);
		
		$this->query_time = microtime(true) - $this->query_time;
		$GLOBALS['log']->info('Query Execution Time:'.$this->query_time);


		if($keepResult)
			$this->lastResult = $result;

		$this->checkError($msg.' Query Failed:' . $sql . '::', $dieOnError);
		return $result;
	}

	/**
	 * (non-PHPdoc)
	 * @see DBManager::getAffectedRowCount()
	 */
	public function getAffectedRowCount($result)
	{
		return pg_affected_rows($result);
	}

	/**
	 * (non-PHPdoc)
	 * @see DBManager::getRowCount()
	 */
	public function getRowCount($result)
	{
	    return pg_num_rows($result);
	}

	/**
	 * (non-PHPdoc)
	 * @see DBManager::disconnect()
	 */
	public function disconnect()
	{
		$GLOBALS['log']->debug('Calling PgSQL::disconnect()');
		if(!empty($this->database)){
			$this->freeResult();
			pg_close($this->database);
			$this->database = null;
		}
	}

	/**
	 * (non-PHPdoc)
	 * @see DBManager::freeDbResult()
	 */
	protected function freeDbResult($dbResult)
	{
		if(!empty($dbResult))
			pg_free_result($dbResult);
	}

	/**
	 * (non-PHPdoc)
	 * @see DBManager::hasLimit()
	 */
	protected function hasLimit($sql)
	{
	    return stripos($sql, " limit ") !== false;
	}

	/**
	 * Check if SQL contains SHOW command
	 * 
	 * @param string $sql
	 * @return boolean
	 */
	protected function hasShowCommand($sql) {
		return stripos($sql, "SHOW") !== false;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see DBManager::limitQuery()
	 */
	public function limitQuery($sql, $start, $count, $dieOnError = false, $msg = '', $execute = true)
	{
		if($this->hasShowCommand($sql))
			return $this->query($sql, $dieOnError, $msg);
		
        $start = (int)$start;
        $count = (int)$count;
	    
	    if ($start < 0)
			$start = 0;
		$GLOBALS['log']->debug('Limit Query:' . $sql. ' Start: ' .$start . ' count: ' . $count);

		$sql = "$sql LIMIT $count OFFSET $start";
		$this->lastsql = $sql;

		if(!empty($GLOBALS['sugar_config']['check_query'])){
			$this->checkQuery($sql);
		}
		
		if(!$execute) {
			return $sql;
		}
		
		return $this->query($sql, $dieOnError, $msg);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see DBManager::get_columns()
	 */
	public function get_columns($tablename)
	{
		//find all unique indexes and primary keys.
		$result = $this->query(
            "SELECT ordinal_position, column_name, 
            		column_default as data_default, data_type,
					character_maximum_length as char_length, 
					numeric_precision, numeric_precision_radix as data_precision,
					numeric_scale as data_scale, is_nullable as nullable 
			FROM information_schema.columns 
			WHERE table_name = '$tablename';");
		
		$columns = array();
		
		while (($row=$this->fetchByAssoc($result)) !=null) {
			$name = strtolower($row['column_name']);
			$columns[$name]['name']=$name;
			$columns[$name]['type']=strtolower($row['data_type']);
			if ( $columns[$name]['type'] == 'number' ) {
				$columns[$name]['len']=
				( !empty($row['data_precision']) ? $row['data_precision'] : '3');
				if ( !empty($row['data_scale']) )
				$columns[$name]['len'].=','.$row['data_scale'];
			}
			elseif ( in_array($columns[$name]['type']
			,array('date','text','time')) ) {
				// do nothing
			}
			else
			$columns[$name]['len']=strtolower($row['char_length']);
			if ( !empty($row['data_default']) ) {
				$matches = array();
				$row['data_default'] = html_entity_decode($row['data_default'],ENT_QUOTES);
				if ( preg_match("/'(.*)'/i",$row['data_default'],$matches) )
				$columns[$name]['default'] = $matches[1];
			}

			$sequence_name = $this->getSequenceName($tablename, $row['column_name'], true);
			if ($this->findSequence($sequence_name))
				$columns[$name]['auto_increment'] = '1';
			elseif ( $row['nullable'] == 'NO' )
				$columns[$name]['required'] = 'true';
		}
		
		return $columns;
	}

	/**
	 * (non-PHPdoc)
	 * @see DBManager::getFieldsArray()
	 */
	public function getFieldsArray($result, $make_lower_case=false)
	{
		$field_array = array();

		if(empty($result))
			return 0;
		
		$fields = pg_num_fields($result);
		for ($i=0; $i < $fields; $i++) {
			$meta = pg_field_name($result, $i);
			if (!$meta)
				return array();

			if($make_lower_case)
				$meta = strtolower($meta);

			$field_array[] = $meta;
		}

		return $field_array;
	}

	/**
	 * (non-PHPdoc)
	 * @see DBManager::fetchRow()
	 */
	public function fetchRow($result)
	{
		if (empty($result))	
			return false;

		return pg_fetch_assoc($result);
	}

	/**
	 * (non-PHPdoc)
	 * @see DBManager::getTablesArray()
	 */
	public function getTablesArray()
	{
		$this->log->debug('Fetching table list');

		if ($this->getDatabase()) {
			$tables = array();
			$r = $this->query("SELECT
								  c.relname as Tables_in
								FROM pg_catalog.pg_class c
								     LEFT JOIN pg_catalog.pg_namespace n ON n.oid = c.relnamespace
								WHERE pg_catalog.pg_table_is_visible(c.oid)
								AND c.relkind='r'
								AND relname NOT LIKE 'pg_%'
								ORDER BY 1");
			if (!empty($r)) {
				while ($a = $this->fetchByAssoc($r)) {
					$row = array_values($a);
					$tables[]=$row[0];
				}
				return $tables;
			}
		}
		
		// no database available
		return false; 
	}

	/**
	 * (non-PHPdoc)
	 * @see DBManager::version()
	 */
	public function version()
	{
		return $this->getOne("SHOW server_version");
	}

	/**
	 * (non-PHPdoc)
	 * @see DBManager::tableExists()
	 */
	public function tableExists($tableName)
	{
		$this->log->info("tableExists: $tableName");

		if ($this->getDatabase()) {	
			$result = $this->query("SELECT n.nspname as Schema,
										  c.relname as Name,
										  CASE c.relkind 
										  WHEN 'r' THEN 'table' 
										  WHEN 'v' THEN 'view' 
										  WHEN 'i' THEN 'index' 
										  WHEN 'S' THEN 'sequence' 
										  WHEN 's' THEN 'special' 
										  END as Type,
										  pg_catalog.pg_get_userbyid(c.relowner) as Owner
										FROM pg_catalog.pg_class c
										     LEFT JOIN pg_catalog.pg_namespace n ON n.oid = c.relnamespace
										WHERE c.relkind IN ('r','v','S','')
										      AND n.nspname <> 'pg_catalog'
										      AND n.nspname <> 'information_schema'
										      AND n.nspname !~ '^pg_toast'
										  AND pg_catalog.pg_table_is_visible(c.oid)
										  AND c.relkind='r' AND c.relname LIKE '$tableName%'
										ORDER BY 1,2;");
			
			if(empty($result)) 
				return false;
			
			$row = $this->fetchByAssoc($result);
			return !empty($row);
		}

		return false;
	}

	/**
	 * (non-PHPdoc)
	 * @see DBManager::tablesLike()
	 */
	public function tablesLike($like)
	{
		if ($this->getDatabase()) {
			$tables = array();
			
			$r = $this->query("SELECT n.nspname as Schema,
										  c.relname as Name,
										  CASE c.relkind 
										  WHEN 'r' THEN 'table' 
										  WHEN 'v' THEN 'view' 
										  WHEN 'i' THEN 'index' 
										  WHEN 'S' THEN 'sequence' 
										  WHEN 's' THEN 'special' 
										  END as Type,
										  pg_catalog.pg_get_userbyid(c.relowner) as Owner
										FROM pg_catalog.pg_class c
										     LEFT JOIN pg_catalog.pg_namespace n ON n.oid = c.relnamespace
										WHERE c.relkind IN ('r','v','S','')
										      AND n.nspname <> 'pg_catalog'
										      AND n.nspname <> 'information_schema'
										      AND n.nspname !~ '^pg_toast'
										  AND pg_catalog.pg_table_is_visible(c.oid)
										  AND c.relkind='r' AND c.relname LIKE " . $this->quoted($like) . " ORDER BY 1,2;");
			if (!empty($r)) {
				while ($a = $this->fetchByAssoc($r)) {
					$row = array_values($a);
					$tables[]=$row[0];
				}
				return $tables;
			}
		}
		return false;
	}

	/**
	 * (non-PHPdoc)
	 * @see DBManager::quote()
	 */
	public function quote($string)
	{
		if(is_array($string)) {
			return $this->arrayQuote($string);
		}
		return pg_escape_string($this->getDatabase(), $this->quoteInternal($string));
	}

	/**
	 * (non-PHPdoc)
	 * @see DBManager::connect()
	 */
	public function connect(array $configOptions = null, $dieOnError = false)
	{
		global $sugar_config;

		if(is_null($configOptions))
			$configOptions = $sugar_config['dbconfig'];

		if ($this->getOption('persistent')) {
			$this->database = @pg_pconnect(
				"host=".$configOptions['db_host_name'] .
				" user=".$configOptions['db_user_name'] .
				" password=".$configOptions['db_password'].
				" dbname=".$configOptions['db_name']
				);
		}

		if (!$this->database) {
			$this->database = @pg_connect(
				"host=".$configOptions['db_host_name'] .
				" user=".$configOptions['db_user_name'] .
				" password=".$configOptions['db_password'].
				" dbname=".$configOptions['db_name']
				);
			if(empty($this->database)) {
				$GLOBALS['log']->fatal("Could not connect to server ".$configOptions['db_host_name']." as ".$configOptions['db_user_name']);
				if($dieOnError) {
					if(isset($GLOBALS['app_strings']['ERR_NO_DB'])) {
						sugar_die($GLOBALS['app_strings']['ERR_NO_DB']);
					} else {
						sugar_die("Could not connect to the database. Please refer to sugarcrm.log for details.");
					}
				} else {
					return false;
				}
			}
			// Do not pass connection information because we have not connected yet
			if($this->database  && $this->getOption('persistent')){
				$_SESSION['administrator_error'] = "<b>Severe Performance Degradation: Persistent Database Connections "
					. "not working.  Please set \$sugar_config['dbconfigoption']['persistent'] to false "
					. "in your config.php file</b>";
			}
		}
		
		// Set Client encoding
		pg_set_client_encoding($this->database, "UNICODE");

		if(!$this->checkError('Could Not Connect:', $dieOnError))
			$GLOBALS['log']->info("connected to db");
		
		$this->connectOptions = $configOptions;
		$GLOBALS['log']->info("Connect:".$this->database);
		
		return true;
	}

	/**
	 * (non-PHPdoc)
	 * @see DBManager::repairTableParams()
	 */
	public function repairTableParams($tablename, $fielddefs, $indices, $execute = true, $engine = null)
	{
        //Modules with names close to 63 characters may have index names over 63 characters, we need to clean them
        foreach ($indices as $key => $value) {
            $indices[$key]['name'] = $this->getValidDBName($value['name'], true, 'index');
        }
        return parent::repairTableParams($tablename,$fielddefs,$indices,$execute,$engine);
	}

	
	/**
	 * (non-PHPdoc)
	 * @see DBManager::convert()
	 * @link 9.9. Date/Time Functions and Operators http://www.postgresql.org/docs/8.4/static/functions-datetime.html
	 */
	public function convert($string, $type, array $additional_parameters = array())
	{
	    if (!empty($additional_parameters)) {
            $additional_parameters_string = ','.implode(',',$additional_parameters);
        } else {
            $additional_parameters_string = '';
        }
        $all_parameters = $additional_parameters;
        if(is_array($string)) {
            $all_parameters = array_merge($string, $all_parameters);
        } elseif (!is_null($string)) {
            array_unshift($all_parameters, $string);
        }
        $all_strings = implode(',', $all_parameters);
        
		switch (strtolower($type)) {
            case 'date':
                return "TO_DATE($string,'YYYY-MM-DD')";
            case 'time':
                return "TO_TIMESTAMP($string,'HH24:MI:SS')";
            case 'datetime':
                return "TO_TIMESTAMP($string,'YYYY-MM-DD HH24:MI:SS')";
			case 'today':
				return "CURRENT_DATE";
			case 'left':
				return "SUBSTR($string$additional_parameters_string)";
			case 'date_format':
				if(empty($additional_parameters)) {
					return "TO_CHAR($string,'YYYY-MM-DD')";
				} else {
					$format = $additional_parameters[0];
					if($format[0] != "'") {
						$format = $this->quoted($format);
					}
					return "TO_CHAR($string,$format)";
				}
			case 'time_format':
				if(empty($additional_parameters_string)) {
					$additional_parameters_string = ",'HH24:MI:SS'";
				}
				return "TO_CHAR($string".$additional_parameters_string.")";
				
			case 'ifnull':
				if(empty($additional_parameters) && !strstr($all_strings, ",")) {
					$all_strings .= ",''";
				}
				return "COALESCE($all_strings)";
			case 'concat':
				$pattern = "/(,'\&nbsp;',)|(,'\s',)/";
				$replacement = " || ' ' || ";
				return "(" . preg_replace($pattern, $replacement, $all_strings) . ")";
			case 'quarter':
					return "TO_CHAR($string, 'Q')";
			case "length":
					return "LENGTH($string)";
			case 'month':
					return "TO_CHAR($string, 'MM')";
			case 'add_date':
				switch(strtolower($additional_parameters[1])) {
					case 'quarter':
						$additional_parameters[0] = (int)$additional_parameters[0] * 3;
						return "(date $string + INTERVAL '{$additional_parameters[0]} month')";
					default:
						return "(date $string + INTERVAL '{$additional_parameters[0]} {$additional_parameters[1]}')";
				}
			case 'add_time':
					return "(date $string + INTERVAL + time '{$additional_parameters[0]}:{$additional_parameters[1]}')";
		}

		return $string;
	}

	/**
	 * (non-PHPdoc)
	 * @see DBManager::fromConvert()
	 */
	public function fromConvert($string, $type)
	{
		return $string;
	}

	/**
	 * (non-PHPdoc)
	 * @see DBManager::createTableSQL()
	 */
	public function createTableSQL(SugarBean $bean)
	{
		$tablename = $bean->getTableName();
		$fieldDefs = $bean->getFieldDefinitions();
		$indices   = $bean->getIndices();
		return $this->createTableSQLParams($tablename, $fieldDefs, $indices);
	}

	/**
	 * (non-PHPdoc)
	 * @see DBManager::createTableSQLParams()
	 */
	public function createTableSQLParams($tablename, $fieldDefs, $indices)
	{
		$columns = $this->columnSQLRep($fieldDefs, false, $tablename);
		if (empty($columns))
			return false;

		$sql = "CREATE TABLE $tablename ($columns);";
		return $sql;
	}

	/**
	 * (non-PHPdoc)
	 * @see DBManager::oneColumnSQLRep()
	 */
	protected function oneColumnSQLRep($fieldDef, $ignoreRequired = false, $table = '', $return_as_array = false)
	{
		// always return as array for post-processing
		$ref = parent::oneColumnSQLRep($fieldDef, $ignoreRequired, $table, true);

		if ( isset($ref['default']) &&
            in_array($ref['colBaseType'], array('text', 'blob', 'longtext', 'longblob')))
			    $ref['default'] = '';

		if ( $return_as_array )
			return $ref;
		else
			return "{$ref['name']} {$ref['colType']} {$ref['default']} {$ref['required']} {$ref['auto_increment']}";
	}
	
	/**
	 * (non-PHPdoc)
	 * @see DBManager::changeColumnSQL()
	 */
	protected function changeColumnSQL($tablename, $fieldDefs, $action, $ignoreRequired = false)
	{
		$columns = array();
		$columnsAlter = array();
		
		if ($this->isFieldArray($fieldDefs)){
			$GLOBALS['log']->debug("is fieldArray");
			foreach ($fieldDefs as $def){
				if ($action == 'drop') {
					$columnsAlter[] = $def['name'];
				} elseif ($action == "add") {
					$columns = $this->oneColumnSQLRep($def, $ignoreRequired, "", true);
					$columnsAlter[] = $columns['name'] . " " . $columns['colType'];
				} else {
					$columns = $this->oneColumnSQLRep($def, $ignoreRequired, "", true);
					$columnsAlter[] = $columns['name'] . " TYPE " .  $columns['colType'];
				
					if (isset($columns['default']) && strlen($columns['default']) > 0) {
						$columnsAlter[] = $columns['name'] . " SET " . $columns['default'];
					}
					
					if ($columns['required'] === 'NOT NULL') {
						$columnsAlter[] = $columns['name'] . " SET " . $columns['required'];
					}
				}
			}
		} else {
			if ($action == 'drop') {
				$columnsAlter[] = $fieldDefs['name'];
			} elseif ($action == 'add') {
				$columns = $this->oneColumnSQLRep($fieldDefs, $ignoreRequired, "", true);
				$columnsAlter[] = $columns['name'] . " " . $columns['colType'];
			} else {
				$columns = $this->oneColumnSQLRep($fieldDefs, $ignoreRequired, "", true);
				$columnsAlter[] = $columns['name'] . " TYPE " .  $columns['colType'];
				
				if (isset($columns['default']) && strlen($columns['default']) > 0) {
					$columnsAlter[] = "ALTER COLUMN " . $columns['name'] . " SET " . $columns['default'];
				}
				
				if ($columns['required'] === 'NOT NULL') {
					$columnsAlter[] = "ALTER COLUMN " . $columns['name'] . " SET " . $columns['required'];
				}
			}
		}
		
		if (strtoupper($action) == 'MODIFY') {
			$action = "ALTER";
		}
		
		return "ALTER TABLE $tablename $action COLUMN ".implode(",", $columnsAlter);
	}


	/**
	 * (non-PHPdoc)
	 * @see DBManager::setAutoIncrement()
	 */
	public function setAutoIncrement($table, $field_name)
	{
		$this->deleteAutoIncrement($table, $field_name);
		$this->query("CREATE SEQUENCE  {$this->getSequenceName($table, $field_name)} 
			INCREMENT BY 1 NO MAXVALUE START WITH 1");
		return "";
	}

	/**
	 * (non-PHPdoc)
	 * @see DBHelper::deleteAutoIncrement()
	 */
	public function deleteAutoIncrement($table, $field_name) {
		$sequence_name = $this->getSequenceName($table, $field_name);
		if ($this->findSequence($sequence_name)) {
			$this->query('DROP SEQUENCE ' .$sequence_name);
		}
	}

	/**
	 * (non-PHPdoc)
	 * @see DBManager::setAutoIncrementStart()
	 */
	public function setAutoIncrementStart($table, $field_name, $start_value)
	{
		$start_value = (int)$start_value;
		return $this->query( "ALTER SEQUENCE " . 
			$this->getSequenceName($table, $field_name, false) . 
			" RESTART WITH $start_value;");
	}
	
	/**
	 * (non-PHPdoc)
	 * @see DBManager::getAutoIncrement()
	 */
	public function getAutoIncrement($table, $field_name)
	{
		return $this->getOne("SELECT nextval('".$this->getSequenceName($table, $field_name) . "')");
	}

	/**
	 * (non-PHPdoc)
	 * @see DBManager::getAutoIncrementSQL()
	 */
	public function getAutoIncrementSQL($table, $field_name)
	{
		return "nextval('".$this->getSequenceName($table, $field_name) . "')";
	}
	
	/**
	 * (non-PHPdoc)
	 * @see DBManager::get_indices()
	 */
	public function get_indices($tablename)
	{
		//find all unique indexes and primary keys.
		$result = $this->query("SELECT c2.relname, i.indisprimary, 
										i.indisunique, i.indisclustered,
										i.indisvalid, pg_catalog.pg_get_indexdef(i.indexrelid, 1, true), 
										pg_catalog.pg_get_indexdef(i.indexrelid, 0, true), c2.reltablespace
									FROM 
										pg_catalog.pg_class c, 
										pg_catalog.pg_class c2, 
										pg_catalog.pg_index i
									WHERE 
										c.oid = i.indrelid AND 
										i.indexrelid = c2.oid AND 
										c.relname='$tablename'
									ORDER BY i.indisprimary DESC, i.indisunique DESC, c2.relname");

		$indices = array();
		while (($row=$this->fetchByAssoc($result)) !=null) {
			$index_type='index';
			if ($row['indisprimary'] =='t') {
				$index_type='primary';
			}
			elseif ( $row['indisunique'] == 't' ) {
				$index_type='unique';
			}
			$name = strtolower($row['relname']);
			$indices[$name]['name']=$name;
			$indices[$name]['type']=$index_type;
			$indices[$name]['fields'][]=strtolower($row['pg_get_indexdef']);
		}

		return $indices;
	}

	/**
	 * (non-PHPdoc)
	 * @see DBManager::add_drop_constraint()
	 */
	public function add_drop_constraint($table, $definition, $drop = false)
	{
        $type         = $definition['type'];
        $fields       = is_array($definition['fields'])?implode(',',$definition['fields']):$definition['fields'];
        $name         = $this->getValidDBName($definition['name'], true, 'index');
        $sql          = '';
		
		switch ($type){
			// generic indices
			case 'index':
			case 'alternate_key':
			case 'clustered':
				if ($drop)
					$sql = "DROP INDEX IF EXISTS {$name} ;";
				else
					$sql = "CREATE INDEX {$name} ON {$table} ({$fields});";
				break;
			// constraints as indices
			case 'unique':
				if ($drop)
					$sql = "ALTER TABLE {$table} DROP UNIQUE ({$fields});";
				else
					$sql = "ALTER TABLE {$table} ADD CONSTRAINT {$name} UNIQUE ({$fields});";
				break;
			case 'primary':
				if ($drop)
					$sql = "ALTER TABLE {$table} DROP PRIMARY KEY CASCADE;";
				else
					$sql = "ALTER TABLE {$table} ADD CONSTRAINT {$name} PRIMARY KEY ({$fields});";
				break;
			case 'foreign':
				if ($drop)
					$sql = "ALTER TABLE {$table} DROP FOREIGN KEY ({$fields});";
				else
					$sql = "ALTER TABLE {$table} ADD CONSTRAINT {$name} FOREIGN KEY ({$fields}) REFERENCES {$definition['foreignTable']}({$definition['foreignField']});";
				break;
        	case 'fulltext':
                if($drop) {
                    $sql = "DROP INDEX {$name}";
                } else {
                   $sql = "CREATE INDEX {$name} ON {$table} USING GIN({$fields})";
                }
                break;
		}
		return $sql;
	}

	/**
	 * (non-PHPdoc)
	 * @see DBManager::fetchOne()
	 */
	public function fetchOne($sql, $dieOnError = false, $msg = '', $suppress = false)
	{
		if(stripos($sql, ' LIMIT ') === false) {
			$sql .= " LIMIT 1";
		}
		return parent::fetchOne($sql, $dieOnError, $msg, $suppress);
	}

	/**
	 * (non-PHPdoc)
	 * @see DBManager::full_text_indexing_installed()
	 */
	public function full_text_indexing_installed($dbname = null)
	{
		return true;
	}

	/**
	 * (non-PHPdoc)
	 * @see DBManager::massageFieldDef()
	 */
	public function massageFieldDef(&$fieldDef, $tablename)
	{
		parent::massageFieldDef($fieldDef,$tablename);

        if ($fieldDef['name'] == 'id')
            $fieldDef['required'] = 'true';
        if ($fieldDef['dbType'] == 'decimal')
            $fieldDef['len'] = '20,2';
        if ($fieldDef['dbType'] == 'decimal2')
            $fieldDef['len'] = '30,6';
        if ($fieldDef['dbType'] == 'double')
            $fieldDef['len'] = '30,10';
        if ($fieldDef['dbType'] == 'float')
            $fieldDef['len'] = '30,6';
        if ($fieldDef['dbType'] == 'uint')
            $fieldDef['len'] = '15';
        if ($fieldDef['dbType'] == 'ulong')
            $fieldDef['len'] = '38';
        if ($fieldDef['dbType'] == 'long')
            $fieldDef['len'] = '38';
        if ($fieldDef['dbType'] == 'bool')
            $fieldDef['len'] = '1';
        if ($fieldDef['dbType'] == 'id')
            $fieldDef['len'] = '36';
        if ($fieldDef['dbType'] == 'currency')
            $fieldDef['len'] = '26,6';
        if ($fieldDef['dbType'] == 'short')
            $fieldDef['len'] = '3';
        if ($fieldDef['dbType'] == 'tinyint')
            $fieldDef['len'] = '3';
        if ($fieldDef['dbType'] == 'int')
            $fieldDef['len'] = '3';
        if ($fieldDef['type'] == 'int' && empty($fieldDef['len']) )
            $fieldDef['len'] = '';
        if ($fieldDef['dbType'] == 'enum' && empty($fieldDef['len']))
            $fieldDef['len'] = '255';
        if ($fieldDef['type'] == 'varchar2' && empty($fieldDef['len']) )
            $fieldDef['len'] = '255';
	}
	
	/**
	 * (non-PHPdoc)
	 * @see DBManager::dropTableNameSQL()
	 */
	public function dropTableNameSQL($name)
	{
		return "DROP TABLE IF EXISTS ${name};";
	}
	
	/**
	 * (non-PHPdoc)
	 * @see DBManager::truncateTableSQL()
	 */
	public function truncateTableSQL($name)
	{
		return "TRUNCATE TABLE $name";
	}
	
	/**
	 * (non-PHPdoc)
	 * @see DBManager::getDefaultCollation()
	 */
	public function getDefaultCollation()
	{
		$q = "SHOW lc_collate";
		$r = $this->query($q);
		$res = array();
		while($a = $this->fetchByAssoc($r)) {
			$res[] = $a['lc_collate'];
		}
		return $res[0];
	}
	
	/**
	 * (non-PHPdoc)
	 * @see DBManager::getCollationList()
	 */
	public function getCollationList()
	{
		$q = "SHOW lc_collate";
		$r = $this->query($q);
		$res = array();
		while($a = $this->fetchByAssoc($r)) {
			$res[] = $a['lc_collate'];
		}
		return $res;
	}

	/**
	 * (non-PHPdoc)
	 * @see DBManager::renameColumnSQL()
	 */
	public function renameColumnSQL($tablename, $column, $newname)
	{
		return "ALTER TABLE $tablename RENAME COLUMN $column TO $newname";
	}

	/**
	 * (non-PHPdoc)
	 * @see DBManager::renameIndexDefs()
	 */
	public function renameIndexDefs($old_definition, $new_definition, $table_name)
	{
		$old_definition['name'] = $this->getValidDBName($old_definition['name'], true, 'index');
		$new_definition['name'] = $this->getValidDBName($new_definition['name'], true, 'index');
		return "ALTER INDEX {$old_definition['name']} RENAME TO {$new_definition['name']}";
	    }
	
	/**
	 * (non-PHPdoc)
	 * @see DBManager::emptyValue()
	 */
	public function emptyValue($type)
	{
	    $ctype = $this->getColumnType($type);
        if($ctype == "datetime") {
            return $this->convert($this->quoted("1970-01-01 00:00:00"), "datetime");
        }
        if($ctype == "date") {
            return $this->convert($this->quoted("1970-01-01"), "date");
        }
        if($ctype == "time") {
            return $this->convert($this->quoted("00:00:00"), "time");
        }
		return parent::emptyValue($type);
	}

	/**
	 * (non-PHPdoc)
	 * @see DBManager::lastDbError()
	 */
	public function lastDbError()
	{
		if($this->database) {
		    if(pg_errormessage($this->database)) {
			    return "PgSQL error ".pg_errormessage($this->database);
		    }
		} else {
			$err =  pg_errormessage();
			if($err) {
			    return $err;
			}
		}
        return false;
    }

	/**
	 * Quote PgSQL search term
	 * @param string $term
	 */
	protected function quoteTerm($term)
	{
		if(strpos($term, ' ') !== false) {
			return '"'.$term.'"';
		}
		return $term;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see DBManager::getFulltextQuery()
	 */
	public function getFulltextQuery($field, $terms, $must_terms = array(), $exclude_terms = array())
	{
        $condition = $or_condition = array();
        foreach($must_terms as $term) {
            $condition[] = $this->quoteTerm($term);
        }

        foreach($terms as $term) {
            $or_condition[] = $this->quoteTerm($term);
        }

        if(!empty($or_condition)) {
            $condition[] = " & (".join(" | ", $or_condition).")";
        }

        foreach($exclude_terms as $term) {
            $condition[] = "~".$this->quoteTerm($term);
        }
        
        $condition = $this->quoted(join(" & ",$condition));
		return "to_tsvector($field) @@ to_tsquery($condition)";
	}

	/**
	 * Get list of all defined charsets
	 * @return array
	 */
	protected function getCharsetInfo()
	{
		$charsets = array();
		$res = $this->query("SHOW lc_ctype");
		while($row = $this->fetchByAssoc($res)) {
			$charsets['character_set_system'] = $row['lc_ctype'];
		}
		return $charsets;
	}

	/**
	 * (non-PHPdoc)
	 * @see DBManager::getDbInfo()
	 */
	public function getDbInfo()
	{
		$charsets = $this->getCharsetInfo();
		$charset_str = array();
		foreach($charsets as $name => $value) {
			$charset_str[] = "$name = $value";
		}
		return array(
			"PgSQL Version" => @pg_version($this->database),
			"PgSQL Host Info" => @pg_host($this->database),
			"PgSQL Server Info" => $this->getOne("SELECT VERSION()"),
			"PgSQL Client Encoding" =>  @pg_client_encoding($this->database),
			"PgSQL Character Set Settings" => join(", ", $charset_str),
		);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see DBManager::validateQuery()
	 */
	public function validateQuery($query)
	{
		$res = $this->query("EXPLAIN $query");
		return !empty($res);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see DBManager::dbExists()
	 */
	public function dbExists($dbname)
	{
		$db = $this->getOne("SELECT d.datname as Name,
		       pg_catalog.pg_get_userbyid(d.datdba) as Owner,
		       pg_catalog.pg_encoding_to_char(d.encoding) as Encoding,
		       d.datcollate as Collation,
		       d.datctype as Ctype,
		       pg_catalog.array_to_string(d.datacl, E'\n') AS ACL
		FROM pg_catalog.pg_database d WHERE d.datname=". $this->quoted($dbname) . " ORDER BY 1");
		return !empty($db);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see DBManager::userExists()
	 */
	public function userExists($username)
	{
		$user = $this->getOne("SELECT r.rolname, r.rolsuper, r.rolinherit,
								  r.rolcreaterole, r.rolcreatedb, r.rolcanlogin,
								  r.rolconnlimit,
								  ARRAY(SELECT b.rolname
								        FROM pg_catalog.pg_auth_members m
								        JOIN pg_catalog.pg_roles b ON (m.roleid = b.oid)
								        WHERE m.member = r.oid) as memberof
								FROM pg_catalog.pg_roles r WHERE r.rolname=".$this->quoted($username) . "
								ORDER BY 1;");

		return !empty($user);
	}

	/**
	 * (non-PHPdoc)
	 * @see DBManager::createDbUser()
	 */
	public function createDbUser($database_name, $host_name, $user, $password)
	{
		$qpassword = $this->quote($password);
		$this->query("CREATE USER $user WITH LOGIN ENCRYPTED PASSWORD '{$qpassword}';");
		$this->query("ALTER DATABASE $database_name OWNER TO $user");
	}
	
	/**
	 * (non-PHPdoc)
	 * @see DBManager::createDatabase()
	 */
	public function createDatabase($dbname)
	{
		$this->query("CREATE DATABASE $dbname WITH 
						ENCODING='UTF8'", true) ; 
//						LC_COLLATE='en_US.UTF-8' 
//						LC_CTYPE='en_US.UTF-8'", true);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see DBManager::dropDatabase()
	 */
	public function dropDatabase($dbname)
	{
		return $this->query("DROP DATABASE IF EXISTS $dbname", true);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see DBManager::valid()
	 */
	public function valid()
	{
		return function_exists("pg_connect");
	}

	/**
	 * (non-PHPdoc)
	 * @see DBManager::canInstall()
	 */
	public function canInstall()
	{
		$db_version = $this->version();
		$GLOBALS['log']->info("PostgreSQL Server Info:" . $db_version);
		
		if(empty($db_version)) {
			return array('ERR_DB_VERSION_FAILURE');
		}
				
		if(version_compare($db_version, '8.4') < 0) {
			return array('ERR_DB_PGSQL_VERSION', $db_version);
		}
		return true;
	}

	/**
	 * (non-PHPdoc)
	 * @see DBManager::installConfig()
	 */
	public function installConfig()
	{
		return array(
			'LBL_DBCONFIG_MSG3' =>  array(
				"setup_db_database_name" => array("label" => 'LBL_DBCONF_DB_NAME', "required" => true),
			),
			'LBL_DBCONFIG_MSG2' =>  array(
				"setup_db_host_name" => array("label" => 'LBL_DBCONF_HOST_NAME', "required" => true),
			),
			'LBL_DBCONF_TITLE_USER_INFO' => array(),
			'LBL_DBCONFIG_B_MSG1' => array(
				"setup_db_admin_user_name" => array("label" => 'LBL_DBCONF_DB_ADMIN_USER', "required" => true),
				"setup_db_admin_password" => array("label" => 'LBL_DBCONF_DB_ADMIN_PASSWORD', "type" => "password"),
			)
		);
	}

	
	/**
	 * Used to generate SEQUENCE names. This could also be used
	 * by an upgrade script to upgrading sequences.  It will take in a name
	 * and md5 the name and only return $length characters.
	 *
	 * @param string $name - name of the orignal sequence
	 * @param int $length - length of the desired md5 sequence.
	 * @return string
	 */
	protected function generateMD5Name($name, $length = 6)
	{
		$md5_name = md5($name);
		return substr($md5_name, 0, $length);
	}

	/**
	 * Generate an PostgreSQL SEQUENCE name. If the length of the sequence names exceeds a certain amount
	 * we will use an md5 of the field name to shorten.
	 *
	 * @param string $table
	 * @param string $field_name
	 * @param boolean $upper_case
	 * @return string
	 */
	protected function getSequenceName($table, $field_name, $upper_case = false)
	{
		$sequence_name = $table. '_' .$field_name . '_seq';
		
		if(strlen($sequence_name) > 63)
			$sequence_name = $table. '_' . $this->generateMD5Name($field_name) . '_seq';
		if($upper_case)
			$sequence_name = strtoupper($sequence_name);
		
		return $sequence_name;
	}

	/**
	 * Returns true if the sequence name given is found
	 *
	 * @param  string $name
	 * @return bool   true if the sequence is found, false otherwise
	 */
	protected function findSequence($name)
	{
		static $sequences;

		if ( !is_array($sequences) ) {
			$result = $this->query("SELECT relname as sequence_name FROM pg_class
									WHERE relkind = 'S' AND relnamespace 
									IN ( SELECT oid FROM pg_namespace 
									WHERE nspname NOT LIKE 'pg_%' AND nspname != 'information_schema')");
			while ( $row = $this->fetchByAssoc($result) )
			$sequences[] = $row['sequence_name'];
		}
		if ( !is_array($sequences) )
			return false;
		else
			return in_array($name,$sequences);
	}

	/**
	 * (non-PHPdoc)
	 * @see DBManager::getFromDummyTable()
	 */
	public function getFromDummyTable()
	{
		return "";
	}

	/**
	 * (non-PHPdoc)
	 * @see DBManager::getGuidSQL()
	 */
	public function getGuidSQL()
	{
		return "uuid_generate_v1()";
	}
	
	/**
	 * (non-PHPdoc)
	 * @see DBManager::quoteIdentifier()
	 */
	public function quoteIdentifier($string)
	{
		return '"'.$string.'"';
	}
	
}
