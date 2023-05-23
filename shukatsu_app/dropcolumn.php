<?php
require("db.php");

if ($num == 1){
?>
<p>これ以上欄を減らせません</p>
<form action="home.php" method="post">
    <button type="submit">戻る</button>
</form>

<?php
}elseif ($db->query("ALTER TABLE `shukatsu_app`
DROP `interview_$num`,
DROP `check_$num`,
DROP `memo_$num`;")){
    header('Location: home.php');
}else{
    error_log($db->error);
}
?>
