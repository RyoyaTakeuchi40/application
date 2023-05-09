<?php
require("db.php");

$gotid = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$stmt = $db -> prepare("SELECT * FROM `shukatsu_app` WHERE id=?");
$stmt -> bind_param("i", $gotid);
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
    <title>詳細画面</title>
    <style>
        textarea {
            resize: none;
            width: 100%;
        }
    </style>
</head>
<body>
    <form action="home.php">
        <button type="submit">戻る</button>
    </form>
    <h3>会社名</h3>
    <textarea name="name" id="name" rows="1"><?php echo H($name); ?></textarea>
    <h3>URL</h3>
    <textarea name="url" id="url" rows="1"><?php echo H($url); ?></textarea>
    <h3>ES</h3>
    <h3>テスト</h3>
    <?php
    if($test_type == 1){
        echo "SPI3";
    }elseif($test_type == 2){
        echo "CAB";
    }elseif($test_type == 3){
        echo "GAB";
    }elseif($test_type == 4){
        echo "技術テスト";
    }else{
        echo "なし";
    }
    ?>
    <h3>1次面接</h3>
    <h3>2次面接</h3>
    <h3>3次面接</h3>
</body>
</html>

