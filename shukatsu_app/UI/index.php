<?php
require("../common/db.php");
require("../common/cntcolumn.php");



if (isset($_SESSION['id']) && isset($_SESSION['name'])){
}else{
	header('Location: login.php');
	exit();
}
$result = $db->query("SELECT * FROM `$user_name` ORDER BY `es` ASC");

if (!$result) {
    echo "表示する内容がありません";
    echo $db->error;
}else{
    //取得したデータを会社ごとの配列に格納
    $companies = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $companies[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>一覧画面</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.7.14"></script>

    <div id="app">
        <table>
            <tr>
                <th>会社名</th>
                <th>☆</th>
                <th colspan="2">ES</th>
                <th colspan="3">テスト</th>
                <template v-for="i in num">
                        <th colspan="2">{{ i }}次面接</th>
                </template>
                <th>結果</th>
            </tr> 
            <tr v-for="(company, index) in companies" key="company['id']">
                <td>{{ company['name'] }}</td>
                <td><input type="checkbox"></td>
                <td>{{ DF(company['es']) }}</td>
                <td>{{ RS(company['check_es']) }}</td>
                <td>{{ DF(company['test']) }}</td>
                <td>{{ TT(company['test_type']) }}</td>
                <td>{{ RS(company['check_test']) }}</td>
                <template v-for="i in num">
                    <td>{{ DF(company['interview_' + i]) }}</td>
                    <td>{{ RS(company['check_' + i]) }}</td>
                </template>
                <td>{{ company['result'] }}</td>
            </tr>
        </table>
    </div>

    <script>
        const app = new Vue({
            data: {
                // PHP変数 $companies をJSON形式に変換
                companies: <?php echo json_encode($companies); ?>,
                num: <?php echo $num; ?>,
                newNum: <?php echo $newnum; ?>,
            },
            methods: {
                // DateFormat
                DF(date) {
                    // dateがnullまたはundefinedの場合の処理
                    if (!date) return '';
                    // 日付をフォーマットする処理を実装
                    const d = new Date(date);
                    const month = d.getMonth() + 1;
                    const day = d.getDate();
                    const formattedDate = `${month}月${day}日`;
                    return formattedDate;
                },
                // 結果の表示
                RS(result) {
                    if (result == 1) return '選考中';
                    else if (result == 2) return '通過';
                    else if (result == 3) return 'お祈り';
                    else if (result == 4) return '辞退';
                    else return '';
                },
                // TestType
                TT(type) {
                    if (type == 1) return 'SPI3';
                    else if (type == 2) return 'CAB';
                    else if (type == 3) return 'GAB';
                    else if (type == 4) return '技術テスト';
                    else if (type == 5) return '適性検査';
                    else if (type == 6) return 'その他';
                    else return '';
                }
            }
        }).$mount('#app');
    </script>
</body>



</html>