<?php
function postCard($row, $pics)
{
?>
	<div class="card w-100 mb-3">
		<div class="card-body">
			<div class="image" style="background-image: url(<?= $row['pfp'] ?>); width: 35px; height: 35px; background-size: contain; display: inline-block; border-radius: 100px;"><span style="vertical-align: middle;"> <?= $row['login'] ?></span></div>

			<h5 class="card-title"><?= $row['title'] ?></h5>
			<p class="card-text"><?= $row['text'] ?></p>
		</div>
		<?php
		if (!empty($pics)) {
		?>
			<div id="post-<?= $row['post_id'] ?>-photos" class="carousel slide card-img-top" data-bs-ride="carousel">
				<div class="carousel-indicators">
					<?php
					foreach ($pics as $number => $pic) {
					?>
						<button type="button" data-bs-target="#post-<?= $row['post_id'] ?>-photos" data-bs-slide-to="<?= $number ?>" class="<?= $number ? '' : 'active' ?>"></button>
					<?php
					}
					?>
				</div>
				<div class="carousel-inner">
					<?php
					foreach ($pics as $number => $pic) {
					?>
						<div class="carousel-item <?= $number ? '' : 'active' ?>">
							<div style="background-image: url(<?= $pic['filename'] ?>); background-size: cover; height: 300px; background-repeat: no-repeat;" class="d-block w-100" alt="..."></div>
						</div>
					<?php
					}
					?>
				</div>
				<button class="carousel-control-prev" type="button" data-bs-target="#post-<?= $row['post_id'] ?>-photos" data-bs-slide="prev">
					<span class="carousel-control-prev-icon" aria-hidden="true"></span>
					<span class="visually-hidden">Previous</span>
				</button>
				<button class="carousel-control-next" type="button" data-bs-target="#post-<?= $row['post_id'] ?>-photos" data-bs-slide="next">
					<span class="carousel-control-next-icon" aria-hidden="true"></span>
					<span class="visually-hidden">Next</span>
				</button>
			</div>
		<?php
		}
		?>
		<div class="btn-group" role="group">
		<?php if ($row['user_id'] == $_SESSION['user_id'] || is_admin()) { ?>
			<a href="?page=post-edit&post-id=<?= $row['post_id'] ?>" class="btn btn-outline-primary"><i class="bi bi-pencil"></i> Edytuj</a>
		<?php } ?>
  <button type="button" class="btn btn-outline-primary"><i class="bi bi-chat-dots"></i> Komentarze</button>
  <button type="button" class="btn btn-outline-primary">Right</button>
</div>

	</div>
<?php
}
?>
