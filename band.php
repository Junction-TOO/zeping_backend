<?php
header("Content-Type: application/json");
include 'common.php';

$type = $_GET['type'];
/*
type:
    - add: 밴드 추가
        bandId(밴드 고유번호)
    - del: 밴드 제거 
        bandId(밴드 고유번호)
    - get: 정보 가져오기
        bandId(밴드 고유번호) 또는 userId(사용자 토큰)
*/

if($type == 'add'){
    $bandId = $_GET['bandId'];
    if($bandId == '') error('Need Parameter: bandId', 'band');
    $sql = "SELECT * FROM gps WHERE bandId='".$bandId."'";
    $DB = DB($sql);
    if(mysqli_num_rows($DB)) error("이미 등록되어 있는 밴드입니다.", 'band');

    $sql = "INSERT INTO gps Values('".$bandId."', NULL, NULL, NULL, NULL, NULL, 0)";
    $DB = DB_res($sql);
    if($DB){
        $echo = array(
            "success" => true,
            "message" => "밴드 추가 완료!"
        );
        echo json_encode($echo);
    }
    else{
        error("DB Insert Error", 'band');
    }
}
else if($type == 'del'){
    $bandId = $_GET['bandId'];
    if($bandId == '') error('Need Parameter: bandId', 'band');
    $sql = "SELECT * FROM gps WHERE bandId='".$bandId."'";
    $DB = DB($sql);
    if(!mysqli_num_rows($DB)) error("이미 삭제 된 밴드입니다.", 'band');
    $sql = "DELETE FROM gps WHERE bandId='".$bandId."'";
    $DB = DB_res($sql);
    if($DB){
        $echo = array(
            "success" => true,
            "message" => "밴드 삭제 완료!"
        );
        echo json_encode($echo);
    }
    else{
        error("DB Delete Error", 'band');
    }
}
else if($type == 'get'){
    $bandId = $_GET['bandId'];
    $userId = $_GET['userId'];
    if($bandId != '' && $userId != ''){
        $rep = "SELECT * FROM gps WHERE bandId='".$bandId."' AND userId='".$userId."'";
    }
    else if($bandId != ''){
        $rep = "SELECT * FROM gps WHERE bandId='".$bandId."'";
    }
    else if($userId != ''){
        $rep = "SELECT * FROM gps WHERE userId='".$userId."'";
    }
    else{
        $rep = "SELECT * FROM gps";
    }
    
    $db = DB($rep);
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
            "losted" => boolval($row[6]),
            "url" => 'https://zep.us/play/2p1am6?customData=["'.$row[1].'"]'
        ));
    }
    $echo = array(
        "success" => true,
        "message" => "밴드 정보 불러오기 성공!",
        "data" => $data
    );
    echo json_encode($echo);
}
else{
    error('Wrong Parameter: type', 'band');
}


?>