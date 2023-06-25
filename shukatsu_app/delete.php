<?php
require("common/db.php");
require("common/cntcolumn.php");

if(isset($_POST['delete'])) {
    $id = filter_input(INPUT_POST, 'delete', FILTER_SANITIZE_NUMBER_INT);
    $stmt = $db -> prepare("DELETE FROM `$user_name` WHERE id = ?");
    $stmt -> bind_param("i", $id);
    if ($stmt->execute()) {
        header("Location:index.php");
    } else {
        error_log($stmt->error);
    }
}else{
    header('Location: index.php');
	exit();
}
?>