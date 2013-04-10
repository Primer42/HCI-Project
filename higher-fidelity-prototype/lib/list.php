<?php

include_once __DIR__ . '/../database/database.php';

/* can adjust this function that specify sorting later */
function get_entries_table($type) {
	$ret = '';
	$database = open_db();
	
	$entries = get_all_entries_of_type($database, $type);
	
	
	$numCol = 2;
	//Write the table header
	$ret = $ret . "<div id=entrytable><table border='1'>
			<tr>
			<th>Name</th>
			<th></th>
			</tr>
			";

	$isEven = False;
	
	while($entry = $entries->fetchArray()) {
		if($isEven){
			$ret = $ret . '<tr class="even">';
		} else {
			$ret = $ret . '<tr class="odd">';
		}
		$name = $entry['name'];
		$ret = $ret . "<td>" . $name . "</td>";
		$ret = $ret . "<td><a href='details.php?" . http_build_query(array('name'=>$name, 'type'=>$type)) . '\'"><img src="./img/viewdetails.png"></a></td>';
		$ret = $ret . "</tr>
				";
		$isEven = !$isEven;
	}
	$ret = $ret . "</table></div>";
	
	$database->close();
	
	return $ret;
	
}

function get_list_page($computerType, $humanType) {
	return "<div id=listmenu>" .
			"<a href='add.php?" . http_build_query(array('cType' => $computerType, 'hType' => $humanType)) . "'> " .
			'<img src="./img/plus_64.png"> Add ' . $humanType . "</a></div>"
	. get_entries_table($computerType);
			

}

?>