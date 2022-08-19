<?php
    header("Content-Type: application/json");
    include 'common.php';
    $userName = $_GET['userName'];
    if($userName == ''){
        error('Need Parameter: userName');
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
    $sql = 'INSERT INTO gps VALUES('.$userId.', "'.$userName.'", "", "")';
    $res = DB_res($sql);

    if(!$res) error("DB Insert Error");
    $echo = array(
        "success" => true,
        "message" => "success",
        "data" => array(
            "userName" => $userName,
            "userId" => $userId
        )
    );
    echo json_encode($echo);
?>