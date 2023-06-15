<?php
require("db.php");

if ($db->query("ALTER TABLE `shukatsu_app`
DROP `interview_$num`,
DROP `check_$num`,
DROP `memo_$num`;")){
    header('Location: index.php');
}else{
    console_log($db);
}
?>
