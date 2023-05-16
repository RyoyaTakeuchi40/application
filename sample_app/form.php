<?php
require("db.php");

if ($db->query("ALTER TABLE `sample_app` 
ADD `int_$newnum` DATE NULL DEFAULT NULL AFTER `memo_$num`, 
ADD `check_$newnum` INT(11) NOT NULL DEFAULT '0' AFTER `int_$newnum`, 
ADD `memo_$newnum` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL AFTER `check_$newnum`")){
    echo "テーブルにカラムを追加しました。";
}else{
    error_log($stmt->error);
}
?>

<form action="home.php">
    <button type="submit">移動</button>
</form>