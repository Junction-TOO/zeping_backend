<?php
header("Content-Type: application/json");
include 'common.php';

$type = $_GET['type'];
/*
type:
    - child: 자녀 위치 등록
        userId(사용자 토큰), latitude(위도), longitude(경도)

    - parents: 부모 위치 등록
        userId(사용자 토큰), latitude(위도), longitude(경도)
*/


$userId = $_GET['userId'];
if($userId == '') error('Need Parameter: userId', 'gps');
$sql = "SELECT * FROM gps WHERE userId='".$userId."'";
$DB = DB($sql);
if(!mysqli_num_rows($DB)) error("등록 사용자가 아닙니다.", 'gps');

$latitude = $_GET['latitude'];
if($latitude == ''){
    error('Need Parameter: latitude', 'gps');
}

$longitude = $_GET['longitude'];
if($longitude == ''){
    error('Need Parameter: longitude', 'gps');
}

$noneGPS = json_encode(array(
    "latitude" => $latitude,
    "longitude" => $longitude
));

if($type == 'child'){
    $sql = "UPDATE gps SET cGPS='".$noneGPS."' WHERE userId='".$userId."'";
    
}
else if($type == 'parents'){
    $sql = "UPDATE gps SET pGPS='".$noneGPS."' WHERE userId='".$userId."'";
}
else{
    error('Wrong Parameter: type', 'gps');
}

$DB = DB_res($sql);
if($DB){
    $echo = array(
        "success" => true,
        "message" => "GPS 정보 수정 성공!"
    );
    echo json_encode($echo);
}
else{
    error("DB Insert Error: ".$sql, 'gps');
}

?>