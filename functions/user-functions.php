<?php

function setSession($key, $value){
	$_SESSION[$key] = $value;
}

function checkSession($key){
	if($_SESSION[$key]){
		return true;
	} 
}

function checkCookie($key){
	if($_COOKIE[$key]){
		return true;
	} 
}

function authorize($session_key, $cookie_key, $pdo){
	if(checkSession($session_key)){
		return true;
	} 
	else if(checkCookie($cookie_key)){
		$hash = $_COOKIE[$cookie_key];
		$param = ['password' => $hash];

		$user = getOne($pdo, 'users', $param);

		if($user){
			setSession('user', $user);
			return true;
		} else {
			return false;
		}
		
	} 
	else {
		return false;
	}
}

function clearSession($session_key){
	unset($_SESSION[$session_key]);
}

function clearCookie($cookie_key){
	if($_COOKIE[$cookie_key]){
		setcookie($cookie_key, '', time() - 3600);
	}
}

function logout($session_key, $cookie_key){
	clearSession($session_key);
	clearCookie($cookie_key);

	session_destroy();
}

function redirect($link){
	header("Location: $link");
	exit;
}

?>