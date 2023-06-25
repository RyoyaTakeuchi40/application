<?php
require("common/db.php");
require("common/cntcolumn.php");



if (isset($_SESSION['id']) && isset($_SESSION['name'])){
}else{
	header('Location: login.php');
	exit();
}

//display変更中でもカラムの減少alertを出すため
$foralert = $db->query("SELECT * FROM `$user_name` ORDER BY `es` ASC");
if ($foralert){
    $forchecks = array();
    while ($list = mysqli_fetch_assoc($foralert)) {
        $forchecks[] = $list;
    }
}
foreach ($forchecks as $forcheck):
?>
    <script>
        var containInterview = false;
        if (<?php echo $forcheck['interview_'.($num)]; ?>){
            var containInterview = true;
        }
    </script>
<?php 
endforeach;

//お気に入りの動作の後
$display = '';
if (!$display = filter_input(INPUT_GET, 'display', FILTER_SANITIZE_STRING)){
    $display = filter_input(INPUT_POST, 'display', FILTER_SANITIZE_STRING);
}
//ボタンから表示内容を選択してデータを取得
if ($display == 'favorite'){
    $result = $db->query("SELECT * FROM `$user_name` WHERE favorite=1 ORDER BY `es` ASC");
}elseif ($display == 'mid'){
    $result = $db->query("SELECT * FROM `$user_name` WHERE result=0 ORDER BY `es` ASC");
}elseif ($display == 'offered'){
    $result = $db->query("SELECT * FROM `$user_name` WHERE result=1 ORDER BY `es` ASC");
}else{
    $result = $db->query("SELECT * FROM `$user_name` ORDER BY `es` ASC");
}

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
<?php foreach ($companies as $company): ?>
    <script>
        var containInterview = false;
        if (<?php echo $company['interview_'.($num)]; ?>){
            var containInterview = true;
        }
    </script>
<?php endforeach; ?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>一覧画面</title>
    <link rel="stylesheet" href="css/style.css">
    <script>
        //DBの面接の回数が1回だった場合にカラムの減少を実行しない
        function prevent(){
            if (<?php echo $num ?>== 1){
                alert('これ以上は欄を減らせません')
                //戻る
                return false;
            }else if (containInterview){
        //入力されている項目がある場合に確認する
                var comfirm = window.confirm(<?php echo $num; ?> + '次面接に入力されている事項がありますが\n本当に削除しますか？');
                if (comfirm){
                    //dropcolumn.phpに遷移
                    alert('削除されました。')
                }else{
                    //戻る
                    return false;
                } 
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <p>ようこそ、<?php echo $user_name;?>さん<span style="text-align: right;"><a href="logout.php">ログアウト</a></span></p>
        <div class="buttons">
            <div class="addbutton">
                <form action="add.php" method="post">
                    <button type="submit" name="add">追加する</button>
                </form>
            </div>
            <div class="display_buttons">
                <form action="index.php" method="post">
                    <button type="submit" name="display" value="all">すべてを表示</button>
                </form>      
                <form action="index.php" method="post">
                    <button type="submit" name="display" value="favorite">気になるだけを表示</button>
                </form>
                <form action="index.php" method="post">
                    <button type="submit" name="display" value="mid">選考中だけを表示</button>
                </form>
                <form action="index.php" method="post">
                    <button type="submit" name="display" value="offered">内定を表示</button>
                </form>
            </div>
        </div>
        <table width="100%">
            <thead>
                <tr>
                    <th>会社名</th>
                    <th>☆</th>
                    <th colspan="2">ES</th>
                    <th colspan="3">テスト</th>
                    <?php for($i=1; $i<$num; $i++): ?>
                        <th colspan="2"><?php echo $i; ?>次面接</th>
                    <?php endfor; ?>
                    <th colspan="2" class="last">
                        <form action="dropcolumn.php" method="post" onsubmit="return prevent();">
                            <button type="submit" name="dropcolumn" class="columnbuttons dropcolumn">削<br>除</button>
                        </form>
                        <?php echo $num; ?>次面接
                        <form action="addcolumn.php" method="post">
                            <button type="submit" name="addcolumn" class="columnbuttons addcolumn">追<br>加</button>
                        </form>
                    </th>
                    <th>結果</th>
                </tr> 
            </thead>
            <tbody>
                <div class="company">
                    <?php if ($result):
                        foreach ($companies as $company): ?>
                            <tr class="company_<?php echo H($company['result']); ?>">
                                <td>
                                    <form action="detail.php" method="post">
                                        <button class="company_name" type="submit" name="id" value="<?php echo H($company['id']); ?>"><?php echo H($company['name']); ?></button>
                                    </form>
                                </td>
                                <td>
                                    <form action="favorite.php" method="post">
                                        <input type="hidden" name="id" value="<?php echo H($company['id']); ?>">
                                        <input type="hidden" name="display" value="<?php echo $display; ?>"><!-- お気に入り動作後も表示を変えないため -->
                                        <input type="hidden" name="favorite" value="0"><!-- チェックが外されたときにお気に入りを外すSQLを実行する -->
                                        <input type="checkbox" name="favorite" value="1" onchange="this.form.submit();" <?php if($company['favorite'] == 1){ echo "checked";} ?>>
                                    </form>
                                </td>
                                <td class="company_<?php echo H($company['result']); ?> stage_<?php echo H($company['check_es']); ?>"><?php echo D($company['es']); ?></td>
                                <td class="company_<?php echo H($company['result']); ?> stage_<?php echo H($company['check_es']); ?>">
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
                                <td class="company_<?php echo H($company['result']); ?> stage_<?php echo H($company['check_test']); ?>"><?php echo D($company['test']); ?></td>
                                <td class="company_<?php echo H($company['result']); ?> stage_<?php echo H($company['check_test']); ?>">
                                    <?php
                                    if($company['test_type'] == 1){
                                        echo "SPI3";
                                    }elseif($company['test_type'] == 2){
                                        echo "CAB";
                                    }elseif($company['test_type'] == 3){
                                        echo "GAB";
                                    }elseif($company['test_type'] == 4){
                                        echo "技術テスト";
                                    }elseif($company['test_type'] == 5){
                                        echo "適性検査";
                                    }elseif($company['test_type'] == 6){
                                        echo "その他";
                                    }else{
                                        echo "";
                                    }
                                    ?>
                                </td>
                                <td class="company_<?php echo H($company['result']); ?> stage_<?php echo H($company['check_test']); ?>">
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
                                <?php for($i=1; $i<=$num; $i++): ?>
                                    <td class="company_<?php echo H($company['result']); ?> stage_<?php echo H($company['check_'.$i]); ?>"><?php echo D($company['interview_'.($i)]); ?></td>
                                    <td class="company_<?php echo H($company['result']); ?> stage_<?php echo H($company['check_'.$i]); ?>">
                                        <?php
                                        if($company['check_'.($i)] == 1){
                                            echo "選考中";
                                        }elseif($company['check_'.($i)] == 2){
                                            echo "通過";
                                        }elseif($company['check_'.($i)] == 3){
                                            echo "お祈り";
                                        }elseif($company['check_'.($i)] == 4){
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
                            <tr class="company_<?php echo H($company['result']); ?>"  style="font-size:70%">
                                <td>マイページURL</th>
                                <td colspan="6">
                                    <a href="<?php echo H($company['url']); ?>"><?php echo H($company['url']); ?></a>
                                </td>
                                <td colspan="2">ログインID</th>
                                <td colspan="2"><?php echo H($company['login']); ?></td>
                            </tr>
                    <?php endforeach;
                    endif; ?>
                </div>
            </tbody>

        </table>
    </div>

</body>
</html>