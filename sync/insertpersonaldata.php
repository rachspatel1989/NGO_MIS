<?php

include_once '../include/DB_Functions.php';
$db = new DB_Functions();

//Get JSON posted by Android Application
$json = $_POST["personaldataJSON"];

//Decode JSON into an Array
$data = json_decode($json);

$response = array();
$personaldata = array();

function getid() {
    $result = mysql_query("SELECT * FROM family_master");
    $num_rows = mysql_num_rows($result);
    if ($num_rows > 0) {
        $get = mysql_query("SELECT MAX(family_unique_id) FROM family_master");
        $got = mysql_fetch_array($get);
        $next_id = $got['MAX(family_unique_id)'] + 1;
        return $next_id;
    } else {
        $next_id = 1001;
        return $next_id;
    }
}

date_default_timezone_set('Asia/Kolkata');
$date_cr = date('m/d/Y');
$dt = date("Y/m/d", strtotime($date_cr));
$St_Time = "01:00:00";
$date = date('m/d/Y h:i:s a', time());
$timestamp = strtotime($date);

//Loop through an Array and insert data read from JSON into MySQL DB
for ($i = 0; $i < count($data); $i++) {

    $next_id = getid();
    $login_id = $data[$i]->login_id;
    $family_habitation = $data[$i]->family_habitation;
    $family_phone = $data[$i]->family_phone;
    $family_head_name = $data[$i]->family_head_name;    
    $family_address = $data[$i]->family_address;
    $district = $data[$i]->district;
    $block = $data[$i]->block;
    $cluster = $data[$i]->cluster;
    $gp = $data[$i]->gp;
    $village = $data[$i]->village;
    $member_no = $data[$i]->member_no;
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
            $result = $db->PersonalData($login_id, $next_id,mysql_real_escape_string($family_habitation),mysql_real_escape_string($family_phone),mysql_real_escape_string($family_head_name),mysql_real_escape_string($family_address),mysql_real_escape_string($district),mysql_real_escape_string($block),mysql_real_escape_string($cluster),mysql_real_escape_string($gp),mysql_real_escape_string($village),mysql_real_escape_string($member_no),$ip,$date,$timestamp,$tempid);
            //Based on insertion, create JSON response
            if ($result) {
                $personaldata["reg_temp_id"] = $data[$i]->tempid;
                $personaldata["status"] = 'yes';
                array_push($response, $personaldata);
            } else {
                $personaldata["reg_temp_id"] = $data[$i]->tempid;
                $personaldata["status"] = 'no';
                array_push($response, $personaldata);
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