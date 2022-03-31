<div class="row justify-content-md-center">
	<div class="col-md-8">
		<?php
		db_connect();

		$user_id = $_SESSION['user_id'];
		if (isset($_GET['user-id'])) {
			$user_id = $_GET['user-id'];
		}

		$stmt = $db->prepare('SELECT * from `posts` join `users` USING(`user_id`) WHERE user_id = ? order by `postdate` desc');
		$stmt->execute([$user_id]);
		require_once 'inc/post-card.php';

		$first = true;
		$found_rows = false;

		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$found_rows = true;
			if ($first) {
		?>
				<h1 class="witajka">Posty użytkownika <?= $row['login'] ?></h1>
		<?php
				$first = false;
			}

			$stmt2 = $db->prepare('Select * from `pics` where `post_id` = ?;');
			$stmt2->execute([$row['post_id']]);
			$pics = $stmt2->fetchAll(PDO::FETCH_ASSOC);
			if (empty($row['pfp'])) {
				$row['pfp'] = 'user.png';
			}

			postCard($row, $pics);
		}

		if (!$found_rows) {
			echo '<h2 class="text-center">Ten użytkownik nie ma żadnych postów.</h2>';
		}

		?>

	</div>
</div>
