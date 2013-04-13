<?php 

$pageTitle = "Welcome!";

function getPageContent() {
	return "Welcome to the Job Tracking Demo!  
<p>
This is a user interface demo for a job, network or position tracking program designed by William Richard and Guvenc Usanmaz.
<p>
Using this program, you can keep track of which people you have met, what companies they work for, and notes about them. If you are looking for a job, you can include entries about that job, who you've talked to about it, and what information you've given them (if they have your resume, a writing sample, etc.).
<p>
The key feature that allows all of this to work smoothly is the ability to refer to multiple entries at once.  For example, you can denote that a person works at a company, or that a note you wrote is regarding a specific job.
<p>
This is merely a demo, mostly to display our user interface layout and is not fully functional.  There are several features that are not present that will be present in the final program.
<p>
Click any of the navigation links above to get started.
<p>
";
}

include __DIR__ . '/../lib/template.php';

?>


