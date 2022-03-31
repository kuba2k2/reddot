<div class="row justify-content-md-center">
	<div class="col-md-12 col-lg-10 col-xl-8">
		<?php
		db_connect();
		$stmt = $db->prepare('SELECT * from `posts` join `users` USING(`user_id`) WHERE post_id = ? order by `postdate` desc');
		$stmt->execute([$_GET['post-id']]);

		require_once 'inc/post-card.php';

		if ($stmt->rowCount() != 1) {
			header('Location: index.php');
			exit;
		}

		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$stmt2 = $db->prepare('Select * from `pics` where `post_id` = ?;');
		$stmt2->execute([$row['post_id']]);
		$pics = $stmt2->fetchAll(PDO::FETCH_ASSOC);

		fix_pfp($row);
		postCard($row, $pics, '600px');
		$user = $row;

		?>
	</div>
	<div class="col-md-12 col-lg-10 col-xl-8">

		<div class="card">
			<div class="card-footer py-3 border-0" style="background-color: #f8f9fa;">
				<form method="POST">
					<input type="hidden" name="post_id" value="<?= $row['post_id'] ?>">
					<div class="d-flex flex-start w-100">
						<div class="rounded-circle shadow-1-strong me-3 user-image big" style="background-image: url(<?= $_SESSION['pfp'] ?>);"></div>
						<div class="form-outline w-100">
							<label class="form-label" for="textAreaExample">Napisz komentarz...</label>
							<textarea class="form-control" id="textAreaExample" name="text" rows="4" style="background: #fff;"></textarea>
						</div>
					</div>
					<div class="float-end mt-2 pt-1">
						<button type="submit" name="form-comment" class="btn btn-primary">Wyślij</button>
					</div>
				</form>
			</div>
			<?php
			$stmt = $db->prepare('SELECT * FROM comments JOIN users USING(user_id) WHERE post_id = ? ORDER BY date_added DESC;');
			$stmt->execute([$user['post_id']]); //ඞ
			if ($stmt->rowCount()) {
			?>
				<div class="card-body p-4">
					<div class="col">
						<?php
						$cls = '';

						while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
							fix_pfp($row);
						?>
							<div class="d-flex flex-start <?= $cls ?>">
								<div class="rounded-circle shadow-1-strong me-3 user-image big" style="background-image: url(<?= $row['pfp'] ?>);"></div>
								<div class="flex-grow-1 flex-shrink-1 comment-text">
									<div class="d-flex justify-content-between align-items-center">
										<p class="mb-1">
											<?= $row['login'] ?> <span class="small">- <?= $row['date_added'] ?></span>
										</p>
									</div>
									<p class="small mb-0">
										<?= nl2br($row['text']) ?>
									</p>
								</div>
							</div>
						<?php
							$cls = 'mt-4';
						}
						?>
					</div>
				</div>
			<?php
			}
			?>
		</div>

	</div>
</div>
