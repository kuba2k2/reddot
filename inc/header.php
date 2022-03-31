<!DOCTYPE html>
<html lang="pl" class="h-100">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@6.5.95/css/materialdesignicons.min.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
	<link rel="stylesheet" href="style.css">
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
	<title>ReddoT</title>
</head>

<body class="d-flex flex-column h-100 container">

	<?php
	$menu = [
		'?page=post-edit' => '<i class="bi bi-plus-square"></i> Add Post',
		'?page=details' => 'Account details',
		'?page=posts' => 'Your poosts',
		'?page=details&edit' => 'Settings',
		'?logout' => 'Log out',
	];
	if ($_GET['page'] != 'welcome') {
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
							echo '<li class="nav-item"><a class="nav-link" href="'.$url.'">'.$text.'</a>';
						}
						?>
					</ul>
					<form class="d-flex">
						<input class="form-control me-2" type="search" placeholder="Search" style="flex-grow: 1;width: unset;">
						<button class="btn btn-outline-success" type="submit"><i class="bi bi-search"></i> Search</button>
					</form>
				</div>
			</div>
		</nav>

		<nav class="navbar navbar-light d-none d-lg-block">
			<form class="container-fluid">
				<a class="navbar-brand" href="index.php"><img src="lepszelogo.png" height="35px"></a>
				<input class="form-control me-2" type="search" placeholder="Search" style="flex-grow: 1;width: unset;">
				<button class="btn btn-outline-success me-2" type="submit"><i class="bi bi-search"></i> Search</button>
				<a href="?page=post-edit" class="btn btn-primary me-2" type="button"><i class="bi bi-plus-square"></i> Add Post</a>
				<div class="dropdown">
					<button class="btn dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
						Account
					</button>
					<ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
						<?php
						foreach ($menu as $url => $text) {
							echo '<li><a class="dropdown-item" href="'.$url.'">'.$text.'</a></li>';
						}
						?>
					</ul>
				</div>
			</form>
		</nav>
	<?php } ?>

	<?php
	show_messages($_GET['page'] == 'welcome' ? 'mt-3' : '');
	?>
