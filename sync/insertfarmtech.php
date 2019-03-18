<?php

include_once '../include/DB_Functions.php';
$db = new DB_Functions();

//Get JSON posted by Android Application
$json = $_POST["farmtechJSON"];

//Decode JSON into an Array
$data = json_decode($json);

//Util arrays to create response JSON
$response = array();
$farmtech = array();

date_default_timezone_set('Asia/Kolkata');
$date_cr = date('m/d/Y');
$dt = date("Y/m/d", strtotime($date_cr));
$St_Time = "01:00:00";
$date = date('m/d/Y h:i:s a', time());
$timestamp = strtotime($date);

//Loop through an Array and insert data read from JSON into MySQL DB
for ($i = 0; $i < count($data); $i++) {
    $login_id = $data[$i]->login_id;
    $ispaddy = $data[$i]->ispaddy;
    $newtech = $data[$i]->newtech;
    $technology = $data[$i]->technology;
    $techsupport = $data[$i]->techsupport;
    $techsupportsecond = $data[$i]->techsupportsecond;
    $techsupportthird = $data[$i]->techsupportthird;
    $wellirrigation = $data[$i]->wellirrigation;
    $irrigation = $data[$i]->irrigation;
    $gwsource = $data[$i]->gwsource;
    $landavailable = $data[$i]->landavailable;
    $nolandreason = $data[$i]->nolandreason;
    $ip = $data[$i]->ip;
    $tempid = $data[$i]->tempid;

    if (isset($ip) && isset($tempid)) {

        $familysql = mysql_query("SELECT family_master.family_id FROM family_master WHERE family_master.reg_device_id = '$ip' AND family_master.reg_temp_id = '$tempid'");
        $familyrow = mysql_fetch_assoc($familysql);
        $family_id = $familyrow['family_id'];
        if ($family_id != "") {

            //Store User into MySQL DB
            $result = $db->Farmtechnology($login_id, $family_id, mysql_real_escape_string($ispaddy), mysql_real_escape_string($newtech), mysql_real_escape_string($technology), mysql_real_escape_string($techsupport), mysql_real_escape_string($techsupportsecond), mysql_real_escape_string($techsupportthird), mysql_real_escape_string($wellirrigation), mysql_real_escape_string($irrigation), mysql_real_escape_string($gwsource), mysql_real_escape_string($landavailable), mysql_real_escape_string($nolandreason), $ip, $date, $timestamp, $tempid);

            //Based on insertion, create JSON response
            if ($result) {
                $farmtech["reg_temp_id"] = $tempid;
                $farmtech["status"] = 'yes';
                array_push($response, $farmtech);
            } else {
                $farmtech["reg_temp_id"] = $tempid;
                $farmtech["status"] = 'no';
                array_push($response, $farmtech);
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