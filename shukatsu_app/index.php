<?php
require("common/db.php");
require("common/cntcolumn.php");


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

// queryの作成
// typeがdateの内容をすべて参照し、日付順で並べる
$query = "SELECT * FROM ( 
    SELECT *, es AS interview_dates FROM shukatsu_app
    UNION ALL SELECT *, test AS interview_dates FROM shukatsu_app ";
for ($i=1;$i<=$num;$i++){
    $query .= "UNION ALL SELECT *, interview_" . $i . " AS interview_dates FROM shukatsu_app ";
}
$query .= ") AS subquery ORDER BY interview_dates ASC";

$result = $db->query($query);

if (!$result) {
    echo "表示する内容がありません";
    echo $db->error;
}else{
    // 取得したデータを会社ごとの配列に格納
    // 重複の削除も同時に行う
    $companies = array();
    $uniqueCompanies = array(); // 一時的な配列
    while ($row = mysqli_fetch_assoc($result)) {
        $uniqueKey = $row['id']; // 重複チェックとしてidを指定する
        if (!isset($uniqueCompanies[$uniqueKey])) {
            $uniqueCompanies[$uniqueKey] = $row;
        }
    }
    // 一時的な配列の値を $companies にコピーする
    foreach ($uniqueCompanies as $company) {
        $companies[] = $company;
    }
}

// ページ遷移後にdisplayを保つ
if(isset($_POST['display'])) {
    $display = filter_input(INPUT_POST, 'display', FILTER_SANITIZE_STRING);
}else{
    // 選考中のみがデフォルト設定
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
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.7.14"></script>

    <div id="app">
        <p class="welcome">ようこそ、{{ userName }}さん</p>
        <div style="text-align: right"><a href="logout.php">ログアウト</a></div>
        <form action="add.php" method="post">
            <button type="submit" name="add">追加する</button>
        </form>
        <select name="display" v-model="display">
            <option value="ongoing">選考中のみ表示</option>
            <option value="favorite">気になる表示</option>
            <option value="all">すべてを表示</option>
            <option value="get">内定のみ表示</option>
        </select>
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th width="50">会社名</th>
                        <th width="10">☆</th>
                        <th width="10">ログインID</th>
                        <th class="es" colspan="2">ES</th>
                        <th class="test"colspan="3">テスト</th>
                        <template v-for="i in num-1">
                            <th class="interview" colspan="2">{{ i }}次面接</th>
                        </template>
                        <!-- 最後のカラムのみ追加と削除のボタンを表示する -->
                        <th colspan="2" class="interview last">
                            <form action="dropcolumn.php" method="post" v-on:submit="handleSubmit">
                                <button type="submit" name="dropcolumn" class="columnbuttons dropcolumn">削<br>除</button>
                            </form>
                            {{ num }}次面接
                            <form action="addcolumn.php" method="post">
                                <button type="submit" name="addcolumn" class="columnbuttons addcolumn">追<br>加</button>
                            </form>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <template v-for="company in companies" :key="company['id']">
                        <!-- displayの状態によって条件を変更 -->
                        <template v-if=" 
                        display == 'ongoing' && company['result'] == 0 || 
                        display == 'favorite' && company['favorite'] == 1 || 
                        display == 'all' || 
                        display == 'get' && company['result'] == 1 "
                        >
                            <tr class="company" :class="trClass(company['result'])">
                                <td><a :href="company['url']">{{ company['name'] }}</a></td>
                                <td>
                                    <form action="" method="post">
                                        <input type="hidden" name="id" :value="company['id']">
                                        <input type="hidden" name="display" :value="display">
                                        <input type="hidden" name="favorite" value="0"><!-- チェックが外されたときにお気に入りを外すSQLを実行する -->
                                        <input type="checkbox" name="favorite" value="1" :checked="company['favorite'] == 1" onchange="this.form.submit()">
                                    </form>
                                </td>
                                <td @click="goToDetail(company['id'])">{{ company['login'] }}</td>
                                <td :class="[tdClass(company['check_es']), trClass(company['result'])]" @click="goToDetail(company['id'])">{{ DF(company['es']) }}</td>
                                <td :class="[tdClass(company['check_es']), trClass(company['result'])]" @click="goToDetail(company['id'])">{{ CH(company['check_es']) }}</td>
                                <td :class="[tdClass(company['check_test']), trClass(company['result'])]" @click="goToDetail(company['id'])">{{ DF(company['test']) }}</td>
                                <td :class="[tdClass(company['check_test']), trClass(company['result'])]" @click="goToDetail(company['id'])">{{ TT(company['test_type']) }}</td>
                                <td :class="[tdClass(company['check_test']), trClass(company['result'])]" @click="goToDetail(company['id'])">{{ CH(company['check_test']) }}</td>
                                <template v-for="i in num">
                                    <td :class="[tdClass(company['check_' + i]), trClass(company['result'])]" @click="goToDetail(company['id'])">{{ DF(company['interview_' + i]) }}</td>
                                    <td :class="[tdClass(company['check_' + i]), trClass(company['result'])]" @click="goToDetail(company['id'])">{{ CH(company['check_' + i]) }}</td>
                                </template>
                            </tr>
                        </template>
                    </template>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        const app = new Vue({
            el: '#app',
            data: {
                // PHP変数をJSON形式に変換して出力
                userName: <?php echo json_encode($user_name); ?>,
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
                // trのクラスを判別する
                trClass(result) {
                    if (result == 1) {
                        return 'company_1';
                    }else if (result == 2) {
                        return 'company_2';
                    }
                },
                // tdのクラスを判別する
                tdClass(result) {
                    if (result == 1) {
                        return 'stage_1';
                    }else if (result == 2) {
                        return 'stage_2';
                    }else if (result == 3) {
                        return 'stage_3';
                    }else if (result == 4) {
                        return 'stage_4';
                    }
                },
                // clickイベントでdetail.phpへ画面遷移
                goToDetail(id) {
                    // フォームを生成
                    const form = document.createElement('form');
                    form.action = 'detail.php';
                    form.method = 'POST';
                    // idのhiddenフィールドを追加
                    const idInput = document.createElement('input');
                    idInput.type = 'hidden';
                    idInput.name = 'id';
                    idInput.value = id;
                    form.appendChild(idInput);
                    // フォームをbodyに追加して送信
                    document.body.appendChild(form);
                    form.submit();
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