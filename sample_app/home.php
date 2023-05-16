<?php
require("db.php");
$result = $db->query("SELECT * FROM `sample_app`");
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
    <title>sample.home</title>
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
    <table>
        <tr>
            <th>id</th>
            <th>int_1</th>
            <th>check_1</th>
            <th>memo_1</th>
        </tr>
        <?php foreach ($companies as $company) : ?>
            <tr>
                <td><?php echo H($company['id']); ?></td>
                <td><?php echo H($company['int_1']); ?></td>
                <td><?php echo H($company['check_1']); ?></td>
                <td><?php echo H($company['memo_1']); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
    <form action="form.php" method="post">
        <button type="submit" name="ran">欄を追加</button>
    </form>
</body>
</html>