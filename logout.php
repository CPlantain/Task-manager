<?php
session_start();

unset($_SESSION['user']);

if($_COOKIE['UserHash']){
	setcookie('UserHash', '', time() - 3600);
}

session_destroy();

header("Location: /login-form.php");
?>
