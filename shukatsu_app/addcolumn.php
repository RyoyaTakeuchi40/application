<?php
require("db.php");

if ($db->query("ALTER TABLE `shukatsu_app` 
ADD `interview_$newnum` DATE NULL DEFAULT NULL AFTER `memo_$num`, 
ADD `check_$newnum` INT(11) NOT NULL DEFAULT '0' AFTER `interview_$newnum`, 
ADD `memo_$newnum` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL AFTER `check_$newnum`")){
    //edit.phpから飛んできた場合、カラム追加後、元のページに戻る
    if(isset($_POST['id'])) {
        $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
        header('Location: edit.php?id=' . $id);
    }
    header('Location: home.php');
}else{
    echo "クエリの実行に失敗しました: " . $db->error;
}
?>
