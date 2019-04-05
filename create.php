<?php 
session_start();

// подключение к БД
try{
	$pdo = new 
	PDO("mysql:host=localhost;dbname=task_manager;charset=utf8", 'root', '');
}catch(PDOException $e){
	die("Не могу подключиться к базе данных");
}

// сохраняем данные из формы
$title = $_POST['title'];
$content = $_POST['content'];
$image = $_FILES['image'];
$user_id = $_SESSION['user']['id'];


// проверка полей на пустоту
foreach ($_POST as $field) {
	if(strlen($field) <= 0){
		$errorMessage = 'пожалуйста заполните все поля';
	}
}


// проверка формата и размера изображения
if(!$errorMessage){
	if(!empty($image['name'])){
		if(($image['type'] != 'image/png') && ($image['type'] != 'image/jpeg') && ($image['type'] != 'image/jpg')){
			$errorMessage = 'неверный формат изображения';
		} else if($image['size'] > 5 * 1024 * 1024){
			$errorMessage = 'файл слишком большой';
		}
	}
}


// вывод ошибок
if($errorMessage){
	require "errors.php";
	exit();
}


// генерация имени изображения и его загрузка
if (!empty($image['name'])) {
	$picName = uniqid() . '.' . substr($image['type'], strlen('image/'));
	$path = 'uploads/';
	$destination =  $path . $picName;
	move_uploaded_file($image['tmp_name'], $destination);
}


// создание новой записи в БД 
$data = [
		'user_id' => $user_id,
		'title' => $title,
		'content' => $content,
		'image' => $picName
		];

$sql = 'INSERT INTO tasks (user_id, title, content, image) VALUES(:user_id, :title, :content, :image)';
$statement = $pdo->prepare($sql);
$statement->execute($data);


header("Location: /list.php");
?>