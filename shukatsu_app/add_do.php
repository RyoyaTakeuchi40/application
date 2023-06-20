<?php
require("db.php");
require("cntcolumn.php");

if(isset($_POST['button'])) {
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    //そのまま代入するとうまく動作しないから
    if(empty($name)){
        $name = "NULL";
    }else{
        $name = "'" . $name . "'";
    }
    $es = new DateTime(filter_input(INPUT_POST, 'es', FILTER_SANITIZE_STRING));
    if(empty($es)){
        $es = "NULL";
    }else{
        $es = $es -> format('Y-m-d');
        $es = "'" . $es . "'";
    }
    $memo_es = filter_input(INPUT_POST, 'memo_es', FILTER_SANITIZE_STRING);
    if(empty($memo_es)){
        $memo_es = "NULL";
    }else{
        $memo_es = "'" . $memo_es . "'";
    }
    $test = new DateTime(filter_input(INPUT_POST, 'test', FILTER_SANITIZE_STRING));
    if(empty($test)){
        $test = "NULL";
    }else{
        $test = $test -> format('Y-m-d');
        $test = "'" . $test . "'";
    }
    $test_type = filter_input(INPUT_POST, 'test_type', FILTER_SANITIZE_NUMBER_INT);
    if(empty($test_type)){
        $test_type = "0";
    }else{
        $test_type = "'" . $test_type . "'";
    }
    for ($i=1;$i<=$num;$i++){
        //nameから取得するための変数を作成
        $ints = 'int_'.(string)$i;
        $memos = 'memo_'.(string)$i;
        
        ${'int_'.$i} = new DateTime(filter_input(INPUT_POST, $ints, FILTER_SANITIZE_STRING));
        if(empty(${'int_'.$i})){
            ${'int_'.$i} = "NULL";
        }else{
            ${'int_'.$i} = ${'int_'.$i} -> format('Y-m-d');
            ${'int_'.$i} = "'" . ${'int_'.$i} . "'";
        }
        ${'memo_'.$i} = filter_input(INPUT_POST, $memos, FILTER_SANITIZE_STRING);
        if(empty(${'memo_'.$i})){
            ${'memo_'.$i} = "NULL";
        }else{
            ${'memo_'.$i} = ${'memo_'.$i} -> format('Y-m-d');
            ${'memo_'.$i} = "'" . ${'memo_'.$i} . "'";
        }
    }
    $url = filter_input(INPUT_POST, 'url', FILTER_SANITIZE_STRING);
    if(empty($url)){
        $url = "NULL";
    }else{
        $url = "'" . $url . "'";
    }
    $login = filter_input(INPUT_POST, 'login', FILTER_SANITIZE_STRING);
    if(empty($login)){
        $login = "NULL";
    }else{
        $login = "'" . $login . "'";
    }

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

    var_dump($query . "<br>" . "<br>");

    $result = $db->query($query);
    if ($result) {
        echo '成功！！';
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