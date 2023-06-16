<?php
require("db.php");

if (isset($_POST['dropcolumn'])){
    $db->query("ALTER TABLE `shukatsu_app`
    DROP `interview_$num`,
    DROP `check_$num`,
    DROP `memo_$num`;");
    header('Location: index.php');
}else{
    header('Location: index.php');
	exit();
}
?>
