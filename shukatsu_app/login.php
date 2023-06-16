<?php
require('db.php');

session_start();

$error = [];
$email = '';
$password = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $email =  filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password =  filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
    if ($email === '' || $password === ''){
        $error['login'] = 'blank';
    }else{
        //ログインチェク
        $stmt = $db -> prepare('SELECT id, name, password FROM `users` WHERE email = ? LIMIT 1');
        if (!$stmt) {
            echo $db->error;  // エラーメッセージを表示
        }
        $stmt -> bind_param('s', $email);
        $stmt -> execute();

        $stmt -> bind_result($id, $name, $hash);
        $stmt -> fetch();

        if (password_verify($password, $hash)){
            //ログイン成功
            session_regenerate_id();
            $_SESSION['id'] = $id;
            $_SESSION['name'] = $name;
            header('Location: index.php');
            exit();
        }else{
            $error['login'] = 'failed';
        }
    }
    
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>ログイン</title>
</head>

<body>
<div id="wrap">
    <div id="head">
        <h1>ログインする</h1>
    </div>
    <div id="content">
        <div id="lead">
            <p>メールアドレスとパスワードを記入してログインしてください。</p>
            <p>会員登録がまだの方は<a href="join/">こちら</a>からどうぞ。</p>
        </div>
        <form action="" method="post">
            <dl>
                <dt>メールアドレス</dt>
                <dd>
                    <input type="text" name="email" size="35" maxlength="255" value="<?php echo H($email); ?>"/>
                    <?php if (isset($error['login']) && $error['login'] === 'blank'): ?>
                        <p class="error">* メールアドレスとパスワードをご記入ください</p>
                    <?php endif; ?>
                    <?php if (isset($error['login']) && $error['login'] === 'failed'): ?>
                        <p class="error">* ログインに失敗しました。正しくご記入ください。</p>
                    <?php endif; ?>
                </dd>
                <dt>パスワード</dt>
                <dd>
                    <input type="password" name="password" size="35" maxlength="255" value="<?php echo H($password); ?>"/>
                </dd>
            </dl>
            <div>
                <input type="submit" value="ログインする"/>
            </div>
        </form>
    </div>
</div>
</body>
</html>
