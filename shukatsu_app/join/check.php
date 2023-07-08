<?php
require("../common/db.php");

session_start();

if (isset($_SESSION['form'])){
	$form = $_SESSION['form'];
}else{
	header('Location: index.php');
	exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $stmt = $db -> prepare("INSERT INTO `users` (`name`,`email`,`password`) VALUES (?, ?, ?)");
    if (!$stmt) {
		echo $db->error;  // エラーメッセージを表示
	}
	$name = $form['name'];
	$email = $form['email'];
	$password = password_hash($form['password'], PASSWORD_DEFAULT);
	$stmt -> bind_param('sss', $name,  $email,  $password);
	if ($stmt->execute()) {
		//tableの作成
		$result = $db->query("CREATE TABLE `take40_shukatsu`.`$name` (
			`id` INT(11) NOT NULL AUTO_INCREMENT , 
			`name` TEXT NOT NULL , 
			`favorite` INT(11) NOT NULL DEFAULT '0' , 
			`es` DATE NULL DEFAULT NULL , 
			`check_es` INT(11) NOT NULL DEFAULT '0' , 
			`memo_es` TEXT NULL DEFAULT NULL , 
			`test` DATE NULL DEFAULT NULL , 
			`test_type` INT(11) NOT NULL DEFAULT '0' , 
			`check_test` INT(11) NULL DEFAULT '0' , 
			`interview_1` DATE NULL DEFAULT NULL , 
			`check_1` INT(11) NOT NULL DEFAULT '0' , 
			`memo_1` TEXT NULL DEFAULT NULL , 
			`interview_2` DATE NULL DEFAULT NULL , 
			`check_2` INT(11) NOT NULL DEFAULT '0' , 
			`memo_2` TEXT NULL DEFAULT NULL , 
			`interview_3` DATE NULL DEFAULT NULL , 
			`check_3` INT(11) NOT NULL DEFAULT '0' , 
			`memo_3` TEXT NULL DEFAULT NULL , 
			`result` INT NOT NULL DEFAULT '0' , 
			`url` TEXT NULL DEFAULT NULL , 
			`login` TEXT NULL DEFAULT NULL , 
			PRIMARY KEY (`id`)) ENGINE = InnoDB
			");
		unset($_SESSION['form']);
        header('Location: thanks.php');
        exit();
    } else {
        echo $stmt->error;  // エラーメッセージを表示
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
			<p>記入した内容を確認して、「登録する」ボタンをクリックしてください</p>
			<form action="" method="post">
				<dl>
					<dt>ニックネーム</dt>
					<dd><?php echo H($form['name']); ?></dd>
					<dt>メールアドレス</dt>
					<dd><?php echo H($form['email']); ?></dd>
					<dt>パスワード</dt>
					<dd>
						【表示されません】
					</dd>
				</dl>
				<div><a href="index.php?action=rewrite">&laquo;&nbsp;書き直す</a> | <input type="submit" value="登録する" /></div>
			</form>
		</div>

	</div>
</body>

</html>