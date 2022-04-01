<?php
function postCard($row, $pics, $height)
{
?>
	<div class="card w-100 mb-3">
		<div class="card-body">
			<div class="user-image image" style="background-image: url(<?= $row['pfp'] ?>);"></div>
			<span class="ms-2">
				<a class="post-user" href="?page=details&user-id=<?= $row['user_id'] ?>">
					<?= $row['name'] . ' ' . $row['surname'] ?>
					<small>(<?= $row['login'] ?>)</small>
				</a>
			</span>

			<h5 class="card-title"><a href="?page=post&post-id=<?= $row['post_id'] ?>" class="post-title"><?= $row['title'] ?></a></h5>
			<p class="card-text"><?= nl2br($row['text']) ?></p>
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
							<div style="background-image: url(<?= $pic['filename'] ?>); background-size: contain; height: <?= $height ?>; background-repeat: no-repeat;background-position: center;" class="d-block w-100" alt="..."></div>
						</div>
					<?php
					}
					?>
				</div>
				<button class="carousel-control-prev" type="button" data-bs-target="#post-<?= $row['post_id'] ?>-photos" data-bs-slide="prev">
					<span class="carousel-control-prev-icon" aria-hidden="true"></span>
					<span class="visually-hidden">Poprzedni</span>
				</button>
				<button class="carousel-control-next" type="button" data-bs-target="#post-<?= $row['post_id'] ?>-photos" data-bs-slide="next">
					<span class="carousel-control-next-icon" aria-hidden="true"></span>
					<span class="visually-hidden">Następny</span>
				</button>
			</div>
		<?php
		}
		?>
		<div class="btn-group" role="group">
			<?php if ($_GET['page'] != 'post') { ?>
				<a href="?page=post&post-id=<?= $row['post_id'] ?>" class="btn">
					<i class="bi bi-chat-dots"></i>
					<?php if ($row['com_count']) { ?>
						Komentarze (<?= $row['com_count'] ?>)
					<?php } else { ?>
						Napisz komentarz
					<?php } ?>
				</a>
			<?php } ?>
			<?php if (can_edit($row['user_id'])) { ?>
				<a href="?page=post-edit&post-id=<?= $row['post_id'] ?>" class="btn"><i class="bi bi-pencil"></i> Edytuj</a>
			<?php } ?>
		</div>

	</div>
<?php
}
?>
