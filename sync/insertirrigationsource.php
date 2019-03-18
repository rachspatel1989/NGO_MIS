<?php

include_once '../include/DB_Functions.php';
$db = new DB_Functions();

//Get JSON posted by Android Application
$json = $_POST["irrigationsourceJSON"];

//Decode JSON into an Array
$data = json_decode($json);

//Util arrays to create response JSON
$response = array();
$irrigationsource = array();

date_default_timezone_set('Asia/Kolkata');
$date_cr = date('m/d/Y');
$dt = date("Y/m/d", strtotime($date_cr));
$St_Time = "01:00:00";
$date = date('m/d/Y h:i:s a', time());
$timestamp = strtotime($date);

//Loop through an Array and insert data read from JSON into MySQL DB
for ($i = 0; $i < count($data); $i++) {
    $login_id = $data[$i]->login_id;
    $source_name = $data[$i]->source_name;
    $source_usability = $data[$i]->source_usability;
    $issource_own_lease = $data[$i]->issource_own_lease;
    $havesource_type = $data[$i]->havesource_type;
    $own_source = $data[$i]->own_source;
    $iswater_own_kharif = $data[$i]->iswater_own_kharif;
    $iswater_own_rabi = $data[$i]->iswater_own_rabi;
    $iswater_own_summer = $data[$i]->iswater_own_summer;
    $lease_source = $data[$i]->lease_source;
    $iswater_lease_kharif = $data[$i]->iswater_lease_kharif;
    $iswater_lease_rabi = $data[$i]->iswater_lease_rabi;
    $iswater_lease_summer = $data[$i]->iswater_lease_summer;
    $group_source = $data[$i]->group_source;
    $iswater_group_kharif = $data[$i]->iswater_group_kharif;
    $iswater_group_rabi = $data[$i]->iswater_group_rabi;
    $iswater_group_summer = $data[$i]->iswater_group_summer;
    $ip = $data[$i]->ip;
    $tempid = $data[$i]->tempid;
    
    if (isset($ip) && isset($tempid)) {

        $familysql = mysql_query("SELECT family_master.family_id FROM family_master WHERE family_master.reg_device_id = '$ip' AND family_master.reg_temp_id = '$tempid'");
        $familyrow = mysql_fetch_assoc($familysql);
        $family_id = $familyrow['family_id'];
        if ($family_id != "") {

            //Store User into MySQL DB
            $result = $db->Irrigationsource($login_id,$family_id,mysql_real_escape_string($source_name),mysql_real_escape_string($source_usability),mysql_real_escape_string($issource_own_lease),mysql_real_escape_string($havesource_type),mysql_real_escape_string($own_source),mysql_real_escape_string($iswater_own_kharif),mysql_real_escape_string($iswater_own_rabi),mysql_real_escape_string($iswater_own_summer),mysql_real_escape_string($lease_source),mysql_real_escape_string($iswater_lease_kharif),mysql_real_escape_string($iswater_lease_rabi),mysql_real_escape_string($iswater_lease_summer),mysql_real_escape_string($group_source),mysql_real_escape_string($iswater_group_kharif),mysql_real_escape_string($iswater_group_rabi),mysql_real_escape_string($iswater_group_summer),$ip,$tempid,$date,$timestamp);

            //Based on insertion, create JSON response
            if ($result) {
                $irrigationsource["reg_temp_id"] = $tempid;
                $irrigationsource["status"] = 'yes';
                array_push($response, $irrigationsource);
            } else {
                $irrigationsource["reg_temp_id"] = $tempid;
                $irrigationsource["status"] = 'no';
                array_push($response, $irrigationsource);
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
