<?php 
require_once 'config.php';

if(!authorize('user', 'UserHash', $pdo)) redirect('/login-form.php'); 

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">

    <title>Create Task</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    
    <style>
      
    </style>
  </head>

  <body>
    <div class="form-wrapper text-center">
      <form class="form-signin" action="create.php" method="post" enctype="multipart/form-data">
        <img class="mb-4" src="assets/img/bootstrap-solid.svg" alt="" width="72" height="72">
        <h1 class="h3 mb-3 font-weight-normal">Добавить запись</h1>
        <label for="inputTitle" class="sr-only">Название</label>
        <input name="title" type="text" id="inputTitle" class="form-control" placeholder="Название">
        <label for="inputContent" class="sr-only">Контент</label>
        <textarea name="content" class="form-control" cols="30" rows="10" placeholder="Текст"></textarea>
        <input name="image" type="file">
        <button class="btn btn-lg btn-primary btn-block" type="submit">Отправить</button>
        <p class="mt-5 mb-3 text-muted">&copy; 2018-2019</p>
      </form>
    </div>
  </body>
</html>
