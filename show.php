<?php 
require_once 'config.php';
// проверяем, авторизован ли пользователь
if(!authorize('user', 'UserHash', $pdo)) redirect('/login-form.php');

$user_id = $_SESSION['user']['id'];
$id = $_GET['id'];

// получаем задачу по id 
$params = ['id' => $id, 'user_id' => $user_id];
$task = getOne($pdo, 'tasks', $params);

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">

    <title>Show</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    
    <style>
      
    </style>
  </head>

  <body>
    <div class="form-wrapper text-center">

      <!-- если у задачи есть изображение, выводим его -->
      <?php if($task['image']) : ?>
        <img class="card-img-top" src="uploads/<?php echo filter($task['image']); ?>">

      <!-- если нет, выводим дефолтную картинку -->
      <?php else : ?>
        <img class="card-img-top" src="assets/img/no-image.jpg">
      <?php endif; ?>
      
      <h2><?php echo filter($task['title']); ?></h2>
      <p><?php echo filter($task['content']); ?></p>
    </div>
  </body>
</html>
