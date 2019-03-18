<?php

include_once '../include/DB_Functions.php';
$db = new DB_Functions();

if (isset($_POST['reg_device_id']) && isset($_POST['reg_temp_id'])) {

    // receiving the post params    
    $reason = $_POST['reason'];
    $get_allocate_id = $_POST['get_allocate_id'];
    $tempid = $_POST['reg_temp_id'];
    $ip = $_POST['reg_device_id'];

    date_default_timezone_set('Asia/Kolkata');
    $date_cr = date('m/d/Y');
    $dt = date("Y/m/d", strtotime($date_cr));
    $St_Time = "01:00:00";
    $date = date('m/d/Y h:i:s a', time());
    $timestamp = strtotime($date);

    $result = mysql_query("SELECT * FROM family_master WHERE family_master.reg_device_id = '$ip' AND family_master.reg_temp_id = '$tempid'") or die("Error");
    $row = mysql_fetch_array($result);
    $family_id = $row["family_id"];

    if ($family_id != "") {

        if ($reason == "") {
            $app_status = $_POST['approval'];
            $user = $db->UpdateActivity($get_allocate_id, $app_status);
            if ($user) {
                $response["response"] = 1;
                $response["message"] = "Data Updated.";
                echo json_encode($response);
            } else {
                $response["response"] = 2;
                $response["message"] = "Unknown error occurred in registration!";
                echo json_encode($response);
            }
        } else {
            $user1 = $db->insertActivityReason($login_id, $family_id, $reason, $ip, $date, $timestamp, $tempid);
            if ($user1) {
                $response["response"] = 1;
                $response["message"] = "Data Inserted.";
                echo json_encode($response);
            } else {
                $response["response"] = 2;
                $response["message"] = "Unknown error occurred in registration!";
                echo json_encode($response);
            }
        }
    } else {
        $response["response"] = 0;
        $response["message"] = "Data Mismatch.";
        echo json_encode($response);
    }
}
