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
		//Add Companies
		$name = 'Tufts University';
		$type = 'company';
		add_entry($database, $name, $type);
		add_attribute($database, $name, $type, 'Address', '419 Boston Ave, Medford MA');
		add_attribute($database, $name, $type, 'Phone', '617-628-5000');
		$name = 'Foo Inc';
		add_entry($database, $name, $type);
		add_attribute($database, $name, $type, 'Address', '123 Main Street, Cambridge, MA');
		add_attribute($database, $name, $type, 'Phone', '617-123-4567');
		$name="Real Company, No Really";
		add_entry($database, $name, $type);
		add_attribute($database, $name, $type, 'Address', 'Number Street Name, Town, MA');
		add_attribute($database, $name, $type, 'Phone', '555-555-5555');
		$name = "Blah Co";
		add_entry($database, $name, $type);
		add_attribute($database, $name, $type, 'Address', '5786 Washington Way, Arlington, MA');
		add_attribute($database, $name, $type, 'Phone', '617-819-4593');
		//Add jobs
		$name = "Teacher Assistant";
		$type = "job";
		add_entry($database, $name, $type);
		add_attribute($database, $name, $type, 'Description', 'TA for CS Class');
		add_relation($database, $name, $type, 'Tufts University', 'company', "Company");
		$name = "Foo Maker";
		add_entry($database, $name, $type);
		add_attribute($database, $name, $type, 'Description', 'Make Foo all day');
		add_relation($database, $name, $type, 'Foo Inc', 'company', "Company");
		$name = "Not a secret agent";
		add_entry($database, $name, $type);
		add_attribute($database, $name, $type, 'Description', 'Really, just a normal blue collar job');
		add_relation($database, $name, $type, 'Real Company, No Really', 'company', "Company");				
		//Add People
		$name = "John Doe";
		$type = "person";
		add_entry($database, $name, $type);
		add_attribute($database, $name, $type, 'Address', '12 Boston Ave Medford MA 02151');
		add_attribute($database, $name, $type, "Email Address", "johndoe@gmail.com ");
		$name = "Guvenc Usanmaz";
		add_entry($database, $name, $type);
		add_attribute($database, $name, $type, 'Address', '147 College Ave. Somerville MA 02166');
		add_attribute($database, $name, $type, "Email Address", "gusanmaz@hotmail.net");
		$name = "William Richard";
		add_entry($database, $name, $type);
		add_attribute($database, $name, $type, 'Address', '19 Medford Ave. Cambridge MA 02162');
		add_attribute($database, $name, $type, "Email Address", "wrichard@yahoo.edu");
		//Add notes
		$name = "Sent Resume";
		$type = "note";
		add_entry($database, $name, $type);
		add_attribute($database, $name, $type, 'text', 'Sent my Resume for this position');
		add_relation($database, $name, $type, 'Foo Maker', 'job', 'Job');
		add_relation($database, $name, $type, 'Foo Inc', 'company', 'Company');
		$name = "Ask about lecturer position";
		add_entry($database, $name, $type);
		add_attribute($database, $name, $type, 'text', 'Ask John if tehy are going to open a position for a lecturer');
		add_relation($database, $name, $type, "John Doe", 'person', "Person");
		add_relation($database, $name, $type, "Tufts University", 'company', "Company");
		
		
	}
	
	return $database;
}