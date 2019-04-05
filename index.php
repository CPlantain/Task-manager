<?php
/*session_start();

if($_SESSION['user']){
	header('Location: /list.php');
	exit;
} 

else if($_COOKIE['UserHash']){

	$hash = $_COOKIE['UserHash'];

	$pdo = new PDO("mysql:host=localhost;dbname=task_manager;charset=utf8", 'root', '');

	$sql = 'SELECT * FROM users WHERE password=:password';
	$statement->BindValue('password', $hash, PDO::PARAM_STR);
	$statement->execute();
	$user = $statement->fetch(PDO::FETCH_ASSOC);

	if(!$user){
		$errorMessage = 'Пользователя с такими данными не найдено. Пожалуйста, очистите файлы cookie и попробуйте ещё раз.';
		require 'errors.php';
		exit;
	} else {
		$_SESSION['user'] = $user;
		header('Location: /list.php');
		exit;
	}
} 

else{
	header('Location: /login-form.php');
	exit;
}*/

?>