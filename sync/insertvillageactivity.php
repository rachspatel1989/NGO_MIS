<?php

include_once '../include/DB_Functions.php';
$db = new DB_Functions();

//Get JSON posted by Android Application
$json = $_POST["villageactivityJSON"];

//Decode JSON into an Array
$data = json_decode($json);

//Util arrays to create response JSON
$response = array();
$villageactivity = array();

date_default_timezone_set('Asia/Kolkata');
$date_cr = date('m/d/Y');
$dt = date("Y/m/d", strtotime($date_cr));
$St_Time = "01:00:00";
$date = date('m/d/Y h:i:s a', time());
$timestamp = strtotime($date);

//Loop through an Array and insert data read from JSON into MySQL DB
for ($i = 0; $i < count($data); $i++) {
    $login_id = $data[$i]->login_id;
    $sectorname = $data[$i]->sectorname;
    $block = $data[$i]->block;
    $village_name = $data[$i]->village_name;
    $cluster_name = $data[$i]->cluster_name;
    $activity = $data[$i]->activity;
    $subactivity = $data[$i]->subactivity;
    $other_sub_activity = $data[$i]->other_sub_activity;
    $date_of_activity = $data[$i]->date_of_activity;
    $no_of_participant = $data[$i]->no_of_participant;
    $dbmgf_grant = $data[$i]->dbmgf_grant;
    $beneficiary_contribution = $data[$i]->beneficiary_contribution;
    $mf = $data[$i]->mf;
    $nabard = $data[$i]->nabard;
    $government = $data[$i]->government;
    $others = $data[$i]->others;
    $ip = $data[$i]->ip;
    $tempid = $data[$i]->tempid;
    $family_id = "";

    if (isset($ip) && isset($tempid)) {
        
            //Store User into MySQL DB
            $result = $db->VillageLevel($login_id, $family_id, mysql_real_escape_string($sectorname), mysql_real_escape_string($block), mysql_real_escape_string($village_name), mysql_real_escape_string($cluster_name), mysql_real_escape_string($activity), mysql_real_escape_string($subactivity), mysql_real_escape_string($other_sub_activity), mysql_real_escape_string($date_of_activity), mysql_real_escape_string($no_of_participant), mysql_real_escape_string($dbmgf_grant), mysql_real_escape_string($beneficiary_contribution), mysql_real_escape_string($mf), mysql_real_escape_string($nabard), mysql_real_escape_string($government), mysql_real_escape_string($others), $ip, $tempid, $date, $timestamp);

            //Based on insertion, create JSON response
            if ($result) {
                $villageactivity["reg_temp_id"] = $tempid;
                $villageactivity["status"] = 'yes';
                array_push($response, $villageactivity);
            } else {
                $villageactivity["reg_temp_id"] = $tempid;
                $villageactivity["status"] = 'no';
                array_push($response, $villageactivity);
            }
    } else {
        $response["response"] = 0;
        $response["message"] = "Missing Parameters Required.";
    }
}
//Post JSON response back to Android Application
echo json_encode($response);
?>