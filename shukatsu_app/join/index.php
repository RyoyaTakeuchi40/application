<?php
require("../db.php");

session_start();

if (isset($_GET['action']) && $_GET['action'] === 'rewrite' && isset($_SESSION['form'])){
    $form = $_SESSION['form'];
}else{
    $form = [
        'name' => '',
        'email' => '',
        'password' => '',
        'confirm' => ''
    ];
}
$error = [];

//フォームの内容をチェック
if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $form['name'] = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    if ($form['name'] === ''){
        $error['name'] = 'blank';
    }else{
        $stmt = $db -> prepare("SELECT COUNT(*) FROM `users` WHERE name=?");
        if (!$stmt) {
            echo $db->error;  // エラーメッセージを表示
        }
        $stmt -> bind_param('s', $form['name']);
        $stmt -> execute();
        $stmt -> bind_result($cnt_name);
        $stmt -> fetch();
        $stmt -> close();
        
        if ($cnt_name > 0){
            $error['name'] = 'duplicate';
        }

    }

    $form['email'] = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    if ($form['email'] === ''){
        $error['email'] = 'blank';
    }else{
        $stmt = $db -> prepare("SELECT COUNT(*) FROM `users` WHERE email=?");
        if (!$stmt) {
            echo $db->error;  // エラーメッセージを表示
        }
        $stmt -> bind_param('s', $form['email']);
        $stmt -> execute();
        $stmt -> bind_result($cnt_email);
        $stmt -> fetch();
        $stmt -> close();
        
        if ($cnt_email > 0){
            $error['email'] = 'duplicate';
        }

    }

    $form['password'] = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
    if ($form['password'] === ''){
        $error['password'] = 'blank';
    }elseif (strlen($form['password']) < 8){
        $error['password'] = 'length';
    }

    $form['confirm'] = filter_input(INPUT_POST, 'confirm', FILTER_SANITIZE_STRING);
    if ($form['confirm'] !== $form['password']){
        $error['confirm'] = 'match';
    }
    if (empty($error)){
        $_SESSION['form'] = $form;
        header('Location: check.php');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>会員登録</title>
</head>

<body>
<div id="wrap">
    <div id="head">
        <h1>会員登録</h1>
    </div>

    <div id="content">
        <p>次のフォームに必要事項をご記入ください。</p>
        <form action="" method="post" enctype="multipart/form-data">
            <dl>
                <dt>ニックネーム<span class="required">必須</span></dt>
                <dd>
                    <input type="text" name="name" size="35" maxlength="255" value="<?php echo H($form['name']); ?>"/>
                    <?php if (isset($error['name']) && $error['name'] === 'blank'): ?>
                        <p class="error">* ニックネームを入力してください</p>
                    <?php endif; ?>
                    <?php if (isset($error['name']) && $error['name'] === 'duplicate'): ?>
                        <p class="error">* 指定されたニックネームはすでに登録されています</p>
                    <?php endif; ?>
                </dd>
                <dt>メールアドレス<span class="required">必須</span></dt>
                <dd>
                    <input type="text" name="email" size="35" maxlength="255" value="<?php echo H($form['email']); ?>"/>
                    <?php if (isset($error['email']) && $error['email'] === 'blank'): ?>
                        <p class="error">* メールアドレスを入力してください</p>
                    <?php endif; ?>
                    <?php if (isset($error['email']) && $error['email'] === 'duplicate'): ?>
                        <p class="error">* 指定されたメールアドレスはすでに登録されています</p>
                    <?php endif; ?>
                <dt>パスワード（8文字以上）<span class="required">必須</span></dt>
                <dd>
                    <input type="password" name="password" size="10" maxlength="20" value="<?php echo H($form['password']); ?>"/>
                    <?php if (isset($error['password']) && $error['password'] === 'blank'): ?>
                        <p class="error">* パスワードを入力してください</p>
                    <?php endif; ?>
                    <?php if (isset($error['password']) && $error['password'] === 'length'): ?>
                        <p class="error">* パスワードは8文字以上で入力してください</p>
                    <?php endif; ?>
                <dt>パスワード（確認用）<span class="required">必須</span></dt>
                <dd>
                    <input type="password" name="confirm" size="10" maxlength="20" value=""/>
                    <?php if (isset($error['confirm']) && $error['confirm'] === 'match'): ?>
                        <p class="error">* パスワードが一致しません</p>
                    <?php endif; ?>
                </dd>
            </dl>
            <div><input type="submit" value="入力内容を確認する"/></div>
        </form>
    </div>
</body>

</html>