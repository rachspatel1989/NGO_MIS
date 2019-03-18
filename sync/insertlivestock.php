<?php

include_once '../include/DB_Functions.php';
$db = new DB_Functions();
mysql_set_charset("utf8");

//Get JSON posted by Android Application
$json = $_POST["livestockJSON"];

//Decode JSON into an Array
$data = json_decode($json);

//Util arrays to create response JSON
$response = array();
$livestock = array();

date_default_timezone_set('Asia/Kolkata');
$date_cr = date('m/d/Y');
$dt = date("Y/m/d", strtotime($date_cr));
$St_Time = "01:00:00";
$date = date('m/d/Y h:i:s a', time());
$timestamp = strtotime($date);

//Loop through an Array and insert data read from JSON into MySQL DB
for ($i = 0; $i < count($data); $i++) {
    $login_id = $data[$i]->login_id;
    $hormfarm = $data[$i]->hormfarm;
    $livestocktype = $data[$i]->livestocktype;
    $indigenousbreed = $data[$i]->indigenousbreed;
    $crossbreed = $data[$i]->crossbreed;
    $income_recieved = $data[$i]->income_recieved;
    $monthly_expenditure = $data[$i]->monthly_expenditure;
    $benefits_received = $data[$i]->benefits_received;
    $meat = $data[$i]->meat;
    $eggs = $data[$i]->eggs;
    $milk = $data[$i]->milk;
    $fur = $data[$i]->fur;
    $sales_per_baby = $data[$i]->sales_per_baby;
    $sales_per_fullgrown = $data[$i]->sales_per_fullgrown;
    $sales_per_kg_meat = $data[$i]->sales_per_kg_meat;
    $sales_dozen_egg = $data[$i]->sales_dozen_egg;
    $sales_per_litre_milk = $data[$i]->sales_per_litre_milk;
    $sales_per_kg_fur = $data[$i]->sales_per_kg_fur;
    $market_accessible = $data[$i]->market_accessible;
    $cattle_rearing = $data[$i]->cattle_rearing;
    $ip = $data[$i]->ip;
    $tempid = $data[$i]->tempid;

    if (isset($ip) && isset($tempid)) {

        $familysql = mysql_query("SELECT family_master.family_id FROM family_master WHERE family_master.reg_device_id = '$ip' AND family_master.reg_temp_id = '$tempid'");
        $familyrow = mysql_fetch_assoc($familysql);
        $family_id = $familyrow['family_id'];
        if ($family_id != "") {
           
            //Store User into MySQL DB
            $result = $db->LiveStock($login_id, $family_id, mysql_real_escape_string($hormfarm), mysql_real_escape_string($livestocktype), mysql_real_escape_string($indigenousbreed), mysql_real_escape_string($crossbreed), mysql_real_escape_string($income_recieved), mysql_real_escape_string($monthly_expenditure), mysql_real_escape_string($benefits_received), mysql_real_escape_string($meat), mysql_real_escape_string($eggs), mysql_real_escape_string($milk), mysql_real_escape_string($fur), mysql_real_escape_string($sales_per_baby), mysql_real_escape_string($sales_per_fullgrown), mysql_real_escape_string($sales_per_kg_meat), mysql_real_escape_string($sales_dozen_egg), mysql_real_escape_string($sales_per_litre_milk), mysql_real_escape_string($sales_per_kg_fur), mysql_real_escape_string($market_accessible), mysql_real_escape_string($cattle_rearing), $ip, $date, $timestamp, $tempid);
            //Based on insertion, create JSON response
            if ($result) {
                $livestock["reg_temp_id"] = $tempid;
                $livestock["status"] = 'yes';
                array_push($response, $livestock);
            } else {
                $livestock["reg_temp_id"] = $tempid;
                $livestock["status"] = 'no';
                array_push($response, $livestock);
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