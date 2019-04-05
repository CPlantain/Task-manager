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
}

// проверяем, есть ли пара емейл + пароль, указанные пользователем
if (!$errorMessage){
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

// если пользователь поставил галочку "запомнить меня", устанавливаем куки на месяц
if($_POST['remember']){
	$hash = $user['password'];
	$time = 30 * 86400;
	setcookie('UserHash', $hash, time() + $time);
}

// если в массиве пост чекбокс "remember" есть, то устанавливаем куки
// проверка на каждой странице: сначала проверяем сессию, если она пустая, проверяем куки.
// если у пользователя есть кука с именем "запомнить", проверяем её содержимое
// если запрос селект с указанным хэшем возвращает запись, то эту запись добавляю в сессию, иначе редирект на логин
// при логауте кука удаляется

header("Location: /list.php");
?>


