<?php
require("dbconnect.php");

function H($value){
    return htmlspecialchars($value, ENT_QUOTES);
}

//applicationsテーブルからデータを取得
$result = $db->query("SELECT * FROM `applications` WHERE `completed`=0 ORDER BY `deadline`");
if (!$result) {
    echo "表示する内容がありません";
}

//取得したデータを配列に格納
$tasks = array();
while ($row = mysqli_fetch_assoc($result)) {
    $tasks[] = $row;
}

//完了済みの場合
$submitted = $db->query("SELECT * FROM `applications` WHERE `completed`=1 ORDER BY `deadline`");
if (!$submitted) {
    echo "表示する内容がありません";
}
$completions = array();
while ($did = mysqli_fetch_assoc($submitted)) {
    $completions[] = $did;
}

//新しい項目の追加
$check = ['button' => ''];
$check['button'] = filter_input(INPUT_POST, 'button', FILTER_SANITIZE_STRING);
mysqli_close($db);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>application</title>
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
    <h1>To Do List</h1>
    <?php if ($check['button'] == 'new'): ?>
        <form action="add.php" method="post">
            <dl>
                <dt>会社名</dt>
                <dd>
                    <input type="text" name="company_name" required>
                </dd>
                <dt>種類</dt>
                <dd>
                    <input type="text" name="type">
                </dd>
                <dt>期日</dt>
                <dd>
                    <input type="date" name="deadline">
                </dd>
                <dt>URL</dt>
                <dd>
                    <input type="text" name="url">
                </dd>
                <dt>メモ</dt>
                <dd>
                    <input type="text" name="memo">
                </dd>
            </dl>
            <button type="submit" name="add" value="add">追加する</button>
        </form>
        <form action="application.php" method="post">
            <button type="submit">戻る</button>
        </form>
    <?php else: ?>
        <form action="" method="post">
            <button type="submit" name="button" value="new">新しい項目</button>
        </form>
    <?php endif; ?>
    <div class="content">
        <table>
            <tr>
                <th>会社名</th>
                <th>種類</th>
                <th>期日</th>
                <th>URL</th>
                <th>メモ</th>
                <th>未提出</th>
            </tr>
            
            <?php foreach ($tasks as $task) : ?>
                <tr class="incompleted">
                    <td><?php echo H($task['company_name']); ?></td>
                    <td><?php echo H($task['type']); ?></td>
                    <td><?php echo H($task['deadline']); ?></td>
                    <td><a href="<?php echo H($task['url']); ?>"><?php echo H($task['url']); ?></a></td>
                    <td><?php echo H($task['memo']); ?></td>
                    <td>
                        <form action="complete.php" method="post">
                            <input type="checkbox" name="complete" value="<?php echo H($task['id']); ?>" onchange="this.form.submit();">
                        </form>
                    </td>
                    <td>
                        <form action="detail.php" method="post">
                            <button type="submit" name="detail" value="<?php echo H($task['id']); ?>">詳細</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <h2>提出済</h2>
    <div class="content">
        <table>
            <tr class="completed">
                <th>会社名</th>
                <th>種類</th>
                <th>期日</th>
                <th>URL</th>
                <th>メモ</th>
                <th>提出済</th>
            </tr>
            <?php foreach ($completions as $completion): ?>
                <tr class="incompleted">
                    <td><?php echo H($completion['company_name']); ?></td>
                    <td><?php echo H($completion['type']); ?></td>
                    <td><?php echo H($completion['deadline']); ?></td>
                    <td><a href="<?php echo H($completion['url']); ?>"><?php echo H($completion['url']); ?></a></td>
                    <td><?php echo H($completion['memo']); ?></td>
                    <td>
                        <form action="return.php" method="post">
                            <input type="checkbox" name="return" value="<?php echo H($completion['id']); ?>" onchange="this.form.submit();">
                        </form>
                    </td>
                    <td>
                        <form action="detail.php" method="post">
                            <button type="submit" name="detail" value="<?php echo H($completion['id']); ?>">詳細</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>