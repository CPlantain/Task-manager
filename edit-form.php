<?php 
require_once 'config.php';
// проверяем авторизацию
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

    <title>Edit Task</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    
    <style>
      
    </style>
  </head>

  <body>
    <div class="form-wrapper text-center">
      <form class="form-signin" action="edit.php" method="post" enctype="multipart/form-data">
        <img class="mb-4" src="assets/img/bootstrap-solid.svg" alt="" width="72" height="72">
        <h1 class="h3 mb-3 font-weight-normal">Изменить запись</h1>
        <label for="inputTitle" class="sr-only">Название</label>
        <input name="title" type="text"  id="inputTitle" class="form-control" placeholder="Название" value="<?php echo filter($task['title']); ?>">
        <label for="inputContent" class="sr-only">Контент</label>
        <textarea name="content" class="form-control" cols="30" rows="10" placeholder="Текст"><?php echo filter($task['content']); ?></textarea>
        <input name="image" type="file">
        <input type="hidden" name="id" value="<?php echo $task['id']; ?>">
        
        <!-- если у задачи есть изображение, выводим его и передаём его имя в скрытом поле -->
        <?php if($task['image']) : ?>
          <img src="uploads/<?php echo filter($task['image']); ?>" alt="" width="300" class="mb-3">
          <input type="hidden" name="current_image" value="<?php echo filter($task['image']); ?>">

        <!-- если нет, выводим дефолтную картинку -->
        <?php else : ?>
          <img src="assets/img/no-image.jpg" alt="" width="300" class="mb-3">
        <?php endif ?>

        <button class="btn btn-lg btn-success btn-block" type="submit">Редактировать</button>
        <p class="mt-5 mb-3 text-muted">&copy; 2018-2019</p>
      </form>
    </div>
  </body>
</html>

