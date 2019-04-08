<?php 
session_start(); 

$user_id = $_SESSION['user']['id'];
$id = $_GET['id'];

// подключение к БД
try{
  $pdo = new 
  PDO("mysql:host=localhost;dbname=task_manager;charset=utf8", 'root', '');
}catch(PDOException $e){
  die("Не могу подключиться к базе данных");
}

// получаем задачу по id 
$sql = 'SELECT * FROM tasks WHERE id=:id AND user_id=:user_id';
$statement = $pdo->prepare($sql);
$statement->BindValue('id', $id, PDO::PARAM_INT);
$statement->BindValue('user_id', $user_id, PDO::PARAM_INT);
$statement->execute();
$task = $statement->fetch(PDO::FETCH_ASSOC);

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
        <input name="title" type="text"  id="inputTitle" class="form-control" placeholder="Название" value="<?php echo $task['title']; ?>">
        <label for="inputContent" class="sr-only">Контент</label>
        <textarea name="content" class="form-control" cols="30" rows="10" placeholder="Текст"><?php echo $task['content']; ?></textarea>
        <input name="image" type="file">
        <input type="hidden" name="id" value="<?php echo $task['id']; ?>">
        
        <!-- если у задачи есть изображение, выводим его и передаём его имя в скрытом поле -->
        <?php if($task['image']) : ?>
          <img src="uploads/<?php echo $task['image']; ?>" alt="" width="300" class="mb-3">
          <input type="hidden" name="current_image" value="<?php echo $task['image']; ?>">

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

