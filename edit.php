<?php
session_start();

// подключение к БД
try{
	$pdo = new 
	PDO("mysql:host=localhost;dbname=task_manager;charset=utf8", 'root', '');
}catch(PDOException $e){
	die("Не могу подключиться к базе данных");
}

// сохраняем данные в удобном виде
$title = $_POST['title'];
$content = $_POST['content'];
$image = $_FILES['image'];
$current_image = $_POST['current_image'];
$user_id = $_SESSION['user']['id'];
$id = $_POST['id'];

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

// удаление старого изображения, генерация имени нового изображения и его загрузка
if (!empty($image['name'])) {
	
	if($current_image){
		if(file_exists('uploads/' . $current_image)){
			unlink('uploads/' . $current_image);
		}
	}
	
	$picName = uniqid() . '.' . substr($image['type'], strlen('image/'));
	$path = 'uploads/';
	$destination =  $path . $picName;
	move_uploaded_file($image['tmp_name'], $destination);
} else {
	$picName = $current_image;
}

// обновление записи в бд 
$data = [
		'title' => $title,
		'content' => $content,
		'image' => $picName,
		'id' => $id,
		'user_id' => $user_id
		];

$sql = 'UPDATE tasks SET title=:title, content=:content, image=:image WHERE id=:id AND user_id=:user_id';
$statement = $pdo->prepare($sql);
$statement->execute($data);


header("Location: /list.php");