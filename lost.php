<?php
header("Content-Type: application/json");
include 'common.php';

$type = $_GET['type'];
/*
type:
    - add: 미아 추가
        bandId(밴드 고유번호)
    - del: 미아 제거 
        bandId(밴드 고유번호)
    - get: 정보 가져오기
*/
if($type == 'add' || $type == 'del'){
    $userId = $_GET['userId'];
    if($userId == '') error('Need Parameter: userId', 'gps');
    $sql = "SELECT * FROM gps WHERE userId='".$userId."'";
    $DB = DB($sql);
    if(!mysqli_num_rows($DB)) error("등록 사용자가 아닙니다.", 'lost');


    if($type == 'add') $ls = 1;
    else if($type == 'del') $ls = 0;
    $sql = "UPDATE gps SET losted=".$ls." WHERE userId='".$userId."'";
    $DB = DB_res($sql);
    if($DB){
        $echo = array(
            "success" => true,
            "message" => "미아 정보 수정 성공!!"
        );
        echo json_encode($echo);
    }
    else{
        error("DB Update Error: ".$sql, 'lost');
    }
}
else if($type == 'get'){
    $db = DB("SELECT * from gps WHERE losted=1");
    $data = array();
    while($row = mysqli_fetch_row($db)){
        $cGPS = json_decode($row[4]);
        $pGPS = json_decode($row[5]);
        if($cGPS == 'null') $cGPS = NULL;
        if($pGPS == 'null') $pGPS = NULL;
        array_push($data, array(
            "bandId" => $row[0],
            "userId" => $row[1],
            "userName" => $row[2],
            "phoneNumber" => $row[3],
            "cGPS" => $cGPS,
            "pGPS" => $pGPS,
            "losted" => boolval($row[6])
        ));
    }
    $echo = array(
        "success" => true,
        "message" => "미아 정보 불러오기 성공!",
        "data" => $data
    );
    echo json_encode($echo);
}
else{
    error('Wrong Parameter: type', 'lost');
}



?>