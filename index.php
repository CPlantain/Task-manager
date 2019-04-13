<?php
require_once 'config.php';
// проверяем авторизован ли пользователь
if(authorize('user', 'UserHash', $pdo)) {
	redirect('/list.php');
} 

else {
	redirect('/login-form.php');
}

?>