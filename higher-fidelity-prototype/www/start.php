<?php 

$pageTitle = "Welcome!";

function getPageContent() {
	return "Welcome to the Job Tracking Demo!  
<p>
This is a user interface demo for a job, network or position tracking program designed by William Richard and Guvenc Usanmaz.
<p>
Using this program, you can keep track of which people you have met, what companies they work for, and notes about them. If you are looking for a job, you can include entries about that job, who you've talked to about it, and what information you've given them (if they have your resume, a writing sample, etc.).
<p>
The key feature that allows all of this to work smoothly is the ability to refer to multiple objects.  For example, you can denote that a person works at a company, or that a note you wrote is regarding a specific job.
<p>
This is merely a demo, mostly to display our user interface layout and is not fully functional.
<p>
Most notably, you will not be able to add your own arbitrary entries to this program.  
For example, if you want to add a job, it will have to be a pre-populated job. You will not be able to type in your own information about the job.
<p>
Also, there are a few features which are currently not present that  will be present for the interactive program.
<p>
Click any of the navigation links above to get started.
<p>
";
}

include __DIR__ . '/../lib/template.php';

?>


