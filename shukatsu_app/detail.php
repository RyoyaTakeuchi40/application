<?php
require("db.php");

$gotid = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$stmt = $db -> prepare("SELECT * FROM `shukatsu_app` WHERE id=?");
$stmt -> bind_param("i", $gotid);
$stmt -> execute();
$stmt -> bind_result($id, $name, $favorite, $es, $check_es, $memo_es, $test, $test_type, $check_test, $int_1, $check_1, $memo_1, $int_2, $check_2, $memo_2, $int_3, $check_3, $memo_3, $result, $url);
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
        .fromdb {
            margin: 0 12px;
        }
    </style>
</head>
<body>
    <form action="home.php" method="post">
        <button type="submit">戻る</button>
    </form>
    <form action="edit.php" method="post">
        <button type="submit" name="id" value="<?php echo $id; ?>">編集する</button>
    </form>
    <h3>会社名</h3>
    <div class="fromdb">
        <p><?php echo H($name); ?></p>
    </div>
    <h3>URL</h3>
    <div class="fromdb">
        <p><a href="<?php echo H($url); ?>"><?php echo H($url); ?></a></p>
    </div>
    <h3>ES</h3>
    <div class="fromdb">
        <p>
            <?php
            if($check_es == 1){
                echo "選考中";
            }elseif($check_es == 2){
                echo "通過";
            }elseif($check_es == 3){
                echo "お祈り";
            }elseif($check_es == 4){
                echo "辞退";
            }else{
                echo "";
            }
            ?>
        </p>
        <p><?php echo D($es); ?></p>
        <p><?php echo H($memo_es); ?></p>
    </div>
    <h3>テスト</h3>
    <div class="fromdb">
        <p>
            <?php
            if($check_test == 1){
                echo "選考中";
            }elseif($check_test == 2){
                echo "通過";
            }elseif($check_test == 3){
                echo "お祈り";
            }elseif($check_test == 4){
                echo "辞退";
            }else{
                echo "";
            }
            ?>
        </p>
        <p><?php echo D($test); ?></p>
        <p><?php
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
        ?></p>
    </div>
    <h3>1次面接</h3>
    <div class="fromdb">
        <p>
            <?php
            if($check_1 == 1){
                echo "選考中";
            }elseif($check_1 == 2){
                echo "通過";
            }elseif($check_1 == 3){
                echo "お祈り";
            }elseif($check_1 == 4){
                echo "辞退";
            }else{
                echo "";
            }
            ?>
        </p>
        <p><?php echo D($int_1); ?></p>
        <p><?php echo H($memo_1); ?></p>
    </div>
    <h3>2次面接</h3>
    <div class="fromdb">
        <p>
            <?php
            if($check_2 == 1){
                echo "選考中";
            }elseif($check_2 == 2){
                echo "通過";
            }elseif($check_2 == 3){
                echo "お祈り";
            }elseif($check_2 == 4){
                echo "辞退";
            }else{
                echo "";
            }
            ?>
        </p>
        <p><?php echo D($int_2); ?></p>
        <p><?php echo H($memo_2); ?></p>
    </div>
    <h3>3次面接</h3>
    <div class="fromdb">
        <p>
            <?php
            if($check_3 == 1){
                echo "選考中";
            }elseif($check_3 == 2){
                echo "通過";
            }elseif($check_3 == 3){
                echo "お祈り";
            }elseif($check_3 == 4){
                echo "辞退";
            }else{
                echo "";
            }
            ?>
        </p>
        <p><?php echo D($int_3); ?></p>
        <p><?php echo H($memo_3); ?></p>
    </div>
    <h3>結果</h3>
    <div class="fromdb">
        <p>
            <?php
            if($result == 1){
                echo "内定";
            }elseif($result == 2){
                echo "お祈り";
            }elseif($result == 3){
                echo "辞退";
            }else{
                echo "選考中";
            }
            ?>
        </p>
    </div>
</body>
</html>
