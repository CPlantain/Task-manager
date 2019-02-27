<?php

// подключение к БД
try{
	$pdo = new 
	PDO("mysql:host=localhost;dbname=task_manager;charset=utf8", 'root', '');
}catch(PDOException $e){
	die("Не могу подключиться к базе данных");
}

// получаем данные 
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];

//проверяем инпуты на пустоту 
foreach ($_POST as $field) {
	if(strlen($field) <= 0){
		$errorMessage = 'пожалуйста заполните все поля';
	}
}

// проверяем формат емейла
if(!$errorMessage) {
	if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$errorMessage = 'некорректный email';
	}
}

// проверяем занятость емейла
if(!$errorMessage) {
	$sql = 'SELECT COUNT(*) as count FROM users WHERE email=:email';
	$statement = $pdo->prepare($sql);
	$statement->BindValue('email', $email, PDO::PARAM_STR);
	$statement->execute();
	$user = $statement->fetch(PDO::FETCH_ASSOC);

	if($user['count'] != 0) {
		$errorMessage = 'такой email уже зарегистрирован';
	}
}

// вывод ошибки
if($errorMessage){
	require 'errors.php';
	exit;
}

$password = password_hash($password, PASSWORD_DEFAULT);


// делаем запись в базу
$sql = 'INSERT INTO users(username, email, password) VALUES(:username, :email, :password)';
$statement = $pdo->prepare($sql);
$statement->BindValue('username', $username, PDO::PARAM_STR);
$statement->BindValue('email', $email, PDO::PARAM_STR);
$statement->BindValue('password', $password, PDO::PARAM_STR);
$statement->execute();

header("Location: /login-form.php");

?>