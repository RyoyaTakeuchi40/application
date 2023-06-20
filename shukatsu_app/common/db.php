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

//エラー表示のためのfunction
function console_log($data){
    echo '<script>';
    echo 'console.log('.json_encode($data).')';
    echo '</script>';
}

//データベース接続
$db = new mysqli('localhost:8889', 'root', 'root', 'job_application');

?>