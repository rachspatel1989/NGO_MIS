<?php

include_once '../include/DB_Functions.php';
$db = new DB_Functions();

//Get JSON posted by Android Application
$json = $_POST["progressdetailsJSON"];

//Decode JSON into an Array
$data = json_decode($json);

//Util arrays to create response JSON
$response = array();
$progressdetails = array();

date_default_timezone_set('Asia/Kolkata');
$date_cr = date('m/d/Y');
$dt = date("Y/m/d", strtotime($date_cr));
$St_Time = "01:00:00";
$date = date('m/d/Y h:i:s a', time());
$timestamp = strtotime($date);

//Loop through an Array and insert data read from JSON into MySQL DB
for ($i = 0; $i < count($data); $i++) {
    $login_id = $data[$i]->login_id;
    $beneficiary_id = $data[$i]->beneficiary_id;
    $activity_name = $data[$i]->activity_name;
    $other_activity = $data[$i]->other_activity;
    $fertilizer_name = $data[$i]->fertilizer_name;
    $fertilizer_qty = $data[$i]->fertilizer_qty;
    $fertilizer_total_cost = $data[$i]->fertilizer_total_cost;
    $seed_qty = $data[$i]->seed_qty;
    $seed_variety_name = $data[$i]->seed_variety_name;
    $seed_total_cost = $data[$i]->seed_total_cost;
    $dbmgf_grant = $data[$i]->dbmgf_grant;
    $lhwrf_grant = $data[$i]->lhwrf_grant;
    $mf_grant = $data[$i]->mf_grant;
    $beneficiary_contribution = $data[$i]->beneficiary_contribution;
    $farmers_contribution = $data[$i]->farmers_contribution;
    $nabard = $data[$i]->nabard;
    $other_grants = $data[$i]->other_grants;
    $mf_availed = $data[$i]->mf_availed;
    $land_levelled_area = $data[$i]->land_levelled_area;
    $total_no = $data[$i]->total_no;
    $species_name = $data[$i]->species_name;
    $variety = $data[$i]->variety;
    $survival_no = $data[$i]->survival_no;
    $insurance_amt = $data[$i]->insurance_amt;
    $contribution_amt = $data[$i]->contribution_amt;
    $enterprise_verification = $data[$i]->enterprise_verification;
    $equipment_name = $data[$i]->equipment_name;
    $equipment_no = $data[$i]->equipment_no;
    $IGA_name = $data[$i]->IGA_name;
    $SHG_name = $data[$i]->SHG_name;
    $training_name = $data[$i]->training_name;
    $training_duration = $data[$i]->training_duration;
    $agency_venue = $data[$i]->agency_venue;
    $financial_institute = $data[$i]->financial_institute;
    $loan_amt = $data[$i]->loan_amt;
    $rate_of_interest = $data[$i]->rate_of_interest;
    $ip = $data[$i]->ip;
    $tempid = $data[$i]->tempid;
    
    if (isset($data[$i]->ip) && isset($data[$i]->tempid)) {

        //Store User into MySQL DB
        $result = $db->ProgressDetailsTracker($login_id, $beneficiary_id, mysql_real_escape_string($activity_name), mysql_real_escape_string($other_activity), mysql_real_escape_string($fertilizer_name), mysql_real_escape_string($fertilizer_qty), mysql_real_escape_string($fertilizer_total_cost), mysql_real_escape_string($seed_qty), mysql_real_escape_string($seed_variety_name), mysql_real_escape_string($seed_total_cost), mysql_real_escape_string($dbmgf_grant), mysql_real_escape_string($lhwrf_grant), mysql_real_escape_string($mf_grant), mysql_real_escape_string($beneficiary_contribution), mysql_real_escape_string($farmers_contribution), mysql_real_escape_string($nabard), mysql_real_escape_string($other_grants), mysql_real_escape_string($mf_availed), mysql_real_escape_string($land_levelled_area), mysql_real_escape_string($total_no), mysql_real_escape_string($species_name), mysql_real_escape_string($variety), mysql_real_escape_string($survival_no), mysql_real_escape_string($insurance_amt), mysql_real_escape_string($contribution_amt), mysql_real_escape_string($enterprise_verification), mysql_real_escape_string($equipment_name), mysql_real_escape_string($equipment_no), mysql_real_escape_string($IGA_name), mysql_real_escape_string($SHG_name), mysql_real_escape_string($training_name), mysql_real_escape_string($training_duration), mysql_real_escape_string($agency_venue), mysql_real_escape_string($financial_institute), mysql_real_escape_string($loan_amt), mysql_real_escape_string($rate_of_interest), $ip, $tempid, $date, $timestamp);

        //Based on insertion, create JSON response
        if ($result) {
            $progressdetails["reg_temp_id"] = $tempid;
            $progressdetails["status"] = 'yes';
            array_push($response, $progressdetails);
        } else {
            $progressdetails["reg_temp_id"] = $tempid;
            $progressdetails["status"] = 'no';
            array_push($response, $progressdetails);
        }
    } else {
        $response["response"] = 0;
        $response["message"] = "Missing Parameters Required.";
    }
}
//Post JSON response back to Android Application
echo json_encode($response);
?>