<?php
session_start();
include_once 'include/DB_Functions.php';
$db = new DB_Functions();
$login_id = $_SESSION['login_id'];

function ipcheck() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
//Is it a proxy address
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

if (isset($_POST['btn-save'])) {

    $ip = ipcheck();

    $family_id = $_POST['familyid'];
    $tempid = "";
    date_default_timezone_set('Asia/Kolkata');
    $date_cr = date('m/d/Y');
    $dt = date("Y/m/d", strtotime($date_cr));
    $St_Time = "01:00:00";
    $date = date('m/d/Y h:i:s a', time());
    $timestamp = strtotime($date);
    $activity = "";

    $update = mysql_query("SELECT Count(activity_allocation_master.allocate_id) AS cnt FROM activity_allocation_master WHERE activity_allocation_master.family_id = '$family_id'");
    $update_query = mysql_fetch_assoc($update);
    $allocateid = $update_query['cnt'];
    if ($allocateid > 0) {

        $sql_update = $db->UpdateActivityAllocationStatus($family_id, $date, $timestamp);
    }

    $condition = mysql_query("SELECT family_master.allocation_status FROM family_master WHERE family_master.family_id = '$family_id' AND family_master.allocation_status = 1");
    $condition_query = mysql_fetch_assoc($condition);
    $allocation_status = $condition_query['allocation_status'];
    if ($allocation_status == 1) {
        ?>
        <script type="text/javascript">
            window.location.href = 'family_activities.php?family_id=<?php echo $family_id ?>';
        </script>
        <?php
    } else {

        $sql1 = mysql_query('SELECT block_master.block_name,family_farmtech_master.ft_is_paddy,family_crop_master.cm_consumed_crop,family_farmtech_master.ft_new_tech,family_foodconsumption_master.fd_type_of_rainfall FROM family_master INNER JOIN block_master ON family_master.block_id = block_master.block_id INNER JOIN family_crop_master ON family_master.family_id = family_crop_master.family_id INNER JOIN family_farmtech_master ON family_master.family_id = family_farmtech_master.family_id INNER JOIN family_foodconsumption_master ON family_master.family_id = family_foodconsumption_master.family_id WHERE family_foodconsumption_master.fd_type_of_rainfall = "Heavy" AND (block_master.block_name = "Sakri" OR block_master.block_name = "Shirpur") AND family_farmtech_master.ft_is_paddy = "Yes" AND family_crop_master.cm_consumed_crop = "Yes, in Kharif only" AND family_farmtech_master.ft_new_tech = "Yes" AND family_master.family_id = "' . $family_id . '"');
        $rice = mysql_fetch_array($sql1);
        if ($rice == "") {
            
        } else {
            $activity = "Rice cultivation with SRI";
            $sql_query = $db->insertActivityEligibility($login_id, $family_id, $activity, $ip, $date, $timestamp, $tempid);
        }

        $sql2 = mysql_query('SELECT family_crop_master.crop_id,family_crop_master.cm_consumed_crop,family_land_master.fld_unit,family_land_master.fld_area FROM family_master INNER JOIN family_crop_master ON family_master.family_id = family_crop_master.family_id INNER JOIN family_land_master ON family_master.family_id = family_land_master.family_id WHERE family_crop_master.cm_consumed_crop = "Yes, in Kharif only" AND (family_crop_master.crop_id = "Moong" OR family_crop_master.crop_id = "Soyabean") AND (family_land_master.fld_area > 3 AND family_land_master.fld_unit = "Acres") OR (family_land_master.fld_area > 7.50 AND family_land_master.fld_unit = "Bigha") AND family_master.family_id = "' . $family_id . '"');
        $soyamoong = mysql_fetch_array($sql2);
        if ($soyamoong == "") {
            
        } else {
            $activity = "Soyabean/Moong cultivation";
            $sql_query = $db->insertActivityEligibility($login_id, $family_id, $activity, $ip, $date, $timestamp, $tempid);
        }

        $sql3 = mysql_query('SELECT family_crop_master.crop_id,family_crop_master.cm_consumed_crop,family_irrigation_source.iswater_own_rabi,family_irrigation_source.iswater_lease_rabi,family_irrigation_source.iswater_group_rabi FROM family_master INNER JOIN family_crop_master ON family_master.family_id = family_crop_master.family_id INNER JOIN family_irrigation_source ON family_master.family_id = family_irrigation_source.family_id WHERE family_crop_master.cm_consumed_crop = "Yes, in Rabi only" AND (family_crop_master.crop_id = "Gram" OR family_crop_master.crop_id = "Toor") AND (family_irrigation_source.iswater_own_rabi = "Adequate" OR family_irrigation_source.iswater_lease_rabi = "Adequate" OR family_irrigation_source.iswater_group_rabi = "Adequate") AND family_master.family_id = "' . $family_id . '"');
        $gramtoor = mysql_fetch_array($sql3);
        if ($gramtoor == "") {
            
        } else {
            $activity = "Gram/Toor Cultivation";
            $sql_query = $db->insertActivityEligibility($login_id, $family_id, $activity, $ip, $date, $timestamp, $tempid);
        }

        $sql4 = mysql_query('SELECT family_crop_master.cm_consumed_crop,family_irrigation_source.iswater_own_rabi,family_irrigation_source.iswater_lease_rabi,family_irrigation_source.iswater_group_rabi,family_livestock_master.flstk_is_market_accessible FROM family_master INNER JOIN family_crop_master ON family_master.family_id = family_crop_master.family_id INNER JOIN family_irrigation_source ON family_master.family_id = family_irrigation_source.family_id INNER JOIN family_livestock_master ON family_master.family_id = family_livestock_master.family_id WHERE family_crop_master.cm_consumed_crop = "Yes, entire year" AND (family_irrigation_source.iswater_own_rabi = "Adequate" OR family_irrigation_source.iswater_lease_rabi = "Adequate" OR family_irrigation_source.iswater_group_rabi = "Adequate") AND family_livestock_master.flstk_is_market_accessible != "No" AND family_master.family_id = "' . $family_id . '"');
        $vegetable = mysql_fetch_array($sql4);
        if ($vegetable == "") {
            
        } else {
            $activity = "Vegetable Cultivation";
            $sql_query = $db->insertActivityEligibility($login_id, $family_id, $activity, $ip, $date, $timestamp, $tempid);
        }

        $sql5 = mysql_query('SELECT family_land_master.fld_undulating_area,family_land_master.fld_leveled_area FROM family_land_master WHERE family_land_master.fld_undulating_area != 0 AND family_land_master.fld_leveled_area != 0 AND family_land_master.family_id = "' . $family_id . '"');
        $landlevel = mysql_fetch_array($sql5);
        if ($landlevel == "") {
            
        } else {
            $activity = "Land Levelling";
            $sql_query = $db->insertActivityEligibility($login_id, $family_id, $activity, $ip, $date, $timestamp, $tempid);
        }

        $sql6 = mysql_query('SELECT family_land_master.fld_waste_area,family_land_master.fld_waste_unit,family_irrigation_source.iswater_own_rabi,family_irrigation_source.iswater_lease_rabi,family_irrigation_source.iswater_group_rabi FROM family_land_master INNER JOIN family_irrigation_source ON family_land_master.family_id = family_irrigation_source.family_id WHERE (family_land_master.fld_waste_area > 1 AND family_land_master.fld_leveled_unit = "Acres") OR (family_land_master.fld_waste_area > 2.50 AND family_land_master.fld_leveled_unit = "Bigha") AND (family_irrigation_source.iswater_own_rabi = "Adequate" OR family_irrigation_source.iswater_lease_rabi = "Adequate" OR family_irrigation_source.iswater_group_rabi = "Adequate") AND family_land_master.family_id = "' . $family_id . '"');
        $orchard = mysql_fetch_array($sql6);
        if ($orchard == "") {
            
        } else {
            $activity = "Orchard Development";
            $sql_query = $db->insertActivityEligibility($login_id, $family_id, $activity, $ip, $date, $timestamp, $tempid);
        }

        $sql7 = mysql_query('SELECT family_livestock_master.flstk_have_indigenious_breed,family_livestock_master.flstk_have_cross_breed,family_livestock_master.flstk_cattle_rearing,family_livestock_master.flstk_is_market_accessible,family_land_master.fld_have_farmland FROM family_livestock_master INNER JOIN family_land_master ON family_land_master.family_id = family_livestock_master.family_id WHERE family_land_master.fld_have_farmland = "Yes" AND (family_livestock_master.flstk_have_indigenious_breed > 1 OR family_livestock_master.flstk_have_cross_breed > 1 OR family_livestock_master.flstk_cattle_rearing > 1) AND family_livestock_master.flstk_is_market_accessible != "No" AND family_livestock_master.family_id = "' . $family_id . '"');
        $cattle = mysql_fetch_array($sql7);
        if ($cattle == "") {
            
        } else {
            $activity = "Cattle Induction";
            $sql_query = $db->insertActivityEligibility($login_id, $family_id, $activity, $ip, $date, $timestamp, $tempid);
        }

        $sql8 = mysql_query('SELECT family_land_master.fld_have_farmland,family_land_master.fld_unit,family_land_master.fld_area,family_housetype_master.ht_space_around_house FROM family_land_master INNER JOIN family_housematerials_master ON family_land_master.family_id = family_housematerials_master.family_id INNER JOIN family_housetype_master ON family_housematerials_master.mat_id = family_housetype_master.mat_id WHERE family_land_master.fld_have_farmland = "No" OR (family_land_master.fld_unit = "Acres" AND family_land_master.fld_unit < 1) OR (family_land_master.fld_unit = "Bigha" AND family_land_master.fld_unit < 2.50) AND family_housetype_master.ht_space_around_house = "Yes" AND family_land_master.family_id = "' . $family_id . '"');
        $poultry = mysql_fetch_array($sql8);
        if ($poultry == "") {
            
        } else {
            $activity = "Poultry";
            $sql_query = $db->insertActivityEligibility($login_id, $family_id, $activity, $ip, $date, $timestamp, $tempid);
        }

        $sql9 = mysql_query('SELECT family_land_master.fld_have_farmland,family_land_master.fld_unit,family_land_master.fld_area,family_housetype_master.ht_space_around_house FROM family_land_master INNER JOIN family_housematerials_master ON family_land_master.family_id = family_housematerials_master.family_id INNER JOIN family_housetype_master ON family_housematerials_master.mat_id = family_housetype_master.mat_id WHERE family_land_master.fld_have_farmland = "No" OR (family_land_master.fld_unit = "Acres" AND family_land_master.fld_unit < 1) OR (family_land_master.fld_unit = "Bigha" AND family_land_master.fld_unit < 2.50) AND family_housetype_master.ht_space_around_house = "Yes" AND family_land_master.family_id = "' . $family_id . '"');
        $goatrearing = mysql_fetch_array($sql9);
        if ($goatrearing == "") {
            
        } else {
            $activity = "Goat Rearing";
            $sql_query = $db->insertActivityEligibility($login_id, $family_id, $activity, $ip, $date, $timestamp, $tempid);
        }

        $sql10 = mysql_query('SELECT family_member_master.fm_age,family_member_master.fm_work_interest,family_selfemp_master.se_training_required FROM family_member_master INNER JOIN family_selfemp_master ON family_member_master.family_id = family_selfemp_master.family_id WHERE (family_member_master.fm_age > 18 AND family_member_master.fm_age < 30) AND (family_member_master.fm_work_interest = "Interested to go for job outside the village" AND family_member_master.fm_work_interest = "Interested to start own enterprise") AND family_selfemp_master.se_training_required = "Yes" AND family_member_master.family_id = "' . $family_id . '"');
        $skilltraining = mysql_fetch_array($sql10);
        if ($skilltraining == "") {
            
        } else {
            $activity = "Skill Training";
            $sql_query = $db->insertActivityEligibility($login_id, $family_id, $activity, $ip, $date, $timestamp, $tempid);
        }

        $sql11 = mysql_query('SELECT family_land_master.fld_have_farmland,family_land_master.fld_unit,family_land_master.fld_area,family_member_master.fm_occupation_id,family_selfemp_master.se_training_required,family_selfemp_master.se_grant_received FROM family_land_master INNER JOIN family_member_master ON family_land_master.family_id = family_member_master.family_id INNER JOIN family_selfemp_master ON family_member_master.family_id = family_selfemp_master.family_id WHERE family_land_master.fld_have_farmland = "No" OR (family_land_master.fld_unit = "Acres" AND family_land_master.fld_unit < 1) OR (family_land_master.fld_unit = "Bigha" AND family_land_master.fld_unit < 2.50) AND family_member_master.fm_occupation_id = "Self-employed business / shop" AND family_selfemp_master.se_training_required = "No: We had enough training/ knowledge" AND (family_selfemp_master.se_grant_received != "Don’t know" OR family_selfemp_master.se_grant_received != "No") AND family_land_master.family_id = "' . $family_id . '"');
        $grantsupport = mysql_fetch_array($sql11);
        if ($grantsupport == "") {
            
        } else {
            $activity = "Grant support for self-employment";
            $sql_query = $db->insertActivityEligibility($login_id, $family_id, $activity, $ip, $date, $timestamp, $tempid);
        }

        $sql12 = mysql_query('SELECT family_member_master.fm_occupation_id,family_selfemp_master.se_training_required,family_selfemp_master.se_grant_received FROM family_member_master INNER JOIN family_selfemp_master ON family_member_master.family_id = family_selfemp_master.family_id WHERE family_member_master.fm_occupation_id = "Self-employed business / shop" AND family_selfemp_master.se_training_required = "No: We had enough training/ knowledge" AND (family_selfemp_master.se_grant_received != "Don’t know" OR family_selfemp_master.se_grant_received != "No" OR family_selfemp_master.se_grant_received != "MFG, Bank, money lander") AND family_member_master.family_id = "' . $family_id . '"');
        $creditsupport = mysql_fetch_array($sql12);
        if ($creditsupport == "") {
            
        } else {
            $activity = "Credit support for self-employment";
            $sql_query = $db->insertActivityEligibility($login_id, $family_id, $activity, $ip, $date, $timestamp, $tempid);
        }

        $sql13 = mysql_query('SELECT family_irrigation_source.source_name,family_irrigation_source.havesource_type FROM family_irrigation_source WHERE family_irrigation_source.source_name = "Dug Well" AND family_irrigation_source.havesource_type != "Use in group of farmers" AND family_irrigation_source.family_id = "' . $family_id . '"');
        $groupdugwell = mysql_fetch_array($sql13);
        if ($groupdugwell == "") {
            
        } else {
            $activity = "Group dug well irrigation scheme";
            $sql_query = $db->insertActivityEligibility($login_id, $family_id, $activity, $ip, $date, $timestamp, $tempid);
        }

        $sql14 = mysql_query('SELECT family_irrigation_source.source_name,family_irrigation_source.havesource_type FROM family_irrigation_source WHERE family_irrigation_source.source_name = "Bore Well" AND family_irrigation_source.havesource_type != "Use in group of farmers" AND family_irrigation_source.family_id = "' . $family_id . '"');
        $groupborewell = mysql_fetch_array($sql14);
        if ($groupborewell == "") {
            
        } else {
            $activity = "Group bore well irrigation scheme";
            $sql_query = $db->insertActivityEligibility($login_id, $family_id, $activity, $ip, $date, $timestamp, $tempid);
        }

        $sql15 = mysql_query('SELECT family_irrigation_source.source_name,family_irrigation_source.source_usability FROM family_irrigation_source WHERE family_irrigation_source.source_name = "Pipeline" AND family_irrigation_source.source_usability != "Yes" AND family_irrigation_source.family_id = "' . $family_id . '"');
        $minilift = mysql_fetch_array($sql15);
        if ($minilift == "") {
            
        } else {
            $activity = "Mini Lift irrigation scheme";
            $sql_query = $db->insertActivityEligibility($login_id, $family_id, $activity, $ip, $date, $timestamp, $tempid);
        }

        $sql16 = mysql_query('SELECT family_irrigation_source.source_name,family_irrigation_source.source_usability FROM family_irrigation_source WHERE family_irrigation_source.source_name = "Pipeline" AND family_irrigation_source.source_usability != "Yes" AND family_irrigation_source.family_id = "' . $family_id . '"');
        $pipepump = mysql_fetch_array($sql16);
        if ($pipepump == "") {
            
        } else {
            $activity = "Pipe/Pump support";
            $sql_query = $db->insertActivityEligibility($login_id, $family_id, $activity, $ip, $date, $timestamp, $tempid);
        }

        $sql17 = mysql_query('SELECT family_member_master.fm_women_sgh FROM family_member_master WHERE family_member_master.fm_women_sgh = "Already part of Women SHG" AND family_member_master.family_id = "' . $family_id . '"');
        $womensgh = mysql_fetch_array($sql17);
        if ($womensgh == "") {
            
        } else {
            $activity = "IGA through SHG programme";
            $sql_query = $db->insertActivityEligibility($login_id, $family_id, $activity, $ip, $date, $timestamp, $tempid);
        }
        ?>
        <script type="text/javascript">
            window.location.href = 'family_activities.php?family_id=<?php echo $family_id ?>';
        </script>
        <?php
    }
}

    