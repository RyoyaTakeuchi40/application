<?php
require("db.php");
require("cntcolumn.php");

if (isset($_POST['id']) || isset($_GET['id'])){
}else{
    header('Location: index.php');
	exit();
}

if (!$postid = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING)){
    $postid = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);
}
$stmt = $db -> prepare("SELECT * FROM `$user_name` WHERE id=?");
$stmt -> bind_param("i", $postid);
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
//DBの面接の回数繰り返す繰り返す
for ($i=1;$i<=$num;$i++){
    //変数名を$int_1,$int_2,$int_3...と増やす
    ${'int_'.$i} = $row[$i*3+6];
    ${'check_'.$i} = $row[$i*3+7];
    ${'memo_'.$i} = $row[$i*3+8];
}
$result = $row[$num*3+9];
$url = $row[$num*3+10];
$login = $row[$num*3+11];
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
        <h3>ログインID</h3>
        <div class="fromdb">
            <textarea name="login" cols="30" rows="1"><?php echo H($login); ?></textarea>
        </div>
        <h3>ES</h3>
        <div class="fromdb">
            <select name="check_es" id="check_es">
                <!-- DBの値によってselectedが選択される -->
                <option value="0" <?php if($check_es == 0){echo "selected";} ?>></option>
                <option value="1" <?php if($check_es == 1){echo "selected";} ?>>選考中</option>
                <option value="2" <?php if($check_es == 2){echo "selected";} ?>>通過</option>
                <option value="3" <?php if($check_es == 3){echo "selected";} ?>>お祈り</option>
                <option value="4" <?php if($check_es == 4){echo "selected";} ?>>辞退</option>
            </select>
            <input type="date" name="es" value="<?php echo $es; ?>">
            <textarea name="memo_es" cols="30" rows="5"><?php echo H($memo_es); ?></textarea>
        </div>
        <h3>テスト</h3>
        <div class="fromdb">
            <select name="check_test" id="check_test">
                <option value="0" <?php if($check_test == 0){echo "selected";} ?>></option>
                <option value="1" <?php if($check_test == 1){echo "selected";} ?>>選考中</option>
                <option value="2" <?php if($check_test == 2){echo "selected";} ?>>通過</option>
                <option value="3" <?php if($check_test == 3){echo "selected";} ?>>お祈り</option>
                <option value="4" <?php if($check_test == 4){echo "selected";} ?>>辞退</option>
            </select>
            <input type="date" name="test" value="<?php echo $test; ?>">
            <select name="test_type" id="test_type">
                <option value="0" <?php if($test_type == 0){echo "selected";} ?>>なし</option>
                <option value="1" <?php if($test_type == 1){echo "selected";} ?>>SPI3</option>
                <option value="2" <?php if($test_type == 2){echo "selected";} ?>>CAB</option>
                <option value="3" <?php if($test_type == 3){echo "selected";} ?>>GAB</option>
                <option value="4" <?php if($test_type == 4){echo "selected";} ?>>技術テスト</option>
                <option value="5" <?php if($test_type == 5){echo "selected";} ?>>適性検査</option>
                <option value="6" <?php if($test_type == 6){echo "selected";} ?>>その他</option>
            </select>
        </div>
        <!-- DBの面接の回数繰り返す -->
        <?php for($i=1; $i<=$num; $i++): ?>
            <h3><?php echo $i; ?>次面接</h3>
            <div class="fromdb">
                <select name="check_<?php echo $i; ?>" id="check_<?php echo $i; ?>">
                    <option value="0" <?php if(${'check_'.$i} == 0){echo "selected";} ?>></option>
                    <option value="1" <?php if(${'check_'.$i} == 1){echo "selected";} ?>>選考中</option>
                    <option value="2" <?php if(${'check_'.$i} == 2){echo "selected";} ?>>通過</option>
                    <option value="3" <?php if(${'check_'.$i} == 3){echo "selected";} ?>>お祈り</option>
                    <option value="4" <?php if(${'check_'.$i} == 4){echo "selected";} ?>>辞退</option>
                </select>
                <input type="date" name="int_<?php echo $i; ?>" value="<?php echo ${'int_'.$i}; ?>">
                <textarea name="memo_<?php echo $i; ?>" cols="30" rows="3"><?php echo H(${'memo_'.$i}); ?></textarea>
            </div>
        <?php endfor; ?>
        <h3>結果</h3>
        <div class="fromdb">
            <select name="result" id="result">
                <option value="0" <?php if($result == 0){echo "selected";} ?>>選考中</option>
                <option value="1" <?php if($result == 1){echo "selected";} ?>>内定</option>
                <option value="2" <?php if($result == 2){echo "selected";} ?>>お祈り</option>
                <option value="3" <?php if($result == 3){echo "selected";} ?>>辞退</option>
            </select>
        </div>
        <button typy="submit" name="id" value="<?php echo H($id); ?>">変更する</button>
    </form>
    <div class="addcolumn">
            <form action="addcolumn.php" method="post">
                <input type="hidden" name="id" value="<?php echo $id ?>">
                <button type="submit" name="addcolumn">欄を追加</button>
            </form>
        </div>
</body>
</html>
