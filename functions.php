<?php

$db = 0;

function db_connect()
{
	// miła i sympatyczna funkcja do łączenia z bazą danych jeden raz
	global $db;
	if ($db)
		return;
	try {
		$db = new PDO('mysql:host=localhost;port=3306;dbname=reddot', 'reddot', 'zaq1@WSX');
	} catch (PDOException $e) {
		if (!$db) {
			add_message('danger', 1, 'Nie ma bazy :(');
			show_messages('');
			exit;
		}
	}
}

function is_logged_in()
{
	return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] && $_SESSION['user_id'];
}

function is_admin()
{
	return is_logged_in() && $_SESSION['role'] == 'ADMIN';
}

function can_edit($user_id)
{
	return is_logged_in() && (is_admin() || $user_id == $_SESSION["user_id"]);
}

function is_form_complete($fields)
{
	foreach ($fields as $field) {
		if (!isset($_POST[$field])) {
			return false;
		}
	}
	return true;
}

function fix_pfp(&$user)
{
	if (empty($user['pfp'])) {
		$user['pfp'] = 'user.png';
	}
}

function update_session($user)
{
	$_SESSION['logged_in'] = true;
	$_SESSION['user_id'] = $user['user_id'];
	$_SESSION['login'] = $user['login'];
	$_SESSION['role'] = $user['role'];
	$_SESSION['name'] = $user['name'];
	$_SESSION['surname'] = $user['surname'];
	$_SESSION['pfp'] = $user['pfp'];
}

function add_message($type, $code, $text, $field = null)
{
	// dodaj wiadomość do wyświetlenia na stronie
	$_SESSION['messages'][] = [
		'type' => $type,
		'code' => $code,
		'text' => $text,
		'field' => $field,
	];
}

function no_access() {
	add_message('warning', 1, 'Nie masz uprawnień do wykonania tej akcji! Przekierowano na stronę główną.');
	header('Location: index.php');
	exit;
}

function not_logged_in() {
	add_message('warning', 2, 'Musisz być zalogowany.');
	header('Location: index.php');
	exit;
}

function show_messages($cls)
{
	if (!isset($_SESSION['messages'])) {
		$_SESSION['messages'] = [];
		return;
	}
	foreach ($_SESSION['messages'] as $message) {
?>
		<div class="alert alert-<?= $message['type'] ?> <?= $cls ?>" role="alert">
			<?= $message['text'] ?>
		</div>
<?php
	}
	$_SESSION['messages'] = [];
}
