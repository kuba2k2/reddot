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

if (isset($_FILES['user-picture']) && $_FILES['user-picture']['name']) {
	$basename = basename($_FILES["user-picture"]["name"]);
	$basename = preg_replace('/[^A-z0-9-_.]/', '_', $basename);
	$target_file = 'pfp/' . time() . '_' . $basename;
	$image_info = getimagesize($_FILES["user-picture"]["tmp_name"]);
	// ඞ
	if ($image_info === false && (!str_ends_with($basename, '.svg'))) {
		add_message('danger', 3, 'Obrazek jest nieprawidłowy');
		return;
	}

	if ($_FILES["user-picture"]["size"] > 5000000) {
		add_message('danger', 3, 'Obrazek jest zbyt potężny');
		return;
	}

	if (!file_exists('pfp')) {
		mkdir('pfp');
	}

	if (!move_uploaded_file($_FILES["user-picture"]["tmp_name"], $target_file)) {
		add_message('danger', 3, 'Nie udało się zmienić awataru, spróbuj ponownie później');
		return;
	}

	$stmt = $db->prepare("UPDATE users SET name = ?, surname = ?, address = ?, email = ?, login = ?, pfp = ? WHERE user_id = ?;");
	$stmt->execute([
		$_POST['user-name'],
		$_POST['user-surname'],
		$_POST['user-address'],
		$_POST['user-email'],
		$_POST['user-login'],
		$target_file,
		$_POST['user-edit-id'],
	]);

	if ($_SESSION['user_id'] == $_POST['user-edit-id']) {
		$_SESSION['pfp'] = $target_file;
	}
} else {
	$stmt = $db->prepare("UPDATE users SET name = ?, surname = ?, address = ?, email = ?, login = ? WHERE user_id = ?;");
	$stmt->execute([
		$_POST['user-name'],
		$_POST['user-surname'],
		$_POST['user-address'],
		$_POST['user-email'],
		$_POST['user-login'],
		$_POST['user-edit-id'],
	]);
}

if ($_SESSION['user_id'] == $_POST['user-edit-id']) {
	$_SESSION['login'] = $_POST['user-login'];
	$_SESSION['name'] = $_POST['user-name'];
	$_SESSION['surname'] = $_POST['user-surname'];
}

add_message('success', 3, 'Profil został zmieniony');
header('Location: ?page=details&user-id=' . $_POST['user-edit-id']);
exit;
