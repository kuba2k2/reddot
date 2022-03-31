<?php
$postId = 0;
$title = null;
$text = null;

if (!is_logged_in()) {
	header('Location: index.php');
	exit;
}

if (isset($_GET['post-id'])) {
	db_connect();
	$stmt = $db->prepare('SELECT * FROM posts WHERE post_id = ? AND (user_id = ? OR 1 = ?);');
	$stmt->execute([
		$_GET['post-id'],
		$_SESSION['user_id'],
		is_admin(),
	]);

	if ($stmt->rowCount() != 1) {
		header('Location: index.php');
		exit;
	}
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	$postId = $row['post_id'];
	$title = $row['title'];
	$text = $row['text'];
}

if ($title) { ?>
	<h1>Edytuj post</h1>
	<small class="mb-3">użytkownika <a class="a-black" href="?page=details&user-id=<?= $row['user_id'] ?>"><?= $row['login'] ?></a></small>
<?php } else { ?>
	<h1>Dodaj post</h1>
<?php } ?>

<form method="post">
	<div class="mb-3">
		<label for="post-title" class="form-label">Tytuł postu</label>
		<input type="text" class="form-control" id="post-title" name="post-title" value="<?= $title ?>">
	</div>
	<div class="mb-3">
		<label for="post-text" class="form-label">Treść</label>
		<textarea class="form-control" id="post-text" name="post-text" rows="15"><?= $text ?></textarea>
	</div>
	<?php if ($postId) { ?>
		<input type="hidden" name="post-edit-id" value="<?= $postId ?>">
		<input type="hidden" name="post-remove-id" value="<?= $postId ?>">
	<?php } ?>
	<button type="submit" class="btn btn-primary" name="form-post"><?= ($title ? 'Zapisz' : 'Dodaj') ?></button>
	<?php if ($postId) { ?>
	<button type="submit" class="btn btn-outline-danger float-end" name="form-post-remove">Usuń post</button>
	<?php } ?>
</form>
