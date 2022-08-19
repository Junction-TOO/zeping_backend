<?php
    header("Content-Type: application/json");
    include 'common.php';
    $userId = $_GET['userId'];
    if($userId == ''){
        error('Need Parameter: userId', 'deleteUser');
    }

    $sql = 'SELECT * FROM gps WHERE userId='.$userId;
    $DB = mysqli_fetch_row(DB($sql));
    $db0 = $DB[0];
    $db1 = $DB[1];
    $db2 = $DB[2];
    $cGPS = json_decode($DB[3]);
    $pGPS = json_decode($DB[4]);
    if($db0 == NULL && $db1 == NULL && $db2 == NULL && $cGPS == NULL && $pGPS == NULL){
        error('Not Found User (ID: '.$userId.')', 'deleteUser');
    }

    $sql = 'DELETE FROM gps WHERE userId='.$userId;
    $DB = DB_res($sql);
    if($DB){
        $sql = 'SELECT * FROM gps WHERE userId='.$userId;
        $DB = mysqli_fetch_row(DB($sql));
        $db0 = $DB[0];
        $db1 = $DB[1];
        $db2 = $DB[2];
        $cGPS = json_decode($DB[3]);
        $pGPS = json_decode($DB[4]);
        if($db0 != NULL || $db1 != NULL || $db2 != NULL || $cGPS != NULL || $pGPS != NULL){
            error('Can not Delete User (ID: '.$userId.')', 'deleteUser');
        }

        $echo = array(
            "success" => true,
            "url" => 'deleteUser',
            "message" => "success",
            "data" => "Deleted User"
        );
        echo json_encode($echo);
    }
    else{
        error("DB Delete Error", 'deleteUser');
    }
?>