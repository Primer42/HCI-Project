<?php

include_once '../database/database.php';

/* can adjust this function that specify sorting later */
function list_entries($type) {
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


?>