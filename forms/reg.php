<?php

db_connect();

if(isset($_POST["reg-username"]) && isset($_POST["reg-password"]) && isset($_POST["reg-email"]) && isset($_POST["reg-passwordconfirm"])
&& isset($_POST["reg-name"]) && isset($_POST["reg-surname"]) && isset($_POST["reg-color"]) && isset($_POST["reg-address"])){
    if($_POST["reg-password"] == $_POST["reg-passwordconfirm"]){
        $stmt = $db->prepare("INSERT INTO `users`(`email`, `login`, `password`, `name`, `surname`, `address`, `dog`)
        VALUES (?,?,?,?,?,?,?)"); // ale to fajnewiem
        $stmt->execute([
            $_POST["reg-email"],
            $_POST["reg-username"],
            $_POST["reg-password"],
            $_POST["reg-name"],
            $_POST["reg-surname"],
            $_POST["reg-address"],
            $_POST["reg-color"],
        ]);
        add_message("success", 3, "zostałeś zajerestrowany");
    }
    else{
        add_message("danger", 3, "Hasła nie są takie same");
    }
}

?>
