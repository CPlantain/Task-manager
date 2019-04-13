<?php
require_once 'config.php';
// проверяем авторизацию
if(!authorize('user', 'UserHash', $pdo)) redirect('/login-form.php'); 

$id = $_GET['id'];
$user_id = $_SESSION['user']['id'];

// получаем имя изображения задачи из базы
$params = ['id' => $id, 'user_id' => $user_id];
$task = getOne($pdo, 'tasks', $params);

// если оно не null, удаляем с сервера
if($task['image']) deleteImage('uploads/', $task['image']);

// удаляем саму задачу
delete($pdo, 'tasks', $params);

redirect('/list.php');
?>