<?php 
require_once 'config.php';

if(!authorize('user', 'UserHash', $pdo)) redirect('/login-form.php');

// сохраняем данные из формы
$title = filter($_POST['title']);
$content = filter($_POST['content']);
$image = $_FILES['image'];
$user_id = $_SESSION['user']['id'];

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

// генерация имени изображения и его загрузка
if (!empty($image['name'])) $picName = uploadImage('uploads/', $image);

// создание новой записи в БД 
$data = [
		'user_id' => $user_id,
		'title' => $title,
		'content' => $content,
		'image' => $picName
		];
$create = create($pdo, 'tasks', $data);

redirect('/list.php');

?>