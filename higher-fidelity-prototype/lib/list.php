<?php

include_once __DIR__ . '/../database/database.php';

/* can adjust this function that specify sorting later */
function get_entries_table($type) {
	$ret = '';
	$database = open_db();
	
	$entries = get_all_entries_of_type($database, $type);
	
	
	$numCol = 2;
	//Write the table header
	$ret = $ret . "<div id=entrytable><table>
			<thead>
			<tr>
			<th>Name</th>
			<th></th>
			</tr>
			</thead>
			<tbody>
			";

	$isEven = False;
	
	while($entry = $entries->fetchArray()) {
		if($isEven){
			$ret = $ret . '<tr class="even">
					';
		} else {
			$ret = $ret . '<tr class="odd">
				';
		}
		$name = $entry['name'];
		$ret = $ret . "<td>" . $name . "</td>
				";
		$ret = $ret . "<td>
					<a href='details.php?" . http_build_query(array('name'=>$name, 'type'=>$type)) . "'><img src='./img/viewdetails.png'></a>
					<a href='confirm_delete.php?" . http_build_query(array('name'=>$name, 'type'=>$type)) . "'><img src='./img/x.png'></a>
				</td>
			";
		$ret = $ret . "</tr>
				";
		$isEven = !$isEven;
	}
	$ret = $ret . "</tbody></table></div>";
	
	$database->close();
	
	return $ret;
	
}

function get_list_page($computerType, $humanType) {
	return "<div id=listmenu>" .
			"<a href='add.php?" . http_build_query(array('cType' => $computerType, 'hType' => $humanType)) . "'> " .
			'<img src="./img/plus_64.png"> Add ' . $humanType . "</a></div>
					"
	. get_entries_table($computerType);
			

}



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


?>