<?php

function post_set($fieldName) {
	return isset($_POST[$fieldName]) and !empty($_POST[$fieldName]);
}

?>