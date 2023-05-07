<?php
require("dbconnect.php");
if(isset($_POST['delete'])) {
    $id = filter_input(INPUT_POST, 'delete', FILTER_SANITIZE_NUMBER_INT);
    $stmt = $db -> prepare("DELETE FROM `applications` WHERE id = ?");
    $stmt -> bind_param("i", $id);
    if ($stmt->execute()) {
        header("Location:application.php");
    } else {
        error_log($stmt->error);
    }
}
?>