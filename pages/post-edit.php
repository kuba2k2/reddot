<?php
$postId = 0;
$title = null;
$text = null;

if (!is_logged_in()) {
	not_logged_in();
}

if (isset($_GET['post-id'])) {
	db_connect();
	$stmt = $db->prepare('SELECT * FROM posts JOIN users USING(user_id) WHERE post_id = ? AND (user_id = ? OR 1 = ?);');
	$stmt->execute([
		$_GET['post-id'],
		$_SESSION['user_id'],
		is_admin(),
	]);

	if ($stmt->rowCount() != 1) {
		no_access();
	}
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	$postId = $row['post_id'];
	$title = $row['title'];
	$text = $row['text'];
}

$edit = isset($title);

if ($edit) { ?>
	<h1>Edytuj post</h1>
	<small class="mb-3">użytkownika <a class="a-black" href="?page=details&user-id=<?= $row['user_id'] ?>"><?= $row['login'] ?></a></small>
<?php } else { ?>
	<h1>Dodaj post</h1>
<?php } ?>

<form method="post" enctype="multipart/form-data">
	<div class="mb-3">
		<label for="post-title" class="form-label">Tytuł postu</label>
		<input type="text" class="form-control" id="post-title" name="post-title" value="<?= $title ?>">
	</div>
	<div class="mb-3">
		<label for="post-text" class="form-label">Treść</label>
		<textarea class="form-control" id="post-text" name="post-text" rows="15"><?= $text ?></textarea>
	</div>
	<div class="mb-3">
		<label for="post-pics" class="form-label">Zdjęcia</label>
		<div class="row pe-3" id="card-container">

			<div class="col-4 col-sm-3 col-md-2 pe-0" id="card-add">
				<a class="card a-black" href="#">
					<i class="bi bi-plus-square-dotted card-img-top"></i>
					<div class="card-body">
						<h6 class="card-title">Dodaj zdjęcie...</h6>
					</div>
				</a>
			</div>

			<div class="col-4 col-sm-3 col-md-2 pe-0 d-none" id="card-template">
				<div class="card">
					<img src="user.png" class="card-img-top">
					<div class="card-body">
						<h6 class="card-title">Nazwa pliku</h6>
						<small class="card-text">
							<span>100 kB</span>
							<a href="#" class="float-end" onclick="removeFile(event)"><i class="bi bi-trash"></i></a>
						</small>
					</div>
				</div>
			</div>

			<input type="file" class="d-none" id="file-1" onchange="addFile(event)" />
		</div>
		<script>
			let fileNumber = 1;

			// https://stackoverflow.com/a/14919494/9438331 ඞ
			function humanFileSize(bytes, si = false, dp = 2) {
				const thresh = si ? 1000 : 1024;

				if (Math.abs(bytes) < thresh) {
					return bytes + ' B';
				}

				const units = si ? ['kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'] : ['KiB', 'MiB', 'GiB', 'TiB', 'PiB', 'EiB', 'ZiB', 'YiB'];
				let u = -1;
				const r = 10 ** dp;

				do {
					bytes /= thresh;
					++u;
				} while (Math.round(Math.abs(bytes) * r) / r >= thresh && u < units.length - 1);


				return bytes.toFixed(dp) + ' ' + units[u];
			}

			$('#card-add').on('click', function(e) {
				e.preventDefault();
				$('#file-' + fileNumber).click();
			});

			function addFile(event) {
				let card = $('#card-template').clone();
				card.removeClass('d-none');
				$('img', card).attr('src', URL.createObjectURL(event.target.files[0]));
				$('h6', card).html(event.target.files[0].name);
				$('small span', card).html(humanFileSize(event.target.files[0].size));
				$('small a i', card).attr('data-file', fileNumber);
				card.attr('id', 'card-' + fileNumber);
				$('#card-container').append(card);
				let input = $('#file-' + fileNumber);
				input.attr('name', 'file-' + fileNumber);
				input = input.clone();
				fileNumber++;
				input.attr('id', 'file-' + fileNumber);
				$('#card-container').append(input);
			}

			function removeFile(event) {
				event.preventDefault();
				let btn = $(event.target);
				$('#file-' + btn.attr('data-file')).remove();
				$('#card-' + btn.attr('data-file')).remove();
			}
		</script>
	</div>
	<?php if ($postId) { ?>
		<input type="hidden" name="post-edit-id" value="<?= $postId ?>">
		<input type="hidden" name="post-remove-id" value="<?= $postId ?>">
	<?php } ?>
	<button type="submit" class="btn btn-primary" name="form-post"><?= ($edit ? 'Zapisz' : 'Dodaj') ?></button>
	<?php if ($postId) { ?>
		<button type="submit" class="btn btn-outline-danger float-end" name="form-post-remove">Usuń post</button>
	<?php } ?>
</form>
