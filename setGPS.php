<?php
    header("Content-Type: application/json");
    include 'common.php';
    $userId = $_GET['userId'];
    if($userId == ''){
        error('Need Parameter: userId', 'setGPS');
    }

    $type = $_GET['type'];
    if($type == ''){
        error('Need Parameter: type', 'setGPS');
    }

    $latitude = $_GET['latitude'];
    if($latitude == ''){
        error('Need Parameter: latitude', 'setGPS');
    }

    $longitude = $_GET['longitude'];
    if($longitude == ''){
        error('Need Parameter: longitude', 'setGPS');
    }

    $who = 'n';
    if($type == 'p' || $type == 'parents'){
        $who = 'p';
    }
    else if($type == 'c' || $type == 'child'){
        $who = 'c';
    }
    else{
        error('Wrong Type: '.$type, 'setGPS');
    }

    $noneGPS = json_encode(array(
        "latitude" => $latitude,
        "longitude" => $longitude
    ));
    $sql = "UPDATE gps SET ".$who."GPS='".$noneGPS."' WHERE userId=".$userId;
    $DB = DB_res($sql);
    if($DB){
        success($userId, 'setGPS');
    }
    else{
        error("DB Insert Error", 'setGPS');
    }
?>