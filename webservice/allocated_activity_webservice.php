<?php

include_once '../include/DB_Functions.php';
$db = new DB_Functions();

if (isset($_POST['reg_device_id']) && isset($_POST['reg_temp_id'])) {

// receiving the post params
    $reg_device_id = $_POST['reg_device_id'];
    $reg_temp_id = $_POST['reg_temp_id'];

    $result = mysql_query("SELECT * FROM family_master WHERE family_master.reg_device_id = '$reg_device_id' AND family_master.reg_temp_id = '$reg_temp_id'") or die("Error");
    $row = mysql_fetch_array($result);
    $family_id = $row["family_id"];


    $sql_query = mysql_query("SELECT activity_allocation_master.allocate_id,activity_allocation_master.activity_id,activity_verification_master.benificiary_id,activity_allocation_master.family_id FROM activity_allocation_master INNER JOIN activity_verification_master ON activity_allocation_master.family_id = activity_verification_master.family_id WHERE activity_allocation_master.family_id = '$family_id' AND activity_allocation_master.approval_status = 'Yes'") or die("Error");
    if (mysql_num_rows($sql_query) > 0) {
// response
        $response["response"] = 1;
        while ($row = mysql_fetch_assoc($sql_query)) {
            $response["allocate_id"] = $row["allocate_id"];
            $response["activity"] = $row["activity_id"];
            $response["benificiary_id"] = $row["benificiary_id"];
            $response["family_id"] = $row["family_id"];
        }

        // echoing JSON response
        echo json_encode($response);
    } else {
        $response["response"] = 2;
        $response["message"] = "No data found";

        // echo no users JSON
        echo json_encode($response);
    }
} else {
    $response["response"] = 3;
    $response["message"] = "Required Parameters Missing";

    // echo no users JSON
    echo json_encode($response);
}

    