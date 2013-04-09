<?php 

require __DIR__ . '/../lib/list.php';

$pageTitle = "Notes";

function getPageContent() {
	return get_list_page('note', 'Note');
}

include __DIR__ . '/../lib/template.php';
?>