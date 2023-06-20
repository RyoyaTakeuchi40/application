<?php
require("./common/db.php");
require("./common/cntcolumn.php");

if (isset($_POST['dropcolumn'])){
    $db->query("ALTER TABLE `$user_name`
    DROP `interview_$num`,
    DROP `check_$num`,
    DROP `memo_$num`;");
    header('Location: index.php');
}else{
    header('Location: index.php');
	exit();
}
?>
