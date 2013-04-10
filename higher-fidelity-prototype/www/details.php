<?php

include_once __DIR__ . '/../database/database.php';


$name= $_GET["name"];
$type = $_GET["type"];

function get_attrib_table($attribs) {
	$numCol = 2;
	$ret = "<table>
			<thead>
			<tr>
			<th>Key</th>
			<th>Value</th>
			</tr></thead><tbody>
			"; 
	
	$isEven = False;
	
	while($attrib = $attribs->fetchArray()) {
		if($isEven) {
			$ret = $ret . '<tr class="even">';
		} else {
			$ret = $ret . '<tr class="odd">';
		}
		
		$ret = $ret . "<td>" . $attrib['key'] . "</td><td>" . $attrib['value'] . "</td></tr>";
		
		$isEven = !$isEven;
	}
	$ret = $ret . "</tbody></table>";

	return $ret;
}

function get_relation_table($relations, $ourName, $ourType) {
	global $type_map;
	$numCol = 2;
	$ret = "<table>
			<thead>
			<tr>
			<th>Relation</th>
			<th>Entry</th>
			</tr></thead><tbody>
			";

	$isEven = False;
	
	while($relation = $relations->fetchArray()) {
		if($isEven) {
			$ret = $ret . '<tr class="even">
					';
		} else {
			$ret = $ret . '<tr class="odd">
					';
		}
		
		$ret = $ret . "<td>" . $relation['name'] . "</td>
				";
		$entryName = '';
		$entryType = '';
		if($relation['e1name'] == $ourName and $relation['e1type'] == $type_map[$ourType]) {
			$entryName = $relation['e2name'];
			$entryType = array_search($relation['e2type'], $type_map);	
		} else {
			$entryName = $relation['e1name'];
			$entryType = array_search($relation['e1type'], $type_map);
		}
		$ret = $ret . "<td><a href='details.php?" . http_build_query(array('name'=>$entryName, 'type'=>$entryType)) . "'>$entryName</a></td>
		";
		$isEven = !$isEven;
		$ret = $ret . "</tr>
				";
	}
	$ret = $ret . "</tbody></table>";
	
	return $ret;
}

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