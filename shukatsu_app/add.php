<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>追加</title>
    <style>
        .fromdb {
            margin: 0 12px;
        }
        textarea {
            resize: none;
            width: 100%;
            margin: auto;
        }
    </style>
</head>
<body>
    <form action="home.php" method="post">
        <button type="submit">戻る</button>
    </form>
    <form action="add_do.php" method="post">
        <h3>会社名</h3>
        <div class="fromdb">
            <textarea name="name" cols="30" rows="1" required></textarea>
        </div>
        <h3>URL</h3>
        <div class="fromdb">
            <textarea name="url" cols="30" rows="1"></textarea>
        </div>
        <h3>ログインID</h3>
        <div class="fromdb">
            <textarea name="login" cols="30" rows="1"></textarea>
        </div>
        <h3>ES</h3>
        <div class="fromdb">
            <input type="date" name="es" value="<?php echo $es; ?>">
            <textarea name="memo_es" cols="30" rows="5"></textarea>
        </div>
        <h3>テスト</h3>
        <div class="fromdb">
            <input type="date" name="test" value="<?php echo $test; ?>">
            <select name="test_type" id="test_type">
                <option value="0">なし</option>
                <option value="1">SPI3</option>
                <option value="2">CAB</option>
                <option value="3">GAB</option>
                <option value="4">技術テスト</option>
            </select>
        </div>
        <h3>1次面接</h3>
        <div class="fromdb">
            <input type="date" name="int_1">
            <textarea name="memo_1" cols="30" rows="5"></textarea>
        </div>
        <h3>2次面接</h3>
        <div class="fromdb">
            <input type="date" name="int_2">
            <textarea name="memo_2" cols="30" rows="5"></textarea>
        </div>
        <h3>3次面接</h3>
        <div class="fromdb">
            <input type="date" name="int_3">
            <textarea name="memo_3" cols="30" rows="5"></textarea>
        </div>
        <button typy="submit" name="button">追加する</button>
    </form>
</body>
</html>

