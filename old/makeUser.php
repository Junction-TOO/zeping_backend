<?php
    header("Content-Type: application/json");
    include 'common.php';
    $userName = $_GET['userName'];
    if($userName == ''){
        error('Need Parameter: userName', 'setGPS');
    }
    $phoneNumber = $_GET['phoneNumber'];
    if($phoneNumber == ''){
        error('Need Parameter: phoneNumber', 'setGPS');
    }
    function getNumber(){
        $usId = mt_rand(1111111, 9999999);
        $sql = 'SELECT * FROM gps WHERE userId = '.$usId;
        $data = DB($sql);
        $number = mysqli_num_rows($data);
        if($number) getNumber();
        else return $usId;
    }
    $userId = getNumber();

    $noneGPS = json_encode(array(
       "latitude" => "",
       "longitude" => ""
    ));

    $sql = "INSERT INTO gps VALUES(".$userId.", '".$userName."', '".$phoneNumber."', '".$noneGPS."', '".$noneGPS."')";
    
    $DB = DB_res($sql);
    if($DB){
        success($userId, 'makeUser');
    }
    else{
        error("DB Insert Error", 'setGPS');
    }
?>