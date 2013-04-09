<?php

include_once __DIR__ . '/../database/database.php';
include_once __DIR__ . '/../lib/header.php';
include_once __DIR__ . '/../lib/footer.php';

function echo_type_selection_dropdown($fieldName) {
	echo <<<TYPESELECT
<select name="$fieldName">
<option value="company">Company</option>
<option value="person">Person</option>
<option value="job">Job</option>
<option value="note">Note</option>
</select>
	
TYPESELECT;
}

function post_set($fieldName) {
	return isset($_POST[$fieldName]) and !empty($_POST[$fieldName]);
}

function handle_attribute($database, $num, $entryName, $entryType) {
	$keyName = 'k' . $num;
	$valName = 'v' . $num;
	
	if(post_set($keyName) and post_set($valName)) {
		add_attribute($database, $entryName, $entryType, $_POST[$keyName], $_POST[$valName]);
	}
}

function handle_relation($database, $num, $baseName, $baseType) {
	$otherEntryTypeField = 'r' . $num . 'type';
	$otherEntryNameField = 'r' . $num . 'entry';
	$relationNameField = 'r' . $num . 'name';
	if(post_set($otherEntryNameField) and post_set($otherEntryTypeField) and post_set($relationNameField)) {
		add_relation($database, $baseName, $baseType, $_POST[$otherEntryNameField], $_POST[$otherEntryTypeField], $_POST[$relationNameField]);
	}
}


$computerType = $_GET["cType"];
$humanType = $_GET["hType"];

if(isset($_POST['name'])) {
	$entryName = $_POST['name'];
	$database = open_db();
	add_entry($database, $entryName, $computerType);
	for($i=1; $i<=5; $i++) {
		handle_attribute($database, $i, $entryName, $computerType);
		handle_relation($database, $i, $entryName, $computerType);
	}
	
}




echo_header('Add ' . $humanType);
	
echo <<<ADD
<form name='addform' method='post' action=''>
<h1>Name: (Required)</h1> <input type="text" name="name"><br>

<h1>Attributes</h1>
<table>
	<tr>
		<th> Key </th>
		<th> Value </th>
	</tr>
	<tr>
		<td><input type="text" name="k1"> </td>
		<td><input type="text" name="v1"> </td>
	</tr>
	<tr>
		<td><input type="text" name="k2"> </td>
		<td><input type="text" name="v2"> </td>
	</tr>
		<tr>
		<td><input type="text" name="k3"> </td>
		<td><input type="text" name="v3"> </td>
	</tr>
		<tr>
		<td><input type="text" name="k4"> </td>
		<td><input type="text" name="v4"> </td>
	</tr>
	<tr>
		<td><input type="text" name="k5"> </td>
		<td><input type="text" name="v5"> </td>
	</tr>
</table>
ADD;
echo '
<h1> Relations </h1>
<table>
	<tr> <th>Other Entry Type</th> <th>Other Entry Name</th> <th> Relation Name </th> </tr>
	<tr>
		<td>
';
echo_type_selection_dropdown("r1type");
echo '
</td>
		<td><input type="text" name="r1entry"></td>
		<td><input type="text" name="r1name"></td> 
	<tr>
	<tr>
		<td>
';
		echo_type_selection_dropdown("r2type");
echo '
		</td>
		<td><input type="text" name="r2entry"></td>
		<td><input type="text" name="r2name"></td> 
	<tr>
	<tr>
		<td>
';
		echo_type_selection_dropdown("r3type");
echo '
</td>
		<td><input type="text" name="r3entry"></td>
		<td><input type="text" name="r3name"></td> 
	<tr>
	<tr>
		<td>
';
		echo_type_selection_dropdown("r4type");
echo '
		</td>
		<td><input type="text" name="r4entry"></td>
		<td><input type="text" name="r4name"></td> 
	<tr>
	<tr>
		<td>
';
		echo_type_selection_dropdown("r5type");
echo '
		</td>
		<td><input type="text" name="r5entry"></td>
		<td><input type="text" name="r5name"></td> 
	<tr>
</table>

<input type="submit" value="Submit">
<button type="button" onclick="history.go(-1);return true;"> Cancel </button>		

';
	
echo_footer();


?>