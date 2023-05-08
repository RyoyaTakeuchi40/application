<?php
function H($value){
    return htmlspecialchars($value, ENT_QUOTES);
}
    $db = new mysqli('localhost:8889', 'root', 'root', 'job_application');
?>