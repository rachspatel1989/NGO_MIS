<?php

include_once '../include/DB_Functions.php';
$db = new DB_Functions();

//Get JSON posted by Android Application
$json = $_POST["pendingsurveyJSON"];

//Decode JSON into an Array
$data = json_decode($json);

$response = array();
$pendingsurvey = array();

date_default_timezone_set('Asia/Kolkata');
$date_cr = date('m/d/Y');
$dt = date("Y/m/d", strtotime($date_cr));
$St_Time = "01:00:00";
$date = date('m/d/Y h:i:s a', time());
$timestamp = strtotime($date);

//Loop through an Array and insert data read from JSON into MySQL DB
for ($i = 0; $i < count($data); $i++) {

    $head_name = $data[$i]->head_name;    
    $contact_no = $data[$i]->contact_no;
    $village_name = $data[$i]->village_name;
    $login_id = $data[$i]->login_id;
    $ip = $data[$i]->ip;
    $tempid = $data[$i]->tempid;

    if (isset($data[$i]->ip) && isset($data[$i]->tempid)) {

        if ($db->PersonalDataExists($tempid, $family_head_name)) {
            // user already exists
            $response["response"] = 1;
            $response["message"] = $tempid . "already exists";
            echo json_encode($response);
            
        } else {
            //Store User into MySQL DB
            $result = $db->PendingSurvey(mysql_real_escape_string($head_name),mysql_real_escape_string($contact_no),mysql_real_escape_string($village_name),  mysql_real_escape_string($login_id),$ip,$date,$timestamp,$tempid);
            //Based on insertion, create JSON response
            if ($result) {
                $pendingsurvey["reg_temp_id"] = $data[$i]->tempid;
                $pendingsurvey["status"] = 'yes';
                array_push($response, $pendingsurvey);
            } else {
                $pendingsurvey["reg_temp_id"] = $data[$i]->tempid;
                $pendingsurvey["status"] = 'no';
                array_push($response, $pendingsurvey);
            }
        }
    } else {
        $response["response"] = 0;
        $response["message"] = "Missing Parameters Required.";
    }
}
//Post JSON response back to Android Application
echo json_encode($response);
?>