<?php
	
	include "phpCommon.php";

	$username = "User1";
	$password = "pwd";

	$sql = new mysqli("localhost", $sql_user, $sql_pwd, $sql_db);
	$stm = $sql->prepare("Insert into users(username, passwordHash) values (?, ?)");
	$stm->bind_param("ss", $username, password_hash($password, PASSWORD_DEFAULT));
	$stm->execute();

?>