<?php

$db = 0;

function db_connect()
{
	// miła i sympatyczna funkcja do łączenia z bazą danych jeden raz
	global $db;
	if ($db)
		return;
	$db = new PDO('mysql:host=localhost;port=3306;dbname=reddot', 'root', 'zaq1@WSX');
	if (!$db) {
		add_message('danger', 1, 'Nie ma bazy :(');
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

function show_messages()
{
	if (!isset($_SESSION['messages'])) {
		$_SESSION['messages'] = [];
		return;
	}
	foreach ($_SESSION['messages'] as $message) {
?>
		<div class="alert alert-<?= $message['type'] ?>" role="alert">
			<?= $message['text'] ?>
		</div>
<?php
	}
	$_SESSION['messages'] = [];
}
