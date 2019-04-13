<?php
require_once 'config.php';
// проверяем, авторизован ли пользователь
if(authorize('user', 'UserHash', $pdo))	redirect('/list.php');

// получаем данные 
$username = filter($_POST['username']);
$email = filter($_POST['email']);
$password = filter($_POST['password']);

//проверяем инпуты на пустоту 
$required = [$username, $email, $password];
if(!checkEmpty($required)) $errorMessage = 'пожалуйста заполните все поля';

// проверяем формат емейла
if(!$errorMessage) {
	if(!checkEmail($email)) $errorMessage = 'некорректный email';
}

// проверяем занятость емейла
if(!$errorMessage) {
	$param = ['email' => $email];
	$user = getOne($pdo, 'users', $param);
	if($user) $errorMessage = 'такой email уже зарегистрирован';
}

// вывод ошибки
if($errorMessage) showError($errorMessage);

// делаем запись в базу
$password = password_hash($password, PASSWORD_DEFAULT);
$data = [
		'username' => $username,
		'email' => $email,
		'password' => $password
		];
$register = create($pdo, 'users', $data);

redirect('/login-form.php');

?>

