<?php

include_once '../include/DB_Functions.php';
$db = new DB_Functions();

//Get JSON posted by Android Application
$json = $_POST["cropproductivityJSON"];

//Decode JSON into an Array
$data = json_decode($json);

//Util arrays to create response JSON
$response = array();
$cropproductivity = array();

date_default_timezone_set('Asia/Kolkata');
$date_cr = date('m/d/Y');
$dt = date("Y/m/d", strtotime($date_cr));
$St_Time = "01:00:00";
$date = date('m/d/Y h:i:s a', time());
$timestamp = strtotime($date);

//Loop through an Array and insert data read from JSON into MySQL DB
for ($i = 0; $i < count($data); $i++) {
    $login_id = $data[$i]->login_id;
    $crop_id = $data[$i]->crop_id;
    $consumed_crop = $data[$i]->consumed_crop;
    $landarea = $data[$i]->landarea;
    $landunit = $data[$i]->landunit;
    $totalproductionamount = $data[$i]->totalproductionamount;
    $totalproductionunit = $data[$i]->totalproductionunit;
    $soldamount = $data[$i]->soldamount;
    $soldunit = $data[$i]->soldunit;
    $expenditure = $data[$i]->expenditure;
    $marketrate = $data[$i]->marketrate;
    $marketrateunit = $data[$i]->marketrateunit;
    $productionamount = $data[$i]->productionamount;
    $productionunit = $data[$i]->productionunit;
    $ip = $data[$i]->ip;
    $tempid = $data[$i]->tempid;

    if (isset($ip) && isset($tempid)) {

        $familysql = mysql_query("SELECT family_master.family_id FROM family_master WHERE family_master.reg_device_id = '$ip' AND family_master.reg_temp_id = '$tempid'");
        $familyrow = mysql_fetch_assoc($familysql);
        $family_id = $familyrow['family_id'];
        if ($family_id != "") {
            
            //Store User into MySQL DB
            $result = $db->Cropproductivity($login_id, $family_id, mysql_real_escape_string($crop_id), mysql_real_escape_string($consumed_crop), mysql_real_escape_string($landarea), mysql_real_escape_string($landunit), mysql_real_escape_string($totalproductionamount), mysql_real_escape_string($totalproductionunit), mysql_real_escape_string($soldamount), mysql_real_escape_string($soldunit), mysql_real_escape_string($expenditure), mysql_real_escape_string($marketrate), mysql_real_escape_string($marketrateunit), mysql_real_escape_string($productionamount), mysql_real_escape_string($productionunit), $ip, $date, $timestamp, $tempid);

            //Based on insertion, create JSON response
            if ($result) {
                $cropproductivity["reg_temp_id"] = $tempid;
                $cropproductivity["status"] = 'yes';
                array_push($response, $cropproductivity);
            } else {
                $cropproductivity["reg_temp_id"] = $tempid;
                $cropproductivity["status"] = 'no';
                array_push($response, $cropproductivity);
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