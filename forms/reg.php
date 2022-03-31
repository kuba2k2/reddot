<?php

db_connect();

$fields = [
    'reg-username',
    'reg-email',
    'reg-password',
    'reg-passwordconfirm',
    'reg-name',
    'reg-surname',
    'reg-color',
    'reg-address',
];

if (!is_form_complete($fields)) {
    if ($_POST['reg-password'] == $_POST['reg-passwordconfirm']) {
        $stmt = $db->prepare("INSERT INTO `users`(`email`, `login`, `password`, `name`, `surname`, `address`, `dog`)
        VALUES (?,?,?,?,?,?,?)"); // ale to fajnewiem
        $stmt->execute([
            $_POST['reg-email'],
            $_POST['reg-username'],
            $_POST['reg-password'],
            $_POST['reg-name'],
            $_POST['reg-surname'],
            $_POST['reg-address'],
            $_POST['reg-color'],
        ]);
        add_message('success', 3, 'Zostałeś zajerestrowany');
    } else {
        add_message('danger', 6, "Hasła nie są takie same");
    }
} else {
    add_message('danger', 7, 'Brakujące pola w formularzu!');
}
