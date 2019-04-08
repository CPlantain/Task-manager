<?php session_start();

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
        <img class="card-img-top" src="uploads/<?php echo $task['image']; ?>">

      <!-- если нет, выводим дефолтную картинку -->
      <?php else : ?>
        <img class="card-img-top" src="assets/img/no-image.jpg">
      <?php endif; ?>
      
      <h2><?php echo $task['title']; ?></h2>
      <p><?php echo $task['content']; ?></p>
    </div>
  </body>
</html>
