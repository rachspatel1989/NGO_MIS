<?php

include_once '../include/DB_Functions.php';
$db = new DB_Functions();

//Get JSON posted by Android Application
$json = $_POST["housematerailsJSON"];

//Decode JSON into an Array
$data = json_decode($json);

//Util arrays to create response JSON
$response = array();
$housematerails = array();

date_default_timezone_set('Asia/Kolkata');
$date_cr = date('m/d/Y');
$dt = date("Y/m/d", strtotime($date_cr));
$St_Time = "01:00:00";
$date = date('m/d/Y h:i:s a', time());
$timestamp = strtotime($date);

//Loop through an Array and insert data read from JSON into MySQL DB
for ($i = 0; $i < count($data); $i++) {
    $login_id = $data[$i]->login_id;
    $floor = $data[$i]->floor;
    $walls = $data[$i]->walls;
    $roof = $data[$i]->roof;
    $ip = $data[$i]->ip;
    $tempid = $data[$i]->tempid;

    if (isset($ip) && isset($tempid)) {

        $familysql = mysql_query("SELECT family_master.family_id FROM family_master WHERE family_master.reg_device_id = '$ip' AND family_master.reg_temp_id = '$tempid'");
        $familyrow = mysql_fetch_assoc($familysql);
        $family_id = $familyrow['family_id'];
        if ($family_id != "") {

            //Store User into MySQL DB
            $result = $db->Housematerials($login_id, $family_id, mysql_real_escape_string($floor), mysql_real_escape_string($walls), mysql_real_escape_string($roof), $ip, $date, $timestamp, $tempid);

            //Based on insertion, create JSON response
            if ($result) {
                $housematerails["reg_temp_id"] = $tempid;
                $housematerails["status"] = 'yes';
                array_push($response, $housematerails);
            } else {
                $housematerails["reg_temp_id"] = $tempid;
                $housematerails["status"] = 'no';
                array_push($response, $housematerails);
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