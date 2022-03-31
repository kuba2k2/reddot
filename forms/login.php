<?php

db_connect();

if (isset($_POST["email"]) && isset($_POST["password"])) {

	$stmt = $db->prepare('Select * from `users` where (`login` = ? or `email` = ?) and `password` = ?;');

	$stmt->execute([
		$_POST["email"],
		$_POST["email"],
		$_POST["password"],
	]);

	if ($stmt->rowCount() != 1) {
		add_message("danger", 2, "Nieprawidłowe dane logowania");
		header('Location: ?page=welcome');
		exit;
	} else {
		$assoc = $stmt->fetch(PDO::FETCH_ASSOC);
		add_message("success", 3, "GRATULACJE UŻYTKOWNIKU");
		$_SESSION['logged_in'] = true;
		$_SESSION['user_id'] = $assoc['user_id'];
		$_SESSION['login'] = $assoc['login'];
		$_SESSION['role'] = $assoc['role'];
		$_SESSION['name'] = $assoc['name'];
		$_SESSION['surname'] = $assoc['surname'];
		$stmt = $db->prepare('UPDATE users SET logindate = CURRENT_TIMESTAMP() WHERE user_id = ?;');
		$stmt->execute([$_SESSION['user_id']]);
		header('Location: index.php');
		exit;
	}
}
