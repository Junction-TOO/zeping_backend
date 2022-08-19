<?php
    header("Content-Type: application/json");
    include 'common.php';
    $userId = $_GET['userId'];
    if($userId == ''){
        error('Need Parameter: userId', 'getGPS');
    }
    success($userId, 'getGPS');
?>