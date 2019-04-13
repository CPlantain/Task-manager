<?php
require_once 'config.php';
// проверяем авторизацию
if(!authorize('user', 'UserHash', $pdo)) redirect('/login-form.php');

// выход из системы
logout('user', 'UserHash');

redirect('/login-form.php');
?>
