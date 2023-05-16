<?php
require("db.php");
$result = $db->query("SELECT * FROM `sample_app`");
$count =  $result->field_count;

$befornum = ($count -1)/3;
$intnum = $befornum +1;

if ($db->query("ALTER TABLE `sample_app` 
ADD `int_$intnum` DATE NULL DEFAULT NULL AFTER `memo_$befornum`, 
ADD `check_$intnum` INT(11) NOT NULL DEFAULT '0' AFTER `int_$intnum`, 
ADD `memo_$intnum` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL AFTER `check_$intnum`")){
    echo "テーブルにカラムを追加しました。";
}else{
    error_log($stmt->error);
}
?>

<form action="home.php">
    <button type="submit">移動</button>
</form>