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
	<div class="col-md-12 col-lg-10 col-xl-8">
		<div class="card">
			<div class="card-body p-4">

				<div class="col">
					<div class="d-flex flex-start">
						<img class="rounded-circle shadow-1-strong me-3" src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/img%20(10).webp" alt="avatar" width="65" height="65" />
						<div class="flex-grow-1 flex-shrink-1">
							<div class="d-flex justify-content-between align-items-center">
								<p class="mb-1">
									Maria Smantha <span class="small">- 2 hours ago</span>
								</p>
							</div>
							<p class="small mb-0">
								It is a long established fact that a reader will be distracted by
								the readable content of a page.
							</p>
						</div>

					</div>

					<div class="d-flex flex-start mt-4">
						<img class="rounded-circle shadow-1-strong me-3" src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/img%20(12).webp" alt="avatar" width="65" height="65" />
						<div class="flex-grow-1 flex-shrink-1">
							<div class="d-flex justify-content-between align-items-center">
								<p class="mb-1">
									Natalie Smith <span class="small">- 2 hours ago</span>
								</p>
							</div>
							<p class="small mb-0">
								The standard chunk of Lorem Ipsum used since the 1500s is
								reproduced below for those interested. Sections 1.10.32 and
								1.10.33.
							</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
