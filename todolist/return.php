<?php
require("dbconnect.php");
if(isset($_POST['return'])) {
    $id = filter_input(INPUT_POST, 'return', FILTER_SANITIZE_NUMBER_INT);
    $stmt = $db -> prepare("UPDATE `applications` SET `completed`='0' WHERE id=?");
    $stmt -> bind_param("i", $id);
    if ($stmt->execute()) {
        header("Location:application.php");
    } else {
        error_log($stmt->error);
    }
}
?>