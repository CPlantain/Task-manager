<?php
require_once 'config.php';
// проверяем, авторизован ли пользователь
if(authorize('user', 'UserHash', $pdo))	redirect('/list.php');

// получаем и фильтруем данные
$email = filter($_POST['email']);
$password = filter($_POST['password']);

// проверяем поля на пустоту
$required = [$email, $password];
if(!checkEmpty($required)) $errorMessage = 'пожалуйста заполните все поля';

// проверяем формат емейла
if(!$errorMessage) {
	if(!checkEmail($email)) $errorMessage = 'некорректный email';
}

// проверяем, есть ли пара емейл + пароль, указанные пользователем
if (!$errorMessage){
	$param = ['email' => $email];
	$user = getOne($pdo, 'users', $param);

	if (!$user) {
		$errorMessage = 'не удалось авторизоваться, email или пароль введены неверно';
	}else if(!password_verify($password, $user['password'])){
		$errorMessage = 'не удалось авторизоваться, email или пароль введены неверно';
	}
}

// выводим ошибки
if($errorMessage) showError($errorMessage);

// записываем пользователя в сессию	
setSession('user', $user);

// если пользователь поставил галочку "запомнить меня", устанавливаем куки на месяц
if($_POST['remember']){
	$hash = $user['password'];
	$time = 30 * 86400;
	setcookie('UserHash', $hash, time() + $time);
}

redirect('/list.php');
?>


