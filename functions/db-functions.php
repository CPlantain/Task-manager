<?php

function connectDatabase($config){
	try{
		return new PDO("{$config['connection']};dbname={$config['database']};charset={$config['charset']};", 
			$config['username'], 
			$config['password'],
			$config['options']
		);
	}
	catch(PDOException $e){
		die('Не могу подключиться к базе данных');
	}
}

function combineParams($params){
	$keys = array_keys($params);

	$string = '';
	foreach ($keys as $key) {
		$string .= $key . '=:' . $key . ' AND ';
	}
	return rtrim($string, ' AND ');
}

function getOne($pdo, $table, $params){
	$keys = combineParams($params);

	$sql = "SELECT * FROM ({$table}) WHERE ({$keys})";
	$statement = $pdo->prepare($sql);
	$statement->execute($params);
	return $statement->fetch(PDO::FETCH_ASSOC);
}

function getAll($pdo, $table, $params){
	$keys = combineParams($params);

	$sql = "SELECT * FROM ({$table}) WHERE ({$keys})";
	$statement = $pdo->prepare($sql);
	$statement->execute($params);
	return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function create($pdo, $table, $data){
	$keys = implode(', ', array_keys($data));
	$tags = ':' . implode(', :', array_keys($data));

	$sql = "INSERT INTO ({$table}) ({$keys}) values ({$tags})";
	$statement = $pdo->prepare($sql);
	$statement->execute($data);
}

function update($pdo, $table, $data, $params){
	$data_keys = array_keys($data);

	$string = '';
	foreach ($data_keys as $key) {
		$string .= $key . '=:' . $key . ',';
	}

	$data_keys = rtrim($string, ',');
	$param_keys = combineParams($params);
	$keys = array_merge($data, $params);

	$sql = "UPDATE ({$table}) SET ({$data_keys}) WHERE ({$param_keys})";
	$statement = $pdo->prepare($sql);
	$statement->execute($keys);
}

function delete($pdo, $table, $params){
	$keys = combineParams($params);

	$sql = "DELETE FROM ({$table}) WHERE ({$keys})";
	$statement = $pdo->prepare($sql);
	$statement->execute($params);
}


?>