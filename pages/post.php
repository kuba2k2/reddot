<div class="row justify-content-md-center">
	<div class="col-md-8">
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
		if (empty($row['pfp'])) {
			$row['pfp'] = 'user.png';
		}

		postCard($row, $pics);

		?>
	</div>
	<div class="col-md-12 col-lg-10 col-xl-8">
		<div class="card">
			<div class="card-body p-4">
				<div class="col">
					<?php
					$stmt = $db->prepare('SELECT * FROM comments JOIN users USING(user_id) WHERE post_id = ? ORDER BY date_added DESC;');
					$stmt->execute([$row['post_id']]);

					$cls = '';

					while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
						if (empty($row['pfp'])) {
							$row['pfp'] = 'user.png';
						}
					?>
						<div class="d-flex flex-start <?=$cls ?>">
							<img class="rounded-circle shadow-1-strong me-3" src="<?= $row['pfp'] ?>" alt="avatar" width="65" height="65" />
							<div class="flex-grow-1 flex-shrink-1">
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
		</div>
		<div class="card-footer py-3 border-0" style="background-color: #f8f9fa;">
            <div class="d-flex flex-start w-100">
              <img class="rounded-circle shadow-1-strong me-3" src="<?= $row['pfp'] ?>" alt="avatar" width="40" height="40" />
              <div class="form-outline w-100">
                <textarea
                  class="form-control"
                  id="textAreaExample"
                  rows="4"
                  style="background: #fff;"
                ></textarea>
                <label class="form-label" for="textAreaExample">Message</label>
              </div>
            </div>
            <div class="float-end mt-2 pt-1">
              <button type="button" class="btn btn-primary btn-sm">Post comment</button>
              <button type="button" class="btn btn-outline-primary btn-sm">Cancel</button>
	</div>
</div>
