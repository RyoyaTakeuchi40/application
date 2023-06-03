<?php
require("db.php");
if(isset($_POST['delete'])) {
    $id = filter_input(INPUT_POST, 'delete', FILTER_SANITIZE_NUMBER_INT);
    $stmt = $db -> prepare("DELETE FROM `shukatsu_app` WHERE id = ?");
    $stmt -> bind_param("i", $id);
    if ($stmt->execute()) {
        header("Location:home.php");
    } else {
        error_log($stmt->error);
    }
}
?>