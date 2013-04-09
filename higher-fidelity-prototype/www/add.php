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


$computerType = $_GET["cType"];
$humanType = $_GET["hType"];
					
echo_header('Add ' . $humanType);
	
echo <<<ADD
<form>
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