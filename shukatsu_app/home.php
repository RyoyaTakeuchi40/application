<?php
function H($value){
    return htmlspecialchars($value, ENT_QUOTES);
}

require("db.php");

//applicationsテーブルからデータを取得
$result = $db->query("SELECT * FROM `shukatsu_app`");
if (!$result) {
    echo "表示する内容がありません";
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
    </style>
</head>
<body>
    <div class="comtainer">
        <table>
            <tr>
                <th>会社名</th>
                <th>ES</th>
                <th>結果</th>
                <th>テスト</th>
                <th>1次面接</th>
                <th>結果</th>
                <th>2次面接</th>
                <th>結果</th>
                <th>3次面接</th>
                <th>結果</th>
                <th>内定</th>
            </tr> 
            <div class="content">
                <?php foreach ($companies as $company) : ?>
                    <tr>
                        <td><?php echo H($company['name']); ?></td>
                        <td><?php echo H($company['es']); ?></td>
                        <td><?php echo H($company['es_check']); ?></td>
                        <td><?php echo H($company['test_type']); ?></td>
                        <td><?php echo H($company['1_interview']); ?></td>
                        <td><?php echo H($company['1_check']); ?></td>
                        <td><?php echo H($company['2_interview']); ?></td>
                        <td><?php echo H($company['2_check']); ?></td>
                        <td><?php echo H($company['3_interview']); ?></td>
                        <td><?php echo H($company['3_check']); ?></td>
                        <td><?php echo H($company['job_offer']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </div>
        </table>
    </div>
</body>
</html>