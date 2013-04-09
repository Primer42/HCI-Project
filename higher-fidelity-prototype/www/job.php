<?php 

require __DIR__ . '/../lib/list.php';

$pageTitle = "Jobs";

function getPageContent() {
	return get_list_page('job', 'Job');
}

include __DIR__ . '/../lib/template.php';

?>
