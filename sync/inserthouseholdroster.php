<?php

include_once '../include/DB_Functions.php';
$db = new DB_Functions();

header('Content-Type: application/json;charset=utf-8');
//Get JSON posted by Android Application
$json = $_POST["householdrosterJSON"];

//Decode JSON into an Array
$data = json_decode($json);

//Util arrays to create response JSON
$response = array();
$household = array();

date_default_timezone_set('Asia/Kolkata');
$date_cr = date('m/d/Y');
$dt = date("Y/m/d", strtotime($date_cr));
$St_Time = "01:00:00";
$date = date('m/d/Y h:i:s a', time());
$timestamp = strtotime($date);

//Loop through an Array and insert data read from JSON into MySQL DB
for ($i = 0; $i < count($data); $i++) {

    $fm_member_unique_id = "";
    $login_id = $data[$i]->login_id;
    $fm_member_name = $data[$i]->fm_member_name;
    $fm_gender = $data[$i]->fm_gender;
    $fm_age = $data[$i]->fm_age;
    $fm_anganwaadi_attended = $data[$i]->fm_anganwaadi_attended;
    $fm_school_attended = $data[$i]->fm_school_attended;
    $fm_education = $data[$i]->fm_education;
    $fm_occupation_id = $data[$i]->fm_occupation_id;
    $fm_work_interest = $data[$i]->fm_work_interest;
    $fm_women_sgh = $data[$i]->fm_women_sgh;
    $fm_emp_name = $data[$i]->fm_emp_name;
    $fm_per_month_salary = $data[$i]->fm_per_month_salary;
    $ip = $data[$i]->ip;
    $tempid = $data[$i]->tempid;
    $status = $data[$i]->fm_status;

    if (isset($ip) && isset($tempid)) {

        $familysql = mysql_query("SELECT family_master.family_id FROM family_master WHERE family_master.reg_device_id = '$ip' AND family_master.reg_temp_id = '$tempid'");
        $familyrow = mysql_fetch_assoc($familysql);
        $family_id = $familyrow['family_id'];
        if ($family_id != "") {

            //Store User into MySQL DB
            $result = $db->HouseholdRoster($login_id, $family_id, mysql_real_escape_string($fm_member_unique_id), mysql_real_escape_string($fm_member_name), mysql_real_escape_string($fm_gender), mysql_real_escape_string($fm_age), mysql_real_escape_string($fm_anganwaadi_attended), mysql_real_escape_string($fm_school_attended), mysql_real_escape_string($fm_education), mysql_real_escape_string($fm_occupation_id), mysql_real_escape_string($fm_work_interest), mysql_real_escape_string($fm_women_sgh), mysql_real_escape_string($fm_emp_name), mysql_real_escape_string($fm_per_month_salary), $ip, $date, $timestamp, $tempid, $status);
            //Based on insertion, create JSON response
            if ($result) {
                $household["reg_temp_id"] = $tempid;
                $household["status"] = 'yes';
                array_push($response, $household);
            } else {
                $household["reg_temp_id"] = $tempid;
                $household["status"] = 'no';
                array_push($response, $household);
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