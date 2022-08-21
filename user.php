<?php
header("Content-Type: application/json");
include 'common.php';
$type = $_GET['type'];
/*
type:
    - add: 사용자 밴드에 등록
        userName(자녀 이름), phoneNumber(부모님 전화번호), bandId(밴드 고유번호)

    - del: 밴드에서 사용자 삭제
        bandId(밴드 고유번호)
*/
function getNumber(){
    $usId = mt_rand(1111111, 9999999);
    $sql = 'SELECT * FROM gps WHERE userId = '.$usId;
    $data = DB($sql);
    $number = mysqli_num_rows($data);
    if($number) getNumber();
    else return $usId;
}

if($type == 'add'){
    $bandId = $_GET['bandId'];
    if($bandId == '') error('Need Parameter: bandId', 'user');
    $sql = "SELECT * FROM gps WHERE bandId='".$bandId."'";
    $DB = DB($sql);
    if(!mysqli_num_rows($DB)) error("등록 된 밴드가 아닙니다.", 'user');
    $DB = mysqli_fetch_row($DB);
    $aUserId = $DB[1];
    if($aUserId != NULL) error("다른 사용자가 등록된 밴드입니다.", 'user');

    $userName = $_GET['userName'];
    if($userName == ''){
        error('Need Parameter: userName', 'setGPS');
    }
    $phoneNumber = $_GET['phoneNumber'];
    if($phoneNumber == ''){
        error('Need Parameter: phoneNumber', 'setGPS');
    }

    $userId = getNumber();
    $sql = "UPDATE gps SET userId='".$userId."', userName='".$userName."', phoneNumber='".$phoneNumber."', cGPS=NULL, pGPS=NULL, losted=0 WHERE bandId='".$bandId."'";
    $DB = DB_res($sql);
    if($DB){
        $echo = array(
            "success" => true,
            "message" => "사용자 정보 등록 완료!",
            "data" => array(
                "userId" => $userId,
                "url" => 'https://zep.us/play/yxWxlb?customData=["'.$userId.'"]'
            )
        );
        echo json_encode($echo);
    }
    else{
        error("DB Update Error", 'user');
    }
}
else if($type == 'del'){
    $bandId = $_GET['bandId'];
    $userId = $_GET['userId'];
    if($bandId != ''){
        $sql = "SELECT * FROM gps WHERE bandId='".$bandId."'";
        $DB = DB($sql);
        if(!mysqli_num_rows($DB)) error("등록 된 밴드가 아닙니다.", 'user');
    
        $sql = "UPDATE gps SET userId=NULL, userName=NULL, phoneNumber=NULL, cGPS=NULL, pGPS=NULL, losted=0 WHERE bandId='".$bandId."'";
        $DB = DB_res($sql);
        if($DB){
            $echo = array(
                "success" => true,
                "message" => "사용자 정보 삭제 완료!"
            );
            echo json_encode($echo);
        }
        else{
            error("DB Update Error", 'user');
        }
    }
    else if($userId != ''){
        $sql = "SELECT * FROM gps WHERE userId='".$userId."'";
        $DB = DB($sql);
        if(!mysqli_num_rows($DB)) error("등록 된 사용자가 아닙니다.", 'user');
    
        $sql = "UPDATE gps SET userId=NULL, userName=NULL, phoneNumber=NULL, cGPS=NULL, pGPS=NULL, losted=0 WHERE userId='".$userId."'";
        $DB = DB_res($sql);
        if($DB){
            $echo = array(
                "success" => true,
                "message" => "사용자 정보 삭제 완료!"
            );
            echo json_encode($echo);
        }
        else{
            error("DB Update Error", 'user');
        }
    }
}
else{
    error('Wrong Parameter: type', 'user');
}

?>