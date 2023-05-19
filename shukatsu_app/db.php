<?php
function H($value){
    return htmlspecialchars($value, ENT_QUOTES);
}
function D($value){
    if ($value){
        return date("n月j日", strtotime($value));
    }
}
    $db = new mysqli('localhost:8889', 'root', 'root', 'job_application');

    $forcnt = $db->query("SELECT * FROM `shukatsu_app`");
    $cnt =  $forcnt->field_count;
    $num = ($cnt -11)/3;
    $newnum = $num +1;
?>