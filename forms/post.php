<?php

db_connect();

if (!is_logged_in()) {
	not_logged_in();
}

if (isset($_POST['form-post-remove']) && isset($_POST['post-remove-id'])) {
	$stmt = $db->prepare('DELETE FROM posts WHERE (user_id = ? OR 1 = ?) AND post_id = ?;');
	$stmt->execute([
		$_SESSION['user_id'],
		is_admin(),
		$_POST['post-remove-id'],
	]);

	if ($stmt->rowCount() == 1) {
		add_message('info', 10, 'Post został usunięty.');
		header('Location: index.php');
		exit;
	} else {
		add_message('danger', 10, 'Nie udało się usunąć postu.');
	}
} elseif (isset($_POST['form-post']) && isset($_POST['post-title']) && isset($_POST['post-text'])) {
	if (isset($_POST['post-edit-id'])) {
		$stmt = $db->prepare('UPDATE posts SET title = ?, text = ? WHERE (user_id = ? OR 1 = ?) AND post_id = ?;');
		$stmt->execute([
			$_POST['post-title'],
			$_POST['post-text'],
			$_SESSION['user_id'],
			is_admin(),
			$_POST['post-edit-id'],
		]);
		$post_id = $_POST['post-edit-id'];
	} else {
		$stmt = $db->prepare('INSERT INTO posts (user_id, title, text) VALUES (?, ?, ?);');
		$stmt->execute([
			$_SESSION['user_id'],
			$_POST['post-title'],
			$_POST['post-text'],
		]);
		$post_id = $db->lastInsertId('post_id');
	}

	foreach ($_FILES as $file) {
		$basename = basename($file["name"]);
		$basename = preg_replace('/[^A-z0-9-_.]/', '_', $basename);
		$target_file = 'pics/' . time() . '_' . $basename;
		$image_info = getimagesize($file["tmp_name"]);

		if ($image_info === false && (!str_ends_with($basename, '.svg'))) {
			add_message('danger', 3, 'Obrazek '.$basename.' jest nieprawidłowy');
			continue;
		}

		if ($file["size"] > 10000000) {
			add_message('danger', 3, 'Obrazek '.$basename.' jest zbyt potężny');
			continue;
		}

		if (!file_exists('pics')) {
			mkdir('pics');
		}

		if (!move_uploaded_file($file["tmp_name"], $target_file)) {
			add_message('danger', 3, 'Nie udało się dodać obrazka '.$basename.', spróbuj ponownie później');
			continue;
		}

		$stmt = $db->prepare("INSERT INTO pics (post_id, filename) VALUES (?, ?);");
		$stmt->execute([
			$post_id,
			$target_file,
		]);
	}

	if ($stmt->rowCount() == 1) {
		if (isset($_POST['post-edit-id'])) {
			add_message('success', 10, 'Post został zmieniony!');
		} else {
			add_message('success', 10, 'Post został dodany!');
		}
		header('Location: index.php');
		exit;
	} else {
		add_message('danger', 10, 'Nie udało się zapisać postu.');
	}
}
