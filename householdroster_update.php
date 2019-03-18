<?php

include_once 'include/DB_Functions.php';
$db = new DB_Functions();
$login_id = $_SESSION['login_id'];

function ipCheck() {
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

    $ip = ipCheck();
// variables for input data
    $fm_getid = $_POST['getid'];
    $fm_fmid = $_POST['fmid'];
    $fm_member_name = $_POST['fm_member_name'];
    $fm_gender = $_POST['fm_gender'];
    $fm_age = $_POST['fm_age'];
    $fm_anganwaadi_attended = $_POST['fm_anganwaadi_attended'];
    $fm_school_attended = $_POST['fm_school_attended'];
    $fm_education = $_POST['fm_education'];
    $fm_occupation_id = $_POST['fm_occupation_id'];
    $fm_work_interest = $_POST['fm_work_interest'];
    $fm_women_sgh = $_POST['fm_women_sgh'];
    $fm_emp_name = $_POST['fm_emp_name'];
    $fm_per_month_salary = $_POST['fm_per_month_salary'];
    $fm_member_unique_id = "";
    $tempid = "";

    date_default_timezone_set('Asia/Kolkata');
    $date_cr = date('m/d/Y');
    $dt = date("Y/m/d", strtotime($date_cr));
    $St_Time = "01:00:00";
    $date = date('m/d/Y h:i:s a', time());
    $timestamp = strtotime($date);

        
        $user = $db->HouseholdRosterUpdate($fm_member_name, $fm_gender, $fm_age, $fm_anganwaadi_attended, $fm_school_attended, $fm_education, $fm_occupation_id, $fm_work_interest, $fm_women_sgh, $fm_emp_name, $fm_per_month_salary, $ip,$fm_getid,$fm_fmid);
        if ($user) {
            ?>
            <script type="text/javascript">
                alert('Data Inserted Successfully ');
//                window.location.href = 'household_roster_new.php';
            </script>
            <?php

        } else {
            ?>
            <script type="text/javascript">
                alert('error occured while inserting your data');
            </script>
            <?php

        }           
}
?>




