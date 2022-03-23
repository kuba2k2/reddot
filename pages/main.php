<div class="row justify-content-md-center">
	<div class="col-md-8">

		<h1 class="witajka">Witaj, <?= $_SESSION['name'] ?>!</h1>
		<?php
		db_connect();
		$stmt = $db->prepare('SELECT * from `posts` join `users` USING(`user_id`) order by `postdate` desc');
		$stmt->execute();
		require_once 'inc/post-card.php';

		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$stmt2 = $db->prepare('Select * from `pics` where `post_id` = ?;');
			$stmt2->execute([$row['post_id']]);
			$pics = $stmt2->fetchAll(PDO::FETCH_ASSOC);
			if (empty($row['pfp'])) {
				$row['pfp'] = 'user.png';
			}

			postCard($row, $pics);
		}
		?>

	</div>
</div>
