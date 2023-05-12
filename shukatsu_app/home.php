<?php
require("db.php");

$fo = ['display' => ''];
$fo['display'] = filter_input(INPUT_POST, 'display', FILTER_SANITIZE_STRING);

//テーブルから表示内容を選択してデータを取得
if ($fo['display'] == 'favorite'){
    $result = $db->query("SELECT * FROM `shukatsu_app` WHERE `favorite`=1");
    if (!$result) {
        echo "表示する内容がありません";
    }
}elseif ($fo['display'] == 'mid'){
    $result = $db->query("SELECT * FROM `shukatsu_app` WHERE `result`=0");
    if (!$result) {
        echo "表示する内容がありません";
    }
}elseif ($fo['display'] == 'offered'){
    $result = $db->query("SELECT * FROM `shukatsu_app` WHERE `result`=1");
    if (!$result) {
        echo "表示する内容がありません";
    }
}else{
    $result = $db->query("SELECT * FROM `shukatsu_app`");
    if (!$result) {
        echo "表示する内容がありません";
    }
}

//取得したデータを配列に格納
$companies = array();
while ($row = mysqli_fetch_assoc($result)) {
    $companies[] = $row;
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>一覧画面</title>
    <style>
        table {
			border-collapse: collapse;
			margin-bottom: 20px;
		}
		th, td {
			border: 1px solid #ddd;
			padding: 8px;
			text-align: center;
		}
		th {
			background-color: #f2f2f2;
		}
        .company_1{
			background-color: #0ff;
        }
        .company_2{
			background-color: #999;
        }
    </style>
</head>
<body>
    <div class="comtainer">
        <div class="addbutton">
            <form action="add.php" method="post">
                <button type="submit" name="add">追加する</button>
            </form>
        </div>
        <div class="displaybuttons">
            <form action="" method="post">
                <button type="submit" name="display" value="all">すべてを表示</button>
            </form>      
            <form action="" method="post">
                <button type="submit" name="display" value="favorite">気になるだけを表示</button>
            </form>
            <form action="" method="post">
                <button type="submit" name="display" value="mid">選考中だけを表示</button>
            </form>
            <form action="" method="post">
                <button type="submit" name="display" value="offered">内定を表示</button>
            </form>
        </div>
        <table>
            <tr>
                <th>会社名</th>
                <th>気になる</th>
                <th>ES</th>
                <th>結果</th>
                <th>テスト</th>
                <th>1次面接</th>
                <th>結果</th>
                <th>2次面接</th>
                <th>結果</th>
                <th>3次面接</th>
                <th>結果</th>
                <th>最終結果</th>
            </tr> 
            <div class="content">
                <?php foreach ($companies as $company) : ?>
                    <tr class="company_<?php echo H($company['result']) ?>">
                        <!-- tableの1つの箱がまるごとリンクになるようにするにはどうしたらいいですか -->
                        <!-- JSのonclickだとphpがうまく動作しないので嫌です -->
                        <td><a href="detail.php?id=<?php echo H($company['id']); ?>"><?php echo H($company['name']); ?></td></a>
                        <td>
                            <form action="favorite.php" method="post">
                                <input type="hidden" name="id" value="<?php echo H($company['id']); ?>">
                                <input type="hidden" name="favorite" value="0">
                                <input type="checkbox" name="favorite" value="1" onchange="this.form.submit();" <?php if($company['favorite'] == 1){ echo "checked";} ?>>
                            </form>
                        </td>
                        <td class="es"><?php echo D($company['es']); ?></td>
                        <td class="es">
                            <?php
                            if($company['es_check'] == 1){
                                echo "選考中";
                            }elseif($company['es_check'] == 2){
                                echo "通過";
                            }elseif($company['es_check'] == 3){
                                echo "お祈り";
                            }elseif($company['es_check'] == 4){
                                echo "辞退";
                            }else{
                                echo "";
                            }
                            ?>
                        </td>
                        <td class="test">
                            <?php
                            if($company['test_type'] == 1){
                                echo "SPI3";
                            }elseif($company['test_type'] == 2){
                                echo "CAB";
                            }elseif($company['test_type'] == 3){
                                echo "GAB";
                            }elseif($company['test_type'] == 4){
                                echo "技術テスト";
                            }else{
                                echo "なし";
                            }
                            ?>
                        </td>
                        <td class="int1"><?php echo D($company['1_interview']); ?></td>
                        <td class="int1">
                            <?php
                            if($company['1_check'] == 1){
                                echo "選考中";
                            }elseif($company['1_check'] == 2){
                                echo "通過";
                            }elseif($company['1_check'] == 3){
                                echo "お祈り";
                            }elseif($company['1_check'] == 4){
                                echo "辞退";
                            }else{
                                echo "";
                            }
                            ?>
                        </td>
                        <td class="int2"><?php echo D($company['2_interview']); ?></td>
                        <td class="int2">
                            <?php
                            if($company['2_check'] == 1){
                                echo "選考中";
                            }elseif($company['2_check'] == 2){
                                echo "通過";
                            }elseif($company['2_check'] == 3){
                                echo "お祈り";
                            }elseif($company['2_check'] == 4){
                                echo "辞退";
                            }else{
                                echo "";
                            }
                            ?>
                        </td>
                        <td class="int3"><?php echo D($company['3_interview']); ?></td>
                        <td class="int3">
                            <?php
                            if($company['3_check'] == 1){
                                echo "選考中";
                            }elseif($company['3_check'] == 2){
                                echo "通過";
                            }elseif($company['3_check'] == 3){
                                echo "お祈り";
                            }elseif($company['3_check'] == 4){
                                echo "辞退";
                            }else{
                                echo "";
                            }
                            ?>
                        </td>
                        <td>
                            <?php
                            if($company['result'] == 1){
                                echo "内定";
                            }elseif($company['result'] == 2){
                                echo "お祈り";
                            }elseif($company['result'] == 3){
                                echo "辞退";
                            }else{
                                echo "選考中";
                            }
                            ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </div>
        </table>
    </div>

</body>
</html>