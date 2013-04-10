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

<ul>
<li><a href="./start.php"> <img src="./img/jobtracker.png"><br>JOB TRACKER</b></a></li>
<li><a href="./company.php"> <img src="./img/company.png"><br>Companies</a></li>
<li><a href="./job.php"> <img src="./img/jobs.png"><br>Jobs</a></li>
<li><a href="./person.php"> <img src="./img/people.png"><br>People</a></li>
<li><a href="./note.php"> <img src="./img/notes.png"><br>Notes</a></li>
</ul>

</div>

<?php echo getPageContent();?>


</body>
</html>
