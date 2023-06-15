<?php
require("db.php");

$gotid = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$stmt = $db -> prepare("SELECT * FROM `shukatsu_app` WHERE id=?");
$stmt -> bind_param("i", $gotid);
$stmt -> execute();
//要素を配列で取得
$result = $stmt->get_result();
$row = $result->fetch_array(MYSQLI_NUM);
//各要素を変数に格納
$id = $row[0];
$name = $row[1];
$favorite = $row[2];
$es = $row[3];
$check_es = $row[4];
$memo_es = $row[5];
$test = $row[6];
$test_type = $row[7];
$check_test = $row[8];
for ($i=1;$i<=$num;$i++){
    ${'int_'.$i} = $row[$i*3+6];
    ${'check_'.$i} = $row[$i*3+7];
    ${'memo_'.$i} = $row[$i*3+8];
}
$result = $row[($num*3)+9];
$url = $row[($num*3)+10];
$login = $row[($num*3)+11];
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>詳細画面</title>
    <style>
        p {
            border: solid 1px;
        }
        .fromdb {
            margin: 0 12px;
        }
    </style>
</head>
<body>
    <form action="index.php" method="post">
        <button type="submit">戻る</button>
    </form>
    <form action="edit.php" method="post">
        <button type="submit" name="id" value="<?php echo $id; ?>">編集する</button>
    </form>
    <form action="delete.php" method="post" onsubmit="return check();">
        <button type="submit" name="delete" value="<?php echo $id; ?>">削除する</button>
    </form>
    <script>
        //本当に削除するか確認作業
        function check(){
            var comfirm = window.confirm('本当に削除しますか？');
            if (comfirm){
                //delete.phpに遷移
                alert('削除されました。')
            }else{
                //戻る
                return false;
            }  
        }
    </script>

    <h3>会社名</h3>
    <div class="fromdb">
        <p><?php echo H($name); ?></p>
    </div>
    <h3>URL</h3>
    <div class="fromdb">
        <a href="<?php echo H($url); ?>"><p><?php echo H($url); ?></p></a>
    </div>
    <h3>ログインID</h3>
    <div class="fromdb">
        <p><?php echo H($login); ?></p>
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
        }elseif($test_type == 5){
            echo "適性検査";
        }elseif($test_type == 6){
            echo "その他";
        }else{
            echo "なし";
        }
        ?></p>
    </div>
    <!-- DBの面接の回数繰り返す -->
    <?php for($i=1; $i<=$num; $i++): ?>
        <!-- 内容が入力されている場合のみ表示 -->
        <?php if (!empty(${'int_'.$i})): ?>
        <h3><?php echo $i; ?>次面接</h3>
            <div class="fromdb">
                <p>
                    <?php
                    if(${'check_'.$i} == 1){
                        echo "選考中";
                    }elseif(${'check_'.$i} == 2){
                        echo "通過";
                    }elseif(${'check_'.$i} == 3){
                        echo "お祈り";
                    }elseif(${'check_'.$i} == 4){
                        echo "辞退";
                    }else{
                        echo "";
                    }
                    ?>
                </p>
                <p><?php echo D(${'int_'.$i}); ?></p>
                <p><?php echo H(${'memo_'.$i}); ?></p>
            </div>
        <?php endif; ?>
    <?php endfor; ?>
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