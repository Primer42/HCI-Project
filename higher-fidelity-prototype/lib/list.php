<?php

include_once __DIR__ . '/../database/database.php';
include_once __DIR__ . '/header.php';
include_once __DIR__ . './footer.php';

/* can adjust this function that specify sorting later */
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

function echo_list_page($computerType, $humanType) {
	echo_header($humanType);
	echo_entries_table($computerType);
	echo_footer();
}

?>