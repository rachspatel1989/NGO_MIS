<?php

include_once '../include/DB_Functions.php';
$db = new DB_Functions();

//Get JSON posted by Android Application
$json = $_POST["housetypeJSON"];

//Decode JSON into an Array
$data = json_decode($json);

//Util arrays to create response JSON
$response = array();
$housetype = array();

date_default_timezone_set('Asia/Kolkata');
$date_cr = date('m/d/Y');
$dt = date("Y/m/d", strtotime($date_cr));
$St_Time = "01:00:00";
$date = date('m/d/Y h:i:s a', time());
$timestamp = strtotime($date);

//Loop through an Array and insert data read from JSON into MySQL DB
for ($i = 0; $i < count($data); $i++) {
    $login_id = $data[$i]->login_id;
    $ht_no_of_rooms = $data[$i]->ht_no_of_rooms;
    $ht_kitchen_location = $data[$i]->ht_kitchen_location;
    $ht_cooking_stove_type = $data[$i]->ht_cooking_stove_type;
    $ht_have_toilet = $data[$i]->ht_have_toilet;
    $ht_have_piped_water_connection = $data[$i]->ht_have_piped_water_connection;
    $ht_have_electricity_meter = $data[$i]->ht_have_electricity_meter;
    $ht_space_around_house = $data[$i]->ht_space_around_house;
    $ip = $data[$i]->ip;
    $tempid = $data[$i]->tempid;

    if (isset($ip) && isset($tempid)) {

        $familysql = mysql_query("SELECT family_master.family_id FROM family_master WHERE family_master.reg_device_id = '$ip' AND family_master.reg_temp_id = '$tempid'");
        $familyrow = mysql_fetch_assoc($familysql);
        $family_id = $familyrow['family_id'];
        if ($family_id != "") {

            $materialsql = mysql_query("SELECT mat_id FROM family_housematerials_master where family_housematerials_master.family_id = $family_id");
            while ($matrow = mysql_fetch_assoc($materialsql)) {
                $mat_id = $matrow['mat_id'];
                //Store User into MySQL DB
                $result = $db->HouseType($login_id, $mat_id, mysql_real_escape_string($ht_no_of_rooms), mysql_real_escape_string($ht_kitchen_location), mysql_real_escape_string($ht_cooking_stove_type), mysql_real_escape_string($ht_have_toilet), mysql_real_escape_string($ht_have_piped_water_connection), mysql_real_escape_string($ht_have_electricity_meter), mysql_real_escape_string($ht_space_around_house), $ip, $date, $timestamp, $tempid);

                //Based on insertion, create JSON response
                if ($result) {
                    $housetype["reg_temp_id"] = $tempid;
                    $housetype["status"] = 'yes';
                    array_push($response, $housetype);
                } else {
                    $housetype["reg_temp_id"] = $tempid;
                    $housetype["status"] = 'no';
                    array_push($response, $housetype);
                }
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