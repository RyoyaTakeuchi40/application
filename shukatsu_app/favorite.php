<?php
require("common/db.php");
require("common/cntcolumn.php");

if(isset($_POST['favorite'])) {
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    $display = filter_input(INPUT_POST, 'display', FILTER_SANITIZE_STRING);
    $favorite = filter_input(INPUT_POST, 'favorite', FILTER_SANITIZE_NUMBER_INT);

    $stmt = $db -> prepare("UPDATE `$user_name` SET `favorite`=? WHERE id=?");
    $stmt -> bind_param('ii', $favorite, $id);
    if ($stmt->execute()) {
        header('Location: index.php?display=' . $display);
        exit();
    } else {
        error_log($stmt->error);
    }
}else{
    header('Location: index.php');
	exit();
}
?>