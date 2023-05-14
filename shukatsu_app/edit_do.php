<?php
require("db.php");
if(isset($_POST['id'])) {
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $url = filter_input(INPUT_POST, 'url', FILTER_SANITIZE_STRING);
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
    $check_es = filter_input(INPUT_POST, 'check_es', FILTER_SANITIZE_NUMBER_INT);
    $check_test = filter_input(INPUT_POST, 'check_test', FILTER_SANITIZE_NUMBER_INT);
    $check_1 = filter_input(INPUT_POST, 'check_1', FILTER_SANITIZE_NUMBER_INT);
    $check_2 = filter_input(INPUT_POST, 'check_2', FILTER_SANITIZE_NUMBER_INT);
    $check_3 = filter_input(INPUT_POST, 'check_3', FILTER_SANITIZE_NUMBER_INT);
    $result = filter_input(INPUT_POST, 'result', FILTER_SANITIZE_NUMBER_INT);


    $stmt = $db -> prepare("UPDATE `shukatsu_app` SET `name`=?,`url`=?,`es`=?,`es_memo`=?,`test`=?,`test_type`=?,`1_interview`=?,`2_interview`=?,`3_interview`=?,`1_memo`=?,`2_memo`=?,`3_memo`=?, `es_check`=?, `test_check`=?, `1_check`=?, `2_check`=?, `3_check`=?, `result`=? WHERE id=?");
    $stmt -> bind_param('sssssissssssiiiiiii', $name, $url, $es, $memo_es, $test, $test_type, $int_1, $int_2, $int_3, $memo_1, $memo_2, $memo_3, 
    $check_es, $check_test, $check_1, $check_2, $check_3, $result, $id);
    if ($stmt->execute()) {
        header('Location: detail.php?id=' . $id);
        exit();
    } else {
        error_log($stmt->error);
    }
}
?>