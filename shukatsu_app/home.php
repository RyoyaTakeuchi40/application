<?php
require("db.php");

$display = ['display' => ''];
//お気に入りの動作の後のため
if (!$display['display'] = filter_input(INPUT_GET, 'display', FILTER_SANITIZE_STRING)){
    $display['display'] = filter_input(INPUT_POST, 'display', FILTER_SANITIZE_STRING);
}

//ボタンから表示内容を選択してデータを取得
if ($display['display'] == 'favorite'){
    $result = $db->query("SELECT * FROM `shukatsu_app` WHERE `favorite`=1");
    if (!$result) {
        echo "表示する内容がありません";
    }
}elseif ($display['display'] == 'mid'){
    $result = $db->query("SELECT * FROM `shukatsu_app` WHERE `result`=0");
    if (!$result) {
        echo "表示する内容がありません";
    }
}elseif ($display['display'] == 'offered'){
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
        <div class="addcolumn">
            <form action="column.php" method="post">
                <button type="submit" name="column">欄を追加</button>
            </form>
        </div>
        <div class="displaybuttons">
            <form action="home.php" method="post">
                <button type="submit" name="display" value="all">すべてを表示</button>
            </form>      
            <form action="home.php" method="post">
                <button type="submit" name="display" value="favorite">気になるだけを表示</button>
            </form>
            <form action="home.php" method="post">
                <button type="submit" name="display" value="mid">選考中だけを表示</button>
            </form>
            <form action="home.php" method="post">
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
                <th>種類</th>
                <th>結果</th>
                <?php for($i=0; $i<$num; $i++): ?>
                    <th><?php echo $i+1; ?>次面接</th>
                    <th>結果</th>
                <?php endfor; ?>
                <th>最終結果</th>
            </tr> 
            <div class="content">
                <?php foreach ($companies as $company) : ?>
                    <tr class="company_<?php echo H($company['result']); ?>">
                        <!-- tableの1つの箱がまるごとリンクになるようにするにはどうしたらいいですか -->
                        <!-- JSのonclickだとphpがうまく動作しないので嫌です -->
                        <td><a href="detail.php?id=<?php echo H($company['id']); ?>"><?php echo H($company['name']); ?></td></a>
                        <td>
                            <form action="favorite.php" method="post">
                                <input type="hidden" name="id" value="<?php echo H($company['id']); ?>">
                                <input type="hidden" name="display" value="<?php echo $display['display']; ?>"><!-- お気に入り動作後も表示を変えないため -->
                                <input type="hidden" name="favorite" value="0"><!-- チェックが外されたときにお気に入りを外すSQLを実行する -->
                                <input type="checkbox" name="favorite" value="1" onchange="this.form.submit();" <?php if($company['favorite'] == 1){ echo "checked";} ?>>
                            </form>
                        </td>
                        <td class="es_<?php echo H($company['check_es']); ?>"><?php echo D($company['es']); ?></td>
                        <td class="es_<?php echo H($company['check_es']); ?>">
                            <?php
                            if($company['check_es'] == 1){
                                echo "選考中";
                            }elseif($company['check_es'] == 2){
                                echo "通過";
                            }elseif($company['check_es'] == 3){
                                echo "お祈り";
                            }elseif($company['check_es'] == 4){
                                echo "辞退";
                            }else{
                                echo "";
                            }
                            ?>
                        </td>
                        <td class="test_<?php echo H($company['check_test']); ?>"><?php echo D($company['test']); ?></td>
                        <td class="test_<?php echo H($company['check_test']); ?>">
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
                                echo "";
                            }
                            ?>
                        </td>
                        <td class="test_<?php echo H($company['check_test']); ?>">
                            <?php
                            if($company['check_test'] == 1){
                                echo "選考中";
                            }elseif($company['check_test'] == 2){
                                echo "通過";
                            }elseif($company['check_test'] == 3){
                                echo "お祈り";
                            }elseif($company['check_test'] == 4){
                                echo "辞退";
                            }else{
                                echo "";
                            }
                            ?>
                        </td>
                        <?php for($i=0; $i<$num; $i++): ?>
                            <td class="int<?php echo ($i+1); ?>_<?php echo H($company['check_'.($i+1)]); ?>"><?php echo D($company['interview_'.($i+1)]); ?></td>
                            <td class="int<?php echo ($i+1); ?>_<?php echo H($company['check_'.($i+1)]); ?>">
                                <?php
                                if($company['check_'.($i+1)] == 1){
                                    echo "選考中";
                                }elseif($company['check_'.($i+1)] == 2){
                                    echo "通過";
                                }elseif($company['check_'.($i+1)] == 3){
                                    echo "お祈り";
                                }elseif($company['check_'.($i+1)] == 4){
                                    echo "辞退";
                                }else{
                                    echo "";
                                }
                                ?>
                            </td>
                        <?php endfor; ?>
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