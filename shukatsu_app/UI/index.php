<?php
require("../common/db.php");
require("../common/cntcolumn.php");


// SESSIONがない場合にログインページに遷移する
if (isset($_SESSION['id']) && isset($_SESSION['name'])){
}else{
	header('Location: login.php');
	exit();
}

// お気に入りの変更
if(isset($_POST['favorite'])) {
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    $favorite = filter_input(INPUT_POST, 'favorite', FILTER_SANITIZE_NUMBER_INT);

    $stmt = $db -> prepare("UPDATE `$user_name` SET `favorite`=? WHERE id=?");
    $stmt -> bind_param('ii', $favorite, $id);
    if ($stmt->execute()) {
    } else {
        error_log($stmt->error);
    }
}

$result = $db->query("SELECT * FROM `$user_name` ORDER BY `es` ASC");

if (!$result) {
    echo "表示する内容がありません";
    echo $db->error;
}else{
    // 取得したデータを会社ごとの配列に格納
    $companies = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $companies[] = $row;
    }
}

// ページ遷移後にdisplayを保つ
if(isset($_POST['display'])) {
    $display = filter_input(INPUT_POST, 'display', FILTER_SANITIZE_STRING);
}else{
    $display = 'ongoing';
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
        <select name="display" v-model="display">
            <option value="ongoing">選考中のみ表示</option>
            <option value="favorite">気になる表示</option>
            <option value="all">すべてを表示</option>
            <option value="get">内定のみ表示</option>
        </select>
        <table>
            <tr>
                <th>会社名</th>
                <th>☆</th>
                <th colspan="2">ES</th>
                <th colspan="3">テスト</th>
                <template v-for="i in num-1">
                    <th colspan="2">{{ i }}次面接</th>
                </template>
                <th colspan="2" class="last">
                        <form action="k" method="post" v-on:submit="handleSubmit">
                            <button type="submit" name="dropcolumn" class="columnbuttons dropcolumn">削<br>除</button>
                        </form>
                        {{ num }}次面接
                        <form action="" method="post">
                            <button type="submit" name="addcolumn" class="columnbuttons addcolumn">追<br>加</button>
                        </form>
                    </th>
                <th>結果</th>
            </tr> 
            <template v-for="company in companies" :key="company['id']">
                <template v-if=" 
                display == 'ongoing' && company['result'] == 0 || 
                display == 'favorite' && company['favorite'] == 1 || 
                display == 'all' || 
                display == 'get' && company['result'] == 1 "
                >
                    <tr>
                        <td>{{ company['name'] }}</td>
                        <td>
                            <form action="" method="post">
                                <input type="hidden" name="id" :value="company['id']">
                                <input type="hidden" name="display" :value="display">
                                <input type="hidden" name="favorite" value="0"><!-- チェックが外されたときにお気に入りを外すSQLを実行する -->
                                <input type="checkbox" name="favorite" value="1" :checked="company['favorite'] == 1" onchange="this.form.submit()">
                            </form>
                        </td>
                        <td>{{ DF(company['es']) }}</td>
                        <td>{{ CH(company['check_es']) }}</td>
                        <td>{{ DF(company['test']) }}</td>
                        <td>{{ TT(company['test_type']) }}</td>
                        <td>{{ CH(company['check_test']) }}</td>
                        <template v-for="i in num">
                            <td>{{ DF(company['interview_' + i]) }}</td>
                            <td>{{ CH(company['check_' + i]) }}</td>
                        </template>
                        <td>{{ company['result'] }}</td>
                    </tr>
                    <tr>
                        <td>マイページURL</td>
                        <td colspan="6">
                            <a :href="company['url']">{{ company['url'] }}</a>
                        </td>
                        <td colspan="2">ログインID</td>
                        <td colspan="2">{{ company['login'] }}</td>
                    </tr>
                </template>
            </template>
        </table>
    </div>

    <script>
        const app = new Vue({
            el: '#app',
            data: {
                // PHP変数 $companies をJSON形式に変換
                companies: <?php echo json_encode($companies); ?>,
                num: <?php echo $num; ?>,
                newNum: <?php echo $newnum; ?>,
                // selectタグの初期値を設定
                display: <?php echo json_encode($display); ?>,
                // num次面接に値が入力されているか
                containInterview: false,
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
                // Check
                CH(check) {
                    if (check == 1) return '選考中';
                    else if (check == 2) return '通過';
                    else if (check == 3) return 'お祈り';
                    else if (check == 4) return '辞退';
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
                },
                // カラム削除ボタンが押されたときに本当に削除してよいか確認
                handleSubmit(event) {
                    if (this.num == 1){
                        alert('これ以上は欄を減らせません')
                        // フォームの送信をキャンセル
                        event.preventDefault();
                    }else if (this.containInterview){
                        // 入力されている項目がある場合に確認する
                        if (!window.confirm(this.num + '次面接に入力されている事項がありますが\n本当に削除しますか？')){
                            // フォームの送信をキャンセル
                            event.preventDefault();
                        }     
                    }
                },
            },
            mounted() {
                // 画面読み込み時にnum次面接に入力事項がある場合containInterviewをtrueにする
                window.onload = () => {
                    Object.values(this.companies).forEach((company) => {
                        if (company['interview_' + this.num]){
                            this.containInterview = true
                        }
                    })
                }
            },
            
        });
    </script>
</body>



</html>