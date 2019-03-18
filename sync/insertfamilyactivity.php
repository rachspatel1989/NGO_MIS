<?php

include_once '../include/DB_Functions.php';
$db = new DB_Functions();

//Get JSON posted by Android Application
$json = $_POST["familyactivityJSON"];

//Decode JSON into an Array
$data = json_decode($json);

//Util arrays to create response JSON
$response = array();
$familyactivity = array();

date_default_timezone_set('Asia/Kolkata');
$date_cr = date('m/d/Y');
$dt = date("Y/m/d", strtotime($date_cr));
$St_Time = "01:00:00";
$date = date('m/d/Y h:i:s a', time());
$timestamp = strtotime($date);

//Loop through an Array and insert data read from JSON into MySQL DB
for ($i = 0; $i < count($data); $i++) {
    $login_id = $data[$i]->login_id;
    $dbmgf_grant = $data[$i]->dbmgf_grant;
    $beneficiary_contribution = $data[$i]->beneficiary_contribution;
    $mf = $data[$i]->mf;
    $nabard = $data[$i]->nabard;
    $government = $data[$i]->government;
    $others = $data[$i]->others;
    $ip = $data[$i]->ip;
    $tempid = $data[$i]->tempid;

    if (isset($data[$i]->ip) && isset($data[$i]->tempid)) {

        //Store User into MySQL DB
        $result = $db->FamilyLevel(mysql_real_escape_string($dbmgf_grant), mysql_real_escape_string($beneficiary_contribution), mysql_real_escape_string($mf), mysql_real_escape_string($nabard), mysql_real_escape_string($government), mysql_real_escape_string($others), $ip, $tempid, $date, $timestamp);

        //Based on insertion, create JSON response
        if ($result) {
            $familyactivity["reg_temp_id"] = $tempid;
            $familyactivity["status"] = 'yes';
            array_push($response, $familyactivity);
        } else {
            $familyactivity["reg_temp_id"] = $tempid;
            $familyactivity["status"] = 'no';
            array_push($response, $familyactivity);
        }
    } else {
        $response["response"] = 0;
        $response["message"] = "Missing Parameters Required.";
    }
}
//Post JSON response back to Android Application
echo json_encode($response);
?>