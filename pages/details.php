<?php
db_connect();
$stmt = $db->prepare('SELECT * FROM `users` WHERE user_id = ?;');
$stmt->execute([
	isset($_GET['user-id']) ? $_GET['user-id'] : $_SESSION['user_id'],
]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
fix_pfp($row);

$dog = 'brak psa :(  (ale ma kota) :)';
switch (intval($row['dog'])) {
	case 1:
		$dog = 'Czarny';
		break;
	case 2:
		$dog = 'Brązowy';
		break;
	case 3:
		$dog = 'Biały';
		break;
	case 4:
		$dog = 'Moręgowaty';
		break;
	case 5:
		$dog = 'Szary';
		break;
	case 6:
		$dog = 'Biało-szary';
		break;
	case 7:
		$dog = 'Czarno-biały';
		break;
	case 8:
		$dog = 'Brązowo-biały';
		break;
	case 9:
		$dog = 'Czarno-brązowy';
		break;
	case 10:
		$dog = 'Czarno-biało-brązowy';
		break;
	case 11:
		$dog = 'Złoty';
		break;
	case 12:
		$dog = 'Zielony';
		break;
}

$edit = isset($_GET['edit']);
if ($edit && !can_edit($row['user_id'])) {
	no_access();
}

$disabled = 'disabled';
$value = 'placeholder';
if ($edit) {
	$disabled = '';
	$value = 'value';
}

?>
<div class="container rounded bg-white mt-5 mb-5">
	<?= ($edit ? '<form method="post" enctype="multipart/form-data">' : '') ?>
	<div class="row">
		<div class="col-md-4 border-right">
			<div class="d-flex flex-column align-items-center text-center p-3 py-5">
				<div class="profile-pic">
					<label class="upload-label <?= ($edit ? '' : 'hidden') ?>" for="file" <i class="bi bi-camera"></i><br>
						<span>Zmień awatar</span>
					</label>
					<input id="file" type="file" onchange="loadFile(event)" name="user-picture" />
					<img src="<?= $row["pfp"] /* ඞ */ ?>" id="profile-pic" />
					<script>
						var loadFile = function(event) {
							var image = document.getElementById("profile-pic");
							image.src = URL.createObjectURL(event.target.files[0]);
						};
					</script>
				</div>

				<span class="font-weight-bold">
					<?= $row["login"] ?>
				</span>
				<span class="text-black-50">
					<?= $row["email"] ?>
				</span>
				<span> </span>
			</div>
		</div>
		<div class="col-md-8 border-right">
			<div class="p-3 py-5">
				<div class="d-flex justify-content-between align-items-center mb-3">
					<h4 class="text-right"><?= ($edit ? 'Edytuj swój profil' : 'Profil użytkownika') ?></h4>
				</div>
				<div class="row mt-3">
					<div class="col-md-6">
						<label class="labels">Imię</label>
						<input type="text" class="form-control" <?= $value . '="' . $row['name'] . '"' ?> <?= $disabled ?> name="user-name">
					</div>
					<div class="col-md-6">
						<label class="labels">Nazwisko</label>
						<input type="text" class="form-control" <?= $value . '="' . $row['surname'] . '"' ?> <?= $disabled ?> name="user-surname">
					</div>
					<div class="col-md-12">
						<label class="labels">Adres</label>
						<input type="text" class="form-control" <?= $value . '="' . $row['address'] . '"' ?> <?= $disabled ?> name="user-address">
					</div>
					<div class="col-md-12">
						<label class="labels">Email</label>
						<input type="text" class="form-control" <?= $value . '="' . $row['email'] . '"' ?> <?= $disabled ?> name="user-email">
					</div>
					<div class="col-md-12">
						<label class="labels">Login</label>
						<input type="text" class="form-control" <?= $value . '="' . $row['login'] . '"' ?> <?= $disabled ?> name="user-login">
					</div>
					<div class="col-md-12">
						<label class="labels">Utworzono</label>
						<input type="text" class="form-control" placeholder="<?= $row["createdate"] ?>" disabled>
					</div>
					<div class="col-md-12">
						<label class="labels">Ostatnie logowanie</label>
						<input type="text" class="form-control" placeholder="<?= $row["logindate"] ?>" disabled>
					</div>
					<div class="col-md-12">
						<label class="labels">Pies</label>
						<input type="text" class="form-control" placeholder="<?= $dog ?>" disabled>
					</div>
				</div>
				<?php if (!$edit) { ?>
					<a href="?page=posts&user-id=<?= $row['user_id'] ?>" class="btn btn-outline-primary mt-3">Zobacz posty</a>
				<?php } ?>
				<?php if ($edit) { ?>
					<input type="hidden" name="user-edit-id" value="<?= $row['user_id'] ?>">
					<?php if (is_admin()) { ?>
						<button type="submit" class="btn btn-outline-danger mt-3" name="form-user-remove" onclick="removeConfirm(event)">Usuń profil</button>
						<script>
							function removeConfirm(event) {
								if (!confirm("Czy na pewno chcesz usunąć konto <?=$row['login'] ?>?\n\nZostaną usunięte wszystkie posty, komentarze oraz zdjęcia tego użytkownika.")) {
									event.preventDefault();
								}
							}
						</script>
					<?php } ?>
					<button type="submit" class="btn btn-outline-success mt-3 float-end" name="form-user-edit">Zapisz</button>
					<a class="btn btn-outline-secondary mt-3 me-3 float-end" href="?page=details&user-id=<?= $row['user_id'] ?>">Anuluj</a>
				<?php } elseif (can_edit($row['user_id'])) { ?>
					<a class="btn btn-outline-primary mt-3 float-end" href="?page=details&edit&user-id=<?= $row['user_id'] ?>">Edytuj</a>
				<?php } ?>
			</div>
		</div>
	</div>
	<?= ($edit ? '</form>' : '') ?>
</div>
<!--

⠄⠄⠄⠄⠄⠄⠄⠄⠄⢀⣤⣶⣿⣿⣿⣿⣿⣿⣿⣶⣄⠄⠄⠄⠄⠄⠄⠄⠄⠄
⠄⠄⠄⠄⠄⠄⠄⢀⣴⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣧⠄⠄⠄⠄⠄⠄⠄⠄
⠄⠄⠄⠄⠄⠄⢀⣾⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣧⠄⠄⠄⠄⠄⠄⠄
⠄⠄⠄⠄⠄⣴⡿⠛⠉⠁⠄⠄⠄⠄⠈⢻⣿⣿⣿⣿⣿⣿⣿⠄⠄⠄⠄⠄⠄⠄
⠄⠄⠄⠄⢸⣿⡅⠄⠄⠄⠄⠄⠄⠄⣠⣾⣿⣿⣿⣿⣿⣿⣿⣷⣶⣶⣦⠄⠄⠄
⠄⠄⠄⠄⠸⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣇⠄⠄
⠄⠄⠄⠄⠄⢸⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⠄⠄
⠄⠄⠄⠄⠄⢸⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⠄⠄
⠄⠄⠄⠄⠄⢸⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⠄⠄
⠄⠄⠄⠄⠄⢸⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⠄⠄
⠄⠄⠄⠄⠄⠘⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⠄⠄
⠄⠄⠄⠄⠄⠄⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⡟⠛⠛⠛⠃⠄⠄
⠄⠄⠄⠄⠄⣼⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⠄⠄⠄⠄⠄⠄
⠄⠄⠄⠄⢰⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⡇⠄⠄⠄⠄⠄
⠄⠄⠄⢀⣾⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⠄⠄⠄⠄⠄
⠄⠄⠄⣾⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⢻⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⡆⠄⠄⠄⠄
⠄⠄⢠⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⠃⠄⢿⣿⣿⣿⣿⣿⣿⣿⣿⣿⠇⠄⠄⠄⠄
⠄⠄⢸⣿⣿⣿⣿⣿⣿⣿⡿⠟⠁⠄⠄⠄⠻⣿⣿⣿⣿⣿⣿⣿⡿⠄⠄⠄⠄⠄
⠄⠄⢸⣿⣿⣿⣿⣿⡿⠋⠄⠄⠄⠄⠄⠄⠄⠙⣿⣿⣿⣿⣿⣿⡇⠄⠄⠄⠄⠄
⠄⠄⢸⣿⣿⣿⣿⣿⣧⡀⠄⠄⠄⠄⠄⠄⠄⢀⣾⣿⣿⣿⣿⣿⡇⠄⠄⠄⠄⠄
⠄⠄⢸⣿⣿⣿⣿⣿⣿⣿⡄⠄⠄⠄⠄⠄⠄⣿⣿⣿⣿⣿⣿⣿⣷⠄⠄⠄⠄⠄
⠄⠄⠸⣿⣿⣿⣿⣿⣿⣿⣷⠄⠄⠄⠄⠄⢰⣿⣿⣿⣿⣿⣿⣿⣿⠄⠄⠄⠄⠄
⠄⠄⠄⢿⣿⣿⣿⣿⣿⣿⡟⠄⠄⠄⠄⠄⠸⣿⣿⣿⣿⣿⣿⣿⠏⠄⠄⠄⠄⠄
⠄⠄⠄⠈⢿⣿⣿⣿⣿⠏⠄⠄⠄⠄⠄⠄⠄⠙⣿⣿⣿⣿⣿⠏⠄⠄⠄⠄⠄⠄
⠄⠄⠄⠄⠘⣿⣿⣿⣿⡇⠄⠄⠄⠄⠄⠄⠄⠄⣿⣿⣿⣿⡏⠄⠄⠄⠄⠄⠄⠄
⠄⠄⠄⠄⠄⢸⣿⣿⣿⣧⠄⠄⠄⠄⠄⠄⠄⢀⣿⣿⣿⣿⡇⠄⠄⠄⠄⠄⠄⠄
⠄⠄⠄⠄⠄⣸⣿⣿⣿⣿⣆⠄⠄⠄⠄⠄⢀⣾⣿⣿⣿⣿⣿⣄⠄⠄⠄⠄⠄⠄
⠄⣀⣀⣤⣾⣿⣿⣿⣿⡿⠟⠄⠄⠄⠄⠄⠸⣿⣿⣿⣿⣿⣿⣿⣷⣄⣀⠄⠄⠄
⠸⠿⠿⠿⠿⠿⠿⠟⠁⠄⠄⠄⠄⠄⠄⠄⠄⠄⠉⠉⠛⠿⢿⡿⠿⠿⠿⠃⠄⠄
-->
