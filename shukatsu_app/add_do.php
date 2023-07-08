<?php
require("common/db.php");
require("common/cntcolumn.php");

if(isset($_POST['button'])) {
    // そのまま代入するとうまく動作しないから
    // queryに合わせるためのfunction*3
    function changeStr($value){
        if(empty($value)){
            $value = "NULL";
        }else{
            $value = "'" . $value . "'";
        }
        return $value;
    }

    function changeInt($value){
        if(empty($value)){
            $value = "0";
        }else{
            $value = "'" . $value . "'";
        }
        return $value;
    }

    // 今日の日付を取得
    $now = new DateTime();
    $now = $now -> format('Y-m-d');
    // 一致の判断をするために合わせる
    $now = "'" . $now . "'";
    
    function changeDate($value){
        $value = new DateTime($value); 
        $value = $value -> format('Y-m-d');
        $value = "'" . $value . "'";
        // 今日の日付と同じ場合に空欄になるようにする
        if($value == $GLOBALS['now']){
            $value = "NULL";
        }
        return $value;
    }

    // 値の取得
    $name = changeStr(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING));
    $es = changeDate(filter_input(INPUT_POST, 'es', FILTER_SANITIZE_STRING));
    $memo_es = changeStr(filter_input(INPUT_POST, 'memo_es', FILTER_SANITIZE_STRING));
    $test = changeDate(filter_input(INPUT_POST, 'test', FILTER_SANITIZE_STRING));
    $test_type = changeInt(filter_input(INPUT_POST, 'test_type', FILTER_SANITIZE_NUMBER_INT));
    for ($i=1;$i<=$num;$i++){
        //nameから取得するための変数を作成
        $ints = 'int_'.(string)$i;
        $memos = 'memo_'.(string)$i;
        ${'int_'.$i} = changeDate(filter_input(INPUT_POST, $ints, FILTER_SANITIZE_STRING));
        ${'memo_'.$i} = changeStr(filter_input(INPUT_POST, $memos, FILTER_SANITIZE_STRING));
    }
    $url = changeStr(filter_input(INPUT_POST, 'url', FILTER_SANITIZE_STRING));
    $login = changeStr(filter_input(INPUT_POST, 'login', FILTER_SANITIZE_STRING));

    // queryの作成
    $query = "INSERT INTO `$user_name` (`id`, `name`, `favorite`, `es`, `check_es`, `memo_es`, `test`, `test_type`, `check_test`, ";
    for ($i=1;$i<=$num;$i++){
        $query .= "`interview_" . $i . "`, `check_" . $i . "`, `memo_" . $i . "`, ";
    }
    $query .= "`result`, `url`, `login`) VALUES (NULL, " . $name . ", '0', " . $es . ", '0', " . $memo_es . ", " . $test . ", " . $test_type . ", '0', ";
    for ($i=1;$i<=$num;$i++){
        $query .= ${'int_'.$i} . ",  '0', " . ${'memo_'.$i} . ",  ";
    }
    $query .= "'0', " . $url . ", " . $login . ")";

    $result = $db->query($query);
    if ($result) {
        header('Location: index.php');
        exit();
    } else {
        echo $db->error;  // エラーメッセージを表示
    }
}else{
    header('Location: index.php');
	exit();
}
?>