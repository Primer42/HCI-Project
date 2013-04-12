<?php

include_once __DIR__ . '/../database/database.php';
include_once __DIR__ . '/../lib/list.php';

$name= $_GET["name"];
$type = $_GET["type"];

$pageTitle = "Details of " . $name;

function getPageContent() {
	global $name, $type;
	
	$database = open_db();
	
	$attribs = get_all_entry_attributes($database, $name, $type);
	$relations = get_all_entry_relations($database, $name, $type);
	
	$ret = '<h1>Details for ' . $name . '</h1>
			<h2>Attributes</h2>' . get_attrib_table($attribs) . '<br>
					<h2>Relations</h2>'.
			get_relation_table($relations, $name, $type) . 
			'<br><button type="button" onclick="history.go(-1);return true;"> Go Back </button>';
	
	$database->close();
	
	return $ret;
	
	
}

include __DIR__ . '/../lib/template.php';

?>