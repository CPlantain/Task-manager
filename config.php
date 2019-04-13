<?php
session_start();

require_once 'functions/db-functions.php';
require_once 'functions/user-functions.php';
require_once 'functions/validation-functions.php';

$database = [
	'database' => 'task_manager',
	'username' => 'root',
	'password' => '',
	'connection' => 'mysql:host=localhost',
	'charset' => 'utf8',
	'options' => [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
];

$pdo = connectDatabase($database);

?>