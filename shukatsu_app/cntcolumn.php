<?php

session_start();

if (isset($_SESSION['id']) && isset($_SESSION['name'])){
    $user_name = $_SESSION['name'];
}


$forcnt = $db->query("SELECT * FROM `$user_name`");
//columnの数を数える
$cnt =  $forcnt->field_count;
//現在の面接の回数
$num = ($cnt -12)/3;
//足される面接は何回目か
$newnum = $num +1;

echo "use_name: " . $user_name . "<br>";
echo "num: " . $num . "<br>";
?>