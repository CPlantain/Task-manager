<?php
session_start();

$id = $_GET['id'];
$user_id = $_SESSION['user']['id'];

// подключение к БД
try{
  $pdo = new 
  PDO("mysql:host=localhost;dbname=task_manager;charset=utf8", 'root', '');
}catch(PDOException $e){
  die("Не могу подключиться к базе данных");
}

// получаем имя изображения задачи из базы
$sql = 'SELECT image FROM tasks WHERE id=:id AND user_id=:user_id';
$statement = $pdo->prepare($sql);
$statement->BindValue('id', $id, PDO::PARAM_INT);
$statement->BindValue('user_id', $user_id, PDO::PARAM_INT);
$statement->execute();
$task = $statement->fetch(PDO::FETCH_ASSOC);

// если оно не null, удаляем с сервера
if($task['image']){
	if(file_exists('uploads/' . $task['image'])){
		unlink('uploads/' . $task['image']);
	}
}

// удаляем саму задачу
$sql = 'DELETE FROM tasks WHERE id=:id AND user_id=:user_id';
$statement = $pdo->prepare($sql);
$statement->BindValue('id', $id, PDO::PARAM_INT);
$statement->BindValue('user_id', $user_id, PDO::PARAM_INT);
$statement->execute();

header("Location: /list.php");
?>