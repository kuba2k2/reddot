<div class="row justify-content-md-center">
	<div class="col-md-8">
		<?php
		db_connect();

		$user_id = $_SESSION['user_id'];
		if (isset($_GET['user-id'])) {
			$user_id = $_GET['user-id'];
		}

		$stmt = $db->prepare('SELECT posts.*, users.*, COUNT(com_id) AS com_count FROM posts JOIN users USING(user_id) LEFT JOIN comments USING(post_id) WHERE posts.user_id = ? GROUP BY post_id ORDER BY postdate DESC;');
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

			fix_pfp($row);
			postCard($row, $pics, '300px');
		}

		if (!$found_rows) {
			echo '<h2 class="text-center">Ten użytkownik nie ma żadnych postów.</h2>';
		}

		?>

	</div>
</div>
