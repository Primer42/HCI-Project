<!DOCTYPE html>
<html>
<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
<title>
<?php echo $pageTitle;?>
</title>
</meta>
<link rel="stylesheet" type="text/css" href="./css/stylesheet.css">
</head>

<body>

<div id="header">
<table>
<tr>
<td><h3><img src="./img/jobtracker.png"> <br>JOB TRACKER 5000</h3> </td>
<td><a href="./company.php"> <img src="./img/company.png"> <br>Companies</a></td>
<td><a href="./job.php"> <img src="./img/jobs.png"> <br>Jobs</a></td>
<td><a href="./person.php"> <img src="./img/people.png"> <br>People</a></td>
<td><a href="./note.php"> <img src="./img/notes.png"> <br>Notes</a></td>
</tr>
</table>
</div>

<br>

<?php echo getPageContent();?>


</body>
</html>
