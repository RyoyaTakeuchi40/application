<?php
require("dbconnect.php");
if(isset($_POST['add'])) {
    $company_name = filter_input(INPUT_POST, 'company_name', FILTER_SANITIZE_STRING);
    $type = filter_input(INPUT_POST, 'type', FILTER_SANITIZE_STRING);
    $deadline = new DateTime(filter_input(INPUT_POST, 'deadline', FILTER_SANITIZE_STRING));
    $deadline = $deadline -> format('Y-m-d');
    $url = filter_input(INPUT_POST, 'url', FILTER_SANITIZE_STRING);
    $memo = filter_input(INPUT_POST, 'memo', FILTER_SANITIZE_STRING);
    $stmt = $db -> prepare("INSERT INTO `applications` (`id`, `completed`, `company_name`, `type`, `deadline`, `url`, `memo`) VALUES (NULL, '0', ?, ?, ?, ?, ?)");
    $stmt -> bind_param('sssss', $company_name, $type, $deadline, $url, $memo);
    if ($stmt->execute()) {
        header('Location: application.php');
        exit();
    } else {
        error_log($stmt->error);
    }
}
?>