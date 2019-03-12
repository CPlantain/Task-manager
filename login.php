<?php
session_start();

// подключение к БД
try{
	$pdo = new 
	PDO("mysql:host=localhost;dbname=task_manager;charset=utf8", 'root', '');
}catch(PDOException $e){
	die("Не могу подключиться к базе данных");
}

// получаем данные
$email = $_POST['email'];
$password = $_POST['password'];

// проверяем поля на пустоту
foreach ($_POST as $field) {
	if (strlen($field) <= 0) {
		$errorMessage = 'пожалуйста заполните все поля';
	}
}

// проверяем формат емейла
if (!$errorMessage) {
	if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
		$errorMessage = 'некорректный email';
	}
}{

// проверяем, есть ли пара емейл + пароль, указанные пользователем
if (!$errorMessage) 
	$sql = 'SELECT * FROM users WHERE email=:email';
	$statement = $pdo->prepare($sql);
	$statement->BindValue('email', $email, PDO::PARAM_STR);
	$statement->execute();
	$user = $statement->fetch(PDO::FETCH_ASSOC);

	if (!$user) {
		$errorMessage = 'не удалось авторизоваться, email или пароль введены неверно';
	}else if(!password_verify($password, $user['password'])){
		$errorMessage = 'не удалось авторизоваться, email или пароль введены неверно';
	}
}

// выводим ошибки
if($errorMessage){
	require 'errors.php';
	exit;
}

// записываем пользователя в сессию	
$_SESSION['user'] = $user;

header("Location: /index.php");
?>