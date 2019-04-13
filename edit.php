<?php
require_once 'config.php';
// проверяем авторизацию
if(!authorize('user', 'UserHash', $pdo)) redirect('/login-form.php');

// сохраняем данные в удобном виде
$title = filter($_POST['title']);
$content = filter($_POST['content']);
$image = $_FILES['image'];
$current_image = filter($_POST['current_image']);
$user_id = $_SESSION['user']['id'];
$id = $_POST['id'];

// проверка полей на пустоту
$required = [$title, $content];
if(!checkEmpty($required)) $errorMessage = 'пожалуйста заполните все поля';

// проверка формата и размера изображения
if(!$errorMessage){
	if(!empty($image['name'])){
		if(!validateImage($image)) $errorMessage = 'Ошибка загрузки изображения! Допустимые форматы: jpeg, jpg, png. Максимальный размер изображения: 5 МБ.';
	}
}

// вывод ошибок
if($errorMessage) showError($errorMessage);

// удаление старого изображения, генерация имени нового изображения и его загрузка
if (!empty($image['name'])) {
	if($current_image) deleteImage('uploads/', $current_image);

	$picName = uploadImage('uploads/', $image);
} else {
	$picName = $current_image;
}

// обновление записи в бд 
$data = [
		'title' => $title,
		'content' => $content,
		'image' => $picName
		];
$params = [
		'id' => $id,
		'user_id' => $user_id
		];

update($pdo, 'tasks', $data, $params);

redirect('/list.php');
?>