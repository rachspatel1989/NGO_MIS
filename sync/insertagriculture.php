<?php

include_once '../include/DB_Functions.php';
$db = new DB_Functions();

//Get JSON posted by Android Application
$json = $_POST["agricultureJSON"];

//Decode JSON into an Array
$data = json_decode($json);

//Util arrays to create response JSON
$response = array();
$agriculture = array();

date_default_timezone_set('Asia/Kolkata');
$date_cr = date('m/d/Y');
$dt = date("Y/m/d", strtotime($date_cr));
$St_Time = "01:00:00";
$date = date('m/d/Y h:i:s a', time());
$timestamp = strtotime($date);

//Loop through an Array and insert data read from JSON into MySQL DB
for ($i = 0; $i < count($data); $i++) {
    $login_id = $data[$i]->login_id;
    $havefarmland = $data[$i]->havefarmland;
    $farmtype = $data[$i]->farmtype;
    $farmarea = $data[$i]->farmarea;
    $farmunit = $data[$i]->farmunit;
    $farmcost = $data[$i]->farmcost;
    $irrigatedarea = $data[$i]->irrigatedarea;
    $irrigatedunit = $data[$i]->irrigatedunit;
    $undulatingarea = $data[$i]->undulatingarea;
    $undulatingunit = $data[$i]->undulatingunit;
    $wastearea = $data[$i]->wastearea;
    $wasteunit = $data[$i]->wasteunit;
    $leveledarea = $data[$i]->leveledarea;
    $leveledunit = $data[$i]->leveledunit;
    $underirrigationarea = $data[$i]->underirrigationarea;
    $underirrigationunit = $data[$i]->underirrigationunit;
    $ip = $data[$i]->ip;
    $tempid = $data[$i]->tempid;

    if (isset($ip) && isset($tempid)) {

        $familysql = mysql_query("SELECT family_master.family_id FROM family_master WHERE family_master.reg_device_id = '$ip' AND family_master.reg_temp_id = '$tempid'");
        $familyrow = mysql_fetch_assoc($familysql);
        $family_id = $familyrow['family_id'];
        if ($family_id != "") {

            //Store User into MySQL DB
            $result = $db->Agriculture($login_id, $family_id, mysql_real_escape_string($havefarmland), mysql_real_escape_string($farmtype), mysql_real_escape_string($farmarea), mysql_real_escape_string($farmunit), mysql_real_escape_string($farmcost), mysql_real_escape_string($irrigatedarea), mysql_real_escape_string($irrigatedunit), mysql_real_escape_string($undulatingarea), mysql_real_escape_string($undulatingunit), mysql_real_escape_string($wastearea), mysql_real_escape_string($wasteunit), mysql_real_escape_string($leveledarea), mysql_real_escape_string($leveledunit), mysql_real_escape_string($underirrigationarea), mysql_real_escape_string($underirrigationunit), $ip, $date, $timestamp, $tempid);

            //Based on insertion, create JSON response
            if ($result) {
                $agriculture["reg_temp_id"] = $tempid;
                $agriculture["status"] = 'yes';
                array_push($response, $agriculture);
            } else {
                $agriculture["reg_temp_id"] = $tempid;
                $agriculture["status"] = 'no';
                array_push($response, $agriculture);
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