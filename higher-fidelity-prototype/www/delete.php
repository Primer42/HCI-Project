<?php

include_once __DIR__ . '/../database/database.php';

$name = $_GET["name"];
$type = $_GET["type"];

$database = open_db();
delete_entry($database, $name, $type);
$database->close();

header('Location: ./' . $type . '.php');

?>