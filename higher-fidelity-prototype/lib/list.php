<?php

include_once __DIR__ . '/../database/database.php';

/* can adjust this function that specify sorting later */
function get_entries_table($type) {
	$ret = '';
	$database = open_db();
	
	$entries = get_all_entries_of_type($database, $type);
	
	
	$numCol = 2;
	//Write the table header
	$ret = $ret . "<table border='1'>
			<tr>
			<th>Name</th>
			<th>Buttons</th>
			</tr>
			";

	$isEven = False;
	
	while($entry = $entries->fetchArray()) {
		if($isEven){
			$ret = $ret . '<tr class="even">';
		} else {
			$ret = $ret . '<tr class="odd">';
		}
		$ret = $ret . "<td>" . $entry['name'] . "</td>";
		$ret = $ret .  "<td> BUTTONS GO HERE </td>";
		$ret = $ret .  "</tr>
				";
		$isEven = !$isEven;
	}
	$ret = $ret . "</table>";
	
	$database->close();
	
	return $ret;
	
}

function echo_entries_table($type) {
	$database = open_db();
	
	$entries = get_all_entries_of_type($database, $type);

	
	$numCol = 2;
	//Write the table header
	
	echo "<table border='1'>
			<tr>
			<th>Name</th>
			<th>Buttons</th>
			</tr>
			";
	
	$isEven = False;

	while($entry = $entries->fetchArray()) {
		if($isEven){
			echo '<tr class="even">';
		} else {
			echo '<tr class="odd">';
		}
		echo "<td>" . $entry['name'] . "</td>";
		echo "<td> BUTTONS GO HERE </td>";
		echo "</tr>
				";
		$isEven = !$isEven;
	}
	echo "</table>";
	
	$database->close();
}

function get_list_page($computerType, $humanType) {
	return 	<<<ADDBUTTON
	<button type="button" onclick="location.href='add.php?cType=$computerType\&hType=$humanType'">Add $humanType</button>

ADDBUTTON
	. get_entries_table($computerType);
			

}

function echo_list_page($computerType, $humanType) {
	echo_header($humanType);
	echo <<<ADDBUTTON
	<button type="button" onclick="location.href='add.php?cType=$computerType\&hType=$humanType'">Add $humanType</button>

ADDBUTTON;
	echo_entries_table($computerType);
	echo_footer();
}

?>