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

?>