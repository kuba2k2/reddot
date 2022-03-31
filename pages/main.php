<div class="row justify-content-md-center">
	<div class="col-md-8">

		<h1 class="witajka">Witaj, <?= $_SESSION['name'] ?>!</h1>
		<?php
		db_connect();
		$stmt = $db->prepare('SELECT posts.*, users.*, COUNT(com_id) AS com_count FROM posts JOIN users USING(user_id) LEFT JOIN comments USING(post_id) GROUP BY post_id ORDER BY postdate DESC;');
		$stmt->execute();
		require_once 'inc/post-card.php';

		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$stmt2 = $db->prepare('Select * from `pics` where `post_id` = ?;');
			$stmt2->execute([$row['post_id']]);
			$pics = $stmt2->fetchAll(PDO::FETCH_ASSOC);
			fix_pfp($row);

			postCard($row, $pics);
		}
		?>

	</div>
</div>
