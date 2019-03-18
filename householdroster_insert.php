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
    echo $date = date('m/d/Y h:i:s a', time());
    echo $timestamp = strtotime($date);

    $familysql = "SELECT MAX(family_id) as family_id FROM family_master";
    if (!( $familyselect = mysql_query($familysql) )) {
        echo 'Retrieval of data from Database Failed - #' . mysql_errno() . ': ' . mysql_error();
    } else {
        if (mysql_num_rows($familyselect) == 0) {
            echo 'No Rows Returned';
        } else {
            
        }
    }
    while ($familyrow = mysql_fetch_assoc($familyselect)) {
        $family_id = $familyrow['family_id'];
        $sql = mysql_query("SELECT Count(family_member_master.fm_id) as cnt FROM family_member_master WHERE family_member_master.family_id = $family_id");
        $row = mysql_fetch_array($sql);
        $cnt = $row['cnt'];
        if ($cnt == 0) {
            $noofmembers = $_POST['noofmembers'];
            if (($cnt + 1) != $noofmembers) {
                $family_id = $familyrow['family_id'];
                $status = 1;
                $user = $db->insertHouseholdRoster($login_id, $family_id, $fm_member_unique_id, $fm_member_name, $fm_gender, $fm_age, $fm_anganwaadi_attended, $fm_school_attended, $fm_education, $fm_occupation_id, $fm_work_interest, $fm_women_sgh, $fm_emp_name, $fm_per_month_salary, $ip, $date, $timestamp, $tempid, $status);
                $user1 = $db->updateFamilyMaster($family_id, $noofmembers);
                if ($user) {
                    ?>
                    <script type="text/javascript">
                        alert('Data Are Inserted Successfully ');
                        window.location.href = 'household_roster_new.php';
                    </script>
                    <?php

                } else {
                    ?>
                    <script type="text/javascript">
                        alert('error occured while inserting your data');
                    </script>
                    <?php

                }
            } else {
                $family_id = $familyrow['family_id'];
                $status = 1;
                $user = $db->insertHouseholdRoster($login_id, $family_id, $fm_member_unique_id, $fm_member_name, $fm_gender, $fm_age, $fm_anganwaadi_attended, $fm_school_attended, $fm_education, $fm_occupation_id, $fm_work_interest, $fm_women_sgh, $fm_emp_name, $fm_per_month_salary, $ip, $date, $timestamp, $tempid, $status);
                $user1 = $db->updateFamilyMaster($family_id, $noofmembers);
                if ($user) {
                    ?>
                    <script type="text/javascript">
                        alert('Data Are Inserted Successfully ');
                        window.location.href = 'socioeconomics.php';
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
        } else {
            $family_id = $familyrow['family_id'];
            $sqlmem = mysql_query("SELECT family_master.member_no FROM family_master WHERE family_master.family_id = $family_id");
            $rowmem = mysql_fetch_array($sqlmem);
            $memberno = $rowmem['member_no'];
            if (($cnt + 1) == $memberno) {
                $status = 0;
                $user = $db->insertHouseholdRoster($login_id, $family_id, $fm_member_unique_id, $fm_member_name, $fm_gender, $fm_age, $fm_anganwaadi_attended, $fm_school_attended, $fm_education, $fm_occupation_id, $fm_work_interest, $fm_women_sgh, $fm_emp_name, $fm_per_month_salary, $ip, $date, $timestamp, $tempid, $status);
                if ($user) {
                    ?>
                    <script type="text/javascript">
                        alert('Data Are Inserted Successfully ');
                        window.location.href = 'socioeconomics.php';
                    </script>
                    <?php

                } else {
                    ?>
                    <script type="text/javascript">
                        alert('error occured while inserting your data');
                    </script>
                    <?php

                }
            } else {
                $family_id = $familyrow['family_id'];
                $status = 0;
                $user = $db->insertHouseholdRoster($login_id, $family_id, $fm_member_unique_id, $fm_member_name, $fm_gender, $fm_age, $fm_anganwaadi_attended, $fm_school_attended, $fm_education, $fm_occupation_id, $fm_work_interest, $fm_women_sgh, $fm_emp_name, $fm_per_month_salary, $ip, $date, $timestamp, $tempid, $status);
                if ($user) {
                    ?>
                    <script type="text/javascript">
                        alert('Data Are Inserted Successfully ');
                        window.location.href = 'household_roster_new.php';
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
        }
    }
}
?>




