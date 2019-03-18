<?php

include_once 'Config.php';

class DB_Functions {

    private $conn;

    public function __construct() {
        $db = new DB_Class();
    }

    function __destruct() {
        
    }

    function runQuery($query) {
        $result = mysql_query($query);
        while ($row = mysql_fetch_assoc($result)) {
            $resultset[] = $row;
        }
        if (!empty($resultset))
            return $resultset;
    }

    function numRows($query) {
        $result = mysql_query($query);
        $rowcount = mysql_num_rows($result);
        return $rowcount;
    }

    public function get_session() {
        return $_SESSION['log_id'];
    }

    public function user_logout() {
        $_SESSION['log_id'] = FALSE;
        session_destroy();
    }

    public function check_login($email, $password) {
        //$password = md5($password);
        $result = mysql_query("SELECT * from login_master WHERE login_uname = '$email' and login_password = '$password' and login_type != 'surveyors'");
        $user_data = mysql_fetch_array($result);
        $no_rows = mysql_num_rows($result);

        if ($no_rows == 1) {
            $_SESSION['log_id'] = true;
            $_SESSION['login_id'] = $user_data['login_id'];
            $_SESSION['login_uid'] = $user_data['login_uid'];
            $_SESSION['login_type'] = $user_data['login_type'];
            return TRUE;
        } else {
            echo "<script language='javascript' type='text/javascript'> alert('Email or Password Invalid');</script>";
            return FALSE;
        }
    }

    public function storeUser($Id, $User, $Phone) {
        // Insert user into database
        $result = mysql_query("INSERT INTO users VALUES($Id,'$User','$Phone')");

        if ($result) {
            return true;
        } else {
            if (mysql_errno() == 1062) {
                // Duplicate key - Primary Key Violation
                return true;
            } else {
                // For other errors
                return false;
            }
        }
    }

    public function insertPersonalData($login_id, $next_id, $family_habitation, $family_phone, $family_head_name, $family_address, $district_id, $block_id, $cluster_id, $gp_id, $village_id, $ip, $date, $timestamp, $tempid) {
        $reg_via = "Web";
        mysql_query("SET NAMES utf8");
        $result = mysql_query("INSERT INTO family_master(login_id,family_unique_id,family_habitation,family_phone,family_head_name,family_address,district_id,block_id,cluster_id,gp_id,village_id,activity_status,reg_via,reg_device_id,reg_created_date,reg_timestamp,reg_temp_id) VALUES('$login_id','$next_id','$family_habitation','$family_phone','$family_head_name','$family_address','$district_id', '$block_id', '$cluster_id', '$gp_id','$village_id','0','$reg_via','$ip',STR_TO_DATE('$date','%m/%d/%Y%h:%i'),'$timestamp','$tempid')");
        return $result;
    }

    public function updatePersonalData($family_id, $family_habitation, $family_phone, $family_head_name, $family_address, $district_id, $block_id, $cluster_id, $gp_id, $village_id, $ip) {
        $reg_via = "Web";
        mysql_query("SET NAMES utf8");
        $result = mysql_query("Update family_master set family_habitation= '$family_habitation',family_phone= '$family_phone', family_head_name='$family_head_name', family_address='$family_address', district_id='$district_id', block_id='$block_id', cluster_id='$cluster_id', gp_id='$gp_id', village_id='$village_id', reg_via='$reg_via', reg_device_id='$ip' WHERE family_id = '$family_id'");
        return $result;
    }

//update personal data
    public function PersonalDataUpdate($login_id, $get_family_id, $family_habitation, $family_phone, $family_head_name, $family_address, $district_id, $block_id, $cluster_id, $gp_id, $village_id, $ip) {
        $reg_via = "Web";
        mysql_query("SET NAMES utf8");
        $result = mysql_query("update family_master set login_id='$login_id',family_habitation='$family_habitation',family_phone='$family_phone',family_head_name='$family_head_name',family_address='$family_address',district_id='$district_id',block_id='$block_id',cluster_id='$cluster_id',gp_id='$gp_id',village_id='$village_id',reg_via='$reg_via',reg_device_id='$ip' where family_id='$get_family_id'");
//        $result = mysql_query("INSERT INTO family_master(login_id,family_unique_id,family_habitation,family_phone,family_head_name,family_address,district_id,block_id,cluster_id,gp_id,village_id,activity_status,reg_via,reg_device_id,reg_created_date,reg_timestamp,reg_temp_id) VALUES('$login_id','$next_id','$family_habitation','$family_phone','$family_head_name','$family_address','$district_id', '$block_id', '$cluster_id', '$gp_id','$village_id','0','$reg_via','$ip',STR_TO_DATE('$date','%m/%d/%Y%h:%i'),'$timestamp','$tempid')");
        return $result;
    }

    public function isFamilyExisted($family_phone, $family_head_name) {
        mysql_query("SET NAMES utf8");
        $result = mysql_query("SELECT family_phone FROM family_master where family_phone = '$family_phone' AND family_head_name = '$family_head_name'");
        $user_data = mysql_fetch_array($result);
        $no_rows_res = mysql_num_rows($result);
        if ($no_rows_res == 1) {
            return $family_phone;
        } else {
            return FALSE;
        }
    }

//    public function insertAdministrativeSurveyor($family_id, $hhheadname, $participates, $noofvisit, $interview_result, $ip, $date, $timestamp) {
//        $reg_via = "Web";
//        $result = mysql_query("INSERT INTO surveyor_master (family_id,sv_name,sv_participation,sv_no_of_visits,sv_interview_results,reg_via,reg_device_id,reg_created_date,reg_timestamp) VALUES('$family_id','$hhheadname','$participates','$noofvisit','$interview_result','$reg_via','$ip',STR_TO_DATE('$date','%m/%d/%Y%h:%i'),'$timestamp')");
//        return $result;
//    }
//
//    public function insertAdministrativeVisit($survey_id, $interview_date, $time_begun, $time_end, $time_duration, $ip) {
//        $reg_via = "Web";
//        $result = mysql_query("INSERT INTO visit_master (survey_id,visit_date,visit_start_time,visit_end_time,visit_duration,reg_via,reg_device_id) VALUES('$survey_id','$interview_date','$time_begun','$time_end','$time_duration','$reg_via','$ip')");
//        return $result;
//    }

    public function insertAdministrativeBenefits($recievebenefit, $schemereceive, $rate, $ip) {
        $reg_via = "Web";
        mysql_query("SET NAMES utf8");
        $result = mysql_query("INSERT INTO received_benefits_master (benefits_is_received,benefits_received,benefits_ratings,reg_via,reg_device_id) VALUES('$recievebenefit','$schemereceive','$rate','$reg_via','$ip')");
        return $result;
    }

    public function insertHouseholdRoster($login_id, $family_id, $fm_member_unique_id, $fm_member_name, $fm_gender, $fm_age, $fm_anganwaadi_attended, $fm_school_attended, $fm_education, $fm_occupation_id, $fm_work_interest, $fm_women_sgh, $fm_emp_name, $fm_per_month_salary, $ip, $date, $timestamp, $tempid, $status) {
        $reg_via = "Web";
        mysql_query("SET NAMES utf8");
        $result = mysql_query("INSERT INTO family_member_master(login_id,family_id,fm_member_unique_id,fm_member_name,fm_gender,fm_age,fm_anganwaadi_attended,fm_school_attended,fm_education,fm_occupation_id,fm_work_interest,fm_women_sgh,fm_emp_name,fm_per_month_salary,reg_via,reg_device_id,reg_created_date,reg_timestamp,reg_temp_id,fm_status) VALUES('$login_id','$family_id','$fm_member_unique_id','$fm_member_name','$fm_gender','$fm_age','$fm_anganwaadi_attended', '$fm_school_attended', '$fm_education', '$fm_occupation_id', '$fm_work_interest','$fm_women_sgh','$fm_emp_name','$fm_per_month_salary','$reg_via','$ip',STR_TO_DATE('$date','%m/%d/%Y%h:%i'),'$timestamp','$tempid','$status')");
        return $result;
    }

//update Household
    public function HouseholdRosterUpdate($fm_member_name, $fm_gender, $fm_age, $fm_anganwaadi_attended, $fm_school_attended, $fm_education, $fm_occupation_id, $fm_work_interest, $fm_women_sgh, $fm_emp_name, $fm_per_month_salary, $ip, $fm_getid, $fm_fmid) {
        $reg_via = "Web";
        mysql_query("SET NAMES utf8");
        $result = mysql_query("Update family_member_master SET fm_member_name='$fm_member_name',fm_gender='$fm_gender',fm_age='$fm_age',fm_anganwaadi_attended='$fm_anganwaadi_attended',fm_school_attended='$fm_school_attended',fm_education='$fm_education',fm_occupation_id='$fm_occupation_id',fm_work_interest='$fm_work_interest',fm_women_sgh='$fm_women_sgh',fm_emp_name='$fm_emp_name',fm_per_month_salary='$fm_per_month_salary',reg_via='$reg_via',reg_device_id='$ip' WHERE family_id = '$fm_getid' AND fm_id='$fm_fmid'");
        return $result;
    }

    public function updateFamilyMaster($family_id, $noofmembers) {
        mysql_query("SET NAMES utf8");
        $result = mysql_query("Update family_master set member_no= '$noofmembers' WHERE family_id = '$family_id'");
        return $result;
    }

    public function insertSocioHousehold($login_id, $family_id, $caste, $povertyline, $availability, $housevalue, $monthrent, $buyfood, $consumefood, $quantityoffood, $receivedwages, $costfood, $rainfall, $migrated, $migrating, $totalmembers, $totaltime, $totaldays, $reducedtrips, $reduceddays, $ip, $date, $timestamp, $tempid, $incomedrop1, $incomedrop2, $incomedrop3, $incomedrop4, $incomedrop5, $incomedrop6, $incomedrop7, $incomedrop8, $incomedrop9, $incomedrop10, $incomedrop11, $incomedrop12, $incomedrop13, $incomedrop14, $income_textbox1, $income_textbox2, $income_textbox3, $income_textbox4, $income_textbox5, $income_textbox6, $income_textbox7, $income_textbox8, $income_textbox9, $income_textbox10, $income_textbox11, $income_textbox12, $income_textbox13, $income_textbox14, $asset_textbox1, $asset_textbox2, $asset_textbox3, $asset_textbox4, $asset_textbox5, $asset_textbox6, $asset_textbox7, $asset_textbox8, $asset_textbox9, $asset_textbox10, $asset_textbox11, $asset_textbox12, $asset_textbox13, $asset_textbox14, $sav_textbox1, $sav_textbox2, $sav_textbox3, $sav_textbox4, $sav_textbox5, $sav_textbox6, $sav_textbox7, $sav_textbox8, $sav_textbox9, $savings1, $savings2, $savings3, $savings4, $savings5, $savings6, $savings7, $savings8, $savings9) {
        $reg_via = "Web";
        mysql_query("SET NAMES utf8");
        $result = mysql_query("INSERT INTO family_household_master (login_id,family_id,hh_caste_category,hh_family_type,hh_family_house,hh_market_value,hh_market_rent,reg_via,reg_device_id,reg_created_date,reg_timestamp,reg_temp_id) VALUES('$login_id','$family_id','$caste','$povertyline','$availability','$housevalue','$monthrent','$reg_via','$ip',STR_TO_DATE('$date','%m/%d/%Y%h:%i'),'$timestamp','$tempid')");
        $result1 = mysql_query("INSERT INTO family_foodconsumption_master (login_id,family_id,fd_consumed_per_month,fd_grown_consumption,fd_cost_per_month,fd_wages_consumption,fd_wages_cost,fd_type_of_rainfall,reg_via,reg_device_id,reg_created_date,reg_timestamp,reg_temp_id) VALUES('$login_id','$family_id','$buyfood','$consumefood','$quantityoffood','$receivedwages','$costfood','$rainfall','$reg_via','$ip',STR_TO_DATE('$date','%m/%d/%Y%h:%i'),'$timestamp','$tempid')");
        $result2 = mysql_query("INSERT INTO family_migration_master (login_id,family_id,mg_for_work,mg_reason,mg_no_of_members,mg_no_of_times,mg_total_days_worked,mg_total_trips,mg_total_days,reg_via,reg_device_id,reg_created_date,reg_timestamp,reg_temp_id) VALUES('$login_id','$family_id','$migrated','$migrating','$totalmembers','$totaltime','$totaldays','$reducedtrips','$reduceddays','$reg_via','$ip',STR_TO_DATE('$date','%m/%d/%Y%h:%i'),'$timestamp','$tempid')");

        $result3 = mysql_query("INSERT INTO family_income_master (login_id,family_id,hhd_income_id,hhd_income_recieved,hhd_earnings_per_year,reg_via,reg_device_id,reg_temp_id,reg_created_date,reg_modified_date,reg_timestamp) VALUES('$login_id','$family_id','1','$income_textbox1','','$reg_via','$ip','$tempid',STR_TO_DATE('$date','%m/%d/%Y%h:%i'),STR_TO_DATE('$date','%m/%d/%Y%h:%i'),'$timestamp')");
        $result4 = mysql_query("INSERT INTO family_income_master (login_id,family_id,hhd_income_id,hhd_income_recieved,hhd_earnings_per_year,reg_via,reg_device_id,reg_temp_id,reg_created_date,reg_modified_date,reg_timestamp) VALUES('$login_id','$family_id','2','$income_textbox2','','$reg_via','$ip','$tempid',STR_TO_DATE('$date','%m/%d/%Y%h:%i'),STR_TO_DATE('$date','%m/%d/%Y%h:%i'),'$timestamp')");
        $result5 = mysql_query("INSERT INTO family_income_master (login_id,family_id,hhd_income_id,hhd_income_recieved,hhd_earnings_per_year,reg_via,reg_device_id,reg_temp_id,reg_created_date,reg_modified_date,reg_timestamp) VALUES('$login_id','$family_id','3','$income_textbox3','','$reg_via','$ip','$tempid',STR_TO_DATE('$date','%m/%d/%Y%h:%i'),STR_TO_DATE('$date','%m/%d/%Y%h:%i'),'$timestamp')");
        $result6 = mysql_query("INSERT INTO family_income_master (login_id,family_id,hhd_income_id,hhd_income_recieved,hhd_earnings_per_year,reg_via,reg_device_id,reg_temp_id,reg_created_date,reg_modified_date,reg_timestamp) VALUES('$login_id','$family_id','4','$income_textbox4','','$reg_via','$ip','$tempid',STR_TO_DATE('$date','%m/%d/%Y%h:%i'),STR_TO_DATE('$date','%m/%d/%Y%h:%i'),'$timestamp')");
        $result7 = mysql_query("INSERT INTO family_income_master (login_id,family_id,hhd_income_id,hhd_income_recieved,hhd_earnings_per_year,reg_via,reg_device_id,reg_temp_id,reg_created_date,reg_modified_date,reg_timestamp) VALUES('$login_id','$family_id','5','$income_textbox5','','$reg_via','$ip','$tempid',STR_TO_DATE('$date','%m/%d/%Y%h:%i'),STR_TO_DATE('$date','%m/%d/%Y%h:%i'),'$timestamp')");
        $result8 = mysql_query("INSERT INTO family_income_master (login_id,family_id,hhd_income_id,hhd_income_recieved,hhd_earnings_per_year,reg_via,reg_device_id,reg_temp_id,reg_created_date,reg_modified_date,reg_timestamp) VALUES('$login_id','$family_id','6','$income_textbox6','','$reg_via','$ip','$tempid',STR_TO_DATE('$date','%m/%d/%Y%h:%i'),STR_TO_DATE('$date','%m/%d/%Y%h:%i'),'$timestamp')");
        $result9 = mysql_query("INSERT INTO family_income_master (login_id,family_id,hhd_income_id,hhd_income_recieved,hhd_earnings_per_year,reg_via,reg_device_id,reg_temp_id,reg_created_date,reg_modified_date,reg_timestamp) VALUES('$login_id','$family_id','7','$income_textbox7','','$reg_via','$ip','$tempid',STR_TO_DATE('$date','%m/%d/%Y%h:%i'),STR_TO_DATE('$date','%m/%d/%Y%h:%i'),'$timestamp')");
        $result10 = mysql_query("INSERT INTO family_income_master (login_id,family_id,hhd_income_id,hhd_income_recieved,hhd_earnings_per_year,reg_via,reg_device_id,reg_temp_id,reg_created_date,reg_modified_date,reg_timestamp) VALUES('$login_id','$family_id','8','$income_textbox8','','$reg_via','$ip','$tempid',STR_TO_DATE('$date','%m/%d/%Y%h:%i'),STR_TO_DATE('$date','%m/%d/%Y%h:%i'),'$timestamp')");
        $result11 = mysql_query("INSERT INTO family_income_master (login_id,family_id,hhd_income_id,hhd_income_recieved,hhd_earnings_per_year,reg_via,reg_device_id,reg_temp_id,reg_created_date,reg_modified_date,reg_timestamp) VALUES('$login_id','$family_id','9','$income_textbox9','','$reg_via','$ip','$tempid',STR_TO_DATE('$date','%m/%d/%Y%h:%i'),STR_TO_DATE('$date','%m/%d/%Y%h:%i'),'$timestamp')");
        $result12 = mysql_query("INSERT INTO family_income_master (login_id,family_id,hhd_income_id,hhd_income_recieved,hhd_earnings_per_year,reg_via,reg_device_id,reg_temp_id,reg_created_date,reg_modified_date,reg_timestamp) VALUES('$login_id','$family_id','10','$income_textbox10','','$reg_via','$ip','$tempid',STR_TO_DATE('$date','%m/%d/%Y%h:%i'),STR_TO_DATE('$date','%m/%d/%Y%h:%i'),'$timestamp')");
        $result13 = mysql_query("INSERT INTO family_income_master (login_id,family_id,hhd_income_id,hhd_income_recieved,hhd_earnings_per_year,reg_via,reg_device_id,reg_temp_id,reg_created_date,reg_modified_date,reg_timestamp) VALUES('$login_id','$family_id','11','$income_textbox11','','$reg_via','$ip','$tempid',STR_TO_DATE('$date','%m/%d/%Y%h:%i'),STR_TO_DATE('$date','%m/%d/%Y%h:%i'),'$timestamp')");
        $result14 = mysql_query("INSERT INTO family_income_master (login_id,family_id,hhd_income_id,hhd_income_recieved,hhd_earnings_per_year,reg_via,reg_device_id,reg_temp_id,reg_created_date,reg_modified_date,reg_timestamp) VALUES('$login_id','$family_id','12','$income_textbox12','','$reg_via','$ip','$tempid',STR_TO_DATE('$date','%m/%d/%Y%h:%i'),STR_TO_DATE('$date','%m/%d/%Y%h:%i'),'$timestamp')");
        $result15 = mysql_query("INSERT INTO family_income_master (login_id,family_id,hhd_income_id,hhd_income_recieved,hhd_earnings_per_year,reg_via,reg_device_id,reg_temp_id,reg_created_date,reg_modified_date,reg_timestamp) VALUES('$login_id','$family_id','13','$income_textbox13','','$reg_via','$ip','$tempid',STR_TO_DATE('$date','%m/%d/%Y%h:%i'),STR_TO_DATE('$date','%m/%d/%Y%h:%i'),'$timestamp')");
        $result16 = mysql_query("INSERT INTO family_income_master (login_id,family_id,hhd_income_id,hhd_income_recieved,hhd_earnings_per_year,reg_via,reg_device_id,reg_temp_id,reg_created_date,reg_modified_date,reg_timestamp) VALUES('$login_id','$family_id','14','$income_textbox14','','$reg_via','$ip','$tempid',STR_TO_DATE('$date','%m/%d/%Y%h:%i'),STR_TO_DATE('$date','%m/%d/%Y%h:%i'),'$timestamp')");

        $result17 = mysql_query("INSERT INTO family_asset_master (login_id,family_id,asset_type_id,total_asset_no,reg_via,reg_device_id,reg_temp_id,reg_created_date,reg_modified_date,reg_timestamp) VALUES('$login_id','$family_id','1','$asset_textbox1','$reg_via','$ip','$tempid',STR_TO_DATE('$date','%m/%d/%Y%h:%i'),STR_TO_DATE('$date','%m/%d/%Y%h:%i'),'$timestamp')");
        $result18 = mysql_query("INSERT INTO family_asset_master (login_id,family_id,asset_type_id,total_asset_no,reg_via,reg_device_id,reg_temp_id,reg_created_date,reg_modified_date,reg_timestamp) VALUES('$login_id','$family_id','2','$asset_textbox2','$reg_via','$ip','$tempid',STR_TO_DATE('$date','%m/%d/%Y%h:%i'),STR_TO_DATE('$date','%m/%d/%Y%h:%i'),'$timestamp')");
        $result19 = mysql_query("INSERT INTO family_asset_master (login_id,family_id,asset_type_id,total_asset_no,reg_via,reg_device_id,reg_temp_id,reg_created_date,reg_modified_date,reg_timestamp) VALUES('$login_id','$family_id','3','$asset_textbox3','$reg_via','$ip','$tempid',STR_TO_DATE('$date','%m/%d/%Y%h:%i'),STR_TO_DATE('$date','%m/%d/%Y%h:%i'),'$timestamp')");
        $result20 = mysql_query("INSERT INTO family_asset_master (login_id,family_id,asset_type_id,total_asset_no,reg_via,reg_device_id,reg_temp_id,reg_created_date,reg_modified_date,reg_timestamp) VALUES('$login_id','$family_id','4','$asset_textbox4','$reg_via','$ip','$tempid',STR_TO_DATE('$date','%m/%d/%Y%h:%i'),STR_TO_DATE('$date','%m/%d/%Y%h:%i'),'$timestamp')");
        $result21 = mysql_query("INSERT INTO family_asset_master (login_id,family_id,asset_type_id,total_asset_no,reg_via,reg_device_id,reg_temp_id,reg_created_date,reg_modified_date,reg_timestamp) VALUES('$login_id','$family_id','5','$asset_textbox5','$reg_via','$ip','$tempid',STR_TO_DATE('$date','%m/%d/%Y%h:%i'),STR_TO_DATE('$date','%m/%d/%Y%h:%i'),'$timestamp')");
        $result22 = mysql_query("INSERT INTO family_asset_master (login_id,family_id,asset_type_id,total_asset_no,reg_via,reg_device_id,reg_temp_id,reg_created_date,reg_modified_date,reg_timestamp) VALUES('$login_id','$family_id','6','$asset_textbox6','$reg_via','$ip','$tempid',STR_TO_DATE('$date','%m/%d/%Y%h:%i'),STR_TO_DATE('$date','%m/%d/%Y%h:%i'),'$timestamp')");
        $result23 = mysql_query("INSERT INTO family_asset_master (login_id,family_id,asset_type_id,total_asset_no,reg_via,reg_device_id,reg_temp_id,reg_created_date,reg_modified_date,reg_timestamp) VALUES('$login_id','$family_id','7','$asset_textbox7','$reg_via','$ip','$tempid',STR_TO_DATE('$date','%m/%d/%Y%h:%i'),STR_TO_DATE('$date','%m/%d/%Y%h:%i'),'$timestamp')");
        $result24 = mysql_query("INSERT INTO family_asset_master (login_id,family_id,asset_type_id,total_asset_no,reg_via,reg_device_id,reg_temp_id,reg_created_date,reg_modified_date,reg_timestamp) VALUES('$login_id','$family_id','8','$asset_textbox8','$reg_via','$ip','$tempid',STR_TO_DATE('$date','%m/%d/%Y%h:%i'),STR_TO_DATE('$date','%m/%d/%Y%h:%i'),'$timestamp')");
        $result25 = mysql_query("INSERT INTO family_asset_master (login_id,family_id,asset_type_id,total_asset_no,reg_via,reg_device_id,reg_temp_id,reg_created_date,reg_modified_date,reg_timestamp) VALUES('$login_id','$family_id','9','$asset_textbox9','$reg_via','$ip','$tempid',STR_TO_DATE('$date','%m/%d/%Y%h:%i'),STR_TO_DATE('$date','%m/%d/%Y%h:%i'),'$timestamp')");
        $result26 = mysql_query("INSERT INTO family_asset_master (login_id,family_id,asset_type_id,total_asset_no,reg_via,reg_device_id,reg_temp_id,reg_created_date,reg_modified_date,reg_timestamp) VALUES('$login_id','$family_id','10','$asset_textbox10','$reg_via','$ip','$tempid',STR_TO_DATE('$date','%m/%d/%Y%h:%i'),STR_TO_DATE('$date','%m/%d/%Y%h:%i'),'$timestamp')");
        $result27 = mysql_query("INSERT INTO family_asset_master (login_id,family_id,asset_type_id,total_asset_no,reg_via,reg_device_id,reg_temp_id,reg_created_date,reg_modified_date,reg_timestamp) VALUES('$login_id','$family_id','11','$asset_textbox11','$reg_via','$ip','$tempid',STR_TO_DATE('$date','%m/%d/%Y%h:%i'),STR_TO_DATE('$date','%m/%d/%Y%h:%i'),'$timestamp')");
        $result28 = mysql_query("INSERT INTO family_asset_master (login_id,family_id,asset_type_id,total_asset_no,reg_via,reg_device_id,reg_temp_id,reg_created_date,reg_modified_date,reg_timestamp) VALUES('$login_id','$family_id','12','$asset_textbox12','$reg_via','$ip','$tempid',STR_TO_DATE('$date','%m/%d/%Y%h:%i'),STR_TO_DATE('$date','%m/%d/%Y%h:%i'),'$timestamp')");
        $result29 = mysql_query("INSERT INTO family_asset_master (login_id,family_id,asset_type_id,total_asset_no,reg_via,reg_device_id,reg_temp_id,reg_created_date,reg_modified_date,reg_timestamp) VALUES('$login_id','$family_id','13','$asset_textbox13','$reg_via','$ip','$tempid',STR_TO_DATE('$date','%m/%d/%Y%h:%i'),STR_TO_DATE('$date','%m/%d/%Y%h:%i'),'$timestamp')");
        $result30 = mysql_query("INSERT INTO family_asset_master (login_id,family_id,asset_type_id,total_asset_no,reg_via,reg_device_id,reg_temp_id,reg_created_date,reg_modified_date,reg_timestamp) VALUES('$login_id','$family_id','14','$asset_textbox14','$reg_via','$ip','$tempid',STR_TO_DATE('$date','%m/%d/%Y%h:%i'),STR_TO_DATE('$date','%m/%d/%Y%h:%i'),'$timestamp')");

        $result31 = mysql_query("INSERT INTO family_savings_master (login_id,family_id,saving_source,household_savings,saved_rupees,reg_via,reg_device_id,reg_temp_id,reg_created_date,reg_modified_date,reg_timestamp) VALUES('$login_id','$family_id','1','$savings1','$sav_textbox1','$reg_via','$ip','$tempid',STR_TO_DATE('$date','%m/%d/%Y%h:%i'),STR_TO_DATE('$date','%m/%d/%Y%h:%i'),'$timestamp')");
        $result32 = mysql_query("INSERT INTO family_savings_master (login_id,family_id,saving_source,household_savings,saved_rupees,reg_via,reg_device_id,reg_temp_id,reg_created_date,reg_modified_date,reg_timestamp) VALUES('$login_id','$family_id','2','$savings2','$sav_textbox2','$reg_via','$ip','$tempid',STR_TO_DATE('$date','%m/%d/%Y%h:%i'),STR_TO_DATE('$date','%m/%d/%Y%h:%i'),'$timestamp')");
        $result33 = mysql_query("INSERT INTO family_savings_master (login_id,family_id,saving_source,household_savings,saved_rupees,reg_via,reg_device_id,reg_temp_id,reg_created_date,reg_modified_date,reg_timestamp) VALUES('$login_id','$family_id','3','$savings3','$sav_textbox3','$reg_via','$ip','$tempid',STR_TO_DATE('$date','%m/%d/%Y%h:%i'),STR_TO_DATE('$date','%m/%d/%Y%h:%i'),'$timestamp')");
        $result34 = mysql_query("INSERT INTO family_savings_master (login_id,family_id,saving_source,household_savings,saved_rupees,reg_via,reg_device_id,reg_temp_id,reg_created_date,reg_modified_date,reg_timestamp) VALUES('$login_id','$family_id','4','$savings4','$sav_textbox4','$reg_via','$ip','$tempid',STR_TO_DATE('$date','%m/%d/%Y%h:%i'),STR_TO_DATE('$date','%m/%d/%Y%h:%i'),'$timestamp')");
        $result35 = mysql_query("INSERT INTO family_savings_master (login_id,family_id,saving_source,household_savings,saved_rupees,reg_via,reg_device_id,reg_temp_id,reg_created_date,reg_modified_date,reg_timestamp) VALUES('$login_id','$family_id','5','$savings5','$sav_textbox5','$reg_via','$ip','$tempid',STR_TO_DATE('$date','%m/%d/%Y%h:%i'),STR_TO_DATE('$date','%m/%d/%Y%h:%i'),'$timestamp')");
        $result36 = mysql_query("INSERT INTO family_savings_master (login_id,family_id,saving_source,household_savings,saved_rupees,reg_via,reg_device_id,reg_temp_id,reg_created_date,reg_modified_date,reg_timestamp) VALUES('$login_id','$family_id','6','$savings6','$sav_textbox6','$reg_via','$ip','$tempid',STR_TO_DATE('$date','%m/%d/%Y%h:%i'),STR_TO_DATE('$date','%m/%d/%Y%h:%i'),'$timestamp')");
        $result37 = mysql_query("INSERT INTO family_savings_master (login_id,family_id,saving_source,household_savings,saved_rupees,reg_via,reg_device_id,reg_temp_id,reg_created_date,reg_modified_date,reg_timestamp) VALUES('$login_id','$family_id','7','$savings7','$sav_textbox7','$reg_via','$ip','$tempid',STR_TO_DATE('$date','%m/%d/%Y%h:%i'),STR_TO_DATE('$date','%m/%d/%Y%h:%i'),'$timestamp')");
        $result38 = mysql_query("INSERT INTO family_savings_master (login_id,family_id,saving_source,household_savings,saved_rupees,reg_via,reg_device_id,reg_temp_id,reg_created_date,reg_modified_date,reg_timestamp) VALUES('$login_id','$family_id','8','$savings8','$sav_textbox8','$reg_via','$ip','$tempid',STR_TO_DATE('$date','%m/%d/%Y%h:%i'),STR_TO_DATE('$date','%m/%d/%Y%h:%i'),'$timestamp')");
        $result39 = mysql_query("INSERT INTO family_savings_master (login_id,family_id,saving_source,household_savings,saved_rupees,reg_via,reg_device_id,reg_temp_id,reg_created_date,reg_modified_date,reg_timestamp) VALUES('$login_id','$family_id','9','$savings9','$sav_textbox9','$reg_via','$ip','$tempid',STR_TO_DATE('$date','%m/%d/%Y%h:%i'),STR_TO_DATE('$date','%m/%d/%Y%h:%i'),'$timestamp')");

        return $result;
    }

    public function SocioHouseholdUpdate($login_id, $get_family_id, $caste, $povertyline, $availability, $housevalue, $monthrent, $buyfood, $consumefood, $quantityoffood, $receivedwages, $costfood, $rainfall, $migrated, $migrating, $totalmembers, $totaltime, $totaldays, $reducedtrips, $reduceddays, $ip, $date, $timestamp, $tempid, $cost_per_year, $incomedrop1, $incomedrop2, $incomedrop3, $incomedrop4, $incomedrop5, $incomedrop6, $incomedrop7, $incomedrop8, $incomedrop9, $incomedrop10, $incomedrop11, $incomedrop12, $incomedrop13, $incomedrop14, $income_textbox1, $income_textbox2, $income_textbox3, $income_textbox4, $income_textbox5, $income_textbox6, $income_textbox7, $income_textbox8, $income_textbox9, $income_textbox10, $income_textbox11, $income_textbox12, $income_textbox13, $income_textbox14, $asset_textbox1, $asset_textbox2, $asset_textbox3, $asset_textbox4, $asset_textbox5, $asset_textbox6, $asset_textbox7, $asset_textbox8, $asset_textbox9, $asset_textbox10, $asset_textbox11, $asset_textbox12, $asset_textbox13, $asset_textbox14, $sav_textbox1, $sav_textbox2, $sav_textbox3, $sav_textbox4, $sav_textbox5, $sav_textbox6, $sav_textbox7, $sav_textbox8, $sav_textbox9, $savings1, $savings2, $savings3, $savings4, $savings5, $savings6, $savings7, $savings8, $savings9) {
        $reg_via = "Web";
        mysql_query("SET NAMES utf8");
        $result = mysql_query("update family_household_master set login_id='$login_id',hh_caste_category='$caste',hh_family_type='$povertyline',hh_family_house='$availability',hh_market_value='$housevalue',hh_market_rent='$monthrent',reg_via='$reg_via',reg_device_id='$ip' where family_id='$get_family_id'");
        $result1 = mysql_query("update family_foodconsumption_master set login_id='$login_id',fd_consumed_per_month='$buyfood',fd_grown_consumption='$consumefood',fd_cost_per_month='$quantityoffood',fd_wages_consumption='$receivedwages',fd_wages_cost='$costfood',fd_type_of_rainfall='$rainfall',reg_via='$reg_via',reg_device_id='$ip' where family_id='$get_family_id'");
        $result2 = mysql_query("update family_migration_master set login_id='$login_id',mg_for_work='$migrated',mg_reason='$migrating',mg_no_of_members='$totalmembers',mg_no_of_times='$totaltime',mg_total_days_worked='$totaldays',mg_total_trips='$reducedtrips',mg_total_days='$reduceddays',reg_via='$reg_via',reg_device_id='$ip' where family_id='$get_family_id'");
        $result3 = mysql_query("update family_nonfoodexp_master set login_id='$login_id',cost_per_year='$cost_per_year',reg_via='$reg_via',reg_device_id='$ip' where family_id='$get_family_id'");

        $result4 = mysql_query("update family_income_master set login_id='$login_id',hhd_earnings_per_year='$income_textbox1',hhd_earnings_per_year='$income_textbox2',hhd_earnings_per_year='$income_textbox3',hhd_earnings_per_year='$income_textbox4',hhd_earnings_per_year='$income_textbox5',hhd_earnings_per_year='$income_textbox6',hhd_earnings_per_year='$income_textbox7',hhd_earnings_per_year='$income_textbox8',hhd_earnings_per_year='$income_textbox9',hhd_earnings_per_year='$income_textbox10',hhd_earnings_per_year='$income_textbox11',hhd_earnings_per_year='$income_textbox12',hhd_earnings_per_year='$income_textbox13',hhd_earnings_per_year='$income_textbox14',reg_via='$reg_via',reg_device_id='$ip' where family_id='$get_family_id'");
        $result5 = mysql_query("update family_income_master set login_id='$login_id',hhd_earnings_per_year='$income_textbox2',reg_via='$reg_via',reg_device_id='$ip' where family_id='$get_family_id' AND hhd_income_id='2'");
        return $result;
    }

    public function insertLiveStockType($hormfarm) {
        $reg_via = "Web";
        mysql_query("SET NAMES utf8");
        $result = mysql_query("INSERT INTO livestock_master (livestock_type,reg_via) VALUES('$hormfarm','$reg_via')");
        return $result;
    }

    public function insertLiveStock($login_id, $family_id, $hormfarm, $livestocktype, $indigenousnreed, $crossbreed, $income, $expenditure, $benefitsgot, $milk, $ratebaby, $ratefullgrown, $ratemilk, $marketaccess, $cattlereating, $ip, $date, $timestamp, $tempid) {
        $reg_via = "Web";
        mysql_query("SET NAMES utf8");
        $result = mysql_query("INSERT INTO family_livestock_master (login_id,family_id,flstk_have_livestock,flstk_livestock_id,flstk_have_indigenious_breed,flstk_have_cross_breed,flstk_income_recieved,flstk_monthly_expenditure,flstk_benefits_received,flstk_milk_per_day,flstk_sales_per_baby,flstk_sales_per_fullgrown,flstk_sales_per_litre_milk,flstk_is_market_accessible,flstk_cattle_rearing,reg_via,reg_device_id,reg_created_date,reg_timestamp,reg_temp_id) VALUES('$login_id', '$family_id', '$hormfarm', '$livestocktype', '$indigenousnreed', '$crossbreed', '$income', '$expenditure', '$benefitsgot', '$milk', '$ratebaby', '$ratefullgrown', '$ratemilk', '$marketaccess', '$cattlereating', '$reg_via', '$ip',STR_TO_DATE('$date','%m/%d/%Y%h:%i'),'$timestamp','$tempid')");
        return $result;
    }

    public function insertLiveStockBuff($login_id, $family_id, $hormfarm, $livestocktype, $indigenousnreedbuff, $crossbreedbuff, $incomebuff, $expenditurebuff, $benefitsgot, $milkbuff, $ratebabybuff, $ratefullgrownbuff, $ratemilkbuff, $marketaccess, $cattlereating, $ip, $date, $timestamp, $tempid) {
        $reg_via = "Web";
        mysql_query("SET NAMES utf8");
        $result = mysql_query("INSERT INTO family_livestock_master (login_id,family_id,flstk_have_livestock,flstk_livestock_id,flstk_have_indigenious_breed,flstk_have_cross_breed,flstk_income_recieved,flstk_monthly_expenditure,flstk_benefits_received,flstk_milk_per_day,flstk_sales_per_baby,flstk_sales_per_fullgrown,flstk_sales_per_litre_milk,flstk_is_market_accessible,flstk_cattle_rearing,reg_via,reg_device_id,reg_created_date,reg_timestamp,reg_temp_id) VALUES('$login_id', '$family_id', '$hormfarm', '$livestocktype', '$indigenousnreedbuff', '$crossbreedbuff', '$incomebuff', '$expenditurebuff', '$benefitsgot', '$milkbuff', '$ratebabybuff', '$ratefullgrownbuff', '$ratemilkbuff', '$marketaccess', '$cattlereating', '$reg_via', '$ip',STR_TO_DATE('$date','%m/%d/%Y%h:%i'),'$timestamp','$tempid')");
        return $result;
    }

    public function insertLiveStockGoat($login_id, $family_id, $hormfarm, $livestocktype, $indigenousnreedgoat, $crossbreedgoat, $incomegoat, $expendituregoat, $benefitsgot, $meatgoat, $milkgoat, $ratebabygoat, $ratefullgrowngoat, $ratemilkgoat, $ratemeatgoat, $marketaccess, $cattlereating, $ip, $date, $timestamp, $tempid) {
        $reg_via = "Web";
        mysql_query("SET NAMES utf8");
        $result = mysql_query("INSERT INTO family_livestock_master (login_id,family_id,flstk_have_livestock,flstk_livestock_id,flstk_have_indigenious_breed,flstk_have_cross_breed,flstk_income_recieved,flstk_monthly_expenditure,flstk_benefits_received,flstk_meat_per_month,flstk_milk_per_day,flstk_sales_per_baby,flstk_sales_per_fullgrown,flstk_sales_per_litre_milk,flstk_sales_per_kg_meat,flstk_is_market_accessible,flstk_cattle_rearing,reg_via,reg_device_id,reg_created_date,reg_timestamp,reg_temp_id) VALUES('$login_id', '$family_id', '$hormfarm', '$livestocktype', '$indigenousnreedgoat', '$crossbreedgoat', '$incomegoat', '$expendituregoat', '$benefitsgot', '$meatgoat', '$milkgoat', '$ratebabygoat', '$ratefullgrowngoat', '$ratemilkgoat', '$ratemeatgoat', '$marketaccess', '$cattlereating', '$reg_via', '$ip',STR_TO_DATE('$date','%m/%d/%Y%h:%i'),'$timestamp','$tempid')");
        return $result;
    }

    public function insertLiveStockSheep($login_id, $family_id, $hormfarm, $livestocktype, $indigenousnreedsheep, $crossbreedsheep, $incomesheep, $expendituresheep, $benefitsgot, $meatsheep, $milksheep, $fursheep, $ratebabysheep, $ratefullgrownsheep, $ratemeatsheep, $ratemilksheep, $ratefursheep, $marketaccess, $cattlereating, $ip, $date, $timestamp, $tempid) {
        $reg_via = "Web";
        mysql_query("SET NAMES utf8");
        $result = mysql_query("INSERT INTO family_livestock_master (login_id,family_id,flstk_have_livestock,flstk_livestock_id,flstk_have_indigenious_breed,flstk_have_cross_breed,flstk_income_recieved,flstk_monthly_expenditure,flstk_benefits_received,flstk_meat_per_month,flstk_milk_per_day,flstk_fur_per_year,flstk_sales_per_baby,flstk_sales_per_fullgrown,flstk_sales_per_kg_meat,flstk_sales_per_litre_milk,flstk_sales_per_kg_fur,flstk_is_market_accessible,flstk_cattle_rearing,reg_via,reg_device_id,reg_created_date,reg_timestamp,reg_temp_id) VALUES('$login_id', '$family_id', '$hormfarm', '$livestocktype', '$indigenousnreedsheep', '$crossbreedsheep', '$incomesheep', '$expendituresheep', '$benefitsgot', '$meatsheep', '$milksheep', '$fursheep', '$ratebabysheep', '$ratefullgrownsheep', '$ratemeatsheep', '$ratemilksheep', '$ratefursheep', '$marketaccess', '$cattlereating', '$reg_via', '$ip',STR_TO_DATE('$date','%m/%d/%Y%h:%i'),'$timestamp','$tempid')");
        return $result;
    }

    public function insertLiveStockPoultry($login_id, $family_id, $hormfarm, $livestocktype, $indigenousnreedpoultry, $crossbreedpoultry, $incomepoultry, $expenditurepoultry, $benefitsgot, $meatpoultry, $eggspoultry, $ratebabypoultry, $ratefullgrownpoultry, $ratemeatpoultry, $rateeggpoultry, $marketaccess, $cattlereating, $ip, $date, $timestamp, $tempid) {
        $reg_via = "Web";
        mysql_query("SET NAMES utf8");
        $result = mysql_query("INSERT INTO family_livestock_master (login_id,family_id,flstk_have_livestock,flstk_livestock_id,flstk_have_indigenious_breed,flstk_have_cross_breed,flstk_income_recieved,flstk_monthly_expenditure,flstk_benefits_received,flstk_meat_per_month,flstk_eggs_per_day,flstk_sales_per_baby,flstk_sales_per_fullgrown,flstk_sales_per_kg_meat,flstk_sales_dozen_egg,flstk_is_market_accessible,flstk_cattle_rearing,reg_via,reg_device_id,reg_created_date,reg_timestamp,reg_temp_id) VALUES('$login_id', '$family_id', '$hormfarm', '$livestocktype', '$indigenousnreedpoultry', '$crossbreedpoultry', '$incomepoultry', '$expenditurepoultry', '$benefitsgot', '$meatpoultry', '$eggspoultry', '$ratebabypoultry', '$ratefullgrownpoultry', '$ratemeatpoultry', '$rateeggpoultry', '$marketaccess', '$cattlereating', '$reg_via', '$ip',STR_TO_DATE('$date','%m/%d/%Y%h:%i'),'$timestamp','$tempid')");
        return $result;
    }

    public function insertLiveStockAnimal($login_id, $family_id, $hormfarm, $livestocktype, $indigenousnreedanimal, $crossbreedanimal, $incomeanimal, $expenditureanimal, $benefitsgot, $meatanimal, $milkanimal, $ratebabyanimal, $ratefullgrownanimal, $ratemeatanimal, $ratemilkanimal, $marketaccess, $cattlereating, $ip, $date, $timestamp, $tempid) {
        $reg_via = "Web";
        mysql_query("SET NAMES utf8");
        $result = mysql_query("INSERT INTO family_livestock_master (login_id,family_id,flstk_have_livestock,flstk_livestock_id,flstk_have_indigenious_breed,flstk_have_cross_breed,flstk_income_recieved,flstk_monthly_expenditure,flstk_benefits_received,flstk_meat_per_month,flstk_milk_per_day,flstk_sales_per_baby,flstk_sales_per_fullgrown,flstk_sales_per_kg_meat,flstk_sales_per_litre_milk,flstk_is_market_accessible,flstk_cattle_rearing,reg_via,reg_device_id,reg_created_date,reg_timestamp,reg_temp_id) VALUES('$login_id', '$family_id', '$hormfarm', '$livestocktype', '$indigenousnreedanimal', '$crossbreedanimal', '$incomeanimal', '$expenditureanimal', '$benefitsgot', '$meatanimal', '$milkanimal', '$ratebabyanimal', '$ratefullgrownanimal', '$ratemeatanimal', '$ratemilkanimal', '$marketaccess', '$cattlereating', '$reg_via', '$ip',STR_TO_DATE('$date','%m/%d/%Y%h:%i'),'$timestamp','$tempid')");
        return $result;
    }

    public function insertLiveStockBird($login_id, $family_id, $hormfarm, $livestocktype, $indigenousnreedbird, $crossbreedbird, $incomebird, $expenditurebird, $benefitsgot, $meatbird, $eggsbird, $ratebabybird, $ratefullgrownbird, $ratemeatbird, $rateeggbird, $marketaccess, $cattlereating, $ip, $date, $timestamp, $tempid) {
        $reg_via = "Web";
        mysql_query("SET NAMES utf8");
        $result = mysql_query("INSERT INTO family_livestock_master (login_id,family_id,flstk_have_livestock,flstk_livestock_id,flstk_have_indigenious_breed,flstk_have_cross_breed,flstk_income_recieved,flstk_monthly_expenditure,flstk_benefits_received,flstk_meat_per_month,flstk_eggs_per_day,flstk_sales_per_baby,flstk_sales_per_fullgrown,flstk_sales_per_kg_meat,flstk_sales_dozen_egg,flstk_is_market_accessible,flstk_cattle_rearing,reg_via,reg_device_id,reg_created_date,reg_timestamp,reg_temp_id) VALUES('$login_id', '$family_id', '$hormfarm', '$livestocktype', '$indigenousnreedbird', '$crossbreedbird', '$incomebird', '$expenditurebird', '$benefitsgot', '$meatbird', '$eggsbird', '$ratebabybird', '$ratefullgrownbird', '$ratemeatbird', '$rateeggbird', '$marketaccess', '$cattlereating', '$reg_via', '$ip',STR_TO_DATE('$date','%m/%d/%Y%h:%i'),'$timestamp','$tempid')");
        return $result;
    }

    public function insertLiveStockNo($login_id, $family_id, $hormfarm, $ip, $date, $timestamp, $tempid) {
        $reg_via = "Web";
        mysql_query("SET NAMES utf8");
        $result = mysql_query("INSERT INTO family_livestock_master (login_id,family_id,flstk_have_livestock,reg_via,reg_device_id,reg_created_date,reg_timestamp,reg_temp_id) VALUES('$login_id','$family_id','$hormfarm','$reg_via','$ip',STR_TO_DATE('$date','%m/%d/%Y%h:%i'),'$timestamp','$tempid')");
        return $result;
    }

    public function insertAgricultureOwnLandNo($login_id, $family_id, $havefarmland, $ip, $date, $timestamp, $tempid) {
        $reg_via = "Web";
        mysql_query("SET NAMES utf8");
        $result = mysql_query("INSERT INTO family_land_master (login_id,family_id,fld_have_farmland,reg_device_id,reg_created_date,reg_timestamp,reg_temp_id) VALUES('$login_id','$family_id', '$havefarmland','$ip','$date','$timestamp','$tempid')");
        return $result;
    }

    public function insertAgriculturedugNo($login_id, $family_id, $havefarmland, $ip, $date, $timestamp, $tempid) {
        $reg_via = "Web";
        mysql_query("SET NAMES utf8");
        $result = mysql_query("INSERT INTO family_irrigation_source (login_id,family_id,source_name,reg_device_id,reg_created_date,reg_timestamp,reg_temp_id) VALUES('$login_id','$family_id', '$havefarmland','$ip','$date','$timestamp','$tempid')");
        return $result;
    }

    public function insertAgricultureboreNo($login_id, $family_id, $havefarmland, $ip, $date, $timestamp, $tempid) {
        $reg_via = "Web";
        mysql_query("SET NAMES utf8");
        $result = mysql_query("INSERT INTO family_irrigation_source (login_id,family_id,source_name,reg_device_id,reg_created_date,reg_timestamp,reg_temp_id) VALUES('$login_id','$family_id', '$havefarmland','$ip','$date','$timestamp','$tempid')");
        return $result;
    }

    public function insertAgriculturepipeNo($login_id, $family_id, $havefarmland, $ip, $date, $timestamp, $tempid) {
        $reg_via = "Web";
        mysql_query("SET NAMES utf8");
        $result = mysql_query("INSERT INTO family_irrigation_source (login_id,family_id,source_name,reg_device_id,reg_created_date,reg_timestamp,reg_temp_id) VALUES('$login_id','$family_id', '$havefarmland','$ip','$date','$timestamp','$tempid')");
        return $result;
    }

//    public function insertAgricultureOwnLand($login_id, $family_id, $havefarmland, $owntype, $ownarea, $ownareaunit, $owncost, $ownirrigatedarea, $ownirrigatedunit, $ownundulatingarea, $ownundulatingunit, $ownwastearea, $ownwasteunit, $ownleveledarea, $ownleveledunit, $ownunderirrigationarea, $ownunderirrigationunit, $ip, $date, $timestamp, $tempid) {
//        $reg_via = "Web";
//        $result = mysql_query("INSERT INTO family_land_master (family_id,fld_have_farmland,fld_type,fld_area,fld_unit,fld_current_cost,fld_irrigated_area,fld_irrigated_unit,fld_undulating_area,fld_undulating_unit,fld_waste_area,fld_waste_unit,fld_leveled_area,fld_leveled_unit,fld_under_irrigation_area,fld_under_irrigation_unit,reg_via,reg_device_id,reg_created_date,reg_timestamp,reg_temp_id) VALUES('$login_id', '$family_id', '$havefarmland', '$owntype', '$ownarea', '$ownareaunit', '$owncost', '$ownirrigatedarea', '$ownirrigatedunit', '$ownundulatingarea', '$ownundulatingunit', '$ownwastearea', '$ownwasteunit', '$ownleveledarea', '$ownleveledunit', '$ownunderirrigationarea', '$ownunderirrigationunit','$reg_via', '$ip',STR_TO_DATE('$date','%m/%d/%Y%h:%i'),'$timestamp','$tempid')");
//        return $result;
//    }
//
//    public function insertAgricultureLeaseLand($login_id, $family_id, $havefarmland, $leasetype, $leasearea, $leaseareaunit, $leasecost1, $leaseirrigatedarea, $leaseirrigatedunit, $leaseundulatingarea, $leaseundulatingunit, $leasewastearea, $leasewasteunit, $leaseleveledarea, $leaseleveledunit, $leaseunderirrigationarea, $leaseunderirrigationunit, $ip, $date, $timestamp, $tempid) {
//        $reg_via = "Web";
//        $result = mysql_query("INSERT INTO family_land_master (login_id,family_id,fld_have_farmland,fld_type,fld_area,fld_unit,fld_current_cost,fld_irrigated_area,fld_irrigated_unit,fld_undulating_area,fld_undulating_unit,fld_waste_area,fld_waste_unit,fld_leveled_area,fld_leveled_unit,fld_under_irrigation_area,fld_under_irrigation_unit,reg_via,reg_device_id,reg_created_date,reg_timestamp,reg_temp_id) VALUES('$login_id', '$family_id', '$havefarmland', '$leasetype', '$leasearea', '$leaseareaunit', '$leasecost1', '$leaseirrigatedarea', '$leaseirrigatedunit', '$leaseundulatingarea', '$leaseundulatingunit', '$leasewastearea', '$leasewasteunit', '$leaseleveledarea', '$leaseleveledunit', '$leaseunderirrigationarea', '$leaseunderirrigationunit','$reg_via', '$ip',STR_TO_DATE('$date','%m/%d/%Y%h:%i'),'$timestamp','$tempid')");
//        return $result;
//    }

    public function insertCropMaster($login_id, $family_id, $crop_id, $consumed_crop, $landarea, $landunit, $totalproductionamount, $totalproductionunit, $soldamount, $soldunit, $expenditure, $marketrate, $marketrateunit, $productionamount, $productionunit, $ispaddy, $newtech, $technology, $techsupport, $techsupportsecond, $techsupportthird, $wellirrigation, $irrigation, $gwsource, $landavailable, $nolandreasone, $ip, $date, $timestamp, $tempid) {
        $reg_via = "Web";
        mysql_query("SET NAMES utf8");
        $sql_fet_sql = mysql_query("SELECT family_id FROM family_master ORDER BY family_id DESC");
        $row_data = mysql_fetch_array($sql_fet_sql);
        $fam_id = $row_data['family_id'];
        $sql_fet_sql1 = mysql_query("SELECT * FROM family_crop_master ,family_farmtech_master WHERE family_crop_master.family_id = family_farmtech_master.family_id AND family_crop_master.family_id = '$fam_id'");
        $sql_fm_rows = mysql_num_rows($sql_fet_sql1);
        //$row_data1 = mysql_fetch_array($sql_fet_sql1);
        if ($sql_fm_rows == 0) {
            $result = mysql_query("INSERT INTO family_crop_master (login_id,family_id, crop_id, cm_consumed_crop, cm_land_area, cm_land_unit,cm_total_production_amount,cm_total_production_unit,cm_total_sold_amount,cm_total_sold_unit,cm_total_expenditure,cm_market_rate,cm_market_rate_unit,cm_production_amt,cm_production_unit,reg_via,reg_device_id,reg_created_date,reg_timestamp,reg_temp_id) VALUES('$login_id','$family_id','$crop_id', '$consumed_crop', '$landarea', '$landunit', '$totalproductionamount', '$totalproductionunit', '$soldamount', '$soldunit', '$expenditure', '$marketrate', '$marketrateunit', '$productionamount', '$productionunit','$reg_via', '$ip',STR_TO_DATE('$date','%m/%d/%Y%h:%i'),'$timestamp','$tempid')");
            $result1 = mysql_query("INSERT INTO family_farmtech_master (login_id,family_id, ft_is_paddy,ft_new_tech,ft_no_nt_reason,ft_first_tech_sup,ft_second_tech_sup,ft_third_tech_sup,ft_grp_well_irrigation,ft_no_gw_reason,ft_gw_source,ft_land_available,ft_no_land_reason,reg_via,reg_device_id,reg_created_date,reg_timestamp,reg_temp_id) VALUES('$login_id','$family_id','$ispaddy', '$newtech', '$technology', '$techsupport', '$techsupportsecond', '$techsupportthird', '$wellirrigation', '$irrigation', '$gwsource', '$landavailable', '$nolandreasone','$reg_via','$ip',STR_TO_DATE('$date','%m/%d/%Y%h:%i'),'$timestamp','$tempid')");
        } else {
            $result = mysql_query("INSERT INTO family_crop_master (login_id,family_id, crop_id, cm_consumed_crop, cm_land_area, cm_land_unit,cm_total_production_amount,cm_total_production_unit,cm_total_sold_amount,cm_total_sold_unit,cm_total_expenditure,cm_market_rate,cm_market_rate_unit,cm_production_amt,cm_production_unit,reg_via,reg_device_id,reg_created_date,reg_timestamp,reg_temp_id) VALUES('$login_id','$family_id','$crop_id', '$consumed_crop', '$landarea', '$landunit', '$totalproductionamount', '$totalproductionunit', '$soldamount', '$soldunit', '$expenditure', '$marketrate', '$marketrateunit', '$productionamount', '$productionunit','$reg_via', '$ip',STR_TO_DATE('$date','%m/%d/%Y%h:%i'),'$timestamp','$tempid')");
        }

        return $result;
    }

    public function insertCropMasterNo($login_id, $family_id, $crop_id, $consumed_crop, $ip, $date, $timestamp, $tempid) {
        $reg_via = "Web";
        mysql_query("SET NAMES utf8");
        $result = mysql_query("INSERT INTO family_crop_master (login_id,family_id, crop_id, cm_consumed_crop, reg_via, reg_device_id,reg_created_date,reg_timestamp,reg_temp_id) VALUES('$login_id','$family_id', '$crop_id', '$consumed_crop', '$reg_via', '$ip',STR_TO_DATE('$date','%m/%d/%Y%h:%i'),'$timestamp','$tempid')");
        return $result;
    }

    public function insertHouseType($login_id, $mat_id, $ht_no_of_rooms, $ht_kitchen_location, $ht_cooking_stove_type, $ht_have_toilet, $ht_have_piped_water_connection, $ht_have_electricity_meter, $ht_space_around_house, $ip, $date, $timestamp, $tempid) {
        $reg_via = "Web";
        mysql_query("SET NAMES utf8");
        $result = mysql_query("INSERT INTO family_housetype_master (login_id,mat_id,ht_no_of_rooms,ht_kitchen_location,ht_cooking_stove_type,ht_have_toilet,ht_have_piped_water_connection,ht_have_electricity_meter,ht_space_around_house,reg_via,reg_device_id,reg_created_date,reg_timestamp,reg_temp_id) VALUES ('$login_id','$mat_id','$ht_no_of_rooms','$ht_kitchen_location','$ht_cooking_stove_type','$ht_have_toilet','$ht_have_piped_water_connection','$ht_have_electricity_meter','$ht_space_around_house','$reg_via','$ip',STR_TO_DATE('$date','%m/%d/%Y%h:%i'),'$timestamp','$tempid')");
        return $result;
    }

    public function insertSelfEmployment($login_id, $family_id, $familymember, $trainingrequired, $grantreceive, $investmentgrant, $investmentcredit, $ip, $date, $timestamp, $tempid) {
        $reg_via = "Web";
        mysql_query("SET NAMES utf8");
        $result = mysql_query("INSERT INTO family_selfemp_master (login_id,family_id,se_family_member,se_training_required,se_grant_received,se_investment_for_grant,se_investment_for_credit,reg_via,reg_device_id,reg_created_date,reg_timestamp,reg_temp_id) VALUES('$login_id','$family_id','$familymember', '$trainingrequired', '$grantreceive', '$investmentgrant', '$investmentcredit','$reg_via','$ip',STR_TO_DATE('$date','%m/%d/%Y%h:%i'),'$timestamp','$tempid')");
        return $result;
    }

    public function SelfEmploymentUpdate($login_id, $family_id, $familymember, $trainingrequired, $grantreceive, $investmentgrant, $investmentcredit, $ip, $date, $timestamp, $tempid) {
        $reg_via = "Web";
        mysql_query("SET NAMES utf8");
        $result = mysql_query("update family_selfemp_master set login_id='$login_id',se_family_member='$familymember',se_training_required='$trainingrequired',se_grant_received='$grantreceive',se_investment_for_grant='$investmentgrant',se_investment_for_credit='$investmentcredit',reg_via='$reg_via',reg_device_id='$ip' where family_id='$get_family_id'");
        return $result;
    }

    public function insertSocioNonFoodExp($family_id, $expense_id, $ip) {
        $reg_via = "Web";
        mysql_query("SET NAMES utf8");
        $result = mysql_query("INSERT INTO family_nonfoodexp_master (family_id,cost_per_year,reg_via,reg_device_id) VALUES('$family_id','$expense_id','$reg_via','$ip')");
        return $result;
    }

    public function UpdateActivity($allocate_id, $app_status) {
        mysql_query("SET NAMES utf8");
        $result = mysql_query("Update activity_allocation_master set approval_status= '$app_status' WHERE allocate_id = '$allocate_id'");
        return $result;
    }

    public function insertActivityEligibility($login_id, $family_id, $activity, $ip, $date, $timestamp, $tempid) {
        $reg_via = "Web";
        mysql_query("SET NAMES utf8");
        $result = mysql_query("INSERT INTO activity_allocation_master(login_id,family_id,activity_id,approval_status,reg_via,reg_device_id,reg_created_date,reg_timestamp,reg_temp_id) VALUES('$login_id','$family_id','$activity','None','$reg_via','$ip',STR_TO_DATE('$date','%m/%d/%Y%h:%i'),'$timestamp','$tempid')");
        return $result;
    }

    public function UpdateActivityAllocationStatus($family_id, $date, $timestamp) {
        mysql_query("SET NAMES utf8");
        $result = mysql_query("Update family_master set allocation_status= '1', reg_modified_date= STR_TO_DATE('$date', '%m/%d/%Y%h:%i'), reg_timestamp= '$timestamp' WHERE family_id = '$family_id'");
        return $result;
    }

    public function UpdateActivityEligibilityStatus($family_id, $date, $timestamp) {
        mysql_query("SET NAMES utf8");
        $result = mysql_query("Update family_master set activity_status= '1', reg_modified_date= STR_TO_DATE('$date', '%m/%d/%Y%h:%i'), reg_timestamp= '$timestamp' WHERE family_id = '$family_id'");
        return $result;
    }

    public function insertActivityReason($login_id, $family_id, $reason, $ip, $date, $timestamp, $tempid) {
        $reg_via = "Web";
        mysql_query("SET NAMES utf8");
        $result = mysql_query("INSERT INTO activity_reason_master (login_id,family_id,reason,reg_via,reg_device_id,reg_created_date,reg_timestamp,reg_temp_id) VALUES('$login_id','$family_id','$reason','$reg_via','$ip',STR_TO_DATE('$date','%m/%d/%Y%h:%i'),'$timestamp','$tempid')");
        return $result;
    }

    public function insertFamilyVerification($login_id, $family_id, $allocate_id, $benificiary_id, $ip, $date, $timestamp, $tempid) {
        $reg_via = "Web";
        mysql_query("SET NAMES utf8");
        $result = mysql_query("INSERT INTO activity_verification_master (login_id,family_id,allocate_id,benificiary_id,bn_status,reg_via,reg_device_id,reg_created_date,reg_timestamp,reg_temp_id) VALUES('$login_id','$family_id','$allocate_id','$benificiary_id','Verified','$reg_via','$ip',STR_TO_DATE('$date','%m/%d/%Y%h:%i'),'$timestamp','$tempid')");
        return $result;
    }

    public function insertActivityTracker($login_id, $family_id, $allocate_id, $benificiary_id, $indicator, $action, $visit, $remark, $ip, $date, $timestamp) {
        $reg_via = "Web";
        mysql_query("SET NAMES utf8");
        $result = mysql_query("INSERT INTO activity_progress_master(login_id,family_id,allocate_id,benificiary_id,indicator_id,action_recorded,visit_date,remarks,reg_via,reg_device_id,reg_created_date,reg_timestamp) VALUES('$login_id','$family_id','$allocate_id','$benificiary_id','$indicator','$action','$visit','$remark','$reg_via','$ip',STR_TO_DATE('$date','%m/%d/%Y%h:%i'),'$timestamp')");
        return $result;
    }

    public function insertVillageLevelPhysical($login_id, $family_id, $sectorname, $block, $village_name, $cluster_name, $activity, $subactivity, $other_sub_activity, $date_of_activity, $no_of_participant, $ip, $date, $timestamp) {
        $reg_via = "Web";
        mysql_query("SET NAMES utf8");
        $result = mysql_query("INSERT INTO village_level_activity (login_id,family_id,sectorname,block,village,cluster,activity,sub_activity,other_sub_activity,date_of_activity,no_of_participant,reg_via,reg_device_id,reg_created_date,reg_timestamp) VALUES('$login_id','$family_id','$sectorname','$block','$village_name','$cluster_name','$activity','$subactivity','$other_sub_activity','$date_of_activity','$no_of_participant','$reg_via','$ip',STR_TO_DATE('$date','%m/%d/%Y%h:%i'),'$timestamp')");
        return $result;
    }

    public function updateVillageLevelFinancial($village_level_id, $dbmgf_grant, $beneficiary_contribution, $mf, $nabard, $government, $others, $ip, $date) {
        mysql_query("SET NAMES utf8");
        $result = mysql_query("Update village_level_activity set dbmgf_grant= '$dbmgf_grant', beneficiary_contribution= '$beneficiary_contribution', mf= '$mf', nabard= '$nabard', government= '$government', others= '$others', reg_device_id= '$ip', reg_modified_date= STR_TO_DATE('$date', '%m/%d/%Y%h:%i') WHERE village_level_id = '$village_level_id'");
        return $result;
    }

    public function insertFamilyLevel($dbmgf_grant, $beneficiary_contribution, $mf, $nabard, $government, $others, $ip, $date, $timestamp) {
        $reg_via = "Web";
        mysql_query("SET NAMES utf8");
        $result = mysql_query("INSERT INTO family_level_activity (dbmgf_grant,beneficiary_contribution,mf,nabard,government,others,reg_via,reg_device_id,reg_created_date,reg_timestamp) VALUES('$dbmgf_grant','$beneficiary_contribution','$mf','$nabard','$government','$others','$reg_via','$ip',STR_TO_DATE('$date','%m/%d/%Y%h:%i'),'$timestamp')");
        return $result;
    }

    public function isActivityExisted($activity_name) {
        mysql_query("SET NAMES utf8");
        $result = mysql_query("SELECT activity_name FROM activity_master where activity_name = '$activity_name'");
        $user_data = mysql_fetch_array($result);
        $no_rows_res = mysql_num_rows($result);
        if ($no_rows_res == 1) {
            return $activity_name;
        } else {
            return FALSE;
        }
    }

    public function insertActivity($sector_id, $activity_name, $ip, $date, $timestamp, $tempid) {
        $reg_via = "Web";
        mysql_query("SET NAMES utf8");
        $result = mysql_query("INSERT INTO activity_master (sector_id,activity_name,reg_via,reg_device_id,reg_created_date,reg_timestamp,reg_temp_id) VALUES('$sector_id','$activity_name','$reg_via','$ip',STR_TO_DATE('$date','%m/%d/%Y%h:%i'),'$timestamp','$tempid')");
        return $result;
    }

    // Data Sync   
    public function PersonalData($login_id, $next_id, $family_habitation, $family_phone, $family_head_name, $family_address, $district_id, $block_id, $cluster_id, $gp_id, $village_id, $member_no, $ip, $date, $timestamp, $tempid) {
        $reg_via = "Android";
        mysql_query("SET NAMES utf8");
        $result = mysql_query("INSERT INTO family_master(login_id,family_unique_id,family_habitation,family_phone,family_head_name,family_address,district_id,block_id,cluster_id,gp_id,village_id,member_no,activity_status,reg_via,reg_device_id,reg_created_date,reg_timestamp,reg_temp_id) VALUES('$login_id','$next_id','$family_habitation','$family_phone','$family_head_name','$family_address','$district_id', '$block_id', '$cluster_id', '$gp_id','$village_id','$member_no','0','$reg_via','$ip',STR_TO_DATE('$date','%m/%d/%Y%h:%i'),'$timestamp','$tempid')");
        return $result;
    }

    public function PersonalDataExists($tempid, $family_head_name) {
        mysql_query("SET NAMES utf8");
        $result = mysql_query("SELECT reg_temp_id FROM family_master where reg_temp_id = '$tempid' AND family_head_name = '$family_head_name'");
        $user_data = mysql_fetch_array($result);
        $no_rows_res = mysql_num_rows($result);
        if ($no_rows_res == 1) {
            return $tempid;
        } else {
            return FALSE;
        }
    }

    public function BenefitsReceived($login_id, $family_id, $recievebenefit, $schemereceive, $rate, $ip, $tempid, $date, $timestamp) {
        $reg_via = "Android";
        mysql_query("SET NAMES utf8");
        $result = mysql_query("INSERT INTO received_benefits_master (login_id,family_id,benefits_is_received,benefits_received,benefits_ratings,reg_via,reg_device_id,reg_temp_id,reg_created_date,reg_timestamp) VALUES('$login_id','$family_id','$recievebenefit','$schemereceive','$rate','$reg_via','$ip','$tempid',STR_TO_DATE('$date','%m/%d/%Y%h:%i'),'$timestamp')");
        return $result;
    }

    public function HouseholdRoster($login_id, $family_id, $fm_member_unique_id, $fm_member_name, $fm_gender, $fm_age, $fm_anganwaadi_attended, $fm_school_attended, $fm_education, $fm_occupation_id, $fm_work_interest, $fm_women_sgh, $fm_emp_name, $fm_per_month_salary, $ip, $date, $timestamp, $tempid, $status) {
        $reg_via = "Android";
        mysql_query("SET NAMES utf8");
        $result = mysql_query("INSERT INTO family_member_master(login_id,family_id,fm_member_unique_id,fm_member_name,fm_gender,fm_age,fm_anganwaadi_attended,fm_school_attended,fm_education,fm_occupation_id,fm_work_interest,fm_women_sgh,fm_emp_name,fm_per_month_salary,reg_via,reg_device_id,reg_created_date,reg_timestamp,reg_temp_id,fm_status) VALUES('$login_id','$family_id','$fm_member_unique_id','$fm_member_name','$fm_gender','$fm_age','$fm_anganwaadi_attended', '$fm_school_attended', '$fm_education', '$fm_occupation_id', '$fm_work_interest','$fm_women_sgh','$fm_emp_name','$fm_per_month_salary','$reg_via','$ip',STR_TO_DATE('$date','%m/%d/%Y%h:%i'),'$timestamp','$tempid','$status')");
        return $result;
    }

    public function Sociohousehold($login_id, $family_id, $caste, $povertyline, $availability, $housevalue, $monthrent, $ip, $date, $timestamp, $tempid) {
        $reg_via = "Android";
        mysql_query("SET NAMES utf8");
        $result = mysql_query("INSERT INTO family_household_master (login_id,family_id,hh_caste_category,hh_family_type,hh_family_house,hh_market_value,hh_market_rent,reg_via,reg_device_id,reg_created_date,reg_timestamp,reg_temp_id) VALUES('$login_id','$family_id','$caste','$povertyline','$availability','$housevalue','$monthrent','$reg_via','$ip',STR_TO_DATE('$date','%m/%d/%Y%h:%i'),'$timestamp','$tempid')");
        return $result;
    }

    public function Sociofoodconsumption($login_id, $family_id, $buyfood, $consumefood, $quantityoffood, $receivedwages, $costfood, $rainfall, $ip, $date, $timestamp, $tempid) {
        $reg_via = "Android";
        mysql_query("SET NAMES utf8");
        $result = mysql_query("INSERT INTO family_foodconsumption_master (login_id,family_id,fd_consumed_per_month,fd_grown_consumption,fd_cost_per_month,fd_wages_consumption,fd_wages_cost,fd_type_of_rainfall,reg_via,reg_device_id,reg_created_date,reg_timestamp,reg_temp_id) VALUES('$login_id','$family_id','$buyfood','$consumefood','$quantityoffood','$receivedwages','$costfood','$rainfall','$reg_via','$ip',STR_TO_DATE('$date','%m/%d/%Y%h:%i'),'$timestamp','$tempid')");
        return $result;
    }

    public function Sociomigration($login_id, $family_id, $migrated, $migrating, $totalmembers, $totaltime, $totaldays, $reducedtrips, $reduceddays, $ip, $date, $timestamp, $tempid) {
        $reg_via = "Android";
        mysql_query("SET NAMES utf8");
        $result = mysql_query("INSERT INTO family_migration_master (login_id,family_id,mg_for_work,mg_reason,mg_no_of_members,mg_no_of_times,mg_total_days_worked,mg_total_trips,mg_total_days,reg_via,reg_device_id,reg_created_date,reg_timestamp,reg_temp_id) VALUES('$login_id','$family_id','$migrated','$migrating','$totalmembers','$totaltime','$totaldays','$reducedtrips','$reduceddays','$reg_via','$ip',STR_TO_DATE('$date','%m/%d/%Y%h:%i'),'$timestamp','$tempid')");
        return $result;
    }

    public function Sociononfood($login_id, $family_id, $expense_id, $cost_per_year, $ip, $tempid, $date, $timestamp) {
        $reg_via = "Android";
        mysql_query("SET NAMES utf8");
        $result = mysql_query("INSERT INTO family_nonfoodexp_master (login_id,family_id,expense_id,cost_per_year,reg_via,reg_device_id,reg_temp_id,reg_created_date,reg_timestamp) VALUES('$login_id','$family_id','$expense_id','$cost_per_year','$reg_via','$ip','$tempid',STR_TO_DATE('$date','%m/%d/%Y%h:%i'),'$timestamp')");
        return $result;
    }

    public function Socioincome($login_id, $family_id, $income, $income_recieved, $earnings_per_year, $ip, $tempid, $date, $timestamp) {
        $reg_via = "Android";
        mysql_query("SET NAMES utf8");
        $result = mysql_query("INSERT INTO family_income_master (login_id,family_id,hhd_income_id,hhd_income_recieved,hhd_earnings_per_year,reg_via,reg_device_id,reg_temp_id,reg_created_date,reg_timestamp) VALUES('$login_id','$family_id','$income','$income_recieved','$earnings_per_year','$reg_via','$ip','$tempid',STR_TO_DATE('$date','%m/%d/%Y%h:%i'),'$timestamp')");
        return $result;
    }

    public function Socioasset($login_id, $family_id, $asset_type_id, $total_asset_no, $ip, $tempid, $date, $timestamp) {
        $reg_via = "Android";
        mysql_query("SET NAMES utf8");
        $result = mysql_query("INSERT INTO family_asset_master (login_id,family_id,asset_type_id,total_asset_no,reg_via,reg_device_id,reg_temp_id,reg_created_date,reg_timestamp) VALUES('$login_id','$family_id','$asset_type_id','$total_asset_no','$reg_via','$ip','$tempid',STR_TO_DATE('$date','%m/%d/%Y%h:%i'),'$timestamp')");
        return $result;
    }

    public function Sociosavings($login_id, $family_id, $saving_source, $household_savings, $saved_rupees, $ip, $tempid, $date, $timestamp) {
        $reg_via = "Android";
        mysql_query("SET NAMES utf8");
        $result = mysql_query("INSERT INTO family_savings_master (login_id,family_id,saving_source,household_savings,saved_rupees,reg_via,reg_device_id,reg_temp_id,reg_created_date,reg_timestamp) VALUES('$login_id','$family_id','$saving_source','$household_savings','$saved_rupees','$reg_via','$ip','$tempid',STR_TO_DATE('$date','%m/%d/%Y%h:%i'),'$timestamp')");
        return $result;
    }

    public function LiveStock($login_id, $family_id, $hormfarm, $livestocktype, $indigenousbreed, $crossbreed, $income_recieved, $monthly_expenditure, $benefits_received, $meat, $eggs, $milk, $fur, $sales_per_baby, $sales_per_fullgrown, $sales_per_kg_meat, $sales_dozen_egg, $sales_per_litre_milk, $sales_per_kg_fur, $market_accessible, $cattle_rearing, $ip, $date, $timestamp, $tempid) {
        $reg_via = "Android";
        mysql_query("SET NAMES utf8");
        $result = mysql_query("INSERT INTO family_livestock_master (login_id,family_id,flstk_livestock_id,flstk_have_livestock,flstk_have_indigenious_breed,flstk_have_cross_breed,flstk_income_recieved,flstk_monthly_expenditure,flstk_benefits_received,flstk_meat_per_month,flstk_eggs_per_day,flstk_milk_per_day,flstk_fur_per_year,flstk_sales_per_baby,flstk_sales_per_fullgrown,flstk_sales_per_kg_meat,flstk_sales_dozen_egg,flstk_sales_per_litre_milk,flstk_sales_per_kg_fur,flstk_is_market_accessible,flstk_cattle_rearing,reg_via,reg_device_id,reg_temp_id,reg_created_date,reg_timestamp) VALUES('$login_id', '$family_id', '$hormfarm', '$livestocktype', '$indigenousbreed', '$crossbreed','$income_recieved','$monthly_expenditure','$benefits_received','$meat','$eggs','$milk','$fur','$sales_per_baby','$sales_per_fullgrown','$sales_per_kg_meat','$sales_dozen_egg','$sales_per_litre_milk','$sales_per_kg_fur','$market_accessible','$cattle_rearing','$reg_via','$ip','$tempid',STR_TO_DATE('$date','%m/%d/%Y%h:%i'),'$timestamp')");
        return $result;
    }

    public function Agriculture($login_id, $family_id, $havefarmland, $farmtype, $farmarea, $farmunit, $farmcost, $irrigatedarea, $irrigatedunit, $undulatingarea, $undulatingunit, $wastearea, $wasteunit, $leveledarea, $leveledunit, $underirrigationarea, $underirrigationunit, $ip, $date, $timestamp, $tempid) {
        $reg_via = "Android";
        mysql_query("SET NAMES utf8");
        $result = mysql_query("INSERT INTO family_land_master (login_id,family_id,fld_have_farmland,fld_type,fld_area,fld_unit,fld_current_cost,fld_irrigated_area,fld_irrigated_unit,fld_undulating_area,fld_undulating_unit,fld_waste_area,fld_waste_unit,fld_leveled_area,fld_leveled_unit,fld_under_irrigation_area,fld_under_irrigation_unit,reg_via,reg_device_id,reg_created_date,reg_timestamp,reg_temp_id) VALUES('$login_id', '$family_id', '$havefarmland', '$farmtype', '$farmarea', '$farmunit', '$farmcost', '$irrigatedarea', '$irrigatedunit', '$undulatingarea', '$undulatingunit', '$wastearea', '$wasteunit', '$leveledarea', '$leveledunit', '$underirrigationarea', '$underirrigationunit','$reg_via', '$ip',STR_TO_DATE('$date','%m/%d/%Y%h:%i'),'$timestamp','$tempid')");
        return $result;
    }

    public function Irrigationsource($login_id, $family_id, $source_name, $source_usability, $issource_own_lease, $havesource_type, $own_source, $iswater_own_kharif, $iswater_own_rabi, $iswater_own_summer, $lease_source, $iswater_lease_kharif, $iswater_lease_rabi, $iswater_lease_summer, $group_source, $iswater_group_kharif, $iswater_group_rabi, $iswater_group_summer, $ip, $tempid, $date, $timestamp) {
        $reg_via = "Android";
        mysql_query("SET NAMES utf8");
        $result = mysql_query("INSERT INTO family_irrigation_source (login_id,family_id,source_name,source_usability,issource_own_lease,havesource_type,own_source,iswater_own_kharif,iswater_own_rabi,iswater_own_summer,lease_source,iswater_lease_kharif,iswater_lease_rabi,iswater_lease_summer,group_source,iswater_group_kharif,iswater_group_rabi,iswater_group_summer,reg_via,reg_device_id,reg_temp_id,reg_created_date,reg_timestamp) VALUES('$login_id', '$family_id','$source_name','$source_usability','$issource_own_lease','$havesource_type','$own_source','$iswater_own_kharif','$iswater_own_rabi','$iswater_own_summer','$lease_source','$iswater_lease_kharif','$iswater_lease_rabi','$iswater_lease_summer','$group_source','$iswater_group_kharif','$iswater_group_rabi','$iswater_group_summer','$reg_via', '$ip','$tempid',STR_TO_DATE('$date','%m/%d/%Y%h:%i'),'$timestamp')");
        return $result;
    }

    public function Irrigationsubsource($login_id, $family_id, $si_water_level, $si_usepumps, $si_no_of_pumps, $ip, $tempid, $date, $timestamp) {
        $reg_via = "Android";
        mysql_query("SET NAMES utf8");
        $result = mysql_query("INSERT INTO family_irrigation_subsource (login_id,family_id,si_water_level,si_usepumps,si_no_of_pumps,reg_via,reg_device_id,reg_temp_id,reg_created_date,reg_timestamp) VALUES('$login_id', '$family_id','$si_water_level','$si_usepumps','$si_no_of_pumps','$reg_via', '$ip','$tempid',STR_TO_DATE('$date','%m/%d/%Y%h:%i'),'$timestamp')");
        return $result;
    }

    public function Cropproductivity($login_id, $family_id, $crop_id, $consumed_crop, $landarea, $landunit, $totalproductionamount, $totalproductionunit, $soldamount, $soldunit, $expenditure, $marketrate, $marketrateunit, $productionamount, $productionunit, $ip, $date, $timestamp, $tempid) {
        $reg_via = "Android";
        $result = mysql_query("INSERT INTO family_crop_master (login_id,family_id, crop_id, cm_consumed_crop, cm_land_area, cm_land_unit,cm_total_production_amount,cm_total_production_unit,cm_total_sold_amount,cm_total_sold_unit,cm_total_expenditure,cm_market_rate,cm_market_rate_unit,cm_production_amt,cm_production_unit,reg_via,reg_device_id,reg_created_date,reg_timestamp,reg_temp_id) VALUES('$login_id','$family_id','$crop_id', '$consumed_crop', '$landarea', '$landunit', '$totalproductionamount', '$totalproductionunit', '$soldamount', '$soldunit', '$expenditure', '$marketrate', '$marketrateunit', '$productionamount', '$productionunit','$reg_via', '$ip',STR_TO_DATE('$date','%m/%d/%Y%h:%i'),'$timestamp','$tempid')");
        return $result;
    }

    public function Farmtechnology($login_id, $family_id, $ispaddy, $newtech, $technology, $techsupport, $techsupportsecond, $techsupportthird, $wellirrigation, $irrigation, $gwsource, $landavailable, $nolandreason, $ip, $date, $timestamp, $tempid) {
        $reg_via = "Android";
        mysql_query("SET NAMES utf8");
        $result = mysql_query("INSERT INTO family_farmtech_master (login_id,family_id, ft_is_paddy,ft_new_tech,ft_no_nt_reason,ft_first_tech_sup,ft_second_tech_sup,ft_third_tech_sup,ft_grp_well_irrigation,ft_no_gw_reason,ft_gw_source,ft_land_available,ft_no_land_reason,reg_via,reg_device_id,reg_created_date,reg_timestamp,reg_temp_id) VALUES('$login_id','$family_id','$ispaddy', '$newtech', '$technology', '$techsupport', '$techsupportsecond', '$techsupportthird', '$wellirrigation', '$irrigation', '$gwsource', '$landavailable', '$nolandreason','$reg_via','$ip',STR_TO_DATE('$date','%m/%d/%Y%h:%i'),'$timestamp','$tempid')");
        return $result;
    }

    public function SelfEmployment($login_id, $family_id, $familymember, $trainingrequired, $grantreceive, $investmentgrant, $investmentcredit, $ip, $date, $timestamp, $tempid) {
        $reg_via = "Android";
        mysql_query("SET NAMES utf8");
        $result = mysql_query("INSERT INTO family_selfemp_master (login_id,family_id,se_family_member,se_training_required,se_grant_received,se_investment_for_grant,se_investment_for_credit,reg_via,reg_device_id,reg_created_date,reg_timestamp,reg_temp_id) VALUES('$login_id','$family_id','$familymember', '$trainingrequired', '$grantreceive', '$investmentgrant', '$investmentcredit','$reg_via','$ip',STR_TO_DATE('$date','%m/%d/%Y%h:%i'),'$timestamp','$tempid')");
        return $result;
    }

    public function Housematerials($login_id, $family_id, $floor, $walls, $roof, $ip, $date, $timestamp, $tempid) {
        $reg_via = "Android";
        mysql_query("SET NAMES utf8");
        $result = mysql_query("INSERT INTO family_housematerials_master (login_id,family_id,mat_for_floor,mat_for_walls,mat_for_roof,reg_via,reg_device_id,reg_created_date,reg_timestamp,reg_temp_id) VALUES ('$login_id','$family_id','$floor','$walls','$roof','$reg_via','$ip',STR_TO_DATE('$date','%m/%d/%Y%h:%i'),'$timestamp','$tempid')");
        return $result;
    }

    public function HouseType($login_id, $mat_id, $ht_no_of_rooms, $ht_kitchen_location, $ht_cooking_stove_type, $ht_have_toilet, $ht_have_piped_water_connection, $ht_have_electricity_meter, $ht_space_around_house, $ip, $date, $timestamp, $tempid) {
        $reg_via = "Android";
        mysql_query("SET NAMES utf8");
        $result = mysql_query("INSERT INTO family_housetype_master (login_id,mat_id,ht_no_of_rooms,ht_kitchen_location,ht_cooking_stove_type,ht_have_toilet,ht_have_piped_water_connection,ht_have_electricity_meter,ht_space_around_house,reg_via,reg_device_id,reg_created_date,reg_timestamp,reg_temp_id) VALUES ('$login_id','$mat_id','$ht_no_of_rooms','$ht_kitchen_location','$ht_cooking_stove_type','$ht_have_toilet','$ht_have_piped_water_connection','$ht_have_electricity_meter','$ht_space_around_house','$reg_via','$ip',STR_TO_DATE('$date','%m/%d/%Y%h:%i'),'$timestamp','$tempid')");
        return $result;
    }

    public function ActivityProgressTracker($login_id, $family_id, $allocate_id, $benificiary_id, $indicator, $action, $visit, $remark, $ip, $date, $timestamp, $tempid) {
        $reg_via = "Android";
        mysql_query("SET NAMES utf8");
        $result = mysql_query("INSERT INTO activity_progress_master(login_id,family_id,allocate_id,benificiary_id,indicator_id,action_recorded,visit_date,remarks,reg_via,reg_device_id,reg_created_date,reg_timestamp,reg_temp_id) VALUES('$login_id','$family_id','$allocate_id','$benificiary_id','$indicator','$action','$visit','$remark','$reg_via','$ip',STR_TO_DATE('$date','%m/%d/%Y%h:%i'),'$timestamp','$tempid')");
        return $result;
    }

    public function ProgressDetailsTracker($login_id, $beneficiary_id, $activity_name, $other_activity, $fertilizer_name, $fertilizer_qty, $fertilizer_total_cost, $seed_qty, $seed_variety_name, $seed_total_cost, $dbmgf_grant, $lhwrf_grant, $mf_grant, $beneficiary_contribution, $farmers_contribution, $nabard, $other_grants, $mf_availed, $land_levelled_area, $total_no, $species_name, $variety, $survival_no, $insurance_amt, $contribution_amt, $enterprise_verification, $equipment_name, $equipment_no, $IGA_name, $SHG_name, $training_name, $training_duration, $agency_venue, $financial_institute, $loan_amt, $rate_of_interest, $ip, $tempid, $date, $timestamp) {
        $reg_via = "Android";
        mysql_query("SET NAMES utf8");
        $result = mysql_query("INSERT INTO activity_progress_details_master(login_id,beneficiary_id,activity_name,other_activity,fertilizer_name,fertilizer_qty,fertilizer_total_cost,seed_qty,seed_variety_name,seed_total_cost,dbmgf_grant,lhwrf_grant,mf_grant,beneficiary_contribution,farmers_contribution,nabard,other_grants,mf_availed,land_levelled_area,total_no,species_name,variety,survival_no,insurance_amt,contribution_amt,enterprise_verification,equipment_name,equipment_no,IGA_name,SHG_name,training_name,training_duration,agency_venue,financial_institute,loan_amt,rate_of_interest,reg_via,reg_device_id,reg_temp_id,reg_created_date,reg_timestamp) VALUES('$login_id','$beneficiary_id','$activity_name','$other_activity','$fertilizer_name','$fertilizer_qty','$fertilizer_total_cost','$seed_qty','$seed_variety_name','$seed_total_cost','$dbmgf_grant','$lhwrf_grant','$mf_grant','$beneficiary_contribution','$farmers_contribution','$nabard','$other_grants','$mf_availed','$land_levelled_area','$total_no','$species_name','$variety','$survival_no','$insurance_amt','$contribution_amt','$enterprise_verification','$equipment_name','$equipment_no','$IGA_name','$SHG_name','$training_name','$training_duration','$agency_venue','$financial_institute','$loan_amt','$rate_of_interest','$reg_via','$ip','$tempid',STR_TO_DATE('$date','%m/%d/%Y%h:%i'),'$timestamp')");
        return $result;
    }

    public function VillageLevel($login_id, $family_id, $sectorname, $block, $village_name, $cluster_name, $activity, $subactivity, $other_sub_activity, $date_of_activity, $no_of_participant, $dbmgf_grant, $beneficiary_contribution, $mf, $nabard, $government, $others, $ip, $tempid, $date, $timestamp) {
        $reg_via = "Android";
        mysql_query("SET NAMES utf8");
        $result = mysql_query("INSERT INTO village_level_activity (login_id,family_id,sectorname,block,village,cluster,activity,sub_activity,other_sub_activity,date_of_activity,no_of_participant,dbmgf_grant,beneficiary_contribution,mf,nabard,government,others,reg_via,reg_device_id,reg_temp_id,reg_created_date,reg_timestamp) VALUES('$login_id','$family_id','$sectorname','$block','$village_name','$cluster_name','$activity','$subactivity','$other_sub_activity','$date_of_activity','$no_of_participant', '$dbmgf_grant', '$beneficiary_contribution', '$mf', '$nabard', '$government', '$others','$reg_via','$ip','$tempid',STR_TO_DATE('$date','%m/%d/%Y%h:%i'),'$timestamp')");
        return $result;
    }

    public function FamilyLevel($dbmgf_grant, $beneficiary_contribution, $mf, $nabard, $government, $others, $ip, $tempid, $date, $timestamp) {
        $reg_via = "Android";
        mysql_query("SET NAMES utf8");
        $result = mysql_query("INSERT INTO family_level_activity (dbmgf_grant,beneficiary_contribution,mf,nabard,government,others,reg_via,reg_device_id,reg_temp_id,reg_created_date,reg_timestamp) VALUES('$dbmgf_grant','$beneficiary_contribution','$mf','$nabard','$government','$others','$reg_via','$ip','$tempid',STR_TO_DATE('$date','%m/%d/%Y%h:%i'),'$timestamp')");
        return $result;
    }

    public function PendingSurvey($head_name, $contact_no, $village_name, $login_id, $ip, $date, $timestamp, $tempid) {
        $reg_via = "Android";
        mysql_query("SET NAMES utf8");
        $result = mysql_query("INSERT INTO pending_survey_master(head_name,contact_no,village_name,login_id,reg_via,reg_device_id,reg_temp_id,reg_created_date,reg_timestamp) VALUES('$head_name','$contact_no','$village_name','$login_id','$reg_via','$ip','$tempid',STR_TO_DATE('$date','%m/%d/%Y%h:%i'),'$timestamp')");
        return $result;
    }

}
