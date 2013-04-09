<?php 

include_once __DIR__ . '/../lib/list.php';

$pageTitle = "People";

function getPageContent() {
	return get_list_page('person', 'Person');
}

include __DIR__ . '/../lib/template.php';
?>
