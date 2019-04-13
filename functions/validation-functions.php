<?php

function filter($string){
	$string = trim($string);
	$string = htmlspecialchars($string);
	$string = strip_tags($string);
	return $string;
}

function checkEmpty($fields){
	foreach ($fields as $field) {
		if(strlen($field) <= 0) {
			return false;
		} else {
			return true;
		}
	}
}

function checkEmail($email){
	if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
		return true;
	} else {
		return false;
	}
}

function validateImage($image){
	$type = $image['type'];
	$size = $image['size'];

	if(($type != 'image/png') && ($type != 'image/jpeg') && ($type != 'image/jpg')){
		return false;
	} else if($size > 5 * 1024 * 1024){
		return false;
	} else {
		return true;
	}
}

function uploadImage($path, $image){
	$type = $image['type'];
	$tmp_name = $image['tmp_name'];

	$name = uniqid() . '.' . substr($type, strlen('image/'));
	$destination =  $path . $name;
	move_uploaded_file($tmp_name, $destination);
	return $name;
}

function deleteImage($path, $image){
	if(file_exists($path . $image)){
		unlink($path . $image);
	}
}

function showError($error){
	$errorMessage = $error;
	require 'errors.php';
	exit;
}

?>