<?php
require("db.php");
if(isset($_POST['id'])) {
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $url = filter_input(INPUT_POST, 'url', FILTER_SANITIZE_STRING);
    $es = new DateTime(filter_input(INPUT_POST, 'es', FILTER_SANITIZE_STRING));
    $es = $es -> format('Y-m-d');
    $memo_es = filter_input(INPUT_POST, 'memo_es', FILTER_SANITIZE_STRING);
    $test = new DateTime(filter_input(INPUT_POST, 'test', FILTER_SANITIZE_STRING));
    $test = $test -> format('Y-m-d');
    $test_type = filter_input(INPUT_POST, 'test_type', FILTER_SANITIZE_NUMBER_INT);
    $int_1 = new DateTime(filter_input(INPUT_POST, 'int_1', FILTER_SANITIZE_STRING));
    $int_1 = $int_1 -> format('Y-m-d');
    $int_2 = new DateTime(filter_input(INPUT_POST, 'int_2', FILTER_SANITIZE_STRING));
    $int_2 = $int_2 -> format('Y-m-d');
    $int_3 = new DateTime(filter_input(INPUT_POST, 'int_3', FILTER_SANITIZE_STRING));
    $int_3 = $int_3 -> format('Y-m-d');
    $memo_1 = filter_input(INPUT_POST, 'memo_1', FILTER_SANITIZE_STRING);
    $memo_2 = filter_input(INPUT_POST, 'memo_2', FILTER_SANITIZE_STRING);
    $memo_3 = filter_input(INPUT_POST, 'memo_3', FILTER_SANITIZE_STRING);

    $stmt = $db -> prepare("UPDATE `shukatsu_app` SET `name`=?,`url`=?,`es`=?,`es_memo`=?,`test`=?,`test_type`=?,`1_interview`=?,`2_interview`=?,`3_interview`=?,`1_memo`=?,`2_memo`=?,`3_memo`=? WHERE id=?");
    $stmt -> bind_param('sssssissssssi', $name, $url, $es, $memo_es, $test, $test_type, $int_1, $int_2, $int_3, $memo_1, $memo_2, $memo_3, $id);
    if ($stmt->execute()) {
        header('Location: detail.php?id=' . $id);
        exit();
    } else {
        error_log($stmt->error);
    }
}
?>