<?php

include_once __DIR__ . '/../database/database.php';
include_once __DIR__ . '/../lib/list.php';



$name= $_GET["name"];
$type = $_GET["type"];

$pageTitle = "Do you want to delete " . $name;

function getPageContent() {
	global $name, $type;
	
	$database = open_db();
	
	$attribs = get_all_entry_attributes($database, $name, $type);
	$relations = get_all_entry_relations($database, $name, $type);
	
	$ret = "<h1> Do you want to delet " . $name . "?</h1>
			<h2> The following attributes will also be deleted </h2><br>" .
			get_attrib_table($attribs) . "<br> 
			<h2>The folowing relations will also be deleted</h2><br>" .
			get_relation_table($relations, $name, $type) . 
			'<br> <button type="button" onclick="location.href=\'./delete.php?' . http_build_query(array('name'=>$name, 'type'=>$type)) . '\'">DELETE CANNOT UNDO</button>
					<button type="button" onclick="history.go(-1);return true;"> Cancel </button>';
	
	$database->close();
	
	return $ret;

}

include __DIR__ . '/../lib/template.php';

?>
