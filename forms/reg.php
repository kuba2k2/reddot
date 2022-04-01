<?php

db_connect();

if (is_logged_in()) {
	header('Location: index.php');
	exit;
}

$fields = [
	'reg-username',
	'reg-email',
	'reg-password',
	'reg-passwordconfirm',
	'reg-name',
	'reg-surname',
	'reg-color',
	'reg-address',
];

if (!is_form_complete($fields)) {
	add_message('danger', 7, 'Brakujące pola w formularzu!');
	return;
}

if ($_POST['reg-password'] != $_POST['reg-passwordconfirm']) {
	add_message('danger', 6, "Hasła nie są takie same");
	return;
}

$stmt = $db->prepare("INSERT INTO `users`(`email`, `login`, `password`, `name`, `surname`, `address`, `dog`)
		VALUES (?,?,?,?,?,?,?)"); // ale to fajnewiem

try {
	$stmt->execute([
		$_POST['reg-email'],
		$_POST['reg-username'],
		$_POST['reg-password'],
		$_POST['reg-name'],
		$_POST['reg-surname'],
		$_POST['reg-address'],
		$_POST['reg-color'],
	]);
} catch (PDOException $e) {
	if ($e->errorInfo[1] == 1062) {
		add_message('danger', 6, "Taki użytkownik już istnieje");
		return;
	} else {
		add_message('danger', 6, "Nieznany błąd podczas tworzenia konta");
		return;
	}
}

add_message('success', 3, 'Zostałeś zajerestrowany. Możesz się teraz zalogować.');
header('Location: index.php');
exit;
