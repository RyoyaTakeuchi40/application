<?php
function H($value){
    return htmlspecialchars($value, ENT_QUOTES);
}

//日付の表示を整える
function D($value){
    if ($value){
        return date("n月j日", strtotime($value));
    }
}

//データベース接続
$db = new mysqli('localhost:8889', 'root', 'root', 'job_application');

$forcnt = $db->query("SELECT * FROM `shukatsu_app`");
//columnの数を数える
$cnt =  $forcnt->field_count;
//現在の面接の回数
$num = ($cnt -11)/3;
//足される面接は何回目か
$newnum = $num +1;

//エラー表示のためのfunction
function console_log($data){
    echo '<script>';
    echo 'console.log('.json_encode($data).')';
    echo '</script>';
}
?>