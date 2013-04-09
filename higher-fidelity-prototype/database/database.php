<?php

$db_loc = __DIR__ . '/db.sqlite';
$type_map = array("company" => 1,
			"job" => 2,
			"person" => 3,
			"note" => 4);

function quote_and_escape_text($text) {
	return '"' . SQLite3::escapeString($text) . '"';
}

function exec_query($database, $query) {
	$result = $database->query($query);
	if(!$result) {
		die("Error on '" . $query . "'");
	}
	return $result;
}	

function add_entry($database, $name, $type) {
	global $type_map;
	$name = '"' . SQLite3::escapeString($name) . '"';
	$query = "INSERT OR REPLACE INTO Entries VALUES (" . join(', ', array($name, $type_map[$type])) . ")";
	exec_query($database, $query);
}

function get_entry($database, $name, $type) {
	global $type_map;
	//$query = join(' ', ["SELECT * FROM Entries WHERE name=", quote_and_escape_text($name), "AND type=", $type_map[$type]]);
	$query = join(' ', array("SELECT * FROM Entries WHERE name=", quote_and_escape_text($name)), "AND type=", $type_map[$type]);
	return exec_query($database, $query);
}

function get_all_entries_of_type($database, $type) {
	global $type_map;
	$query = join(' ', array('SELECT * FROM Entries WHERE type=', $type_map[$type]));
	return exec_query($database, $query);
}

function add_attribute($database, $entryName, $entryType, $attribKey, $attribVal) {
	global $type_map;
	$query = 'INSERT OR REPLACE INTO Attributes VALUES (' . join(', ', array(quote_and_escape_text($entryName), $type_map[$entryType], quote_and_escape_text($attribKey), quote_and_escape_text($attribVal))) . ')'; 	
	exec_query($database, $query);
}

function get_all_entry_attributes($database, $entryName, $entryType) {
	global $type_map;
	$query = join(' ', array("SELECT * FROM Attributes WHERE entryName=", quote_and_escape_text($entryName), "AND entryType=", $type_map[$entryType]));
	return exec_query($database, $query);
}

function add_relation($database, $e1name, $e1type, $e2name, $e2type, $relationName) {
	global $type_map;
	$query = 'INSERT OR REPLACE INTO Relations VALUES(' . join(', ', array(quote_and_escape_text($relationName), quote_and_escape_text($e1name), $type_map[$e1type], quote_and_escape_text($e2name), $type_map[$e2type])) . ')';
	exec_query($database, $query);
}

function get_all_entry_relations($database, $entryName, $entryType) {
	global $type_map;
	$entryName = quote_and_escape_text($entryName);
	$entryType = $type_map[$entryType];
	$query = 'SELECT * FROM Relations WHERE (e1name=' . $entryName . ' AND e1type=' . $entryType . ')'.
				'OR (e2name=' . $entryName . 'AND e2type=' . $entryType . ')';
	return exec_query($database, $query);
			
}

function open_db() {

	global $db_loc, $type_map;
		
	$add_test_data = !file_exists($db_loc);
	
	try
	{
		//create or open the database
		$database = new SQLite3($db_loc);
	}
	catch(Exception $e)
	{
		die($error);
	}
	
	$create_queries  = array(
		'CREATE TABLE IF NOT EXISTS Entries' .
			'(name TEXT, type INTEGER, PRIMARY KEY(name, type))',
		'CREATE TABLE IF NOT EXISTS Attributes' .
			'(entryName TEXT, entryType INTEGER, key TEXT NOT NULL, value TEXT NOT NULL, ' .
			'FOREIGN KEY(entryName, entryType) REFERENCES Entries(name, type), PRIMARY KEY(entryName, entryType, key))',
		'CREATE TABLE IF NOT EXISTS Relations' .
			'(name TEXT NOT NULL, e1name TEXT, e1type INTEGER, e2name TEXT, e2type INTEGER,' .
			'FOREIGN KEY(e1name, e1type) REFERENCES Entries(name, type), FOREIGN KEY(e2name, e2type) REFERENCES Entries(name, type)' .
			'PRIMARY KEY (e1name, e1type, e2name, e2type, name))'
	);
	foreach ($create_queries as $query) {
		exec_query($database, $query);
	}
	
	if($add_test_data) {
		add_entry($database, 'Tufts University', 'company');
		add_entry($database, 'Foo Inc', 'company');
		add_attribute($database, 'Tufts University', 'company', 'Address', '419 Boston Ave, Medford MA');
		add_entry($database, 'Teacher Assistant', 'job');
		add_attribute($database, 'Teacher Assistant', 'job', 'Description', 'TA for CS Class');
		add_relation($database, 'Tufts University', 'company', 'Teacher Assistant', 'job', "Jobs's Company");
		add_entry($database, 'Sent Resume', 'note');
		add_attribute($database, 'Sent Resume', 'note', 'text', 'Sent my Resume for this position');
		add_relation($database, 'Sent Resume', 'note', 'Teacher Assistant', 'job', 'Job');
		add_entry($database, 'John Doe', 'person');
		add_attribute($database, 'John Doe', 'person', 'Address', '12 Boston Ave Medford MA 02151');
	}
	
	return $database;
}