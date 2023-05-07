<?php
require("dbconnect.php");
$postid = filter_input(INPUT_POST, 'detail', FILTER_SANITIZE_NUMBER_INT);
$stmt = $db -> prepare("SELECT * FROM `applications` WHERE id=?");
$stmt -> bind_param("i", $postid);
$stmt -> execute();
$stmt -> bind_result($id, $completed, $company_name, $type, $deadline, $url, $memo);
$stmt -> fetch();
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>詳細</title>
</head>
<body>
    <?php if ($completed === 0): ?>
        <h2>未完了のタスク</h2>
    <?php else: ?>
        <h2>完了済みのタスク</h2>
    <?php endif; ?>
    <form action="edit.php" method="post">
        <p>会社名</p>
        <input type="text" name="company_name" size="35" value="<?php echo $company_name; ?>" required>
        <p>種類</p>
        <input type="text" name="type" value="<?php echo $type; ?>">
        <p>期日</p>
        <input type="date" name="deadline" value="<?php echo $deadline; ?>">
        <p>URL</p>
        <input type="text" name="url" value="<?php echo $url; ?>">
        <p>メモ</p>
        <input type="text" name="memo" value="<?php echo $memo; ?>">
        <br>
        <button type="submit" name="edit" value="<?php echo $id; ?>">編集する</button>
    </form>
    <form action="delete.php" method="post">
        <button type="submit" name="delete" value="<?php echo $id; ?>">削除する</button>
    </form>
    <form action="application.php">
        <button type="submit">戻る</button>
    </form>
</body>
</html>