<?php

db_connect();

if (!is_logged_in()) {
	header('Location: index.php');
	exit;
}

/*if (isset($_POST['form-post-remove']) && isset($_POST['post-remove-id'])) {
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
} else*/
if (isset($_POST['form-comment']) && isset($_POST['text'])) {

	$stmt = $db->prepare("INSERT INTO `comments`(`post_id`, `user_id`, `text`) VALUES (?,?,?)"); // ඞ
	$stmt->execute([
		$_POST['post_id'],
		$_SESSION['user_id'],
		$_POST['text'],
	]);

	if ($stmt->rowCount() == 1) {
	    add_message('success', 10, 'Komentarz został dodany!');
		header('Location: ?page=post&post-id='.$_POST['post_id']); // ඞ
	} else {
		add_message('danger', 10, 'Nie udało się zapisać komentarza.');
	}
}
