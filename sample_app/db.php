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
?>
