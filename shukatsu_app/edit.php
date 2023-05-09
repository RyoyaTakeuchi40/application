<?php
require("db.php");

$postid = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
$stmt = $db -> prepare("SELECT * FROM `shukatsu_app` WHERE id=?");
$stmt -> bind_param("i", $postid);
$stmt -> execute();
$stmt -> bind_result($id, $name, $favorite, $es, $check_es, $memo_es, $test, $test_type, $int_1, $check_1, $memo_1, $int_2, $check_2, $memo_2, $int_3, $check_3, $memo_3, $result, $url);
$stmt -> fetch();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>編集画面</title>
    <style>
        .fromdb {
            margin: 0 12px;
        }
        textarea {
            resize: none;
            width: 100%;
            margin: auto;
        }
    </style>
</head>
<body>
    <form action="detail.php" method="get">
        <button type="submit" name="id" value="<?php echo H($id); ?>">キャンセル</button>
    </form>
    <form action="edit_do.php" method="post">
        <h3>会社名</h3>
        <div class="fromdb">
            <textarea name="name" cols="30" rows="1"><?php echo H($name); ?></textarea>
        </div>
        <h3>URL</h3>
        <div class="fromdb">
            <textarea name="url" cols="30" rows="1"><?php echo H($url); ?></textarea>
        </div>
        <h3>ES</h3>
        <div class="fromdb">
            <input type="date" name="es" value="<?php echo $es; ?>">
            <textarea name="memo_es" cols="30" rows="5"><?php echo H($memo_es); ?></textarea>
        </div>
        <h3>テスト</h3>
        <div class="fromdb">
            <input type="date" name="test" value="<?php echo $test; ?>">
            <select name="test_type" id="test_type">
                <option value="0" <?php if($test_type == 0){echo "selected";} ?>>なし</option>
                <option value="1" <?php if($test_type == 1){echo "selected";} ?>>SPI3</option>
                <option value="2" <?php if($test_type == 2){echo "selected";} ?>>CAB</option>
                <option value="3" <?php if($test_type == 3){echo "selected";} ?>>GAB</option>
                <option value="4" <?php if($test_type == 4){echo "selected";} ?>>技術テスト</option>
            </select>
        </div>
        <h3>1次面接</h3>
        <div class="fromdb">
            <input type="date" name="int_1" value="<?php echo $int_1; ?>">
            <textarea name="memo_1" cols="30" rows="5"><?php echo H($memo_1); ?></textarea>
        </div>
        <h3>2次面接</h3>
        <div class="fromdb">
            <input type="date" name="int_2" value="<?php echo $int_2; ?>">
            <textarea name="memo_2" cols="30" rows="5"><?php echo H($memo_2); ?></textarea>
        </div>
        <h3>3次面接</h3>
        <div class="fromdb">
            <input type="date" name="int_3" value="<?php echo $int_3; ?>">
            <textarea name="memo_3" cols="30" rows="5"><?php echo H($memo_3); ?></textarea>
        </div>
        <button typy="submit" name="id" value="<?php echo H($id); ?>">変更する</button>
    </form>
</body>
</html>

