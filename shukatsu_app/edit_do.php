<?php
require("db.php");
if(isset($_POST['id'])) {
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $es = filter_input(INPUT_POST, 'es', FILTER_SANITIZE_STRING);
    //そのままdatetimeを作成すると値が入ってしまうから
    if(empty($es)){
        $es = null;
    }else{
        $es = new DateTime(filter_input(INPUT_POST, 'es', FILTER_SANITIZE_STRING));
        $es = $es -> format('Y-m-d');
    }
    $check_es = filter_input(INPUT_POST, 'check_es', FILTER_SANITIZE_NUMBER_INT);
    $memo_es = filter_input(INPUT_POST, 'memo_es', FILTER_SANITIZE_STRING);
    $test = filter_input(INPUT_POST, 'test', FILTER_SANITIZE_STRING);
    if(empty($test)){
        $test = null;
    }else{
        $test = new DateTime(filter_input(INPUT_POST, 'test', FILTER_SANITIZE_STRING));
        $test = $test -> format('Y-m-d');
    }
    $test_type = filter_input(INPUT_POST, 'test_type', FILTER_SANITIZE_NUMBER_INT);
    $check_test = filter_input(INPUT_POST, 'check_test', FILTER_SANITIZE_NUMBER_INT);

    for ($i=1;$i<=$num;$i++){
        //nameから取得するための変数を作成
        $ints = 'int_'.(string)$i;
        $checks = 'check_'.(string)$i;
        $memos = 'memo_'.(string)$i;
        
        ${'int_'.$i} = filter_input(INPUT_POST, $ints, FILTER_SANITIZE_STRING);
        if(empty(${'int_'.$i})){
            ${'int_'.$i} = null;
        }else{
            ${'int_'.$i} = new DateTime(filter_input(INPUT_POST, $ints, FILTER_SANITIZE_STRING));
            ${'int_'.$i} = ${'int_'.$i} -> format('Y-m-d');
        }
        ${'check_'.$i} = filter_input(INPUT_POST, $checks, FILTER_SANITIZE_NUMBER_INT);
        ${'memo_'.$i} = filter_input(INPUT_POST, $memos, FILTER_SANITIZE_STRING);
    }

    $result = filter_input(INPUT_POST, 'result', FILTER_SANITIZE_NUMBER_INT);
    $url = filter_input(INPUT_POST, 'url', FILTER_SANITIZE_STRING);
    $login = filter_input(INPUT_POST, 'login', FILTER_SANITIZE_STRING);

    //ループ以外の部分をbind
    $stmt = $db -> prepare("UPDATE `shukatsu_app` SET `name`=?, `url`=?, `login`=?, `es`=?, `memo_es`=?, `test`=?, `test_type`=?, `check_es`=?, `check_test`=?, `result`=? WHERE id=?");
    $stmt -> bind_param('ssssssiiiii', $name, $url, $login, $es, $memo_es, $test, $test_type, $check_es, $check_test, $result, $id);
    $stmt->execute();

    //ループ部分をbind
    for ($i=1;$i<=$num;$i++){
        $stmt = $db -> prepare("UPDATE `shukatsu_app` SET `interview_$i`=?, `check_$i`=?, `memo_$i`=? WHERE id=?");
        $stmt -> bind_param('sisi', ${'int_'.$i}, ${'check_'.$i}, ${'memo_'.$i}, $id);
        $stmt -> execute();
    }

    if ($stmt->execute()) {
        header('Location: detail.php?id=' . $id);
        exit();
    } else {
        error_log($stmt->error);
    }
}