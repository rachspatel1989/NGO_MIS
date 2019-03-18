<?php

include_once '../include/DB_Functions.php';
$db = new DB_Functions();
mysql_set_charset("UTF8");

//Get JSON posted by Android Application
$json = $_POST["selfempJSON"];

//Decode JSON into an Array
$data = json_decode($json);

//Util arrays to create response JSON
$response = array();
$selfemp = array();

date_default_timezone_set('Asia/Kolkata');
$date_cr = date('m/d/Y');
$dt = date("Y/m/d", strtotime($date_cr));
$St_Time = "01:00:00";
$date = date('m/d/Y h:i:s a', time());
$timestamp = strtotime($date);

//Loop through an Array and insert data read from JSON into MySQL DB
for ($i = 0; $i < count($data); $i++) {
    $login_id = $data[$i]->login_id;
    $familymember = $data[$i]->familymember;
    $trainingrequired = $data[$i]->trainingrequired;
    $grantreceive = $data[$i]->grantreceive;
    $investmentgrant = $data[$i]->investmentgrant;
    $investmentcredit = $data[$i]->investmentcredit;    
    $ip = $data[$i]->ip;
    $tempid = $data[$i]->tempid;

    if (isset($ip) && isset($tempid)) {

        $familysql = mysql_query("SELECT family_master.family_id FROM family_master WHERE family_master.reg_device_id = '$ip' AND family_master.reg_temp_id = '$tempid'");
        $familyrow = mysql_fetch_assoc($familysql);
        $family_id = $familyrow['family_id'];
        if ($family_id != "") {

            //Store User into MySQL DB
            $result = $db->SelfEmployment($login_id, $family_id, mysql_real_escape_string($familymember), mysql_real_escape_string($trainingrequired), mysql_real_escape_string($grantreceive), mysql_real_escape_string($investmentgrant), mysql_real_escape_string($investmentcredit), $ip, $date, $timestamp, $tempid);

            //Based on insertion, create JSON response
            if ($result) {
                $selfemp["reg_temp_id"] = $tempid;
                $selfemp["status"] = 'yes';
                array_push($response, $selfemp);
            } else {
                $selfemp["reg_temp_id"] = $tempid;
                $selfemp["status"] = 'no';
                array_push($response, $selfemp);
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