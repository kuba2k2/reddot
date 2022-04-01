<div class="row justify-content-md-center">
	<div class="col-md-8">

		<?php
		if (empty($_POST['query'])) {
			header('Location: index.php');
			exit;
		}
		?>

		<h1 class="witajka">Wyniki wyszukiwania: <?= $_POST['query'] ?></h1>
		<?php
		db_connect();
		$stmt = $db->prepare('SELECT posts.*, users.*, COUNT(com_id) AS com_count
		FROM posts
		JOIN users USING(user_id)
		LEFT JOIN comments USING(post_id)
		WHERE MATCH(`posts`.`title`,`posts`.`text`) AGAINST (? IN BOOLEAN MODE)
		OR MATCH(`comments`.`text`) AGAINST (? IN BOOLEAN MODE)
		OR MATCH(`users`.`login`) AGAINST (? IN BOOLEAN MODE)
		GROUP BY post_id
		ORDER BY postdate DESC;');
		$stmt->execute([
			implode('* ', explode(' ', $_POST['query'])) . '*',
			implode('* ', explode(' ', $_POST['query'])) . '*',
			implode('* ', explode(' ', $_POST['query'])) . '*',
		]);
		require_once 'inc/post-card.php';

		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$stmt2 = $db->prepare('Select * from `pics` where `post_id` = ?;');
			$stmt2->execute([$row['post_id']]);
			$pics = $stmt2->fetchAll(PDO::FETCH_ASSOC);
			fix_pfp($row);

			postCard($row, $pics, '300px');
		}
		?>

	</div>
</div>
