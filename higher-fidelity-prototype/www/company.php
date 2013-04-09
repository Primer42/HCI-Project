<?php 
require __DIR__ . '/../lib/list.php';

$pageTitle = "Companies";

function getPageContent() {
	return get_list_page('company', 'Company');
}

include __DIR__ . '/../lib/template.php';
?>