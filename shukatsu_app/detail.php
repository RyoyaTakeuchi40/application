<?php
require("common/db.php");
require("common/cntcolumn.php");

if (isset($_POST['id'])){
}else{
    header('Location: index.php');
	exit();
}

$postid = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
$stmt = $db -> prepare("SELECT * FROM `$user_name` WHERE id=?");
// $stmt = $db -> query("SELECT * FROM `$user_name`");
$stmt -> bind_param("i", $postid);
$stmt->execute();
$stmt->store_result();

// カラム数を取得
$num_of_fields = $stmt->field_count;

// カラム名の配列を初期化
$columns = array();

// カラムメタデータを取得
$meta = $stmt->result_metadata();
while ($field = $meta->fetch_field()) {
    $columns[] = &$row[$field->name];
}

// バインドされた変数に結果を格納
call_user_func_array(array($stmt, 'bind_result'), $columns);

// レコードを取得
$stmt->fetch();

//各要素を変数に格納
$id = $columns[0];
$name = $columns[1];
$favorite = $columns[2];
$es = $columns[3];
$check_es = $columns[4];
$memo_es = $columns[5];
$test = $columns[6];
$test_type = $columns[7];
$check_test = $columns[8];
// DBの面接の回数繰り返す繰り返す
for ($i=1;$i<=$num;$i++){
    // 変数名を$int_1,$int_2,$int_3...と増やす
    ${'int_'.$i} = $columns[$i*3+6];
    ${'check_'.$i} = $columns[$i*3+7];
    ${'memo_'.$i} = $columns[$i*3+8];
}
$result = $columns[($num*3)+9];
$url = $columns[($num*3)+10];
$login = $columns[($num*3)+11];
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>詳細画面</title>
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