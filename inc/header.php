<!DOCTYPE html>
<html lang="pl" class="h-100">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@6.5.95/css/materialdesignicons.min.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
	<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
	<link rel="stylesheet" href="style.css">
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
	<title>ReddoT</title>
</head>

<?php
$welcome = $_GET['page'] == 'welcome';
?>

<body class="h-100 d-flex flex-column">
	<div class="d-flex flex-column container mb-3 <?= ($welcome ? 'h-100' : '') ?>">

		<?php
		$menu = [
			'?page=post-edit' => '<i class="bi bi-plus-square"></i> Dodaj post',
			'?page=details' => 'Profil',
			'?page=posts' => 'Twoje posty',
			'?page=details&edit' => 'Ustawienia',
			'?logout' => 'Wyloguj się',
		];
		if (!$welcome) {
		?>
			<nav class="navbar navbar-expand-lg navbar-light bg-light d-lg-none">
				<div class="container-fluid">
					<a class="navbar-brand" href="index.php"><img src="lepszelogo.png" height="35px"></a>
					<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
						<span class="navbar-toggler-icon"></span>
					</button>
					<div class="collapse navbar-collapse" id="navbarTogglerDemo02">
						<ul class="navbar-nav me-auto mb-2 mb-lg-0">
							<?php
							foreach ($menu as $url => $text) {
								echo '<li class="nav-item"><a class="nav-link" href="' . $url . '">' . $text . '</a>';
							}
							?>
						</ul>
						<form class="d-flex">
							<input class="form-control me-2" type="search" placeholder="Szukaj" style="flex-grow: 1;width: unset;">
							<button class="btn btn-outline-success" type="submit"><i class="bi bi-search"></i> Szukaj</button>
						</form>
					</div>
				</div>
			</nav>

			<nav class="navbar navbar-light d-none d-lg-block">
				<form class="container-fluid">
					<a class="navbar-brand" href="index.php"><img src="lepszelogo.png" height="35px"></a>
					<input class="form-control me-2" type="search" placeholder="Szukaj" style="flex-grow: 1;width: unset;">
					<button class="btn btn-outline-success me-2" type="submit"><i class="bi bi-search"></i> Szukaj</button>
					<a href="?page=post-edit" class="btn btn-primary me-2" type="button"><i class="bi bi-plus-square"></i> Dodaj post</a>
					<div class="dropdown account-dropdown">
						<button class="btn dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
							<?php fix_pfp($_SESSION); ?>
							<div class="user-image image" style="background-image: url(<?= $_SESSION['pfp'] ?>);"></div>
							<span class="ms-2">
								<a class="a-black" href="?page=details&user-id=<?= $_SESSION['user_id'] ?>">
									<?= $_SESSION['login'] ?>
								</a>
							</span>
						</button>
						<ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
							<?php
							foreach ($menu as $url => $text) {
								echo '<li><a class="dropdown-item" href="' . $url . '">' . $text . '</a></li>';
							}
							?>
						</ul>
					</div>
				</form>
			</nav>
		<?php } ?>

		<?php
		show_messages($welcome ? 'mt-3' : '');
		?>
