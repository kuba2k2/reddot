<?php

db_connect();

if (!can_edit($_POST['user-edit-id'])) {
	header('Location: index.php');
	exit;
}

$fields = [
	'user-name',
	'user-surname',
	'user-address',
	'user-email',
	'user-login',
	'user-edit-id',
];

if (!is_form_complete($fields)) {
	add_message('danger', 7, 'Brakujące pola w formularzu!');
	return;
}

$stmt = $db->prepare("UPDATE users SET name = ?, surname = ?, address = ?, email = ?, login = ? WHERE user_id = ?;");
$stmt->execute([
	$_POST['user-name'],
	$_POST['user-surname'],
	$_POST['user-address'],
	$_POST['user-email'],
	$_POST['user-login'],
	$_POST['user-edit-id'],
]);

add_message('success', 3, 'Profil został zmieniony');
header('Location: ?page=details&user-id='.$_POST['user-edit-id']);
exit;
