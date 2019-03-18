<?php

include_once '../include/DB_Functions.php';
$db = new DB_Functions();

if (isset($_POST['reg_device_id']) && isset($_POST['reg_temp_id']) && isset($_POST['loginid']) && isset($_POST['allocate_id'])) {

    $ip = $_POST['reg_device_id'];
    $tempid = $_POST['reg_temp_id'];
    $allocate_id = $_POST['allocate_id'];
    $login_id = $_POST['loginid'];

    function getid() {
        $result = mysql_query("SELECT * FROM activity_verification_master");
        $num_rows = mysql_num_rows($result);
        if ($num_rows > 0) {
            $get = mysql_query("SELECT MAX(bn_id) FROM activity_verification_master");
            $got = mysql_fetch_array($get);
            $next_id = $got['MAX(bn_id)'] + 1;
            return $next_id;
        } else {
            $next_id = "1";
            return $next_id;
        }
    }

    date_default_timezone_set('Asia/Kolkata');
    $date_cr = date('m/d/Y');
    $dt = date("Y/m/d", strtotime($date_cr));
    $St_Time = "01:00:00";
    $date = date('m/d/Y h:i:s a', time());
    $timestamp = strtotime($date);

    $sql_fet = "SELECT village_master.village_name FROM activity_allocation_master INNER JOIN family_master ON activity_allocation_master.family_id = family_master.family_id INNER JOIN village_master ON family_master.village_id = village_master.village_id WHERE activity_allocation_master.allocate_id = $allocate_id";
    if (!( $selectRes = mysql_query($sql_fet) )) {
        echo 'Retrieval of data from Database Failed - #' . mysql_errno() . ': ' . mysql_error();
    } else {
        if (mysql_num_rows($selectRes) == 0) {
            echo 'No Rows Returned';
        } else {
            
        }
        while ($rows = mysql_fetch_assoc($selectRes)) {
            $_SESSION['village_name'] = $rows['village_name'];
            $village_name = $_SESSION['village_name'];
        }
    }

    $benificiary_id = $village_name . getid();

    $sql_fetch = mysql_query("SELECT activity_allocation_master.activity_id,cluster_master.cluster_name,gp_master.gp_name,village_master.village_name,family_master.family_phone,family_master.family_head_name,family_master.family_address,family_member_master.fm_profile_img_path FROM activity_allocation_master INNER JOIN family_master ON activity_allocation_master.family_id = family_master.family_id INNER JOIN cluster_master ON family_master.cluster_id = cluster_master.cluster_id INNER JOIN gp_master ON family_master.gp_id = gp_master.gp_id INNER JOIN village_master ON family_master.village_id = village_master.village_id INNER JOIN family_member_master ON activity_allocation_master.family_id = family_member_master.family_id WHERE activity_allocation_master.allocate_id = '$allocate_id' AND family_member_master.fm_status = 1");
    if (mysql_num_rows($sql_fetch) > 0) {

        while ($row = mysql_fetch_array($sql_fetch)) {
            // temp user array
            $res["activity"] = $row["activity_id"];
            $res["cluster"] = $row['cluster_name'];
            $res["gp"] = $row['gp_name'];
            $res["village"] = $row['village_name'];
            $res["fphone"] = $row['family_phone'];
            $res["headname"] = $row['family_head_name'];
            $res["faddress"] = $row['family_address'];
            $res["profilepic"] = $row['fm_profile_img_path'];
        }
    }
    $res["benificiary_id"] = $benificiary_id;

    $sql = "SELECT family_id FROM activity_allocation_master WHERE activity_allocation_master.allocate_id = $allocate_id";
    $select = mysql_query($sql);
    $rows = mysql_fetch_assoc($select);
    $family_id = $rows['family_id'];

//    $user = $db->insertFamilyVerification($login_id, $family_id, $allocate_id, $benificiary_id, $ip, $date, $timestamp, $tempid);
//    if ($user) {
//        $res["response"] = 1;
//        $res["message"] = "Data Inserted.";
//        echo json_encode($res);
//        $sql = "SELECT activity_allocation_master.activity_id FROM activity_allocation_master WHERE activity_allocation_master.allocate_id = $allocate_id";
//        $select = mysql_query($sql);
//        $row1 = mysql_fetch_assoc($select);
//        $activity_id = $row1['activity_id'];
//    } else {
//        $res["response"] = 2;
//        $res["message"] = "Unknown error occurred in registration!";
//        echo json_encode($res);
//    }
}