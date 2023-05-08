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
                        <td><?php echo H($company['favorite']); ?></td>
                        <td class="es"><?php echo H($company['es']); ?></td>
                        <td class="es"><?php echo H($company['es_check']); ?></td>
                        <td class="test"><?php echo H($company['test_type']); ?></td>
                        <td class="int1"><?php echo H($company['1_interview']); ?></td>
                        <td class="int1"><?php echo H($company['1_check']); ?></td>
                        <td class="int2"><?php echo H($company['2_interview']); ?></td>
                        <td class="int2"><?php echo H($company['2_check']); ?></td>
                        <td class="int3"><?php echo H($company['3_interview']); ?></td>
                        <td class="int3"><?php echo H($company['3_check']); ?></td>
                        <td><?php echo H($company['result']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </div>
        </table>
    </div>

</body>
</html>