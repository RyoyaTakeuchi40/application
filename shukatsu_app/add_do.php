<?php
require("db.php");
if(isset($_POST['button'])) {
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $url = filter_input(INPUT_POST, 'url', FILTER_SANITIZE_STRING);
    $login = filter_input(INPUT_POST, 'login', FILTER_SANITIZE_STRING);
    $cones = filter_input(INPUT_POST, 'es', FILTER_SANITIZE_STRING);
    if($cones == null){
        $es = null;
    }else{
        $es = new DateTime(filter_input(INPUT_POST, 'es', FILTER_SANITIZE_STRING));
        $es = $es -> format('Y-m-d');
    }
    $memo_es = filter_input(INPUT_POST, 'memo_es', FILTER_SANITIZE_STRING);
    $contest = filter_input(INPUT_POST, 'test', FILTER_SANITIZE_STRING);
    if($contest == null){
        $test = null;
    }else{
        $test = new DateTime(filter_input(INPUT_POST, 'test', FILTER_SANITIZE_STRING));
        $test = $test -> format('Y-m-d');
    }
    $test_type = filter_input(INPUT_POST, 'test_type', FILTER_SANITIZE_NUMBER_INT);
    $con1 = filter_input(INPUT_POST, 'int_1', FILTER_SANITIZE_STRING);
    if($con1 == null){
        $int_1 = null;
    }else{
        $int_1 = new DateTime(filter_input(INPUT_POST, 'int_1', FILTER_SANITIZE_STRING));
        $int_1 = $int_1 -> format('Y-m-d');
    }
    $con2 = filter_input(INPUT_POST, 'int_2', FILTER_SANITIZE_STRING);
    if($con2 == null){
        $int_2 = null;
    }else{
        $int_2 = new DateTime(filter_input(INPUT_POST, 'int_2', FILTER_SANITIZE_STRING));
        $int_2 = $int_2 -> format('Y-m-d');
    }
    $con3 = filter_input(INPUT_POST, 'int_3', FILTER_SANITIZE_STRING);
    if($con3 == null){
        $int_3 = null;
    }else{
        $int_3 = new DateTime(filter_input(INPUT_POST, 'int_3', FILTER_SANITIZE_STRING));
        $int_3 = $int_3 -> format('Y-m-d');
    }
    $memo_1 = filter_input(INPUT_POST, 'memo_1', FILTER_SANITIZE_STRING);
    $memo_2 = filter_input(INPUT_POST, 'memo_2', FILTER_SANITIZE_STRING);
    $memo_3 = filter_input(INPUT_POST, 'memo_3', FILTER_SANITIZE_STRING);

    $stmt = $db -> prepare("INSERT INTO `shukatsu_app` (`name`,`url`,`login`,`es`,`memo_es`,`test`,`test_type`,`interview_1`,`interview_2`,`interview_3`,`memo_1`,`memo_2`,`memo_3`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    if (!$stmt) {
        echo $db->error;  // エラーメッセージを表示
    }
    $stmt -> bind_param('ssssssissssss', $name, $url, $login, $es, $memo_es, $test, $test_type, $int_1, $int_2, $int_3, $memo_1, $memo_2, $memo_3);
    if ($stmt->execute()) {
        header('Location: index.php');
        exit();
    } else {
        echo $stmt->error;  // エラーメッセージを表示
    }
}else{
    header('Location: index.php');
	exit();
}
?>